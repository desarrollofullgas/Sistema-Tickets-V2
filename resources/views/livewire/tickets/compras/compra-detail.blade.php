<div x-data="{ modelOpen: false }">
    <button @click="modelOpen =!modelOpen" wire:loading.attr="disabled" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="w-6 h-6 text-gray-400 hover:text-indigo-500 transition duration-300" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
            <path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"/>
        </svg>
        <span class="tooltiptext">Ver más</span>
    </button>

    <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
            <div x-cloak @click="modelOpen = false" x-show="modelOpen" 
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0" 
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100" 
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-gray-500 dark:bg-gray-700/75 bg-opacity-75" aria-hidden="true"
            ></div>
            <div x-cloak x-show="modelOpen" 
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block w-full max-w-2xl p-6 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl dark:bg-dark-eval-1"
            >
            
                <div class="flex items-center justify-between mb-1 border-b py-2">
                    <h1 class="text-xl font-bold text-blue-800 dark:text-gray-400">Requisición # {{$compraID}}</h1>
                    <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg"fill="currentColor" class="w-6 h-6 text-gray-400 hover:text-red-800 transition duration-300" viewBox="0 0 320 512" >
                            <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/>
                        </svg>
                    </button>
                </div>
                <div class="flex flex-col gap-1 mt-1">
                    <div class=" flex flex-wrap justify-evenly gap-1 pb-2">
                        <div>
                            <h2 class="font-bold text-blue-800 dark:text-gray-400">Agente solicitante:</h2>
                            <div class="font-bold">{{$compra->ticket->agente->name}}</div>
                        </div>
                        <div>
                            <div>
                                <h2 class="font-bold text-blue-800 dark:text-gray-400">Cliente:</h2>
                                <div class="font-bold">{{$compra->ticket->cliente->name}}</div>
                            </div>
                        </div>
                        <div>
                            <div class=" text-center">
                                @if ($compra->productos->count() > 0)
                                    <h2 class="font-bold text-blue-800 dark:text-gray-400">Cantidad de productos:</h2>
                                    <div class="font-bold">{{$compra->productos->count()}}</div>
                                @else
                                    <h2 class="font-bold text-blue-800 dark:text-gray-400">Cantidad de servicios:</h2>
                                    <div class="font-bold">{{$compra->servicios->count()}}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="my-1 flex justify-center">
                        <a href="{{asset('storage/'.$compra->documento)}}" target="_blank" class="px-2 py-1 rounded-md flex items-center gap-1 bg-gray-400 text-white hover:bg-gray-800 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 384 512">
                                <path d="M64 464c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16H224v80c0 17.7 14.3 32 32 32h80V448c0 8.8-7.2 16-16 16H64zM64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V154.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0H64zm56 256c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120z"/>
                            </svg>
                            {{ $compra->documentoNombre }}
                        </a>
                    </div>
                    <div class="flex flex-col gap-2 max-h-72 overflow-auto">
                        <div class="text-start">
                            <h2 class="font-bold text-blue-800 dark:text-gray-400">Problema detectado:</h2>
                            <p>{{$compra->problema}}</p>
                        </div>
                        <div class="text-start">
                            <h2 class="font-bold text-blue-800 dark:text-gray-400">Solución:</h2>
                            <p>{{$compra->solucion}}</p>
                        </div>
                        @if (isset($compra->mensaje_opcion))
                        <div class="text-start">
                            <h2 class="font-bold text-blue-800 dark:text-gray-400">Nota:</h2>
                            <p>{{$compra->mensaje_opcion}}</p>
                        </div>
                        @endif
                    </div>
                    @if ($compra->comentarios->count() > 0)
                        <div class='w-full rounded-lg border overflow-auto dark:border-gray-700 flex items-center justify-center my-2' x-data="{ open: false }">
                            <div class='w-full '>
                                <div @click="open = !open" class='flex items-center w-full overflow-auto mx-auto cursor-pointer bg-gray-100 dark:bg-slate-700 dark:text-gray-300 rounded-md'>
                                    <div class=' px-2 transform transition duration-300 ease-in-out' :class="{'rotate-90': open,'text-blue-500':open }">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 512 512">
                                            <path d="M0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM241 377c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l87-87-87-87c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0L345 239c9.4 9.4 9.4 24.6 0 33.9L241 377z"/>
                                        </svg>        
                                    </div>
                                    <div class='flex items-center px-1 py-2'>
                                        Clic para mostrar/ocultar observación
                                    </div>
                                </div>
                                <div class="w-full transform transition duration-300 ease-in-out "
                                x-cloak x-show="open" x-collapse x-collapse.duration.500ms >
                                    <div class="p-1 max-h-[200px] overflow-auto">
                                        @foreach ($compra->comentarios as $comentario)
                                        <div class="p-2 border-b border-gray-400">
                                            <div class="w-full dark:border-gray-500 flex flex-wrap justify-between">
                                                <div class="flex flex-col gap-2">
                                                    <div class="flex flex-wrap gap-1 mb-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 448 512" fill="currentColor">
                                                            <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/>
                                                        </svg>
                                                        <p>{{$comentario->usuario->name}}</p>
                                                    </div>
                                                    <p class="px-2 py-1 rounded-md break-all relative text-white  after:w-3 after:h-3 after:block after:absolute after:bottom-[97%] after:clip-path-polygon-[0%_0%,_0%_100%,_100%_100%] "
                                                    @if ($comentario->user_id==Auth::user()->id)
                                                        :class="'bg-blue-500 after:bg-blue-500 dark:bg-blue-600 after:dark:bg-blue-600'"
                                                    @else
                                                        :class="'bg-gray-400 dark:bg-slate-600 after:bg-gray-400 after:dark:bg-slate-600'"
                                                    @endif>
                                                        {{$comentario->comentario}}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex items-end justify-end">
                                                <p>{{$comentario->created_at}}</p>
                                            </div>
                                        </div>    
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="overflow-auto">
                        <div class='w-full rounded-lg border dark:border-gray-700 flex items-center justify-center my-2' x-data="{ open: false }">
                            <div class='w-full '>
                                <div @click="open = !open" class='flex items-center w-full overflow-auto mx-auto cursor-pointer bg-gray-100 dark:bg-slate-700 dark:text-gray-300 rounded-md'>
                                    <div class=' px-2 transform transition duration-300 ease-in-out' :class="{'rotate-90': open,'text-blue-500':open }">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 512 512">
                                            <path d="M0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM241 377c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l87-87-87-87c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0L345 239c9.4 9.4 9.4 24.6 0 33.9L241 377z"/>
                                        </svg>        
                                    </div>
                                    <div class='flex items-center px-1 py-2'>
                                        @if ($compra->productos->count() > 0)
                                            Clic para mostrar/ocultar productos
                                        @else
                                            Clic para mostrar/ocultar servicios
                                        @endif
                                    </div>
                                </div>
                                <div class="w-full transform transition duration-300 ease-in-out"
                                x-cloak x-show="open" x-collapse x-collapse.duration.500ms >
                                    <div class=" max-h-72 overflow-auto">
                                        <table class="w-full text-center">
                                            <thead>
                                                <tr>
                                                    @if ($compra->productos->count() > 0)
                                                       <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                                            Imagen
                                                        </th> 
                                                    @endif
                                                    
                                                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                                        {{$compra->productos->count()>0?'Producto' :'Servicio'}}
                                                    </th>
                                                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                                        Cantidad
                                                    </th>
                                                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                                        Prioridad
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($compra->productos->count() > 0)
                                                   @foreach ($compra->productos as $producto)
                                                        <tr>
                                                            <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                                                <div class="flex justify-center items-center">
                                                                    <figure class="w-[4rem] h-[4rem] overflow-hidden rounded-full flex justify-center items-center">
                                                                        <img src="{{ asset('storage/' . $producto->producto->product_photo_path) }}" alt="" class="w-full">
                                                                    </figure>
                                                                </div>
                                                            </th>
                                                            <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                                                <div>
                                                                    {{$producto->producto->name}}
                                                                </div>
                                                            </th>
                                                            <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                                                {{$producto->cantidad}}
                                                            </th>
                                                            <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                                                <div>
                                                                    {{$producto->producto->prioridad}}
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    @foreach ($compra->servicios as $servicio)
                                                            <tr>
                                                                <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                                                    <div>
                                                                        {{$servicio->servicio->name}}
                                                                    </div>
                                                                </th>
                                                                <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                                                    {{$servicio->cantidad}}
                                                                </th>
                                                                <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                                                    <div>
                                                                        {{$servicio->servicio->prioridad}}
                                                                    </div>
                                                                </th>
                                                            </tr>
                                                        @endforeach 
                                                @endif
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Evidencias en BD --}}
                        <div>
                            @if ($compra->evidencias->count() > 0)
                                <label class="flex justify-center gap-3 items-center text-white bg-gray-600 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="16" height="16" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path d="M384 480h48c11.4 0 21.9-6 27.6-15.9l112-192c5.8-9.9 5.8-22.1 .1-32.1S555.5 224 544 224H144c-11.4 0-21.9 6-27.6 15.9L48 357.1V96c0-8.8 7.2-16 16-16H181.5c4.2 0 8.3 1.7 11.3 4.7l26.5 26.5c21 21 49.5 32.8 79.2 32.8H416c8.8 0 16 7.2 16 16v32h48V160c0-35.3-28.7-64-64-64H298.5c-17 0-33.3-6.7-45.3-18.7L226.7 50.7c-12-12-28.3-18.7-45.3-18.7H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H87.7 384z"/>
                                    </svg>
                                    {{ __('Evidencias') }}
                                </label>
                                <div class="flex justyfy-venly flex-wrap gap-3 py-2">
                                    @foreach ($compra->evidencias as $antigArch)
                                        @if ($antigArch->flag_trash == 0)
                                            <div class="p-1">
                                                @if ($antigArch->mime_type == "image/png" || $antigArch->mime_type == "image/jpg" || $antigArch->mime_type == "image/jpeg" 
                                                                        || $antigArch->mime_type == "image/webp")
                                                    <a href="{{ asset('storage/'.$antigArch->archivo_path) }}" target="_blank" data-lightbox="imagenes-edit-{{ $antigArch->repuesto_id }}" data-title="{{ $antigArch->nombre_archivo }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar" class="text-xs">
                                                        <figure class="d-inline-block max-w-[90px]" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Presione para visualizar" data-bs-placement="top">
                                                            <img class="w-full" src="{{ asset('storage/'.$antigArch->archivo_path) }}">
                                                            <p class="break-all">{{ $antigArch->nombre_archivo }}</p>
                                                        </figure>
                                                    </a>
												@elseif ($antigArch->mime_type == 'video/mp4' || $antigArch->mime_type == 'application/octet-stream')
                                                    <a href="{{ asset('storage/'.$antigArch->archivo_path) }}" target="_blank"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar" class="text-xs">
                                                        <figure class="d-inline-block max-w-[90px]" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Presione para descargar" data-bs-placement="top">
                                                            <img class="w-100" src="{{ asset('img/icons/videos_video_media_cinema_1725.png') }}">
                                                            <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
                                                        </figure>
                                                    </a>
                                                @elseif ($antigArch->mime_type == "application/pdf")
                                                    <a href="{{ asset('storage/'.$antigArch->archivo_path) }}" target="_blank"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar" class="text-xs">
                                                        <figure class="d-inline-block max-w-[90px]" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Presione para descargar" data-bs-placement="top">
                                                            <img class="w-100" src="{{ asset('img/icons/pdf.png') }}">
                                                            <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
                                                        </figure>
                                                    </a>
                                                @elseif ($antigArch->mime_type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
                                                    <a  href="{{ asset('storage/'.$antigArch->archivo_path) }}" target="_blank"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar" class="text-xs">
                                                        <figure class="d-inline-block max-w-[90px]" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Presione para descargar" data-bs-placement="top">
                                                            <img class="w-100" src="{{ asset('img/icons/word-2019.svg') }}">
                                                            <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
                                                        </figure>
                                                    </a>
                                                    @elseif ($antigArch->mime_type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $antigArch->mime_type =='application/vnd.ms-excel')
                                                    <a  href="{{ asset('storage/'.$antigArch->archivo_path) }}" target="_blank"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar" class="text-xs">
                                                        <figure class="d-inline-block max-w-[90px]" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Presione para descargar" data-bs-placement="top">
                                                            <img class="w-100" src="{{ asset('img/icons/file-type-excel.svg') }}">
                                                            <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
                                                        </figure>
                                                    </a>
                                                    @elseif ($antigArch->mime_type == 'application/zip' || $antigArch->mime_type == 'application/vnd.rar')
                                                    <a  href="{{ asset('storage/'.$antigArch->archivo_path) }}" target="_blank"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar" class="text-xs">
                                                        <figure class="d-inline-block max-w-[90px]" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Presione para descargar" data-bs-placement="top">
                                                            <img class="w-100" src="{{ asset('img/icons/file-type-excel.svg') }}">
                                                            <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
                                                        </figure>
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="max-w-[100px]  icon icon-tabler icon-tabler-folder-off" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M8 4h1l3 3h7a2 2 0 0 1 2 2v8m-2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 1.189 -1.829"></path>
                                        <path d="M3 3l18 18"></path>
                                    </svg>
                                    <span class="text-xl">No se encontraron Evidencias</span>
                                </div>
                            @endif
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    </div>
</div>
