<div class="p-6 flex flex-col gap-6 bg-white rounded-md shadow-md dark:bg-dark-eval-1">
    <div class="ml-2 flex gap-2 flex-col relative">
        <div class="text-right">
			 <button type="button"  onclick="window.location.href = '{{ route('export.excel') }}'" class=" text-gray-400 border rounded-md p-1.5 w-fit transition duration-300 hover:bg-gray-400 hover:text-white dark:bg-dark-eval-0 dark:border-dark-eval-0 dark:hover:bg-dark-eval-2 dark:hover:border-gray-500">
                <svg width="24" height="24" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#20744a" fill-rule="evenodd" d="M28.781 4.405h-10.13V2.018L2 4.588v22.527l16.651 2.868v-3.538h10.13A1.162 1.162 0 0 0 30 25.349V5.5a1.162 1.162 0 0 0-1.219-1.095Zm.16 21.126H18.617l-.017-1.889h2.487v-2.2h-2.506l-.012-1.3h2.518v-2.2H18.55l-.012-1.3h2.549v-2.2H18.53v-1.3h2.557v-2.2H18.53v-1.3h2.557v-2.2H18.53v-2h10.411Z"/>
                    <path fill="#20744a" d="M22.487 7.439h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323z"/>
                    <path fill="#fff" fill-rule="evenodd" d="m6.347 10.673l2.146-.123l1.349 3.709l1.594-3.862l2.146-.123l-2.606 5.266l2.606 5.279l-2.269-.153l-1.532-4.024l-1.533 3.871l-2.085-.184l2.422-4.663l-2.238-4.993z"/>
                </svg>
            </button>
            <button type="button" aria-label="btn-orden"
                class=" text-gray-400 border rounded-md p-1.5 w-fit transition duration-300 hover:bg-gray-400 hover:text-white dark:bg-dark-eval-0 dark:border-dark-eval-0 dark:hover:bg-dark-eval-2 dark:hover:border-gray-500"
                wire:click="changeOrden">
                @if ($orden == 'desc')
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sort-ascending w-5 h-5"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 6l7 0"></path>
                        <path d="M4 12l7 0"></path>
                        <path d="M4 18l9 0"></path>
                        <path d="M15 9l3 -3l3 3"></path>
                        <path d="M18 6l0 12"></path>
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sort-descending w-5 h-5"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 6l9 0"></path>
                        <path d="M4 12l7 0"></path>
                        <path d="M4 18l7 0"></path>
                        <path d="M15 15l3 3l3 -3"></path>
                        <path d="M18 6l0 12"></path>
                    </svg>
                @endif
            </button>
            <button type="button" aria-label="btn-view"
                class=" text-gray-400 border rounded-md p-1.5 w-fit transition duration-300 hover:bg-gray-400 hover:text-white dark:bg-dark-eval-0 dark:border-dark-eval-0 dark:hover:bg-dark-eval-2 dark:hover:border-gray-500"
                wire:click="changeView">
                @if (session('view_tck'))
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-grid w-5 h-5"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                        <path d="M14 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                        <path d="M4 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                        <path d="M14 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-list w-5 h-5"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"></path>
                        <path d="M4 14m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z">
                        </path>
                    </svg>
                @endif
            </button>
        </div>
        <form action="{{ route('tickets') }}" method="GET" class="flex flex-wrap gap-2 items-end">
            <div class="flex gap-1 flex-col">
                <x-label value="{{ __('Filtro') }}" for="status" />
                <select name="status" id="filtro-status"
                    class="text-sm border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                    <option hidden value="All" selected>Todos</option>
                    <option value="Abierto">Abierto</option>
                    <option value="En proceso">En proceso</option>
                    <option value="Cerrado">Cerrado</option>
                </select>
            </div>
            @if (!in_array(Auth::user()->permiso_id, [2, 3]))
                <div>
                    <x-label value="{{ __('Zona') }}" for="zona" />
                    <select name="zona" id="zona"
                        class="text-sm border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                        <option value="" selected>Todas</option>
                        @foreach ($zonas as $zona)
                            <option value="{{ $zona->id }}">{{ $zona->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="flex gap-1 flex-col">
                <x-label value="{{ __('Fecha inicial') }}" for="fechaIn" />
                <input type="date" name="start" id="fechaIn"
                    class="text-sm border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400" />
            </div>
            <div class="flex gap-1 flex-col">
                <x-label value="{{ __('Fecha final') }}" for="fechaEnd" />
                <input type="date" name="end" id="fechaEnd"
                    class="text-sm border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400" />
            </div>
            <button type="submit" aria-label="buscar" id="btn-search"
                class="border p-2 w-8 h-8 flex justify-center items-center rounded dark:border-gray-700 dark:text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" fill="currentColor">
                    <path
                        d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                </svg>
            </button>
        </form>
        <form action="{{ route('tickets') }}" method="GET">
            <label for="search" class="sr-only">
                Search
            </label>
            <input type="search" name="tck"
                class="block w-full p-3 pl-10 text-sm border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
                placeholder="Buscar..." />
        </form>
    </div>

    <div class="flex flex-wrap gap-2 justify-evenly">
        @forelse ($tickets as $tck)
            <div  :class="$wire.c || 'w-full flex  flex-wrap-reverse md:flex-nowrap gap-2 justify-end items-center'"
                @if ($tck->status == 'Abierto') 
                    class=" group/buttons border-2 border-green-500 dark:border-green-700 rounded-md " 
                @endif
                @if ($tck->status == 'En proceso') 
                    class=" group/buttons border-2 border-yellow-500 rounded-md" 
                @endif
                @if ($tck->status == 'Vencido') 
                    class=" group/buttons border-2 border-red-500 rounded-md"
                @else
                    class=" group/buttons border-2 rounded-md" 
                @endif
                >
                <div 
                    :class="$wire.c ? 'flex justify-between gap-1 flex-col pb-3' : 'w-full px-1 grid max-sm:grid-cols-1 max-md:grid-cols-3 md:grid-cols-6 items-center gap-1'">
                    <div class="flex justify-between py-1">
                        <div class=" px-1">
                            #{{ $tck->id }}
                        </div>
                        <div @if ($tck->status == 'Abierto') class="bg-green-500 text-white p-1 " @endif
                            @if ($tck->status == 'En proceso') class="bg-yellow-500 text-white p-1" @endif
                            @if ($tck->status == 'Vencido') class="bg-red-500 text-white p-1" @endif
                            @if ($tck->status == 'Cerrado' || $tck->status == 'Por abrir') class="bg-gray-500 text-white p-1" @endif>
                            {{ $tck->status }}
                        </div>
                    </div>
                    <div class=" text-center font-bold text-xl p-1">
                        <h2>{{ $tck->falla->name }}</h2>
                    </div>
                    <div class="text-center">
                        {{ $tck->cliente->name }}
                    </div>
                    <div class="text-center">
                        {{ $tck->agente->name }}
                    </div>
                    <div class="w-full flex flex-col gap-1 justify-center items-center">
                        @if ($tck->status != 'Cerrado')
                            <div  class="w-fit md:w-full flex justify-center gap-1 items-center border-b">
                                <strong class="text-sm">Creado:</strong>
                                <span class="text-xs">{{ $tck->created_at }}</span>
                            </div>
                            <div  class="w-full flex justify-center gap-1 items-center">
                                <strong class="text-sm">Vence:</strong>
                                <span class="text-xs">{{ $tck->fecha_cierre }}</span>
                            </div>
                        @endif
                        @if ($tck->status == 'Cerrado' && $tck->cerrado != null)
                            <div  class="w-full flex justify-center gap-1 items-center">
                                <strong class="text-sm">Cerrado:</strong>
                                <span class="text-xs">{{ $tck->cerrado }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex justify-center h-fit">
                        <div @if ($tck->falla->prioridad->name == 'Bajo') class="bg-green-400 text-white p-1 rounded w-auto" @endif
                            @if ($tck->falla->prioridad->name == 'Medio') class="bg-yellow-400 text-white p-1 rounded w-auto" @endif
                            @if ($tck->falla->prioridad->name == 'Alto') class="bg-orange-400 text-white p-1 rounded w-auto" @endif
                            @if ($tck->falla->prioridad->name == 'Crítico') class="bg-red-400 text-white p-1 rounded w-auto" @endif
                            @if ($tck->falla->prioridad->name == 'Alto Crítico') class="bg-red-700 text-white p-1 rounded w-auto" @endif
                            :class="$wire.c ? 'w-fit' : 'w-full text-center mx-1'">
                            {{ $tck->falla->prioridad->name }}
                        </div>
                    </div>
                </div>
                <div class="relative" :class="$wire.c ? 'h-8 overflow-hidden' : ''">
                    <div class="flex flex-wrap justify-center items-center px-2"
                        x-data="{menu:false,drop:false,
                            init(){
                                $wire.c
                                ?this.menu=false
                                :this.menu=true;
                                $wire.c
                                ?this.drop=true
                                :this.drop=false;
                            }}"
                        :class="$wire.c 
                            ?'gap-2 min-[720px]:absolute min-[720px]:top-full min-[720px]:group-hover/buttons:top-0 transition-[top] duration-300' 
                            :'relative gap-1 w-fit'">
                            <button class="p-1 text-gray-400 duration-300" :class="menu?'block hover:text-gray-600':'hidden'" @click="drop=!drop">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 " viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                    <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                    <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                 </svg>
                            </button>
                        <div :class="menu
                            ?'flex flex-col w-fit gap-2 absolute border border-gray-200 dark:border-dark-eval-3 shadow-md p-2 right-full 2xl:left-full z-50 bg-white dark:bg-dark-eval-3 rounded-md'
                            :'inline-flex items-center gap-2 text-base font-semibold text-gray-900 dark:text-white'"
                            x-cloak x-collapse x-show="drop">
                            @if ($tck->status != 'Cerrado')
                                @if (Auth::user()->permiso_id == 1)
                                    <a :class="menu?'flex gap-1':'tooltip'"
                                        href="{{ route('tck.editar', $tck->id) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6 text-black hover:text-gray-600 dark:text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                        <span :class="menu?'':'tooltiptext'">Editar</span>
                                    </a>
                                    <div :class="menu && 'flex gap-1'">
                                        @livewire('tickets.reasignar', ['ticketID' => $tck->id], key('reasignar' . $tck->id))
                                        <template x-if="menu">
                                            <span>Reasignar</span>
                                        </template>
                                    </div>
                                @endif
                                <a :class="menu?'flex gap-1':'tooltip'"
                                    href="{{ route('tck.ver', $tck->id) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                        fill="currentColor"
                                        class="w-6 h-6 text-black hover:text-gray-600 dark:text-white"
                                        viewBox="0 0 576 512">
                                        <path
                                            d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                                    </svg>
                                    <span :class="menu?'':'tooltiptext'">Ver Más</span>
                                </a>
                                @if (!in_array(Auth::user()->permiso_id, [2, 3, 6]))
                                    <div :class="menu && 'flex gap-1'">
                                        @livewire('tickets.compras.show-compras', ['ticketID' => $tck->id], key('compra' . $tck->id))
                                        <template x-if="menu">
                                            <span>Requisiciones</span>
                                        </template>
                                    </div>
                                    <a :class="menu?'flex gap-1':'tooltip'"
                                        href="{{ route('tck.tarea', $tck->id) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6 text-black hover:text-gray-600 dark:text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                        </svg>
                                        <span :class="menu?'':'tooltiptext'">Tareas</span>
                                    </a>
                                @endif
                            @else
                                <a :class="menu?'flex gap-1':'tooltip'"
                                    href="{{ route('tck.ver', $tck->id) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                        fill="currentColor"
                                        class="w-6 h-6 text-black hover:text-gray-600 dark:text-white"
                                        viewBox="0 0 576 512">
                                        <path
                                            d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                                    </svg>
                                    <span :class="menu?'':'tooltiptext'">Ver Más</span>
                                </a>
                            @endif
                            @if (Auth::user()->permiso_id == 1 && $tck->status == 'Cerrado')
                            <div :class="menu && 'flex gap-1'">
                                @livewire('tickets.unlock-ticket', ['ticketID' => $tck->id], key('unlock' . $tck->id))
                                <template x-if="menu">
                                    <span>Abrir</span>
                                </template>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="max-w-[200px] bi bi-x-circle"
                    viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
                <span class="text-2xl">No hay datos registrados</span>
            </div>
        @endforelse
    </div>
    {{ $tickets->links() }}
</div>
