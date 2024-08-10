<x-app-layout>
    @section('title', 'Tickets Pendientes')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet-header>
                {{ __('TICKETS PENDIENTES') }}
            </x-card-greet-header>
            {{-- <div class="flex flex-wrap gap-2">
                @if ($pendientes > 0 && Auth::user()->permiso_id==1)
                    <a href="" class="rounded-md px-2 py-1 flex justify-center items-center bg-sky-700 hover:bg-sky-800 transition duration-300" >
                        Tickets por abrir 
                        <div class="mx-1 rounded-full bg-white text-black w-7 h-7 flex justify-center items-center">
                            {{$pendientes}}
                        </div>
                    </a>
                @endif
                
                @livewire('tickets.new-ticket')
            </div> --}}
        </div>
    </x-slot>
   {{--  @livewire('tickets.tickets') --}}
   @livewire('tickets.por-abrir')
</x-app-layout>