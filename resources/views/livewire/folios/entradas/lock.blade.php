<div>
    <button wire:click='lock({{$entradaID}})' wire:loading.attr="disabled" aria-label="reasignar-usuario" title="Confirmar documento" class="flex gap-1 items-center px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
        </svg>
        <span>Validar documento</span>
    </button>
</div>