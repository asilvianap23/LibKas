<?php

namespace App\Http\Controllers;

use App\Models\Publikasi;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublikasiController extends Controller
{
    public function create($anggotaId)
    {
        $anggota = Anggota::findOrFail($anggotaId);
        return view('publikasi.create', compact('anggota'));
    }
    public function store(Request $request, $anggotaId)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tahun' => 'required|digits:4',
            'keterangan' => 'nullable|string',
            'naskah' => 'nullable|url', 
        ]);
    
        Publikasi::create([
            'anggota_id' => $anggotaId,
            'judul' => $request->judul,
            'tahun' => $request->tahun,
            'keterangan' => $request->keterangan,
            'naskah' => $request->naskah, 
        ]);
    
        return redirect()->route('anggota.show', $anggotaId)->with('success', 'Publikasi berhasil ditambahkan!');
    }    
    

    public function edit($id)
    {
        $publikasi = Publikasi::findOrFail($id);
        return view('publikasi.edit', compact('publikasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tahun' => 'required|digits:4',
            'keterangan' => 'nullable|string',
            'naskah' => 'nullable|url',
        ]);
    
        $publikasi = Publikasi::findOrFail($id);

        $publikasi->update([
            'judul' => $request->judul,
            'tahun' => $request->tahun,
            'keterangan' => $request->keterangan,
            'naskah' => $request->naskah,
        ]);
    
        return redirect()->route('anggota.show', $publikasi->anggota_id)->with('success', 'Publikasi berhasil diperbarui!');
    }
    
    public function destroy($id)
    {
        $publikasi = Publikasi::findOrFail($id);
        $publikasi->delete();

        return redirect()->route('anggota.show', $publikasi->anggota_id)->with('success', 'Publikasi berhasil dihapus!');
    }
}

