<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Freelora') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * { transition: background-color 0.2s ease, border-color 0.2s ease, color 0.15s ease; }
        </style>
    </head>
    <body class="font-sans antialiased h-full bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100">
        @include('layouts.navigation')

        <!-- Page Content -->
        <main class="min-h-screen">
            {{ $slot }}
        </main>
    </body>
</html>
