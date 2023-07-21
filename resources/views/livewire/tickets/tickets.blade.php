<div class="p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
    <div class="ml-2 flex gap-2 flex-col">
        <form action="{{ route('tickets') }}" method="GET" class="flex gap-2 items-end">
            <div class="flex gap-1 flex-col">
                <x-label value="{{ __('Filtro') }}" for="status" />
                <select name="status" id="status" class="text-sm rounded-md dark:bg-dark-eval-0 dark:text-white">
                    <option hidden value="" selected>Todos</option>
                    <option value="Abierto">Abierto</option>
                    <option value="En proceso">En proceso</option>
                    <option value="Cerrado">Cerrado</option>
                </select>
            </div>
            <div class="flex gap-1 flex-col">
                <x-label value="{{ __('Fecha inicial') }}" for="fechaIn" />
                <input type="date" name="start" id="fechaIn"
                    class="text-sm rounded-md dark:bg-dark-eval-0 dark:text-white" />
            </div>
            <div class="flex gap-1 flex-col">
                <x-label value="{{ __('Fecha final') }}" for="sfechaEnd" />
                <input type="date" name="end" id="fechaEnd"
                    class="text-sm rounded-md dark:bg-dark-eval-0 dark:text-white" />
            </div>
            <button type="submit"
                class="bg-gray-300 p-1 w-8 h-8 flex justify-center items-center rounded dark:bg-dark-eval-3 dark:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" fill="currentColor">
                    <path
                        d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                </svg>
            </button>
            <div class="flex gap-1 flex-col ml-52">
                <form action="{{ route('tickets') }}" method="GET">
                    <label for="search" class="sr-only">
                        Search
                    </label>
                    <input type="search" name="tck"
                        class="block w-full p-3 pl-10 text-sm rounded-md  dark:bg-dark-eval-0 dark:text-white"
                        placeholder="Buscar Ticket..." />
                </form>
            </div>
        </form>

    </div>
    <div class="flex flex-wrap gap-2 justify-evenly ">
        @foreach ($tickets as $tck)
            <div @if ($tck->status == 'Abierto') class="shadow-lg group container border  border-green-500 rounded-md bg-white  w-[200px]  flex justify-center items-center  mx-left content-div" @endif
                @if ($tck->status == 'En proceso') class="shadow-lg group container border  border-yellow-500 rounded-md bg-white  w-[200px]  flex justify-center items-center  mx-left content-div" @endif
                @if ($tck->status == 'Cerrado') class="shadow-lg group container border  border-gray-500 rounded-md bg-white  w-[200px]  flex justify-center items-center  mx-left content-div" @endif
                wire:key="ticket-{{ $tck->id }}" x-data="{ closed: false }" x-show="!closed">
                <div>
                    <div class="w-full image-cover rounded-t-md ">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div class="text-black">#{{ $tck->id }}</div>
                            <div @if ($tck->status == 'Abierto') class=" p-2 m-2 w-18 h-18 text-center bg-green-500 dark:bg-dark-eval-3 rounded-full  text-white float-right fd-cl group-hover:opacity-25" @endif
                                @if ($tck->status == 'En proceso') class="p-2 m-2 w-18 h-18 text-center bg-yellow-500 dark:bg-dark-eval-3 rounded-full  text-white float-right fd-cl group-hover:opacity-25" @endif
                                @if ($tck->status == 'Cerrado') class="p-2 m-2 w-18 h-18 text-center bg-gray-500 dark:bg-dark-eval-3 rounded-full  text-white float-right fd-cl group-hover:opacity-25" @endif>
                                <span class="text-xs tracking-wide  font-bold font-sans"> {{ $tck->status }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="py-6 px-2 bg-white dark:bg-dark-eval-2 rounded-md fd-cl group-hover:opacity-25">
                        <span
                            class="block text-lg text-gray-800 dark:text-white font-bold tracking-wide text-center">{{ $tck->falla->name }}</span>
                        <span class="sr-only">Falla del ticket</span>
                        <span class="block text-gray-600 text-sm">

                            <div class="text-center text-black"> {{-- Quien solicita el ticket --}}
                                <p class="bg-blue-200 rounded-md p-1"> {{ $tck->cliente->name }}</p>
                            </div>

                            @if (Auth::user()->permiso_id == 1)
                                <div class="text-center text-black dark:text-white font-bold"> {{-- Agente asignado para solucionar el ticket --}}
                                    {{-- <p>Agente asignado:</p> --}}
                                    {{ $tck->agente->name }}
                                </div>
                            @endif

                            <div class="text-center">
                                <p class="text-black dark:text-white">Vencimiento:</p> {{-- Fecha de vencimiento del ticket --}}
                                <p class="bg-gray-300 rounded-md p-1">{{ $tck->fecha_cierre }}</p>
                            </div>
                            @if ($tck->status == 'Cerrado' && $tck->cerrado != null)
                                <div class="text-center">
                                    <p class="text-black dark:text-white">Cerrado:</p> {{-- Fecha de cierre del ticket --}}
                                    <p class="bg-gray-300 rounded-md p-1">{{ $tck->cerrado }}</p>
                                </div>
                            @endif
                        </span>
                    </div>
                </div>
                <div class="absolute opacity-0 fd-sh group-hover:opacity-100">
                    <div class="pt6 text-center">
                        <span
                            @if ($tck->falla->prioridad->name == 'Bajo') class="bg-green-400 text-white p-1 rounded w-auto" @endif
                            @if ($tck->falla->prioridad->name == 'Medio') class="bg-yellow-400 text-white p-1 rounded w-auto" @endif
                            @if ($tck->falla->prioridad->name == 'Alto') class="bg-orange-400 text-white p-1 rounded w-auto" @endif
                            @if ($tck->falla->prioridad->name == 'Crítico') class="bg-red-400 text-white p-1 rounded w-auto" @endif
                            @if ($tck->falla->prioridad->name == 'Alto Crítico') class="bg-red-700 text-white p-1 rounded w-auto" @endif>
                            {{ $tck->falla->prioridad->name }}
                        </span>

                    </div>
                    <div class="flex gap-1 pt-8 text-center">
                        {{-- @livewire('tickets.edit-ticket', ['ticketID' => $tck->id]) --}}
                        {{-- @livewire('tickets.show-ticket', ['ticketID' => $tck->id]) --}}
                        {{-- @livewire('tickets.comentarios', ['ticketID' => $tck->id]) --}}

                        @if ($tck->status != 'Cerrado')
                            {{-- Ver y comentarios --}}
                            <a class="bg-white dark:bg-dark-eval-3 p-1 rounded-md tooltip"
                                href="{{ route('tck.ver', $tck->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                    fill="currentColor" class="w-6 h-6 text-black hover:text-purple-600 dark:text-white"
                                    viewBox="0 0 576 512">
                                    <path
                                        d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                                </svg>
                                <span class="tooltiptext">Ver Más</span>
                            </a>
                            {{-- Tareas --}}
                            <a class="bg-white dark:bg-dark-eval-3 p-1 rounded-md tooltip"
                                href="{{ route('tck.tarea', $tck->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6 text-black hover:text-cyan-600 dark:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                </svg>
                                <span class="tooltiptext">Tareas</span>
                            </a>
                            {{-- Editar Ticket --}}
                            @if (Auth::user()->permiso_id == 1)
                                <a class="bg-white dark:bg-dark-eval-3 p-1 rounded-md tooltip"
                                    href="{{ route('tck.editar', $tck->id) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-6 h-6 text-black hover:text-blue-600 dark:text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    <span class="tooltiptext">Editar</span>
                                </a>
                                @livewire('tickets.reasignar', ['ticketID' => $tck->id])
                            @endif
                            {{-- Requisiciones --}}
                            @livewire('tickets.compras.show-compras', ['ticketID' => $tck->id])

                            {{-- Abrir Ticket Rapido - Solo Administradores --}}
                            @if (Auth::user()->permiso_id == 1 && $tck->status == 'Cerrado')
                                @livewire('tickets.unlock-ticket', ['ticketID' => $tck->id])
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            <style>
                .content-div {
                    background-image: url('storage/product-photos/ticket.png');
                    background-repeat: no-repeat;
                    background-size: 198px;
                    background-position: center;
                }

                .content-div:hover {
                    background-image:
                        linear-gradient(to right,
                            rgba(73, 72, 72, 0.658), hsla(0, 1%, 48%, 0.712)),
                        url('storage/product-photos/ticket.png');
                }

                .image-cover {
                    height: 260px;
                }

                .content-div:hover .fd-cl {
                    opacity: 0.25;
                }

                .content-div:hover .fd-sh {
                    opacity: 1;
                }
            </style>
        @endforeach
    </div>

    @if (count($tickets) > 0)
        {{ $tickets->links() }}
    @else
        <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
            <img src="{{ asset('img/logo/emptystate.svg') }}" style="width: 5000px" alt="Buzón Vacío">
            <span class="">No hay tickets registrados.</span>
        </div>
    @endif
</div>
