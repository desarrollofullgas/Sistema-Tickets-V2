<div>
    <div class="py-4 space-y-4">
        {{-- Filtros --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            {{-- Barra de Busqueda --}}
            <div>
                <x-input wire:model="search" type="text" class="w-auto" placeholder="Buscar tipos compra..." />
            </div>
            {{-- Filtro de Fechas --}}
            <div class="hidden md:flex items-center justify-center overflow-auto">
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input type="date" name="start" id="from_date" wire:model="from_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <span class="mx-4 text-gray-500">a</span>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input type="date" name="end" id="to_date" wire:model="to_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <button wire:click="clearDateFilters" class="mx-4 text-gray-500">x</button>
            </div>
        </div>

        <div class="overflow-auto rounded-lg shadow hidden md:block">
            {{-- Componente tabla --}}
            <x-table>
                <x-slot name="head">
                    {{-- Componente Heading  --}}
                    <x-heading sortable>TIPO COMPRA</x-heading>
                    <x-heading sortable>CORREOS ASIGNADOS</x-heading>
                    <x-heading sortable>OPCIONES</x-heading>
                </x-slot>
                <x-slot name="body">
                    @if ($correos->count() > 0)
                        @forelse($categorias as $mail)
                            {{-- Componente Row --}}
                            <x-row wire:loading.class.delay="opacity-75">
                                {{-- Componente Column --}}
                                <x-cell class="font-bold">{{ $mail->name }}</x-cell>
                                <x-cell> {{ $mail->correos->count() }}
                                </x-cell>
                                <x-cell>
                                    <div class="flex gap-2 justify-center items-center">
                                        @if ($valid->pivot->vermas == 1)
                                            @livewire('correos.asignados.show-asignados', ['categoriaID' => $mail->id], key('show' . $mail->id))
                                        @endif
                                        @if ($mail->correos->count() > 0)
                                            @if ($valid->pivot->ed == 1)
                                                @livewire('correos.asignados.edit-asignacion', ['categoriaID' => $mail->id], key('edit' . $mail->id))
                                            @endif
                                        @endif
                                    </div>
                                </x-cell>
                            </x-row>
                        @empty
                            <x-row>
                                <x-cell colspan="6">
                                    <div class="flex justify-center items-center space-x-2">
                                        <x-icons.inbox class="w-8 h-8 text-gray-300" />
                                        <span class="py-8 font-medium text-gray-400 text-xl">No se encontraron
                                            resultados...</span>
                                    </div>
                                </x-cell>
                            </x-row>
                        @endforelse
                    @endif
                    @if ($servs)
                        <x-row wire:loading.class.delay="opacity-75">
                            <x-cell class="font-bold">SERVICIOS</x-cell>
                            <x-cell>{{ $servs }}</x-cell>
                            <x-cell>
                                <div class="flex gap-2 justify-center items-center">
                                    @if ($valid->pivot->vermas == 1)
                                        @livewire('correos.asignados.show-correos-servicio', key('Servicios'))
                                    @endif
                                    @if ($valid->pivot->ed == 1)
                                        @livewire('correos.asignados.edit-correos-servicio', key('EditarServicios'))
                                    @endif
                                </div>
                            </x-cell>
                        </x-row>
                    @endif

                </x-slot>
            </x-table>
            {{-- Paginación y contenido por página --}}
            <div class="py-4 px-3 bg-gray-800">
                <div class="flex space-x-4 items-center mb3">
                    <x-label class="text-sm font-medium text-white">Mostrar</x-label>
                    <select wire:model.live="perPage"
                        class="bg-gray-50 dark:bg-slate-800 border border-gray-300 text-gray-400 text-sm rounded-lg focus:ring-indigo-500">
                        
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                {{ $categorias->links() }}
            </div>
        </div>


        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
            @if ($correos->count() > 0)
                @forelse($categorias as $mail)
                    <div class="bg-white dark:bg-slate-900 space-y-3 p-4 rounded-lg shadow">
                        <div class="flex float-right">
                            <div x-data="{ open: false }">
                                <div class="relative inline-block text-left">
                                    <div>
                                        <button @click="open = !open" type="button"
                                            class="inline-flex w-full justify-center gap-x-1.5 p-2 text-sm font-semibold text-gray-900 dark:text-gray-400 hover:text-blue-500 dark:hover:text-indigo-500"
                                            :aria-expanded="open.toString()" aria-haspopup="true">
                                            <svg class="w-10 h-10" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
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
                                            @if ($valid->pivot->vermas == 1)
                                                @livewire('correos.asignados.show-asignados', ['categoriaID' => $mail->id], key('showmail' . $mail->id))
                                            @endif
                                            @if ($mail->correos->count() > 0)
                                                @if ($valid->pivot->ed == 1)
                                                    @livewire('correos.asignados.edit-asignacion', ['categoriaID' => $mail->id], key('editmail' . $mail->id))
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 text-sm">
                            <div class="font-bold truncate">
                                {{ $mail->name }}
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
            @endif
            @if ($servs)
                <div class="bg-white dark:bg-slate-900 space-y-3 p-4 rounded-lg shadow">
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
                                        @if ($valid->pivot->vermas == 1)
                                            @livewire('correos.asignados.show-correos-servicio', key('ServiciosMail'))
                                        @endif
                                        @if ($valid->pivot->ed == 1)
                                            @livewire('correos.asignados.edit-correos-servicio', key('EditarServiciosMail'))
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 text-sm">
                        <div class="font-bold truncate">
                            {{ __('SERVICIOS') }}
                        </div>
                    </div>
                </div>
            @endif

            <div class="py-4 px-3">
                <div class="flex space-x-4 items-center mb-3">
                    <x-label class="text-sm font-medium text-gray-600">Mostrar</x-label>
                    <select wire:model.live="perPage"
                        class="bg-gray-50 dark:bg-slate-800 border border-gray-300 text-gray-400 text-sm rounded-lg focus:ring-indigo-500">
                        
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                {{ $categorias->links() }}
            </div>
        </div>
    </div>
</div>
