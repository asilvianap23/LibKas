<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\KuitansiMail;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function create($eventId)
    {
        $event = Event::findOrFail($eventId);

        if (auth()->check()) {
            return view('event.userPayment', compact('event'));
        } else {
            return view('event.PublicPayment', compact('event'));
        }
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'instansi' => 'nullable|string|max:255',
            'wa' => 'required|string|max:20',
            'amount' => 'required|numeric|min:1',
            'bukti' => 'required|image|max:2048',
        ]);
        
        $buktiPath = $request->file('bukti')->store('bukti_pembayaran', 'public');
        
        $payment = Payment::create([
            'event_id' => $id,
            'user_id' => auth()->check() ? auth()->id() : null,
            'nama' => $request->nama,
            'email' => $request->email,
            'instansi' => $request->instansi,
            'wa' => $request->wa,
            'amount' => $request->amount,
            'bukti' => $buktiPath,
            'verif' => false,
            'reject' => false,
        ]);
        
        if (!auth()->check()) {
            return redirect()->route('event.public', ['id' => $id])->with('success', 'Pembayaran berhasil diterima, kuitansi pembayaran akan di kirim melalui email');
        }
        
        return redirect()->route('user.event.show', ['id' => $id])->with('success', 'Pembayaran berhasil dikirim');
    }
    
    public function verify(Request $request)
    {
        $payment = Payment::with('event')->findOrFail($request->payment_id);
    
        if ($request->action === 'approve') {
            $payment->verif = true;
            $payment->reject = false;
            $payment->save();
    
            if ($payment->email) {
                $imagePath = $payment->event->kuitansi_template;
                if (str_contains($imagePath, 'kuitansi_template/')) {
                    $imagePath = str_replace('kuitansi_template/', '', $imagePath);
                }
                $imageFullPath = public_path('storage/kuitansi_template/' . $imagePath);
                $pdf = Pdf::loadView('kuitansi.pdf', [
                    'payment' => $payment,
                    'imageFullPath' => $imageFullPath,
                ]);
    
                Mail::to($payment->email)->send(new KuitansiMail($payment, $pdf->output()));
            }
    
            return back()->with('success', 'Pembayaran disetujui & kuitansi dikirim.');
        } elseif ($request->action === 'reject') {
            $payment->verif = false;
            $payment->reject = true;
            $payment->save();
    
            return back()->with('success', 'Pembayaran ditolak.');
        }
    
        return back()->with('error', 'Aksi tidak valid.');
    }  

    public function downloadKuitansi($id)
    {
        $payment = Payment::with(['event', 'user'])->findOrFail($id);
    
        if (!$payment->verif) {
            abort(403, 'Kuitansi hanya tersedia untuk pembayaran yang sudah diverifikasi.');
        }
    
        $imagePath = basename($payment->event->kuitansi_template);
    
        $imageFullPath = public_path('storage/kuitansi_template/' . $imagePath);
    
        if (!file_exists($imageFullPath)) {
            abort(404, 'Template kuitansi untuk event ini tidak ditemukan. Silakan upload terlebih dahulu.');
        }
    
        $pdf = Pdf::loadView('kuitansi.pdf', compact('payment', 'imageFullPath'));
        $pdfContent = $pdf->output();
    
        if ($payment->email) {
            Mail::to($payment->email)->send(new KuitansiMail($payment, $pdfContent));
        }
    
        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'Kuitansi_' . $payment->nama . '.pdf');
    }
}
