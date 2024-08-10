<div>

    <button wire:click="confirmShowCategoria({{ $categoria_show_id }})" wire:loading.attr="disabled"
        class="tooltip" data-target="ShowCategoria{{ $categoria_show_id }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-yellow-500 dark:hover:text-yellow-300">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span class="tooltiptext">Ver Más</span>
    </button>

    <x-dialog-modal wire:model="ShowgCategoria" id="ShowCategoria{{ $categoria_show_id }}" class="flex items-center">
        <x-slot name="title">
            {{ __('Información General de la Categoria') }}
        </x-slot>

        <x-slot name="content">
            <div class="overflow-hidden max-h-96 overflow-y-auto">
                <fieldset class="border dark:border-gray-500 p-2 mb-2">
                    <legend class="font-bold">Detalles de la Categoría</legend>
                    <div>
                        <span><strong>Nombre: </strong>{{$this->titulo_categoria}}</span>
                        <span><strong>Productos: </strong>{{$this->productos}}</span>
                    </div>
                    <div class="mt-2 flex flex-wrap gap-3">
                        <span><strong>Estado: </strong>{{$this->status}}</span>
                    </div>
                </fieldset>
                @if ($productos_tabla->isnotEmpty())
                    <div class="border rounded-lg overflow-hidden max-h-[320px] overflow-y-auto">
                        <details>
                            <summary class="bg-gray-100 dark:bg-slate-800 py-2 px-4 cursor-pointer">Click para mostrar/ocultar
                                Productos en esta Categoria</summary>
                            <table class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Nombre</th>
                                        <th class="px-4 py-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($productos_tabla as $producto)
                                        <tr>
                                            <td class="border px-4 py-2">
                                                <span class="text-xs"> {{ $producto->name }}</span>
                                            </td>
                                            <td class="border px-4 py-2">
                                                <span class="text-xs"> @if ($producto->status == 'Activo')
                                                    <i
                                                        class="text-green-500"></i>
                                                    {{ $producto->status }}
                                                @else
                                                    <i
                                                        class="text-red-500"></i>
                                                    {{ $producto->status }}
                                                @endif</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="border px-4 py-2" colspan="3">Sin datos.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </details>
                    </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-secondary-button wire:click="$toggle('ShowgCategoria')" wire:loading.attr="disabled">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
