<x-app-layout>
    @section('title', 'Notificaciones')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet-header>
                {{ __('NOTIFICACIONES') }}
            </x-card-greet-header>
        </div>
    </x-slot>
    <form action="{{route('notificaciones')}}">
        <x-input type="text" id="search" name="search" class="dark:text-gray-300" placeholder="Buscar..."/>
    </form>
    <div class="flex flex-col  gap-3 py-3">
		 @livewire('new-notifications')
        @livewire('all-notifications')
    </div>
</x-app-layout>
