<x-app-layout>
    @section('title', 'Graficas de usuarios')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet-header>
                {{ __('GRÁFICAS DE USUARIOS') }}
            </x-card-greet-header>
        </div>
        <div class="mt-10 mb-2 flex flex-wrap gap-2 justify-center">
            @livewire('analytics.users.cant-tck-asignado')
            @livewire('analytics.users.cant-tck-register')
            @livewire('analytics.users.cant-tck-zona')
            @livewire('analytics.users.cant-tck-area')
        </div>
        <div class="mt-3">
            @livewire('analytics.users.cant-tck-supervisores')
        </div>
        <div class="mt-3">
            @livewire('analytics.users.cant-tck-individual')
        </div>
    </x-slot>
    {{-- script de ChartsJS --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
    @endpush
</x-app-layout>