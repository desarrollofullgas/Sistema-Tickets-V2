<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('img/favicon/faviconnew.png') }}" type="image/x-icon">

    <title> Fullgas - @yield('title') </title>

    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel=" stylesheet">

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
        
        /* Estilo para el fondo de puntitos o asteriscos */
        .dots-background {
            /* Utilizar un gradiente de puntos */
            background-image: radial-gradient(#0000001c 1px, transparent 2px); /* Color y tamaño de los puntos */
            background-size: 20px 20px; /* Tamaño de los puntos */
        }
    </style>

    <!--Select 2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- Toast --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/toastr.css') }}">
    <link href="{{ asset('assets/css/toastr.min.css') }}" rel="stylesheet" type="text/css" />


    @livewireStyles

    <!--JQuery-->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    <!--Select 2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased text-gray-900 dark:text-gray-200">

    <!--Developed with ❤ by Desarrollo, saga 2022 - 2024 😝-->
   {{-- <script type='text/javascript'>
        $(function() {
            $(document).bind("contextmenu", function(e) {
                return false;
            });
        });
    </script> --}}
    <div x-data="mainState" :class="{ dark: isDarkMode }" @resize.window="handleWindowResize" x-cloak>
        <x-banner />

         <div class="min-h-screen text-gray-900 bg-gray-100 selection:bg-red-400 selection:text-gray-700 dark:bg-dark-eval-2 dark:text-gray-200">
            <!-- Sidebar -->
            <x-sidebar.sidebar />

            <!-- Page Wrapper -->
            <div class="flex flex-col min-h-screen"
                :class="{
                    'lg:ml-64': isSidebarOpen,
                    'md:ml-16': !isSidebarOpen
                }"
                style="transition-property: margin; transition-duration: 150ms;">

                @livewire('navigation-menu')

                <x-mobile-bottom-nav />

                <!-- Page Heading -->
                @if (isset($header))
                    <header>
                        <div
                            class="px-4 py-6 mx-auto max-w-7xl w-full sm:px-6 lg:px-8 bg-white dark:bg-dark-eval-1 overflow-visible">
                            {{ $header }}
                        </div>
						 @livewire('atencion-guardia') {{-- llamado al componente  --}}
                    </header>
                @endif

                <!-- Page Content -->
                <main class="flex-1 p-4 mx-auto max-w-7xl w-full sm:p-6 lg:p-8 dots-background">
                    {{ $slot }}
                </main>
                <!-- Page Footer -->
                <x-footer />
            </div>
        </div>
    </div>
    @stack('modals')

    @include('sweetalert::alert') {{-- llamado a las propiedades de Sweet Alert --}}

    @livewireScripts
	
	{{-- Livewire sortable CDN --}}
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>


    @auth
        <script>
            window.onload = function() {
            // Crear un nuevo objeto de audio
            var audio = new Audio('/sound/iphone-notificacion.mp3');
            
            Echo.private('App.Models.User.' + {{ Auth::user()->id }})
                .notification((notification) => {
                    // Reproducir el sonido
                    audio.play();
                    
                    // Mostrar el tipo de notificación en la consola
                    console.log(notification.type);
                });
        }
        </script>
    @endauth

    @stack('scripts')

    <script src="{{ ('assets/js/toastr.min.js') }}"></script>
	<style>
        .bg-opacity-50 {
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>

  @if ($cantidadTicketsProximosVencer > 0)
        <script type="text/javascript">
            toastr.error("EXISTE {{ $cantidadTicketsProximosVencer }} TICKETS PRÓXIMOS A VENCER", 'Tickets por vencer', {
                timeOut: 0, // Desactiva el tiempo de espera automático para la notificación
                extendedTimeOut: 0, // Desactiva el tiempo extendido de espera
                closeButton: true, // Muestra el botón de cierre en la notificación
                onclick: function() {
                    document.getElementById('miModalV').classList.remove('hidden');
                    document.getElementById('miModalV').classList.add('flex');

                    document.getElementById('closeModalBtnV').addEventListener('click', function() {
                        document.getElementById('miModalV').classList.add('hidden');
                        document.getElementById('miModalV').classList.remove('flex');
                    });

                    document.getElementById('closeModalV').addEventListener('click', function() {
                        document.getElementById('miModalV').classList.add('hidden');
                        document.getElementById('miModalV').classList.remove('flex');
                    });
                }
            });
        </script>

        <!-- Modal -->
        <div id="miModalV"
            class="hidden fixed inset-0 flex items-center justify-center z-50 overflow-auto bg-black bg-opacity-50">
            <div
                class="bg-white rounded-lg w-full p-1 max-w-3xl overflow-hidden mx-4 sm:mx-auto sm:w-full md:max-w-8xl lg:max-w-8xl">
                <div class="modal-header flex justify-between items-center mb-4">
                    <h5 class="modal-title text-lg font-semibold">Tickets <strong>PRÓXIMOS A VENCER</strong> </h5>
                    <div class="text-xs">* Tickets cuya <strong>FECHA DE VENCIMIENTO</strong> se da dentro de 5 horas.
                    </div>
                </div>
                <div class="modal-body">
                    <div class=" max-h-72 overflow-auto">
                        <x-table>
                            <x-slot name="head">
                                {{-- Componente Heading  --}}
                                <x-heading sortable>ID</x-heading>
                                <x-heading sortable>ESTADO</x-heading>
                                <x-heading sortable>FALLA</x-heading>
                                <x-heading sortable>CLIENTE</x-heading>
                                <x-heading sortable>AGENTE</x-heading>
                                <x-heading sortable>CREADO</x-heading>
                                <x-heading sortable>VENCE</x-heading>
                                <x-heading sortable>PRIORIDAD</x-heading>
                                <x-heading></x-heading>
                            </x-slot>
                            <x-slot name="body">
                                @forelse($ticketsProximosVencer as $item)
                                    {{-- Componente Row --}}
                                    <x-row wire:loading.class.delay="opacity-75">
                                        {{-- Componente Column --}}
                                        <x-cell>{{ $item->id }} </x-cell>
                                        <x-cell>
                                            <div
                                                class="rounded bg-{{ $item->status_color }}-200 py-1 px-3 text-xs text-{{ $item->status_color }}-500 font-bold">
                                                {{ $item->status }}
                                            </div>
                                        </x-cell>
                                        <x-cell class="font-bold">{{ $item->falla->name }} </x-cell>
                                        <x-cell> {{ $item->cliente->name }}</x-cell>
                                        <x-cell> {{ $item->agente->name }}</x-cell>
                                        <x-cell> {{ $item->created_at }}</x-cell>
                                        <x-cell> {{ $item->fecha_cierre }}</x-cell>
                                        <x-cell> {{ $item->falla->prioridad->name }}</x-cell>
                                        <x-cell>
                                            <div class="flex gap-2 justify-center items-center">
                                                <a class="bg-white dark:bg-dark-eval-3 p-1 rounded-md tooltip"
                                                    href="{{ route('tck.ver', $item->id) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                        height="15" fill="currentColor"
                                                        class="w-6 h-6 text-black hover:text-gray-600 dark:text-white"
                                                        viewBox="0 0 576 512">
                                                        <path
                                                            d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                                                    </svg>
                                                    <span class="tooltiptext">Ver Más</span>
                                                </a>
                                            </div>
                                        </x-cell>
                                    </x-row>
                                @empty
                                    <x-row>
                                        <x-cell colspan="6">
                                            <div class="flex justify-center items-center space-x-2">
                                                <x-icons.inbox class="w-8 h-8 text-gray-300" />
                                                <span class="py-8 font-medium text-gray-400 text-xl">No se encontraron
                                                    resultados...</span>
                                            </div>
                                        </x-cell>
                                    </x-row>
                                @endforelse
                            </x-slot>
                        </x-table>
                    </div>
                </div>
                <div class="modal-footer mt-4">
                    <button id="closeModalBtnV"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md mr-4">
                        Cerrar
                    </button>
                    <!-- Otros botones o acciones que desees -->
                </div>
            </div>
        </div>
    @endif
    @if ($cantidadTicketsPorAtender > 0)
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                toastr.info("EXISTE {{ $cantidadTicketsPorAtender }} TICKETS ABIERTOS", 'Tickets abiertos', {
                    timeOut: 0, // Desactiva el tiempo de espera automático para la notificación
                    extendedTimeOut: 0, // Desactiva el tiempo extendido de espera
                    closeButton: true, // Muestra el botón de cierre en la notificación
                    onclick: function() {
                        document.getElementById('miModalA').classList.remove('hidden');
                        document.getElementById('miModalA').classList.add('flex');

                        document.getElementById('closeModalBtnA').addEventListener('click', function() {
                            document.getElementById('miModalA').classList.add('hidden');
                            document.getElementById('miModalA').classList.remove('flex');
                        });

                        document.getElementById('closeModalA').addEventListener('click', function() {
                            document.getElementById('miModalA').classList.add('hidden');
                            document.getElementById('miModalA').classList.remove('flex');
                        });
                    }
                });
            });
        </script>

        <!-- Modal -->
        <div id="miModalA"
            class="hidden fixed inset-0 flex items-center justify-center z-50 overflow-auto bg-black bg-opacity-50">
            <div
                class="bg-white rounded-lg w-full p-1 max-w-3xl overflow-hidden mx-4 sm:mx-auto sm:w-full md:max-w-8xl lg:max-w-8xl">
                <div class="modal-header flex justify-between items-center mb-4">
                    <h5 class="modal-title text-lg font-semibold">Tickets <strong>POR ATENDER</strong> </h5>
                    <div class="text-xs">* Tickets con estado <strong>ABIERTO</strong> con más de 30 minutos sin atender
                        desde su creación.</div>
                </div>
                <div class="modal-body">
                    <div class=" max-h-72 overflow-auto">
                        <x-table>
                            <x-slot name="head">
                                {{-- Componente Heading  --}}
                                <x-heading sortable>ID</x-heading>
                                <x-heading sortable>ESTADO</x-heading>
                                <x-heading sortable>FALLA</x-heading>
                                <x-heading sortable>CLIENTE</x-heading>
                                <x-heading sortable>AGENTE</x-heading>
                                <x-heading sortable>CREADO</x-heading>
                                <x-heading sortable>VENCE</x-heading>
                                <x-heading sortable>PRIORIDAD</x-heading>
                                <x-heading></x-heading>
                            </x-slot>
                            <x-slot name="body">
                                @forelse($ticketsPorAtender as $item)
                                    {{-- Componente Row --}}
                                    <x-row wire:loading.class.delay="opacity-75">
                                        {{-- Componente Column --}}
                                        <x-cell>{{ $item->id }} </x-cell>
                                        <x-cell>
                                            <div
                                                class="rounded bg-{{ $item->status_color }}-200 py-1 px-3 text-xs text-{{ $item->status_color }}-500 font-bold">
                                                {{ $item->status }}
                                            </div>
                                        </x-cell>
                                        <x-cell class="font-bold">{{ $item->falla->name }} </x-cell>
                                        <x-cell> {{ $item->cliente->name }}</x-cell>
                                        <x-cell> {{ $item->agente->name }}</x-cell>
                                        <x-cell> {{ $item->created_at }}</x-cell>
                                        <x-cell> {{ $item->fecha_cierre }}</x-cell>
                                        <x-cell> {{ $item->falla->prioridad->name }}</x-cell>
                                        <x-cell>
                                            <div class="flex gap-2 justify-center items-center">
                                                <a class="bg-white dark:bg-dark-eval-3 p-1 rounded-md tooltip"
                                                    href="{{ route('tck.ver', $item->id) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                        height="15" fill="currentColor"
                                                        class="w-6 h-6 text-black hover:text-gray-600 dark:text-white"
                                                        viewBox="0 0 576 512">
                                                        <path
                                                            d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                                                    </svg>
                                                    <span class="tooltiptext">Ver Más</span>
                                                </a>
                                            </div>
                                        </x-cell>
                                    </x-row>
                                @empty
                                    <x-row>
                                        <x-cell colspan="6">
                                            <div class="flex justify-center items-center space-x-2">
                                                <x-icons.inbox class="w-8 h-8 text-gray-300" />
                                                <span class="py-8 font-medium text-gray-400 text-xl">No se encontraron
                                                    resultados...</span>
                                            </div>
                                        </x-cell>
                                    </x-row>
                                @endforelse
                            </x-slot>
                        </x-table>
                    </div>
                </div>
                <div class="modal-footer mt-4">
                    <button id="closeModalBtnA"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md mr-4">
                        Cerrar
                    </button>
                    <!-- Otros botones o acciones que desees -->
                </div>
            </div>
        </div>
    @endif
    @if ($cantidadTicketsSinComentar > 0)
        <script type="text/javascript">
            toastr.warning("EXISTE {{ $cantidadTicketsSinComentar }} TICKETS CON MÁS DE 3 DÍAS SIN ACTUALIZAR ",
                'Tickets sin comentar', {
                    timeOut: 0, // Desactiva el tiempo de espera automático para la notificación
                    extendedTimeOut: 0, // Desactiva el tiempo extendido de espera
                    closeButton: true, // Muestra el botón de cierre en la notificación
                    onclick: function() {
                        document.getElementById('miModalC').classList.remove('hidden');
                        document.getElementById('miModalC').classList.add('flex');

                        document.getElementById('closeModalBtnC').addEventListener('click', function() {
                            document.getElementById('miModalC').classList.add('hidden');
                            document.getElementById('miModalC').classList.remove('flex');
                        });

                        document.getElementById('closeModalC').addEventListener('click', function() {
                            document.getElementById('miModalC').classList.add('hidden');
                            document.getElementById('miModalC').classList.remove('flex');
                        });
                    }
                });
        </script>

        <!-- Modal -->
        <div id="miModalC"
            class="hidden fixed inset-0 flex items-center justify-center z-50 overflow-auto bg-black bg-opacity-50">
            <div
                class="bg-white rounded-lg w-full p-1 max-w-3xl overflow-hidden mx-4 sm:mx-auto sm:w-full md:max-w-8xl lg:max-w-8xl">
                <div class="modal-header flex justify-between items-center mb-4">
                    <h5 class="modal-title text-lg font-semibold">Tickets <strong>SIN ATENCIÓN</strong> </h5>
                    <div class="text-xs">* Tickets con más de <strong>3 DÍAS</strong> sin actualizar.</div>
                </div>
                <div class="modal-body">
                    <div class=" max-h-72 overflow-auto">
                        <x-table>
                            <x-slot name="head">
                                {{-- Componente Heading  --}}
                                <x-heading sortable>ID</x-heading>
                                <x-heading sortable>ESTADO</x-heading>
                                <x-heading sortable>FALLA</x-heading>
                                <x-heading sortable>CLIENTE</x-heading>
                                <x-heading sortable>AGENTE</x-heading>
                                <x-heading sortable>CREADO</x-heading>
                                <x-heading sortable>VENCE</x-heading>
                                <x-heading sortable>PRIORIDAD</x-heading>
                                <x-heading></x-heading>
                            </x-slot>
                            <x-slot name="body">
                                @forelse($ticketsEnProcesoSinComentarios as $item)
                                    {{-- Componente Row --}}
                                    <x-row wire:loading.class.delay="opacity-75">
                                        {{-- Componente Column --}}
                                        <x-cell>{{ $item->id }} </x-cell>
                                        <x-cell>
                                            <div
                                                class="rounded bg-{{ $item->status_color }}-200 py-1 px-3 text-xs text-{{ $item->status_color }}-500 font-bold">
                                                {{ $item->status }}
                                            </div>
                                        </x-cell>
                                        <x-cell class="font-bold">{{ $item->falla->name }} </x-cell>
                                        <x-cell> {{ $item->cliente->name }}</x-cell>
                                        <x-cell> {{ $item->agente->name }}</x-cell>
                                        <x-cell> {{ $item->created_at }}</x-cell>
                                        <x-cell> {{ $item->fecha_cierre }}</x-cell>
                                        <x-cell> {{ $item->falla->prioridad->name }}</x-cell>
                                        <x-cell>
                                            <div class="flex gap-2 justify-center items-center">
                                                <a class="bg-white dark:bg-dark-eval-3 p-1 rounded-md tooltip"
                                                    href="{{ route('tck.ver', $item->id) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                        height="15" fill="currentColor"
                                                        class="w-6 h-6 text-black hover:text-gray-600 dark:text-white"
                                                        viewBox="0 0 576 512">
                                                        <path
                                                            d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                                                    </svg>
                                                    <span class="tooltiptext">Ver Más</span>
                                                </a>
                                            </div>
                                        </x-cell>
                                    </x-row>
                                @empty
                                    <x-row>
                                        <x-cell colspan="6">
                                            <div class="flex justify-center items-center space-x-2">
                                                <x-icons.inbox class="w-8 h-8 text-gray-300" />
                                                <span class="py-8 font-medium text-gray-400 text-xl">No se encontraron
                                                    resultados...</span>
                                            </div>
                                        </x-cell>
                                    </x-row>
                                @endforelse
                            </x-slot>
                        </x-table>
                    </div>
                </div>
                <div class="modal-footer mt-4">
                    <button id="closeModalBtnC"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md mr-4">
                        Cerrar
                    </button>
                    <!-- Otros botones o acciones que desees -->
                </div>
            </div>
        </div>
    @endif
</body>

</html>
