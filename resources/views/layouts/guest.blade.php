<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('img/favicon/faviconnew.png') }}" type="image/x-icon">

    <title> Fullgas  @yield('title') </title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <!-- Styles -->
    <style>
        [x-cloak] {
            display: none;
        }
    </style>
	<style>
        body {
            /* Establecer un color de fondo */
            background-color: #f3f4f6; /* Color de fondo base */
        }

        /* Estilo para el fondo de puntitos o asteriscos */
        .dots-background {
            /* Utilizar un gradiente de puntos */
            background-image: radial-gradient(#0000001c 1px, transparent 2px); /* Color y tamaño de los puntos */
            background-size: 20px 20px; /* Tamaño de los puntos */
        }
    </style>

@livewireStyles

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 dark:text-gray-200"> 
    <div x-data="mainState" :class="{dark: isDarkMode}" x-cloak>
        <div class="flex flex-col min-h-screen selection:bg-red-400 selection:text-neutral-700 text-gray-900 bg-gray-100 dark:bg-dark-eval-2 dark:text-gray-200 dots-background">
            {{ $slot }}
            {{-- <x-footer /> --}}
        </div>

        <div class="fixed top-10 right-10">
            <x-button type="button" iconOnly variant="secondary" srText="Toggle dark mode" @click="toggleTheme">
                <x-heroicon-o-moon x-show="!isDarkMode" aria-hidden="true" class="w-6 h-6" />
                <x-heroicon-o-sun x-show="isDarkMode" aria-hidden="true" class="w-6 h-6" />
            </x-button>
        </div>
    </div>
    @stack('modals')

    @livewireScripts
</body>

</html>