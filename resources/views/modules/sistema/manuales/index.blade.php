<x-app-layout>

    @section('title', 'Manuales')

    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet-header>
                {{ __('MANUALES') }}
            </x-card-greet-header>
            @if ($val->pivot->wr == 1)
                @livewire('sistema.manuales.new-manual')
            @endif
        </div>
    </x-slot>

    @livewire('sistema.manuales.table-manuales')

</x-app-layout>
