@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8 max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Tambah Anggota</h1>

    {{-- Tombol Kembali --}}
    <div class="mb-6">
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('anggota.index') }}" class="inline-flex items-center text-sm text-white bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded shadow">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        @else
            <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-white bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded shadow">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        @endif
    </div>    

    <form action="{{ route('anggota.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6 space-y-5 border border-gray-200">
        @csrf

        {{-- Dropdown User untuk Admin --}}
        @if (auth()->user()->role === 'admin')
            <div>
                <label for="user_id" class="block text-sm font-semibold text-gray-700 mb-1">Instansi / User</label>
                <select name="user_id" id="user_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200 select2" required>
                    <option value="">-- Pilih Instansi --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->instansi ?: 'No Instansi' }}
                        </option>
                    @endforeach
                </select>
            </div>
        @else
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        @endif
    

        <div>
            <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1">Nama</label>
            <input type="text" name="nama" id="nama" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200" required>
        </div>

        <div>
            <label for="jabatan" class="block text-sm font-semibold text-gray-700 mb-1">Jabatan</label>
            <select name="jabatan" id="jabatan" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200" required>
                <option value="">-- Pilih Jabatan --</option>
                <option value="Kepala Perpustakaan">Kepala Perpustakaan</option>
                <option value="Pustakawan">Pustakawan</option>
                <option value="Staf Support Perpustakaan">Staf Support Perpustakaan</option>
            </select>
        </div>        

        <div>
            <label for="pendidikan" class="block text-sm font-semibold text-gray-700 mb-1">Pendidikan</label>
            <select name="pendidikan" id="pendidikan" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200" required>
                <option value="">-- Pilih Pendidikan --</option>
                <option value="SMA/SMK/SLTA sederajat">SMA/SMK/SLTA sederajat</option>
                <option value="S1 Ilmu Perpustakaan">S1 Ilmu Perpustakaan</option>
                <option value="S1 Bidang Lain">S1 Bidang Lain</option>
                <option value="S2 Ilmu Perpustakaan">S2 Ilmu Perpustakaan</option>
                <option value="S2 Bidang Lain">S2 Bidang Lain</option>
            </select>
        </div>        

        <div>
            <label for="wa" class="block text-sm font-semibold text-gray-700 mb-1">No. WhatsApp</label>
            <input type="text" name="wa" id="wa" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200" required>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded shadow">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
<script>
    $(document).ready(function() {
        // Menginisialisasi Select2 pada dropdown user_id
        $('#user_id').select2({
            placeholder: "Pilih Instansi",
            allowClear: true,
            width: '100%' // Menyesuaikan dengan lebar form
        });
    });
</script>

