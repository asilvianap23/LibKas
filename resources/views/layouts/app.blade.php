<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <body class="font-sans antialiased">
    <!-- resources/views/layouts/app.blade.php -->
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        
        <!-- Button to open Sidebar (Only visible when sidebar is closed) -->
        <button class="openbtn" id="toggleSidebarBtn" onclick="toggleSidebar()"></button>

        <!-- Sidebar -->
        @include('layouts.sidebar') <!-- Menyertakan sidebar dari file terpisah -->

        <!-- Page Content -->
        <div class="main-content" id="mainContent">
            <!-- Navigation Bar -->
            <div class="sticky-nav">
                @include('layouts.navigation')
            </div>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#tanggal_event", {
            mode: "multiple", // memungkinkan memilih beberapa tanggal
            dateFormat: "Y-m-d", // format tanggal
            onClose: function(selectedDates, dateStr, instance) {
                // Menyimpan tanggal yang dipilih dalam format string terpisah koma
                document.querySelector("#tanggal_event").value = selectedDates.map(function(date) {
                    return date.toISOString().split('T')[0];
                }).join(',');
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            // Inisialisasi Select2
            $('.select2').select2({
                placeholder: 'Pilih opsi...',
                allowClear: true
            });
    
            // Pastikan toggle sidebar tetap berfungsi
            let sidebar = document.getElementById('sidebar');
            let toggleButton = document.getElementById('toggleSidebarBtn');
    
            if (sidebar.classList.contains('closed')) {
                toggleButton.style.display = 'block';
                toggleButton.innerHTML = "→";
            } else {
                toggleButton.style.display = 'none';
                toggleButton.innerHTML = "←";
            }
        });
    
        // Fungsi toggle sidebar
        function toggleSidebar() {
            let sidebar = document.getElementById('sidebar');
            let mainContent = document.getElementById('mainContent');
            let toggleButton = document.getElementById('toggleSidebarBtn');
            
            sidebar.classList.toggle('closed');
            mainContent.classList.toggle('expanded');
    
            if (sidebar.classList.contains('closed')) {
                toggleButton.style.display = 'block';
                toggleButton.innerHTML = "→";
            } else {
                toggleButton.style.display = 'none';
                toggleButton.innerHTML = "←";
            }
        }
    </script>
    @stack('scripts')
    </body>
</html>
