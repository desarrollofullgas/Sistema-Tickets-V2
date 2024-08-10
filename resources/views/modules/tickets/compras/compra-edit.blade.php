<x-app-layout>
    @section('title', 'Requisiciones')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet-header>
                {{ __('REQUISICIÓN #').$compraID }}
            </x-card-greet-header>
        </div>
    </x-slot>
    <div>
        @livewire('tickets.compras.compra-edit',['compraID' => $compraID])
    </div>
</x-app-layout>