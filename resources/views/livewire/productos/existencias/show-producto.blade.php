<div>
    <button wire:click="showProducto({{ $productoID }})" wire:loading.attr="disabled" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-indigo-500 transition duration-300" viewBox="0 0 576 512">
            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
            <path
                d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
        </svg>
        <span class="tooltiptext">Ver Más</span>
    </button>
    <x-dialog-modal wire:model="modal" class="flex items-center">
        <x-slot name="title">
            <div class="flex flex-wrap gap-2 justify-center items-center">
                <div>
                    {{$name}}
                </div>
                <div @if ($prioridad=="Bajo")
                    class="bg-green-400 text-white p-1 rounded w-auto"
                    @endif
                    @if ($prioridad=="Medio")
                        class="bg-yellow-400 text-white p-1 rounded w-auto"
                    @endif
                    @if ($prioridad=="Alto")
                        class="bg-orange-400 text-white p-1 rounded w-auto"
                    @endif
                    @if ($prioridad=="Crítico")
                        class="bg-red-400 text-white p-1 rounded w-auto"
                    @endif
                    @if ($prioridad=="Alto Crítico")
                        class="bg-red-700 text-white p-1 rounded w-auto"
                    @endif>
                    {{$prioridad}}
                </div>
            </div>
        </x-slot>
        <x-slot name="content" class="relative">
            <div class="flex flex-wrap gap-2 justify-center border-b p-2">
                <figure class=" w-36 h-36 rounded-md overflow-hidden flex justify-center items-center">
                    @if ($imagen == null)
                        <img class="w-full h-full " style="width: 100px;"
                            src="{{ asset('storage/product-photos/imagedefault.jpg') }}" alt="Imagen" />
                    @else
                        <img class="w-full h-full " style="width: 100px;"
                            src="{{ asset('storage/' . $imagen) }}" alt="Imagen" />
                    @endif
                </figure>
                <div class=" flex flex-wrap flex-col gap-2">
                    <div class="flex flex-wrap gap-1 items-center">
                        <h2 class=" text-lg font-bold">Categoría: </h2>
                        <div>{{ $categoria }}</div>
                    </div>
                    <div class="flex flex-wrap gap-1 items-center">
                        <h2 class=" text-lg font-bold">Marca: </h2>
                        <div>{{ $marca }}</div>
                    </div>
                    <div class="flex flex-wrap gap-1 items-center">
                        <h2 class=" text-lg font-bold">Modelo: </h2>
                        <div>{{ $modelo }}</div>
                    </div>
                    <div class="flex flex-wrap gap-1 items-center">
                        <h2 class=" text-lg font-bold">Unidad de medida: </h2>
                        <div>{{ $unidad }}</div>
                    </div>
                </div>
            </div>
            <div class=" text-left pt-2">
                <h2 class=" text-lg font-bold">Descripcion: </h2>
                <div class="max-h-[300px]">
                    {{ $descripcion }}
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('modal',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
