<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-gradient-to-br from-blue-50 to-purple-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-md p-4 flex justify-between items-center border-b border-gray-200">
        <div class="text-2xl font-bold text-indigo-600 flex items-center">
            <i class="fas fa-book-reader mr-2"></i> Forum Perpustakaan
        </div>
        <div>
            <a href="{{ url('/') }}" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors duration-300 flex items-center">
                <i class="fas fa-home mr-2"></i> Beranda
            </a>
        </div>
    </nav>

    <!-- Konten -->
    <main class="container mx-auto px-6 py-12 flex-grow">

        <div class="max-w-xl mx-auto bg-white p-8 rounded-3xl shadow-lg border border-gray-100 hover:shadow-2xl transition duration-300">
            <a href="{{ url()->previous() }}" 
                class="inline-block mb-4 text-sm text-blue-600 hover:text-blue-800 font-semibold">
                ← Kembali
            </a>

            <h2 class="text-3xl font-bold mb-6 text-blue-700 text-center">Pembayaran untuk: {{ $event->nama_event }}</h2>

            @if ($errors->any())
                <div class="mb-4 bg-red-50 text-red-700 border border-red-200 p-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-50 text-red-700 border border-red-200 p-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('public.payment.store', ['id' => $event->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-gray-700">👤 Nama</label>
                    <input type="text" name="nama" class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-200" required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-gray-700">📱 Nomor WhatsApp</label>
                    <input type="text" name="wa" class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-200" required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-gray-700">📧 Email</label>
                    <input type="email" name="email" class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-200" required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-gray-700">🏢 Instansi</label>
                    <input type="text" name="instansi" class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-200" required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-gray-700">🎟️ Paket yang Dipilih</label>
                    <select name="paket_id" class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-200" required>
                        <option value="">Pilih Paket</option>
                        @foreach ($event->pakets as $paket)
                            <option value="{{ $paket->id }}" data-nominal="{{ $paket->nominal }}">
                                {{ $paket->nama_paket }} - Rp {{ number_format($paket->nominal, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-gray-700">💰 Jumlah Pembayaran</label>
                    <input type="number" name="amount" id="amount" class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-200" required>
                </div>

                <div class="mb-6">
                    <label class="block mb-1 font-semibold text-gray-700">📎 Upload Bukti Pembayaran</label>
                    <input type="file" name="bukti" class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-200" accept="image/*" required>
                </div>

                <div>
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded w-full shadow-md hover:shadow-lg transition duration-200">
                        Kirim Pembayaran
                    </button>
                </div>
            </form>

        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-inner p-4 text-center text-gray-500">
        &copy; {{ date('Y') }} Forum Perpustakaan PTMA.
    </footer>

    <script>
        document.querySelector('select[name="paket_id"]').addEventListener('change', function() {
            var nominal = this.selectedOptions[0].getAttribute('data-nominal');
            document.getElementById('amount').value = nominal;
        });
    </script>

</body>
</html>
