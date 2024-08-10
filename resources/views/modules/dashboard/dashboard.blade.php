@php
    use Carbon\Carbon;
@endphp
<x-app-layout>
    @section('title', 'Dashboard')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet>
                {{ $greeting }}
            </x-card-greet>
        </div>
    </x-slot>
    <div x-data="{ showModal: false, modalStyle: '' }" class="relative inline-block">
        <!-- Trigger element to open the modal -->
        <div @click="showModal = true; calculateModalPosition($event)" class="flex gap-2 text-2xl font-bold text-gray-700 dark:text-gray-400 mb-3">
            {{ __('TICKETS') }}
            <x-icons.info class="w-5 h-5"/>
        </div>
    
        <!-- Modal -->
        <div x-show="showModal" @click.away="showModal = false" :style="modalStyle" class="absolute bg-white dark:bg-dark-eval-3 rounded-2xl p-6 z-50 shadow-md">
            <h2 class="text-xs font-medium text-neutral-700 dark:text-neutral-400">INFORMACIÓN TICKETS, MES EN CURSO: {{ mb_strtoupper(Carbon::now()->monthName) }}</h2>
        </div>
    </div>
    <div class="flex flex-wrap justify-center items-center gap-3 py-3">
        <div class="p-2 w-full">
            <div class="flex flex-wrap justify-center gap-5">
                {{-- Abiertos => mes en curso --}}
                <div class="col-span-12 sm:col-span-12 md:col-span-5 lg:col-span-5 xxl:col-span-5">
                    @livewire('top-tickets.list-abiertos')
                </div>
                {{-- En proceso => mes en curso --}}
                <div class="col-span-12 sm:col-span-12 md:col-span-5 lg:col-span-5 xxl:col-span-5">
                    @livewire('top-tickets.list-en-proceso')
                </div>
                {{-- Cerrados => mes en curso --}}
                <div class="col-span-12 sm:col-span-12 md:col-span-5 lg:col-span-5 xxl:col-span-5">
                    @livewire('top-tickets.list-cerrado')
                </div>
            </div>
        </div>
    </div>

    {{-- Graficas Prioridad y total por estado => mes en curso --}}
    <div class=" flex justify-center items-center py-3">
        <div>
            @livewire('dashboard.dashboard-charts')
        </div>
    </div>
</x-app-layout>
<script>
    calculateModalPosition(event) {
    const iconRect = event.target.getBoundingClientRect();
    const modalLeft = iconRect.right + window.pageXOffset;
    const modalTop = iconRect.top + window.pageYOffset;
    this.modalStyle = `left: ${modalLeft}px; top: ${modalTop}px;`;
}
</script>