@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Edit Anggota</h1>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('anggota.update', $anggota->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="nama" class="block">Nama</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $anggota->nama) }}" class="w-full p-2 border border-gray-300 rounded" required>
        </div>
    
        <div class="mb-4">
            <label for="jabatan" class="block">Jabatan</label>
            <select name="jabatan" id="jabatan" class="w-full p-2 border border-gray-300 rounded" required>
                <option value="">-- Pilih Jabatan --</option>
                <option value="Kepala Perpustakaan" {{ old('jabatan', $anggota->jabatan) == 'Kepala Perpustakaan' ? 'selected' : '' }}>Kepala Perpustakaan</option>
                <option value="Pustakawan" {{ old('jabatan', $anggota->jabatan) == 'Pustakawan' ? 'selected' : '' }}>Pustakawan</option>
                <option value="Staf Support Perpustakaan" {{ old('jabatan', $anggota->jabatan) == 'Staf Support Perpustakaan' ? 'selected' : '' }}>Staf Support Perpustakaan</option>
            </select>
        </div>
        
        <div class="mb-4">
            <label for="pendidikan" class="block">Pendidikan</label>
            <select name="pendidikan" id="pendidikan" class="w-full p-2 border border-gray-300 rounded">
                <option value="">-- Pilih Pendidikan --</option>
                <option value="SMA/SMK/SLTA sederajat" {{ old('pendidikan', $anggota->pendidikan) == 'SMA/SMK/SLTA sederajat' ? 'selected' : '' }}>SMA/SMK/SLTA sederajat</option>
                <option value="S1 Ilmu Perpustakaan" {{ old('pendidikan', $anggota->pendidikan) == 'S1 Ilmu Perpustakaan' ? 'selected' : '' }}>S1 Ilmu Perpustakaan</option>
                <option value="S1 Bidang Lain" {{ old('pendidikan', $anggota->pendidikan) == 'S1 Bidang Lain' ? 'selected' : '' }}>S1 Bidang Lain</option>
                <option value="S2 Ilmu Perpustakaan" {{ old('pendidikan', $anggota->pendidikan) == 'S2 Ilmu Perpustakaan' ? 'selected' : '' }}>S2 Ilmu Perpustakaan</option>
                <option value="S2 Bidang Lain" {{ old('pendidikan', $anggota->pendidikan) == 'S2 Bidang Lain' ? 'selected' : '' }}>S2 Bidang Lain</option>
            </select>
        </div>
        
        <div class="mb-4">
            <label for="wa" class="block">WhatsApp</label>
            <input type="text" name="wa" id="wa" value="{{ old('wa', $anggota->wa) }}" class="w-full p-2 border border-gray-300 rounded">
        </div>
    
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
    </form>
    
</div>
@endsection
