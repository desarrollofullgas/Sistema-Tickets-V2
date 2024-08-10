<div>

    <button wire:click="confirmShowZona({{ $zona_show_id }})" wire:loading.attr="disabled" class="tooltip"
        data-target="ShowZona{{ $zona_show_id }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-indigo-500">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span class="tooltiptext">Ver Más</span>
    </button>

    <x-dialog-modal wire:model="ShowgZona" id="ShowZona{{ $zona_show_id }}" class="flex items-center">
        <x-slot name="title">
            <div class="bg-dark-eval-1 dark:bg-gray-600 p-1 rounded-md text-white text-center">
                {{ __('Información General de la Zona') }}
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="overflow-hidden max-h-80 overflow-y-auto">
                <div class="overflow-hidden max-h-96 overflow-y-auto mb-2">
                    <fieldset class="border dark:border-gray-500 p-2">
                        <legend class="font-bold">Detalles de la Zona</legend>
                        <div>
                            <span><strong>Nombre: </strong>{{ $this->name }}</span>
                            <span><strong>Gerentes:
                                </strong>{{ $this->gerent == null ? 'POR DEFINIR' : $this->gerent }}</span>
                                <span><strong>Supervisores:
                                </strong>{{ $this->supervi == null ? 'POR DEFINIR' : $this->supervi }}</span>
                        </div>
                        <div class="mt-2 flex flex-wrap gap-3">
                            <span><strong> Estaciones:
                                </strong>{{ $this->estacions == null ? 'POR DEFINIR' : $this->estacions }}</span>
                            <span><strong>Estado: </strong>{{ $this->status == null ? 'POR DEFINIR' : $this->status }}</span>
                            <span><strong>Fecha de Registro:
                                </strong>{{ $this->created_at == null ? 'POR DEFINIR' : $this->created_at }}</span>
                        </div>
                    </fieldset>
                </div>
                <div>
                    @if (!empty($db))
                        <div class="border rounded-lg overflow-hidden max-h-[320px] overflow-y-auto">
                            <details>
                                <summary class="bg-gray-100 dark:bg-gray-900 py-2 px-4 cursor-pointer">Click para
                                    mostrar/ocultar
                                    Gerentes</summary>
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2">Nombre</th>
                                            <th class="px-4 py-2">Estacion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $user)
                                            <tr>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs"> {{ $user->name }}</span>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs">
                                                        @if (empty($user->estacion->name))
                                                            <p class="text-red-500">
                                                                {{ __('Sin estación Asignada') }}
                                                            </p>
                                                        @else
                                                            {{ $user->estacion->name }}
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="border px-4 py-2" colspan="2">Sin datos.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </details>
                        </div>
                    @endif
                </div>
                <br>
                <div>
                    @if ($isSuper)
                        <div class="border rounded-lg overflow-hidden max-h-[320px] overflow-y-auto">
                            <details>
                                <summary class="bg-gray-100 dark:bg-gray-900 py-2 px-4 cursor-pointer">Click para
                                    mostrar/ocultar
                                    Supervisores</summary>
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2">Nombre</th>
                                            <th class="px-4 py-2">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($isSuper as $super)
                                            <tr>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs"> {{ $super->name }} </span>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs">
                                                        @if ($super->status == 'Activo')
                                                            <i class="text-green-500"></i>
                                                            {{ $super->status }}
                                                        @else
                                                            <i class="text-red-500"></i>
                                                            {{ $super->status }}
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="border px-4 py-2" colspan="2">Sin datos.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </details>
                        </div>
                    @endif
                </div>
                <br>
                <div>
                    @if ($estaciones->isnotEmpty())
                        <div class="border rounded-lg overflow-hidden max-h-[320px] overflow-y-auto">
                            <details>
                                <summary class="bg-gray-100 dark:bg-gray-900 py-2 px-4 cursor-pointer">Click para
                                    mostrar/ocultar
                                    Estaciones</summary>
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2">Nombre</th>
                                            <th class="px-4 py-2">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($estaciones as $estacion)
                                            <tr>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs"> {{ $estacion->name }} </span>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs">
                                                        @if ($estacion->status == 'Activo')
                                                            <i class="text-green-500"></i>
                                                            {{ $estacion->status }}
                                                        @else
                                                            <i class="text-red-500"></i>
                                                            {{ $estacion->status }}
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="border px-4 py-2" colspan="2">Sin datos.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </details>
                        </div>
                    @endif
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-secondary-button wire:click="$toggle('ShowgZona')" wire:loading.attr="disabled">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
