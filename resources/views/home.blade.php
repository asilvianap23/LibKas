@extends('layouts.app')

@section('content')
@php
    $tahunIni = now()->year;
    $isAktif = \App\Models\Kas::where('user_id', auth()->id())
        ->where('is_verified', true)
        ->whereYear('created_at', $tahunIni)
        ->exists();
@endphp

<div class="container mx-auto p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 border-b-4">Selamat Datang, {{ auth()->user()->name }} 👋</h1>
    </div>
    
    <!-- Informasi Instansi -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
        <h2 class="text-xl font-semibold text-pink-700 mb-4">✨ Informasi Instansi Anda</h2>
    
        <div class="grid sm:grid-cols-2 gap-x-6 gap-y-5 text-gray-700 text-sm sm:text-base">
            <!-- Instansi -->
            <div class="flex items-start space-x-2">
                <span class="w-36 font-semibold text-gray-500">🏢 Instansi</span>
                <span class="text-gray-800">: {{ auth()->user()->instansi ?: 'Instansi tidak tersedia' }}</span>
            </div>
    
            <!-- Jumlah Anggota -->
            <div class="flex items-start space-x-2">
                <span class="w-36 font-semibold text-gray-500">👥 Jumlah SDM Perpustakaan</span>
                <span class="text-gray-800">: {{ auth()->user()->anggotas->count() }}</span>
            </div>
    
            <!-- Status -->
            <div class="flex sm:col-span-2 items-start space-x-2">
                <span class="w-36 font-semibold text-gray-500">📅 Status</span>
                <div>
                    @if ($isAktif)
                        <span class="inline-flex items-center gap-2 bg-green-50 text-green-700 text-sm font-medium px-3 py-1 rounded-full border border-green-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Aktif {{ $tahunIni }}
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 bg-red-50 text-red-700 text-sm font-medium px-3 py-1 rounded-full border border-red-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Tidak Aktif. Silahkan melakukan pembayaran untuk kas {{ $tahunIni }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>    

    <!-- Daftar Anggota -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-blue-600">Daftar SDM Perpustakaan</h2>
            <a href="{{ route('anggota.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded transition">+ Tambah SDM</a>
        </div>

        @if(auth()->user()->anggotas->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full table-auto border border-gray-200 rounded">
                    <thead>
                        <tr class="bg-gray-100 text-left text-sm text-gray-600 uppercase">
                            <th class="px-4 py-3 border">No</th>
                            <th class="px-4 py-3 border">Nama</th>
                            <th class="px-4 py-3 border">Jabatan</th>
                            <th class="px-4 py-3 border">Pendidikan</th>
                            <th class="px-4 py-3 border">WhatsApp</th>
                            <th class="px-4 py-3 border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @foreach(auth()->user()->anggotas as $anggota)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border">{{ $anggota->nama }}</td>
                            <td class="px-4 py-2 border">{{ $anggota->jabatan }}</td>
                            <td class="px-4 py-2 border">{{ $anggota->pendidikan }}</td>
                            <td class="px-4 py-2 border">{{ $anggota->wa }}</td>
                            <td class="px-4 py-2 border text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('anggota.show', $anggota->id) }}"
                                       class="bg-green-500 hover:bg-green-600 text-white text-xs px-3 py-1 rounded shadow transition">
                                       View
                                    </a>
                                    <a href="{{ route('anggota.edit', $anggota->id) }}"
                                       class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs px-3 py-1 rounded shadow transition">
                                       Edit
                                    </a>
                                    <form action="{{ route('anggota.destroy', $anggota->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded shadow transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 mt-4">Belum ada anggota yang terdaftar pada instansi Anda.</p>
        @endif
    </div>
</div>
@endsection
