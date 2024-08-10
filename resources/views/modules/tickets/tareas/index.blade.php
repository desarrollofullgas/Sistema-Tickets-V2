<x-app-layout>
    @section('title', 'Tarea')
    <div class="flex flex-col sm:flex-row gap-2">
        <div class="bg-white dark:bg-dark-eval-3 text-gray-800 p-4 rounded-md shadow-lg mb-4 sm:mb-0">
            <ul class="list-style:none">
                <li class="mb-2"><strong class="dark:text-white">Ticket: </strong>
                    <span class="dark:text-white">#{{ $ticketID }}</span>
                </li>
                <li class="mb-2"><strong class="dark:text-white">Estado:</strong>
                     @if ($tck->status == 'Abierto' && $tck->vencido == 0)
                        <span class="bg-green-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @elseif ($tck->status == 'En proceso' && $tck->vencido == 0)
                        <span class="bg-orange-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @elseif ($tck->vencido == 1)
                        <span class="bg-red-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @elseif ($tck->status == 'Cerrado')
                        <span class="bg-gray-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @endif
                </li>
                <li class="mb-2"><strong class="dark:text-white">Cliente:</strong>
                    <div class="dark:text-white">
                        {{ $tck->cliente->name }}</div>
                </li>
                <li class="mb-2"><strong class="dark:text-white">Creado:</strong>
                    <div class="dark:text-white">
                        {{ $tck->created_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}</div>
                </li>
                <li class="mb-2"><strong class="dark:text-white">Vencimiento:</strong>
                    <div class="bg-gray-400 p-1 rounded-md text-white">
                        {{ \Carbon\Carbon::parse($tck->fecha_cierre)->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}
                    </div>
                </li>
                @if ($tck->status == 'Cerrado' && $tck->cerrado != null)
                    <li class="mb-2"><strong class="dark:text-white">Cerrado:</strong>
                        <div class="bg-gray-400 p-1 rounded-md text-white">
                            {{ \Carbon\Carbon::parse($tck->cerrado)->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}
                        </div>
                    </li>
                @endif
            </ul>
            {{-- Botones acción --}}
            @if (Auth::user()->permiso_id == 1 ||
                    Auth::user()->permiso_id == 7 ||
                    Auth::user()->permiso_id == 4 ||
                    Auth::user()->permiso_id == 5)
                <div class="bg-dark-eval-1 dark:bg-dark-eval-2 p-2 rounded-md text-white text-center">
                    {{ __('Ir a:') }}
                </div>
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-center mt-5">
                    <div class="flex justify-center rounded-lg space-x-2" role="group">
                        
                            <a class="px-2 py-1 text-xs font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800" href="{{ route('tck.ver', $tck->id) }}">
                            Ver Ticket
                        </a>
						@if ($valid->pivot->ed == 1)
                            @livewire('tickets.reasignar', ['ticketID' => $tck->id])
                        @endif
                        
                        @livewire('tickets.compras.show-compras', ['ticketID' => $tck->id])

                        @if ($valid->pivot->vermas == 1 && $tck->status == 'Cerrado')
                            @livewire('tickets.unlock-ticket', ['ticketID' => $tck->id])
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="ml-0 sm:ml-16">
            @livewire('tickets.tareas.new-tarea', ['ticketID' => $ticketID], key('new' . $tarea->id))
        </div>
    </div>

    <div class="mt-4 bg-white dark:bg-dark-eval-1 text-gray-800 p-4 rounded-md shadow-lg">
        <div class="bg-dark-eval-1 p-1 rounded-md text-white text-center mb-2">
            {{ __('Tareas del ticket:') }}
        </div>
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-3">
            <span
                class="inline-flex items-center p-1 text-sm font-medium text-center text-white bg-gray-400 rounded-lg">
                Tareas
                <span
                    class="inline-flex items-center justify-center w-4 h-4 ml-2 text-xs font-semibold text-black bg-white rounded-full">
                    {{ $tareas->count() }}
                </span>
            </span>
        </div>
        @forelse ($tareas as $tarea)
            <div @if ($tarea->status == 'Abierto') class="mb-2 bg-teal-100 border-t-4 border-teal-500 rounded-md text-teal-900 px-4 py-3 shadow-md" @endif
                @if ($tarea->status == 'En Proceso') class="mb-2 bg-orange-100 border-t-4 border-orange-500 rounded-md text-orange-900 px-4 py-3 shadow-md" @endif
                @if ($tarea->status == 'Cerrado') class="mb-2 bg-gray-100 border-t-4 border-gray-500 rounded-md text-gray-900 px-4 py-3 shadow-md" @endif
                role="alert">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex">
                        <div class="py-1 flex items-center"> <span
                                @if ($tarea->status == 'Abierto') class="mr-4 bg-teal-500 p-1 rounded-full text-white" @endif
                                @if ($tarea->status == 'En Proceso') class="mr-4 bg-orange-500 p-1 rounded-full text-white" @endif
                                @if ($tarea->status == 'Cerrado') class="mr-4 bg-gray-500 p-1 rounded-full text-white" @endif>#{{ $tarea->id }}</span>
                        </div>
                        <div>
                            <p class="font-bold">{{ $tarea->user->name }}</p>
                            <p class="text-sm"> {{ $tarea->mensaje }}</p>
                        </div>
                    </div>
                    <div class="flex w-full h-4 bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700">
                        @if ($tarea->status == 'Abierto')
                            <div class="flex flex-col justify-center overflow-hidden bg-green-500 text-xs text-white text-center"
                                role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                aria-valuemax="100">25%</div>
                        @endif
                        @if ($tarea->status == 'En Proceso')
                            <div class="flex flex-col justify-center overflow-hidden bg-green-500 text-xs text-white text-center"
                                role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                aria-valuemax="100">50%</div>
                        @endif
                        @if ($tarea->status == 'Cerrado')
                            <div class="flex flex-col justify-center overflow-hidden bg-green-500 text-xs text-white text-center"
                                role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                                aria-valuemax="100">100%</div>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        {{-- @if (!(Auth::id() == $solicitaTarea )) --}}
                            @livewire('tickets.tareas.show-tarea', ['tareaID' => $tarea->id], key('show' . $tarea->id))
                        {{-- @endif --}}

                        @if ($tarea->status != 'Cerrado' || Auth::user()->permiso_id == 1)
                            @if ($valid->pivot->ed == 1)
                                @livewire('tickets.tareas.edit-tarea', ['tareaID' => $tarea->id], key('edit' . $tarea->id))
						@endif
						@if ($valid->pivot->de == 1)
                                @livewire('tickets.tareas.delete-tarea', ['tareaID' => $tarea->id], key('delete' . $tarea->id))
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <span class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
                Sin tareas actualmente.
            </span>
        @endforelse
    </div>
</x-app-layout>
