<x-app-layout>
    @section('title', 'Graficas generales')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet-header>
                {{ __('GRÁFICAS GENERALES') }}
            </x-card-greet-header>
        </div>
        <div class="mt-10 mb-2 flex flex-wrap gap-2 justify-center">
            @livewire('analytics.general')
            @livewire('analytics.prioridades')
        </div>
        <div>
            @livewire('analytics.fallas')
        </div>
    </x-slot>
    {{-- script de ChartsJS --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush
</x-app-layout>