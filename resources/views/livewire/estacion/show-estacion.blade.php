<div>

    <button wire:click="confirmShowEstacion({{ $estacion_show_id }})" wire:loading.attr="disabled"
        class="tooltip" data-target="ShowEstacion{{ $estacion_show_id }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-indigo-400">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span class="tooltiptext">Ver Más</span>
    </button>

    <x-dialog-modal wire:model="ShowgEstacion" id="ShowEstacion{{ $estacion_show_id }}" class="flex items-center">
        <x-slot name="title">
            <div class="bg-dark-eval-1 dark:bg-gray-600 p-2 rounded-md text-white text-center">
                {{ __('Información de la Estación') }}
            </div>
        </x-slot>

        <x-slot name="content">
            {{-- <div class="w-full rounded overflow-hidden shadow-lg">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2 ">{{ $this->titulo_estacion }}</div>
                    <div class="font-bold text-sm mb-2 ">No. {{ $this->numero }}</div>
                    <div class="px-2">
                        <div class="flex -mx-2 bg-gray-300 p-2 rounded-md">
                            <div class="w-1/3 px-2">
                                <span class="dark:text-black">Gerente: </span>
                                @if ($gerentestat == 'Inactivo')
                                    <p class="text-red-500">
                                        <span class="text-xs">{{ $this->gerente }}</span>
                                    </p>
                                @else
                                    <span class="text-xs dark:text-black"> {{ $this->gerente }}</span>
                                @endif
                            </div>
                            <div class="w-1/3 px-2">
                                <span class="dark:text-black">Supervisor:</span>
                                @if ($supervisorstat == 'Inactivo')
                                    <p class="text-red-500">
                                        <span class="text-xs"> {{ $this->supervisor }}</span>
                                    </p>
                                @else
                                    <span class="text-xs dark:text-black"> {{ $this->supervisor }}</span>
                                @endif
                            </div>
                            <div class="w-1/3 px-2">
                                <span class="dark:text-black">Status:</span>
                                <span class="text-xs dark:text-black">{{ $this->status }}</span>
                            </div>
                            <div class="w-1/3 dark:text-black"> Registro:</span>
                                <span class="text-xs dark:text-black">{{ $this->created_at }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-6 pt-4 pb-2">
                    <span class="text-indigo-500 font-bold">Zona:</span>
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#{{ $this->zonas }}</span>
                </div>
                <img class="w-full" src="{{ asset('img/logo/fullpower.png') }}" alt="">
            </div> --}}
            <div class="overflow-hidden max-h-96 overflow-y-auto">
                <fieldset class="border dark:border-gray-500 p-2">
                    <legend class="font-bold">Detalles de la Estación</legend>
                    <div>
                        <span><strong>Estación: </strong>{{$this->titulo_estacion}}</span>
                        <span><strong>Numero Estación: </strong>{{$this->numero==null?'POR DEFINIR':$this->numero}}</span>
                    </div>
                    <div class="mt-2 flex flex-wrap gap-3">
						<span><strong>Correo: </strong>{{$this->mail==null?'POR DEFINIR':$this->mail}}</span>
                        <span><strong>Gerente: </strong>{{$this->gerente==null?'POR DEFINIR':$this->gerente}}</span>
                        <span><strong>Supervisor: </strong>{{$this->supervisor==null?'POR DEFINIR':$this->supervisor}}</span>
                        <span><strong>Zonas: </strong>{{$this->zonas==null?'POR DEFINIR':$this->zonas}}</span>
                    </div>
                </fieldset>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-secondary-button wire:click="$toggle('ShowgEstacion')" wire:loading.attr="disabled">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
