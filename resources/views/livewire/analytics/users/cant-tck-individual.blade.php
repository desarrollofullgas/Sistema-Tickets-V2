<div  class="py-2 px-3 border rounded-md bg-white dark:bg-dark-eval-1 dark:border-0 shadow-sm" >
    <div class="flex max-sm:flex-wrap gap-2 mb-4">
        <div class="w-full">
            <x-label value="{{__('Usuario')}}" for="user"/>
             <select wire:model="user" class="w-full border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700"
                name="user" id="user">
                <option value="{{Auth::user()->id}}">Yo</option>
                @foreach ($userList as $user)
                    <option value="{{$user['id']}}">{{$user['name']}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <x-label value="{{__('Seleccionar mes')}}"/>
            <x-input type="month" wire:model='mes'/>
        </div>
    </div>
    <div class="mb-3">
        <h2 class="pb-1 mb-3 font-bold text-xl border-b">CANTIDADES DE TICKETS</h2>
        <table class="w-full">
            <thead>
                <tr>
                    <th class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                        BAJOS
                    </th>
                    <th class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                        MEDIOS
                    </th>
                    <th class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                        ALTOS
                    </th>
                    <th class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                        CRÍTICOS
                    </th>
                    <th class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                        ALTOS CRÍTICOS
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-5 lg:mb-0 dark:bg-slate-800 dark:lg:hover:bg-slate-600"">
                    @foreach ($list as $prioridades)
                        @foreach ($prioridades as $key=>$pr)
                            <th class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class=" flex justify-center gap-2 text-xs font-bold uppercase ">
                                    <span  class="lg:hidden">
                                        @switch($key)
                                            @case('bajo')
                                                {{__('Bajos:')}}
                                                @break
                                            @case('medio')
                                                {{__('Medios:')}}
                                                @break
                                            @case('alto')
                                                {{__('Altos:')}}
                                                @break
                                            @case('critico')
                                                {{__('Críticos:')}}
                                                @break
                                            @case('altCr')
                                                {{__('Altos críticos:')}}
                                                @break
                                            @default
                                                
                                        @endswitch
                                    </span>
                                    <p>{{count($pr)}}</p>
                                </div>
                            </th>
                        @endforeach
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
    <div class="flex flex-col gap-2">
        @foreach ($list as $prioridades)
            @foreach ($prioridades as $key => $pr)
                @if (count($pr)>0)    
                    <div x-data="{toggle:false}" class=" border-2 rounded-md max-h-80 overflow-y-auto"
                        @switch($key)
                            @case('bajo')
                                :class="'border-green-500 dark:border-green-700'"
                                @break
                            @case('medio')
                                :class="'border-blue-700'"
                                @break
                            @case('alto')
                                :class="'border-amber-600'"
                                @break
                            @case('critico')
                                :class="'border-purple-700'"
                                @break
                            @case('altCr')
                                :class="'border-red-700'"
                                @break
                            @default
                                
                        @endswitch>
                        
                        <h2 class=" flex gap-2 items-center px-2 py-1 font-bold text-lg text-white cursor-pointer" @click="toggle=!toggle"
                            @switch($key)
                                @case('bajo')
                                    :class="'bg-green-500'"
                                    @break
                                @case('medio')
                                    :class="'bg-blue-700'"
                                    @break
                                @case('alto')
                                    :class="'bg-amber-600'"
                                    @break
                                @case('critico')
                                    :class="'bg-purple-700'"
                                    @break
                                @case('altCr')
                                    :class="'bg-red-700'"
                                    @break
                                @default
                                    
                            @endswitch>
                            <div class="px-2 transform transition duration-300 ease-in-out rotate-90 text-white" :class="{'rotate-90': toggle}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 512 512">
                                    <path d="M0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM241 377c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l87-87-87-87c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0L345 239c9.4 9.4 9.4 24.6 0 33.9L241 377z"></path>
                                </svg>        
                            </div>
                            @switch($key)
                                @case('bajo')
                                    {{__('Bajos')}}
                                    @break
                                @case('medio')
                                    {{__('Medios')}}
                                    @break
                                @case('alto')
                                    {{__('Altos')}}
                                    @break
                                @case('critico')
                                    {{__('Críticos')}}
                                    @break
                                @case('altCr')
                                    {{__('Altos críticos')}}
                                    @break
                                @default
                                    
                            @endswitch
                        </h2>
                        <div class="px-2 flex flex-col gap-2 justify-evenly" x-cloak x-show="toggle" x-collapse>
                            @foreach ($pr as $id=> $tck)
                                <div class="flex flex-col gap-2 md:grid md:grid-cols-5 border-b pb-2 pt-1 justify-center md:place-items-center">
                                    <div>#{{$tck->id}}</div>
                                    <div class="text-center"
                                        @if ($tck->status=="Abierto")
                                            :class="'bg-green-500 text-white p-1 dark:bg-green-700'"
                                        @endif
                                        @if ($tck->status=="En proceso")
                                            :class="'bg-amber-600 text-white p-1'"
                                        @endif
                                        @if ($tck->status=="Cerrado" || $tck->status=="Por abrir" || $tck->status=="Vencido")
                                            :class="'bg-gray-400 text-white p-1'"
                                        @endif 
                                        >
                                        {{$tck->status}}
                                    </div>
                                    <div class=" text-center font-bold text-xl">
                                        <h2>{{$tck->falla->name}}</h2>
                                    </div>
                                    <div class="text-center">
                                        <p>Cliente:</p>
                                        {{$tck->cliente->name}}
                                    </div>
                                    <div class="text-center">
                                        <p>Vencimiento:</p>
                                        {{$tck->fecha_cierre}}
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                    </div>
                @endif
            @endforeach
        @endforeach
    </div>
</div>