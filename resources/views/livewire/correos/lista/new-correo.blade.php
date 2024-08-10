<div x-data="{ modelOpen: false }">
    <x-button @click="modelOpen =!modelOpen" wire:loading.attr="disabled" aria-label="añadir tipo" class="dark:border-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700">
        <i class="fa-solid fa-plus"></i>
        {{ __('Añadir correo') }}
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
                    <h1 class="text-xl font-medium">{{ __('Nuevo correo') }}</h1>
                </div>
                <div>
                    <div class="flex flex-wrap gap-3 justify-evenly items-center py-2">
                        <div>
                            <x-label value="{{ __('Correo electrónico') }}" for="correo" />
                            <x-input wire:model.defer="correo" type="email" name="correo"
                                id="correo" required autofocus autocomplete="correo" />
                            <x-input-error for="correo"></x-input-error>
                        </div>
                    </div>
                    <div name="footer" class="d-none text-right mt-2">
                        <x-danger-button class="mr-2" wire:click="addCorreo" wire:loading.attr="disabled">
                            Aceptar
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