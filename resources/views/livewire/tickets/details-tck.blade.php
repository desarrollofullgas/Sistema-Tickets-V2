<div x-data="{ modelOpen: false }">

    <button @click="modelOpen =!modelOpen" wire:loading.attr="disabled" aria-label="reasignar-usuario" class="px-2 py-1 text-xs font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
        Detalle Ticket
    </button>

    <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center md:items-center sm:p-0">
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
                class="inline-block w-full max-w-2xl p-6 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-3xl dark:bg-dark-eval-1"
            >
            
                <div class="flex items-start justify-between space-x-4">
                    <div class="flex flex-wrap gap-2 sm:gap-4 bg-dark-eval-1 p-1 rounded-md text-white text-center mb-2">
                        <h1 class="text-xl font-medium">{{ __('Ticket #').$ticketID }}</h1>
                        <h2 class="text-lg">Fecha de creación: <strong class="text-base">{{$tck->created_at}}</strong></h2>
                    </div>
                    <div class="flex justify-center items-center my-2">
                        <a href="{{route('tck.ver',$tck->id)}}" class="w-fit flex gap-2 bg-gray-400 dark:bg-sky-700 px-2 py-1 text-white rounded-md">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M12 18c-.328 0 -.652 -.017 -.97 -.05c-3.172 -.332 -5.85 -2.315 -8.03 -5.95c2.4 -4 5.4 -6 9 -6c3.465 0 6.374 1.853 8.727 5.558" /><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M20.2 20.2l1.8 1.8" /></svg>
                            Más detalles
                        </a>
                    </div>
                    {{-- <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg"fill="currentColor" class="w-6 h-6 text-gray-400 hover:text-orange-800 transition duration-300" viewBox="0 0 320 512" >
                            <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/>
                        </svg>
                    </button> --}}
                </div>
                {{-- <div class="flex justify-center items-center my-2">
                    <a href="{{route('tck.ver',$tck->id)}}" class="w-fit flex gap-2 bg-gray-400 dark:bg-sky-700 px-2 py-1 text-white rounded-md">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M12 18c-.328 0 -.652 -.017 -.97 -.05c-3.172 -.332 -5.85 -2.315 -8.03 -5.95c2.4 -4 5.4 -6 9 -6c3.465 0 6.374 1.853 8.727 5.558" /><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M20.2 20.2l1.8 1.8" /></svg>
                        Más detalles
                    </a>
                </div> --}}
                <div>
                    <div class="flex gap-2 flex-wrap items-center">
                        <h2 class="text-lg">Falla:</h2>
                        <div class="text-base"><strong>{{$tck->falla->name}}</strong></div>
                    </div>
                    <div class=" flex flex-wrap justify-evenly pb-4">
                        <div>
                            <h2 class="text-lg">Cliente:</h2>
                            <div class=" text-base"><strong>{{$tck->cliente->name}}</strong></div>
                        </div>
                        <div>
                            <h2 class="text-lg">Agente asignado:</h2>
                            <div class="text-base"><strong>{{$tck->agente->name}}</strong></div>
                        </div>
                    </div>
                    
                    
                    <div class="w-full">
                        <x-label value="{{ __('Detalles') }}" for="mensaje" />
                        <textarea disabled 
                                class=" w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700 {{ $errors->has('mensaje') ? 'is-invalid' : '' }} "
                                name="mensaje" required autofocus autocomplete="mensaje">{{$tck->mensaje}}
                        </textarea>
                    </div>
                    {{-- Evidencias en BD --}}
                    <div class="max-h-[150px] overflow-auto">
                        @if ($tck->archivos->count() > 0)
                            <label class="flex justify-center gap-3 items-center text-white bg-amber-600 p-1">
                                <svg fill="currentColor" width="16" height="16" viewBox="0 0 576 512">
                                    <path d="M384 480h48c11.4 0 21.9-6 27.6-15.9l112-192c5.8-9.9 5.8-22.1 .1-32.1S555.5 224 544 224H144c-11.4 0-21.9 6-27.6 15.9L48 357.1V96c0-8.8 7.2-16 16-16H181.5c4.2 0 8.3 1.7 11.3 4.7l26.5 26.5c21 21 49.5 32.8 79.2 32.8H416c8.8 0 16 7.2 16 16v32h48V160c0-35.3-28.7-64-64-64H298.5c-17 0-33.3-6.7-45.3-18.7L226.7 50.7c-12-12-28.3-18.7-45.3-18.7H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H87.7 384z"/>
                                </svg>
                                {{ __('Archivos Almacenados') }}
                            </label>
                            <div class="flex justify-evenly flex-wrap gap-3 py-2">
                                @forelse ($tck->archivos as $antigArch)
                                    @if ($antigArch->flag_trash == 0)
                                        <div class="relative p-1">
                                            @if (
                                                $antigArch->mime_type == 'image/png' ||
                                                    $antigArch->mime_type == 'image/jpg' ||
                                                    $antigArch->mime_type == 'image/jpeg' ||
                                                    $antigArch->mime_type == 'image/webp')
                                                <a href="{{ asset('storage/' . $antigArch->archivo_path) }}"
                                                    data-lightbox="imagenes-edit-{{ $antigArch->repuesto_id }}"
                                                    data-title="{{ $antigArch->nombre_archivo }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Visualizar" class="text-xs">
                                                    <figure class="d-inline-block max-w-[90px]" tabindex="0"
                                                        data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                        data-bs-content="Presione para visualizar" data-bs-placement="top">
                                                        <img class="w-full"
                                                            src="{{ asset('storage/' . $antigArch->archivo_path) }}">
                                                        <p class="break-all">{{ $antigArch->nombre_archivo }}</p>
                                                        @if (strlen($antigArch->size) == 4)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 1) . ' ' . 'KB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 5)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 2) . ' ' . 'KB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 6)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 3) . ' ' . 'KB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 7)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 1) . ' ' . 'MB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 8)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 2) . ' ' . 'MB') }}
                                                            </p>
                                                        @endif
                                                    </figure>
                                                </a>
                                            @elseif ($antigArch->mime_type == 'video/mp4')
                                                <a href="{{ asset('storage/' . $antigArch->archivo_path) }}"
                                                    data-title="{{ $antigArch->nombre_archivo }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Visualizar" class="text-xs">
                                                    <figure class="d-inline-block max-w-[90px]" tabindex="0">
                                                        <img class="w-100"
                                                            src="{{ asset('img/icons/videos_video_media_cinema_1725.png') }}">
                                                        <p class="break-all">{{ $antigArch->nombre_archivo }}</p>
                                                        @if (strlen($antigArch->size) == 4)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 1) . ' ' . 'KB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 5)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 2) . ' ' . 'KB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 6)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 3) . ' ' . 'KB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 7)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 1) . ' ' . 'MB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 8)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 2) . ' ' . 'MB') }}
                                                            </p>
                                                        @endif
                                                    </figure>
                                                </a>
                                            @elseif ($antigArch->mime_type == 'application/pdf')
                                                <a href="{{ asset('storage/' . $antigArch->archivo_path) }}" download=""
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar"
                                                    class="text-xs">
                                                    <figure class="d-inline-block max-w-[90px]" tabindex="0"
                                                        data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                        data-bs-content="Presione para descargar" data-bs-placement="top">
                                                        <img class="w-100" src="{{ asset('img/icons/file-type-pdf2.svg') }}">
                                                        <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
                                                        @if (strlen($antigArch->size) == 4)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 1) . ' ' . 'KB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 5)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 2) . ' ' . 'KB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 6)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 3) . ' ' . 'KB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 7)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 1) . ' ' . 'MB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 8)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 2) . ' ' . 'MB') }}
                                                            </p>
                                                        @endif
                                                    </figure>
                                                </a>
                                            @elseif ($antigArch->mime_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                                                <a href="{{ asset('storage/' . $antigArch->archivo_path) }}" download=""
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar"
                                                    class="text-xs">
                                                    <figure class="d-inline-block max-w-[90px]" tabindex="0"
                                                        data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                        data-bs-content="Presione para descargar" data-bs-placement="top">
                                                        <img class="w-100" src="{{ asset('img/icons/file-type-word.svg') }}">
                                                        <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
                                                        @if (strlen($antigArch->size) == 4)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 1) . ' ' . 'KB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 5)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 2) . ' ' . 'KB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 6)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 3) . ' ' . 'KB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 7)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 1) . ' ' . 'MB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 8)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 2) . ' ' . 'MB') }}
                                                            </p>
                                                        @endif
                                                    </figure>
                                                </a>
                                                @elseif ($antigArch->mime_type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                                                <a href="{{ asset('storage/' . $antigArch->archivo_path) }}" download=""
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar"
                                                    class="text-xs">
                                                    <figure class="d-inline-block max-w-[90px]" tabindex="0"
                                                        data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                        data-bs-content="Presione para descargar" data-bs-placement="top">
                                                        <img class="w-100" src="{{ asset('img/icons/file-type-excel.svg') }}">
                                                        <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
                                                        @if (strlen($antigArch->size) == 4)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 1) . ' ' . 'KB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 5)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 2) . ' ' . 'KB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 6)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 3) . ' ' . 'KB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 7)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 1) . ' ' . 'MB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 8)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 2) . ' ' . 'MB') }}
                                                            </p>
                                                        @endif
                                                    </figure>
                                                </a>
                                                @elseif ($antigArch->mime_type == 'application/zip' || $antigArch->mime_type == 'application/vnd.rar')
                                                <a href="{{ asset('storage/' . $antigArch->archivo_path) }}" download=""
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar"
                                                    class="text-xs">
                                                    <figure class="d-inline-block max-w-[90px]" tabindex="0"
                                                        data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                        data-bs-content="Presione para descargar" data-bs-placement="top">
                                                        <img class="w-100" src="{{ asset('img/icons/file-type-zip2.svg') }}">
                                                        <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
                                                        @if (strlen($antigArch->size) == 4)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 1) . ' ' . 'KB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 5)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 2) . ' ' . 'KB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 6)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 3) . ' ' . 'KB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 7)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 1) . ' ' . 'MB') }}
                                                            </p>
                                                        @elseif (strlen($antigArch->size) == 8)
                                                            <p>
                                                                {{ __(substr($antigArch->size, 0, 2) . ' ' . 'MB') }}
                                                            </p>
                                                        @endif
                                                    </figure>
                                                </a>
                                            @endif
                                            {{-- <form action="{{ route('tck.destroy', ['id' => $antigArch->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 rounded-lg p-1 text-sm text-white">
                                                    Eliminar archivo
                                                </button>
                                            </form> --}}
                                        </div>
                                    @endif
                                @empty
                                    sin registros
                                @endforelse
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
                <div class="flex justify-end items-end mt-3">
                    <x-secondary-button @click="modelOpen = false" >
                        Cerrar
                    </x-secondary-button>
                </div>
            </div>
        </div>
    </div>
</div>