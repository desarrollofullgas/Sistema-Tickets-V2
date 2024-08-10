<div x-data="{ modelOpen: false }">
    <button @click="modelOpen =!modelOpen" wire:loading.attr="disabled" aria-label="añadir tipo" class="flex gap-2 items-center px-4 py-2 rounded-md bg-gray-400 text-white font-semibold hover:bg-gray-500">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="w-5 h-5" fill="currentColor">
            <path d="M58.9 42.1c3-6.1 9.6-9.6 16.3-8.7L320 64 564.8 33.4c6.7-.8 13.3 2.7 16.3 8.7l41.7 83.4c9 17.9-.6 39.6-19.8 45.1L439.6 217.3c-13.9 4-28.8-1.9-36.2-14.3L320 64 236.6 203c-7.4 12.4-22.3 18.3-36.2 14.3L37.1 170.6c-19.3-5.5-28.8-27.2-19.8-45.1L58.9 42.1zM321.1 128l54.9 91.4c14.9 24.8 44.6 36.6 72.5 28.6L576 211.6v167c0 22-15 41.2-36.4 46.6l-204.1 51c-10.2 2.6-20.9 2.6-31 0l-204.1-51C79 419.7 64 400.5 64 378.5v-167L191.6 248c27.8 8 57.6-3.8 72.5-28.6L318.9 128h2.2z"/>
        </svg>
        {{ __('Añadir Stock') }}
    </button>
    <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center md:items-center sm:p-0">
            <div x-cloak @click="modelOpen = false" x-show="modelOpen" 
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0" 
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100" 
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-gray-500 dark:bg-gray-700/75 bg-opacity-75" aria-hidden="true"
            ></div>
            <div x-cloak x-show="modelOpen" 
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block w-full max-w-3xl p-6 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-3xl dark:bg-dark-eval-1"
            >      
            <div class="bg-dark-eval-1 p-1 rounded-md text-white text-center mb-2">
                {{ __('Nuevo Producto para el almacén') }}
            </div>
                <div x-data="{list:data,productos:[], search(event){
                    this.list=data.filter((item)=>item.name.toLowerCase().includes(event.target.value));
                    //console.log(prod);
                }, 
                    send(){
                        this.productos= this.list.filter((item)=>item.show===true);
                        //console.log(this.productos);
                        $wire.set('productos',this.productos);
                        $wire.addAlmacen();
                    } }">
                    <div class="py-2">
                        <div>
                            <x-input type="search" name="search" @change="search(event)"
                                id="search" placeholder="Buscar..." required autofocus autocomplete="search" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                                dark:text-gray-300 dark:focus:ring-offset-dark-eval-1"/>
                        </div>
                            <script>
                                const data={!!json_encode($productslist)!!};
                            </script>
                        <div class="mt-2 p-2 flex flex-wrap gap-2 max-h-80 overflow-auto" >
                            <template x-for="prod in list" :key="prod.id">
                                <div x-data="{options:false}" class="w-full">
                                    <div class="overflow-hidden">
                                        <input type="checkbox" name="productos[]"  class="peer hidden" :id="`p${prod.id}`">
                                        <label class="border flex justify-start gap-2 items-center w-full cursor-pointer p-2 rounded-md transition duration-300 delay-100 overflow-hidden max-[400px]:flex-wrap" :for="`p${prod.id}`"  :class="prod.show?'bg-gray-300  dark:bg-gray-400 ':'border-gray-300 dark:border-gray-500'">
                                            <div class="w-full flex gap-2 items-center flex-col min-[380px]:flex-row" @click="prod.show=!prod.show">
                                                <figure class="max-w-[3rem] max-h-[3rem] rounded-full overflow-hidden">
                                                    <img  class="rounded-full " alt="imagen producto" :src="`/storage/${prod.product_photo_path}`">
                                                </figure>
                                                <div x-text="prod.name" class="transition duration-300 text-black font-bold delay-100" :class="prod.show?'text-white font-bold':''"></div>
                                            </div>
                                            <div class="w-full m-2 flex gap-2 max-[580px]:flex-wrap justify-center items-center" x-cloak x-show="prod.show"
                                                x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0 translate-x-full"
                                                x-transition:enter-end="opacity-100 tranlate-x-0"
                                                x-transition:leave="transition ease-in duration-300"
                                                x-transition:leave-start="opacity-100 tranlate-x-0"
                                                x-transition:leave-end="opacity-0 translate-x-full">
                                                <div>
                                                    <div class="relative" >
                                                        <input type="number" name="stock" x-model="prod.stock"
                                                        :id="`stock${prod.id}`" required autofocus autocomplete="stock" 
                                                         value="0" min="0" placeholder=" " class="peer border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                                                         dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                                        <label :for="`stock${prod.id}`" class="absolute rounded-md duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-dark-eval-1 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{ __('Stock actual') }} </label>
                                                    </div>
                                                    <x-input-error for=""></x-input-error>
                                                </div>
                                                <div>
                                                    <div class="relative">
                                                        <input type="number" name="base" x-model="prod.base"
                                                        :id="`base${prod.id}`" required autofocus autocomplete="base" 
                                                        value="0" min="0" placeholder=" "  class="peer border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                                                        dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                                        <label :for="`base${prod.id}`" class="absolute rounded-md duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-dark-eval-1 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"> {{ __('Stock base') }}</label>
                                                    </div>
                                                    <x-input-error for=""></x-input-error>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div>
                        <x-input-error for="productos"></x-input-error>
                        <x-input-error for="productos.*.base"></x-input-error>
                        <x-input-error for="productos.*.stock"></x-input-error>
                    </div>
                    <div name="footer" class="d-none text-right mt-2">
                        <x-danger-button class="mr-2" wire:loading.attr="disabled" @click="send()">
							 <div role="status" wire:loading wire:target="addAlmacen">
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
            
                        <x-secondary-button @click="modelOpen = false" wire:loading.attr="disabled">
                            Cancelar
                        </x-secondary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>