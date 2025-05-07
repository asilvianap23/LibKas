<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Kas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->input('user_id');
        $users = User::when($userId, function ($query) use ($userId) {
            return $query->where('id', $userId);
        })
        ->with('anggotas')
        ->orderByRaw('LOWER(instansi)')
        ->get();
    
        $tahunIni = Carbon::now()->year;
    
        if (auth()->user()->role === 'admin') {
            $users = User::when($userId, function ($query) use ($userId) {
                return $query->where('id', $userId);
            })->with('anggotas')->get();
    
            $userOptions = User::all();
    
            $totalAnggota = \App\Models\Anggota::when($userId, function ($query) use ($userId) {
                return $query->where('user_id', $userId);
            })->count();
    
            $instansiAktifIds = Kas::where('is_verified', true)
                ->whereYear('created_at', $tahunIni)
                ->pluck('user_id')
                ->unique();
    
            $jumlahInstansiAktif = User::when($userId, function ($query) use ($userId) {
                return $query->where('id', $userId);
            })->whereIn('id', $instansiAktifIds)->count();
    
            $jumlahInstansiTidakAktif = User::when($userId, function ($query) use ($userId) {
                return $query->where('id', $userId);
            })->whereNotIn('id', $instansiAktifIds)->count();
    
            $instansiTidakAktifIds = $users->pluck('id')->diff($instansiAktifIds)->toArray();
        } else {
            $users = User::where('id', auth()->id())->with('anggotas')->get();
    
            $userOptions = User::orderByRaw("instansi IS NULL, LOWER(instansi)")->get();
            
            $totalAnggota = \App\Models\Anggota::where('user_id', auth()->id())->count();
    
            $isAktif = Kas::where('user_id', auth()->id())
                ->where('is_verified', true)
                ->whereYear('created_at', $tahunIni)
                ->exists();
    
            $jumlahInstansiAktif = $isAktif ? 1 : 0;
            $jumlahInstansiTidakAktif = $isAktif ? 0 : 1;
    
            $instansiTidakAktifIds = $isAktif ? [] : [auth()->id()];
        }
    
        $totalInstansi = $users->count();
        $status = $request->input('status');
        if ($status === 'aktif') {
            $filteredUserIds = $instansiAktifIds;
        } elseif ($status === 'tidak-aktif') {
            $filteredUserIds = $users->pluck('id')->diff($instansiAktifIds);
        } else {
            $filteredUserIds = null;
        }
        
        if ($filteredUserIds !== null) {
            $users = $users->filter(function ($user) use ($filteredUserIds) {
                return in_array($user->id, $filteredUserIds->toArray());
            });
        }
        
        return view('anggota.index', compact(
            'users',
            'status',
            'userOptions',
            'totalAnggota',
            'totalInstansi',
            'jumlahInstansiAktif',
            'jumlahInstansiTidakAktif',
            'instansiTidakAktifIds'
        ));
    }
    
    public function create()
    {
        if (auth()->user()->role === 'admin') {
            $users = User::all();
            return view('anggota.create', compact('users'));
        }
    
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'pendidikan' => 'required|string|max:255',
            'wa' => 'required|string|max:20',
        ]);

        $user_id = auth()->user()->role === 'admin' ? $request->user_id : auth()->id();

        Anggota::create([
            'user_id' => $user_id,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'pendidikan' => $request->pendidikan,
            'wa' => $request->wa,
        ]);

        if (Auth::user()->role == 'admin')  {
            return redirect()->route('anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
        } else {
            return redirect()->route('home')->with('success', 'Anggota berhasil ditambahkan.');
        }
    }

    public function edit($id)
    {
        $anggota = Auth::user()->anggotas()->findOrFail($id);
        return view('anggota.edit', compact('anggota'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'pendidikan' => 'nullable|string|max:255',
            'wa' => 'nullable|string|max:20',
        ]);
    
        $anggota = Auth::user()->anggotas()->findOrFail($id);
        $anggota->update($request->all());
    
        if (Auth::user()->role == 'admin') {
            return redirect()->route('anggota.index')->with('success', 'Anggota berhasil diperbarui.');
        } else {
            return redirect()->route('home')->with('success', 'Anggota berhasil diperbarui.');
        }
    }       

    public function destroy(Anggota $anggota)
    {
        $anggota->delete();

        if (Auth::user()->role == 'admin')  {
            return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus.');
        } else {
            return redirect()->route('home')->with('success', 'Anggota berhasil dihapus.');
        }
    }
    
    public function show($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('anggota.show', compact('anggota'));
    }
}
