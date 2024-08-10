<x-app-layout>
    @section('title', 'Graficas de compras')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet-header>
                {{ __('GRÁFICAS DE REQUISICIONES') }}
            </x-card-greet-header>
        </div>
        <div class="mt-10 mb-2 flex flex-wrap gap-2 justify-center">
            @livewire('analytics.compras.categorias')
            @livewire('analytics.compras.serv-prod')
        </div>
        <div class="mb-2 flex flex-wrap gap-2 justify-center">
            @livewire('analytics.compras.productos')
            @livewire('analytics.compras.servicios')
        </div>
    </x-slot>
    {{-- script de ChartsJS --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush
</x-app-layout>