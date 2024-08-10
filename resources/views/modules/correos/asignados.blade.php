<x-app-layout>
    @section('title', 'Correos asignados')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet-header>
                {{ __('CORREOS ASIGNADOS POR TIPO DE COMPRA') }}
            </x-card-greet-header>
            @if ($valid->pivot->wr == 1)
                <div>
                    @livewire('correos.asignados.asignar')
                </div>
            @endif
        </div>
    </x-slot>
    {{-- <div class="p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        @if ($correos->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                            Tipo de compra
                        </th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                            Correos asignados
                        </th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categorias as $categoria)
                        @if ($categoria->correos->count() > 0)
                            <tr
                                class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0 dark:bg-slate-800 dark:lg:hover:bg-slate-600">
                                <th
                                    class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                    <div class="w-full flex justify-center gap-2">
                                        <span
                                            class="lg:hidden bg-blue-200 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white">
                                            Tipo de compra
                                        </span>
                                        {{ $categoria->name }}
                                    </div>
                                </th>
                                <th
                                    class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                    <div class="w-full flex justify-center gap-2">
                                        <span
                                            class="lg:hidden bg-blue-200 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white">
                                            Correos asignados
                                        </span>
                                        {{ $categoria->correos->count() }}
                                    </div>
                                </th>
                                <th
                                    class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                    <div class="w-full flex justify-center gap-2">
                                        @if ($valid->pivot->vermas == 1)
                                            @livewire('correos.asignados.show-asignados', ['categoriaID' => $categoria->id], key('show' . $categoria->id))
                                        @endif
                                        @if ($categoria->correos->count() > 0)
                                            @if ($valid->pivot->ed == 1)
                                                @livewire('correos.asignados.edit-asignacion', ['categoriaID' => $categoria->id], key('edit' . $categoria->id))
                                            @endif
                                        @endif
                                    </div>
                                </th>
                            </tr>
                        @endif
                    @endforeach
                    @if ($servicios)
                        <tr
                            class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0 dark:bg-slate-800 dark:lg:hover:bg-slate-600">
                            <th
                                class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    <span
                                        class="lg:hidden bg-blue-200 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white">
                                        Tipo de compra
                                    </span>
                                    SERVICIOS
                                </div>
                            </th>
                            <th
                                class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    <span
                                        class="lg:hidden bg-blue-200 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white">
                                        Correos asignados
                                    </span>
                                    {{ $servicios }}
                                </div>
                            </th>
                            <th
                                class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    @if ($valid->pivot->vermas == 1)
                                        @livewire('correos.asignados.show-correos-servicio', key('Servicios'))
                                    @endif
                                    @if ($valid->pivot->ed == 1)
                                        @livewire('correos.asignados.edit-correos-servicio', key('EditarServicios'))
                                    @endif
                                </div>
                            </th>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{ $categorias->links() }}
        @else
            <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="max-w-[200px] bi bi-x-circle"
                    viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
                <span class="text-2xl">No hay datos registrados</span>
            </div>
        @endif

    </div> --}}
    <div>
        @livewire('correos.asignados.asignado-table')
    </div>
</x-app-layout>
