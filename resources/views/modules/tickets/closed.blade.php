<x-app-layout>
    @section('title', 'Tickets Cerrados')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet-header>
                {{ __('TICKETS CERRADOS') }}
            </x-card-greet-header>
            <div class="flex flex-wrap gap-2">
                @if ($valid->pivot->wr == 1)
                    @livewire('tickets.new-ticket')
                @endif
            </div>
        </div>
    </x-slot>
    @livewire('tickets.ticket-cerrado')
</x-app-layout>