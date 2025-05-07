@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-blue-600 mb-2 border-b-4">Tambah Iuran Kas</h1>
        <p class="text-lg text-gray-700 mt-2"><span class="text-lg text-gray-500 ml-2">(Halaman ini digunakan untuk menambahkan data kas masuk)</span></p>
    </div>

    <!-- Menampilkan Pesan Sukses -->
    @if (session('success'))
        <div class="bg-blue-200 text-blue-800 p-4 rounded-lg shadow-md mb-6 transition-transform duration-300 ease-in-out transform hover:scale-105">
            <div class="flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Menampilkan Pesan Error -->
    @if ($errors->any())
        <div class="bg-red-200 text-red-800 p-4 rounded-lg shadow-md mb-6 transition-transform duration-300 ease-in-out transform hover:scale-105">
            <ul class="list-disc ml-6 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Tambah Kas -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <form action="{{ route('kas.masuk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Jumlah Mahasiswa -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <select 
                        id="amount" 
                        name="amount" 
                        required 
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500"
                    >
                        <option value="">-- Pilih Jumlah Mahasiswa --</option>
                        <option value="150000">0 - 2500 mahasiswa → Rp 150.000</option>
                        <option value="250000">2501 - 5000 mahasiswa → Rp 250.000</option>
                        <option value="500000">5001 - 9999 mahasiswa → Rp 500.000</option>
                        <option value="1000000">> 10.000 mahasiswa → Rp 1.000.000</option>
                    </select>
                </div>

                <!-- PIC -->
                <div>
                    <label for="pic" class="block text-sm font-medium text-gray-700">PIC</label>
                    <input type="text" id="pic" name="pic" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500">
                </div>

                <!-- WhatsApp -->
                <div>
                    <label for="wa" class="block text-sm font-medium text-gray-700">WhatsApp</label>
                    <input type="text" id="wa" name="wa" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500">
                </div>
                <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                <input type="hidden" name="instansi" value="{{ Auth::user()->instansi }}">

            </div>

            <!-- Deskripsi -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="description" name="description" rows="4" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500"></textarea>
            </div>

            <!-- Foto -->
            <div class="mt-6">
                <label for="photo" class="block text-sm font-medium text-gray-700">Bukti Transfer (Image max 2mb)</label>
                <input type="file" id="photo" name="photo" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500">
            </div>

            <!-- Button -->
            <div class="mt-6 flex justify-center">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md shadow hover:bg-blue-600 focus:ring focus:ring-blue-300">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
