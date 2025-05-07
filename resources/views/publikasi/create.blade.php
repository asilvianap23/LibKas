@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">Tambah Publikasi</h1>
    <form action="{{ route('publikasi.store', $anggota->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="judul" class="block text-sm font-semibold text-gray-700">Judul</label>
            <input type="text" id="judul" name="judul" class="w-full p-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="tahun" class="block text-sm font-semibold text-gray-700">Tahun</label>
            <input type="number" id="tahun" name="tahun" class="w-full p-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="keterangan" class="block text-sm font-semibold text-gray-700">Keterangan</label>
            <select name="keterangan" id="keterangan" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200" required>
                <option value="">-- Pilih Terbit di --</option>
                <option value="Q1">Q1</option>
                <option value="Q2">Q2</option>
                <option value="Q3">Q3</option>
                <option value="Sinta1">Sinta 1</option>
                <option value="Sinta2">Sinta 2</option>      
                <option value="Sinta3">Sinta 3</option>
                <option value="Sinta4">Sinta 4</option>
                <option value="Sinta5">Sinta 5</option>              
                <option value="lainnya">Lainnya (prosiding/Bookchapter/dll)</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="naskah" class="block text-sm font-semibold text-gray-700">Link Naskah Publikasi</label>
            <input type="text" id="naskah" name="naskah_pdf" class="w-full p-2 border rounded">
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan Publikasi</button>
    </form>
</div>
@endsection
