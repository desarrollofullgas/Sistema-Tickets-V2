<div class="col-md-4 col-sm-6 col-6 d-flex justify-content-end justify-content-md-end justify-content-sm-end">
    <div class="">
        <x-button wire:click="$set('modal',true)" class="dark:border-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700">
            {{ __('Añadir Ticket') }}
            </x-button>
    </div>

    <x-dialog-modal wire:model="modal" id="modalRepuesto" class="flex items-center">
        <x-slot name="title">
            <div class="bg-dark-eval-1 dark:bg-dark-eval-2 p-2 rounded-md text-white text-center">
                {{ __('Nuevo Ticket') }}
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-wrap gap-3 justify-evenly items-center">
                {{-- <div>
                            <x-label value="{{ __('Departamento') }}" for="departamento"/>
                            <select id="departamento" name="departamento" class="border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700" wire:model="departamento">
                                <option value="">Seleccionar Departamento</option>
                                @foreach ($departamentos as $dep)
                                    <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error for="departamento"></x-input-error>
                        </div> --}}
                
                <div>
                    <x-label value="{{ __('Área') }}" for="area" />
                    <select id="area" name="area" class="rounded-md dark:bg-slate-800 dark:border-gray-700"
                        wire:model="area">
                        <option value="">Seleccionar Área</option>
                        @if (auth()->user() && in_array(auth()->user()->id, $usersSistemas->pluck('id')->toArray()))
                            @foreach ($areasSistem as $sistem)
                                <option value="{{ $sistem->id }}">{{ $sistem->name }}</option>
                            @endforeach
                        @else
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    <x-input-error for="area"></x-input-error>
                </div>
                @if ($servicios)
                    <div>
                        <x-label value="{{ __('Servicio') }}" for="servicio" />
                        <select wire:model="servicio" name="servicio" id="servicio"
                            class="rounded-md dark:bg-slate-800 dark:border-gray-700">
                            <option hidden value="" selected>Seleccionar Servicio</option>
                            @foreach ($servicios as $servicio)
                                <option value="{{ $servicio->id }}">{{ $servicio->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="servicio"></x-input-error>
                    </div>
                @endif
                @if ($fallas)
                    <div>
                        <x-label value="{{ __('Falla') }}" for="falla" />
                        <select wire:model="falla" name="falla" id="falla" style="width: 150px;"
                            class="rounded-md dark:bg-slate-800 dark:border-gray-700">
                            <option hidden value="" selected>Seleccionar falla</option>
                            @foreach ($fallas as $falla)
                                <option value="{{ $falla->id }}">{{ $falla->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="falla"></x-input-error>
                    </div>
                @endif
                {{-- <div class="w-full">
                    <div>Falla</div>
                    <select wire:model="falla" name="falla" id="fallaSelect" style="width: 100%;"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                    dark:focus:ring-offset-dark-eval-1 w-full">
                        <option hidden value="" selected>Seleccionar falla</option>
                        @foreach ($servicios as $servicio)
                            @if ($servicio->fallas->count() > 0)    
                                <optgroup label="{{$servicio->name}}">
                                    @foreach ($servicio->fallas as $falla)
                                        <option value="{{$falla->id}}">{{$falla->name}}</option>
                                    @endforeach
                                </optgroup>
                            @endif
                        @endforeach
                    </select>
                    <x-input-error for="falla"></x-input-error>
                </div> --}}
                {{-- @if ($personal)
                    <div>
                        <x-label value="{{ __('Agente') }}" for="personal" />
                        <select wire:model="asignado" name="personal" id="personal"
                            class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                            <option hidden value="" selected>Seleccionar agente</option>
                            @foreach ($personal as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="asignado"></x-input-error>
                    </div>
                @endif --}}
            </div>
            <div class="flex flex-wrap gap-2">
                {{-- <div class="w-full">
                    <div>Asunto</div>
                    <x-input wire:model="asunto" type="text" name="asunto" id="asunto"
                        class="w-full  border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700 dark:text-white"
                        required  autocomplete="asunto" />
                    <x-input-error for="asunto"></x-input-error>
                </div> --}}
                <div class="w-full">
                    {{-- <x-label value="{{ __('Detalles') }}" for="mensaje" /> --}}
                    <div>Detalles</div>
                    <textarea wire:model="mensaje"
                        class="resize-none w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700 {{ $errors->has('mensaje') ? 'is-invalid' : '' }} resize-none"
                        name="mensaje" required  autocomplete="mensaje">
                    </textarea>
                    <x-input-error for="mensaje"></x-input-error>
                </div>
            </div>
            <div class="mb-3 col-12 w-full" x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress">

                <x-label value="{{ __('Evidencias') }}" class="border-b border-gray-400 w-full text-left mb-2" />
                <input type="file" wire:model="evidencias"
                    class="flex flex-wrap file:text-sm file:font-semibold file:bg-blue-300 file:text-blue-700 hover:file:bg-blue-100 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0"
                    multiple name="evidencias" required autocomplete="evidencias"
                    accept="image/*, .pdf, .doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                <x-input-error for="evidencias"></x-input-error>

                <!-- Progress Bar -->
                <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-2.5 mb-2 dark:bg-gray-700">
                    <div class="bg-red-600 h-2.5 rounded-full dark:bg-red-500 transition-[width] duration-500"
                        x-bind:style="`width:${progress}%`"></div>
                </div>
            </div>

        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addTicket" wire:loading.attr="disabled">
                <div role="status" wire:loading wire:target="addTicket">
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
        document.addEventListener('livewire:load',()=>{
            Livewire.hook('message.processed',(message,component)=>{

                $('#fallaSelect').select2({
                    placeholder: "Seleccionar falla",
                    allowClear: true,
                }).on('change', function() {
                    @this.set('falla', $(this).val());
                });
            });
        });
        
    </script>
@endpush
</div>