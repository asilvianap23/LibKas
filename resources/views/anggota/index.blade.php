@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-2">
    {{-- Heading --}}
    <div class="mb-6 bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <h1 class="text-2xl font-bold text-blue-700 flex items-center gap-2">
            <span class="text-3xl">📋</span> Daftar Instansi & Anggota
        </h1>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm sm:text-base">
            <!-- Total Instansi -->
            <div class="flex items-center bg-blue-50 border border-blue-200 rounded-lg p-4 shadow-sm">
                <div class="text-blue-600 text-2xl mr-3">
                    <i class="fas fa-building"></i>
                </div>
                <div>
                    <p class="text-gray-600">Total Instansi</p>
                    <p class="text-lg font-semibold text-blue-800">{{ $totalInstansi }}</p>
                </div>
            </div>

            <!-- Instansi Aktif -->
            <div class="flex items-center bg-yellow-50 border border-yellow-200 rounded-lg p-4 shadow-sm">
                <div class="text-yellow-600 text-2xl mr-3">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <p class="text-gray-600">Instansi Aktif ({{ date('Y') }})</p>
                    <p class="text-lg font-semibold text-yellow-800">{{ $jumlahInstansiAktif }}</p>
                </div>
            </div>

            <!-- Instansi Tidak Aktif -->
            <div class="flex items-center bg-red-50 border border-red-200 rounded-lg p-4 shadow-sm">
                <div class="text-red-600 text-2xl mr-3">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div>
                    <p class="text-gray-600">Instansi Tidak Aktif ({{ date('Y') }})</p>
                    <p class="text-lg font-semibold text-red-800">{{ $jumlahInstansiTidakAktif }}</p>
                </div>
            </div>

            <!-- Total Anggota -->
            <div class="flex items-center bg-green-50 border border-green-200 rounded-lg p-4 shadow-sm md:col-span-3">
                <div class="text-green-600 text-2xl mr-3">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <p class="text-gray-600">Total Anggota FPPTMA</p>
                    <p class="text-lg font-semibold text-green-800">{{ $totalAnggota }}</p>
                </div>
            </div>
        </div>
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

<div class="container mx-auto px-4 py-2">
    <div class="bg-white border border-gray-300 shadow-lg rounded-lg p-6">
        {{-- Filter Form --}}
        <form method="GET" class="mb-6 flex flex-wrap items-center gap-4 bg-white p-4 rounded shadow">
            <div class="flex items-center gap-2">
                <label for="user_id" class="text-sm font-medium text-gray-700">Filter Instansi:</label>
                <select name="user_id" id="user_id" class="select2 px-4 py-2 border border-gray-300 rounded w-64">
                    <option value="">-- Semua Instansi --</option>
                    @foreach($userOptions as $option)
                        <option value="{{ $option->id }}" {{ request('user_id') == $option->id ? 'selected' : '' }}>
                            {{ $option->instansi ?: 'Tanpa Instansi' }}
                        </option>
                    @endforeach
                </select>                
            </div>

            <div class="flex items-center gap-2">
                <label for="status" class="text-sm font-medium text-gray-700">Status:</label>
                <select name="status" id="status" class="px-4 py-2 border border-gray-300 rounded w-48">
                    <option value="">-- Semua --</option>
                    <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak-aktif" {{ request('status') === 'tidak-aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded text-sm">
                Terapkan
            </button>
        </form>

        @if(auth()->user()->role === 'admin')
            <div class="mb-6 flex justify-end">
                <a href="{{ route('anggota.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded text-sm inline-block">
                    + Tambah SDM
                </a>
            </div>
        @endif

        @if($users->isEmpty())
            <p class="text-center text-gray-500 mt-10">Tidak ada data instansi yang ditemukan.</p>
        @endif

        <div class="space-y-6">
            @foreach($users->sortBy('instansi') as $user)
                <div class="bg-white border rounded shadow p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold {{ in_array($user->id, $instansiTidakAktifIds) ? 'text-red-600' : 'text-gray-800' }}">
                            {{ $user->instansi ?: 'Tanpa Instansi' }} 

                            @if(in_array($user->id, $instansiTidakAktifIds))
                                <span class="ml-2 text-sm bg-red-100 text-red-700 px-2 py-0.5 rounded-full">Tidak Aktif {{ date('Y') }}</span>
                            @endif

                            <span class="text-sm text-gray-500 ml-1">[{{ $user->anggotas->count() }} Anggota]</span>
                        </h2>

                        @if(auth()->user()->role === 'admin')
                            <button 
                                onclick="document.getElementById('anggota-{{ $user->id }}').classList.toggle('hidden')" 
                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm px-2 py-1 rounded transition flex items-center gap-1">
                                <i class="fas fa-eye"></i> <span class="hidden sm:inline">Lihat SDM Perpustakaan</span>
                            </button>
                        @endif
                    </div>

                    <div id="anggota-{{ $user->id }}" class="hidden transition-all duration-300 ease-in-out">
                        @if($user->anggotas->count())
                            <div class="overflow-x-auto">
                                <table class="w-full border text-sm">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="border px-4 py-2 text-left">No</th>
                                            <th class="border px-4 py-2 text-left">Nama</th>
                                            <th class="border px-4 py-2 text-left">Jabatan</th>
                                            <th class="border px-4 py-2 text-left">Pendidikan</th>
                                            <th class="border px-4 py-2 text-left">WhatsApp</th>
                                            <th class="border px-4 py-2 text-left">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->anggotas as $index => $anggota)
                                            <tr class="hover:bg-gray-50">
                                                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                                <td class="border px-4 py-2">
                                                    {{ $anggota->nama }}
                                                    @if(isset($anggota->aktif) && !$anggota->aktif)
                                                        <span class="ml-2 text-xs text-red-500">(Nonaktif)</span>
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">{{ $anggota->jabatan }}</td>
                                                <td class="border px-4 py-2">{{ $anggota->pendidikan }}</td>
                                                <td class="border px-4 py-2">{{ $anggota->wa }}</td>
                                                <td class="border px-4 py-2 space-x-2">
                                                    <a href="{{ route('anggota.edit', $anggota->id) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                                                    <form action="{{ route('anggota.destroy', $anggota->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus anggota ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500">Belum ada SDM.</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#user_id').select2({
            placeholder: "Pilih Instansi",
            allowClear: true,
            width: 'resolve' // menyesuaikan otomatis
        });
    });
</script>
@endsection