<div>
    <div class="py-4 space-y-4">
        {{-- Filtros --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            {{-- Barra de Busqueda --}}
            <div>
                <x-input wire:model="search" type="text" class="w-auto" placeholder="Buscar en almacen..." />
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
                                {{-- @if ($valid->pivot->de == 1)
                                    <x-dropdown-link href="#" wire:click="deleteAlmacenes">
                                        {{ __('Eliminar Almacén') }}
                                    </x-dropdown-link>
                                @endif --}}
                                <x-dropdown-link href="#" wire:click="exportSelected">
                                    {{ __('Exportar a Excel') }}
                                </x-dropdown-link>
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
        @if ($selectPage)
            @if ($selectAll)
                <div class="text-gray-400 text-xs">
                    Se han seleccionado <strong>{{ $almacenes->total() }}</strong> elementos.
                </div>
            @else
                <div class="text-gray-400 text-xs">
                    Se han seleccionado <strong>{{ count($checked) }}</strong> elementos, ¿Deseas seleccionar los
                    <strong>{{ $almacenes->total() }}</strong>?
                    <a href="#" class="text-blue-500 hover:underline" wire:click="selectAll">Seleccionar todo</a>
                </div>
            @endif
        @endif

        <div class="overflow-auto rounded-lg shadow hidden md:block">
            {{-- Componente tabla --}}
            <x-table>
                <x-slot name="head">
                    {{-- Componente Heading  --}}
                    <x-heading><x-input type="checkbox" wire:model="selectPage" /></x-heading>
                    <x-heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">ID</x-heading>
                    <x-heading>IMAGEN</x-heading>
                    <x-heading sortable wire:click="sortBy('producto_id')" :direction="$sortField === 'producto_id' ? $sortDirection : null">PRODUCTO</x-heading>
                    <x-heading sortable wire:click="sortBy('stock')" :direction="$sortField === 'stock' ? $sortDirection : null">STOCK ACTUAL</x-heading>
                    <x-heading sortable wire:click="sortBy('stock_base')" :direction="$sortField === 'stock' ? $sortDirection : null">STOCK BASE</x-heading>
                    <x-heading sortable wire:click="sortBy('updated_at')" :direction="$sortField === 'updated_at' ? $sortDirection : null">FECHA
                        ACTUALIZACIÓN</x-heading>
                    <x-heading sortable>OPCIONES</x-heading>
                </x-slot>
                <x-slot name="body">
                    @forelse($almacenes as $alm)
                        {{-- Componente Row --}}
                        <x-row wire:loading.class.delay="opacity-75">
                            {{-- Componente Column --}}
                            <x-cell> <x-input type="checkbox" value="{{ $alm->id }}" wire:model="checked" />
                            </x-cell>
                            <x-cell>{{ $alm->id }} </x-cell>
                            <x-cell>
                                <div class="w-full flex justify-center gap-2">
                                    <figure class="w-16 rounded-full flex items-center justify-center overflow-hidden">
                                        <img src="{{ asset('storage/' . $alm->producto->product_photo_path) }}"
                                            alt="imagen producto" class="w-full object-cover">
                                    </figure>
                                </div>
                            </x-cell>
                            <x-cell class="font-bold">{{ $alm->producto->name }}</x-cell>
                            <x-cell> {{ $alm->stock }} </x-cell>
                            <x-cell>{{ $alm->stock_base }} </x-cell>
                            <x-cell> {{ $alm->updated_at->locale('es')->isoFormat('D  MMMM  YYYY') }}
                            </x-cell>
                            <x-cell>
                                <div class="flex gap-2 justify-center items-center">
                                    @if ($valid->pivot->ed == 1)
                                        @livewire('productos.almacen.edit-almacen', ['idAlma' => $alm->id], key('edit' . $alm->id))
                                    @endif
                                    @if ($valid->pivot->de == 1)
                                        @livewire('productos.almacen.delete-almacen', ['idAlma' => $alm->id], key('del' . $alm->id))
                                    @endif
                                </div>
                            </x-cell>
                        </x-row>
                    @empty
                        <x-row>
                            <x-cell colspan="8">
                                <div class="flex justify-center items-center space-x-2">
                                    <x-icons.inbox class="w-8 h-8 text-gray-300" />
                                    <span class="py-8 font-medium text-gray-400 text-xl">No se encontraron
                                        resultados...</span>
                                </div>
                            </x-cell>
                        </x-row>
                    @endforelse
                </x-slot>
            </x-table>
            {{-- Paginación y contenido por página --}}
            <div class="py-4 px-3 bg-gray-800">
                <div class="flex space-x-4 items-center mb3">
                    <x-label class="text-sm font-medium text-white">Mostrar</x-label>
                    <select wire:model.live="perPage"
                        class="bg-gray-50 dark:bg-slate-800 border border-gray-300 text-gray-400 text-sm rounded-lg focus:ring-indigo-500">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                {{ $almacenes->links() }}
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
            @forelse($almacenes as $categoria)
                <div class="bg-white dark:bg-slate-800 space-y-3 p-4 rounded-lg shadow">
                    <div class="flex float-right">
                        <div x-data="{ open: false }">
                            <div class="relative inline-block text-left">
                                <div>
                                    <button @click="open = !open" type="button"
                                        class="inline-flex w-full justify-center gap-x-1.5 p-2 text-sm font-semibold text-gray-900 dark:text-gray-400 hover:text-blue-500 dark:hover:text-indigo-500"
                                        :aria-expanded="open.toString()" aria-haspopup="true">
                                        <svg class="w-10 h-10" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="1.5"
                                                d="M12.25 12h-.5m.5-4h-.5m.5 8h-.5" />
                                        </svg>
                                    </button>
                                </div>

                                <div x-show="open" @click.away="open = false"
                                    class="absolute right-0 z-10 w-56 origin-top-right rounded-md bg-gray-100 p-2 dark:bg-slate-800 overflow-auto"
                                    role="menu" aria-orientation="vertical" aria-labelledby="menu-button"
                                    tabindex="-1">
                                    <div class="flex gap-2 justify-center items-center">
                                        <div>
                                            @if ($valid->pivot->ed == 1)
                                            @livewire('productos.almacen.edit-almacen', ['idAlma' => $alm->id], key('editar' . $alm->id))
                                        @endif
                                        </div>
                                        <div>
                                            @if ($valid->pivot->de == 1)
                                            @livewire('productos.almacen.delete-almacen', ['idAlma' => $alm->id], key('delete' . $alm->id))
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 text-sm">
                        <div class="font-bold">#{{ $categoria->id }}</div>
                        <div class="font-bold truncate">
                            {{ $categoria->producto->name }}
                        </div>
                    </div>
                    <div class="flex gap-4 justify-center items-center md:flex-row md:items-center md:justify-center ">
                        <div>
                            {{ $categoria->updated_at->locale('es')->isoFormat('D  MMMM  YYYY') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex justify-center items-center space-x-2">
                    <x-icons.inbox class="w-8 h-8 text-gray-300" />
                    <span class="py-8 font-medium text-gray-400 text-xl">No se encontraron
                        resultados...</span>
                </div>
            @endforelse

            <div class="py-4 px-3">
                <div class="flex space-x-4 items-center mb-3">
                    <x-label class="text-sm font-medium text-gray-600">Mostrar</x-label>
                    <select wire:model.live="perPage"
                        class="bg-gray-50 dark:bg-slate-800 border border-gray-300 text-gray-400 text-sm rounded-lg focus:ring-indigo-500">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                {{ $almacenes->links() }}
            </div>
        </div>
    </div>
</div>
