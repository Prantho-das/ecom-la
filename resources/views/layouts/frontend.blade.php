<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Product Details' }}</title>
    <meta name="description" content="{{ $description ?? '' }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="shortcut icon" href="{{ asset(getSetting('logo')) }}" type="image/x-icon" />
    @livewireStyles
</head>

<body>
    <x-header />
    {{ $slot }}
    <x-footer />
    <!-- You can open the modal using ID.showModal() method -->
<x-country-modal/>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    {{-- Extra Scripts Slot For Components --}}


    @livewireScripts
    @stack('scripts')
</body>

</html>
