<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKasMasuk = Kas::where('type', 'masuk')
            ->where('is_verified', true)
            ->sum('amount');
    
        $totalKasKeluar = Kas::where('type', 'keluar')
            ->sum('amount');
    
        $transaksiHariIni = Kas::whereDate('created_at', today())
            ->where('is_verified', true)
            ->where('type', 'masuk')
            ->sum('amount');
    
        $transaksiBulanIni = Kas::whereMonth('created_at', now()->month)
            ->where('is_verified', true)
            ->where('type', 'masuk')
            ->sum('amount');
    
        $kasMasuk = Kas::where('type', 'masuk')
            ->where('is_verified', true)
            ->latest()
            ->limit(5)
            ->get();

        $kasKeluar = Kas::where('type', 'keluar')
            ->where('is_verified', true)
            ->latest()
            ->limit(5)
            ->get();

        $kasKeluarHariIni = Kas::whereDate('created_at', today())
            ->where('type', 'keluar')
            ->sum('amount');

        $kasKeluarBulanIni = Kas::whereMonth('created_at', now()->month)
            ->where('type', 'keluar')
            ->sum('amount');

        $totalKas = $totalKasMasuk - $totalKasKeluar;

        return view('dashboard', [
            'totalKas' => number_format($totalKas, 2),
            'transaksiHariIni' => number_format($transaksiHariIni, 2),
            'transaksiBulanIni' => number_format($transaksiBulanIni, 2),
            'kasMasuk' => $kasMasuk,
            'kasKeluar' => $kasKeluar,
            'kasKeluarHariIni' => number_format($kasKeluarHariIni, 2),
            'kasKeluarBulanIni' => number_format($kasKeluarBulanIni, 2),
        ]);
    }
}
