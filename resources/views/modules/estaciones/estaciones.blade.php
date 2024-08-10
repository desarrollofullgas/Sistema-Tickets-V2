<x-app-layout>
    @section('title', 'Estaciones')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet-header>
                {{ __('ESTACIONES') }}
            </x-card-greet-header>
            <div class=" flex justify-center space-x-2">
                @if ($valid->pivot->wr == 1)
                    <div>
                        @livewire('estacion.estacion-create')
                    </div>
                @endif
                @if ($valid->pivot->verpap == 1)
                    <div>
                        <a class="inline-flex items-center px-3 py-2.5 text-sm font-medium text-center float-right text-white bg-gray-400 rounded-lg hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-dark-eval-3 "
                            href="{{ route('estaciones.trashed') }}">
                            Eliminados
                            <span
                                class="inline-flex items-center justify-center w-4 h-4 ml-2 text-xs font-semibold text-black bg-white rounded-full">
                                {{ $trashed }}
                            </span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    {{-- <div
        class="p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md lg:flex-row md:justify-between dark:bg-dark-eval-1">
        <div class="w-full">
            <div class="flex gap-1 flex-col mb-3">
                <form action="{{ route('estaciones') }}" method="GET">
                    <div class="flex">
                        <div class="relative mr-4">
                            <label for="filter" class="sr-only">Filtrar por zona</label>
                            <select name="filter" id="filter"
                                class="block w-full p-3 pl-10 text-sm border-gray-200 rounded-md focus:border-gray-500 focus:ring-gray-500 dark:bg-dark-eval-0 dark:border-gray-700 dark:text-white">
                                <option value="">Todos</option>
                                @foreach ($zonas as $zona)
                                    <option value="{{ $zona->id }}"
                                        {{ request('filter') == $zona->id ? 'selected' : '' }}>{{ $zona->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute top-0 left-0 mt-3 ml-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6 8H2a2 2 0 00-2 2v12a2 2 0 002 2h4a2 2 0 002-2V10a2 2 0 00-2-2zm0 0V4a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h12m-6 0a2 2 0 00-2 2v8a2 2 0 002 2h4a2 2 0 002-2v-8a2 2 0 00-2-2h-4a2 2 0 00-2 2z"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <table
                class="border-collapse w-full  bg-white text-center text-sm   dark:bg-dark-eval-0 dark:text-gray-400">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Nombre</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Gerente</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Supervisor</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Zona</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Fecha de Registro</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Status</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Opciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                    @forelse ($estaciones as $estacion)
                        <tr>
                            <td
                                class="w-full lg:w-auto p-3  text-center border border-b block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Nombre</span>
                                <div class="text-sm">
                                    <div class="font-medium uppercase">{{ $estacion->name }}</div>
                                </div>
                            </td>
                            <td
                                class="w-full lg:w-auto p-3  text-center border border-b  block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Gerente</span>
                                @if ($estacion->user_id != 0 || $estacion->user_id != null)
                                    @if ($estacion->user->permiso_id == 3 && $estacion->user->status == 'Activo')
                                        {{ $estacion->user->name }}
                                    @else
                                        <p class="text-danger p-0 m-0">
                                            {{ $estacion->user->name }}
                                            <span class="inline-block" tabindex="0" data-bs-toggle="popover"
                                                data-bs-trigger="hover focus"
                                                data-bs-content="Este gerente ha sido movido a la papelera"
                                                data-bs-placement="top">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-4 h-4 text-blue-400">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                        </p>
                                    @endif
                                @else
                                    <p class="text-red-500">
                                        {{ __('Sin Gerente') }}
                                    </p>
                                @endif
                            </td>
                            <td
                                class="w-full lg:w-auto p-3  text-center border border-b  block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Supervisor</span>
                                @if ($estacion->supervisor_id != 0 || $estacion->supervisor_id != null)
                                    @if ($estacion->supervisor->permiso_id == 2 && $estacion->supervisor->status == 'Activo')
                                        {{ $estacion->supervisor->name }}
                                    @else
                                        <p class="text-danger p-0 m-0">
                                            {{ $estacion->supervisor->name }}
                                            <span class="inline-block" tabindex="0" data-bs-toggle="popover"
                                                data-bs-trigger="hover focus"
                                                data-bs-content="Este supervisor ha sido movido a la papelera"
                                                data-bs-placement="top">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-4 h-4 text-blue-400">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                        </p>
                                    @endif
                                @else
                                    <p class="text-red-500">
                                        {{ __('Sin Supervisor') }}
                                    </p>
                                @endif
                            </td>
                            <td
                                class="w-full lg:w-auto p-3  text-center border border-b  block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Zona</span>
                                @if ($estacion->zona->status == 'Inactivo')
                                    <p class="text-red-500">
                                        {{ $estacion->zona->name }}
                                        <span class="inline-block" tabindex="0" data-bs-toggle="popover"
                                            data-bs-trigger="hover focus"
                                            data-bs-content="Esta zona ha sido movida a la papelera"
                                            data-bs-placement="top">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="w-4 h-4 text-blue-400">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </p>
                                @else
                                    {{ $estacion->zona->name }}
                                @endif
                            </td>
                            <td
                                class="w-full lg:w-auto p-3  text-center border border-b  block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Fecha</span>
                                {{ $estacion->created_at->locale('es')->isoFormat('D / MMMM / YYYY H:mm:ss a') }}
                            </td>
                            <td
                                class="w-full lg:w-auto p-3  text-center border border-b  block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Status</span>
                                @if ($estacion->status == 'Activo')
                                    <span
                                        class="rounded bg-green-200 py-1 px-3 text-xs text-green-500 font-bold">{{ $estacion->status }}</span>
                                @else
                                    <span
                                        class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold">{{ $estacion->status }}</span>
                                @endif
                            </td>
                            <td class="w-full lg:w-auto p-3  border border-b block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Opciones</span>
                                <div class="flex justify-end gap-4">
                                    <div>
                                        @if ($valid->pivot->vermas == 1)
                                            @livewire('estacion.show-estacion', ['estacion_show_id' => $estacion->id])
                                        @endif
                                    </div>
                                    <div>
                                        @if ($valid->pivot->ed == 1)
                                            @livewire('estacion.estacion-edit', ['estacion_id' => $estacion->id])
                                        @endif
                                    </div>
                                    <div>
                                        @if ($valid->pivot->de == 1)
                                            @livewire('estacion.estacion-delete', ['estaID' => $estacion->id])
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static"
                                colspan="7">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Sin
                                    registros</span>
                                No hay estaciones en el sistema
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-2">
                {{ $estaciones->appends($_GET)->links() }}
            </div>
        </div>
    </div> --}}
    <div>
        @livewire('estacion.estacion-table')
    </div>

</x-app-layout>
