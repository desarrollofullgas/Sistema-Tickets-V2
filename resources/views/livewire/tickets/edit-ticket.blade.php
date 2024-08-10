<div class="p-4  overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
    <div class="bg-dark-eval-1 p-1 rounded-md text-white text-center mb-2">
        {{ __('Editar Ticket') }}
    </div>
    <div>
        <div class="flex flex-wrap justify-evenly gap-2">
            <div class="mb-2">
                <x-label value="{{ __('Creado') }}" for="creado" />
                <x-input wire:model.defer="creado" type="datetime-local" name="creado" id="creado"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1" />
                <x-input-error for="creado"></x-input-error>
            </div>
            <div class="mb-2">
                <x-label value="{{ __('Vencimiento') }}" for="vence" />
                <x-input wire:model.defer="vence" type="datetime-local" name="vence" id="vence"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1" />
                <x-input-error for="vence"></x-input-error>
            </div>
			<div>
                <x-label value="{{ __('Vencido:') }}" />
                <select id="vencido" wire:model.defer="vencido"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('vencido') ? 'is-invalid' : '' }}"
                    name="vencido" required aria-required="true">
                    <option hidden value="">Seleccionar estado del ticket</option>
                    <option value="0" @if ($vencido == 0) {{ 'selected' }} @endif>
                        Sin Vencer</option>
                    <option value="1" @if ($vencido == 1) {{ 'selected' }} @endif>
                        Vencido</option>
                </select>
                <x-input-error for="vencido"></x-input-error>
            </div>
        </div>
        @if ($this->cerrado != NULL)
            <div class=" mb-2">
                <x-label value="{{ __('Cerrado') }}" for="cerrado" />
                <x-input wire:model.defer="cerrado" type="datetime-local" name="cerrado" id="cerrado"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1" />
                <x-input-error for="cerrado"></x-input-error>
            </div>
        @endif
        <div class="flex  gap-2 justify-evenly items-center mb-2">
            <div>
                <x-label value="{{ __('Departamento') }}" for="departamento" />
                <select id="departamento" name="departamento"
                    class="w-auto border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700"
                    wire:model.defer="departamento">
                    <option value="">Seleccionar Departamento</option>
                    @foreach ($departamentos as $dep)
                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                    @endforeach
                </select>
                <x-input-error for="departamento"></x-input-error>
            </div>
            <div>
                <x-label value="{{ __('Área') }}" for="area" />
                <select wire:model="area" name="area" id="area"
                    class="w-auto border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                    <option hidden value="" selected>Seleccionar Área</option>
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                    @endforeach
                </select>
                <x-input-error for="area"></x-input-error>
            </div>
        </div>
        <div class="flex gap-2 justify-evenly items-center mb-2">
            <div>
                <x-label value="{{ __('Servicio') }}" for="servicio" />
                <select wire:model="servicio" name="servicio" id="servicio" 
                    class="w-auto border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                    <option hidden value="" selected>Seleccionar Servicio</option>
                    @foreach ($servicios as $servicio)
                        <option value="{{ $servicio->id }}">{{ $servicio->name }}</option>
                    @endforeach
                </select>
                <x-input-error for="servicio"></x-input-error>
            </div>
            
            @if ($fallas)
                <div>
                    <x-label value="{{ __('Falla') }}" for="falla" />
                    <select wire:model.defer="falla" name="falla" id="falla"
                        class="w-auto border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        <option hidden value="" selected>Seleccionar falla</option>
                        @foreach ($fallas as $falla)
                            <option value="{{ $falla->id }}">{{ $falla->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="falla"></x-input-error>
                </div>
            @endif

        </div>
        <div class="flex gap-2 justify-evenly items-center mb-2">
            <div>
                <x-label value="{{ __('Cliente') }}" for="cliente" />
                <select wire:model.defer="cliente" name="cliente" id="cliente"
                    class="w-auto border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                    <option hidden value="" selected>Seleccionar cliente</option>
                    @foreach ($clientes as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
                <x-input-error for="cliente"></x-input-error>
            </div>
            @if ($agentes)
                <div>
                    <x-label value="{{ __('Agente') }}" for="personal" />
                    <select wire:model.defer="agente" name="personal" id="personal"
                        class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        <option hidden value="" selected>Seleccionar agente</option>
                        @foreach ($agentes as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="agente"></x-input-error>
                </div>
            @endif
            <div>
                <x-label value="{{ __('Estado del ticket') }}" />
                <select id="status" wire:model.defer="status"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('status') ? 'is-invalid' : '' }}"
                    name="status" required aria-required="true">
                    <option hidden value="">Seleccionar estado del ticket</option>
                    <option value="Abierto" @if ($status == 'Abierto') {{ 'selected' }} @endif>
                        Abierto</option>
                    <option value="En proceso" @if ($status == 'En proceso') {{ 'selected' }} @endif>
                        En proceso</option>
                    <option value="Cerrado" @if ($status == 'Cerrado') {{ 'selected' }} @endif>
                        Cerrado</option>
                        <option value="Por abrir" @if ($status == 'Por abrir') {{ 'selected' }} @endif>
                            Por abrir</option>
                </select>
                <x-input-error for="status"></x-input-error>
            </div>
        </div>
        <div class="flex flex-wrap gap-2 ">
            {{-- <div class="w-full">
                <x-label value="{{ __('Asunto') }}" for="asunto" />
                <x-input wire:model.defer="asunto" type="text" name="asunto" id="asunto" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                dark:text-gray-300 dark:focus:ring-offset-dark-eval-1" required
                    autocomplete="asunto" />
                <x-input-error for="asunto"></x-input-error>
            </div> --}}
            <div class="w-full mt-3">
                <x-label value="{{ __('Descripción') }}" for="mensaje" />
                <textarea wire:model.defer="mensaje"
                    class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700 {{ $errors->has('mensaje') ? 'is-invalid' : '' }}"
                    name="mensaje" required  autocomplete="mensaje">
                </textarea>
                <x-input-error for="mensaje"></x-input-error>
            </div>
        </div>
    </div>
    <div class="mb-3 mt-3 col-12 w-full" x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
        x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress">

        <x-label value="{{ __('Subir evidencias') }}" class="border-b border-gray-400 w-full text-left mb-2" />
        <input type="file" wire:model="evidencias"
            class="flex flex-wrap file:text-sm file:font-semibold file:bg-blue-300 file:text-blue-700 hover:file:bg-blue-100 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0"
            multiple name="evidencias" required autocomplete="evidencias"
            accept="video/*, image/*, .pdf, .doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
        <x-input-error for="evidencias"></x-input-error>

        <!-- Progress Bar -->
        <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-2.5 mb-2 dark:bg-gray-700">
            <div class="bg-red-600 h-2.5 rounded-full dark:bg-red-500 transition-[width] duration-500"
                x-bind:style="`width:${progress}%`"></div>
        </div>
    </div>

    <x-danger-button class="mr-2 float-right" wire:click="updateTicket({{ $ticketID }})"
        wire:loading.attr="disabled">
        <div role="status" wire:loading wire:target="updateTicket">
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
