<x-app-layout>
    @section('title', 'Ranking')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet-header>
                {{ __('RANKING DE CALIFICACIONES') }}
            </x-card-greet-header>
        </div>
    </x-slot>
    <div>
        @livewire('analytics.calificaciones.ranking')
    </div>
</x-app-layout>