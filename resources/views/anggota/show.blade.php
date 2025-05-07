@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 border-b-4">Detail SDM Perpustakaan</h1>
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline text-sm">&larr; Kembali ke Dashboard</a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <div class="grid sm:grid-cols-2 gap-6 text-gray-700 text-sm sm:text-base">
            <div class="flex items-start space-x-2">
                <span class="w-36 font-semibold text-gray-500">👤 Nama</span>
                <span class="text-gray-800">: {{ $anggota->nama }}</span>
            </div>

            <div class="flex items-start space-x-2">
                <span class="w-36 font-semibold text-gray-500">🏢 Jabatan</span>
                <span class="text-gray-800">: {{ $anggota->jabatan }}</span>
            </div>

            <div class="flex items-start space-x-2">
                <span class="w-36 font-semibold text-gray-500">🎓 Pendidikan</span>
                <span class="text-gray-800">: {{ $anggota->pendidikan }}</span>
            </div>

            <div class="flex items-start space-x-2">
                <span class="w-36 font-semibold text-gray-500">📱 WhatsApp</span>
                <span class="text-gray-800">: {{ $anggota->wa }}</span>
            </div>
        </div>

        <!-- Edit and Delete Buttons -->
        <div class="mt-6 flex space-x-4">
            <a href="{{ route('anggota.edit', $anggota->id) }}" 
            class="bg-yellow-400 hover:bg-yellow-500 text-white px-6 py-3 rounded-lg shadow text-sm transition w-full sm:w-auto">
                ✏️ Edit
            </a>

            <form action="{{ route('anggota.destroy', $anggota->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg shadow text-sm transition w-full sm:w-auto">
                    🗑️ Hapus
                </button>
            </form>
        </div>

        <!-- Add Publication Button -->
        <div class="mt-6">
            <a href="{{ route('publikasi.create', ['anggotaId' => $anggota->id]) }}"
               class="bg-green-500 hover:bg-green-600 text-white text-xs px-6 py-3 rounded-lg shadow transition w-full sm:w-auto">
                + Tambah Publikasi
            </a>
        </div>
        
        <!-- Publications Table -->
        <div class="mt-6">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Daftar Publikasi</h3>
        
            @if ($anggota->publikasis && $anggota->publikasis->count() > 0)
        
                <div class="overflow-x-auto">
                    <table class="w-full table-auto border border-gray-200 rounded">
                        <thead>
                            <tr class="bg-gray-100 text-left text-sm text-gray-600 uppercase">
                                <th class="px-4 py-3 border">No</th>
                                <th class="px-4 py-3 border">Judul Publikasi</th>
                                <th class="px-4 py-3 border">Tahun</th>
                                <th class="px-4 py-3 border">Keterangan</th>
                                <th class="px-4 py-3 border">Link Naskah</th>
                                <th class="px-4 py-3 border text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-800">
                            @foreach($anggota->publikasis as $publikasi)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 border">{{ $publikasi->judul }}</td>
                                    <td class="px-4 py-2 border">{{ $publikasi->tahun }}</td>
                                    <td class="px-4 py-2 border">{{ $publikasi->keterangan ?? 'Tidak ada keterangan' }}</td>
                                    <td class="px-4 py-2 border">
                                        @if ($publikasi->naskah)
                                            <a href="{{ $publikasi->naskah }}" class="text-blue-500 hover:text-blue-600 text-sm" target="_blank">Lihat Naskah</a>
                                        @else
                                            Tidak ada link naskah.
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border text-center">
                                        <a href="{{ route('publikasi.edit', $publikasi->id) }}" 
                                           class="text-blue-500 hover:text-blue-600 text-sm">Edit</a> |
                                        <form action="{{ route('publikasi.destroy', $publikasi->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-600 text-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        
            @else
                <p class="text-gray-500">Belum ada publikasi untuk anggota ini.</p>
            @endif
        </div>
        
    </div>
</div>
@endsection
