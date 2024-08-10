<x-app-layout>
    @section('title', 'Requisicion')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet-header>
                {{ __('NUEVA REQUISICIÓN PARA EL TICKET #').$ticketID }}
            </x-card-greet-header>
            {{-- Botones acción --}}
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-center mt-5">
                {{-- Botones acción --}}
                @if (Auth::user()->permiso_id == 1 ||
                        Auth::user()->permiso_id == 7 ||
                        Auth::user()->permiso_id == 4 ||
                        Auth::user()->permiso_id == 5)
                    <div class="bg-dark-eval-1 dark:bg-dark-eval-2 p-2 rounded-md text-white text-center">
                        {{ __('Ir a:') }}
                    </div>
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-center mt-5">
                        <div class="flex justify-center rounded-lg space-x-2" role="group">
                            @if (Auth::user()->permiso_id == 1)
                                <a class="px-2 py-1 text-xs font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800"
                                    href="{{ route('tck.editar', $tck->id) }}">
                                    Editar Ticket
                                </a>
                                @livewire('tickets.reasignar', ['ticketID' => $ticketID])
                            @endif
                            <a class="flex items-center px-2 py-1 text-xs font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800" href="{{ route('tck.tarea', $tck->id) }}">
                                @if ($tareasCount)
                                    <div class="relative">
                                      
                                        <span class="absolute top-0 right-0 bg-red-500 text-white p-1 rounded-full"></span>
                                    </div>
                                @else
                                @endif
                                Tareas
                            </a>
                            <a class="px-2 py-1 text-xs font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800" href="{{ route('tck.ver', $tck->id) }}">
                                Ver Ticket
                            </a>

                            @if (Auth::user()->permiso_id == 1 && $tck->status == 'Cerrado')
                                @livewire('tickets.unlock-ticket', ['ticketID' => $ticketID])
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>
    <div>
        @livewire('tickets.compras.new-compra', ['ticketID' => $ticketID])
    </div>
</x-app-layout>
