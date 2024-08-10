<x-app-layout>
    @section('title', 'Marcas de productos')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet-header>
                {{ __('MARCAS DE PRODUCTOS') }}
            </x-card-greet-header>
            <div class=" flex justify-center space-x-2">
                @if ($valid->pivot->wr == 1)
                    @livewire('productos.marcas.new-marca')
                @endif
                @if ($valid->pivot->verpap == 1)
                    <div class="">
                        <a class="inline-flex items-center px-3 py-2.5 text-sm font-medium text-center float-right text-white bg-gray-400 rounded-lg hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-dark-eval-3 "
                            href="{{ route('marcas.trashed') }}">
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
    {{-- <div class="p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="flex gap-1 flex-col mb-2">
            <form action="{{ route('marcas') }}" method="GET">
                <div class="flex">
                    <div class="relative">
                        <label for="search" class="sr-only">Buscar</label>
                        <input type="text" name="search" id="search"
                            class="block w-full p-3 pl-10 text-sm border-gray-200 rounded-md focus:border-gray-500 focus:ring-gray-500 dark:bg-dark-eval-0 dark:border-gray-700 dark:text-white"
                            placeholder="Buscar..." value="{{ request('search') }}">
                        <div class="absolute top-0 left-0 mt-3 ml-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.5 9a6.5 6.5 0 10-13 0 6.5 6.5 0 0013 0z" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"></path>
                                <path d="M22 22L18 18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <button type="submit"
                        class="ml-4 py-2 px-4 bg-gray-600 text-white rounded-md hover:bg-gray-700">Buscar</button>

                </div>
            </form>

        </div>
        @if ($marcas->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                            ID
                        </th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                            Nombre de la marca
                        </th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                            Status
                        </th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                            Fecha de creación
                        </th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                            Opciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($marcas as $marca)
                        <tr
                            class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0 dark:bg-slate-800 dark:lg:hover:bg-slate-600">
                            <th
                                class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    <span
                                        class="lg:hidden bg-blue-200 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white">
                                        ID
                                    </span>
                                    {{ $marca->id }}
                                </div>
                            </th>
                            <th
                                class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    <span
                                        class="lg:hidden bg-blue-200 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white">
                                        Nombre de la marca
                                    </span>
                                    {{ $marca->name }}
                                </div>
                            </th>
                            <th
                                class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    <span
                                        class="lg:hidden bg-blue-200 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white">
                                        Status
                                    </span>
                                    @if ($marca->status == 'Activo')
                                        <span
                                            class="rounded bg-green-200 py-1 px-3 text-xs text-green-500 font-bold  dark:bg-green-900 dark:text-green-300">{{ $marca->status }}</span>
                                    @else
                                        <span
                                            class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold  dark:bg-red-900 dark:text-red-300">{{ $marca->status }}</span>
                                    @endif
                                </div>
                            </th>
                            <th
                                class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    <span
                                        class="lg:hidden bg-blue-200 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white">
                                        Status
                                    </span>
                                    {{ $marca->created_at->locale('es')->isoFormat('D / MMMM / YYYY H:mm:ss a') }}
                                </div>
                            </th>
                            <th
                                class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    @if ($valid->pivot->vermas == 1)
                                        @livewire('productos.marcas.show-marca', ['marcaID' => $marca->id])
                                    @endif
                                    @if ($valid->pivot->ed == 1)
                                        @livewire('productos.marcas.edit-marca', ['marcaID' => $marca->id])
                                    @endif
                                    @if ($valid->pivot->de == 1)
                                        @livewire('productos.marcas.delete-marca', ['marcaID' => $marca->id])
                                    @endif
                                </div>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $marcas->links() }}
        @else
            <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
                <td class="p-4" colspan="4">
                    <span class="text-danger text-lg">
                        <p style="display: flex; justify-content: center;"><img
                                src="{{ asset('img/logo/emptystate.svg') }}" style="" alt="Buzón Vacío"></p>
                    </span>
                    Sin registros.
                </td>
            </div>
        @endif

    </div> --}}
    <div>
        @livewire('productos.marcas.marca-table')
    </div>
</x-app-layout>
