<div>
    <button wire:click="confirmPermisoAsig({{ $permiso_asig_id }})" wire:loading.attr="disabled"
        class="bg-green-100  text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300"
        data-target="AsigPermiso{{ $permiso_asig_id }}">
        Asignar
    </button>

    <x-dialog-modal wire:model="AsigPermiso" id="AsigPermiso{{ $permiso_asig_id }}" class="flex items-center">
        <x-slot name="title">
            <div class="bg-dark-eval-1 dark:bg-gray-600 p-4 rounded-md text-white text-center">
                {{ __('Asignar Permisos a:') . ' ' . $permiso_asig_name }}
            </div>
        </x-slot>

        <x-slot name="content">

            <div class="flex flex-wrap">
                <form action="{{ route('asignacionpermiso.asignar', $permiso_asig_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-wrap">
                        <div class="mb-3 mr-2">
                            <x-label value="{{ __('Nombre del Rol') }}" />
                            <x-input wire:model="titulo_permiso"
                                class="{{ $errors->has('titulo_permiso') ? 'is-invalid' : '' }}" type="text"
                                name="titulo_permiso" :value="old('titulo_permiso')" required autofocus
                                autocomplete="titulo_permiso" />
                            <x-input-error for="titulo_permiso"></x-input-error>
                            @if ($errors->has('titulo_permiso'))
                                <span class="text-red-500">{{ $errors->first('titulo_permiso') }}</span>
                            @endif
                        </div>

                        <div class="mb-3 ml-2">
                            <x-label value="{{ __('Descripción') }}" />
                            <x-input wire:model="descripcion"
                                class="{{ $errors->has('descripcion') ? 'is-invalid' : '' }}" type="text"
                                name="descripcion" :value="old('descripcion')" required autofocus
                                autocomplete="descripcion" />
                            <x-input-error for="descripcion"></x-input-error>
                            @if ($errors->has('descripcion'))
                                <span class="text-red-500">{{ $errors->first('descripcion') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="border rounded-lg  max-h-[320px] overflow-auto dark:border-gray-700">
                        <details>
                            <summary
                                class="bg-gray-100 py-2 px-4 cursor-pointer dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                Click para mostrar/ocultar Permisos</summary>
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                            Panel</th>
                                        <th
                                            class="font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                            Leer</th>
                                        <th
                                            class="font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                            Escribir</th>
                                        <th
                                            class="font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                            Editar</th>
                                        <th
                                            class="font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                            Eliminar</th>
                                        <th
                                            class="font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                            Ver Más </th>
                                        <th
                                            class="font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                            Ver Papelera</th>
                                        <th
                                            class="font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                            Restaurar Papelera</th>
                                        <th
                                            class="font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                            Ver Más Papelera
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="table-light">
                                    @foreach ($permission as $permissio)
                                        <tr>
                                            <td>
                                                {{ $permissio->titulo_panel }}
                                            </td>
                                            <td class="align-middle">
                                                <div class="">
                                                    <input name="leer[{{ $permissio->id }}]" value="1"
                                                        id="leer.{{ $permissio->id }}" type="checkbox"
                                                        class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                        @foreach ($perm as $item)
                                                @if ($item->panel_id == $permissio->id)
                                                    @if ($item->re == 1)
                                                        {{ 'checked' }}
                                                    @endif    
                                                @endif @endforeach>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="">
                                                    <input name="crear[{{ $permissio->id }}]" value="1"
                                                        id="crear.{{ $permissio->id }}" type="checkbox"
                                                        class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                       
                                                        @foreach ($perm as $item)
                                                @if ($item->panel_id == $permissio->id)
                                                    @if ($item->wr == 1)
                                                        {{ 'checked' }}
                                                    @endif    
                                                @endif @endforeach>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="">
                                                    <input name="editar[{{ $permissio->id }}]" value="1"
                                                        id="editar.{{ $permissio->id }}" type="checkbox"
                                                        class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                       
                                                        @foreach ($perm as $item)
                                                @if ($item->panel_id == $permissio->id)
                                                    @if ($item->ed == 1)
                                                        {{ 'checked' }}
                                                    @endif    
                                                @endif @endforeach>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="">
                                                    <input name="eliminar[{{ $permissio->id }}]" type="checkbox"
                                                    class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                        value="1" id="eliminar.{{ $permissio->id }}"
                                                       
                                                        @foreach ($perm as $item)
                                                @if ($item->panel_id == $permissio->id)
                                                    @if ($item->de == 1)
                                                        {{ 'checked' }}
                                                    @endif    
                                                @endif @endforeach>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="">
                                                    <input name="vermas[{{ $permissio->id }}]" type="checkbox"
                                                    class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                        value="1" id="vermas.{{ $permissio->id }}"
                                                       
                                                        @foreach ($perm as $item)
                                                @if ($item->panel_id == $permissio->id)
                                                    @if ($item->vermas == 1)
                                                        {{ 'checked' }}
                                                    @endif    
                                                @endif @endforeach>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="">
                                                    <input name="verpap[{{ $permissio->id }}]" type="checkbox"
                                                    class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                        value="1" id="verpap.{{ $permissio->id }}"
                                                       
                                                        @foreach ($perm as $item)
                                                @if ($item->panel_id == $permissio->id)
                                                    @if ($item->verpap == 1 && $item->panel_id != 4)
                                                        {{ 'checked' }}
                                                    @elseif ($item->verpap == 1 || $item->panel_id == 4)
                                                        {{ 'disabled' }}
                                                    @endif    
                                                @endif @endforeach>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="">
                                                    <input name="restpap[{{ $permissio->id }}]" type="checkbox"
                                                    class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                        value="1" id="restpap.{{ $permissio->id }}"
                                                       
                                                        @foreach ($perm as $item)
                                                @if ($item->panel_id == $permissio->id)
                                                    @if ($item->restpap == 1 && $item->panel_id != 4)
                                                        {{ 'checked' }}
                                                    @elseif ($item->restpap == 1 || $item->panel_id == 4)
                                                        {{ 'disabled' }}
                                                    @endif
                                                @endif @endforeach>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="">
                                                    <input name="vermaspap[{{ $permissio->id }}]" type="checkbox"
                                                    class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                        value="1" id="vermaspap.{{ $permissio->id }}"
                                                       
                                                        @foreach ($perm as $item)
                                                @if ($item->panel_id == $permissio->id)
                                                    @if ($item->vermaspap == 1 && $item->panel_id != 4)
                                                        {{ 'checked' }}
                                                    @elseif ($item->vermaspap == 1 || $item->panel_id == 4)
                                                        {{ 'disabled' }}
                                                    @endif    
                                                @endif @endforeach>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </details>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="mr-2 bg-green-500 p-2 text-white font-bold  rounded-md"
                            wire:click="AsignarPermiso({{ $permiso_asig_id }})">
                            Aceptar
                        </button>
                    </div>
                </form>
            </div>
        </x-slot>

        <x-slot name="footer" class="hidden">
            <x-secondary-button wire:click="$toggle('AsigPermiso')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button> 
        </x-slot>
    </x-dialog-modal>
</div>
