<div x-data="{ modelOpen: false }">
    <button @click="modelOpen =!modelOpen" wire:loading.attr="disabled" aria-label="reasignar-usuario" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-indigo-500 transition duration-300">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
        <span class="tooltiptext">Editar</span>
    </button>
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
                class="inline-block w-full max-w-3xl p-6 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-3xl dark:bg-dark-eval-1"
            >        
                <div class="flex items-center justify-between space-x-4">
                    <h1 class="text-xl font-medium">{{ __('Editar correos para "Servicios"') }}</h1>
                </div>
                <div class="py-3 flex flex-col gap-1">
                    <x-card-warn>
                        Seleccione los correos a eliminar
                    </x-card-warn>
                    <div class="pt-1 pb-3 flex flex-col gap-2 max-h-[1020px] overflow-y-auto">
                        @foreach ($zonas as $zona)
                            <div class="border rounded-md overflow-hidden dark:border-slate-500">
                                <div class="px-2 py-1 w-full bg-slate-500 text-white">
                                    <h2 class="font-bold text-lg">{{$zona->zona->name}}</h2>
                                </div>
                                <div class="p-2 flex flex-wrap gap-2 justify-center">
                                    @foreach ($correos as $email)
                                        @if ($email->zona_id == $zona->zona_id)
                                        <label for="Serv{{$zona->zona_id}}{{$email->correo->correo}}" class="cursor-pointer flex items-center justify-center gap-2 rounded-full px-2 py-1 bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300">
                                            <input  id="Serv{{$zona->zona_id}}{{$email->correo->correo}}" type="checkbox" wire:model.defer="mailsDelete" value="{{$email->id}}" class="w-4 h-4 text-yellow-400 bg-amber-100 border-amber-300 rounded-full focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-amber-600 focus:ring-2 dark:bg-amber-700 dark:border-amber-500">     
                                            <span>{{$email->correo->correo}}</span>
                                        </label>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div name="footer" class="d-none text-right mt-1">
                    <x-danger-button class="mr-2" wire:click="updateAsignacion()" wire:loading.attr="disabled">
                        Actualizar
                    </x-danger-button>
        
                    <x-secondary-button @click="modelOpen = false" wire:loading.attr="disabled">
                        Cancelar
                    </x-secondary-button>
                </div>
            </div>
        </div>
    </div>
</div>