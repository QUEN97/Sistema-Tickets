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
    <div class="flex flex-wrap gap-2 justify-evenly">
        
        
        @foreach ($tickets as $tck)

        <div 
        @if ($tck->status=="Abierto")
            class=" group/buttons border-2 border-green-500 dark:border-green-700 rounded-md flex flex-col justify-between gap-1 w-[200px] pb-3 "
        @endif
        @if ($tck->status=="En proceso")
            class=" group/buttons border-2 border-amber-600 rounded-md flex flex-col justify-between gap-1 w-[200px] pb-3 "
        @else
            class=" group/buttons border-2 rounded-md flex flex-col justify-between gap-1 w-[200px] pb-3 "
        @endif
       >
            <div class="flex justify-between py-1">
                <div class=" px-1">
                    #{{$tck->id}}
                </div>
                <div 
                @if ($tck->status=="Abierto")
                    class="bg-green-500 text-white p-1 dark:bg-green-700"
                @endif
                @if ($tck->status=="En proceso")
                    class="bg-amber-600 text-white p-1"
                @endif
                @if ($tck->status=="Cerrado" || $tck->status=="Por abrir")
                    class="bg-gray-400 text-white p-1"
                @endif
                >
                    {{$tck->status}}
                </div>
            </div>
            <div class=" text-center font-bold text-2xl">
                <h2>{{$tck->falla->name}}</h2>
            </div>
            <div class="text-center">
                {{$tck->cliente->name}}
            </div>
            @if (Auth::user()->permiso_id==1)
                <div class="text-center">
                    <p>Agente asignado:</p>
                    {{$tck->agente->name}}
                </div>
            @endif
            <div class="text-center mb-1">
                
                <span 
                @if ($tck->falla->prioridad->name=="Bajo")
                    class="bg-green-500 text-white p-1 rounded w-auto dark:bg-green-700"
                @endif
                @if ($tck->falla->prioridad->name=="Medio")
                    class="bg-blue-700 text-white p-1 rounded w-auto"
                @endif
                @if ($tck->falla->prioridad->name=="Alto")
                    class="bg-amber-600 text-white p-1 rounded w-auto"
                @endif
                @if ($tck->falla->prioridad->name=="Crítico")
                    class="bg-purple-700 text-white p-1 rounded w-auto"
                @endif
                @if ($tck->falla->prioridad->name=="Alto Crítico")
                    class="bg-red-700 text-white p-1 rounded w-auto"
                @endif>
                
                    {{$tck->falla->prioridad->name}}
                </span>
                
            </div>
            <div class=" h-8 relative overflow-hidden">
                <div class="flex flex-wrap gap-2 px-2 justify-center items-center min-[720px]:absolute min-[720px]:top-full min-[720px]:group-hover/buttons:top-0 transition-[top] duration-300">
                    @if ($tck->status!='Cerrado')    
                        @if (Auth::user()->permiso_id==1)  
                            @livewire('tickets.edit-ticket',['ticketID'=>$tck->id])
                        {{-- @else
                            @livewire('tickets.show-ticket',['ticketID'=>$tck->id]) --}}
                        @endif
                    @endif
                        @livewire('tickets.unlock-ticket',['ticketID'=>$tck->id])
                        @livewire('tickets.reasignar',['ticketID'=>$tck->id])
                </div>
            </div>
            
        </div>
        
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
