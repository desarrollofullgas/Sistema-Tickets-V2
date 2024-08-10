<div x-data="{ modelOpen: false }">
    <button @click="modelOpen =!modelOpen" wire:loading.attr="disabled" aria-label="ver servicio" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-indigo-500 transition duration-300"
            viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
            <path
                d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
        </svg>
        <span class="tooltiptext">Ver Más</span>
    </button>
    <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center md:items-center sm:p-0">
            <div x-cloak @click="modelOpen = false" x-show="modelOpen"
                x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-gray-500 dark:bg-gray-700/75 bg-opacity-75"
                aria-hidden="true"></div>
            <div x-cloak x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block w-full max-w-xl p-6 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl dark:bg-dark-eval-1">

                <div class="mb-1">
                    <div class="bg-dark-eval-1 p-1 rounded-md text-white text-center mb-2">
                        <div>{{ __('Folio:') }} {{ $folio->folio }}</div>
                        {{-- <div> {{ __('Fecha:') }} {{ $folio->created_at }}</div> --}}
                    </div>
                </div>
                <div>
                    @if ($folio->salidas->count() > 0)
                        <div class="w-full py-2 text-lg">
                            <h1>Historial</h1>
                        </div>
                        <div class="flex flex-col  max-h-[320px] overflow-y-auto">
                            @foreach ($folio->salidas as $salida)
                                <div class="py-2 border-b border-gray-300">
                                    <div class="flex mb-1 text-sm">

                                        @if ($salida->usuario->profile_photo_path)
                                            <figure class="flex justify-center items-center h-10 w-10 rounded-full overflow-hidden">
                                                <img class="w-full"
                                                    src="/storage/{{ $salida->usuario->profile_photo_path }}"
                                                    alt="{{ $salida->usuario->name }}" />
                                            </figure>
                                        @else
                                            <figure class="flex justify-center items-center h-10 w-10 rounded-full overflow-hidden">
                                                <img class="w-full"
                                                    src="{{ $salida->usuario->profile_photo_url }}"
                                                    alt="{{ $salida->usuario->name }}" />
                                            </figure>
                                        @endif
                                        <div class="w-full pb-2">
                                            <div class="flex justify-between">
                                                <div class="flex gap-2">
                                                    <span class="block ml-2 font-semibold text-gray-600 dark:text-white">{{ $salida->usuario->name }}</span>
                                                    <div class="float-right"> 
                                                        {{ __('Fecha:') }}
                                                        {{ $salida->created_at }}
                                                    </div>
                                                    <div class="relative" x-data="{toggle:false}" >
                                                        <button class="text-gray-400 duration-300 block hover:text-gray-600" @click="toggle=!toggle">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 " viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                                                <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                                                <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                                             </svg>
                                                        </button>
                                                        <div class="absolute z-50 flex flex-col w-max rounded-md overflow-hidden bg-white dark:bg-dark-eval-3 shadow-md right-full top-0 md:left-full" x-cloak x-collapse x-show="toggle">
                                                            @if ($salida->editable == 1)
                                                                    <a href="{{route('salida.edit', $salida->id)}}" class="flex gap-1 items-center px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="1.5" stroke="currentColor"
                                                                            class="w-6 h-6">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                                        </svg>
                                                                        <span>Editar</span>
                                                                    </a>
                                                                    @livewire('folios.salida.lock', ['salidaID' => $salida->id])
                                                            @endif
                                                            <a href="{{asset('storage/'.$salida->pdf)}}" target="_blank" rel="noopener noreferrer" class="flex gap-1 items-center px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M64 464h32v48H64c-35.3 0-64-28.7-64-64V64C0 28.7 28.7 0 64 0h165.5c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3V288h-48V160h-80c-17.7 0-32-14.3-32-32V48H64c-8.8 0-16 7.2-16 16v384c0 8.8 7.2 16 16 16zm112-112h32c30.9 0 56 25.1 56 56s-25.1 56-56 56h-16v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24h-16v48h16zm96-80h32c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48h-32c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16v-64c0-8.8-7.2-16-16-16h-16v96h16zm80-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16h-32v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16h-32v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V368z"/>
                                                                </svg>
                                                                <span>Ver documento</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="block ml-2 "></span>
                                            </div>
                                            <div class="flex items-center"> <!-- Agregado el contenedor flex -->
                                                <span
                                                    class="block ml-2 text-sm text-gray-600 dark:text-white">{{ $salida->motivo }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='w-full border border-gray-100 dark:border-slate-700 rounded-md overflow-hidden' x-data="{open:false}">
                                        <div @click="open = !open" class='flex items-center w-full overflow-auto mx-auto cursor-pointer bg-gray-100 dark:bg-slate-700 dark:text-gray-300 rounded-t-md'>
                                            <div class=' px-2 transform transition duration-300 ease-in-out' :class="{'rotate-90': open,'text-blue-500':open }">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 512 512">
                                                    <path d="M0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM241 377c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l87-87-87-87c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0L345 239c9.4 9.4 9.4 24.6 0 33.9L241 377z"/>
                                                </svg>        
                                            </div>
                                            <div class='flex items-center px-1 py-2'>
                                                Click para mostrar/ocultar productos de la operación
                                            </div>
                                        </div>
                                        <div class="w-full transform transition duration-300 ease-in-out"
                                        x-cloak x-show="open" x-collapse x-collapse.duration.500ms >
                                            <div class=" max-h-72 overflow-auto">
                                                <table class="w-full text-center rounded-b-md">
                                                    <thead>
                                                        <tr>
                                                            <th class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                                                 Imagen
                                                             </th>     
                                                            <th class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                                                Producto
                                                            </th>
                                                            <th class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                                                Cantidad
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($salida->productos as $producto)
                                                             <tr>
                                                                 <th  class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                                                     <div class="flex justify-center items-center">
                                                                         <figure class="w-[4rem] h-[4rem] overflow-hidden rounded-full flex justify-center items-center">
                                                                             <img src="{{ asset('storage/' . $producto->producto->product_photo_path) }}" alt="" class="w-full">
                                                                         </figure>
                                                                     </div>
                                                                 </th>
                                                                 <th  class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                                                     <div>
                                                                         {{$producto->producto->name}}
                                                                     </div>
																	  <div>
                                                                        {{ $producto->serie->serie??'No se encontró serie' }}
                                                                     </div>
                                                                 </th>
                                                                 <th  class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                                                     {{$producto->cantidad}}
                                                                 </th>
                                                             </tr>
                                                         @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                class="max-w-[150px] bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path
                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                            </svg>
                            <span class="text-lg">Sin folios registradas</span>
                        </div>
                    @endif
                </div>
                <div class="mt-3 float-right">
                    <x-secondary-button @click="modelOpen = false" wire:loading.attr="disabled">
                        Cerrar
                    </x-secondary-button>
                </div>
            </div>
        </div>
    </div>
</div>
