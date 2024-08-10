<div class="w-full h-full text-center flex flex-wrap justify-center items-center gap-6">

    <div class="flex flex-wrap justify-center gap-5 w-full">
        @livewire('dashboard.ticket-prioridad')
        @livewire('dashboard.ticket-estado')
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush
</div>
