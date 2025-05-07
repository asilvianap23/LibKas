@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-center text-2xl font-bold text-indigo-600 mb-6">Data Kas Anda</h2>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    {{-- Table Kas --}}
    <div class="overflow-x-auto rounded-lg shadow border border-gray-200">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-indigo-100 text-gray-800 text-center uppercase">
                <tr>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Jumlah (Rp)</th>
                    <th class="px-6 py-3">Deskripsi</th>
                    <th class="px-6 py-3">Bukti Transfer</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Download</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kas as $data)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-6 py-4 text-center">{{ $data->created_at->format('d-m-Y') }}</td>
                        <td class="px-6 py-4 text-right">{{ number_format($data->amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ $data->description }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($data->photo)
                                <a href="{{ asset('storage/' . $data->photo) }}" target="_blank" class="text-indigo-600 hover:underline text-sm font-medium">Lihat Bukti</a>
                            @else
                                <span class="italic text-gray-400">Tidak tersedia</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($data->is_verified)
                                <span class="inline-block px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded">Terverifikasi</span>
                            @elseif($data->rejected_at)
                                <span class="inline-block px-2 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded">Ditolak</span>
                            @else
                                <span class="inline-block px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded">Menunggu</span>
                            @endif
                        </td>                                               
                        <td class="px-6 py-4 text-center">
                            @if($data->is_verified)
                                <div class="flex flex-wrap gap-2 justify-center">
                                    <a href="{{ route('kas.downloadSertifikat', $data->id) }}" class="bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1 rounded shadow">Sertifikat</a>
                                    <a href="{{ route('kas.downloadKwitansi', $data->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded shadow">Kwitansi</a>
                                </div>
                            @elseif($data->rejected_at)
                                <div class="text-sm text-red-600 italic">
                                    Ditolak
                                    @if($data->rejected_reason)
                                        : {{ $data->rejected_reason }}
                                    @endif
                                </div>
                            @else
                                <span class="text-sm text-gray-400">Tidak tersedia</span>
                            @endif
                        </td>                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-400 italic">Belum ada data kas tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6 flex justify-center">
        {{ $kas->links('pagination::tailwind') }}
    </div>
</div>
@endsection
