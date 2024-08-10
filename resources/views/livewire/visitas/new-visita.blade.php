@php
    $canSelectStation = Auth::user()->permiso_id != 3 && Auth::user()->permiso_id != 2;
@endphp
<div class="col-md-4 col-sm-6 col-6 d-flex justify-content-end justify-content-md-end justify-content-sm-end">
    <div class="">
        <x-button wire:click="$set('modal',true)" class="dark:border-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700">
            <i class="fa-solid fa-plus"></i>
            {{ __('Programar visita') }}
            </x-jet-button>
    </div>
    <x-dialog-modal wire:model="modal" id="modalRepuesto" class="flex items-center">
        <x-slot name="title">
            <div class="bg-dark-eval-1 dark:bg-gray-600 p-2 rounded-md text-white text-center">
                {{ __('Visita') }}
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="flex gap-2 justify-evenly ">

                {{-- <div class="mb-4">
                    <x-label value="{{ __('Usuario') }}" for="usuario" />
                    <select id="usuario" wire:model="usuario"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('usuario') ? 'is-invalid' : '' }}"
                        name="usuario" required>
                        <option value="">Seleccionar Usuario</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="usuario"></x-input-error>
                </div> --}}
                <div class="mb-4">
                    <x-label value="{{ __('Fecha') }}" for="fecha" />
                    <x-input wire:model="fecha" type="datetime-local" name="fecha"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1"
                        id="fecha" required autofocus autocomplete="fecha" />
                    <x-input-error for="fecha"></x-input-error>
                </div>
                @if (Auth::user()->permiso_id != 3)
                    <div class="mb-4">
                        <x-label value="{{ __('Estación') }}" />
                        <select id="estacion" wire:model="estacion"
                            class="border-gray-300 dark:bg-dark-eval-{{ $canSelectStation ? '1' : '0' }} dark:text-{{ $canSelectStation ? 'gray' : 'black' }} focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('estacion') ? 'is-invalid' : '' }}"
                            name="estacion" required aria-required="true">

                            <option {{ $canSelectStation ? '' : 'hidden value="" selected' }}>Seleccionar Estación
                            </option>
                            @foreach ($canSelectStation ? $estacions : $superEsta as $esta)
                                <option value="{{ $esta->id }}">{{ $esta->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="estacion"></x-input-error>
                    </div>
                @endif
            </div>
            <div class="mb-2" wire:ignore>
                <x-label value="{{ __('Motivo') }}" for="motivo" />
                    <select id="select2" name="fallasList[ ]" 
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                 dark:focus:ring-offset-dark-eval-1 w-full"
                        multiple="multiple">
                        @foreach ($fallas as $falla)
                            <option value="{{ $falla->id }}">{{ $falla->name }}</option>
                        @endforeach
                    </select>
                <x-input-error for="motivo"></x-input-error>
            </div>
            <div>
                <x-label value="{{ __('Detalles adicionales de la visita') }}" for="motivo" />
                <textarea wire:model.defer="motivo"
                    class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700 {{ $errors->has('motivo') ? 'is-invalid' : '' }}"
                    name="motivo" required autocomplete="motivo">
                        </textarea>
                <x-input-error for="motivo"></x-input-error>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="programarVisita" wire:loading.attr="disabled">
                <div role="status" wire:loading wire:target="programarVisita">
                    <svg aria-hidden="true"
                        class="inline w-4 h-4 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-white"
                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor" />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentFill" />
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$set('modal',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
    @push('scripts')
        <script>
            document.addEventListener('livewire:load', function () {
                Livewire.hook('message.processed', (message, component) => {
                    $('#select2').select2({
                        placeholder: "Seleccionar motivo(s)...",
                        allowClear: true
                    }).on('change', function () {
                        @this.set('fallasList', $(this).val());
                    });
                });
            });
        </script>
    @endpush
</div>
