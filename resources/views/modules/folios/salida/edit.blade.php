<x-app-layout>
    @section('title', 'Folios de Salida')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet-header>
                {{ __('EDITAR SALIDA #').$id }}
            </x-card-greet-header>
        </div>
        <div>
         @livewire('folios.salida.edit-salida',['salidaID'=>$id])
        </div>
    </x-slot>
</x-app-layout>