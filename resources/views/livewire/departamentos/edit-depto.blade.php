<div>
    <button wire:click="editDepto({{$deptoID}})" wire:loading.attr="disabled" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-indigo-500 transition duration-300">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
        <span class="tooltiptext">Editar</span>
    </button>
    
        <x-dialog-modal wire:model="modal" id="modalRepuesto" class="flex items-center">
            <x-slot name="title">
                {{ __('Editar departamento') }}
            </x-slot>
            <x-slot name="content">
                <div class="flex flex-wrap gap-3 justify-evenly items-center">
                    <div>
                        <x-label value="{{ __('Nombre del departamento') }}" for="name" />
                        <x-input wire:model="name" type="text" name="name" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                        dark:text-gray-300 dark:focus:ring-offset-dark-eval-1"
                            id="name" required autofocus autocomplete="name" />
                        <x-input-error for="name"></x-input-error>
                    </div>
                    <div>
                        <x-label value="{{ __('Status') }}" />
                        <select id="status" wire:model="status"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('status') ? 'is-invalid' : '' }}"
                            name="status" required aria-required="true">
                            <option hidden value="">Seleccionar Status</option>
                            <option value="Activo" @if ($status == 'Activo') {{ 'selected' }} @endif>
                                Activo</option>
                            <option value="Inactivo" @if ($status == 'Inactivo') {{ 'selected' }} @endif>
                                Inactivo</option>
                        </select>
                        <x-input-error for="status"></x-input-error>
                    </div>
                </div>
            </x-slot>
    
            <x-slot name="footer" class="d-none">
                <x-danger-button class="mr-2" wire:click="updateDepto({{$deptoID}})" wire:loading.attr="disabled">
                    Aceptar
                </x-danger-button>
    
                <x-secondary-button wire:click="$set('modal',false)" wire:loading.attr="disabled">
                    Cancelar
                </x-secondary-button>
            </x-slot>
        </x-dialog-modal>
</div>