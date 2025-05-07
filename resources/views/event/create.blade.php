@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-8">
        <h1 class="text-4xl font-semibold text-blue-600 mb-4 border-b-4 pb-2">Tambah Event</h1>
        <p class="text-lg text-gray-700"><span class="text-lg text-gray-500">(Isi data event baru)</span></p>
    </div>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label class="block mb-2 text-lg font-semibold text-gray-700">Nama Event</label>
                <input type="text" name="nama_event" class="w-full border border-gray-300 p-4 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('nama_event')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label class="block mb-2 text-lg font-semibold text-gray-700">Tanggal Event (Bisa Pilih Beberapa)</label>
                <input type="text" name="tanggal_event" id="tanggal_event" 
                    class="w-full border border-gray-300 p-4 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="Pilih tanggal" required readonly>
                @error('tanggal_event')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label class="block mb-2 text-lg font-semibold text-gray-700">Jenis Paket dan Nominal</label>
                <div class="flex items-center space-x-4">
                    <input type="text" name="jenis_paket[]" placeholder="Jenis Paket" class="w-1/2 border border-gray-300 p-4 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <input type="number" name="nominal[]" placeholder="Nominal (Rp)" class="w-1/2 border border-gray-300 p-4 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div id="paket-list"></div>
                <button type="button" id="tambah-paket" class="mt-4 text-blue-600">+ Tambah Paket</button>

                @error('jenis_paket')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
                @error('nominal')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-4">
                <label for="kuitansi_template" class="block font-medium">Template Kuitansi (Images)</label>
                <input type="file" name="kuitansi_template" accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml" class="mt-1 block w-full">
                <p class="text-sm text-gray-500 mt-1">jpeg, png, jpg, gif, svg.</p>
                @error('kuitansi_template')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6 mt-6">
                <label class="block mb-2 text-lg font-semibold text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" class="w-full border border-gray-300 p-4 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4" placeholder="Deskripsi event (opsional)"></textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition duration-300 flex items-center space-x-2">
                    <i class="fas fa-save"></i>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
        flatpickr("#tanggal_event", {
        mode: "multiple", // Memungkinkan memilih beberapa tanggal
        dateFormat: "Y-m-d", // Format tanggal
        onClose: function(selectedDates, dateStr, instance) {
            // Menyimpan tanggal yang dipilih sebagai array tersembunyi
            let tanggalArray = selectedDates.map(function(date) {
                return date.toISOString().split('T')[0];
            });

            // Membuat input tersembunyi untuk mengirim tanggal_event sebagai array
            let tanggalEventInput = document.createElement('input');
            tanggalEventInput.type = 'hidden';
            tanggalEventInput.name = 'tanggal_event[]'; // Array
            tanggalEventInput.value = tanggalArray.join(','); // Tanggal dipisahkan dengan koma

            // Menambahkan input tersembunyi ke dalam form
            document.querySelector('form').appendChild(tanggalEventInput);
        }
    });
    document.addEventListener("DOMContentLoaded", function () {
        // Inisialisasi Flatpickr
        flatpickr("#tanggal_event", {
            mode: "multiple",
            dateFormat: "Y-m-d",
            onClose: function(selectedDates, dateStr, instance) {
                document.querySelector("#tanggal_event").value = selectedDates.map(function(date) {
                    return date.toISOString().split('T')[0];
                }).join(',');
            }
        });

        // Event listener tombol tambah paket
        document.getElementById('tambah-paket').addEventListener('click', function () {
            let paketList = document.getElementById('paket-list');

            let div = document.createElement('div');
            div.classList.add('flex', 'items-center', 'space-x-4', 'mt-4');

            div.innerHTML = `
                <input type="text" name="jenis_paket[]" placeholder="Jenis Paket" class="w-1/2 border border-gray-300 p-4 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <input type="number" name="nominal[]" placeholder="Nominal (Rp)" class="w-1/2 border border-gray-300 p-4 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            `;

            paketList.appendChild(div);
        });
    });
</script>
@endpush

@endsection


