@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Pembayaran untuk: {{ $event->nama_event }}</h2>

    {{-- Tampilkan pesan error validasi --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 border border-red-300 p-3 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tampilkan session error jika ada --}}
    @if (session('error'))
        <div class="mb-4 bg-red-100 text-red-700 border border-red-300 p-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('payment.store', ['id' => $event->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
    
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nama</label>
            <input type="text" name="nama" class="w-full border p-2 rounded" required>
        </div>
    
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nomor WhatsApp</label>
            <input type="text" name="wa" class="w-full border p-2 rounded" required>
        </div>
    
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Paket yang Dipilih</label>
            <select name="paket_id" class="w-full border p-2 rounded" required>
                <option value="">Pilih Paket</option>
                @foreach ($event->pakets as $paket)
                    <option value="{{ $paket->id }}" data-nominal="{{ $paket->nominal }}">
                        {{ $paket->nama_paket }} - Rp {{ number_format($paket->nominal, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Jumlah Pembayaran</label>
            <input type="number" name="amount" id="amount" class="w-full border p-2 rounded" required>
        </div>
    
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Upload Bukti Pembayaran</label>
            <input type="file" name="bukti" class="w-full border p-2 rounded" accept="image/*" required>
        </div>
    
        <div class="mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Kirim Pembayaran
            </button>
        </div>
    </form>    
</div>
<script>
    // Ubah nominal otomatis saat pilih paket
    document.querySelector('select[name="paket_id"]').addEventListener('change', function() {
        var nominal = this.selectedOptions[0].getAttribute('data-nominal');
        document.getElementById('amount').value = nominal;
    });
</script>
@endsection
