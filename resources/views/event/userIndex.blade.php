@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-12">

    <!-- Header -->
    <div class="mb-12 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-indigo-700 mb-3">✨ Event Terkini</h1>
        <p class="text-gray-500 text-lg">Temukan acara menarik yang tersedia untuk Anda</p>
        <div class="mt-3 w-28 h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded mx-auto"></div>
    </div>

    <!-- Pesan Sukses -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-300 text-green-700 px-5 py-4 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Daftar Event -->
    @if($events->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($events as $event)
                <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transform hover:scale-105 transition duration-300 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-indigo-100 text-indigo-600 p-3 rounded-full shadow-sm">
                                <i class="fas fa-calendar-day text-xl"></i>
                            </div>
                            <h3 class="ml-4 text-xl font-semibold text-indigo-800 leading-tight">
                                <a href="{{ route('user.event.show', $event->id) }}" class="hover:underline">
                                    {{ $event->nama_event }}
                                </a>
                            </h3>
                        </div>
                        <p class="text-sm text-gray-500 mb-2">
                            📅 
                            {{ collect(explode(',', $event->tanggal_event))->map(fn($tgl) => \Carbon\Carbon::parse($tgl)->format('d-m-Y'))->implode(', ') }}
                        </p>
                        <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                            {{ Str::limit($event->deskripsi, 120, '...') }}
                        </p>
                        <div class="flex justify-end">
                            <a href="{{ route('user.event.show', $event->id) }}" 
                               class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white px-4 py-2 rounded-full text-sm font-medium hover:from-indigo-600 hover:to-purple-600 transition duration-200 shadow-md flex items-center space-x-2">
                                <i class="fas fa-arrow-right"></i>
                                <span>Detail</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-16">
            <p class="text-gray-500 text-lg">😔 Belum ada event tersedia saat ini.</p>
        </div>
    @endif

</div>
@endsection
