<div>
    <button wire:click="showDepto({{$deptoID}})" wire:loading.attr="disabled" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="w-6 h-6 text-gray-400 hover:text-indigo-500 transition duration-300" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
            <path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"/>
        </svg>
        <span class="tooltiptext">Ver Más</span>
    </button>
    <x-dialog-modal wire:model="modal" class="flex items-center">
        <x-slot name="title">
            {{ __('Información del departamento') }}
        </x-slot>
        <x-slot name="content" class="relative">
        @if ($depto)
            <div class=" flex justify-evenly pb-4">
                    <div>
                        <h2>Nombre del Departamento:</h2>
                        <div class="text-lg">{{$depto->name}}</div>
                    </div>
                    <div>
                        <div>
                            <h2>Áreas asignadas al departamento:</h2>
                            <div class="text-lg">{{$depto->areas->count()}}</div>
                        </div>
                    </div>
                
            </div>
            @if ($depto->areas->count() > 0)
                    <div class="border rounded-lg  max-h-[320px] overflow-auto dark:border-gray-700">
                        <details>
                            <summary class="bg-gray-100 py-2 px-4 cursor-pointer dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">Click para mostrar/ocultar Áreas del departamento</summary>
                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                            Nombre del área
                                        </th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($depto->areas as $area)
                                        <tr>
                                            <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                                <div>
                                                    {{$area->name}}
                                                </div>
                                            </th>
                                            <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                                @if ($depto->status == 'Activo')
                                                    <div class="rounded bg-green-200 py-1 px-3 text-xs text-green-500 font-bold  dark:bg-green-300 dark:text-green-900">
                                                        {{$area->status}}
                                                    </div>
                                                @else
                                                    <div>
                                                        <div class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold  dark:bg-red-300 dark:text-red-900">
                                                            {{$area->status}}
                                                        </div>
                                                    </div>
                                                @endif
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </details>
                    </div>
                @else
                <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg"  fill="currentColor" class="max-w-[150px] bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                    <span class="text-lg">Sin áreas registradas</span>
                </div>
                @endif
            <div class="absolute right-1.5	top-1.5">
                <button wire:click="$toggle('modal')" wire:loading.attr="disabled">
                    <svg xmlns="http://www.w3.org/2000/svg"fill="currentColor" class="w-6 h-6 text-gray-400 hover:text-orange-800 transition duration-300" viewBox="0 0 320 512" >
                        <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/>
                    </svg>
                </button>
            </div>
        @endif
        </x-slot>
        <x-slot name="footer">
        </x-slot>
    </x-dialog-modal>
</div>