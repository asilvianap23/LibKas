<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Mail\SendPDFMail;
use App\Mail\KasMasukMail;
use Illuminate\Http\Request;
use App\Mail\KasMasukNotification;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class KasController extends Controller
{
   
    public function index()
    {
        $kasMasuk = Kas::where('type', 'masuk')
        ->where('user_id', auth()->id()) 
        ->paginate(10); 
        $kasKeluar = Kas::where('type', 'keluar')->paginate(10);
        $kas = Kas::paginate(10);
    
        return view('kas.index', compact('kasMasuk', 'kasKeluar', 'kas'));
    }
    
    public function storeKasMasuk(Request $request)
    { 
        $validatedData = $request->validate([
            'amount' => 'required|in:150000,250000,500000,1000000',
            'description' => 'nullable|string|max:255',
            'photo' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'pic' => 'nullable|string|max:255',
            'wa' => 'nullable|string|max:15',
        ]);
    
        DB::beginTransaction();
        try {
            $kas = new Kas();
            $kas->amount = $validatedData['amount'];
            $kas->description = $validatedData['description'] ?? null;
            $kas->pic = $validatedData['pic'] ?? null;
            $kas->wa = $validatedData['wa'] ?? null;

            $kas->instansi = auth()->user()->instansi;
            $kas->email = auth()->user()->email;          
    
            $kas->user_id = auth()->id();
            $kas->is_verified = false;

            if ($request->hasFile('photo')) {
                $photoStoredPath = $request->file('photo')->store('bukti_transfer', 'public');
                $kas->photo = $photoStoredPath;
            }
    
            $kas->save();
 
            if (!empty($kas->email)) {
                $photoPath = isset($photoStoredPath) ? storage_path('app/public/' . $photoStoredPath) : null;
                Mail::to($kas->email)->send(new KasMasukMail($kas, $photoPath));
            }
    
            DB::commit();
            return redirect()->route('kas.index')->with('success', 'Kas masuk berhasil disimpan dan menunggu verifikasi.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Ada kesalahan ketika menyimpan data!');
        }
    }

    public function showKasKeluar()
    {
        $kasKeluar = Kas::where('type', 'keluar')->get();

        return view('kas.keluar.index', compact('kasKeluar'));
    }

    public function storeKasKeluar(Request $request)
    {
        $totalKasMasuk = Kas::where('type', 'masuk')
            ->where('is_verified', 1)
            ->sum('amount');
    
        $totalKasKeluar = Kas::where('type', 'keluar')->sum('amount');
    
        if ($totalKasMasuk - $totalKasKeluar < $request->amount) {
            return back()->withErrors(['amount' => 'Jumlah pengeluaran melebihi saldo kas yang tersedia.']);
        }
    
        $kas = Kas::create([
            'amount' => $request->amount,
            'description' => $request->description,
            'type' => 'keluar',
            'user_id' => Auth::id(),
            'is_verified' => 1, 
        ]);
    
        if ($request->hasFile('files')) {
            $filePaths = [];
            foreach ($request->file('files') as $file) {
                $filePath = $file->store('kas_files', 'public');
                $filePaths[] = $filePath; 
            }
    
            $kas->update([
                'bukti' => json_encode($filePaths),
            ]);
        }
    
        return redirect()->route('kas.keluar.index')->with('success', 'Kas keluar berhasil disimpan.');
    }
    
    public function showKasMasuk(Request $request)
    {
     
        $limit = $request->input('limit', 10);  
        $search = $request->input('search');    
        $status = $request->input('status');    
        $type = $request->input('type', 'masuk');  
     
        $query = Kas::query();
     
        if ($status === 'verified') {
            $query->where('is_verified', 1); 
        } elseif ($status === 'pending') {
            $query->where('is_verified', 0)->whereNull('rejected_at');
        } elseif ($status === 'rejected') {
            $query->whereNotNull('rejected_at'); 
        }
     
        $query->where('type', $type);
     
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('description', 'like', '%' . $search . '%')
                      ->orWhere('amount', 'like', '%' . $search . '%')
                      ->orWhere('pic', 'like', '%' . $search . '%')
                      ->orWhere('instansi', 'like', '%' . $search . '%');
            });
        }
     
        $kas = $query->latest()->paginate($limit);
     
        return view('kas.masuk.index', compact('kas'));
    }
             
    public function verifyKasMasuk($id)
    {
        $kas = Kas::findOrFail($id); 
    
        $kas->is_verified = true;
        $kas->save();
    
        $pdfSertifikatPath = storage_path("app/public/sertifikat_{$kas->id}.pdf");
        $pdfKwitansiPath = storage_path("app/public/kwitansi_{$kas->id}.pdf");
    
        $pdfSertifikat = Pdf::loadView('emails.sertifikat', compact('kas'));
        $pdfSertifikat->save($pdfSertifikatPath);
    
        $pdfKwitansi = Pdf::loadView('emails.kwitansi', compact('kas'));
        $pdfKwitansi->save($pdfKwitansiPath);
    
        if (!empty($kas->email)) {
            Mail::to($kas->email)->send(new SendPDFMail($kas, $pdfSertifikatPath, $pdfKwitansiPath)); // Pastikan $kas dikirim ke email
        }
    
        return redirect()->route('kas.masuk.index')->with('success', 'Kas masuk berhasil diverifikasi dan email terkirim.');
    }
    
    public function rejectKasMasuk(Request $request, $id)
    {
        $kas = Kas::findOrFail($id);
    
        $kas->is_verified = false;
        $kas->rejected_at = now();  
    
        if ($request->has('rejected_reason')) {
            $kas->rejected_reason = $request->input('rejected_reason');
        }  
    
        $kas->save();
    
        return redirect()->route('kas.masuk.index')->with('success', 'Kas berhasil ditolak.');
    }
    
    public function processVerificationKasMasuk(Request $request, $id)
    {
        $kas = Kas::findOrFail($id);

        $request->validate([
            'action' => 'required|in:verify,reject',
        ]);
    
        if ($request->action == 'verify') {
            $kas->is_verified = true;
            $kas->verified_at = now(); 
            $kas->rejected_at = null;  
        } elseif ($request->action == 'reject') {
            $kas->is_verified = false;
            $kas->rejected_at = now(); 
        }

        $kas->save();
    
        return redirect()->route('kas.index')->with('status', $request->action == 'verify' ? 'Kas berhasil diverifikasi.' : 'Kas ditolak.');
    }
    public function laporanKasMasuk(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $search = $request->search;
        $limit = $request->limit ?? 10; 
        
        $kasMasuk = Kas::where('type', 'masuk')
            ->where('is_verified', true) 
            ->when($startDate, function ($query, $startDate) {
                return $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                return $query->whereDate('created_at', '<=', $endDate);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('description', 'like', '%' . $search . '%')
                          ->orWhereHas('user', function ($query) use ($search) {
                              $query->where('name', 'like', '%' . $search . '%');
                          });
                });
            })
            ->paginate($limit); 
        
        return view('laporan.kasMasuk', compact('kasMasuk', 'startDate', 'endDate', 'search', 'limit'));
    }
    
    
    public function laporanKasKeluar(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $search = $request->search;
        $limit = $request->limit ?? 10; 
    
        $kasKeluar = Kas::where('type', 'keluar')
            ->when($startDate, function ($query) use ($startDate) {
                return $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->whereDate('created_at', '<=', $endDate);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where('description', 'like', "%$search%");
            })

            ->orderBy('created_at', 'desc') 
            ->paginate($limit);
    
        return view('laporan.kasKeluar', compact('kasKeluar', 'startDate', 'endDate', 'search', 'limit'));
    }  
    public function dataKas(Request $request)
    {
        $kas = Kas::where('user_id', auth()->id()) 
                ->paginate(10); 

        return view('kas.data', compact('kas'));
    }
    public function downloadSertifikat($id)
    {
        $kas = Kas::findOrFail($id);
    
        $pdfSertifikatPath = storage_path("app/public/sertifikat_{$kas->id}.pdf");
    
        if (!file_exists($pdfSertifikatPath)) {
            return redirect()->back()->with('error', 'Sertifikat tidak ditemukan!');
        }
    
        return response()->download($pdfSertifikatPath);
    }
    
    public function downloadKwitansi($id)
    {
        $kas = Kas::findOrFail($id);
    
        $pdfKwitansiPath = storage_path("app/public/kwitansi_{$kas->id}.pdf");
    
        if (!file_exists($pdfKwitansiPath)) {
            return redirect()->back()->with('error', 'Kwitansi tidak ditemukan!');
        }
        return response()->download($pdfKwitansiPath);
    }
    
}