<div class="p-4  overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
    <div class="bg-dark-eval-1 p-1 rounded-md text-white text-center mb-2">
        {{ __('Detalles Ticket') }}
    </div>
       <div>
        <x-label value="{{ __('Servicio') }}" for="servicio" />
        <x-input wire:model="servicio" disabled type="text"
        class="w-full  border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700 dark:text-white"
            name="servicio" required  autocomplete="servicio"/>
        <x-input-error for="servicio"></x-input-error>
    </div>
    <div>
        <x-label value="{{ __('Falla') }}" for="falla" />
        <x-input wire:model="falla" disabled type="text"
        class="w-full  border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700 dark:text-white"
            name="falla" required  autocomplete="falla"/>
        <x-input-error for="falla"></x-input-error>
    </div>
   <div class=" flex flex-wrap gap-1 pb-4"> 
        {{-- <div class="w-full">
                    <div>Asunto</div>
                    <x-input wire:model="asunto" type="text" name="asunto" id="asunto"
                        class="w-full  border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700 dark:text-white"
                        required  autocomplete="asunto" />
                    <x-input-error for="asunto"></x-input-error>
                </div> --}}
        <div class="w-full">
            <x-label value="{{ __('Descripción') }}" for="mensaje" />
            <textarea wire:model="mensaje" disabled
                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('mensaje') ? 'is-invalid' : '' }} " rows="4" cols="50"
                name="mensaje" required  autocomplete="mensaje">
            </textarea>
            <x-input-error for="mensaje"></x-input-error>
        </div>
   </div> 
    <hr>
    @if ($evidenciaArc->count() > 0)
    <div class="flex items-center ml-2 mt-3"> <!-- Agregado el contenedor flex -->
        @if ($evidenciaArc)
             <div class="flex justify-evenly flex-wrap gap-3 py-2">
                    @forelse ($evidenciaArc as $antigArch)
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
                                    @elseif ($antigArch->mime_type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $antigArch->mime_type =='application/vnd.ms-excel')
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
                                    @elseif ($antigArch->mime_type == 'application/zip' || $antigArch->mime_type == 'application/vnd.rar'
								|| $antigArch->mime_type == 'application/x-rar')
                                    <a href="{{ asset('storage/' . $antigArch->archivo_path) }}" download=""
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar"
                                        class="text-xs">
                                        <figure class="d-inline-block max-w-[90px]" tabindex="0"
                                            data-bs-toggle="popover" data-bs-trigger="hover focus"
                                            data-bs-content="Presione para descargar" data-bs-placement="top">
                                            <img class="w-100" src="{{ asset('img/icons/file-type-zip2 (1).svg') }}">
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
        @endif
    </div>
@endif
</div>
