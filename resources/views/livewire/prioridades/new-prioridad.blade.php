<div class="col-md-4 col-sm-6 col-6 d-flex justify-content-end justify-content-md-end justify-content-sm-end">
    <div class="">
        <x-button wire:click="$set('modal',true)" class="dark:border-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700">
            <i class="fa-solid fa-plus"></i>
            {{ __('Añadir prioridad') }}
            </x-jet-button>
    </div>

    <x-dialog-modal wire:model="modal" id="" class="flex items-center">
        <x-slot name="title">
            {{ __('Nueva prioridad') }}
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-wrap gap-3 justify-evenly items-center">
                <div>
                    <x-label value="{{ __('Nivel de prioridad') }}" for="name" />
                    <select wire:model="name" name="name" id="name"
                        class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        <option hidden value="" selected>Seleccionar prioridad</option>
                        <option value="Bajo">Bajo</option>
                        <option value="Medio">Medio</option>
                        <option value="Alto">Alto</option>
                        <option value="Crítico">Crítico</option>
                        <option value="Alto Crítico">Alto Crítico</option>
                    </select>
                    <x-input-error for="name"></x-input-error>
                </div>
                <div>
                    <x-label value="{{ __('Tipo de ticket') }}" for="banco"/>
                    <select wire:model="tipo" name="tipo" id="tipo"
                        class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        <option hidden value="" selected>Seleccionar tipo</option>
                        @foreach ($tipos as $tipo)
                            <option value="{{$tipo->id}}">{{$tipo->name}}</option>
                        @endforeach
                    </select>
                    <x-input-error for="tipo"></x-input-error>
                </div>
                <div>
                    <x-label value="{{ __('Tiempo de respuesta en HORAS') }}" for="area" />
                    <x-input wire:model="tiempo" type="number" name="tiempo" min="1"
                        id="tiempo" required autofocus autocomplete="tiempo" />
                    <x-input-error for="tiempo"></x-input-error>
                </div>
            </div>
            
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addPrioridad" wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$set('modal',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>