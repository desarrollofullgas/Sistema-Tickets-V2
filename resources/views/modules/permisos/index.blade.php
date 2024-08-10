<x-app-layout>

    @section('title', 'Roles Y Permisos')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet-header>
                {{ __('ROLES Y PERMISOS') }}
            </x-card-greet-header>
             @if ($val->pivot->wr == 1)
            @livewire('permisos.new-permiso')
        @endif 
        </div>
    </x-slot>
    
   @livewire('permisos.table-permisos')
    
</x-app-layout>