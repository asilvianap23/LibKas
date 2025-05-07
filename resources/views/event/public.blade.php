<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Event Publik</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #eef2f7, #f8fafc);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col font-sans">

    <!-- Navbar -->
    <nav class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-50">
        <div class="text-2xl font-bold text-indigo-600 flex items-center">
            <i class="fas fa-book-reader text-3xl mr-2"></i> Forum Perpustakaan
        </div>
        <div>
            <a href="{{ url('/') }}" class="text-gray-700 hover:text-indigo-600 font-medium transition duration-300">
                <i class="fas fa-home mr-2"></i> Beranda
            </a>
        </div>
    </nav>

    <!-- Konten -->
    <main class="container mx-auto px-6 py-10 flex-grow">

        <!-- Header -->
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold text-indigo-700 mb-2 flex items-center justify-center space-x-2">
                <i class="fas fa-star text-yellow-400"></i>
                <span>Daftar Event Publik</span> 
                <i class="fas fa-star text-yellow-400"></i>
            </h1>            
            <p class="text-gray-600">Acara yang tersedia untuk Anda</p>
            <div class="mt-2 w-24 mx-auto border-b-4 border-indigo-500 rounded"></div>
        </div>

        <!-- Pesan Sukses -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 text-green-700 border border-green-300 p-4 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Daftar Event -->
        @if($events->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($events as $event)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 p-6 border border-gray-100">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-calendar-alt text-indigo-500 text-2xl mr-3"></i>
                            <h3 class="text-xl font-bold text-indigo-600">
                                <a href="{{ route('public.event.daftar', $event->id) }}" class="hover:underline">{{ $event->nama_event }}</a>
                            </h3>
                        </div>

                        <p class="text-sm text-gray-500 mb-2">
                            <i class="fas fa-calendar-check mr-1"></i> 
                            {{ collect(explode(',', $event->tanggal_event))->map(fn($tgl) => \Carbon\Carbon::parse($tgl)->format('d-m-Y'))->implode(', ') }}
                        </p>

                        <p class="text-gray-700 mb-6 leading-relaxed">
                            <i class="fas fa-info-circle text-indigo-300 mr-2"></i>
                            {{ Str::limit($event->deskripsi, 120, '...') }}
                        </p>

                        <div class="flex justify-end">
                            <a href="{{ route('public.event.daftar', $event->id) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition duration-300 flex items-center space-x-2">
                                <span>Daftar</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <p class="text-gray-500 text-lg"><i class="fas fa-exclamation-circle text-red-500 mr-2"></i> Belum ada event tersedia.</p>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-inner p-4 text-center text-gray-500 border-t">
        &copy; {{ date('Y') }} Forum Perpustakaan PTMA.
    </footer>

</body>
</html>
