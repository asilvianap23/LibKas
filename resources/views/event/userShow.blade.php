@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white/70 backdrop-blur-lg p-10 rounded-3xl shadow-2xl border border-white/40">
    {{-- Bagian Header --}}
    <div class="mb-8 text-center">
        <h2 class="text-4xl font-extrabold text-indigo-700 mb-2">💳 Daftar Pembayaran</h2>
        <p class="text-lg text-gray-600">Untuk: <strong class="text-indigo-600">{{ $event->nama_event }}</strong></p>
        <div class="mt-2 border-b-4 border-indigo-500 w-24 mx-auto rounded-full"></div>
    </div>

    {{-- Tampilkan pesan error validasi --}}
    @if ($errors->any())
        <div class="mb-6 bg-red-100 text-red-700 border border-red-300 p-4 rounded-lg shadow-md">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tampilkan session error jika ada --}}
    @if (session('error'))
        <div class="mb-6 bg-red-100 text-red-700 border border-red-300 p-4 rounded-lg shadow-md">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tombol untuk menambah pembayaran --}}
    <div class="mb-6 flex justify-end">
        <a href="{{ route('payment.create', ['id' => $event->id]) }}" 
           class="bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 text-white px-6 py-3 rounded-full shadow-lg flex items-center space-x-2 transition-all duration-300 transform hover:scale-105">
            <i class="fas fa-plus"></i>
            <span>Tambah Pembayaran</span>
        </a>
    </div>

    {{-- Tabel Pembayaran --}}
    <div class="overflow-x-auto bg-white/50 backdrop-blur-md rounded-2xl shadow-lg border border-white/30">
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-gradient-to-r from-indigo-100 to-blue-100">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 border-b">Nama</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 border-b">Nomor WA</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 border-b">Jumlah Pembayaran</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 border-b">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 border-b">Download</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700">
                @foreach ($event->payments as $payment)
                    <tr class="hover:bg-white/40 hover:backdrop-blur-sm transition duration-300 ease-in-out transform hover:scale-[1.02]">
                        <td class="px-6 py-4 border-b">{{ $payment->nama }}</td>
                        <td class="px-6 py-4 border-b">{{ $payment->wa }}</td>
                        <td class="px-6 py-4 border-b font-semibold text-blue-600">
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 border-b">
                            @if ($payment->verif)
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold flex items-center space-x-1 w-max shadow-sm">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Terverifikasi</span>
                                </span>
                            @elseif ($payment->reject)
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold flex items-center space-x-1 w-max shadow-sm">
                                    <i class="fas fa-times-circle"></i>
                                    <span>Ditolak</span>
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold flex items-center space-x-1 w-max shadow-sm">
                                    <i class="fas fa-clock"></i>
                                    <span>Belum Diverifikasi</span>
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 border-b">
                            @if($payment->reject)
                                <span class="text-red-500 italic text-xs">❌ Ditolak - Tidak Tersedia</span>
                            @elseif($payment->verif)
                                <a href="{{ route('kuitansi.download', $payment->id) }}" 
                                   class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1 rounded-full text-xs font-semibold transition duration-200 inline-flex items-center space-x-1 shadow-sm hover:scale-105" 
                                   target="_blank">
                                    <i class="fas fa-download"></i>
                                    <span>Kuitansi</span>
                                </a>
                            @else
                                <span class="text-gray-400 italic text-xs">⌛ Belum Tersedia</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
