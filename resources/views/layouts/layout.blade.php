<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Website Donasi')</title>
    @vite('resources/css/app.css')
    <!-- Tambahkan ini di header -->
    <link href="https://cdn.jsdelivr.net/npm/lightbox2/dist/css/lightbox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <!-- Tambahkan ini di bagian bawah body -->
    <script src="https://cdn.jsdelivr.net/npm/lightbox2/dist/js/lightbox.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

</head>
<body class="bg-emerald-100">
    <!-- Header -->
    @include('components.navbar')

    <!-- Main Content -->
    <main class="container mx-auto p-4">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')

    @include('components.float-navbar')
</body>
</html>
