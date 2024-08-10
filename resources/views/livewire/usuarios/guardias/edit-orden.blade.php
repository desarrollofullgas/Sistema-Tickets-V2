<div x-data="{ edit: false, cancel(){
    $wire.restoreData();
    this.edit = false;
} }" class="w-full">
    <div class="flex justify-between mb-2">
        <div>
            <button type="button" class="flex gap-2 items-center justify-center text-gray-400 hover:text-indigo-500 transition duration-300 " title="Restaurar cambios" wire:click="restoreData()" x-cloack x-show="edit">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.545 8.163a.75.75 0 0 1-.487-1.044l1.66-3.535a.75.75 0 0 1 1.36.002l.732 1.569a.755.755 0 0 1 .08-.027a8.15 8.15 0 1 1-5.8 5.903a.75.75 0 1 1 1.456.364a6.65 6.65 0 1 0 4.907-4.862l.74 1.583a.75.75 0 0 1-.872 1.043l-3.776-.996Z"/>
                </svg>
            </button>
        </div>
        {{-- <button type="button" wire:click="prox()" class="p-2 border">
            change
        </button> --}}
        @if ($valid->pivot->ed == 1)
        <button @click="edit =!edit" wire:loading.attr="disabled" aria-label="editar ticket" title="Editar" x-cloak x-show="edit==false">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-6 h-6 text-gray-400 hover:text-indigo-500 transition duration-300">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
        </button>
        @endif
    </div>
    <div id="alert-border-4" class="flex items-center p-4 mb-4 text-amber-800 border border-l-4 border-amber-300 bg-amber-50 dark:text-amber-300 dark:bg-gray-800 dark:border-amber-800" x-cloack x-show="edit" x-collapse>
        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <div class="ml-3 text-sm font-medium">
          Sólo puede existir un usuario con el STATUS <i>'En esta semana ' y 'Próximo' </i>.
        </div>
    </div>
    <div wire:sortable="updateList" class="flex flex-col gap-2 ">
        {{-- <ul wire:sortable="updateList" class="flex flex-col gap-2">
            @foreach ($guardias as $usuario)
                <li wire:sortable.item="{{ $usuario->user_id }}" wire:key="task-{{ $usuario->id }}" class="border">
                    <h4 wire:sortable.handle>{{ $usuario->usuario->name }}</h4>
                </li>
            @endforeach
        </ul> --}}
        <div class="border font-bold grid grid-cols-3 justify-items-center items-center p-2 gap-2 max-[800px]:hidden rounded-t-md uppercase bg-gray-200 text-gray-600 border-gray-300  dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
            <div>ORDEN</div>
            <div>USUARIO</div>
            <div>ESTADO</div>
        </div>
        @foreach ($guardias as $key=>$usuario)
        <div wire:sortable.item="{{ $usuario->user_id }}" wire:key="task-{{ $usuario->id }}" class="max-[480px]:relative min-h-[60px] flex items-stretch gap-1 w-auto border rounded-md overflow-hidden dark:border-gray-600 " :class="edit && 'shadow-md dark:bg-dark-eval-2 dark:shadow-slate-900/60 '">
            <div wire:sortable.handle class="flex items-center justify-center text-white p-2 bg-gray-300 dark:bg-gray-600 cursor-move" x-show="edit" x-cloak x-transition>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 9H5c-.55 0-1 .45-1 1s.45 1 1 1h14c.55 0 1-.45 1-1s-.45-1-1-1zM5 15h14c.55 0 1-.45 1-1s-.45-1-1-1H5c-.55 0-1 .45-1 1s.45 1 1 1z"/>
                </svg>
            </div>
            <div class="flex-auto p-2 grid justify-items-start min-[800px]:justify-items-center items-center grid-cols-[repeat(auto-fit,minmax(200px,1fr))] gap-2">
                <div class="flex flex-wrap gap-1">
                    <div class="min-[800px]:hidden bg-blue-100 text-blue-800 p-1 text-xs font-bold uppercase dark:bg-blue-700 dark:text-white">
                        ORDEN: 
                    </div>
                    {{$usuario->orden}}
                </div>
                <div class="flex flex-wrap gap-1">
                    <div class="min-[800px]:hidden bg-blue-100 text-blue-800 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white w-fit">
                        USUARIO: 
                    </div>
                    <h4>{{ $usuario->usuario->name }}</h4>
                </div>
                <template x-if="edit==false">
                    <div class="flex flex-wrap gap-1">
                        <div class="min-[800px]:hidden bg-blue-100 text-blue-800 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white w-fit">
                            ESTADO: 
                        </div>
                        <div>{{$usuario->status}}</div>
                    </div>
                </template>
                <div x-show="edit">
                    <select wire:model="arrSave.{{$key}}.status" wire:change="change()" name="status" id="status"
                        class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        <option value="En espera">En espera</option>
                        <option value="Esta semana">Esta semana</option>
                        <option value="Próximo">Próximo</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-center items-center p-2 max-[480px]:absolute max-[480px]:top-0 max-[480px]:right-0" x-cloak x-show="edit">
                <button type="button" wire:click="deleteGuardia({{$usuario->id}})">
                    <svg xmlns="http://www.w3.org/2000/svg"  class="bi bi-trash3-fill w-6 h-6 text-gray-400 hover:text-orange-800 transition duration-300 max-[480px]:hidden"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16z" stroke-width="0" fill="currentColor"></path>
                        <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor"></path>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 min-[481px]:hidden" viewBox="0 0 384 512" fill="currentColor">
                        <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>
                    </svg>
                </button>
            </div>
        </div>
        @endforeach
        <div class="flex justify-end" x-cloack x-show="edit" x-collapse>
            <div class="flex flex-wrap gap-2">
                <x-button wire:click="update()" class="max-[320px]:w-full flex gap-2 items-center justify-center font-semibold text-xs uppercase tracking-widest">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 448 512">
                        <path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V173.3c0-17-6.7-33.3-18.7-45.3L352 50.7C340 38.7 323.7 32 306.7 32H64zm0 96c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V128zM224 288a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/>
                    </svg>
                    Guardar
                </x-button>
                <x-secondary-button  @click="cancel()" wire:loading.attr="disabled" class="max-[320px]:w-full flex justify-center items-center">
                    Cancelar
                </x-secondary-button>
            </div>
        </div>
    </div>
</div>