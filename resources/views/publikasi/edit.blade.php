@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">Edit Publikasi</h1>
    
    <form action="{{ route('publikasi.update', $publikasi->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="judul" class="block text-sm font-semibold text-gray-700">Judul</label>
            <input type="text" id="judul" name="judul" value="{{ old('judul', $publikasi->judul) }}" class="w-full p-2 border rounded" required>
            @error('judul')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="tahun" class="block text-sm font-semibold text-gray-700">Tahun</label>
            <input type="number" id="tahun" name="tahun" value="{{ old('tahun', $publikasi->tahun) }}" class="w-full p-2 border rounded" required>
            @error('tahun')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="keterangan" class="block text-sm font-semibold text-gray-700">Keterangan</label>
            <select name="keterangan" id="keterangan" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200" required>
                <option value="">-- Pilih Terbit di --</option>
                <option value="q1" {{ old('keterangan', $publikasi->keterangan) == 'Q1' ? 'selected' : '' }}>Q1</option>
                <option value="q2" {{ old('keterangan', $publikasi->keterangan) == 'Q2' ? 'selected' : '' }}>Q2</option>
                <option value="q3" {{ old('keterangan', $publikasi->keterangan) == 'Q3' ? 'selected' : '' }}>Q3</option>
                <option value="Sinta1" {{ old('keterangan', $publikasi->keterangan) == 'Sinta1' ? 'selected' : '' }}>Sinta 1</option>
                <option value="Sinta2" {{ old('keterangan', $publikasi->keterangan) == 'Sinta2' ? 'selected' : '' }}>Sinta 2</option>      
                <option value="Sinta3" {{ old('keterangan', $publikasi->keterangan) == 'Sinta3' ? 'selected' : '' }}>Sinta 3</option>
                <option value="Sinta4" {{ old('keterangan', $publikasi->keterangan) == 'Sinta4' ? 'selected' : '' }}>Sinta 4</option>
                <option value="Sinta5" {{ old('keterangan', $publikasi->keterangan) == 'Sinta5' ? 'selected' : '' }}>Sinta 5</option>              
                <option value="lainnya" {{ old('keterangan', $publikasi->keterangan) == 'lainnya' ? 'selected' : '' }}>Lainnya (prosiding/Bookchapter/dll)</option>
            </select>
            @error('keterangan')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>        

        <div class="mb-4">
            <label for="naskah" class="block text-sm font-semibold text-gray-700">Link Naskah (Opsional)</label>
            <input type="url" id="naskah" name="naskah" value="{{ old('naskah', $publikasi->naskah) }}" class="w-full p-2 border rounded" placeholder="https://contoh.com/naskah.pdf">
            @error('naskah')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror

            @if ($publikasi->naskah)
                <p class="text-sm text-gray-500 mt-2">
                    <a href="{{ $publikasi->naskah }}" class="text-blue-600 hover:underline" target="_blank">Lihat Link Naskah yang sudah ada</a>
                </p>
            @endif
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Perubahan</button>
    </form>
</div>
@endsection
