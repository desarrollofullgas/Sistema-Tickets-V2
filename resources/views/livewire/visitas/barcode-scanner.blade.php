<div class="mb-4">
    <input type="text" 
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:border-gray-600 dark:bg-dark-eval-1 dark:focus:ring-offset-dark-eval-1 w-full"
        wire:model="barcode" wire:keydown.enter="buscarUsuario" placeholder="Escanea el código de barras">

    @if (count($usuarios) > 0)
    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2">
        @foreach ($usuarios as $item)
            <div class="bg-white border p-2 border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                {{-- <div class="flex justify-end px-4 pt-4">
                    <!-- Validamos si es un array o un objeto -->
                    @if(is_array($item))
                        <span>{{ $item['status'] }}</span>
                    @else
                        <span>{{ $item->status }}</span>
                    @endif
                </div> --}}
                <div class="flex flex-col items-center pb-6">
                    <!--Foto del usuario -->
                    @if (isset($item['profile_photo_path']))
                        <img class="w-24 h-24 mb-3 rounded-full shadow-lg"
                            src="{{ Storage::url($item['profile_photo_path']) }}" alt="{{ $item['name'] }} foto">
                    @elseif (isset($item->profile_photo_path))
                        <img class="w-24 h-24 mb-3 rounded-full shadow-lg"
                            src="{{ Storage::url($item->profile_photo_path) }}" alt="{{ $item->name }} foto">
                    @else
                        <img class="w-24 h-24 mb-3 rounded-full shadow-lg"
                            src="{{ $item['profile_photo_url'] }}" alt="{{ $item['name'] }}'s profile photo">
                    @endif
                    <!-- Nombre y permiso del usuario -->
                    @if(is_array($item))
                        <h5 class="mb-1 text-xl font-medium text-center text-gray-900 dark:text-white">{{ $item['name'] }}</h5>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $item['permiso']['titulo_permiso'] }}</span>
                    @else
                        <h5 class="mb-1 text-center text-gray-900 dark:text-white">{{ $item->name }}</h5>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $item->permiso->titulo_permiso }}</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

        <div class="flex mt-4 md:mt-6">
            <!-- Botón para registrar todas las visitas -->
            <x-danger-button wire:click="updateVisita" wire:loading.attr="disabled">
                Registrar Visita
            </x-danger-button>

            <!-- Botón limpiar -->
            <x-secondary-button wire:click="limpiarListaUsuarios" class="ml-3" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </div>
    @endif
</div>