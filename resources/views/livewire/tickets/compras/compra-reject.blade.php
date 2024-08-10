<div>
    <button  wire:click="$set('modal',true)" wire:loading.attr="disabled" 
        class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400 hover:text-red-500">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
          <span class="tooltiptext">Rechazar requisición</span>
    </button>


    <x-dialog-modal wire:model="modal" class="flex items-center">
        <x-slot name="title">
            <div class="bg-dark-eval-1 p-2 rounded-md text-white text-center">
                {{ __('Motivo de Rechazo') }}
            </div>
        </x-slot>

        <x-slot name="content">
            <div>
                <x-label value="{{ __('Observación') }}" />
                <textarea wire:model="observacion" class="resize-none rounded-md w-full " name="observacion" required autofocus></textarea>
                <x-input-error for="observacion"></x-input-error>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="rechazo({{ $compraID }})" wire:loading.attr="disabled">
                {{ __('Aceptar')}}
            </x-danger-button>

            <x-secondary-button wire:click="$toggle('modal')" wire:loading.attr="disabled">
                {{ __('Cerrar') }}
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
