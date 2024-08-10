<div>
    <button wire:click='lock({{$salidaID}})' wire:loading.attr="disabled" aria-label="reasignar-usuario" title="Confirmar documento">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400 hover:text-indigo-500 transition duration-300">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
        </svg>
    </button>
</div>