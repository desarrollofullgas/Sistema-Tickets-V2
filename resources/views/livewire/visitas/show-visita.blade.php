<div>
    <button wire:click="showVisita({{ $visitaID }})" wire:loading.attr="disabled"
        class="text-gray-400 duration-300 flex items-center gap-2 hover:text-gray-600">
        {{-- <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-indigo-500 transition duration-300"
            viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
            <path
                d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
        </svg> --}}
        <span>Ver Visita</span>
    </button>
    <x-dialog-modal wire:model="modal" class="flex items-center">
        <x-slot name="title">
            <div class="bg-dark-eval-1 dark:bg-gray-600 p-2 rounded-md text-white text-center">
                {{ __('Información de la visita') }}
            </div>
        </x-slot>
        <x-slot name="content" class="relative">
            <div class="max-h-[350px] overflow-y-auto">
                @if ($visita->usuario->count() > 1)
                    {{ __('Realizaron la visita:') }}
                @else
                    {{ __('Realizó la visita:') }}
                @endif
                <div class="grid grid-cols-2 gap-2">
                    @foreach ($visita->usuario as $user)
                        <div class="flex gap-2 items-center">
                            <img class="relative inline-block h-[58px] w-[58px] rounded-full object-cover object-center"
                                src="{{ $user->profile_photo_path ? '/storage/' . $user->profile_photo_path : $user->profile_photo_url }}"
                                alt="{{ $user->name }}" />

                            <div class="flex flex-col gap-1 ">
                                <div class="block text-xs antialiased font-semibold leading-snug tracking-normal">
                                    {{ $user->name }}
                                </div>

                                <div
                                    class="flex flex-col gap-1 text-xs antialiased font-semibold leading-snug tracking-normal">
                                    @php
                                        $arraycollectID = [];
                                        $areasArray = DB::table('user_areas')
                                            ->select('area_id')
                                            ->where('user_id', $user->id)
                                            ->get();
                                        foreach ($areasArray as $area) {
                                            $arraycollectID[] = $area->area_id;
                                        }
                                        $areasNombres = DB::table('areas')
                                            ->whereIn('id', $arraycollectID)
                                            ->pluck('name');
                                    @endphp

                                    @if ($areasNombres && count($areasNombres) > 0)
                                        {{ $user->permiso->titulo_permiso }} -
                                        @foreach ($areasNombres as $nombreArea)
                                            {{ mb_strtoupper($nombreArea) }}
                                        @endforeach
                                    @else
                                        No hay áreas disponibles.
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr class="h-px my-2 bg-gray-300 border-0 dark:bg-slate-400">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    @foreach ($visita->fallas as $falla)
                        <span
                            class="inline-flex items-center gap-1 rounded-full bg-sky-600 px-2 py-1 text-xs font-semibold text-white">
                            {{ $falla->name }}
                        </span>
                    @endforeach
                </div>
                <hr class="h-px my-2 bg-gray-300 border-0 dark:bg-slate-400">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="p-0 mb-6">
                        <div>{{ $visita->solicita->name }} {{ __('realizó el siguiente comentario:') }}</div>
                        @if (!$mostrarCompleto)
                            <p class="text-gray-400" id="observa-visita">
                                {{ \Illuminate\Support\Str::limit($visita->observacion_visita, 100) }}</p>
                            <button class="text-light text-blue-500" wire:click="mostrarMas">Ver más</button>
                        @else
                            <p class="text-gray-400">{{ $visita->observacion_visita }}</p>
                            <button class="text-light text-blue-500" wire:click="mostrarMenos">Ver menos</button>
                        @endif
                    </div>
                    <div class="p-0 mb-6">
                        <div class="flex items-center gap-0 5">
                            @if ($evidenciaArc->count() > 0)
                                <div class="flex items-center mt-3 mb-3"> <!-- Agregado el contenedor flex -->
                                    @if ($evidenciaArc)
                                        <div class="relative" x-data="{ toggle: false }">
                                            <button
                                                class="text-blue-900 font-bold duration-300 flex items-center gap-2 hover:text-gray-600"
                                                @click="toggle=!toggle">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                </svg>
                                                <span>Evidencias</span>
                                            </button>
                                            @foreach ($evidenciaArc as $antigArch)
                                                @if ($antigArch->flag_trash == 0)
                                                    <div class="absolute z-50 flex flex-col w-max rounded-md overflow-hidden bg-gray-400 dark:bg-gray-400 shadow-md right-full top-0"
                                                        x-cloak x-collapse x-show="toggle">
                                                        <a href="{{ asset('storage/' . $antigArch->archivo_path) }}"
                                                            target="_blank" rel="noopener noreferrer"
                                                            class="flex gap-1 items-center px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            <svg class="w-6 h-6" fill="currentColor"
                                                                viewBox="0 0 512 512"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M64 464h32v48H64c-35.3 0-64-28.7-64-64V64C0 28.7 28.7 0 64 0h165.5c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3V288h-48V160h-80c-17.7 0-32-14.3-32-32V48H64c-8.8 0-16 7.2-16 16v384c0 8.8 7.2 16 16 16zm112-112h32c30.9 0 56 25.1 56 56s-25.1 56-56 56h-16v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24h-16v48h16zm96-80h32c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48h-32c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16v-64c0-8.8-7.2-16-16-16h-16v96h16zm80-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16h-32v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16h-32v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V368z" />
                                                            </svg>
                                                            <span>{{ $antigArch->nombre_archivo }}</span>
                                                        </a>
                                                    </div>
                                                @endif
                                            @endforeach
                                            
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="text-blue-900 font-bold  flex items-center gap-2 hover:text-gray-600">
                           <a href="{{asset('storage/'.$visita->archivo)}}" target="_blank" >Hoja de servicio</a> 
                        </div>
                    </div>
                </div>

                <hr class="h-px my-2 bg-gray-300 border-0 dark:bg-slate-400">
                <div class="mb-2">{{ __('Tiempo: ') }}
                    @if ($this->horas > 0)
                        {{ $this->horas }} horas,
                    @endif
                    @if ($this->minutos > 0)
                        {{ $this->minutos }} minutos,
                    @endif
                    @if ($this->segundos > 0)
                        {{ $this->segundos }} segundos,
                    @endif
                </div>

                <ol class="items-center sm:flex">
                    <li class="relative mb-6 sm:mb-0">
                        <div class="flex items-center">
                            <div
                                class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                                <svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
                        </div>
                        <div class="mt-3 sm:pe-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Creación</h3>
                            <time
                                class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ $visita->created_at }}</time>

                        </div>
                    </li>
                    <li class="relative mb-6 sm:mb-0">
                        <div class="flex items-center">
                            <div
                                class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                                <svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
                        </div>
                        <div class="mt-3 sm:pe-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">En Proceso</h3>
                            <time
                                class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ $visita->llegada }}</time>

                        </div>
                    </li>
                    <li class="relative mb-6 sm:mb-0">
                        <div class="flex items-center">
                            <div
                                class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                                <svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
                        </div>
                        <div class="mt-3 sm:pe-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Completado</h3>
                            <time
                                class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ $visita->retirada }}</time>

                        </div>
                    </li>
                </ol>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('modal')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
