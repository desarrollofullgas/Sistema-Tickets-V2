<x-app-layout>
    @section('title', 'EditarTicket')

    <div class="flex flex-col gap-2">
        <div class="bg-white dark:bg-dark-eval-1 text-gray-800 dark:text-gray-300 p-4 rounded-md shadow-lg mb-4 sm:mb-0">
            <div class="flex flex-wrap justify-evenly items-center gap-2">
                <div>
                    <div class="flex flex-wrap gap-2">
                        <div>
                            <strong>Ticket: </strong>
                            <span>#{{ $ticketID }}</span>
                        </div>
                        <div>
                            <strong>Estado:</strong>
                            @if ($tck->status == 'Abierto' && $tck->vencido == 0)
                        <span class="bg-green-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @elseif ($tck->status == 'En proceso' && $tck->vencido == 0)
                        <span class="bg-orange-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @elseif ($tck->vencido == 1)
                        <span class="bg-red-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @elseif ($tck->status == 'Cerrado')
                        <span class="bg-gray-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @elseif ($tck->status == 'Por abrir')
                        <span class="bg-indigo-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @endif
                        </div>
                    </div>
                    <div>
                        <strong>Cliente:</strong>
                        <span>
                            {{ $tck->cliente->name }}
                        </span>
                    </div>
                </div>
                <div>
                    <div>
                        <strong>Creado:</strong>
                    <div>
                        {{ $tck->created_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}</div>
                    </div>
                    <div>
                        <strong>Vencimiento:</strong>
                        <div class="bg-gray-400 py-1 px-2 rounded-md text-white">
                            {{ \Carbon\Carbon::parse($tck->fecha_cierre)->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}
                        </div>
                    </div>
					@if ($tck->status == 'Cerrado' && $tck->cerrado != null)
					<div>
                        <strong>Cerrado:</strong>
                        <div class="bg-gray-400 py-1 px-2 rounded-md text-white">
                              {{ \Carbon\Carbon::parse($tck->cerrado)->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}
                        </div>
                    </div>
					@endif
                </div>
                {{-- Botones acción --}}
                @if (Auth::user()->permiso_id == 1 || Auth::user()->permiso_id == 7 || Auth::user()->permiso_id == 8 || Auth::user()->permiso_id == 4)
                    <div>
                        <div class="bg-dark-eval-1 dark:bg-dark-eval-2 p-2 rounded-md text-white text-center">
                            {{ __('Ir a:') }}
                        </div>
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-center mt-5">
                            <div class="flex justify-center rounded-lg space-x-2" role="group">
                                <a class="px-2 py-1 text-xs font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800" href="{{ route('tck.ver', $tck->id) }}">
                            Ver Ticket
                        </a>
                                @if ($valid->pivot->ed == 1)
                                    @livewire('tickets.reasignar', ['ticketID' => $tck->id])
                                @endif
                                <a class="flex items-center justify-center px-2 py-1 text-xs font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800"
                            href="{{ route('tck.tarea', $tck->id) }}">
                            @if ($tareasCount)
                                <div class="relative">
                                    <span class="absolute top-0 right-0 bg-red-500 text-white p-1 rounded-full"></span>
                                </div>
                            @else
                            @endif
                            <span class="tooltiptext">Tareas</span>
                        </a>
                                @livewire('tickets.compras.show-compras', ['ticketID' => $tck->id])

                                @if ($valid->pivot->vermas == 1 && $tck->status == 'Cerrado')
                                    @livewire('tickets.unlock-ticket', ['ticketID' => $tck->id])
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            {{-- <ul class="list-style:none flex flex-wrap gap-2">
                <li class="mb-2"><strong class="dark:text-white">Ticket: </strong>
                    <span class="dark:text-white">#{{ $ticketID }}</span>
                </li>
                <li class="mb-2"><strong class="dark:text-white">Estado:</strong>
                    @if ($tck->status == 'Abierto')
                        <span class="bg-green-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @elseif ($tck->status == 'En proceso')
                        <span class="bg-orange-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @elseif ($tck->status == 'Vencido')
                        <span class="bg-red-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @elseif ($tck->status == 'Cerrado')
                        <span class="bg-gray-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @elseif ($tck->status == 'Por abrir')
                        <span class="bg-indigo-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @endif
                </li>
                <li class="mb-2"><strong class="dark:text-white">Cliente:</strong>
                    <div class="dark:text-white">
                        {{ $tck->cliente->name }}</div>
                </li>
                <li class="mb-2"><strong class="dark:text-white">Creado:</strong>
                    <div class="dark:text-white">
                        {{ $tck->created_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}</div>
                </li>
                <li class="mb-2"><strong class="dark:text-white">Vencimiento:</strong>
                    <div class="bg-gray-400 p-1 rounded-md text-white">
                        {{ \Carbon\Carbon::parse($tck->fecha_cierre)->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}
                    </div>
                </li>
                @if ($tck->status == 'Cerrado' && $tck->cerrado != null)
                    <li class="mb-2"><strong class="dark:text-white">Cerrado:</strong>
                        <div class="bg-gray-400 p-1 rounded-md text-white">
                            {{ \Carbon\Carbon::parse($tck->cerrado)->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}
                        </div>
                    </li>
                @endif
            </ul> --}}
            

        </div>

        @livewire('tickets.edit-ticket', ['ticketID' => $ticketID])
        
    </div>

    <div class="mt-4 bg-white dark:bg-dark-eval-1 text-gray-800 p-4 rounded-md shadow-lg">
        <div class="bg-dark-eval-1 p-1 rounded-md text-white text-center mb-2">
            {{ __('Evidencias del ticket:') }}
        </div>
        {{-- Evidencias en BD --}}
        <div class="max-h-[150px] overflow-auto">
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
                                                <img class="w-100"
                                                    src="{{ asset('img/icons/file-type-word.svg') }}">
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
                                    {{--<form action="{{ route('tck.destroy', ['id' => $antigArch->id]) }}"
                                        method="POST">
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
    </div>
</x-app-layout>
