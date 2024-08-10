<div x-data="{ modelOpen: false, dates:false }">
    <x-button @click="modelOpen =!modelOpen" wire:loading.attr="disabled" aria-label="añadir tipo" class="flex gap-2 dark:border-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700">
        <svg class="w-5 h-5 text-white" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
            <path d="M15.534 1.36L14.309 0H4.662c-.696 0-.965.516-.965.919v3.63H5.05V1.653c0-.154.13-.284.28-.284h6.903c.152 0 .228.027.228.152v4.82h4.913c.193 0 .268.1.268.246v11.77c0 .246-.1.283-.25.283H5.33a.287.287 0 0 1-.28-.284V17.28H3.706v1.695c-.018.6.302 1.025.956 1.025H18.06c.7 0 .939-.507.939-.969V5.187l-.35-.38l-3.116-3.446Zm-1.698.16l.387.434l2.596 2.853l.143.173h-2.653c-.2 0-.327-.033-.38-.1c-.053-.065-.084-.17-.093-.313V1.52Zm-1.09 9.147h4.577v1.334h-4.578v-1.334Zm0-2.666h4.577v1.333h-4.578V8Zm0 5.333h4.577v1.334h-4.578v-1.334ZM1 5.626v10.667h10.465V5.626H1Zm5.233 6.204l-.64.978h.64V14H3.016l2.334-3.51l-2.068-3.156H5.01L6.234 9.17l1.223-1.836h1.727L7.112 10.49L9.449 14H7.656l-1.423-2.17Z"/>
        </svg>
        {{ __('HISTORIAL GENERAL') }}
    </x-jet-button>
    <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center md:items-center sm:p-0">
            <div x-cloak @click="modelOpen = false" x-show="modelOpen" 
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0" 
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100" 
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-gray-500 dark:bg-gray-700/75 bg-opacity-75" aria-hidden="true"
            ></div>
            <div x-cloak x-show="modelOpen" 
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block w-full max-w-xl p-6 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl dark:bg-dark-eval-1"
            >      
                <div class="flex items-center justify-between space-x-4">
                    <h1 class="text-xl font-medium">{{ __('Guardar historial de folios') }}</h1>
                </div>
                <div>
                    <div class="flex flex-wrap gap-2 items-center py-2">
                        <div class="text-center m-auto border-b">
                            <x-label value="{{ __('Seleccione un tipo de reporte') }}" for="tipo" />
                            <div class="flex gap-2 justify-center items-stretch py-3">
                                <div id="tipo">
                                    <input type="radio" name="tipo" id="entrada" value="gral" wire:model.defer="tipo" class="peer/entrada hidden">
                                    <label for="entrada" class="h-full flex items-center justify-center gap-1 cursor-pointer bg-gray-300 dark:bg-dark-eval-0 peer-checked/entrada:bg-amber-600 hover:bg-amber-500 text-white px-4 py-2 rounded-md transition duration-300" @click="dates=false">
                                        General
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" name="tipo" id="salida" value="date" wire:model.defer="tipo" class="peer/salida hidden">
                                    <label for="salida" class="h-full flex items-center justify-center gap-1 cursor-pointer bg-gray-300 dark:bg-dark-eval-0 peer-checked/salida:bg-amber-600 hover:bg-amber-500 text-white px-4 py-2 rounded-md transition duration-300" @click="dates=true">
                                        Rango de fechas
                                    </label>
                                </div>
                            </div>
                            <x-input-error for="tipo"></x-input-error>
                        </div>
                        <div class="w-full flex flex-wrap justify-center gap-3" x-show="dates" x-cloack x-collapse>
                            <div>
                                <x-label value="{{ __('Fecha de inicio') }}" for="dateIn" />
                                <x-input wire:model.defer="dateIn" type="date" name="dateIn"
                                    id="dateIn" required autofocus autocomplete="dateIn" />
                                <x-input-error for="dateIn"></x-input-error>
                            </div>
                            <div>
                                <x-label value="{{ __('Fecha de termino') }}" for="dateEnd" />
                                <x-input wire:model.defer="dateEnd" type="date" name="dateEnd"
                                    id="dateEnd" required autofocus autocomplete="dateEnd" />
                                <x-input-error for="dateEnd"></x-input-error>
                            </div>
                        </div>
                    </div>
                    <div name="footer" class="d-none text-right mt-2">
                        <x-danger-button class="mr-2" wire:click="generarArchivo()" wire:loading.attr="disabled">
                            Generar
                        </x-danger-button>
            
                        <x-secondary-button @click="modelOpen = false" wire:loading.attr="disabled">
                            Cancelar
                        </x-secondary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>