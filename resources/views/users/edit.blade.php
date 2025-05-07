@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Edit User</h1>

    <form action="{{ route('user.update', $user->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="text-sm">Nama</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="px-4 py-2 border rounded w-full" required>
        </div>

        <div>
            <label for="email" class="text-sm">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="px-4 py-2 border rounded w-full" required>
        </div>

        <div>
            <label for="password" class="text-sm">Password (Kosongkan jika tidak ingin mengubah)</label>
            <input type="password" name="password" id="password" class="px-4 py-2 border rounded w-full">
        </div>

        <!-- Kolom Instansi -->
        <div>
            <label for="instansi" class="text-sm">Instansi</label>
            <input type="text" name="instansi" id="instansi" value="{{ old('instansi', $user->instansi) }}" class="px-4 py-2 border rounded w-full" required>
        </div>

        <!-- Kolom Role (Admin/User) -->
        @if(auth()->user()->role === 'admin')
            <div>
                <label for="role" class="text-sm">Peran</label>
                <select name="role" id="role" class="px-4 py-2 border rounded w-full">
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>
        @endif

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
