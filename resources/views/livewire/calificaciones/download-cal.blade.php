<div x-data="{modalOpen:false}">
    <x-button class="gap-2" @click="modalOpen=!modalOpen">
        <svg class="w-6 h-6" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
            <path d="M7 11l5 5l5 -5"></path>
            <path d="M12 4l0 12"></path>
         </svg>
         <span>Descargar reporte</span>
    </x-button>
    <div x-show="modalOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center md:items-center sm:p-0">
            <div x-cloak @click="modalOpen = false" x-show="modalOpen" 
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0" 
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100" 
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-gray-500 dark:bg-gray-700/75 bg-opacity-75" aria-hidden="true"
            ></div>
            <div x-cloak x-show="modalOpen" 
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block w-full max-w-xl p-6 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl dark:bg-dark-eval-1"
            >        
                <div class="flex items-center justify-between space-x-4">
                    <h1 class="text-xl font-medium">{{ __('Descargar Reporte') }}</h1>
                </div>
                <div class="flex justify-center py-3">
                    <div class="flex flex-wrap gap-3 justify-evenly items-center">
                        <div>
                            <x-label value="{{__('Fecha de inicio')}}"/>
                            <x-input type="date" wire:model='dateIn'/>
                            <x-input-error for="dateIn"></x-input-error>
                        </div>
                        <div>
                            <x-label value="{{__('Fecha de término')}}"/>
                            <x-input type="date" wire:model='dateEnd'/>
                            <x-input-error for="dateEnd"></x-input-error>
                        </div>
                    </div>
                </div>
                <div name="footer" class="flex flex-wrap justify-center sm:justify-end items-stretch gap-2 text-right mt-2">
                    <x-danger-button class="mr-2 flex gap-2" wire:click="genExcel()" wire:loading.attr="disabled">
                        <svg wire:loading.remove class="w-6 h-6" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                            <path d="M7 11l5 5l5 -5"></path>
                            <path d="M12 4l0 12"></path>
                         </svg>
                        <svg wire:loading class=" animate-spin w-6 h-6" viewBox="0 0 50 50" fill="currentColor">
                            <circle cx="25" cy="10" r="2"/>
                            <circle cx="25" cy="40" r="2" opacity=".3"/>
                            <circle cx="32.5" cy="12" r="2" opacity=".3"/>
                            <circle cx="17.5" cy="38" r="2" opacity=".3"/>
                            <circle cx="17.5" cy="12" r="2" opacity=".93"/>
                            <circle cx="32.5" cy="38" r="2" opacity=".3"/>
                            <circle cx="10" cy="25" r="2" opacity=".65"/>
                            <circle cx="40" cy="25" r="2" opacity=".3"/>
                            <circle cx="12" cy="17.5" r="2" opacity=".86"/>
                            <circle cx="38" cy="32.5" r="2" opacity=".3"/>
                            <circle cx="12" cy="32.5" r="2" opacity=".44"/>
                            <circle cx="38" cy="17.5" r="2" opacity=".3"/>
                        </svg>
                        <span>Aceptar</span> 
                    </x-danger-button>
        
                    <x-secondary-button @click="modalOpen = false" wire:loading.attr="disabled">
                        Cancelar
                    </x-secondary-button>
                </div>
            </div>
        </div>
    </div>
</div>
