@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-2">
    {{-- Heading --}}
    <div class="mb-6 bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <h1 class="text-2xl font-bold text-blue-700 flex items-center gap-2">
            <span class="text-3xl">📋</span> Rincian Acara: {{ $event->nama_event }}
        </h1>

        <div class="mt-6 text-sm sm:text-base">
            <p class="text-gray-600">{{ $event->deskripsi }}</p>
        </div>
    </div>

    {{-- Informasi Pembayaran Terverifikasi --}}
    <div class="mb-6 bg-green-50 p-6 rounded-lg shadow-md border-l-4 border-green-500">
        <h2 class="text-xl font-semibold text-green-700">Informasi Pembayaran Terverifikasi</h2>
        <div class="flex items-center space-x-4 mt-4">
            <i class="fas fa-check-circle text-green-600 text-4xl"></i>
            <div>
                <p class="font-semibold text-lg">Jumlah Pembayaran Terverifikasi:</p>
                <p class="text-2xl text-green-600">{{ $verifiedCount }} orang</p>
                <p class="font-semibold text-lg mt-4">Total Uang yang Diterima:</p>
                <p class="text-2xl text-green-600">Rp {{ number_format($totalVerifiedAmount) }}</p>
            </div>
        </div>
    </div>

    {{-- Filter Daftar Pembayaran --}}
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Daftar Pembayaran</h3>

        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full table-auto border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-4 text-left text-sm font-semibold text-gray-700">No.</th>
                        <th class="p-4 text-left text-sm font-semibold text-gray-700">Nama</th>  
                        <th class="p-4 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="p-4 text-left text-sm font-semibold text-gray-700">Instansi</th>
                        <th class="p-4 text-left text-sm font-semibold text-gray-700">Jumlah</th>
                        <th class="p-4 text-left text-sm font-semibold text-gray-700">Bukti</th>
                        <th class="p-4 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="p-4 text-left text-sm font-semibold text-gray-700">Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($event->payments as $index => $payment)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-4">{{ $index + 1 }}</td>
                        <td class="p-4">{{ $payment->nama }}</td>
                        <td class="p-4">{{ $payment->email }}</td>
                        <td class="p-4">{{ $payment->instansi ?? '-' }}</td>
                        <td class="p-4">Rp {{ number_format($payment->amount) }}</td>
                        <td class="p-4">
                            @if($payment->bukti)
                                <a href="{{ asset('storage/' . $payment->bukti) }}" target="_blank" class="text-blue-600 underline">
                                    lihat bukti
                                </a>
                            @else
                                <span class="text-gray-400 italic">Tidak ada</span>
                            @endif
                        </td>                                                                       
                        <td class="p-4">
                            @if($payment->verif)
                                <span class="text-green-600 font-semibold">Terverifikasi</span>
                            @elseif($payment->reject)
                                <span class="text-red-600 font-semibold">Ditolak</span>
                            @else
                                <span class="text-yellow-600 font-semibold">Belum Diverifikasi</span>
                            @endif
                        </td>
                        <td class="p-4 flex space-x-2">
                            @if (!$payment->verif && !$payment->reject)
                                <!-- Tombol Setuju -->
                                <form action="{{ route('payment.verify') }}" method="POST" onsubmit="return confirm('Yakin ingin menyetujui pembayaran ini?')">
                                    @csrf
                                    <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg flex items-center space-x-2">
                                        <i class="fas fa-thumbs-up"></i>
                                        <span>Setuju</span>
                                    </button>
                                </form>

                                <!-- Tombol Tolak -->
                                <form action="{{ route('payment.verify') }}" method="POST" onsubmit="return confirm('Yakin ingin menolak pembayaran ini?')">
                                    @csrf
                                    <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                    <input type="hidden" name="action" value="reject">
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg flex items-center space-x-2">
                                        <i class="fas fa-thumbs-down"></i>
                                        <span>Tolak</span>
                                    </button>
                                </form>
                            @else
                                @if ($payment->verif && !$payment->reject)
                                    <a href="{{ route('kuitansi.download', $payment->id) }}" 
                                        class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1 rounded-full text-xs font-semibold transition duration-200 inline-flex items-center space-x-1 shadow-sm hover:scale-105" 
                                        target="_blank">
                                        <i class="fas fa-download"></i>
                                        <span>Kuitansi</span>
                                    </a>
                                @else
                                    <span class="bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold inline-flex items-center space-x-1 shadow-sm">
                                        <i class="fas fa-download"></i>
                                        <span>Tidak tersedia</span>
                                    </span>
                                @endif
                                                                                
                            @endif
                        </td>                
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
