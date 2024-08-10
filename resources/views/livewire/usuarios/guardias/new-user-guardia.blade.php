<div class="col-md-4 col-sm-6 col-6 d-flex justify-content-end justify-content-md-end justify-content-sm-end">
    <div class="">
        <x-button wire:click="$set('modal',true)" class="dark:border-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700">
            <i class="fa-solid fa-plus"></i>
            {{ __('Añadir usuario') }}
            </x-jet-button>
    </div>

    <x-dialog-modal wire:model="modal" id="modalRepuesto" class="flex items-center">
        <x-slot name="title">
            <div class="bg-dark-eval-1 dark:bg-gray-600 p-1 rounded-md text-white text-center">
                {{ __('Agregar Usuario para Guardia') }}
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-wrap gap-3 justify-evenly items-center">
                <div class="w-full">
                    <x-label value="{{ __('Usuario') }}" for="usuario"/>
                    <select wire:model="usuario" name="usuario" id="userSelect" style="width: 100%;"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                    dark:focus:ring-offset-dark-eval-1 w-full">
                        <option></option>
                        @foreach ($personal as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                    <x-input-error for="usuario"></x-input-error>
                </div>               
            </div>        
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addGuardia" wire:loading.attr="disabled">
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

                $('#userSelect').select2({
                    placeholder: "Seleccionar usuario",
                    allowClear: true,
                }).on('change', function() {
                    @this.set('usuario', $(this).val());
                });
            });
        });
        
    </script>
@endpush
</div>