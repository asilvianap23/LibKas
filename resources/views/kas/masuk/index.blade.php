@extends('layouts.app')

@section('content')
<!-- Header Section -->
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-blue-600 mb-2 border-b-4">Verifikasi Kas Masuk</h1>
        <p class="text-lg text-gray-700 mt-2"><span class="text-lg text-gray-500 ml-2">(Detail dan Verifikasi)</span></p>
    </div>
</div>
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
<!-- Body Section dengan Kotak -->
<div class="container mx-auto px-4 py-6">
    <div class="bg-white border border-gray-300 shadow-lg rounded-lg p-6">
        <!-- Filter dan Pencarian -->
        <div class="flex flex-wrap items-center justify-between mb-4">
            <form method="GET" action="{{ route('kas.masuk.index') }}" class="flex items-center gap-4 w-full">
                <!-- Limit - Ditempatkan di kiri -->
                <div class="flex-shrink-0">
                    <select name="limit" class="border rounded px-4 py-2" onchange="this.form.submit()">
                        <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ request('limit') == 15 ? 'selected' : '' }}>15</option>
                        <option value="30" {{ request('limit') == 30 ? 'selected' : '' }}>30</option>
                        <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
        
                <!-- Elemen di kanan -->
                <div class="ml-auto flex items-center gap-4">
                    <!-- Filter Status -->
                    <select name="status" class="border rounded px-4 py-2" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Sudah Diverifikasi</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
        
                    <!-- Search -->
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Cari deskripsi..." 
                        class="border rounded px-4 py-2" 
                        value="{{ request('search') }}"/>
        
                    <button type="submit" class="button-custom">Filter</button>
                </div>
            </form>        
        </div>
        
        <!-- Tabel Kas Masuk -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="table-custom w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b">Tanggal</th>
                        <th class="px-6 py-3 border-b">Jumlah</th>
                        <th class="px-6 py-3 border-b">Deskripsi</th>
                        <th class="px-6 py-3 border-b">Kas Masuk Dari</th>
                        <th class="px-6 py-3 border-b">Instansi</th>
                        <th class="px-6 py-3 border-b">Bukti Transfer</th>
                        <th class="px-6 py-3 border-b">Status</th>
                        <th class="px-6 py-3 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kas as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 border-b">{{ $item->created_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 border-b">{{ number_format($item->amount, 2) }}</td>
                        <td class="px-6 py-4 border-b">{{ $item->description }}</td>
                        <td class="px-6 py-4 border-b">{{ $item->pic }}</td>
                        <td class="px-6 py-4 border-b">{{ $item->instansi }}</td>
                        <td class="px-6 py-4 border-b">
                            @if($item->photo)
                                <a href="{{ asset('storage/' . $item->photo) }}" class="link-view" target="_blank">Lihat Bukti</a>
                            @else
                                <span class="text-gray-500">tidak ada bukti</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 border-b">
                            @if($item->is_verified)
                                <span class="status-verified">Sudah Diverifikasi</span>
                            @elseif($item->rejected_at)
                                <div class="text-red-600">
                                    <div class="font-semibold">Ditolak</div>
                                    <div class="text-sm text-gray-600">Tanggal: {{ $item->rejected_at->format('Y-m-d') }}</div>
                                    @if($item->rejected_reason)
                                        <div class="text-sm italic text-red-500 mt-1">Alasan: {{ $item->rejected_reason }}</div>
                                    @endif
                                </div>
                            @else
                                <span class="status-pending">Menunggu Verifikasi</span>
                            @endif
                        </td>                                           
                        <td class="px-6 py-4 border-b">
                            <div class="flex-buttons">
                                @if(!$item->is_verified && !$item->rejected_at)
                               <!-- Tombol Verifikasi -->
                               <div class="flex items-center gap-2">
                                    <!-- Tombol Verifikasi -->
                                    <form action="{{ route('kas.masuk.verify', $item->id) }}" method="POST" onsubmit="return confirmAction(event)">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="action" value="verify" class="button-custom bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded flex items-center gap-1" title="Verifikasi data">
                                            <i class="fas fa-check-circle"></i> Verifikasi
                                        </button>
                                    </form>
                                
                                    <!-- Tombol Tolak -->
                                    <button type="button" onclick="showRejectModal()" class="button-custom bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded flex items-center gap-1">
                                        <i class="fas fa-times-circle"></i> Tolak
                                    </button>
                                </div>
                                
                                <!-- Modal Reject -->
                                <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-30 hidden z-50 flex items-center justify-center">
                                    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                                        <h2 class="text-xl font-semibold mb-4 text-red-600">Alasan Penolakan</h2>
                                        
                                        <!-- Form penolakan -->
                                        <form id="rejectForm" action="{{ route('kas.masuk.reject', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="kas_id" id="kas_id" value="{{ $item->id }}">
                                            <textarea name="rejected_reason" id="rejected_reason" rows="4" class="w-full border rounded p-2 mb-4" placeholder="Tuliskan alasan penolakan..." required></textarea>
                                            <div class="flex justify-end gap-2">
                                                <button type="button" onclick="closeRejectModal()" class="bg-gray-300 px-4 py-2 rounded">Batal</button>
                                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Tolak</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                @else
                                    <span class="text-green-500 font-medium">Sudah Diproses</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    
        <!-- Pagination -->
        <div class="mt-4">
            {{ $kas->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<script>
    function confirmAction(event) {
        return confirm('Apakah Anda yakin ingin melanjutkan tindakan ini?');
    }

    // Fungsi untuk menampilkan modal alasan penolakan
    function showRejectModal() {
        document.getElementById('rejectModal').classList.remove('hidden'); // Menampilkan modal
    }

    // Fungsi untuk menutup modal penolakan
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden'); // Menyembunyikan modal
    }
</script>

@endsection
