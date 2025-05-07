@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">Detail Publikasi</h1>

    <div class="mb-4">
        <h2 class="text-xl font-semibold mb-2">Judul: {{ $publikasi->judul }}</h2>
        <p class="mb-2"><strong>Tahun:</strong> {{ $publikasi->tahun }}</p>

        <p class="mb-2">
            <strong>Keterangan:</strong>
            @if ($publikasi->keterangan)
                <span class="inline-block px-2 py-1 text-xs font-semibold text-white 
                    @if(strtolower($publikasi->keterangan) == 'q1') bg-green-600 
                    @elseif(strtolower($publikasi->keterangan) == 'q2') bg-blue-600 
                    @elseif(strtolower($publikasi->keterangan) == 'q3') bg-yellow-600 
                    @elseif(strtolower($publikasi->keterangan) == 'sinta1') bg-purple-600 
                    @elseif(strtolower($publikasi->keterangan) == 'sinta2') bg-indigo-600 
                    @elseif(strtolower($publikasi->keterangan) == 'sinta3') bg-pink-600 
                    @elseif(strtolower($publikasi->keterangan) == 'sinta4') bg-red-600 
                    @elseif(strtolower($publikasi->keterangan) == 'sinta5') bg-gray-600 
                    @else bg-gray-400 
                    @endif 
                    rounded">
                    {{ strtoupper($publikasi->keterangan) }}
                </span>
            @else
                <span class="text-gray-500">Tidak ada keterangan</span>
            @endif
        </p>

        <p class="mb-2">
            <strong>Link Naskah:</strong>
            @if ($publikasi->naskah)
                <a href="{{ $publikasi->naskah }}" class="text-blue-600 hover:underline" target="_blank">Lihat Naskah</a>
            @else
                <span class="text-gray-500">Belum ada link naskah.</span>
            @endif
        </p>
    </div>

    <a href="{{ route('publikasi.edit', $publikasi->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded">Edit Publikasi</a>
    <form action="{{ route('publikasi.destroy', $publikasi->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus publikasi ini?')" class="inline-block">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Hapus Publikasi</button>
    </form>
</div>
@endsection
