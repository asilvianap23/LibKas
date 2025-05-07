@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Daftar User</h1>

    {{-- Tabel daftar user --}}
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-300 text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-gray-700 uppercase">
                <tr>
                    <th class="border px-4 py-3">No</th>
                    <th class="border px-4 py-3">Nama</th>
                    <th class="border px-4 py-3">Email</th>
                    <th class="border px-4 py-3">Instansi</th>
                    <th class="border px-4 py-3">Peran</th>
                    <th class="border px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">{{ $user->name }}</td>
                        <td class="border px-4 py-2">{{ $user->email }}</td>
                        <td class="border px-4 py-2">{{ $user->instansi }}</td>
                        <td class="border px-4 py-2">{{ ucfirst($user->role) }}</td>
                        <td class="border px-4 py-2 space-x-2">
                            <a href="{{ route('user.edit', $user->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form id="form-delete-{{ $user->id }}" action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-red-600 hover:underline" onclick="if(confirm('Apakah Anda yakin ingin menghapus data ini?')) { document.getElementById('form-delete-{{ $user->id }}').submit(); }">
                                    Hapus
                                </button>
                            </form>                                                     
                        </td>                               
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Cek semua form dengan class .delete-form
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            if (!confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                e.preventDefault(); // Cegah pengiriman form
            }
        });
    });
</script>
@endsection
