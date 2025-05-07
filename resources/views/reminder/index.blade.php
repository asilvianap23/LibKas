@extends('layouts.app')

@section('title', 'Reminder Pembayaran')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Pengingat Pembayaran</h1>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg shadow-md">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form untuk memilih opsi pengingat -->
        <form action="{{ route('reminder.send') }}" method="POST">
            @csrf
            <div class="bg-white p-8 rounded-3xl shadow-xl mb-8 space-y-8 max-w-lg mx-auto">
                <p class="text-lg text-gray-700 font-medium">Pilih opsi pengingat pembayaran:</p>
        
                <!-- Pilihan Pengingat untuk Semua Pengguna -->
                <div class="flex items-center space-x-4 py-4 border-b border-gray-200">
                    <svg class="w-6 h-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C8.67 6.165 7 8.388 7 11v3.159c0 .538-.214 1.055-.595 1.436L5 17h5m0 0v1a3 3 0 006 0v-1m-6 0h6" />
                    </svg>
                    <input type="radio" name="verified_only" value="no" id="all_users" checked class="h-6 w-6 text-indigo-600 border-gray-300 focus:ring-2 focus:ring-indigo-500">
                    <label for="all_users" class="text-gray-800 text-base font-medium">Kirim ke Semua Instansi</label>
                </div>
        
                <!-- Pilihan Pengingat untuk Pengguna yang Belum Diverifikasi -->
                <div class="flex items-center space-x-4 py-4 border-b border-gray-200">
                    <svg class="w-6 h-6 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 5.5C7.858 5.5 4.5 8.858 4.5 13s3.358 7.5 7.5 7.5 7.5-3.358 7.5-7.5S16.142 5.5 12 5.5z" />
                    </svg>
                    <input type="radio" name="verified_only" value="yes" id="unverified_users" class="h-6 w-6 text-indigo-600 border-gray-300 focus:ring-2 focus:ring-indigo-500">
                    <label for="unverified_users" class="text-gray-800 text-base font-medium">Kirim ke Instansi yang Belum Aktif</label>
                </div>
        
                <!-- Tombol Kirim Pengingat -->
                <div class="flex justify-end">
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white font-semibold rounded-2xl shadow-xl hover:from-indigo-600 hover:to-indigo-700 transition-all duration-300">
                        <svg class="w-5 h-5 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18" />
                        </svg>
                        Kirim Pengingat
                    </button>
                </div>
            </div>
        </form>
        
    </div>
@endsection
