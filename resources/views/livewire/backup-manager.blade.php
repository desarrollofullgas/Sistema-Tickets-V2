<div>
    <x-button wire:click="createBackup" class="mb-4">
        Iniciar Respaldo
        <div role="status" wire:loading wire:target="createBackup" wire:loading.attr="disabled">
            <x-icons.spin class="inline w-4 h-4 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-white"/>
            <span class="sr-only">Loading...</span>
        </div>
    </x-button>
    
    {{-- <ul>
        @foreach ($backups as $backup)
            <li>
                {{ $backup }}
                <button wire:click="downloadBackup('{{ $backup }}')">Download</button>
                <button wire:click="deleteBackup('{{ $backup }}')">Delete</button>
            </li>
        @endforeach
    </ul> --}}

    <div class="overflow-auto rounded-lg shadow hidden md:block">
        {{-- Componente tabla --}}
        <x-table>
            <x-slot name="head">
                {{-- Componente Heading  --}}
                <x-heading sortable></x-heading>
                <x-heading></x-heading>
            </x-slot>
            <x-slot name="body">
                @forelse($backups as $backup)
                    {{-- Componente Row --}}
                    <x-row wire:loading.class.delay="opacity-75">
                        {{-- Componente Column --}}
                        <x-cell class="font-bold text-center">{{ $backup }}</x-cell>
                        <x-cell>
                            <div class="flex gap-2 justify-center items-center">
                                
                                <button wire:click="downloadBackup('{{ $backup }}')"><x-icons.download class="w-6 h-6 hover:text-purple-500"/></button>
                                
                                <button wire:click="deleteBackup('{{ $backup }}')"><x-icons.delete class="w-6 h-6 hover:text-red-500"/></button>
                                
                            </div>
                        </x-cell>
                    </x-row>
                @empty
                    <x-row>
                        <x-cell colspan="3">
                            <div class="flex justify-center items-center space-x-2">
                                <x-icons.inbox class="w-8 h-8 text-gray-300" />
                                <span class="py-8 font-medium text-gray-400 text-xl">No se encontraron
                                    resultados...</span>
                            </div>
                        </x-cell>
                    </x-row>
                @endforelse
            </x-slot>
        </x-table>
    </div>
</div>