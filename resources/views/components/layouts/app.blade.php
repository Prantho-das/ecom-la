<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? getSetting('site_title',"Dato Hall") }}</title>
        <meta name="description" content="{{ $description ?? 'Laravel Ecom LA' }}">
        <link rel="icon" href="{{ asset(getSetting('logo')) }}" type="image/x-icon">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex flex-col min-h-screen font-sans antialiased bg-white">
        <x-header />

        <main class="flex-grow">
            {{ $slot }}
        </main>

        <x-footer />
    </body>
</html>
