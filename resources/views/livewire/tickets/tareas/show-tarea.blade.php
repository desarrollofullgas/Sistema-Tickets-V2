<div>
    <div class="">
        <button wire:click="showTarea({{ $tareaID }})" class="tooltip">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="tooltiptext">Ver Más</span>
        </button>
    </div>

    <x-dialog-modal wire:model="modal" class="flex items-center">
        <x-slot name="title">
            <div class="bg-dark-eval-1 dark:bg-dark-eval-3 p-2 rounded-md text-white text-center">
                {{ __('Detalles de la Tarea') }}
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="max-h-[320px] overflow-y-auto">
                <div class="overflow-hidden max-h-96 overflow-y-auto">
                    <fieldset class="border border-l-dark-eval-1 dark:border-gray-500 p-2">
                        <legend class="font-bold">TICKET:</legend>
                        <div>
                            <span><strong>#: </strong>{{$this->idticket}}</span>
                            <span><strong>CLIENTE: </strong>{{ $this->solicitatck }}</span>
                        </div>
                        <div class="mt-2 flex flex-wrap gap-3">
                            <span><strong>DESCRIPCIÓN: </strong>{{$this->mensajetck}}</span>
                            <span><strong>VENCIMIENTO: </strong>{{$this->vencetck}}</span>
                        </div>
                    </fieldset>
                    <fieldset class="border border-l-dark-eval-1 dark:border-gray-500 p-2">
                        <legend class="font-bold">TAREA:</legend>
                        <div>
                            <span><strong>#: </strong>{{$this->tareaID}}</span>
                            <span><strong>ASIGNADO: </strong>{{ $this->user_asignado }}</span>
                        </div>
                        <div class="mt-2 flex flex-wrap gap-3">
                            <span><strong>ASUNTO: </strong>{{$this->asunto}}</span>
                            <span><strong>DESCRIPCIÓN: </strong>{{$this->mensaje}}</span>
                        </div>
                    </fieldset>
                </div>
                <div class="dark:bg-dark-eval-0 p-2 rounded-md mt-2">
                    @livewire('tickets.tareas.comentarios-tarea', ['tareaID' => $tareaID], key('comentarios'.$tareaID))
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-secondary-button wire:click="$set('modal',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
