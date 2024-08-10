<x-app-layout>
    @section('title', 'Folios de Entrada')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet-header>
                {{ __('EDITAR ENTRADA #').$id }}
            </x-card-greet-header>
        </div>
        <div>
         @livewire('folios.entradas.edit-entrada',['entradaID'=>$id])
        </div>
    </x-slot>
</x-app-layout>