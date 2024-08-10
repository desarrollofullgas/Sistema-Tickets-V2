<div>
    <x-button
        class="float-right  hover:bg-gray-400 text-gray-100 dark:bg-gray-700  dark:hover:bg-gray-200 dark:hover:text-gray-800"
        wire:click="showModalFormUsuario">
        {{ __('Nuevo Usuario') }}
    </x-button>

    <x-dialog-modal wire:model="newgUsuario" id="modalUsuario" class="flex items-center">
        <x-slot name="title">
            <div class="bg-dark-eval-1 dark:bg-gray-600 p-1 rounded-md text-white text-center">
                {{ __('Nuevo Usuario') }}
            </div>
        </x-slot>

        <x-slot name="content">
            {{-- Paso #1 --}}
            <div wire:key="step1" class="{{ $currentStep == 1 ? 'block' : 'hidden' }}">
                <div class="flex items-center justify-center">
                    <span
                        class="bg-green-100 text-green-800 text-xl font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{ __('Datos Personales') }}</span>
                </div>
                <div class="flex flex-wrap gap-3 justify-evenly items-center">
                    <div class="md:w-1/2 px-3 mb-2 md:mb-2">
                        <x-label value="{{ __('Nombre') }}" />
                        <x-input wire:model.defer="name"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:border-gray-600 dark:bg-dark-eval-1
                        dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('name') ? 'is-invalid' : '' }}"
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error for="name"></x-input-error>
                    </div>
                    <div class="md:w-1/2 px-3 mb-2 md:mb-2">
                        <x-label value="{{ __('Usuario') }}" />
                        <x-input wire:model.defer="username"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('username') ? 'is-invalid' : '' }}"
                            type="text" name="username" :value="old('username')" required autofocus
                            autocomplete="username" />
                        <x-input-error for="username"></x-input-error>
                    </div>
                </div>
                <div class="md:w-full px-3 mb-3">
                    <x-label value="{{ __('Correo Electrónico') }}" />
                    <x-input wire:model.defer="email"
                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                        dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('email') ? 'is-invalid' : '' }}"
                        type="email" name="email" :value="old('email')" required />
                    <x-input-error for="email"></x-input-error>
                </div>
				<div class="md:w-full px-3 mb-3">
                    <x-label value="{{ __('Teléfono') }}" />
                    <x-input wire:model.defer="tel"
                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                        dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('tel') ? 'is-invalid' : '' }}"
                        type="tel" name="tel" :value="old('tel')" required />
                    <x-input-error for="tel"></x-input-error>
                </div>

                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <button
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-dark-eval-3 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                        wire:click="nextStep">
                        {{ __('Siguiente') }}
                    </button>
                </div>
            </div>
            {{-- Paso #2 --}}
            <div wire:key="step2" class="{{ $currentStep == 2 ? 'block' : 'hidden' }}">
                <div class="flex items-center justify-center">
                    <span
                        class="bg-green-100 text-green-800 text-xl font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{ __('Datos Cuenta') }}</span>
                </div>

                <div class="flex flex-wrap gap-3 justify-evenly items-center">
                    <div class="md:w-1/2 px-3 mb-2 md:mb-0">
                        <x-label value="{{ __('Rol') }}" />
                        <select id="permiso" wire:model="permiso" 
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700 {{ $errors->has('permiso') ? 'is-invalid' : '' }}"
                            name="permiso" required aria-required="true">
                            <option hidden value="" selected>Seleccionar Rol</option>
                            @foreach ($permisos as $permiso)
                                <option value="{{ $permiso->id }}">{{ $permiso->titulo_permiso }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="permiso"></x-input-error>
                    </div>
                    {{-- @if ($zonau) --}}
                        <div class="md:w-1/2 px-3 mb-2 md:mb-0" wire:ignore>
                            <x-label value="{{ __('Zona') }}" />
                            <select id="select2" name="zonasList[ ]"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                             dark:focus:ring-offset-dark-eval-1 w-full"
                                multiple="multiple">
                                @foreach ($zonas as $zona)
                                    <option value="{{ $zona->id }}">{{ $zona->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error for="zona"></x-input-error>
                        </div>
                    {{-- @endif --}}
                </div>
                <div class="flex flex-wrap gap-3 justify-evenly items-center">
                    {{-- @if ($areau) --}}
                        <div class="md:w-1/2 px-3 mb-6 md:mb-0" wire:ignore>
                            <x-label value="{{ __('Area') }}" />
                            <select id="select3" name="areasList[ ]" 
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                         dark:focus:ring-offset-dark-eval-1 w-full"
                                multiple="multiple">
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error for="area"></x-input-error>
                        </div>
                    {{-- @endif --}}
                    <div class="md:w-1/2 mb-6 md:mb-0">
                        <x-label value="{{ __('Región') }}" />
                        <select id="region" wire:model="region"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700 {{ $errors->has('region') ? 'is-invalid' : '' }}"
                            name="region" required aria-required="true">
                            <option hidden value="" selected>Seleccionar Región</option>
                            @foreach ($regiones as $region)
                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="region"></x-input-error>
                    </div>
                </div>
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <button
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-dark-eval-3 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                        wire:click="nextStep2">
                        {{ __('Siguiente') }}
                    </button>
                    <button
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-dark-eval-3 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                        wire:click="previousStep">
                        {{ __('Anterior') }}
                    </button>
                </div>
            </div>
            {{-- Paso #3 --}}
            <div wire:key="step3" class="{{ $currentStep == 3 ? 'block' : 'hidden' }}">
                <div class="flex items-center justify-center">
                    <span
                        class="bg-green-100 text-green-800 text-xl font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{ __('Datos Acceso') }}</span>
                </div>
                <div class="flex flex-wrap gap-3 justify-evenly items-center">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-label value="{{ __('Contraseña') }}" />
                        <x-input wire:model.defer="password"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                    dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('password') ? 'is-invalid' : '' }}"
                            type="password" name="password" required autocomplete="new-password"
                            wire:keydown.enter="addUsuario" />
                        <x-input-error for="password"></x-input-error>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <x-label value="{{ __('Confirmar Contraseña') }}" />
                        <x-input
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                        dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                            type="password" wire:model.defer="password_confirmation" name="password_confirmation"
                            required autocomplete="new-password" wire:keydown.enter="addUsuario" />
                        <x-input-error for="password_confirmation"></x-input-error>
                    </div>
                </div>
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <button
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-dark-eval-3 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                        wire:click="previousStep">
                        {{ __('Anterior') }}
                    </button>
                    <x-danger-button class="mr-2" wire:click="addUserTCK" wire:loading.attr="disabled">
                        <div role="status" wire:loading wire:target="addUserTCK">
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
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-secondary-button wire:click="$toggle('newgUsuario')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
    @push('scripts')
        <script>
            document.addEventListener('livewire:load', function () {
                Livewire.hook('message.processed', (message, component) => {
                    $('#select2').select2({
                        placeholder: "Seleccionar zona(s)...",
                        allowClear: true
                    }).on('change', function () {
                        @this.set('zonasList', $(this).val());
                    });

                    $('#select3').select2({
                        placeholder: "Seleccionar area(s)...",
                        allowClear: true
                    }).on('change', function () {
                        @this.set('areasList', $(this).val());
                    });
                });
            });
        </script>
    @endpush
</div>
