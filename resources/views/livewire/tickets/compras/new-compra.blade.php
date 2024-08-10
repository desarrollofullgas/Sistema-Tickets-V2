<div x-data="{servicios:[],productos:[],tipo:@entangle('tipo'),showProd:false,showServ:false,showSearch:false,
    filtro:'',
    filterProd(){
        return this.productos
                ? this.productos.filter(pr => {
                    return (pr.name.toLowerCase().includes(this.filtro.toLowerCase())); 
                })
                : {}
    },
    filterServ(){
        return this.servicios.length>0
                ? this.servicios.filter(serv => {
                    return (serv.name.toLowerCase().includes(this.filtro.toLowerCase())); 
                })
                : {}
    },
    prod(){
        this.showServ=false;
        this.showProd=true;
    },
    serv(){
        this.showServ=true;
        this.showProd=false;
        this.showSearch=false;
        this.productos=[];
        $wire.set('categoria','');
        this.servicios=listS;
    },
    chargeProd(event){
        this.productos = listP.filter((item)=> item.categoria_id==event.target.value);
        $wire.set('categoria',event.target.value);
        this.showSearch=true;
    },
    sendCar(){
        this.tipo=='Producto'
        ?$wire.set('carrito',this.productos.filter(item=> item.selected))
        :$wire.set('carrito',this.servicios.filter(item=> item.selected));
        $wire.addCompra();
    },
    previus(){
        this.productos=[];
        $wire.previusStep();
        
    }
}">
<script wire:ignore>
    const listP={!!json_encode($productos)!!}
    const listS={!!json_encode($servicios)!!}
