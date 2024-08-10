<div>
    <div class="border border-yellow-500 rounded-2xl p-4 bg-white dark:bg-slate-800 shadow-xl">
        <div class="flex flex-col justify-center items-center" id="headerContent">
            <p class="font-bold text-2xl text-gray-700 dark:text-gray-400">{{ __('EN PROCESO') }}</p>
            {{-- <x-icons.ticket class="w-32 h-32 lg:w-48 lg:h-48 text-green-700 " id="icon" /> --}}
        </div>

        <div class="text-sm">
            <details id="ticketDetailsP">
                <summary class="py-2 px-4 cursor-pointer flex items-center justify-center text-center"
                    onclick="toggleDetailsP()">
                    <span class="font-bold text-gray-700 dark:text-gray-400" id="toggleTextP">{{ __('MOSTRAR') }}</span>
                    <span
                        class="inline-flex items-center justify-center ml-2 w-4 h-4 text-xs font-semibold text-yellow-500 bg-yellow-200 rounded-full">
                        {{ $ultimosEnProceso->count() }}
                    </span>
                </summary>

                <table class="w-full text-center text-sm" id="ticketTableP">
                    <thead>
                        <tr>
                            <th class="bg-gray-300 dark:bg-dark-eval-1 p-3 font-bold uppercase hidden lg:table-cell ">
                                Ticket
                            </th>
                            <th class="bg-gray-300 dark:bg-dark-eval-1 p-3 font-bold uppercase hidden lg:table-cell ">
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                        @forelse($ultimosEnProceso as $process)
                            <tr>
                                <td class="w-full lg:w-auto p-3  text-center  block lg:table-cell relative lg:static">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 px-1 py-1 text-xs font-bold uppercase">Falla</span>
                                    {{ $process->nombre_falla }}
                                    <br />
                                    <div class="flex gap-2 ">
                                        <p class="text-xs">#{{ $process->tck }}</p>
                                        <p class="text-xs">{{ $process->solicitante_name }}</p>
                                    </div>
                                </td>
                                <td class="w-full lg:w-auto p-3 block lg:table-cell relative lg:static">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 px-1 py-1 text-xs font-bold uppercase">Opciones</span>
                                    <a class="px-2 py-1 text-xs font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800"
                                        href="{{ route('tck.ver', $process->id) }}">
                                        {{ __('Ver Ticket') }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="w-full lg:w-auto p-3 text-center border border-b block lg:table-cell relative lg:static"
                                    colspan="2">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Sin
                                        registros</span>
                                    {{ __('No hay tickets Abiertos') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </details>
        </div>
    </div>

    <script>
        function toggleDetailsP() {
            var details = document.getElementById('ticketDetailsP');
            var toggleText = document.getElementById('toggleTextP');
            var icon = document.getElementById('icon');
            var headerContent = document.getElementById('headerContent');
            var ticketTable = document.getElementById('ticketTableP');

            if (details.open) {
                toggleText.innerText = 'MOSTRAR';
                icon.style.display = 'block';
                ticketTable.style.width = '100%';
                headerContent.style.justifyContent = 'center';
            } else {
                toggleText.innerText = 'OCULTAR';
                icon.style.display = 'none';
                headerContent.style.justifyContent = 'flex-start';
            }
        }
    </script>
</div>