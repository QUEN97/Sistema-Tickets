<div class="p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
    <div class="ml-2 flex gap-2 flex-col">
        <form action="{{ route('tck.abierto') }}" method="GET">
            <label for="search" class="sr-only">
                Search
            </label>
            <input type="search" name="tck"
                class="block w-full p-3 pl-10 text-sm border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
                placeholder="Buscar..." />
        </form>
    </div>
    <div class="flex flex-wrap gap-2 justify-evenly ">
        @foreach ($tickets as $tck)
            <div @if ($tck->status == 'Abierto') class="shadow-lg group container border  border-green-500 rounded-md bg-white  w-[200px]  flex justify-center items-center  mx-left content-div" @endif
                @if ($tck->status == 'En proceso') class="shadow-lg group container border  border-yellow-500 rounded-md bg-white  w-[200px]  flex justify-center items-center  mx-left content-div" @endif
                @if ($tck->status == 'Cerrado' || $tck->status == 'Por abrir') class="shadow-lg group container border  border-gray-500 rounded-md bg-white  w-[200px]  flex justify-center items-center  mx-left content-div" @endif
                wire:key="ticket-{{ $tck->id }}" x-data="{ closed: false }" x-show="!closed">
                <div>
                    <div class="w-full image-cover rounded-t-md ">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div class="text-black">#{{ $tck->id }}</div>
                            <div @if ($tck->status == 'Abierto') class=" p-2 m-2 w-18 h-18 text-center bg-green-500 dark:bg-dark-eval-3 rounded-full  text-white float-right fd-cl group-hover:opacity-25" @endif
                                @if ($tck->status == 'En proceso') class="p-2 m-2 w-18 h-18 text-center bg-yellow-500 dark:bg-dark-eval-3 rounded-full  text-white float-right fd-cl group-hover:opacity-25" @endif
                                @if ($tck->status == 'Cerrado' || $tck->status == 'Por abrir') class="p-2 m-2 w-18 h-18 text-center bg-gray-500 dark:bg-dark-eval-3 rounded-full  text-white float-right fd-cl group-hover:opacity-25" @endif>
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
                                <div class="text-center text-black dark:text-white font-bold">
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

                        {{-- Abrir Ticket Rapido - Solo Administradores --}}
                        @if (Auth::user()->permiso_id == 1 )
                            @livewire('tickets.unlock-ticket', ['ticketID' => $tck->id])
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
    
    @if (count($tickets) >0)
            
        {{$tickets->links()}}
    @else
        <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg"  fill="currentColor" class="max-w-[200px] bi bi-x-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
            </svg>
            <span class="text-2xl">No hay datos registrados</span>
        </div>
    @endif 
</div>
