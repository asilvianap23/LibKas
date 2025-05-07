@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Tambah User</h1>

    <form action="{{ route('user.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="name" class="text-sm">Nama</label>
            <input type="text" name="name" id="name" class="px-4 py-2 border rounded w-full" required>
        </div>

        <div>
            <label for="email" class="text-sm">Email</label>
            <input type="email" name="email" id="email" class="px-4 py-2 border rounded w-full" required>
        </div>

        <div>
            <label for="password" class="text-sm">Password</label>
            <input type="password" name="password" id="password" class="px-4 py-2 border rounded w-full" required>
        </div>

        <!-- Kolom Instansi -->
        <div>
            <label for="instansi" class="text-sm">Instansi</label>
            <input type="text" name="instansi" id="instansi" class="px-4 py-2 border rounded w-full" required>
        </div>

        <!-- Kolom Role (Admin/User) -->
        @if(auth()->user()->role === 'admin')
            <div>
                <label for="role" class="text-sm">Peran</label>
                <select name="role" id="role" class="px-4 py-2 border rounded w-full">
                    <option value="admin">Admin</option>
                    <option value="user" selected>User</option>
                </select>
            </div>
        @endif

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
