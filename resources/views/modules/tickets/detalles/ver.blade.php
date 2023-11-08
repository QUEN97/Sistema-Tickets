<x-app-layout>
    @section('title', 'Ver Ticket')

    <div class="flex flex-col items-center sm:flex-row gap-2">
        <div class="bg-white dark:bg-dark-eval-1 text-gray-800 p-4 rounded-md shadow-lg mb-4 sm:mb-0">
            <ul class="list-style:none">
                <li class="mb-2"><strong class="dark:text-white">Ticket: </strong>
                    <span class="dark:text-white">#{{ $ticketID }}</span>
                </li>
                <li class="mb-2"><strong class="dark:text-white">Estado:</strong>
                    @if ($tck->status == 'Abierto')
                        <span class="bg-green-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @elseif ($tck->status == 'En proceso')
                        <span class="bg-orange-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @elseif ($tck->status == 'Vencido')
                        <span class="bg-red-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @elseif ($tck->status == 'Cerrado')
                        <span class="bg-gray-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @endif
                </li>
                <li class="mb-2"><strong class="dark:text-white">Cliente:</strong>
                    <div class="dark:text-white">
                        {{ $tck->cliente->name }}</div>
                </li>
                <li class="mb-2"><strong class="dark:text-white">Creado:</strong>
                    <div class="dark:text-white">
                        {{ $tck->created_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}</div>
                </li>
                <li class="mb-2"><strong class="dark:text-white">Vencimiento:</strong>
                    <div class="bg-gray-400 p-1 rounded-md text-white">
                        {{ \Carbon\Carbon::parse($tck->fecha_cierre)->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}
                    </div>
                </li>
                @if ($tck->status == 'Cerrado' && $tck->cerrado != null)
                    <li class="mb-2"><strong class="dark:text-white">Cerrado:</strong>
                        <div class="bg-gray-400 p-1 rounded-md text-white">
                            {{ \Carbon\Carbon::parse($tck->cerrado)->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}
                        </div>
                    </li>
                @endif
            </ul>
            {{-- Botones acción --}}
            @if (Auth::user()->permiso_id == 1 || Auth::user()->permiso_id == 7 || Auth::user()->permiso_id == 4 || Auth::user()->permiso_id == 5)
                <div class="bg-dark-eval-1 dark:bg-dark-eval-2 p-2 rounded-md text-white text-center">
                    {{ __('Ir a:') }}
                </div>
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-center mt-5">
                    <div class="flex justify-center rounded-lg" role="group">
                        @if (Auth::user()->permiso_id == 1)
                            <a class="tooltip"
                                href="{{ route('tck.editar', $tck->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6 text-black hover:text-indigo-600 dark:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                                <span class="tooltiptext">Editar</span>
                            </a>
                            @livewire('tickets.reasignar', ['ticketID' => $tck->id])
                        @endif
                        <a class="tooltip"
                            href="{{ route('tck.tarea', $tck->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6 text-black hover:text-indigo-600 dark:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                            <span class="tooltiptext">Tareas</span>
                        </a>
                        @livewire('tickets.compras.show-compras', ['ticketID' => $tck->id])

                        @if (Auth::user()->permiso_id == 1 && $tck->status == 'Cerrado')
                            @livewire('tickets.unlock-ticket', ['ticketID' => $tck->id])
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="ml-0 sm:ml-16">
            @livewire('tickets.show-ticket', ['ticketID' => $ticketID])
        </div>
    </div>

    <div class="mt-4 bg-white dark:bg-dark-eval-1 text-gray-800 p-4 rounded-md shadow-lg">
        <div class="bg-dark-eval-1 p-1 rounded-md text-white text-center mb-2">
            {{ __('Comentarios del ticket:') }}
        </div>
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-3">
            <span
                class="inline-flex items-center p-1 text-sm font-medium text-center text-white bg-gray-400 rounded-lg">
                Comentarios
                <span
                    class="inline-flex items-center justify-center w-4 h-4 ml-2 text-xs font-semibold text-black bg-white rounded-full">
                    {{ $comentarios->count() }}
                </span>
            </span>
            <div>
                @if ($tck->status != 'Cerrado')
                    @if (!(Auth::id() == $ticketOwner && $tck->status == 'Abierto'))
                        @livewire('tickets.comentarios', ['ticketID' => $tck->id])
                    @endif
                @endif
            </div>
        </div>
        @if ($comentarios->count() > 0)
            <ul class="flex flex-col  max-h-[320px] overflow-y-auto">
                @foreach ($comentarios as $comentario)
                    <li>
                        <a
                            class="flex  px-3 py-2 text-sm transition duration-150 ease-in-out border-b border-gray-300 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none">
                            @if ($comentario->usuario->profile_photo_path)
                                <div onclick="window.location.href='{{ asset('/storage/' . $comentario->usuario->profile_photo_path) }}'">
                                    <img class="h-10 w-10 rounded-full object-cover"
                                    src="/storage/{{ $comentario->usuario->profile_photo_path }}"
                                    alt="{{ $comentario->usuario->name }}" />
                                </div>
                            @else
                            <div onclick="window.location.href='{{ asset($comentario->usuario->profile_photo_url) }}'">
                                <img class="object-cover w-10 h-10 rounded-full"
                                src="{{ $comentario->usuario->profile_photo_url }}" alt="{{ $comentario->usuario->name }}" />
                            </div>
                            @endif
                            <div class="w-full pb-2">
                                <div class="flex justify-between">
                                    <div class="flex">
                                        <span
                                            class="block ml-2 font-semibold text-gray-600 dark:text-white">{{ $comentario->usuario->name }}</span>
                                        <span
                                            class="block ml-2 bg-gray-400 p-1 rounded-md text-bold text-white text-xs">{{ $comentario->statustck }}</span>

                                    </div>
                                    <span
                                        class="block ml-2 text-xs text-gray-600 dark:text-white">{{ $comentario->created_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}</span>
                                </div>
                                <div class="flex items-center"> <!-- Agregado el contenedor flex -->
                                    <span
                                        class="block ml-2 text-sm text-gray-600 dark:text-white">{{ $comentario->comentario }}</span>
                                    @if ($comentario->archivos->count() > 0)
                                        <div class="flex items-center ml-2"> <!-- Agregado el contenedor flex -->
                                            @if ($comentario->archivos)
                                                <select name="select" size="1"
                                                    class="block w-full p-1 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    style="width: 150px; font-size: 12px;"
                                                    onChange="window.open(this.options[this.selectedIndex].value,'_blank')">
                                                    <option value="" selected>
                                                        Evidencias
                                                    </option>
                                                    @foreach ($comentario->archivos as $antigArch)
                                                        @if ($antigArch->flag_trash == 0)
                                                            <option
                                                                value="{{ asset('storage/' . $antigArch->archivo_path) }}">
                                                                {{ $antigArch->nombre_archivo }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if (Auth::user()->id == $comentario->usuario->id || Auth::user()->permiso_id ==1)
                            <form action="{{ route('com.destroy', ['id' => $comentario->id]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-500 hover:text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5 text-red-500">
                                    <path fill-rule="evenodd"
                                        d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                        clip-rule="evenodd" />
                                </svg>
                                </button>
                            </form>
                            @endif
                        </a>

                    </li>
                @endforeach
            </ul>
        @else
            <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
                <span>Sin comentarios actualmente.</span>
            </div>
        @endif
    </div>
    @if (Auth::user()->permiso_id==1 && ($comReasignados->count()>0 || $comAbierto->count()>0))
        <div class="mt-4 bg-white dark:bg-dark-eval-1 text-gray-800 p-4 rounded-md shadow-lg">
            <div class="bg-dark-eval-1 p-1 rounded-md text-white text-center mb-2">
                {{ __('Otros comentarios:') }}
            </div>
            @if ($comReasignados->count()>0 || $comAbierto->count()>0)
            <div class="flex flex-col gap-2">
                @if ($comReasignados->count()>0)
                    <div class='w-full rounded-lg border dark:border-gray-700 flex items-center justify-center' x-data="{ open: false }">
                        <div class='w-full '>
                            <div @click="open = !open" class='relative flex items-center w-full overflow-auto mx-auto cursor-pointer bg-gray-100 dark:bg-slate-700 dark:text-gray-300 rounded-md'>
                                <div class=' px-2 transform transition duration-300 ease-in-out' :class="{'rotate-90': open,'text-blue-500':open }">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 512 512">
                                        <path d="M0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM241 377c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l87-87-87-87c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0L345 239c9.4 9.4 9.4 24.6 0 33.9L241 377z"/>
                                    </svg>        
                                </div>
                                <div class='flex items-center px-1 py-2'>
                                    Comentarios al reasignar
                                </div>
                            </div>
                            <div class="w-full transform transition duration-300 ease-in-out"
                            x-cloak x-show="open" x-collapse x-collapse.duration.500ms >
                                <ul class="flex flex-col  max-h-[320px] overflow-y-auto" x-cloak x-show="open" x-collapse>
                                    @foreach ($comReasignados as $comentario)
                                        <li>
                                            <a
                                                class="flex  px-3 py-2 text-sm transition duration-150 ease-in-out border-b border-gray-300 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none">
                                                @if ($comentario->usuario->profile_photo_path)
                                                    <div onclick="window.location.href='{{ asset('/storage/' . $comentario->usuario->profile_photo_path) }}'">
                                                        <img class="h-10 w-10 rounded-full object-cover"
                                                        src="/storage/{{ $comentario->usuario->profile_photo_path }}"
                                                        alt="{{ $comentario->usuario->name }}" />
                                                    </div>
                                                @else
                                                <div onclick="window.location.href='{{ asset($comentario->usuario->profile_photo_url) }}'">
                                                    <img class="object-cover w-10 h-10 rounded-full"
                                                    src="{{ $comentario->usuario->profile_photo_url }}" alt="{{ $comentario->usuario->name }}" />
                                                </div>
                                                @endif
                                                <div class="w-full pb-2">
                                                    <div class="flex justify-between">
                                                        <div class="flex">
                                                            <span
                                                                class="block ml-2 font-semibold text-gray-600 dark:text-white">{{ $comentario->usuario->name }}</span>
                                                            <span
                                                                class="block ml-2 bg-gray-400 p-1 rounded-md text-bold text-white text-xs">{{ $comentario->statustck }}</span>
            
                                                        </div>
                                                        <span
                                                            class="block ml-2 text-xs text-gray-600 dark:text-white">{{ $comentario->created_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}</span>
                                                    </div>
                                                    <div class="flex items-center"> <!-- Agregado el contenedor flex -->
                                                        <span
                                                            class="block ml-2 text-sm text-gray-600 dark:text-white">{{ $comentario->comentario }}</span>
                                                    </div>
                                                </div>
                                                @if (Auth::user()->id == $comentario->usuario->id)
                                                <form action="{{ route('com.destroy', ['id' => $comentario->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-gray-500 hover:text-red-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                        class="w-5 h-5 text-red-500">
                                                        <path fill-rule="evenodd"
                                                            d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    </button>
                                                </form>
                                                @endif
                                            </a>
            
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>   
                @endif
                @if ($comAbierto->count() > 0)
                    <div class='w-full rounded-lg border dark:border-gray-700 flex items-center justify-center' x-data="{ open: false }">
                        <div class='w-full '>
                            <div @click="open = !open" class='relative flex items-center w-full overflow-auto mx-auto cursor-pointer bg-gray-100 dark:bg-slate-700 dark:text-gray-300 rounded-md'>
                                <div class=' px-2 transform transition duration-300 ease-in-out' :class="{'rotate-90': open,'text-blue-500':open }">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 512 512">
                                        <path d="M0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM241 377c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l87-87-87-87c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0L345 239c9.4 9.4 9.4 24.6 0 33.9L241 377z"/>
                                    </svg>        
                                </div>
                                <div class='flex items-center px-1 py-2'>
                                    Comentarios por abrir el ticket
                                </div>
                            </div>
                            <div class="w-full transform transition duration-300 ease-in-out"
                            x-cloak x-show="open" x-collapse x-collapse.duration.500ms >
                                <ul class="flex flex-col  max-h-[320px] overflow-y-auto" x-cloak x-show="open" x-collapse>
                                    @foreach ($comAbierto as $comentario)
                                        <li>
                                            <a
                                                class="flex  px-3 py-2 text-sm transition duration-150 ease-in-out border-b border-gray-300 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none">
                                                @if ($comentario->usuario->profile_photo_path)
                                                    <div onclick="window.location.href='{{ asset('/storage/' . $comentario->usuario->profile_photo_path) }}'">
                                                        <img class="h-10 w-10 rounded-full object-cover"
                                                        src="/storage/{{ $comentario->usuario->profile_photo_path }}"
                                                        alt="{{ $comentario->usuario->name }}" />
                                                    </div>
                                                @else
                                                <div onclick="window.location.href='{{ asset($comentario->usuario->profile_photo_url) }}'">
                                                    <img class="object-cover w-10 h-10 rounded-full"
                                                    src="{{ $comentario->usuario->profile_photo_url }}" alt="{{ $comentario->usuario->name }}" />
                                                </div>
                                                @endif
                                                <div class="w-full pb-2">
                                                    <div class="flex justify-between">
                                                        <div class="flex">
                                                            <span
                                                                class="block ml-2 font-semibold text-gray-600 dark:text-white">{{ $comentario->usuario->name }}</span>
                                                            <span
                                                                class="block ml-2 bg-gray-400 p-1 rounded-md text-bold text-white text-xs">{{ $comentario->statustck }}</span>
            
                                                        </div>
                                                        <span
                                                            class="block ml-2 text-xs text-gray-600 dark:text-white">{{ $comentario->created_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}</span>
                                                    </div>
                                                    <div class="flex items-center"> <!-- Agregado el contenedor flex -->
                                                        <span
                                                            class="block ml-2 text-sm text-gray-600 dark:text-white">{{ $comentario->comentario }}</span>
                                                    </div>
                                                </div>
                                                @if (Auth::user()->id == $comentario->usuario->id)
                                                <form action="{{ route('com.destroy', ['id' => $comentario->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-gray-500 hover:text-red-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                        class="w-5 h-5 text-red-500">
                                                        <path fill-rule="evenodd"
                                                            d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    </button>
                                                </form>
                                                @endif
                                            </a>
            
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>                     
                @endif
            </div>
            @else
                <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
                    <span>Sin comentarios actualmente.</span>
                </div>
            @endif
        </div>
    @endif
</x-app-layout>
