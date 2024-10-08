<div class="w-full">
    <h2 class="mb-2">
        {{-- {{ __('Asignar Horario') }} --}}
    </h2>
    <div class="w-full">
        <div class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('Horarios de comida asignados por usuario') }}
            <table class="border-collapse w-full  text-center text-sm text-gray-500 dark:text-white ">
                <thead class="bg-gray-50 dark:bg-dark-eval-2">
                    <tr>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Usuario</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Horario</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Opciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                    @forelse ($horarios as $horario)
                        <tr>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800  dark:text-white text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-700">
                                <span
                                    class="lg:hidden top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase dark:text-black">Usuario</span>
                                {{ $horario->user->name }}
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800  dark:text-white text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-700">
                                <span
                                    class="lg:hidden top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase dark:text-black">Horario</span>
                                {{ \Carbon\Carbon::parse($horario->meal->start_time)->format('g:i A') }} -
                                {{ \Carbon\Carbon::parse($horario->meal->end_time)->format('g:i A') }}
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800  dark:text-white border border-b block lg:table-cell relative lg:static dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase dark:text-black">opciones</span>
                                @if ($valid->pivot->de == 1)
                                    <button wire:click="deleteMealAssignment({{ $horario->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6 text-gray-400 hover:text-red-500">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:text-gray-300 dark:border-gray-700"
                                colspan="6">
                                {{ __('No hay horarios asignados') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-5">
            @if ($valid->pivot->wr == 1)
                <x-button wire:click="openModalA" wire:loading.attr="disabled">
                    {{ __('Asignar Horario') }}
                </x-button>
            @endif
        </div>

        <x-dialog-modal wire:model="AsignacionHorario" class="flex items-center">
            <x-slot name="title">
                <div class="bg-dark-eval-1 p-4 rounded-md text-white text-center">
                    {{ __('Horario de comida por usuario') }}
                </div>
            </x-slot>

            <x-slot name="content">
                {{ __('Antes de proceder con la asignación del horario, favor de validar si este ya se encuentra registrado,
                                                                de lo contrario puede proceder con la asignación del horario.') }}

                <div class="flex flex-col md:flex-row gap-2 mt-4">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-2">
                        <x-label for="selectedMealSchedule" value="{{ __('Seleccionar Horario') }}" />
                        <select id="selectedMealSchedule"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                    dark:text-gray-300 dark:focus:ring-offset-dark-eval-1"
                            wire:model="selectedMealSchedule">
                            <option value="">Selecionar Horario</option>
                            @foreach ($mealSchedules as $schedule)
                                <option value="{{ $schedule->id }}">{{ $schedule->start_time }} -
                                    {{ $schedule->end_time }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="selectedMealSchedule"></x-input-error>
                    </div>

                    <div class="md:w-1/2 px-3 mb-6 md:mb-2">
                        <x-label for="selectedUser" value="{{ __('Seleccionar Usuario') }}" />
                        <select id="selectedUser"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                    dark:text-gray-300 dark:focus:ring-offset-dark-eval-1"
                            wire:model="selectedUser">
                            <option value="">Seleccionar Usuario</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="selectedUser"></x-input-error>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-button v wire:click="$toggle('AsignacionHorario')" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-button>

                @if ($valid->pivot->wr == 1)
                    <x-button variant="danger" class="ml-2" wire:click="assignMealSchedule"
                        wire:loading.attr="disabled">
                        <div role="status" wire:loading wire:target="assignMealSchedule">
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
                        {{ __('Asignar') }}
                    </x-button>
                @endif
            </x-slot>
        </x-dialog-modal>
    </div>
</div>
