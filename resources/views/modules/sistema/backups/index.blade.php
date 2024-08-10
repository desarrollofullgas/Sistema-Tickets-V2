<x-app-layout>
    @section('title', 'Backup')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet-header>
                {{ __('RESPALDO BASE DE DATOS') }}
            </x-card-greet-header>
        </div>
    </x-slot>
    <div>
        <div>
            @livewire('backup-manager')
        </div>
    </div>
</x-app-layout>
