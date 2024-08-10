<div>
    <button wire:click="editArea({{$areaID}})" wire:loading.attr="disabled" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-indigo-500 transition duration-300">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
        <span class="tooltiptext">Editar</span>
    </button>
    
        <x-dialog-modal wire:model="modal" id="modalRepuesto" class="flex items-center">
            <x-slot name="title">
                <div class="bg-dark-eval-1 dark:bg-gray-600 p-2 rounded-md text-white text-center">
                    {{ __('Editar Área') }}
                </div>
            </x-slot>
            <x-slot name="content">
                <div class="flex flex-wrap gap-3 justify-evenly items-center">
                    <div>
                        <x-label value="{{ __('Nombre del área') }}" for="area" />
                        <x-input wire:model="area" type="text" name="area"
                            id="area" required autofocus autocomplete="area" />
                        <x-input-error for="area"></x-input-error>
                    </div>
                    <div>
                        <x-label value="{{ __('Departamento') }}" for="banco"/>
                        <select wire:model="depto" name="depto" id="depto"
                            class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                            {{-- @if ($deptoName)  
                                <option hidden value="" selected>{{$deptoName}}</option>
                            @endif --}}
                            @foreach ($departamentos as $dep)
                                <option value="{{$dep->id}}">{{$dep->name}}</option>
                            @endforeach
                        </select>
                        <x-input-error for="depto"></x-input-error>
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
                <x-danger-button class="mr-2" wire:click="updateArea({{$areaID}})" wire:loading.attr="disabled">
                    <div role="status" wire:loading wire:target="updateArea">
                        <svg aria-hidden="true"
                            class="inline w-4 h-4 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-white"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                    Aceptar
                </x-danger-button>
    
                <x-secondary-button wire:click="$set('modal',false)" wire:loading.attr="disabled">
                    Cancelar
                </x-secondary-button>
            </x-slot>
        </x-dialog-modal>
</div>