<x-app-layout>
    @section('title', 'Productos')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet-header>
                {{ __('PRODUCTOS') }}
            </x-card-greet-header>
            <div class=" flex justify-center space-x-2">
            @if ($valid->pivot->wr == 1)
                @livewire('productos.existencias.producto-create')
            @endif
            <div class="mb-2">
                <a class="inline-flex items-center px-3 py-2.5 text-sm font-medium text-center float-right text-white bg-gray-400 rounded-lg hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-dark-eval-3 "
                    href="{{ route('productos.trashed') }}">
                    Eliminados
                    <span
                        class="inline-flex items-center justify-center w-4 h-4 ml-2 text-xs font-semibold text-black bg-white rounded-full">
                        {{ $trashed }}
                    </span>
                </a>
            </div>
            </div>
        </div>
    </x-slot>
    {{-- <div
        class="p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <div class="flex gap-1 flex-col mb-2">
                <form action="{{ route('productos') }}" method="GET">
                    <div class="flex">
                        <div class="relative mr-4">
                            <label for="filter" class="sr-only">Filtrar por categoría</label>
                            <select name="filter" id="filter"
                                class="block w-full p-3 pl-10 text-sm border-gray-200 rounded-md focus:border-gray-500 focus:ring-gray-500 dark:bg-dark-eval-0 dark:border-gray-700 dark:text-white">
                                <option value="">Todos</option>
                                @foreach ($categos as $catego)
                                    <option value="{{ $catego->id }}"
                                        {{ request('filter') == $catego->id ? 'selected' : '' }}>{{ $catego->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute top-0 left-0 mt-3 ml-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6 8H2a2 2 0 00-2 2v12a2 2 0 002 2h4a2 2 0 002-2V10a2 2 0 00-2-2zm0 0V4a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h12m-6 0a2 2 0 00-2 2v8a2 2 0 002 2h4a2 2 0 002-2v-8a2 2 0 00-2-2h-4a2 2 0 00-2 2z"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                </svg>
                            </div>
                        </div>
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
            <table class="border-collapse w-full  bg-white text-center text-sm text-gray-500  dark:bg-dark-eval-0 dark:text-black">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Nombre</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Categoria</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Unidad</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Status</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Fecha de Registro</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Opciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                    @forelse($productos as $producto)
                        <tr>
                            <th
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Nombre</span>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10">
                                        @if ($producto->product_photo_path == null)
                                            <img class="w-full h-full rounded-full"
                                                src="{{ asset('storage/product-photos/imagedefault.jpg') }}"
                                                alt="" />
                                        @else
                                            <img class="w-full h-full rounded-full"
                                                src="{{ asset('storage/' . $producto->product_photo_path) }}"
                                                alt="" />
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{ $producto->name }}
                                        </p>
                                    </div>
                                </div>
                            </th>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Categoria</span>
                                {{ $producto->categoria->name}}
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Unidad</span>
                                {{ $producto->unidad }}
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Status</span>
                                @if ($producto->status == 'Activo')
                                    <span
                                        class="rounded bg-green-200 py-1 px-3 text-xs text-green-500 font-bold">{{ $producto->status }}</span>
                                @else
                                    <span
                                        class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold">{{ $producto->status }}</span>
                                @endif
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Fecha</span>
                                {{ $producto->created_at->locale('es')->isoFormat('D / MMMM / YYYY H:mm:ss a') }}
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 border border-b block lg:table-cell relative lg:static">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Opciones</span>
                                <div class="flex gap-2">
                                    <div>
                                        @if ($valid->pivot->vermas == 1)
                                            @livewire('productos.existencias.show-producto', ['productoID' => $producto->id])
                                        @endif
                                    </div> 
                                    <div>
                                        @if ($valid->pivot->ed == 1)
                                            @livewire('productos.existencias.producto-edit', ['productoID' => $producto->id])
                                        @endif
                                    </div>
                                    <div>
                                        @if ($valid->pivot->de == 1)
                                            @livewire('productos.existencias.producto-delete', ['prodID' => $producto->id])
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
                                No hay productos en el sistema
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-2 mb-2 mr-2">
                {{ $productos->appends($_GET)->links() }}
            </div>
    </div> --}}
    <div>
        @livewire('productos.existencias.prod-table')
    </div>
</x-app-layout>
