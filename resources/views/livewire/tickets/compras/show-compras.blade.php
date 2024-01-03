<div x-data="{ modelOpen: false }">
    <button @click="modelOpen =!modelOpen" wire:loading.attr="disabled" aria-label="reasignar-usuario" class="tooltip ">
         @if($comprasCount)
         <div class="relative">
            <svg class="w-6 h-6" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                <circle cx="13.33" cy="29.75" r="2.25" fill="currentColor" class="clr-i-outline clr-i-outline-path-1"/>
                <circle cx="27" cy="29.75" r="2.25" fill="currentColor" class="clr-i-outline clr-i-outline-path-2"/>
                <path fill="currentColor" d="M33.08 5.37a1 1 0 0 0-.77-.37H11.49l.65 2H31l-2.67 12h-15L8.76 4.53a1 1 0 0 0-.66-.65L4 2.62a1 1 0 1 0-.59 1.92L7 5.64l4.59 14.5l-1.64 1.34l-.13.13A2.66 2.66 0 0 0 9.74 25A2.75 2.75 0 0 0 12 26h16.69a1 1 0 0 0 0-2H11.84a.67.67 0 0 1-.56-1l2.41-2h15.44a1 1 0 0 0 1-.78l3.17-14a1 1 0 0 0-.22-.85" class="clr-i-outline clr-i-outline-path-3"/>
                <path fill="none" d="M0 0h36v36H0z"/>
            </svg>
             <span class="absolute top-0 right-0 bg-red-500 text-white p-1 rounded-full"> </span>
         </div>
         @else
         <svg class="w-6 h-6" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
            <circle cx="13.33" cy="29.75" r="2.25" fill="currentColor" class="clr-i-outline clr-i-outline-path-1"/>
            <circle cx="27" cy="29.75" r="2.25" fill="currentColor" class="clr-i-outline clr-i-outline-path-2"/>
            <path fill="currentColor" d="M33.08 5.37a1 1 0 0 0-.77-.37H11.49l.65 2H31l-2.67 12h-15L8.76 4.53a1 1 0 0 0-.66-.65L4 2.62a1 1 0 1 0-.59 1.92L7 5.64l4.59 14.5l-1.64 1.34l-.13.13A2.66 2.66 0 0 0 9.74 25A2.75 2.75 0 0 0 12 26h16.69a1 1 0 0 0 0-2H11.84a.67.67 0 0 1-.56-1l2.41-2h15.44a1 1 0 0 0 1-.78l3.17-14a1 1 0 0 0-.22-.85" class="clr-i-outline clr-i-outline-path-3"/>
            <path fill="none" d="M0 0h36v36H0z"/>
        </svg>
         @endif
         <span class="tooltiptext">Requisiciones</span>
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
                class="inline-block w-full max-w-xl p-6 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl dark:bg-dark-eval-1">      
                <div class="flex items-center justify-between space-x-4 mb-2">
                    <h1 class="text-xl font-medium">{{ __('Requisiciones') }}</h1>
                    <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg"fill="currentColor" class="w-6 h-6 text-gray-400 hover:text-orange-800 transition duration-300" viewBox="0 0 320 512" >
                            <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/>
                        </svg>
                    </button>
                </div>
                <div>
                    <div class="">
                        <div class="flex justify-end">
                            <a href="{{route('tck.compra',$ticketID)}}" class="px-3 py-2 rounded-md bg-green-700 text-white hover:bg-green-800 transition duration-300">
                                Nueva requisición
                            </a>
                        </div>
                        @if ($compras->count() > 0)
                        <div class="max-h-[15rem] overflow-auto mt-2 flex flex-col gap-2">
                            @foreach ($compras as $compra)
                                <div class='w-full rounded-lg border dark:border-gray-700 flex items-center justify-center' x-data="{ open: false }">
                                    <div class='w-full '>
                                        <div @click="open = !open" class='relative flex items-center w-full overflow-auto mx-auto cursor-pointer bg-gray-100 dark:bg-slate-700 dark:text-gray-300 rounded-md'>
                                            <div class=' px-2 transform transition duration-300 ease-in-out' :class="{'rotate-90': open,'text-blue-500':open }">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 512 512">
                                                    <path d="M0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM241 377c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l87-87-87-87c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0L345 239c9.4 9.4 9.4 24.6 0 33.9L241 377z"/>
                                                </svg>        
                                            </div>
                                            <div class='flex items-center px-1 py-2'>
                                                Requisición # {{$compra->id}}
                                            </div>
                                            <button type="button" wire:click='deleteCompra({{$compra->id}})' class="absolute top-1 right-1" data-confirm="seguro">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 icon icon-tabler icon-tabler-trash-filled"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16z" stroke-width="0" fill="currentColor"></path>
                                                    <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor"></path>
                                                 </svg>
                                            </button>
                                        </div>
                                        <div class="w-full transform transition duration-300 ease-in-out"
                                        x-cloak x-show="open" x-collapse x-collapse.duration.500ms >
                                            <div>
                                                <div class="my-2 flex justify-center">
                                                    <a href="{{asset('storage/'.$compra->documento)}}" target="_blank" class="px-2 py-1 rounded-md flex items-center gap-1 bg-red-700 text-white hover:bg-red-800 transition duration-300">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 384 512">
                                                            <path d="M64 464c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16H224v80c0 17.7 14.3 32 32 32h80V448c0 8.8-7.2 16-16 16H64zM64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V154.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0H64zm56 256c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120z"/>
                                                        </svg>
                                                        Ver archivo PDF
                                                    </a>
                                                </div>
                                                <table class="w-full">
                                                    <thead>
                                                        <tr>
                                                            @if ($compra->productos->count()>0)
                                                                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                                                    Imagen
                                                                </th>
                                                            @endif
                                                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                                                    {{$compra->productos->count()>0?"Producto":"Servicio"}}
                                                            </th>
                                                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                                                Cantidad
                                                            </th>
                                                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                                                Prioridad
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($compra->productos->count() > 0)
                                                            @foreach ($compra->productos as $producto)
                                                                <tr>
                                                                    <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                                                        <div class="flex justify-center items-center">
                                                                            <figure class="w-[4rem] h-[4rem] overflow-hidden rounded-full flex justify-center items-center">
                                                                                <img src="{{ asset('storage/' . $producto->producto->product_photo_path) }}" alt="" class="w-full">
                                                                            </figure>
                                                                        </div>
                                                                    </th>
                                                                    <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                                                        <div>
                                                                            {{$producto->producto->name}}
                                                                        </div>
                                                                    </th>
                                                                    <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                                                        {{$producto->cantidad}}
                                                                    </th>
                                                                    <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                                                        <div>
                                                                            {{$producto->producto->prioridad}}
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            @foreach ($compra->servicios as $servicio)
                                                                <tr>
                                                                    <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                                                        <div>
                                                                            {{$servicio->servicio->name}}
                                                                        </div>
                                                                    </th>
                                                                    <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                                                        {{$servicio->cantidad}}
                                                                    </th>
                                                                    <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                                                        <div>
                                                                            {{$servicio->servicio->prioridad}}
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @else
                        <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg"  fill="currentColor" class="max-w-[120px] bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                            <span class="text-xl">No se encontraron requisiciones asociadas</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>