<div>
    <div class="py-4 space-y-4">
        {{-- Filtros --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            {{-- Barra de Busqueda --}}
            <div>
                <x-input wire:model="search" type="text" class="w-auto" placeholder="Buscar usuarios..." />
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
                                    <x-dropdown-link href="#" wire:click="deleteUsuarios">
                                        {{ __('Eliminar Usuario') }}
                                    </x-dropdown-link>
                                @endif
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
                    Se han seleccionado <strong>{{ $usuarios->total() }}</strong> elementos.
                </div>
            @else
                <div class="text-gray-400 text-xs">
                    Se han seleccionado <strong>{{ count($checked) }}</strong> elementos, ¿Deseas seleccionar los
                    <strong>{{ $usuarios->total() }}</strong>?
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
                    <x-heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null">USUARIO</x-heading>
                    <x-heading >ZONA/ÁREA</x-heading>
                    <x-heading >DISPONIBILIDAD</x-heading>
                    <x-heading sortable wire:click="sortBy('status')" :direction="$sortField === 'status' ? $sortDirection : null">ESTADO</x-heading>
                    <x-heading>OPCIONES</x-heading>
                </x-slot>
                <x-slot name="body">
                    @forelse($usuarios as $user)
                    {{-- Componente Row --}}
                    <x-row wire:loading.class.delay="opacity-75">
                        {{-- Componente Column --}}
                        <x-cell> <x-input type="checkbox" value="{{ $user->id }}" wire:model="checked" />
                        </x-cell>
                        <x-cell>{{ $user->id }} </x-cell>
                        <x-cell class="flex gap-3 px-6 py-6 font-normal">
                            <div class="relative h-10 w-10">
                                @if ($user->profile_photo_path)
                                    <div
                                        onclick="window.location.href='{{ asset('/storage/' . $user->profile_photo_path) }}'">
                                        <img class="h-10 w-10 rounded-full object-cover"
                                            src="/storage/{{ $user->profile_photo_path }}"
                                            alt="{{ $user->name }}" />
                                    </div>
                                @else
                                    <div onclick="window.location.href='{{ asset($user->profile_photo_url) }}'">
                                        <img class="object-cover w-10 h-10 rounded-full"
                                            src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
                                    </div>
                                @endif
                                @if (Cache::has('user-is-online-' . $user->id))
                                    <span
                                        class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-green-400 ring ring-white"></span>
                                @else
                                    <span
                                        class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-red-600 ring ring-white"></span>
                                @endif
                            </div>
                            <div class="text-sm">
                                <div class="font-bold">{{ $user->name }}</div>
                                <div class="text-gray-400">{{ $user->permiso->titulo_permiso }}</div>
                            </div>
                        </x-cell>
                        <x-cell><div class="flex flex-wrap">
                            {{-- @if ($user->zonas->count() > 0) --}}
                            @foreach ($user->zonas as $zona)
                                <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-2 py-1 text-xs font-semibold text-indigo-600 dark:bg-gray-300 dark:text-gray-900" style="margin-bottom: 5px;">
                                            {{ $zona->name }}
                                        </span>
                            @endforeach
                        {{-- @else --}}
                            @foreach ($user->areas as $area)
                                <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-2 py-1 text-xs font-semibold text-indigo-600 dark:bg-gray-300 dark:text-gray-800" style="margin-bottom: 5px;">
                                    {{ $area->name }}
                                </span>
                            @endforeach
                        {{-- @endif --}}
                        </div></x-cell>
                        <x-cell>@if (Cache::has('user-is-online-' . $user->id))
                            <span
                                class="inline-flex items-center m-2 px-3 py-1 bg-green-200 rounded-full text-sm font-semibold text-green-600  dark:bg-green-900 dark:text-green-300">
                                <span class="ml-1">
                                    Online
                                </span>
                            </span>
                        @else
                            <span
                                class="inline-flex items-center m-2 px-2 py-1 bg-gray-200 rounded-full text-sm font-semibold text-gray-600  dark:bg-gray-900 dark:text-gray-300">
                                <span class="ml-1">
                                    Offline
                                </span>
                            </span>
                            <br>
                            @if ($user->last_seen)
                                <span class="dark:text-gray-400 text-xs">
                                    Últ. vez: {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
                                </span>
                            @endif
                        @endif</x-cell>
                        <x-cell>
                            <div
                                class="rounded bg-{{ $user->status_color }}-200 py-1 px-3 text-xs text-{{ $user->status_color }}-500 font-bold dark:bg-green-900 dark:text-green-300">
                                {{ $user->status }}
                            </div>
                        </x-cell>
                        <x-cell>
                            <div class="flex gap-2 justify-center items-center">
                                <div>
                                    @if ($valid->pivot->ed == 1)
                                        @livewire('usuarios.user-edit', ['user_edit_id' => $user->id], key('ed'.$user->id))
                                    @endif
                                </div>
                                <div>
                                    @if ($valid->pivot->vermas == 1)
                                        @livewire('usuarios.show-user', ['user_show_id' => $user->id], key('show'.$user->id))
                                    @endif
                                </div>
                                <div>
                                    @if ($valid->pivot->de == 1)
                                        @livewire('usuarios.user-delete', ['userID' => $user->id], key('del'.$user->id))
                                    @endif
                                </div>
                            </div>
                        </x-cell>
                    </x-row>
                @empty
                    <x-row>
                        <x-cell colspan="7">
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
                        class="bg-gray-50 border border-gray-300 text-gray-400 text-sm rounded-lg focus:ring-indigo-500">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                {{ $usuarios->links() }}
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
            @forelse($usuarios as $user)
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
                                                @livewire('usuarios.user-edit', ['user_edit_id' => $user->id], key('edit'.$user->id))
                                            @endif
                                        </div>
                                        <div>
                                            @if ($valid->pivot->vermas == 1)
                                                @livewire('usuarios.show-user', ['user_show_id' => $user->id], key('showuser'.$user->id))
                                            @endif
                                        </div>
                                        <div>
                                            @if ($valid->pivot->de == 1)
                                                @livewire('usuarios.user-delete', ['userID' => $user->id], key('delete'.$user->id))
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 text-sm">
                        <div class="font-bold">#{{ $user->id }}</div>
                        <div class="truncate class flex gap-3 px-6 py-4 font-normal">
                            <div class="relative h-10 w-10">
                                @if ($user->profile_photo_path)
                                    <div
                                        onclick="window.location.href='{{ asset('/storage/' . $user->profile_photo_path) }}'">
                                        <img class="h-10 w-10 rounded-full object-cover"
                                            src="/storage/{{ $user->profile_photo_path }}"
                                            alt="{{ $user->name }}" />
                                    </div>
                                @else
                                    <div onclick="window.location.href='{{ asset($user->profile_photo_url) }}'">
                                        <img class="object-cover w-10 h-10 rounded-full"
                                            src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
                                    </div>
                                @endif
                                @if (Cache::has('user-is-online-' . $user->id))
                                    <span
                                        class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-green-400 ring ring-white"></span>
                                @else
                                    <span
                                        class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-red-600 ring ring-white"></span>
                                @endif
                            </div>
                            <div class="text-sm">
                                <div class="font-bold">{{ $user->name }}</div>
                                <div class="text-gray-400">{{ $user->permiso->titulo_permiso }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-4 justify-center items-center md:flex-row md:items-center md:justify-center ">
                        <span
                            class="rounded bg-{{ $user->status_color }}-200 py-1 px-3 text-xs text-{{ $user->status_color }}-500 font-bold">
                            {{ $user->status }}
                        </span>
                        <div>
                            @if (Cache::has('user-is-online-' . $user->id))
                            <span
                                class="inline-flex items-center m-2 px-3 py-1 bg-green-200 rounded-full text-sm font-semibold text-green-600  dark:bg-green-900 dark:text-green-300">
                                <span class="ml-1">
                                    Online
                                </span>
                            </span>
                        @else
                            <span
                                class="inline-flex items-center m-2 px-2 py-1 bg-gray-200 rounded-full text-sm font-semibold text-gray-600  dark:bg-gray-900 dark:text-gray-300">
                                <span class="ml-1">
                                    Offline
                                </span>
                            </span>
                            <br>
                            @if ($user->last_seen)
                                <span class="dark:text-gray-400 text-xs">
                                    Últ. vez: {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
                                </span>
                            @endif
                        @endif
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
                {{ $usuarios->links() }}
            </div>
        </div>
    </div>
</div>
