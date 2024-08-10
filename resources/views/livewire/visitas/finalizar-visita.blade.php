<div>
    <button wire:click="ConfirmVisita({{ $visitaID }})" wire:loading.attr="disabled"
        class="text-gray-400 duration-300 flex items-center gap-2 hover:text-gray-600">
        {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
        </svg> --}}
        <span>Finalizar Visita</span>
    </button>
    <x-dialog-modal wire:model="modal" class="flex items-center">
        <x-slot name="title">
        </x-slot>
        <x-slot name="content" class="relative">
            <div>
                <div class="flex justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-10 h-10 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <p>Estas por finalizar la visita para la estación <i>"{{ $visitaEstacion }}"</i>,
                    <strong>Por favor</strong> comentanos si el motivo de la visita fue debidamente resuelto o ha
                    quedado
                    algún detalle por resolver.
                </p>
                <div>
                    <x-label value="{{ __('Observación') }}" />
                    <textarea wire:model="observacion"
                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700 {{ $errors->has('observacion') ? 'is-invalid' : '' }}"
                        name="observacion" required autofocus></textarea>
                    <x-input-error for="observacion"></x-input-error>
                </div>
                <div class="mb-3 col-12 w-full" x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">

                    <x-label value="{{ __('Evidencias') }}" class="border-b border-gray-400 w-full text-left mb-2" />
                    <input type="file" wire:model="evidencias"
                        class="flex flex-wrap file:text-sm file:font-semibold file:bg-blue-300 file:text-blue-700 hover:file:bg-blue-100 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0"
                        multiple name="evidencias" required autocomplete="evidencias"
                        accept="image/*, .pdf, .doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                    <x-input-error for="evidencias"></x-input-error>

                    <!-- Progress Bar -->
                    <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-2.5 mb-2 dark:bg-gray-700">
                        <div class="bg-red-600 h-2.5 rounded-full dark:bg-red-500 transition-[width] duration-500"
                            x-bind:style="`width:${progress}%`"></div>
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="w-full flex justify-center gap-3">
                <x-danger-button class="mr-2" wire:click="FinalVisita({{ $visitaID }})"
                    wire:loading.attr="disabled">
                    Aceptar
                </x-danger-button>
                <x-secondary-button wire:click="$set('modal',false)" wire:loading.attr="disabled">
                    Cancelar
                </x-secondary-button>
            </div>

        </x-slot>
    </x-dialog-modal>
</div>
