<div class="flex flex-col gap-3" {{-- x-data="{modalOpen:false}" --}}>
    <div
        class="flex flex-wrap justify-between items-center gap-1 p-4 rounded-md bg-white shadow-md dark:bg-dark-eval-1 dark:shadow-none">
        <div>
            <x-label value="{{ __('Seleccionar mes') }}" />
            <x-input type="month" wire:model='mes' />
        </div>
        {{-- <div class="relative  rounded-md overflow-hidden p-1 flex justify-center items-stretch">
            <div class="absolute animate-spin -top-10 -bottom-10 -left-10 -right-10 bg-gradient-to-r from-orange-500 via-orange-400 to-orange-800">
            </div>
            <div class="w-full rounded md flex justify-center items-center z-10 bg-white dark:bg-dark-eval-1">
                10%
            </div>
        </div> --}}
        {{-- <div>
            <x-button class="gap-2" @click="modalOpen=!modalOpen">
                <svg class="w-6 h-6" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                    <path d="M7 11l5 5l5 -5"></path>
                    <path d="M12 4l0 12"></path>
                 </svg>
                 <span>Descargar reporte</span>
            </x-button>
        </div> --}}
        @if ($valid->pivot->vermas == 1)
            @livewire('calificaciones.download-cal')
        @endif
    </div>
    {{-- modal para rango de fechas --}}
    {{-- <div x-show="modalOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center md:items-center sm:p-0">
            <div x-cloak @click="modalOpen = false" x-show="modalOpen" 
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0" 
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100" 
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-gray-500 dark:bg-gray-700/75 bg-opacity-75" aria-hidden="true"
            >
            </div>
            <div x-cloak x-show="modalOpen" 
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block w-full max-w-xl p-6 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl dark:bg-dark-eval-1"
            >        
                <div class="flex items-center justify-between space-x-4">
                    <h1 class="text-xl font-medium">{{ __('Editar falla') }}</h1>
                </div>
                <div class="flex justify-center py-3">
                    <div class="flex flex-wrap gap-3 justify-evenly items-center">
                        <div>
                            <x-label value="{{__('Fecha de inicio')}}"/>
                            <x-input type="date" wire:model='dateIn'/>
                            <x-input-error for="dateIn"></x-input-error>
                        </div>
                        <div>
                            <x-label value="{{__('Fecha de término')}}"/>
                            <x-input type="date" wire:model='dateEnd'/>
                            <x-input-error for="dateEnd"></x-input-error>
                        </div>
                    </div>
                </div>
                <div name="footer" class="d-none text-right mt-1">
                    <x-danger-button class="mr-2" wire:click="genExcel()" wire:loading.attr="disabled">
                        Aceptar
                    </x-danger-button>
        
                    <x-secondary-button @click="modalOpen = false" wire:loading.attr="disabled">
                        Cancelar
                    </x-secondary-button>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- Ranking --}}
    @if (count($users) > 0)
        <div class="   flex flex-col gap-2">{{-- lg:clip-path-polygon-[50%_0,0_100%,100%_100%] --}}
            @foreach ($users as $key => $group)
                <div
                    class="flex lg:flex-col max-lg:justify-between max-lg:px-5 justify-center items-center py-3 bg-white shadow-md dark:bg-dark-eval-1 dark:shadow-none rounded-md">
                    @if ($key < 3)
                        <div class="relative">
                            <div
                                class="absolute top-0 bottom-0 left-0 right-0 flex justify-center items-center text-white text-xs">
                                <span class="font-bold">
                                    {{ number_format($group[0]['cal'], 1) }}%
                                </span>
                            </div>
                            <svg viewBox="-2 -4 24 24" fill="currentColor"
                                @if ($key == 0) :class="'w-20 text-amber-500'"
                                @elseif($key == 1)
                                    :class="'w-16 text-gray-500'"
                                @else
                                    :class="'w-14 text-orange-700'" @endif>
                                <path
                                    d="M2.049 1.802L5.854 5.15L9.244.976a1 1 0 0 1 1.565.017l3.235 4.156l3.928-3.396a1 1 0 0 1 1.643.9L18.115 13H1.922L.399 2.7a1 1 0 0 1 1.65-.898zM2 14h16v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z" />
                            </svg>
                        </div>
                    @else
                        @if ($key + 1 == count($users))
                            <div class="flex gap-1 items-center rounded-full border p-1 mb-2">
                                <svg class=" w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 512 512">
                                    <path
                                        d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM159.3 388.7c-2.6 8.4-11.6 13.2-20 10.5s-13.2-11.6-10.5-20C145.2 326.1 196.3 288 256 288s110.8 38.1 127.3 91.3c2.6 8.4-2.1 17.4-10.5 20s-17.4-2.1-20-10.5C340.5 349.4 302.1 320 256 320s-84.5 29.4-96.7 68.7zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                </svg>
                                <span>{{ number_format($group[0]['cal'], 1) }}%</span>
                            </div>
                        @else
                            <div
                                class="w-12 h-12 flex justify-center items-center border rounded-full m-2 font-bold text-xs">
                                <span>{{ number_format($group[0]['cal'], 1) }}%</span>
                            </div>
                        @endif
                    @endif
                    <div class=" flex flex-wrap gap-2 justify-center items-center max-lg:flex-auto">
                        @foreach ($group as $user)
                            <div class="flex justify-center items-center p-1 rounded-full"
                                @if ($key == 0) :class="'bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500'"
                                @elseif($key == 1)
                                    :class="'bg-gradient-to-r from-gray-500 via-gray-400 to-gray-800'"
                                @elseif($key == 2)
                                    :class="'bg-gradient-to-r from-orange-500 via-orange-400 to-orange-800'"
                                @else
                                    :class="'border'" @endif>
                                <span class=" px-2  rounded-full bg-white dark:bg-dark-eval-1">
                                    {{ $user['user'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>{{-- etiqueta de cierre del path? --}}
        <!--fin de path-->
        <div class="p-2 border-b text-center mt-4 mb-2">
            <h1 class="text-xl font-bold">{{ __('Información de puntajes') }}</h1>
        </div>
        <div class=" flex flex-col gap-2">
            @foreach ($users as $key => $group)
                @foreach ($group as $user)
                    <div class=" p-4 rounded-md bg-white shadow-md dark:bg-dark-eval-1 dark:shadow-none">
                        <div class="mb-2 border-b pb-1">
                            @if ($key < 3)
                                <div class=" w-6">
                                    <svg viewBox="-2 -4 24 24" fill="currentColor"
                                        @if ($key == 0) :class="'text-amber-500'"
                                        @elseif($key == 1)
                                            :class="'text-gray-500'"
                                        @else
                                            :class="'text-orange-700'" @endif>
                                        <path
                                            d="M2.049 1.802L5.854 5.15L9.244.976a1 1 0 0 1 1.565.017l3.235 4.156l3.928-3.396a1 1 0 0 1 1.643.9L18.115 13H1.922L.399 2.7a1 1 0 0 1 1.65-.898zM2 14h16v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z" />
                                    </svg>
                                </div>
                            @endif
                            <span>{{ $user['user'] }}</span>
                        </div>

                        <div class="grid grid-cols-[repeat(auto-fit,minmax(200px,1fr))] gap-1">
                            <span>Puntos positivos: <b>{{ $user['pos'] }}</b></span>
                            <span>Puntos negativos: <b>{{ $user['neg'] }}</b></span>
                            <span>Total de puntos: <b>{{ $user['total'] }}</b></span>
                            <span>Calificación: <b>{{ number_format($user['cal'], 1) }}</b></span>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    @else
        <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="max-w-[200px] bi bi-x-circle"
                viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path
                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
            </svg>
            <span class="text-2xl text-center">Sin calificaciones por mostrar</span>
        </div>
    @endif
</div>
