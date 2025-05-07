@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">{{ $event->nama_event }}</h2>
    <p class="mb-6 text-gray-700">{{ $event->deskripsi }}</p>

    <h3 class="text-xl font-semibold mb-2">Verifikasi Pembayaran</h3>
    <p>Total yang sudah membayar: <strong>Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</strong></p>
</div>
@endsection
