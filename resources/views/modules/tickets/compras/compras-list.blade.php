<x-app-layout>
    @section('title', 'Requisiciones')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet-header>
                {{ __('LISTA DE REQUISICIONES') }}
            </x-card-greet-header>
        </div>
    </x-slot>
    <div class="p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        @if ($compras->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                            ID
                        </th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                            No. de ticket
                        </th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                            Agente
                        </th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                            Cliente
                        </th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                            Status
                        </th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                            Fecha de creación
                        </th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                            Fecha de actualización
                        </th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                            Opciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compras as $compra)
                        <tr
                            class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0 dark:bg-slate-800 dark:lg:hover:bg-slate-600">
                            <th
                                class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    <span
                                        class="lg:hidden bg-blue-200 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white">
                                        ID
                                    </span>
                                    {{ $compra->id }}
                                </div>
                            </th>
                            <th
                                class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    <span
                                        class="lg:hidden bg-blue-200 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white">
                                        No. de ticket
                                    </span>
                                    {{ $compra->ticket_id }}
                                </div>
                            </th>
                            <th
                                class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    <span
                                        class="lg:hidden bg-blue-200 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white">
                                        Agente
                                    </span>
                                    {{ $compra->ticket->agente->name }}
                                </div>
                            </th>
                            <th
                                class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    <span
                                        class="lg:hidden bg-blue-200 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white">
                                        Cliente
                                    </span>
                                    {{ $compra->ticket->cliente->name }}
                                </div>
                            </th>
                            <th
                                class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    <span
                                        class="lg:hidden bg-blue-200 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white">
                                        Status
                                    </span>
                                    @if ($compra->status == 'Solicitado')
                                        <div class="py-1 px-2 bg-blue-700 text-white rounded-md">
                                            {{ $compra->status }}
                                        </div>
                                    @endif
                                    @if ($compra->status == 'Aprobado')
                                        <div class="py-1 px-2 bg-green-700 text-white rounded-md">
                                            {{ $compra->status }}
                                        </div>
                                    @endif
                                    @if ($compra->status == 'Enviado a compras')
                                        <div class="py-1 px-2 bg-amber-600 text-white rounded-md">
                                            {{ $compra->status }}
                                        </div>
                                    @endif
                                    @if ($compra->status == 'Completado')
                                        <div class="py-1 px-2 bg-slate-900 text-white rounded-md">
                                            {{ $compra->status }}
                                        </div>
                                    @endif
                                    @if ($compra->status == 'Rechazado')
                                        <div class="py-1 px-2 bg-red-700 text-white rounded-md">
                                            {{ $compra->status }}
                                        </div>
                                    @endif
                                </div>
                            </th>
                            <th
                                class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    <span
                                        class="lg:hidden bg-blue-200 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white">
                                        Status
                                    </span>
                                    {{ $compra->created_at->locale('es')->isoFormat('D / MMMM / YYYY H:mm:ss a') }}
                                </div>
                            </th>
                            <th
                                class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    <span
                                        class="lg:hidden bg-blue-200 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white">
                                        Status
                                    </span>
                                    {{ $compra->updated_at->locale('es')->isoFormat('D / MMMM / YYYY H:mm:ss a') }}
                                </div>
                            </th>
                            <th
                                class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    @livewire('tickets.compras.compra-detail', ['compraID' => $compra->id])
                                    @if ($compra->status != 'Completado')
                                        @if (
                                            (Auth::user()->permiso_id == 1 && $compra->status == 'Solicitado') ||
                                                (Auth::user()->permiso_id == 4 && $compra->status != 'Solicitado') ||
                                                (Auth::user()->permiso_id == 5 && $compra->status != 'Solicitado' && $compra->status != 'Aprobado'))
                                            <div>
                                                <a href="{{ route('req.edit', $compra->id) }}" class="tooltip">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6 text-gray-400 hover:text-indigo-500 transition duration-300">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                    <span class="tooltiptext">Editar</span>
                                                </a>
                                            </div>
                                        @endif
                                    @endif


                                    {{-- @livewire('departamentos.delete-depto',['deptoID'=>$compra->id]) --}}
                                    @if (Auth::user()->permiso_id == 1 || Auth::user()->permiso_id == 4)
                                        @livewire('tickets.compras.acep-compra', ['compraID' => $compra->id, 'status' => $compra->status])
                                    @endif

                                    @if ($compra->status != 'Completado' && $compra->status != 'Rechazado')
                                        @if (
                                            (Auth::user()->permiso_id == 1 && $compra->status == 'Solicitado') ||
                                                (Auth::user()->permiso_id == 4 && $compra->status != 'Solicitado') )
                                            @livewire('tickets.compras.compra-reject', ['compraID' => $compra->id])
                                        @endif
                                    @endif


                                </div>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $compras->links() }}
        @else
            <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="max-w-[200px] bi bi-x-circle"
                    viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
                <span class="text-2xl">No hay datos registrados</span>
            </div>
        @endif
    </div>
</x-app-layout>
