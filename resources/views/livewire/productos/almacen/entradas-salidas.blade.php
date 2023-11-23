<div x-data="{ modelOpen: false }">
    <button @click="modelOpen =!modelOpen" wire:loading.attr="disabled" aria-label="añadir tipo"
        class="flex gap-2 items-center px-4 py-2 rounded-md bg-black text-white font-semibold hover:bg-gray-700 ">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M294.2 277.7c18 5 34.7 13.4 49.5 24.7l161.5-53.8c8.4-2.8 12.9-11.9 10.1-20.2L454.9 47.2c-2.8-8.4-11.9-12.9-20.2-10.1l-61.1 20.4l33.1 99.4L346 177l-33.1-99.4l-61.6 20.5c-8.4 2.8-12.9 11.9-10.1 20.2l53 159.4zm281 48.7L565 296c-2.8-8.4-11.9-12.9-20.2-10.1l-213.5 71.2c-17.2-22-43.6-36.4-73.5-37L158.4 21.9C154 8.8 141.8 0 128 0H16C7.2 0 0 7.2 0 16v32c0 8.8 7.2 16 16 16h88.9l92.2 276.7c-26.1 20.4-41.7 53.6-36 90.5c6.1 39.4 37.9 72.3 77.3 79.2c60.2 10.7 112.3-34.8 113.4-92.6l213.3-71.2c8.3-2.8 12.9-11.8 10.1-20.2zM256 464c-26.5 0-48-21.5-48-48s21.5-48 48-48s48 21.5 48 48s-21.5 48-48 48z" />
        </svg>
        {{ __('Entradas y salidas') }}
    </button>
    <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center md:items-center sm:p-0">
            <div x-cloak @click="modelOpen = false" x-show="modelOpen"
                x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-gray-500 dark:bg-gray-700/75 bg-opacity-75"
                aria-hidden="true"></div>
            <div x-cloak x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block w-full max-w-3xl p-6  text-left transition-all transform bg-white rounded-lg shadow-xl  dark:bg-dark-eval-1">
                <div class="bg-dark-eval-1 p-1 rounded-md text-white text-center mb-2">
                    {{ __('Entradas y Salidas') }}
                </div>
                <div class="my-2" x-data="{
                    productos: prod,
                    estaciones: est,
                    tickets: [],
                    contador: 1,
                    showSerie: false,
                    showSerie2: false,
                    carrito: [{ id: 1, tck: '', estacion: '', prod: '', observacion: '', cantsol: '', serie: '' }],
                    addChild() {
                        this.contador++;
                        this.carrito.push({ id: this.contador, tck: '', estacion: '', prod: '', observacion: '', cantsol: '', serie: '' })
                        //console.log(this.carrito);
                    },
                    remove(id) {
                        this.carrito = this.carrito.filter((item) => item.id !== id);
                    },
                    send() {
                        //console.log(this.carrito);
                        $wire.set('carrito', this.carrito);
                        $wire.operacion();
                        setTimeout(() => $wire.refresh(), 50);
                    },
                    Selects(){
                        return {
                            tickets:[],
                            filterTCK(event){
                                const user=est.find(item=>item.id==event.target.value);
                                this.tickets=tck.filter(item=>item.solicitante_id==user.user_id);
                            }
                        }
                    },
                    selectConfigs() {
                        return {
                            filter: ' ',
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
                                this.show ? this.close() : this.open();
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
                                return this.options ?
                                    this.options.filter(option => {
                                        return (option.name.toLowerCase().indexOf(this.filter) > -1)
                                    }) : {}
                            },
                            onOptionClick(index, car) {
                                this.focusedOptionIndex = index;
                                this.selectOption(car); //el id es para editar el carrito
                                this.filterSeries(this.options[index].id);
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
                                } else {
                                    this.selected = selected;
                                    this.filter = this.selectedName();
                                    this.carrito = this.carrito.map((item) => {
                                        if (item.id == id) {
                                            item.prod = this.selected.id
                                        }
                                        return item;
                                    });
                                }
                                this.close();
                            }
                        }
                    }
                    }">
                    <div class=" text-center text-base">
                        <div class="">
                            <x-label value="{{ __('Seleccione la operación a realizar') }}" for="tipo" />
                            <div class="flex gap-2 justify-center py-3">
                                <div id="tipo">
                                    <input type="radio" name="tipo" id="entrada" value="entrada"
                                        wire:model.defer="tipo" class="peer/entrada hidden"
                                        @click="showSerie=true; showSerie2=false">
                                    <label for="entrada"
                                        class="flex items-center justify-center gap-1 cursor-pointer bg-gray-300 dark:bg-dark-eval-0 peer-checked/entrada:bg-black hover:bg-black text-white px-4 py-2 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 21l-8 -4.5v-9l8 -4.5l8 4.5v4.5"></path>
                                            <path d="M12 12l8 -4.5"></path>
                                            <path d="M12 12v9"></path>
                                            <path d="M12 12l-8 -4.5"></path>
                                            <path d="M22 18h-7"></path>
                                            <path d="M18 15l-3 3l3 3"></path>
                                        </svg>
                                        Entrada
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" name="tipo" id="salida" value="salida"
                                        wire:model.defer="tipo" class="peer/salida hidden"
                                        @click="showSerie=false; showSerie2=true">
                                    <label for="salida"
                                        class="flex items-center justify-center gap-1 cursor-pointer bg-gray-300 dark:bg-dark-eval-0 peer-checked/salida:bg-black hover:bg-black text-white px-4 py-2 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 21l-8 -4.5v-9l8 -4.5l8 4.5v4.5"></path>
                                            <path d="M12 12l8 -4.5"></path>
                                            <path d="M12 12v9"></path>
                                            <path d="M12 12l-8 -4.5"></path>
                                            <path d="M15 18h7"></path>
                                            <path d="M19 15l3 3l-3 3"></path>
                                        </svg>
                                        Salida
                                    </label>
                                </div>
                            </div>
                            <x-input-error for="tipo"></x-input-error>
                        </div>
                    </div>
                    <div>
                        <div class="relative border-b border-gray-400 pb-2">
                            <input type="text" name="motivo" id="motivo" required autofocus autocomplete="base"
                                wire:model.defer="motivo" placeholder=" "
                                class="peer w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                            <label for="motivo"
                                class="absolute rounded-md duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-dark-eval-1 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                {{ __('Motivo') }}</label>
                        </div>
                        <x-input-error for="motivo"></x-input-error>
                    </div>

                    <div class="max-h-96 overflow-y-auto"  x-data="{series:ser,selectSerie:[],
                        filterSeries(event){
                            this.selectSerie=this.series.filter(item=>item.producto===event);
                            console.log(this.series.filter(item=>item.producto===event));
                        }
                    }">
                        <script>
                            const prod = {!! json_encode($productosEntradaSalida) !!};
                            const est = {!! json_encode($estaciones) !!};
                            const tck = {!! json_encode($tck) !!}
                            const ser={!!json_encode($series)!!};
                            //console.log(prod);
                        </script>
                        <template x-for="prod in carrito" :key="prod.id">
                            <div class=" py-3  border-b border-gray-400 relative">
                                <template x-if="prod.id>1">
                                    <button type="button" @click="remove(prod.id)"
                                        class="absolute top-3 right-0 text-white p-2 rounded-md bg-red-600 hover:bg-red-700 transition duration-300">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                                        </svg>
                                    </button>
                                </template>
                                <div class="flex flex-wrap gap-2" x-data="Selects()">
                                    <div>
                                        <select :name="`s${prod.id}`" :id="`s${prod.id}`" x-model="prod.estacion" @change="filterTCK(event)"
                                            class="border-gray-300 max-w-[185px] focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                            <option value="" hidden selected>Seleccione estación</option>
                                            <option value="NULL">Sin estación</option>
                                            <template x-for="estacion in estaciones" :key="estacion.id">
                                                <option :value="estacion.id" x-text="estacion.name"></option>
                                            </template>
                                        </select>
                                    </div>
                                    <div>
                                        <select :name="`t${prod.id}`" :id="`t${prod.id}`" x-model="prod.tck"
                                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                            <option value="NULL">Sin ticket</option>
                                            <option value="" hidden selected>Seleccione ticket</option>
                                            <template x-for="tck in tickets" :key="tck.id">
                                                <option :value="tck.id" x-text="'Ticket #'+tck.id"></option>
                                            </template>
                                        </select>
                                    </div>
                                    <div x-data="selectConfigs()" class="borderflex flex-col items-center relative">
                                        <div class="h-full">
                                            <div @click.away="close()"
                                                class="h-full border border-gray-300 flex focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1">
                                                <input placeholder="Seleccionar producto" x-model="filter"
                                                    x-transition:leave="transition ease-in duration-100"
                                                    x-transition:leave-start="opacity-100"
                                                    x-transition:leave-end="opacity-0" @mousedown="open()"
                                                    @keydown.enter.stop.prevent="selectOption()"
                                                    class=" border-0 p-1 px-2 rounded-md appearance-none outline-none w-full  dark:bg-dark-eval-1">
                                                <div class="w-8 flex justify-center items-center">
                                                    <button @click="toggle()"
                                                        class="w-full h-full cursor-pointer text-gray-600 outline-none focus:outline-none">
                                                        <div class="w-full h-full flex justify-center items-center transform transition duration-300"
                                                            :class="{ '-rotate-180': show }">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-chevron-down w-5 h-5"
                                                                viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                </path>
                                                                <path d="M6 9l6 6l6 -6"></path>
                                                            </svg>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div x-show="isOpen()"
                                            class="border absolute shadow bg-white top-full max-w-xs z-40 lef-0 rounded max-h-select overflow-y-auto dark:bg-dark-eval-1 dark:border-gray-400">
                                            <div class="flex flex-col max-h-40 overflow-y-scroll">
                                                <template x-for="(option, index) in filteredOptions()"
                                                    :key="index">
                                                    <div @click="onOptionClick(index,prod.id)"
                                                        :class="classOption(option.id, index)"
                                                        :aria-selected="focusedOptionIndex === index">
                                                        <div
                                                            class="flex w-full items-center p-2 pl-2 border-transparent  relative">
                                                            <div class="w-full items-center flex">
                                                                <div class="mx-2 -mt-1"><span
                                                                        x-text="option.name"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-wrap gap-2 my-2">
                                    <div>
                                        <div class="relative">
                                            <input type="number" name="base" x-model="prod.cantsol"
                                                :id="`base${prod.id}`" required autofocus autocomplete="base"
                                                value="0" min="0" placeholder=" "
                                                class="peer w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                            <label :for="`base${prod.id}`"
                                                class="absolute rounded-md duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-dark-eval-1 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                                {{ __('Cantidad') }}</label>
                                        </div>
                                        <x-input-error for=""></x-input-error>
                                    </div>
                                    <div class="relative" x-show="showSerie" x-cloak>
                                        <input type="text" :name="`serie${prod.id}`" :id="`serie${prod.id}`"
                                            x-model="prod.serie" placeholder=" "
                                            class="peer w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                        <label :for="`serie${prod.id}`"
                                            class="absolute rounded-md duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-dark-eval-1 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">
                                            {{ __('Serie') }}</label>
                                    </div>
                                    <div class="relative" x-show="showSerie2" x-cloak>
                                        <select :name="`serie${prod.id}`" :id="`serie${prod.id}`" x-model="prod.serie"
                                        class="w-full border-gray-300 max-w-[185px] focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                                        <option value="" hidden selected>Seleccione serie</option>
                                        <template x-for="serie in selectSerie" :key="serie.id">
                                            <option :value="serie.serie" x-text="serie.serie"></option>
                                        </template>
                                    </select>
                                    </div>
                                    <div>
                                        {{-- <div class="w-full relative mt-2">
                                            <textarea
                                                class="w-full h-24 resize-none border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1"
                                                :name="`area${prod.id}`" :id="`area${prod.id}`" cols="30" rows="10" x-model="prod.observacion"></textarea>
                                            <label :for="`base${prod.id}`"
                                                class="absolute rounded-md duration-300 transform  z-10 origin-[0] bg-white dark:bg-dark-eval-1 px-2 text-blue-600 dark:text-blue-500  top-2 scale-75 -translate-y-4 left-1">
                                                {{ __('Observación') }}</label>
                                        </div> --}}
                                        <div class="w-full">
                                            <select x-model="prod.observacion"
                                            class="w-full border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700"
                                            :name="`area${prod.id}`" :id="`area${prod.id}`">
                                                <option value="" hidden>Estado del producto</option>
                                                <option value="Nuevo">Nuevo</option>
                                                <option value="Usado">Usado</option>
                                                <option value="Reparado">Reparado</option>
                                                <option value="Dañado">Dañado</option>
                                                <option value="Retorno">Retornado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </template>
                        <div class="py-2 flex justify-end">
                            <button @click="addChild()"
                                class="rounded-md text-white bg-green-700 hover:bg-green-800 transition duration-300 p-2 flex gap-2 justify-center items-center">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor">
                                    <path
                                        d="M13 15.6c.3.2.7.2 1 0l5-2.9v.3c.7 0 1.4.1 2 .4v-1.8l1-.6c.5-.3.6-.9.4-1.4l-1.5-2.5c-.1-.2-.2-.4-.4-.5l-7.9-4.4c-.2-.1-.4-.2-.6-.2s-.4.1-.6.2L3.6 6.6c-.2.1-.4.2-.5.4L1.6 9.6c-.3.5-.1 1.1.4 1.4c.3.2.7.2 1 0v5.5c0 .4.2.7.5.9l7.9 4.4c.2.1.4.2.6.2s.4-.1.6-.2l.9-.5c-.3-.6-.4-1.3-.5-2m-2 0l-6-3.4V9.2l6 3.4v6.7m9.1-9.6l-6.3 3.6l-.6-1l6.3-3.6l.6 1M12 10.8V4.2l6 3.3l-6 3.3m8 4.2v3h3v2h-3v3h-2v-3h-3v-2h3v-3h2Z" />
                                </svg>
                                <span>Añadir más</span>
                            </button>
                        </div>
                    </div>
                    <div>
                        {{-- <x-input-error for="carrito"></x-input-error> --}}
                        <x-input-error for="carrito.*.*"></x-input-error>
                        {{-- <x-input-error for="carrito.*.estacion"></x-input-error>
                        <x-input-error for="carrito.*.cantsol"></x-input-error>
                        <x-input-error for="carrito.*.observacion"></x-input-error> --}}
                    </div>
                    <div name="footer" class="flex flex-wrap gap-2 justify-center mt-1">
                        <x-danger-button class="mr-2" @click="send()" wire:loading.attr="disabled">
                            <div role="status" wire:loading wire:target="operacion">
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
                            Generar
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
