<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HIMA ILKOM UMKU')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800 flex flex-col min-h-screen">

    <!-- Memanggil Navbar 1 Pintu -->
    @include('layouts.navbar')

    <!-- Konten Utama (Diberi pt-32 agar konten didorong ke bawah) -->
    <main class="flex-grow pt-28 sm:pt-32 pb-20">
        @yield('content')
    </main>

    <!-- Memanggil Footer 1 Pintu -->
    @include('layouts.footer')

</body>
</html>