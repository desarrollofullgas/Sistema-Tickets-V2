<div>
    <div class="py-4 space-y-4">
        {{-- Filtros --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            {{-- Barra de Busqueda --}}
            <div>
                <x-input wire:model="search" type="text" class="w-auto" placeholder="Buscar manuales..." />
            </div>
            {{-- Acciones Masivas --}}
            @if ($checked)
                <x-dropdown align="right" width="60">
                    <x-slot name="trigger">
                        <button type="button"
                            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-black rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                            Seleccionados
                            <span
                                class="inline-flex items-center justify-center w-4 h-4 ms-2 ml-2 text-xs font-semibold text-gray-800 bg-gray-200 rounded-full">
                                {{ count($checked) }}
                            </span>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="w-60">
                            <!-- Encabezado -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Opciones') }}
                            </div>
                            <!-- Eliminar y Exportar-->
                            <div>
                                @if ($valid->pivot->de == 1)
                                    <x-dropdown-link href="#" wire:click="deleteManuals">
                                        {{ __('Eliminar Manual') }}
                                    </x-dropdown-link>
                                @endif
                            </div>
                        </div>
                    </x-slot>
                </x-dropdown>
            @endif
            {{-- Filtro de Fechas --}}
            <div class="hidden md:flex items-center justify-center overflow-auto">
                <div class="relative">
                    <input type="date" name="start" id="from_date" wire:model="from_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <span class="mx-4 text-gray-500">a</span>
                <div class="relative">
                    <input type="date" name="end" id="to_date" wire:model="to_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <button wire:click="clearDateFilters" class="mx-4 text-gray-500">x</button>
            </div>
        </div>
         {{-- Select All --}}
         <div class="flex items-center">
            <div class="relative w-full md:w-auto">
                <x-input type="checkbox" wire:model="selectPage" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"/>
				Seleccionar Todo
            </div>
        </div>
        @if ($selectPage)
            @if ($selectAll)
                <div class="text-gray-400 text-xs">
                    Se han seleccionado <strong>{{ $manuals->total() }}</strong> elementos.
                </div>
            @else
                <div class="text-gray-400 text-xs">
                    Se han seleccionado <strong>{{ count($checked) }}</strong> elementos, ¿Deseas seleccionar los
                    <strong>{{ $manuals->total() }}</strong>?
                    <a href="#" class="text-blue-500 hover:underline" wire:click="selectAll">Seleccionar todo</a>
                </div>
            @endif
        @endif


            {{-- Componente grid --}}
            <div class="grid grid-cols-2 gap-4" wire:loading.class.delay="opacity-75">
                @foreach ($manuals as $tem)
                    @foreach ($tem->permisos as $item)
                        @if ($item->pivot->permiso_id == Auth::user()->permiso_id)
                            <div class="relative p-4 mx-auto mt-2 w-full transform overflow-hidden rounded-lg bg-white dark:bg-dark-eval-1 shadow-md hover:shadow-lg">
                                <!-- Checkbox -->
                                <x-input type="checkbox" value="{{ $tem->id }}" wire:model="checked" class="absolute top-2 left-2 z-10 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"/>
                            
                                <!-- Contenedor principal -->
                                <div class="">
                                    <!-- Resto del contenido -->
                                    {{-- <a href="{{ asset('storage/' . $tem->manual_path) }}" target="_blank"></a> --}}
                                    <div class="flex items-center gap-2 px-4 font-bold">
                                        <div>
                                            @if ($tem->mime_type=='application/pdf')
                                                <x-icons.pdf class="w-6 h-6 text-red-500" />
                                            @elseif($tem->mime_type=='video/mp4')
                                                <x-icons.video class="w-6 h-6 text-pink-600" />
                                            @else
                                                <x-icons.unknow class="w-6 h-6 text-gray-500" />
                                            @endif
                                        </div>
                                        <a class="text-sm font-bold no-underline hover:underline hover:text-blue-500"
                                            href="{{ asset('storage/' . $tem->manual_path) }}" target="_blank">
                                            {{ __($tem->titulo_manual . ' (') }}
                                            @if (strlen($tem->size) == 3)
                                                {{ __(substr($tem->size, 0, 2) . ' ' . 'KB )') }}
                                            @elseif (strlen($tem->size) == 4)
                                                {{ __(substr($tem->size, 0, 1) . ' ' . 'KB )') }}
                                            @elseif (strlen($tem->size) == 5)
                                                {{ __(substr($tem->size, 0, 2) . ' ' . 'KB )') }}
                                            @elseif (strlen($tem->size) == 6)
                                                {{ __(substr($tem->size, 0, 3) . ' ' . 'KB )') }}
                                            @elseif (strlen($tem->size) == 7)
                                                {{ __(substr($tem->size, 0, 1) . ' ' . 'MB )') }}
                                            @elseif (strlen($tem->size) == 8)
                                                {{ __(substr($tem->size, 0, 2) . ' ' . 'MB )') }}
                                            @endif
                                        </a>
                                    </div>
                                    <div class="p-4 flex justify-between">
                                        <!-- Izquierda -->
                                        <div>
                                            <div class="flex items-center mt-3">
                                                <p class="font-medium text-xs text-gray-500 dark:text-white">{{ $tem->categoria }}</p>
                                            </div>
                                            <div class="flex items-center mt-3">
                                                <p class="font-medium text-xs text-gray-500 dark:text-white">{{ $tem->sub_categoria }}</p>
                                            </div>
                                        </div>
                                        <!-- Derecha -->
                                        <div>
                                            <div class="flex items-center mt-3">
                                                <p class="font-medium text-xs text-gray-500 dark:text-white">{{ $tem->user->name }}</p>
                                            </div>
                                            <div class="flex items-center mt-3">
                                                <p class="font-medium text-xs text-gray-500 dark:text-white">{{ $tem->created_at->locale('es')->isoFormat('D / MMMM / YYYY H:mm:ss a') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            
            </div>
            {{-- Paginación y contenido por página --}}
            <div class="py-4 px-3 bg-gray-800">
                <div class="flex space-x-4 items-center mb3">
                    <x-label class="text-sm font-medium text-white">Mostrar</x-label>
                    <select wire:model.live="perPage"
                        class="bg-gray-50 dark:bg-slate-800 border border-gray-300 text-gray-400 text-sm rounded-lg focus:ring-indigo-500">
                        <option value="6">6</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                {{ $manuals->links() }}
            </div>
        </div>
    </div>
