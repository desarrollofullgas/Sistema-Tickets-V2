<div class="col-md-4 col-sm-6 col-6 d-flex justify-content-end justify-content-md-end justify-content-sm-end">
    <div class="">
        <x-button wire:click="$set('modal',true)" class="dark:border-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700">
            <i class="fa-solid fa-plus"></i>
            {{ __('Asignar correo') }}
            </x-jet-button>
    </div>

    <x-dialog-modal wire:model="modal" id="modalRepuesto" class="flex items-center">
        <x-slot name="title">
            {{ __('Nueva asignación') }}
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col flex-wrap gap-3 justify-evenly items-center py-2" x-data="{producto:false}">
                <div class="text-center mb-2">
                    <div class="flex justify-center gap-2">
                        <div @click="producto=true">
                            <input wire:model="tipo" type="radio" name="tipo" id="Producto" value="Producto" class="peer/producto hidden">
                            <label for="Producto" class="cursor-pointer bg-gray-300 dark:bg-dark-eval-0 peer-checked/producto:bg-amber-600 hover:bg-amber-500 text-white px-3 py-1 rounded-md transition duration-300">
                                Producto
                            </label>
                        </div>
                        <div @click="producto=false">
                            <input wire:model="tipo" type="radio" name="tipo" id="Servicio" value="Servicio" class=" peer/producto hidden">
                            <label for="Servicio" class="cursor-pointer bg-gray-300 dark:bg-dark-eval-0 peer-checked/producto:bg-amber-600 hover:bg-amber-500 text-white px-3 py-1 rounded-md transition duration-300">
                                Servicio
                            </label>
                        </div>
                    </div>
                    <x-input-error for="tipo"></x-input-error>
                </div>
                <div x-cloak x-show="producto" x-collapse>
                    <x-label value="{{ __('Categoría de compra') }}" for="tipo"/>
                    <select wire:model.defer="categoria" name="tipo" id="tipo"
                        class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        <option hidden value="" selected>Seleccionar categoría</option>
                        @foreach ($tipos as $tipo)
                            <option value="{{$tipo->id}}">{{$tipo->name}}</option>
                        @endforeach
                    </select>
                    <x-input-error for="categoria"></x-input-error>
                </div>
                <div class="w-full">
                    <x-label value="{{ __('Correo') }}" for="correo"/>
                    <select wire:model.defer="correos" name="correo[]" id="correo" multiple="multiple" style="width: 100%"
                        class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        @foreach ($emails as $email)
                            <option value="{{$email->id}}">{{$email->correo}}</option>
                        @endforeach
                    </select>
                    <x-input-error for="correos"></x-input-error>
                </div>
                <div class="w-full">
                    <x-label value="{{ __('Zonas') }}" for="zonas"/>
                    <select wire:model.defer="zonasAsignadas" name="zonas[]" id="zonas" multiple="multiple" style="width: 100%"
                        class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        @foreach ($zonas as $zonas)
                            <option value="{{$zonas->id}}">{{$zonas->name}}</option>
                        @endforeach
                    </select>
                    <x-input-error for="zonasAsignadas"></x-input-error>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addCorreo" wire:loading.attr="disabled">
                <div role="status" wire:loading wire:target="addCorreo">
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
                    $('#correo').select2({
                        placeholder: "Seleccionar correo(s)...",
                        allowClear: true,
                    }).on('change', function() {
                        @this.set('correos', $(this).val());
                    });
                    
                    $('#zonas').select2({
                        placeholder: "Seleccionar zonas(s)...",
                        allowClear: true
                    }).on('change', function() {
                        @this.set('zonasAsignadas', $(this).val());
                    });
                });
            });
            
        </script>
    @endpush
</div>