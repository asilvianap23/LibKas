<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Payment;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('event.index', compact('events'));
    }

    public function create()
    {
        return view('event.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'tanggal_event' => 'required|string',
            'jenis_paket' => 'required|array', 
            'jenis_paket.*' => 'required|string|max:255', 
            'nominal' => 'required|array', 
            'nominal.*' => 'required|numeric|min:0', 
            'kuitansi_template' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120', 
            'deskripsi' => 'nullable|string',
        ]);
    
        $tanggalEvent = $request->tanggal_event;
    
        $data = $request->only(['nama_event', 'deskripsi']);
        $data['tanggal_event'] = $tanggalEvent;
    
        if ($request->hasFile('kuitansi_template')) {
            $data['kuitansi_template'] = $request->file('kuitansi_template')->store('kuitansi_template', 'public');
        }
    
        $event = Event::create($data);
    
        $jenis_paket = $request->jenis_paket;
        $nominal = $request->nominal;
    
        foreach ($jenis_paket as $index => $paket) {
            $event->pakets()->create([
                'nama_paket' => $paket,
                'nominal' => $nominal[$index],
            ]);
        }
    
        return redirect()->route('event.index')->with('success', 'Event berhasil ditambahkan.');
    }
    
    public function show($id)
    {
        $event = Event::findOrFail($id);
    
        $verifiedCount = $event->payments->where('verif', true)->count();
    
        $totalVerifiedAmount = $event->payments->where('verif', true)->sum('amount');
    
        return view('event.show', compact('event', 'verifiedCount', 'totalVerifiedAmount'));
    }
    
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        
        $event->tanggal_event = explode(',', $event->tanggal_event);
    
        $event->pakets = $event->pakets()->get();
    
        return view('event.edit', compact('event'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'tanggal_event' => 'required|string',
            'kuitansi_template' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'deskripsi' => 'nullable|string',
            'jenis_paket' => 'required|array',
            'jenis_paket.*' => 'required|string|max:255',
            'nominal' => 'required|array',
            'nominal.*' => 'required|numeric|min:0',
        ]);
        
        $event = Event::findOrFail($id);
    
        $event->nama_event = $request->nama_event;
        $event->deskripsi = $request->deskripsi;
    
        $event->tanggal_event = $request->tanggal_event;
        
        if ($request->hasFile('kuitansi_template')) {
            $path = $request->file('kuitansi_template')->store('event_kuitansi', 'public');
            $event->kuitansi_template = $path;
        }
    
        $event->save();
    
        $event->pakets()->delete();
    
        $jenis_paket = $request->jenis_paket;
        $nominal = $request->nominal;
    
        foreach ($jenis_paket as $index => $paket) {
            $event->pakets()->create([
                'nama_paket' => $paket,
                'nominal' => $nominal[$index],
            ]);
        }
    
        return redirect()->route('event.edit', $event->id)->with('success', 'Event berhasil diperbarui!');
    }
    
    public function destroy($id)
    {
        Event::destroy($id);
        return redirect()->route('event.index')->with('success', 'Event berhasil dihapus.');
    }

    public function verifyPayment($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $payment->status = 'terverifikasi';
        $payment->save();

        return redirect()->back()->with('success', 'Pembayaran terverifikasi.');
    }

    public function userEvents()
    {
        $events = Event::all();
        return view('event.userPayment', compact('events'));
    }

    public function userIndex()
    {
        $events = Event::all();
        return view('event.userIndex', compact('events'));
    }
    
    public function userShow($id)
    {
        $event = Event::findOrFail($id);
        $hasPaid = $event->payments()->where('user_id', auth()->id())->exists();
    
        return view('event.userShow', compact('event', 'hasPaid'));
    }

    public function public()
    {
        $events = Event::latest()->get();
        return view('event.public', compact('events'));
    }
}
