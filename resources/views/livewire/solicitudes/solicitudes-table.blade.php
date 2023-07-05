<div
    class="p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md lg:flex-row md:justify-between dark:bg-dark-eval-1">
    <div class="w-full">
        <div class="grid grid-cols-2 mb-2 mt-2">
            <div class="ml-2">
                <form action="{{ route('solicitudes') }}" method="GET">
                    <label for="search" class="sr-only">
                        Search
                    </label>
                    <input type="text" name="s"
                        class="block w-full p-3 pl-10 text-sm border-gray-200 rounded-md focus:border-gray-500 focus:ring-gray-500 dark:bg-dark-eval-0 dark:border-gray-700 dark:text-black"
                        placeholder="Buscar..." />
                </form>
            </div>
            <div class="mr-2">
                <a class="inline-flex items-center px-3 py-2.5 text-sm font-medium text-center float-right text-white bg-gray-400 rounded-lg hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-dark-eval-3"
                    href="{{ route('solicitudes.trashed') }}">
                    Eliminados
                    <span
                        class="inline-flex items-center justify-center w-4 h-4 ml-2 text-xs font-semibold text-black bg-white rounded-full">
                        {{ $trashed }}
                    </span>
                </a>
            </div>
        </div>
        {{-- @if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) --}}
        <table
            class="border-collapse w-full  bg-white text-center text-sm text-gray-500  dark:bg-dark-eval-0 dark:text-black">
            <thead class="bg-gray-50">
                <tr>
                    <th
                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                        Id</th>
                    <th
                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                        Estación</th>
                    <th
                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                        Tipo Compra</th>
                    <th
                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                        Productos Pedidos</th>
                    <th
                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                        Status</th>
                    <th
                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                        Fecha</th>
                    @if ($superSolis->isnotEmpty() || $gerenSolis->isnotEmpty() || Auth::user()->permiso_id != 1)
                        @if ($valid->pivot->ed == 1 || $valid->pivot->de == 1 || $valid->pivot->vermas == 1)
                            <th
                                class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                Opciones</th>
                        @endif
                    @else
                        @if ($valid->pivot->ed == 1 || $valid->pivot->de == 1 || $valid->pivot->vermas == 1)
                            <th
                                class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                Opciones</th>
                        @endif
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                @if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3 && Auth::user()->permiso_id != 4)
                    @forelse ($todoSolis as $soli)
                        <tr>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static dark:text-black  dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Id</span>
                                <div class="text-sm">
                                    <div class="font-medium text-gray-700 dark:text-black ">{{ $soli->id }}</div>
                                </div>
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:text-black  dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Email</span>
                                {{ $soli->estacion }}
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:text-black  dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Email</span>
                                {{ $soli->tipo_compra }}
                            </td>
                            @if ($soli->tipo_compra == 'Ordinario')
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:text-black  dark:border-gray-700">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Email</span>
                                    {{ $soli->totprod }}
                                </td>
                            @else
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:text-black  dark:border-gray-700">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Email</span>
                                    {{ $soli->totprodext }}
                                </td>
                            @endif

                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:text-black  dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Status</span>
                                @if ($soli->status == 'Solicitado a Compras')
                                    <span
                                        class="rounded bg-indigo-200 py-1 px-3 text-xs text-indigo-500 font-bold  dark:bg-violet-500 dark:text-violet-200">
                                        {{ $soli->status }}
                                    </span>
                                @elseif ($soli->status == 'Solicitado al Supervisor')
                                    <span
                                        class="rounded bg-blue-200 py-1 px-3 text-xs text-blue-500 font-bold dark:bg-blue-600 dark:text-blue-200">
                                        {{ $soli->status }}
                                    </span>
                                @elseif ($soli->status == 'Solicitud Rechazada')
                                    <span
                                        class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold dark:bg-red-600 dark:text-red-200">
                                        {{ $soli->status }}
                                    </span>
                                @elseif ($soli->status == 'Solicitud Aprobada')
                                    <span
                                        class="rounded bg-green-200 py-1 px-3 text-xs text-green-500 font-bold dark:bg-green-600 dark:text-green-200">
                                        {{ $soli->status }}
                                    </span>
                                @elseif ($soli->status == 'Enviado a Administración')
                                    <span
                                        class="rounded bg-pink-200 py-1 px-3 text-xs text-pink-500 font-bold dark:bg-pink-600 dark:text-pink-200">
                                        {{ $soli->status }}
                                    </span>
                                @endif
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:text-black  dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Fecha</span>
                                {{ date('d-m-Y H:i:s a', strtotime($soli->fecha)) }}
                            </td>
                            @if ($valid->pivot->ed == 1 || $valid->pivot->de == 1 || $valid->pivot->vermas == 1)
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static dark:text-black  dark:border-gray-700">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Opciones</span>
                                    <div  style="display: flex; justify-content: center;">
                                        <div class="flex gap-2">
                                            @if ($valid->pivot->vermas == 1)
                                                {{-- @livewire('solicitudes.show-solicitud', ['solicitud_show_id' => $solis->id]) --}}
                                                <livewire:solicitudes.show-solicitud :solicitud_show_id='$soli->id'
                                                    :wire:key="'show-solicitud-'.$soli->id">
                                            @endif
    
                                            @if ($soli->tipo_compra == 'Ordinario')
                                                @if (
                                                    $valid->pivot->ed == 1 &&
                                                        $soli->status != 'Solicitud Rechazada' &&
                                                        $soli->status != 'Solicitud Aprobada' &&
                                                        $soli->status != 'Solicitado al Supervisor')
                                                    <livewire:solicitudes.solicitud-edit :solicitud_id='$soli->id'
                                                        :wire:key="'solicitud-edit-'.$soli->id">
                                                @endif
                                            @else
                                                @if (
                                                    $valid->pivot->ed == 1 &&
                                                        $soli->status != 'Solicitud Rechazada' &&
                                                        $soli->status != 'Solicitud Aprobada' &&
                                                        $soli->status != 'Solicitado al Supervisor' )
                                                    <livewire:solicitudes.solicitud-extra-edit :solicitud_id='$soli->id'
                                                        :wire:key="'solicitud-extra-edit-'.$soli->id">
                                                @endif
                                            @endif
    
                                            @if ($valid->pivot->de == 1 && $soli->status != 'Solicitado al Supervisor' && $soli->status != 'Solicitado a Compras')
                                                @livewire('solicitudes.solicitud-delete', ['solicID' => $soli->id])
                                            @endif
                                            {{-- trabajar a partir de quí (creo) --}}
                                            @if (
                                                $soli->status != 'Solicitud Rechazada' &&
                                                    $soli->status != 'Solicitud Aprobada' &&
                                                    $soli->status != 'Solicitado al Supervisor' &&
                                                    $soli->status != 'Solicitado a Compras')
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                </svg>
    
                                                @if ($soli->status == 'Enviado a Administración')
                                                    <button wire:click="aceptarSoliCompr({{ $soli->id }})"
                                                        wire:loading.attr="disabled" class="tooltip">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6 text-gray-400 hover:text-green-500">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M4.5 12.75l6 6 9-13.5" />
                                                        </svg>
                                                        <span class="tooltiptext">Aceptar Solicitud</span>
                                                    </button>
                                                @elseif($soli->status == 'Solicitado a Compras')
                                                    <button wire:click="envAdmin({{ $soli->id }})"
                                                        wire:loading.attr="disabled" class="tooltip">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6 text-gray-400 hover:text-green-500">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M4.5 12.75l6 6 9-13.5" />
                                                        </svg>
                                                        <span class="tooltiptext">Enviar a Administración</span>
                                                    </button>
                                                @else
                                                    <button wire:click="aceptarSoli({{ $soli->id }})"
                                                        wire:loading.attr="disabled" class="tooltip">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6 text-gray-400 hover:text-green-500">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M4.5 12.75l6 6 9-13.5" />
                                                        </svg>
                                                        <span class="tooltiptext">Aceptar Solicitud</span>
                                                    </button>
                                                @endif
                                                <livewire:solicitudes.observacion-rechazo-solicitud :solicitud_obser_id='$soli->id'
                                                    :wire:key="'observacion-rechazo-soliciutd-'.$soli->id">
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static"
                                colspan="7">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Sin
                                    registros</span>
                                    <p style="display: flex; justify-content: center;"><img src="{{asset('img/logo/buzon.png')}}" style="max-width: 150px" alt="Buzón Vacío"></p>
                            </td>
                        </tr>
                    @endforelse
                @elseif(Auth::user()->permiso_id == 4)
                    @forelse ($compraSolis as $soli)
                        <tr>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static dark:text-black  dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Id</span>
                                <div class="text-sm">
                                    <div class="font-medium text-gray-700 dark:text-gray-400 ">{{ $soli->id }}
                                    </div>
                                </div>
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:text-gray-400  dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Email</span>
                                {{ $soli->estacion }}
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:text-gray-400  dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Email</span>
                                {{ $soli->tipo_compra }}
                            </td>
                            @if ($soli->tipo_compra == 'Ordinario')
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:text-gray-400  dark:border-gray-700">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Email</span>
                                    {{ $soli->totprod }}
                                </td>
                            @else
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:text-gray-400  dark:border-gray-700">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Email</span>
                                    {{ $soli->totprodext }}
                                </td>
                            @endif
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:text-gray-400  dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Status</span>
                                @if ($soli->status == 'Solicitado a Compras')
                                    <span
                                        class="rounded bg-indigo-200 py-1 px-3 text-xs text-indigo-500 font-bold  dark:bg-violet-500 dark:text-violet-200">
                                        {{ $soli->status }}
                                    </span>
                                @elseif ($soli->status == 'Solicitado al Supervisor')
                                    <span
                                        class="rounded bg-blue-200 py-1 px-3 text-xs text-blue-500 font-bold dark:bg-blue-600 dark:text-blue-200">
                                        {{ $soli->status }}
                                    </span>
                                @elseif ($soli->status == 'Solicitud Rechazada')
                                    <span
                                        class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold dark:bg-red-600 dark:text-red-200">
                                        {{ $soli->status }}
                                    </span>
                                @elseif ($soli->status == 'Solicitud Aprobada')
                                    <span
                                        class="rounded bg-green-200 py-1 px-3 text-xs text-green-500 font-bold dark:bg-green-600 dark:text-green-200">
                                        {{ $soli->status }}
                                    </span>
                                @elseif ($soli->status == 'Enviado a Administración')
                                    <span
                                        class="rounded bg-pink-200 py-1 px-3 text-xs text-pink-500 font-bold dark:bg-pink-600 dark:text-pink-200">
                                        {{ $soli->status }}
                                    </span>
                                @endif
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:text-gray-400  dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Fecha</span>
                                {{ date('d-m-Y H:i:s a', strtotime($soli->fecha)) }}
                            </td>
                            @if ($valid->pivot->ed == 1 || $valid->pivot->de == 1 || $valid->pivot->vermas == 1)
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 border border-b block lg:table-cell relative lg:static dark:text-gray-400  dark:border-gray-700">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Opciones</span>
                                    <div style="display: flex; justify-content: center;">
                                        <div class="flex gap-2">
                                            @if ($valid->pivot->vermas == 1)
                                                {{-- @livewire('solicitudes.show-solicitud', ['solicitud_show_id' => $solis->id]) --}}
                                                <livewire:solicitudes.show-solicitud :solicitud_show_id='$soli->id'
                                                    :wire:key="'show-solicitud-'.$soli->id">
                                            @endif
    
                                            @if ($soli->tipo_compra == 'Ordinario')
                                                @if (
                                                    $valid->pivot->ed == 1 &&
                                                        $soli->status != 'Solicitud Rechazada' &&
                                                        $soli->status != 'Solicitud Aprobada' &&
                                                        $soli->status != 'Solicitado al Supervisor' &&
                                                        $soli->status != 'Enviado a Administración')
                                                    <livewire:solicitudes.solicitud-edit :solicitud_id='$soli->id'
                                                        :wire:key="'solicitud-edit-'.$soli->id">
                                                @endif
                                            @else
                                                @if (
                                                    $valid->pivot->ed == 1 &&
                                                        $soli->status != 'Solicitud Rechazada' &&
                                                        $soli->status != 'Solicitud Aprobada' &&
                                                        $soli->status != 'Solicitado al Supervisor' &&
                                                        $soli->status != 'Enviado a Administración')
                                                    <livewire:solicitudes.solicitud-extra-edit :solicitud_id='$soli->id'
                                                        :wire:key="'solicitud-extra-edit-'.$soli->id">
                                                @endif
                                            @endif
    
    
                                            @if ($valid->pivot->de == 1)
                                                @livewire('solicitudes.solicitud-delete', ['solicID' => $soli->id])
                                            @endif
                                            
                                            @if (
                                                $soli->status != 'Solicitud Rechazada' &&
                                                    $soli->status != 'Solicitud Aprobada' &&
                                                    $soli->status != 'Solicitado al Supervisor' &&
                                                    $soli->status != 'Enviado a Administración')
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6 text-gray-400">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                </svg>
    
                                                @if ($soli->status == 'Solicitado a Compras')
                                                    <button wire:click="envAdmin({{ $soli->id }})"
                                                        wire:loading.attr="disabled" class="tooltip">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6 text-gray-400 hover:text-green-500">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M4.5 12.75l6 6 9-13.5" />
                                                        </svg>
                                                        <span class="tooltiptext">Enviar a Administración</span>
                                                    </button>
                                                @endif
                                                <livewire:solicitudes.observacion-rechazo-solicitud :solicitud_obser_id='$soli->id'
                                                    :wire:key="'observacion-rechazo-soliciutd-'.$soli->id">
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static"
                                colspan="7">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Sin
                                    registros</span>
                                    <p style="display: flex; justify-content: center;"><img src="{{asset('img/logo/buzon.png')}}" style="max-width: 150px" alt="Buzón Vacío"></p>
                            </td>
                        </tr>
                    @endforelse
                @elseif (Auth::user()->permiso_id == 2)
                    @forelse ($superSolis as $super)
                        <tr>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static dark:text-gray-400  dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Id</span>
                                <div class="text-sm">
                                    <div class="font-medium text-gray-700 dark:text-gray-400">{{ $super->id }}
                                    </div>
                                </div>
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:text-gray-400  dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Email</span>
                                {{ $super->estacion }}
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:text-gray-400  dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Email</span>
                                {{ $super->tipo_compra }}
                            </td>
                            @if ($super->tipo_compra == 'Ordinario')
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:text-gray-400  dark:border-gray-700">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Email</span>
                                    {{ $super->totprod }}
                                </td>
                            @else
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:text-gray-400  dark:border-gray-700">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Email</span>
                                    {{ $super->totprodext }}
                                </td>
                            @endif
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:text-gray-400  dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Status</span>
                                @if ($super->status == 'Solicitado a Compras')
                                    <span
                                        class="rounded bg-indigo-200 py-1 px-3 text-xs text-indigo-500 font-bold  dark:bg-violet-500 dark:text-violet-200">
                                        {{ $super->status }}
                                    </span>
                                @elseif ($super->status == 'Solicitado al Supervisor')
                                    <span
                                        class="rounded bg-blue-200 py-1 px-3 text-xs text-blue-500 font-bold dark:bg-blue-600 dark:text-blue-200">
                                        {{ $super->status }}
                                    </span>
                                @elseif ($super->status == 'Solicitud Rechazada')
                                    <span
                                        class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold dark:bg-red-600 dark:text-red-200">
                                        {{ $super->status }}
                                    </span>
                                @elseif ($super->status == 'Solicitud Aprobada')
                                    <span
                                        class="rounded bg-green-200 py-1 px-3 text-xs text-green-500 font-bold dark:bg-green-600 dark:text-green-200">
                                        {{ $super->status }}
                                    </span>
                                @elseif ($super->status == 'Enviado a Administración')
                                    <span
                                        class="rounded bg-pink-200 py-1 px-3 text-xs text-pink-500 font-bold dark:bg-pink-600 dark:text-pink-200">
                                        {{ $super->status }}
                                    </span>
                                @endif
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:text-gray-400  dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Fecha</span>
                                {{ date('d-m-Y H:i:s a', strtotime($super->fecha)) }}
                            </td>
                            @if ($valid->pivot->ed == 1 || $valid->pivot->de == 1 || $valid->pivot->vermas == 1)
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static dark:text-gray-400  dark:border-gray-700">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Opciones</span>
                                    <div style="display: flex; justify-content: center;">
                                        <div class="flex gap-2">
                                            @if ($valid->pivot->vermas == 1)
                                                <livewire:solicitudes.show-solicitud :solicitud_show_id='$super->id'
                                                    :wire:key="'show-solicitud-'.$super->id">
                                            @endif
    
                                            @if ($super->tipo_compra == 'Ordinario')
                                                @if (
                                                    $valid->pivot->ed == 1 &&
                                                        $super->status != 'Solicitud Aprobada' &&
                                                        $super->status != 'Solicitado a Compras' &&
                                                        $super->status != 'Enviado a Administración')
                                                    <livewire:solicitudes.solicitud-edit :solicitud_id='$super->id'
                                                        :wire:key="'solicitud-edit-'.$super->id">
                                                @endif
                                            @else
                                                @if (
                                                    $valid->pivot->ed == 1 &&
                                                        $super->status != 'Solicitud Aprobada' &&
                                                        $super->status != 'Solicitado a Compras' &&
                                                        $super->status != 'Enviado a Administración')
                                                    <livewire:solicitudes.solicitud-extra-edit :solicitud_id='$super->id'
                                                        :wire:key="'solicitud-edit-'.$super->id">
                                                @endif
                                            @endif
    
    
                                            @if ($valid->pivot->de == 1 && $super->status != 'Solicitud Aprobada' && $super->status != 'Solicitado a Compras')
                                                @livewire('solicitudes.solicitud-delete', ['solicID' => $super->id])
                                            @endif
    
                                            @if ($super->status == 'Solicitado al Supervisor' && $super->status != 'Solicitado a Compras')
                                                <button wire:click="aceptarSoli({{ $super->id }})"
                                                    wire:loading.attr="disabled" class="tooltip">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6 text-gray-400 hover:text-green-500">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M4.5 12.75l6 6 9-13.5" />
                                                    </svg>
                                                    <span class="tooltiptext">Enviar a Compras</span>
                                                </button>
    
                                                <livewire:solicitudes.observacion-rechazo-solicitud :solicitud_obser_id='$super->id'
                                                    :wire:key="'observacion-rechazo-soliciutd-'.$super->id">
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static"
                                colspan="7">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Sin
                                    registros</span>
                                    <p style="display: flex; justify-content: center;"><img src="{{asset('img/logo/buzon.png')}}" style="max-width: 150px" alt="Buzón Vacío"></p>
                            </td>
                        </tr>
                    @endforelse
                @elseif (Auth::user()->permiso_id == 3)
                    @forelse ($gerenSolis as $geren)
                        <tr>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static   dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Id</span>
                                <div class="text-sm">
                                    <div class="font-medium text-gray-700 ">{{ $geren->id }}
                                    </div>
                                </div>
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static   dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Email</span>
                                {{ $geren->estacion }}
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static   dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Email</span>
                                {{ $geren->tipo_compra }}
                            </td>
                            @if ($geren->tipo_compra == 'Ordinario')
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static   dark:border-gray-700">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Email</span>
                                    {{ $geren->totprod }}
                                </td>
                            @else
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static   dark:border-gray-700">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Email</span>
                                    {{ $geren->totprodext }}
                                </td>
                            @endif
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static   dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Status</span>
                                @if ($geren->status == 'Solicitado a Compras')
                                    <span
                                        class="rounded bg-indigo-200 py-1 px-3 text-xs text-indigo-500 font-bold  dark:bg-violet-500 dark:text-violet-200">
                                        {{ $geren->status }}
                                    </span>
                                @elseif ($geren->status == 'Solicitado al Supervisor')
                                    <span
                                        class="rounded bg-blue-200 py-1 px-3 text-xs text-blue-500 font-bold dark:bg-blue-600 dark:text-blue-200">
                                        {{ $geren->status }}
                                    </span>
                                @elseif ($geren->status == 'Solicitud Rechazada')
                                    <span
                                        class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold dark:bg-red-600 dark:text-red-200">
                                        {{ $geren->status }}
                                    </span>
                                @elseif ($geren->status == 'Solicitud Aprobada')
                                    <span
                                        class="rounded bg-green-200 py-1 px-3 text-xs text-green-500 font-bold dark:bg-green-600 dark:text-green-200">
                                        {{ $geren->status }}
                                    </span>
                                @elseif ($geren->status == 'Enviado a Administración')
                                    <span
                                        class="rounded bg-pink-200 py-1 px-3 text-xs text-pink-500 font-bold dark:bg-pink-600 dark:text-pink-200">
                                        {{ $geren->status }}
                                    </span>
                                @endif
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static   dark:border-gray-700">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Fecha</span>
                                {{ date('d-m-Y H:i:s a', strtotime($geren->fecha)) }}
                            </td>
                            @if ($valid->pivot->ed == 1 || $valid->pivot->de == 1 || $valid->pivot->vermas == 1)
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static   dark:border-gray-700">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Opciones</span>
                                    <div style="display: flex; justify-content: center;">
                                        <div class="flex gap-2">
                                            @if ($valid->pivot->vermas == 1)
                                                <livewire:solicitudes.show-solicitud :solicitud_show_id='$geren->id'
                                                    :wire:key="'show-solicitud-'.$geren->id">
                                            @endif
    
                                            @if ($geren->tipo_compra == 'Ordinario')
                                                @if (
                                                    $valid->pivot->ed == 1 &&
                                                        $geren->status != 'Solicitud Aprobada' &&
                                                        $geren->status != 'Solicitado a Compras' &&
                                                        $geren->status != 'Enviado a Administración')
                                                    <livewire:solicitudes.solicitud-edit :solicitud_id='$geren->id'
                                                        :wire:key="'solicitud-edit-'.$geren->id">
                                                @endif
                                            @else
                                                @if (
                                                    $valid->pivot->ed == 1 &&
                                                        $geren->status != 'Solicitud Aprobada' &&
                                                        $geren->status != 'Solicitado a Compras' &&
                                                        $geren->status != 'Enviado a Administración')
                                                    <livewire:solicitudes.solicitud-extra-edit :solicitud_id='$geren->id'
                                                        :wire:key="'solicitud-edit-'.$geren->id">
                                                @endif
                                            @endif
    
                                            @if ($valid->pivot->de == 1 && $geren->status != 'Solicitud Aprobada' && $geren->status != 'Solicitado a Compras')
                                                @livewire('solicitudes.solicitud-delete', ['solicID' => $geren->id])
                                            @endif
    
                                            {{-- @if ($geren->status == 'Solicitado al Supervisor')
                                        <button wire:click="aceptarSoliCompr({{ $geren->id }})"
                                            wire:loading.attr="disabled" class="hover:bg-green-100 rounded-full"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Aprobar Solicitud">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-6 h-6 hover:text-green-500">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                        </button>
    
                                        <livewire:solicitudes.observacion-rechazo-solicitud :solicitud_obser_id='$geren->id'
                                            :wire:key="'observacion-rechazo-soliciutd-'.$geren->id">
                                    @endif --}}
                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static"
                                colspan="7">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Sin
                                    registros</span>
                                    <p style="display: flex; justify-content: center;"><img src="{{asset('img/logo/buzon.png')}}" style="max-width: 150px" alt="Buzón Vacío"></p>
                            </td>
                        </tr>
                    @endforelse
                @endif
            </tbody>
        </table>
        <div class="mt-2 mb-2 mr-2">
            @if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3)
                {{ $todoSolis->appends($_GET)->links() }}
            @elseif(Auth::user()->permiso_id == 4)
                {{ $compraSolis->appends($_GET)->links() }}
            @elseif(Auth::user()->permiso_id == 2)
                {{ $superSolis->appends($_GET)->links() }}
            @elseif (Auth::user()->permiso_id == 3)
                {{ $gerenSolis->appends($_GET)->links() }}
            @endif
        </div>
    </div>
    {{-- @endif --}}
</div>
</div>
