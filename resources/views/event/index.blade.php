@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header Section dengan Garis Bawah -->
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-bold text-blue-700 mb-2">🎉 Daftar Event</h1>
        <p class="text-md text-gray-600">(Daftar Acara dan Event Terbaru)</p>
        <div class="mt-2 border-b-4 border-blue-500 w-24 mx-auto"></div>
    </div>

    <div class="max-w-7xl mx-auto bg-gradient-to-r from-blue-50 to-indigo-50 p-8 rounded-2xl shadow-2xl">
        <!-- Flash Message -->
        @if(session('success'))
            <div class="mt-4 bg-green-100 text-green-700 border border-green-300 p-4 rounded-lg shadow-md">
                {{ session('success') }}
            </div>
        @endif

        {{-- Cek role admin --}}
        @if(auth()->user()->role === 'admin')
        <!-- Tombol Tambah Event -->
        <div class="mb-8 flex justify-end">
            <a href="{{ route('event.create') }}" 
               class="bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white px-6 py-3 rounded-full shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105 flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Event</span>
            </a>
        </div>
        @endif

        <!-- Card for each Event -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($events as $event)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 p-6 border border-gray-100">
                    <div class="flex items-center mb-4">
                        <!-- Icon -->
                        <i class="fas fa-calendar-alt text-indigo-600 text-3xl mr-3"></i>
                        <h3 class="text-xl font-bold text-indigo-700">{{ $event->nama_event }}</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">
                        📅 Tanggal: 
                        {{ collect(explode(',', $event->tanggal_event))->map(fn($tgl) => \Carbon\Carbon::parse($tgl)->format('d-m-Y'))->implode(', ') }}
                    </p>

                    <div class="flex justify-start items-center space-x-4">
                        <!-- Detail Button -->
                        <a href="{{ route('event.show', $event->id) }}" 
                           class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-4 py-2 rounded-full text-sm font-semibold flex items-center space-x-2 transition duration-200">
                            <i class="fas fa-eye"></i>
                            <span>Detail</span>
                        </a>

                        @if(auth()->user()->role === 'admin')
                            <!-- Edit Button -->
                            <a href="{{ route('event.edit', $event->id) }}" 
                               class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-4 py-2 rounded-full text-sm font-semibold flex items-center space-x-2 transition duration-200">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </a>
                            <!-- Delete Button -->
                            <form action="{{ route('event.destroy', $event->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Yakin hapus?')" 
                                        class="bg-red-100 text-red-700 hover:bg-red-200 px-4 py-2 rounded-full text-sm font-semibold flex items-center space-x-2 transition duration-200">
                                    <i class="fas fa-trash"></i>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
