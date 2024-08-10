@php
    $canSelectStation = Auth::user()->permiso_id != 3 && Auth::user()->permiso_id != 2;
@endphp
<div>
    <button wire:click="$set('modal',true)" wire:loading.attr="disabled"
        class="text-gray-400 duration-300 flex items-center gap-2 hover:text-gray-600">
        {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg> --}}
        <span>Editar Visita</span>
    </button>
    <x-dialog-modal wire:model="modal" id="modalRepuesto" class="flex items-center">
        <x-slot name="title">
            <div class="bg-dark-eval-1 dark:bg-gray-600 p-2 rounded-md text-white text-center">
                {{ __('Editar visita') }}
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-wrap gap-3 justify-evenly items-center max-h-[320px] overflow-y-auto">
                <div class="mb-4">
                    <x-label value="{{ __('Fecha') }}" for="fecha" />
                    <x-input wire:model="fecha" type="datetime-local" name="fecha"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1"
                        id="fecha" required autofocus autocomplete="fecha" />
                    <x-input-error for="fecha"></x-input-error>
                </div>
                @if ($estacion)
                    @if (Auth::user()->permiso_id != 3)
                        <div class="mb-4">
                            <x-label value="{{ __('Estación') }}" />
                            <select id="estacion" wire:model="estacion"
                                class="border-gray-300 dark:bg-dark-eval-{{ $canSelectStation ? '1' : '0' }} dark:text-{{ $canSelectStation ? 'gray' : 'black' }} focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('estacion') ? 'is-invalid' : '' }}"
                                name="estacion" required aria-required="true">

                                <option {{ $canSelectStation ? '' : 'hidden value="" selected' }}>Seleccionar Estación
                                </option>
                                @foreach ($canSelectStation ? $estacions : $superEsta as $esta)
                                    <option value="{{ $esta->id }}"
                                        @if (old('estacion') == $esta->id) selected @endif>{{ $esta->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error for="estacion"></x-input-error>
                        </div>
                    @endif
                @endif
                <div class="mb-4">
                    <x-label value="{{ __('Solicita') }}" for="solicita" />
                    <select id="solicita" wire:model="solicita"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                        dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('solicita') ? 'is-invalid' : '' }}"
                        name="solicita" required>
                        <option value="">Seleccionar solicitante</option>
                        @foreach ($solicitan as $user)
                            <option value="{{ $user->id }}"@if (old('solicita') == $user->id) selected @endif>
                                {{ $user->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="usuario"></x-input-error>
                </div>
                 @if($usuario)
                    <div class="mb-4">
                        <x-label value="{{ __('Usuarios') }}"  for="usuario"/>
                        <div class="max-h-[100px] min-w-[120px] overflow-y-auto">
                            @foreach ($users as $tag)
                                <div class="flex items-center">
                                    <input type="checkbox" wire:model="usuario" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                                    dark:text-gray-300 dark:focus:ring-offset-dark-eval-1" value="{{ $tag->id }}"
                                        name="names[]" id="{{ $tag->name }}" multiple>
                                    <label for="{{ $tag->name }}"  @if (old('usuario') == $tag->id) selected @endif>{{ $tag->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <x-input-error for="area"></x-input-error>
                    </div>
                @endif 
                <div class="mb-4">
                    <x-label value="{{ __('Estado') }}" />
                    <select id="status" wire:model="status"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                        dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('status') ? 'is-invalid' : '' }}"
                        name="status" required aria-required="true">
                        <option hidden value="">Seleccionar Status</option>
                        <option value="Pendiente" @if ($status == 'Pendiente') {{ 'selected' }} @endif>
                            Pendiente</option>
                        <option value="En proceso" @if ($status == 'En proceso') {{ 'selected' }} @endif>
                            En proceso</option>
                        <option value="No realizado" @if ($status == 'No realizado') {{ 'selected' }} @endif>
                            No realizado</option>
                        <option value="Cancelada" @if ($status == 'Cancelada') {{ 'selected' }} @endif>
                            Cancelada</option>
                        <option value="Completado" @if ($status == 'Completado') {{ 'selected' }} @endif>
                            Completado</option>
                    </select>
                    <x-input-error for="status"></x-input-error>
                </div>
                <div class="mb-4">
                    <x-label value="{{ __('Motivo Visita') }}" />
                    <div class="max-h-[100px] min-w-[120px] overflow-y-auto">
                        @foreach ($fallas as $tag)
                            <div class="flex items-center">
                                <input type="checkbox" wire:model="fallasUpdate" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                                dark:text-gray-300 dark:focus:ring-offset-dark-eval-1" value="{{ $tag->id }}"
                                    name="names[]" id="{{ $tag->name }}" multiple>
                                <label for="{{ $tag->name }}"  @if (old('fallasUpdate') == $tag->id) selected @endif>{{ $tag->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    <x-input-error for="area"></x-input-error>
                </div>
                <div class="mb-4">
                    <x-label value="{{ __('Observacion') }}" for="motivo" />
                    <textarea wire:model.defer="motivo"
                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700 {{ $errors->has('motivo') ? 'is-invalid' : '' }}"
                        name="motivo" required autocomplete="motivo">
                            </textarea>
                    <x-input-error for="motivo"></x-input-error>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="updateVisita({{ $visitaID }})"
                wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$set('modal',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
