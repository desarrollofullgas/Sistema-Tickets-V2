<div>
    <button wire:click="showTarea({{$tareaID}})" wire:loading.attr="disabled" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="w-6 h-6 text-gray-400 hover:text-indigo-500 transition duration-300" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
            <path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"/>
        </svg>
        <span class="tooltiptext">Ver Más</span>
    </button>
    <x-dialog-modal wire:model="modal" class="flex items-center ">
        <x-slot name="title">
            <div class="bg-dark-eval-1 p-1 rounded-md text-white text-center mb-2">
                {{ __('Tarea #').$tareaID }}
            </div>
        </x-slot>
        <x-slot name="content" class="relative">
            @if ($tarea)    
                <div class="flex flex-col gap-1">
                    <div class=" flex flex-wrap justify-evenly gap-1 pb-4">
                        <div>
                            <h2>Agente solicitante:</h2>
                            <span class="text-lg">{{$tarea->ticket->agente->name}}</span>
                        </div>
                        <div>
                            <div>
                                <h2>Cliente:</h2>
                                <div class="text-lg">{{$tarea->ticket->cliente->name}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 space-y-6 max-h-[320px] overflow-y-auto">
                        <div>
                            {{ __('Asunto') }}
                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                {{ $tarea->asunto }}
                             </p>
                        </div>
                        <div>
                            {{ __('Descripción') }}
                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                {{ $tarea->mensaje }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button class="mr-2" wire:click="$set('modal',false)" wire:loading.attr="disabled">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>