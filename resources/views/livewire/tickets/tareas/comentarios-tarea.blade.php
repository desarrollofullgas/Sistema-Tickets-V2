<div>
    <div class="flex gap-2 justify-evenly items-center">
        <div>
            <x-label value="{{ __('Estado de la tarea') }}" for="status" />
            <select wire:model="status" name="status" id="status"
                class=" border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                <option hidden value="" selected>Seleccionar estado de la tarea</option>
                <option value="Abierto" @if (Auth::user()->permiso_id != 1 && Auth::user()->permiso_id != 4) hidden @endif>Abierto</option>
                <option value="En Proceso">En Proceso</option>
                <option value="Cerrado" @if (Auth::user()->permiso_id != 1 && Auth::user()->permiso_id != 4 && (Auth::id() != $this->asignado->id )) hidden @endif>Cerrado</option>
            </select>
            <x-input-error for="status"></x-input-error>
        </div>
        <div>
            <x-label value="{{ __('Mensaje') }}" for="mensaje" />
            <textarea wire:model="mensaje"
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 resize-none{{ $errors->has('mensaje') ? 'is-invalid' : '' }}"
                name="mensaje" required>
                    </textarea>
            <x-input-error for="mensaje"></x-input-error>
        </div>
       
                <x-danger-button class="mr-2" wire:click="addCom({{ $tareaID }})" wire:loading.attr="disabled">
                    <div role="status" wire:loading wire:target="addCom">
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
        
    </div>
    {{-- comentarios de la tarea --}}
    @if ($comentarios->count() > 0)
        <ul class="flex flex-col  max-h-[100px] overflow-y-auto">
            <hr>
            <div class="mb-2 float-left">
                <span
                    class="inline-flex items-center p-1 text-sm font-medium text-center text-white bg-gray-400 rounded-lg">
                    Comentarios
                    <span
                        class="inline-flex items-center justify-center w-4 h-4 ml-2 text-xs font-semibold text-black bg-white rounded-full">
                        {{ $comentarios->count() }}
                    </span>
                </span>
            </div>
            @foreach ($comentarios as $comentario)
                <li>
                    <a
                        class="flex  px-3 py-2 text-sm transition duration-150 ease-in-out border-b border-gray-300 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none">
                        @if ($comentario->usuario->profile_photo_path)
                            <div
                                onclick="window.location.href='{{ asset('/storage/' . $comentario->usuario->profile_photo_path) }}'">
                                <img class="h-10 w-10 rounded-full object-cover"
                                    src="/storage/{{ $comentario->usuario->profile_photo_path }}"
                                    alt="{{ $comentario->usuario->name }}" />
                            </div>
                        @else
                            <div onclick="window.location.href='{{ asset($comentario->usuario->profile_photo_url) }}'">
                                <img class="object-cover w-10 h-10 rounded-full"
                                    src="{{ $comentario->usuario->profile_photo_url }}"
                                    alt="{{ $comentario->usuario->name }}" />
                            </div>
                        @endif
                        <div class="w-full pb-2">
                            <div class="flex justify-between">
                                <div class="flex">
                                    <span
                                        class="block ml-2 font-semibold text-gray-600 dark:text-white">{{ $comentario->usuario->name }}</span>
                                    <span
                                        class="block ml-2 bg-gray-400 p-1 rounded-md text-bold text-white text-xs">{{ $comentario->statustarea }}</span>
                                </div>
                                <span
                                    class="block ml-2 text-xs text-gray-600 dark:text-white">{{ $comentario->created_at->format('M d, Y H:i a') }}</span>
                            </div>
                            <span
                                class="block ml-2 text-sm text-gray-600 dark:text-white">{{ $comentario->comentario }}</span>

                        </div>
                        <button wire:click="removeCom({{ $comentario->id }})"
                            class="p-2 text-gray-500 hover:text-red-500 ">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-5 h-5 text-red-500">
                                <path fill-rule="evenodd"
                                    d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <div class="mt-2 p-4 " style="display: flex; justify-content: center;">
            Sin Comentarios.
        </div>
    @endif
</div>