</script>
    <div class="p-6 bg-white rounded-md shadow-md dark:bg-dark-eval-1" >
        <h2 class="text-lg text-center mb-2 font-bold">INFORMACIÓN DEL CORREO</h2>
        <div class="flex flex-col gap-2 overflow-hidden">
            <div>
                <x-label value="{{ __('Titulo') }}" for="titulo" />
                <x-input wire:model="titulo" type="text" name="titulo"
                    id="titulo" required autofocus autocomplete="titulo" class="w-full"/>
                <x-input-error for="titulo"></x-input-error>
            </div>
            <div>
                <x-label value="{{ __('Problema detectado') }}" />
                <textarea wire:model="problema" class="form-control h-32 w-full resize-none rounded-md dark:bg-slate-800" name="problema"
                    required autofocus autocomplete="problema" cols="30" rows="8"></textarea>
                <x-input-error for="problema"></x-input-error>
            </div>
            <div>
                <x-label value="{{ __('Solución') }}" />
                <textarea wire:model="solucion" class="form-control h-24 w-full resize-none rounded-md dark:bg-slate-800" name="solucion"
                    required autofocus autocomplete="solucion" cols="30" rows="8"></textarea>
                <x-input-error for="solucion"></x-input-error>
            </div>
            <div class="mb-1 col-12 w-full"
                    x-data="{ isUploading: false, progress: 0 }"
                    x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false"
                    x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">
    
                <x-label value="{{ __('Evidencias') }}" class="border-b border-gray-400 w-full text-left mb-2"/>
                <input type="file" wire:model="evidencias" class=" pb-2 flex flex-wrap file:text-sm file:font-semibold file:bg-blue-300 file:text-blue-700 hover:file:bg-blue-100 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0"
                multiple name="evidencias" required autocomplete="evidencias" accept="image/*, video/*, .pdf, .doc, .docx">
                <x-input-error for="evidencias"></x-input-error>
    
                <!-- Progress Bar -->
                <p x-text="progress" x-show="isUploading"></p>
                <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-2.5 mb-2 dark:bg-gray-700">
                    <div class="bg-red-600 h-2.5 rounded-full dark:bg-red-500 transition-[width] duration-500"  x-bind:style="`width:${progress}%`"></div>
                </div>
            </div>
        </div>
		<span class="text-gray-400 text-sm">Tamaño máximo archivos de video <strong>16 MB</strong>.</span>
    </div>
    <div class=" mt-4 p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <h2 class="text-lg text-center mb-2 font-bold">DATOS DE LA REQUISICIÓN</h2>
        <div class="text-center mb-2">
            <div class="flex justify-center gap-2">
                <div @click="prod()">
                    <input wire:model="tipo" type="radio" name="tipo" id="Producto" value="Producto" class="peer/producto hidden">
                    <label for="Producto" class="cursor-pointer bg-gray-300 dark:bg-dark-eval-0 peer-checked/producto:bg-amber-600 hover:bg-amber-500 text-white px-3 py-1 rounded-md transition duration-300">
                        Producto
                    </label>
                </div>
                <div @click="serv()">
                    <input wire:model="tipo" type="radio" name="tipo" id="Servicio" value="Servicio" class=" peer/producto hidden">
                    <label for="Servicio" class="cursor-pointer bg-gray-300 dark:bg-dark-eval-0 peer-checked/producto:bg-amber-600 hover:bg-amber-500 text-white px-3 py-1 rounded-md transition duration-300">
                        Servicio
                    </label>
                </div>
            </div>
            <x-input-error for="tipo"></x-input-error>
        </div>
        <template x-if="showProd">
            <div class="flex flex-col gap-2">
                <div class="flex flex-wrap gap-2 items-end">
                    <div>
                        <x-label value="{{ __('Categoría de producto') }}" />
                        <select id="categoria" wire:model="categoria" @change="chargeProd(event)"
                                class="select-estaciones form-select form-control border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700  {{ $errors->has('categoria') ? 'is-invalid' : '' }}" 
                                name="categoria" required aria-required="true">
                            <option hidden value="" selected>{{ __('Seleccionar categoría') }}</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{$categoria->id}}">{{$categoria->name}}</option>
                            @endforeach
                        </select>
                        <x-input-error for="categoria"></x-input-error>
                    </div>
                    <div>
                        <x-input type="search" name="search" x-show="showSearch" x-cloak x-model="filtro"
                            id="search" placeholder="Buscar..." required autofocus autocomplete="search" class="w-full"/>
                    </div>
                </div>
                <template x-if="showSearch">
                    <div>
                        <div class="py-1 border-b-2 mb-2">
                            <h2>Seleccione sus productos</h2>
                        </div>
                        <div class="flex flex-wrap gap-3 justify-center max-h-80 overflow-auto" wire:ignore>
                            <template x-for="pr in filterProd()" :key="pr.id">
                                <div x-data="{toggle:false}" class="h-fit felx flex-col justify-center items-center gap-1 max-w-[15rem] text-center border-2 py-2 px-3 rounded-md" :class="pr.selected?'border-blue-600 bg-blue-900 text-white':'border-gray-300 bg-gray-300 dark:bg-dark-eval-3 dark:border-dark-eval-3'">
                                    <div class="flex flex-row items-center gap-0.5 relative w-full">
                                        <input type="checkbox" :value="`${pr.id}`" name="carrito[]" :id="`${pr.name}`" class="hidden">
                                        <div class="w-full">
                                            <label :for="`${pr.name}`" class="break-all w-full cursor-pointer" @click="pr.selected=!pr.selected">
                                                <div class="flex justify-center items-center">
                                                    <figure class="w-[5rem] h-[5rem] overflow-hidden rounded-full flex justify-center items-center">
                                                        <img :src="`/storage/${pr.product_photo_path}`" alt="" class="w-full">
                                                    </figure>
                                                </div>
                                                <p x-text="pr.name"></p>
                                            </label>
                                        </div>    
                                    </div>
                                    <div class="w-full" x-show="pr.selected" x-cloak x-collapse>
                                        <label :for="`${pr.name}ct`">{{ __('Cantidad') }}</label>
                                        <input type="number" :name="`${pr.name}ct`" min=0
                                        :id="`${pr.name}ct`" required autofocus x-model="pr.cantidad"
                                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                                        dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 text-black w-full">
                                    </div>
                                </div>
                            </template>
                        </div>    
                    </div>
                </template>
            </div>
        </template>
        <template x-if="showServ">
            <div>
                <div>
                    <x-input  type="search" name="searchService" x-model="filtro"
                        id="searchService" placeholder="Buscar..." required autofocus autocomplete="searchService" class="w-full"/>
                </div>
                <div>
                    <div class="py-1 border-b-2 mb-2">
                        <h2>Seleccione los servicios que requiere</h2>
                    </div>
                    <div class="flex flex-wrap gap-3 justify-evenly max-h-80 overflow-auto" wire:ignore>
                        <template x-for="serv in filterServ()" :key="serv.id">
                            <div x-data="{toggle:false}" class="h-fit felx flex-col justify-center items-center gap-1 max-w-[15rem] text-center border-2 py-2 px-3 rounded-md" :class="serv.selected?'border-blue-600 bg-blue-900 text-white':'border-gray-300 bg-gray-300 dark:bg-dark-eval-3 dark:border-dark-eval-3'">
                                {{-- <p x-text="serv.id"></p> --}}
                                <div class="flex flex-row items-center gap-0.5 relative w-full">
                                    <input type="checkbox" :value="`${serv.id}`" name="carrito[]" :id="`${serv.name}`" class="hidden">
                                    <div class="w-full">
                                        <label :for="`${serv.name}`" class="break-all w-full cursor-pointer" @click="serv.selected=!serv.selected">
                                            <p x-text="serv.name"></p>
                                        </label>
                                    </div>    
                                </div>
                                <div class="w-full" x-show="serv.selected" x-cloak x-collapse>
                                    <label :for="`${serv.name}ct`">{{ __('Cantidad') }}</label>
                                    <input type="number" :name="`${serv.name}ct`" min=0
                                    :id="`${serv.name}ct`" required autofocus x-model="serv.cantidad"
                                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                                    dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 text-black w-full">
                                </div>
                            </div>
                        </template>
                       {{--  @foreach ($servicios as $key => $pr)
                            <div class="flex flex-row items-center gap-0.5 relative ">
                                <input type="checkbox" wire:model="carrito.{{$key}}.id" value="{{$pr->id }}" name="carrito[]" id="{{$pr->name}}" class="hidden">
                                <label for="{{$pr->name}}" class="break-all w-full text-center border-2 py-2 px-3 rounded-md cursor-pointer ">
                                    {{$pr->name}}               
                                </label>
                            </div>
                        @endforeach --}}
                    </div>    
                </div>
            </div>
        </template>
        <x-input-error for="carrito"></x-input-error>
        <x-input-error for="carrito.*"></x-input-error>
    </div>
    @if ($step == 1)
    @elseif($step ==2)
        
        {{-- @if ($tipo == "Producto")    
            <div class="flex flex-col gap-2">
                <div class="flex flex-wrap gap-2 items-end">
                    <div>
                        <x-label value="{{ __('Clase de producto') }}" />
                        <select id="clase" wire:model="clase" @change="showProd=true"
                                class="select-estaciones form-select form-control border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700  {{ $errors->has('clase') ? 'is-invalid' : '' }}" 
                                name="clase" required aria-required="true">
                            <option hidden value="" selected>{{ __('Seleccionar clase') }}</option>
                            @foreach ($clases as $clase)
                                <option value="{{$clase->id}}">{{$clase->name}}</option>
                            @endforeach
                        </select>
                        <x-input-error for="clase"></x-input-error>
                    </div>
                    @if ($productos)
                        <div>
                            <x-input wire:model="search" type="search" name="search"
                                id="search" placeholder="Buscar..." required autofocus autocomplete="search" class="w-full"/>
                        </div>
                    @endif
                </div>
                <x-input-error for="carrito"></x-input-error>
                <div>
                    @if ($productos)
                        <div class="py-1 border-b-2 mb-2">
                            <h2>Seleccione sus productos</h2>
                        </div>
                        <div class="flex flex-wrap gap-3 justify-center max-h-80 overflow-auto">
                            @foreach ($productos as $key => $pr)
                                <div class="flex flex-row items-center gap-0.5 relative max-w-[20rem]">
                                    <input type="checkbox" wire:model="carrito.{{$key}}.id" value="{{$pr->id }}" name="carrito[]" id="{{$pr->name}}" class="hidden">
                                    <label for="{{$pr->name}}" class="break-all w-full text-center border-2 py-2 px-3 rounded-md cursor-pointer" @click="changeStatus({{$pr->id}})" :class="(prods[{{$key}}].id=={{$pr->id}} && prods[{{$key}}].selected)?'border-blue-600':'border-gray-300 '">
                                        <div class="flex justify-center items-center">
                                            <figure class="w-[8rem] h-[8rem] overflow-hidden rounded-full flex justify-center items-center">
                                                <img src="{{ asset('storage/' . $pr->archivo_path) }}" alt="" class="w-full">
                                            </figure>
                                        </div>
                                        {{$pr->name}}
                                        <div class="col-12 p-0">
                                            <x-label value="{{ __('Prioridad') }}" />
                                            <select wire:model="carrito.{{$key}}.prioridad"
                                                    class="select-estaciones form-select form-control border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700 " 
                                                    name="carrito.{{$key}}.prioridad" required aria-required="true">
                                                    <option hidden value="" selected>{{ __('Seleccionar Prioridad') }}</option>
                                                    <option value="Bajo">{{ __('Bajo') }}</option>
                                                    <option value="Medio">{{ __('Medio') }}</option>
                                                    <option value="Alto">{{ __('Alto') }}</option>
                                                    <option value="Alto crítico">{{ __('Alto crítico') }}</option>
                                            </select>
                                            <x-input-error for="carrito.{{$key}}.prioridad"></x-input-error>
                                        </div>
                                        <div>
                                            <x-label value="{{ __('Cantidad') }}" for="carrito.{{$key}}.cantidad" />
                                            <x-input wire:model="carrito.{{$key}}.cantidad" type="number" name="carrito.{{$key}}.cantidad" min
                                                id="carrito.{{$key}}.cantidad" required autofocus autocomplete="carrito.{{$key}}.cantidad" class="w-full"/>
                                            <x-input-error for="carrito.{{$key}}.cantidad"></x-input-error>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>    
                    @endif
                </div>
            </div>
        @elseif ($tipo == "Servicio")
            <div>
                <x-input wire:model.debounce.200ms="searchService" type="search" name="searchService"
                    id="searchService" placeholder="Buscar..." required autofocus autocomplete="searchService" class="w-full"/>
            </div>
            <x-input-error for="carrito"></x-input-error>
            <div>
                @if ($servicios)
                    <div class="py-1 border-b-2 mb-2">
                        <h2>Seleccione los servicios que requiere</h2>
                    </div>
                    <div class="flex flex-wrap gap-3 justify-evenly max-h-80 overflow-auto">
                        @foreach ($servicios as $key => $pr)
                            <div class="flex flex-row items-center gap-0.5 relative ">
                                <input type="checkbox" wire:model="carrito.{{$key}}.id" value="{{$pr->id }}" name="carrito[]" id="{{$pr->name}}" class="hidden">
                                <label for="{{$pr->name}}" class="break-all w-full text-center border-2 py-2 px-3 rounded-md cursor-pointer ">
                                    {{$pr->name}}               
                                </label>
                            </div>
                        @endforeach
                    </div>    
                @endif
            </div>
        @endif --}}
    @else
    {{-- step #3 --}}
    <div class="flex flex-col gap-2">
        <div>
            @if ($tipo=="Producto")    
                @if ($productos)
                    <div class="py-1 border-b-2 mb-2">
                        <h2>Ingrese la información de sus productos</h2>
                    </div>
                    <div class="flex flex-wrap gap-2 justify-center max-h-80 overflow-auto">
                        @foreach ($productos as $key => $pr)
                            @foreach ($carrito as $produc)
                                @if ($produc['id'] == $pr->id)
                                <div class="flex flex-row items-center gap-0.5">
                                    <div class="break-all text-start w-full border-2 p-2 rounded-md border-gray-300 cursor-pointer peer-checked:border-blue-600">
                                        <x-input-error for="carrito.{{$key}}"></x-input-error>
                                        <div class="flex justify-center items-center">
                                            <figure class="w-[4rem] h-[4rem] overflow-hidden rounded-full flex justify-center items-center">
                                                <img src="{{ asset('storage/' . $pr->product_photo_path) }}" alt="" class="w-full">
                                            </figure>
                                        </div>
                                        {{$pr->name}}
                                        <div>
                                            <x-label value="{{ __('Cantidad') }}" for="carrito.{{$key}}.cantidad" />
                                            <x-input wire:model="carrito.{{$key}}.cantidad" type="number" name="carrito.{{$key}}.cantidad" min
                                                id="carrito.{{$key}}.cantidad" required autofocus autocomplete="carrito.{{$key}}.cantidad" class="w-full"/>
                                            <x-input-error for="carrito.{{$key}}.cantidad"></x-input-error>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>    
                @endif
            @elseif($tipo=="Servicio")
            <div class="py-1 border-b-2 mb-2">
                <h2>Complete la siguiente información</h2>
            </div>
            <div class="flex flex-wrap gap-2 justify-center max-h-80 overflow-auto">
                @foreach ($servicios as $key => $pr)
                    @foreach ($carrito as $produc)
                        @if ($produc['id'] == $pr->id)
                        <div class="flex flex-row items-center gap-0.5">
                            <div class="break-all text-start w-full border-2 p-2 rounded-md border-gray-300 cursor-pointer peer-checked:border-blue-600">
                                <x-input-error for="carrito.{{$key}}"></x-input-error>
                                <h2>{{$pr->name}}</h2>
                                {{-- <div class="col-12 p-0">
                                    <x-label value="{{ __('Prioridad') }}" />
                                    <select wire:model="carrito.{{$key}}.prioridad"
                                            class="select-estaciones form-select form-control border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700 " 
                                            name="carrito.{{$key}}.prioridad" required aria-required="true">
                                            <option hidden value="" selected>{{ __('Seleccionar Prioridad') }}</option>
                                            <option value="Bajo">{{ __('Bajo') }}</option>
                                            <option value="Medio">{{ __('Medio') }}</option>
                                            <option value="Alto">{{ __('Alto') }}</option>
                                            <option value="Alto crítico">{{ __('Alto crítico') }}</option>
                                    </select>
                                    <x-input-error for="carrito.{{$key}}.prioridad"></x-input-error>
                                </div> --}}
                                <div>
                                    <x-label value="{{ __('Cantidad') }}" for="carrito.{{$key}}.cantidad" />
                                    <x-input wire:model="carrito.{{$key}}.cantidad" type="number" name="carrito.{{$key}}.cantidad" min
                                        id="carrito.{{$key}}.cantidad" required autofocus autocomplete="carrito.{{$key}}.cantidad" class="w-full"/>
                                    <x-input-error for="carrito.{{$key}}.cantidad"></x-input-error>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                @endforeach
            </div> 
            @endif
        </div>
    </div>
    @endif
    {{-- <div class="flex flex-wrap gap-3 justify-center">
        @if ($step == 1)
            <button  type="button" wire:click="nextStep" class="rounded-md max-w-[8rem] flex gap-1 items-center px-3 py-1 bg-blue-600 text-white hover:bg-blue-700 transition duration-300">
                Siguiente
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512" fill="currentColor">
                    <path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/>
                </svg>
            </button>
        @elseif($step==2)
            <button  type="button" wire:click="previusStep" class="rounded-md max-w-[8rem] flex gap-1 items-center px-3 py-1 bg-blue-600 text-white hover:bg-blue-700 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512" fill="currentColor">
                    <path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/>
                </svg>
                Regresar
            </button>
            <button  type="button"  class="rounded-md max-w-[8rem] flex gap-1 items-center px-3 py-1 bg-blue-600 text-white hover:bg-blue-700 transition duration-300"  @click="sendCar()">
                Siguiente
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512" fill="currentColor">
                    <path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/>
                </svg>
            </button>
        @else
            <button  type="button" wire:click="previusStep" class="rounded-md max-w-[8rem] flex gap-1 items-center px-3 py-1 bg-blue-600 text-white hover:bg-blue-700 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512" fill="currentColor">
                    <path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/>
                </svg>
                Regresar
            </button>
            @if (count($carrito) > 0)    
                <button  type="button" wire:click="addCompra" class="rounded-md max-w-[8rem] flex gap-1 items-center px-3 py-1 bg-green-600 text-white hover:bg-green-700 transition duration-300">
                    Enviar
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail-forward h-6 w-6"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 18h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7.5"></path>
                        <path d="M3 6l9 6l9 -6"></path>
                        <path d="M15 18h6"></path>
                        <path d="M18 15l3 3l-3 3"></path>
                    </svg>
                </button>
            @endif
        @endif
    </div> --}}
    <div>

    </div>
    <div class="flex flex-wrap gap-3 justify-center">
        {{-- @if ($step !=1)
        <button  type="button" wire:click="previusStep" class="rounded-md max-w-[8rem] flex gap-1 items-center px-3 py-1 bg-blue-600 text-white hover:bg-blue-700 transition duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512" fill="currentColor">
                <path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/>
            </svg>
            Regresar
        </button>
        @endif
        @if ($step!=3)
        <button  type="button" class="rounded-md max-w-[8rem] flex gap-1 items-center px-3 py-1 bg-blue-600 text-white hover:bg-blue-700 transition duration-300"  @click="sendCar()">
            Siguiente
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512" fill="currentColor">
                <path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/>
            </svg>
        </button>
        @endif
        @if ($step>2)
        @endif --}}
        <button id="sendButton"  type="button" class="rounded-md max-w-[8rem] flex gap-1 items-center px-3 py-1 bg-gray-800 text-white hover:bg-gray-600 mt-3" @click="sendCar()">
            <div role="status" wire:loading wire:target="addCompra">
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
            Enviar
        </button>
    </div>

</div>

