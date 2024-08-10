<div class="my-3">
    <div class="p-6 bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <h2 class="text-center font-bold text-xl border-b mb-4 pb-1">INFORMACIÓN ACTUAL</h2>
        <div class="flex flex-col gap-2">
            <div>
                <x-label value="{{__('Motivo')}}" for="motivo"/>
                <x-input wire:model.defer="motivo" class="w-full"
                type="text" name="motivo" id="motivo" required autofocus/>
            </div>
            <div>
                <div class="hidden lg:grid lg:grid-cols-6 items-center text-center py-2 px-3 text-white font-bold bg-gray-400 dark:bg-slate-600">
                    <span>#Ticket</span>
                    {{-- <span>Estación</span> --}}
                    <span>Equipo/material</span>
                    <span>Cantidad</span>
                    <span>Observación</span>
                    <span>Serie</span>
                </div>
                <div class="max-h-96 overflow-auto">
                    @foreach ($entrada->productos as $key => $pr)
                    <div class="max-lg:flex-wrap flex gap-2 p-2 border-2 rounded-md mt-1 dark:border-slate-600 lg:items-center">
                        @if ($key>0)    
                            <button type="button" class=" max-lg:mb-2 h-fit w-fit" wire:click="deleteCarrito({{$pr->id}})" data-bs-toggle="tooltip" data-bs-placement="top" title="Doble click para Eliminar">
                                <svg xmlns="http://www.w3.org/2000/svg"  class="bi bi-trash3-fill w-6 h-6 text-gray-400 hover:text-orange-800 transition duration-300"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16z" stroke-width="0" fill="currentColor"></path>
                                    <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor"></path>
                                </svg>
                            </button>
                        @else
                            <div class="w-6 h-6">

                            </div>
                        @endif
                        
                        <div class="flex flex-wrap gap-2 lg:grid lg:grid-cols-6 justify-items-center items-center">
                            <div class="w-full">
                                <x-label value="{{__('Ticket')}}" for="ticket{{$productos[$key]['id']}}" class="block lg:hidden"/>
                                <select id="ticket{{$productos[$key]['id']}}" wire:model.defer="productos.{{$key}}.tck"
                                        class="w-full border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700  {{ $errors->has('clase') ? 'is-invalid' : '' }}" 
                                        name="clase" required aria-required="true"{{--  @change="filter(event)" --}}>
                                        <option value="NULL" >Sin ticket</option>
                                    @foreach ($tickets as $ticket)
                                        <option value="{{$ticket->id}}">#{{$ticket->id}}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="clase"></x-input-error>
                            </div>
                            {{-- <div class="w-full">
                                <x-label value="{{__('Estación')}}" for="estacion{{$productos[$key]['id']}}" class="block lg:hidden"/>
                                <select id="estacion{{$productos[$key]['id']}}" wire:model.defer="productos.{{$key}}.est"
                                        class="w-full border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700  {{ $errors->has('clase') ? 'is-invalid' : '' }}" 
                                        name="clase" required aria-required="true">
                                    <option value="" hidden selected>Seleccione estación</option>
                                    
                                    @foreach ($estaciones as $est)
                                        <option value="{{$est->id}}">{{$est->name}}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="clase"></x-input-error>
                            </div> --}}
                            <div class="w-full text-center">
                                <x-label value="{{__('Equipo/material:')}}" class="block lg:hidden"/>
                                <span>{{$pr->producto->name}}</span>
                            </div>
                            <div class="w-full">
                                <x-label value="{{__('Cantidad')}}" for="cant{{$productos[$key]['id']}}" class="block lg:hidden"/>
                                <x-input wire:model.defer="productos.{{$key}}.cant" class="w-full text-center" type="number" name="cant" id="cant{{$productos[$key]['id']}}" required/>
                            </div>
                            <div class="w-full">
                                <x-label value="{{__('Observación')}}" for="obs{{$productos[$key]['id']}}" class="block lg:hidden"/>
                                <select wire:model.defer="productos.{{$key}}.obs"
                                class="w-full border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700"
                                name="observacion" id="obs{{$productos[$key]['id']}}">
                                    <option value="" hidden>Seleccione una opción</option>
                                    <option value="Nuevo">Nuevo</option>
                                    <option value="Usado">Usado</option>
                                    <option value="Reparado">Reparado</option>
                                    <option value="Dañado">Dañado</option>
                                    <option value="Retorno">Retorno</option>
                                </select>
                            </div>
                            <div class="w-full">
                                <x-label value="{{__('Serie')}}" for="serie{{$productos[$key]['id']}}" class="block lg:hidden"/>
                                <x-input wire:model.defer="productos.{{$key}}.serie"
                                 class="w-full" type="text" name="serie" id="serie{{$productos[$key]['id']}}"/>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore 
        x-data="{productos:prod,tickets:tck,contador:1,
            carrito:[{id:1,tck:'',prod:'',observacion:'',cantsol:'',serie:''}],
            addChild(){
                this.contador++;
                this.carrito.push({id:this.contador,tck:'',prod:'',observacion:'',cantsol:'',serie:''});
                //console.log(this.carrito);
            },
            remove(id){
                this.carrito=this.carrito.filter((item)=>item.id!==id);
            },
            send(){
                //console.log(this.carrito);
                this.carrito=this.carrito.filter((item)=>(item.tck!=''&& item.estacion!='' && item.prod!='' && item.observacion!='' && item.cantsol!=''));
                $wire.set('carrito',this.carrito);
                $wire.updateEntrada();
                setTimeout(()=>$wire.refresh(),50);
            },
            selectConfigs() {
                return {
                    filter: '',
                    show: false,
                    selected: null,
                    focusedOptionIndex: null,
                    options: prod,
                    close() { 
                    this.show = false;
                    this.filter = this.selectedName();
                    this.focusedOptionIndex = this.selected ? this.focusedOptionIndex : null;
                    },
                    open() { 
                    this.show = true; 
                    this.filter = '';
                    },
                    toggle() { 
                        this.show?this.close() : this.open();
                    },
                    isOpen() { return this.show === true },
                    selectedName() { return this.selected ? this.selected.name : this.filter; },
                    classOption(id, index) {
                    const isSelected = this.selected ? (id == this.selected.id) : false;
                    const isFocused = (index == this.focusedOptionIndex);
                    return {
                        'cursor-pointer w-full  hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600': true,
                        'bg-blue-600 text-white dark:bg-dark-eval-0': isSelected,
                        'bg-blue-50': isFocused
                    };
                    },
                    filteredOptions() {
                    return this.options
                        ? this.options.filter(option => {
                            return (option.name.toLowerCase().indexOf(this.filter) > -1) 
                        })
                    : {}
                    },
                    onOptionClick(index,car) {
                    this.focusedOptionIndex = index;
                    this.selectOption(car);//el id es para editar el carrito
                    },
                    selectOption(id) {
                    if (!this.isOpen()) {
                        return;
                    }
                    this.focusedOptionIndex = this.focusedOptionIndex ?? 0;
                    const selected = this.filteredOptions()[this.focusedOptionIndex]
                    if (this.selected && this.selected.id == selected.id) {
                        this.filter = '';
                        this.selected = null;
                    }
                    else {
                        this.selected = selected;
                        this.filter = this.selectedName();
                        this.carrito=this.carrito.map((item)=>{
                            if(item.id==id){
                                item.prod=this.selected.id
                            }
                            return item;
                        });
                    }
                    this.close();
                    }
                }
            }
            }">
        <div class="p-6 bg-white rounded-md shadow-md dark:bg-dark-eval-1 mt-4">
            <h2 class="text-center font-bold text-xl border-b mb-4 pb-1">REGISTRAR NUEVO MATERIAL / EQUIPO</h2>
            <div>
                <div class="h-[25rem] w-full overflow-auto">
                    <template x-for="prod in carrito" :key="prod.id">
                        <div class="w-full h-fit flex max-lg:flex-wrap gap-1 items-start py-3  border-b border-gray-400 ">
                            <div class="flex flex-wrap gap-2 lg:grid lg:grid-cols-6 justify-items-center items-center">
                                {{-- <div class="flex flex-col">
                                    <label :for="`s${prod.id}`" class="font-medium text-sm text-gray-700 dark:text-gray-300">{{__('Estación')}}</label>
                                    <select :name="`s${prod.id}`" :id="`s${prod.id}`" x-model="prod.estacion"
                                        class="w-full border-gray-300 max-w-[185px] focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                        <option value="" hidden selected>Seleccione estación</option>
                                        <option value="NULL" >Sin estación</option>
                                        <template x-for="estacion in estaciones" :key="estacion.id">
                                            <option :value="estacion.id" x-text="estacion.name"></option>
                                        </template>
                                    </select>
                                </div> --}}
                                <div>
                                    <label :for="`t${prod.id}`" class="font-medium text-sm text-gray-700 dark:text-gray-300">{{__('Ticket')}}</label>
                                    <select :name="`t${prod.id}`" :id="`t${prod.id}`" x-model="prod.tck"
                                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                        <option value="NULL" >Sin ticket</option>
                                        <option value="" hidden selected>Seleccione ticket</option>
                                        <template x-for="tck in tickets" :key="tck.id">
                                            <option :value="tck.id" x-text="'Ticket #'+tck.id"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label :for="`p${prod.id}`" class="font-medium text-sm text-gray-700 dark:text-gray-300">{{__('Producto')}}</label>
                                    <select :name="`p${prod.id}`"
                                                    :id="`SprodS${prod.id}`" x-model="prod.prod"
                                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                        <option value="" hidden selected>Seleccione producto</option>
                                        <template x-for="pr in productos" :key="pr.id + 'Psl'">
                                            <option :value="pr.id" x-text="pr.name"></option>
                                        </template>
                                    </select>
                                    {{-- <div x-data="selectConfigs()" :id="`p${prod.id}`" class="borderflex flex-col items-center relative">
                                        <div class="h-full">
                                            <div @click.away="close()" class="h-full border border-gray-300 flex focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1">
                                                <input placeholder="Seleccionar producto"
                                                    x-model="filter"
                                                    x-transition:leave="transition ease-in duration-100"
                                                    x-transition:leave-start="opacity-100"
                                                    x-transition:leave-end="opacity-0"
                                                    @mousedown="open()"
                                                    @keydown.enter.stop.prevent="selectOption()"
                                                    class=" border-0 p-1 px-2 rounded-md appearance-none outline-none w-full  dark:bg-dark-eval-1">
                                                <div class="w-8 flex justify-center items-center">
                                                    <button @click="toggle()" class="w-full h-full cursor-pointer text-gray-600 outline-none focus:outline-none">
                                                        <div class="w-full h-full flex justify-center items-center transform transition duration-300" :class="{'-rotate-180':show}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down w-5 h-5" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M6 9l6 6l6 -6"></path>
                                                            </svg>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div x-show="isOpen()" class="border absolute shadow bg-white top-full max-w-xs z-40 lef-0 rounded max-h-select overflow-y-auto dark:bg-dark-eval-1 dark:border-gray-400">
                                            <div class="flex flex-col">
                                            <template x-for="(option, index) in filteredOptions()" :key="index">
                                                <div @click="onOptionClick(index,prod.id)" :class="classOption(option.id, index)" :aria-selected="focusedOptionIndex === index">
                                                    <div class="flex w-full items-center p-2 pl-2 border-transparent  relative">
                                                        <div class="w-full items-center flex">
                                                            <div class="mx-2 -mt-1"><span x-text="option.name"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="relative">
                                    <label :for="`base${prod.id}`" class="font-medium text-sm text-gray-700 dark:text-gray-300">{{__('Cantidad')}}</label>
                                    <input type="number" name="base" x-model="prod.cantsol"
                                    :id="`base${prod.id}`" required autofocus autocomplete="base" 
                                    value="0" min="0"  placeholder=" "  class="peer w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                </div>
                                <div class="w-full">
                                    <label :for="`obs${prod.id}`" class="font-medium text-sm text-gray-700 dark:text-gray-300">{{__('Observación')}}</label>
                                    <select x-model="prod.observacion"
                                    class="w-full border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700"
                                    name="observacion" id="obs{{$productos[$key]['id']}}">
                                        <option value="" hidden>Seleccione una opción</option>
                                        <option value="NUEVO">NUEVO</option>
                                        <option value="USADO">USADO</option>
                                        <option value="REPARADO">REPARADO</option>
                                        <option value="DAÑADO">DAÑADO</option>
                                        <option value="RETORNO">RETORNO</option>
                                    </select>
                                </div>
                                <div class="w-full">

                                    <label :for="`ser${prod.id}`" class="font-medium text-sm text-gray-700 dark:text-gray-300">{{__('Serie')}}</label>
                                    <x-input id="ser{{$productos[$key]['id']}}" x-model="prod.serie"
                                     class="w-full" type="text" name="serie"/>
                                </div>
                            </div>
                            <template x-if="prod.id>1">
                                <button type="button" @click="remove(prod.id)" class="max-lg:w-full h-fit flex justify-center items-center text-white p-2 rounded-md bg-red-600 hover:bg-red-700 transition duration-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                    </svg>
                                </button>
                            </template>
                        </div>
                    </template>
                </div>
                <div class="py-2 flex justify-end">
                    <button @click="addChild()" class="rounded-md text-white bg-green-700 hover:bg-green-800 transition duration-300 p-2 flex gap-2 justify-center items-center">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                            <path d="M13 15.6c.3.2.7.2 1 0l5-2.9v.3c.7 0 1.4.1 2 .4v-1.8l1-.6c.5-.3.6-.9.4-1.4l-1.5-2.5c-.1-.2-.2-.4-.4-.5l-7.9-4.4c-.2-.1-.4-.2-.6-.2s-.4.1-.6.2L3.6 6.6c-.2.1-.4.2-.5.4L1.6 9.6c-.3.5-.1 1.1.4 1.4c.3.2.7.2 1 0v5.5c0 .4.2.7.5.9l7.9 4.4c.2.1.4.2.6.2s.4-.1.6-.2l.9-.5c-.3-.6-.4-1.3-.5-2m-2 0l-6-3.4V9.2l6 3.4v6.7m9.1-9.6l-6.3 3.6l-.6-1l6.3-3.6l.6 1M12 10.8V4.2l6 3.3l-6 3.3m8 4.2v3h3v2h-3v3h-2v-3h-3v-2h3v-3h2Z"/>
                        </svg>
                        <span>Añadir más</span>
                    </button>
                </div>
            </div>
            <script>
                const prod={!!json_encode($listProductos)!!};
                const tck={!!json_encode($tickets)!!}
            </script>
        </div>
        <div class="flex flex-wrap gap-3 justify-center mt-2">
            <x-button type="primary" class="flex justify-center items-center gap-2" @click="send()">
                <div role="status" wire:loading wire:target="updateEntrada">
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
                Guardar y descargar
            </x-button>      
        </div>
    </div>
</div>