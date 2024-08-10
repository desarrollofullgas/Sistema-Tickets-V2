<div>
    <div class="">
        <x-button wire:click="$set('modal',true)" class="dark:border-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700">
            <i class="fa-solid fa-plus"></i>
            {{ __('Nueva') }}
            </x-jet-button>
    </div>

    <x-dialog-modal wire:model="modal" id="modalRepuesto" class="flex items-center">
        <x-slot name="title">
            <div class="bg-dark-eval-1 p-2 rounded-md text-white text-center">
                {{ __('Nueva Marca') }}
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-wrap gap-3 justify-evenly items-center">
                <div>
                    <x-label value="{{ __('Nombre de la marca') }}" for="name" />
                    <x-input wire:model="name" type="text" name="name"
                        id="name" required autofocus autocomplete="name" />
                    <x-input-error for="name"></x-input-error>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addMarca" wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$set('modal',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
