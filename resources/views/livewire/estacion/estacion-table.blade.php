<div class="p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
    <div class="w-full flex pb-4">
        <div class="w-3/6 mx-1">
            <label for="search">Busqueda:</label>
            <input wire:model.debounce.300ms="search" type="text"
                class="block appearance-none w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 dark:bg-dark-eval-0 dark:text-white dark:border-gray-900"
                placeholder="Buscar estaciones...">
        </div>
        <div class="w-1/6 relative mx-1">
            <label for="filterZonas">Filtrar:</label>
            <select wire:model="filterZonas" id="filterZonas"
                class="block appearance-none w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 dark:bg-dark-eval-0 dark:text-white dark:border-gray-900">
                <option value="">Todos</option>
                @foreach ($zonas as $zona)
                    <option value="{{ $zona->id }}">{{ $zona->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-1/6 relative mx-1">
            <label for="orderBy">Ordenar por:</label>
            <select wire:model="orderBy"
                class="block appearance-none w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 dark:bg-dark-eval-0 dark:text-white dark:border-gray-900"
                id="grid-state">
                <option value="id">ID</option>
                <option value="name">Nombre</option>
            </select>
        </div>
        <div class="w-1/6 relative mx-1">
            <label for="orderAsc">Orden:</label>
            <select wire:model="orderAsc"
                class="block appearance-none w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 dark:bg-dark-eval-0 dark:text-white dark:border-gray-900"
                id="grid-state">
                <option value="1">Ascendente</option>
                <option value="0">Descendente</option>
            </select>
        </div>
        <div class="w-1/6 relative mx-1">
            <label for="perPage">Mostrar:</label>
            <select wire:model="perPage"
                class="block appearance-none w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 dark:bg-dark-eval-0 dark:text-white dark:border-gray-900"
                id="grid-state">
                <option>10</option>
                <option>25</option>
                <option>50</option>
                <option>100</option>
            </select>
        </div>
    </div>

   <div>
        <table class="border-collapse w-full  bg-white text-center">
            <thead>
                <tr>
                    <th class="p-3 font-bold uppercase bg-gray-800 text-white  hidden lg:table-cell dark:bg-slate-700">
                        ID
                    </th>
                    <th class="p-3 font-bold uppercase bg-gray-800 text-white  hidden lg:table-cell dark:bg-slate-700">
                        Nombre
                    </th>
                    <th class="p-3 font-bold uppercase bg-gray-800 text-white  hidden lg:table-cell dark:bg-slate-700">
                        #Estación
                    </th>
                    <th class="p-3 font-bold uppercase bg-gray-800 text-white  hidden lg:table-cell dark:bg-slate-700">
                        Gerente
                    </th>
                    <th class="p-3 font-bold uppercase bg-gray-800 text-white  hidden lg:table-cell dark:bg-slate-700">
                        Supervisor
                    </th>
                    <th class="p-3 font-bold uppercase bg-gray-800 text-white  hidden lg:table-cell dark:bg-slate-700">
                        Zona
                    </th>
                    <th class="p-3 font-bold uppercase bg-gray-800 text-white  hidden lg:table-cell dark:bg-slate-700">
                        Fecha de Registro
                    </th>
                    <th class="p-3 font-bold uppercase bg-gray-800 text-white  hidden lg:table-cell dark:bg-slate-700">
                        Status
                    </th>
                    <th class="p-3 font-bold uppercase bg-gray-800 text-white  hidden lg:table-cell dark:bg-slate-700">
                        Opciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($estaciones as $esta)
                    <tr
                        class="bg-white lg:hover:bg-blue-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0 dark:bg-slate-800 dark:lg:hover:bg-slate-600">
                        <th
                            class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                            <div class="w-full flex justify-center gap-2">
                                <span
                                    class="lg:hidden rounded-sm bg-black p-1 text-xs text-white font-bold uppercase dark:bg-gray-200 dark:text-black">
                                    ID
                                </span>
                                {{ $esta->id }}
                            </div>
                        </th>
                        <th
                            class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                            <div class="w-full flex justify-center gap-2">
                                <span
                                    class="lg:hidden rounded-sm bg-black p-1 text-xs text-white font-bold uppercase dark:bg-gray-200 dark:text-black">
                                    Nombre
                                </span>
                                {{ $esta->name }}
                            </div>
                        </th>
                        <th
                            class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                            <div class="w-full flex justify-center gap-2">
                                <span
                                    class="lg:hidden rounded-sm bg-black p-1 text-xs text-white font-bold uppercase dark:bg-gray-200 dark:text-black">
                                    Número
                                </span>
                                {{ $esta->num_estacion }}
                            </div>
                        </th>
                        <th
                            class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                            <div class="w-full flex justify-center gap-2">
                                <span
                                    class="lg:hidden rounded-sm bg-black p-1 text-xs text-white font-bold uppercase dark:bg-gray-200 dark:text-black">
                                    Gerente
                                </span>
                                @if ($esta->user_id != 0 || $esta->user_id != null)
                                    @if ($esta->user->permiso_id == 3 && $esta->user->status == 'Activo')
                                        {{ $esta->user->name }}
                                    @else
                                        <p class="text-danger p-0 m-0">
                                            {{ $esta->user->name }}
                                            <span class="inline-block" tabindex="0" data-bs-toggle="popover"
                                                data-bs-trigger="hover focus"
                                                data-bs-content="Este gerente ha sido movido a la papelera"
                                                data-bs-placement="top">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-4 h-4 text-blue-400">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                        </p>
                                    @endif
                                @else
                                    <p class="text-red-500">
                                        {{ __('Sin Gerente') }}
                                    </p>
                                @endif
                            </div>
                        </th>
                        <th
                            class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                            <div class="w-full flex justify-center gap-2">
                                <span
                                    class="lg:hidden rounded-sm bg-black p-1 text-xs text-white font-bold uppercase dark:bg-gray-200 dark:text-black">
                                    Supervisor
                                </span>
                                @if ($esta->supervisor_id != 0 || $esta->supervisor_id != null)
                                    @if ($esta->supervisor->permiso_id == 2 && $esta->supervisor->status == 'Activo')
                                        {{ $esta->supervisor->name }}
                                    @else
                                        <p class="text-danger p-0 m-0">
                                            {{ $esta->supervisor->name }}
                                            <span class="inline-block" tabindex="0" data-bs-toggle="popover"
                                                data-bs-trigger="hover focus"
                                                data-bs-content="Este supervisor ha sido movido a la papelera"
                                                data-bs-placement="top">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-4 h-4 text-blue-400">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                        </p>
                                    @endif
                                @else
                                    <p class="text-red-500">
                                        {{ __('Sin Supervisor') }}
                                    </p>
                                @endif
                            </div>
                        </th>
                        <th
                            class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                            <div class="w-full flex justify-center gap-2">
                                <span
                                    class="lg:hidden rounded-sm bg-black p-1 text-xs text-white font-bold uppercase dark:bg-gray-200 dark:text-black">
                                    Zona
                                </span>
                                @if ($esta->zona->status == 'Inactivo')
                                    <p class="text-red-500">
                                        {{ $esta->zona->name }}
                                        <span class="inline-block" tabindex="0" data-bs-toggle="popover"
                                            data-bs-trigger="hover focus"
                                            data-bs-content="Esta zona ha sido movida a la papelera"
                                            data-bs-placement="top">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="w-4 h-4 text-blue-400">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </p>
                                @else
                                    {{ $esta->zona->name }}
                                @endif
                            </div>
                        </th>
                        <th
                            class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                            <div class="w-full flex justify-center gap-2">
                                <span
                                    class="lg:hidden rounded-sm bg-black p-1 text-xs text-white font-bold uppercase dark:bg-gray-200 dark:text-black">
                                    Fecha
                                </span>
                                {{ $esta->created_at->locale('es')->isoFormat('D / MMMM / YYYY H:mm:ss a') }}
                            </div>
                        </th>
                        <th
                            class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                            <div class="w-full flex justify-center gap-2">
                                <span
                                    class="lg:hidden rounded-sm bg-black p-1 text-xs text-white font-bold uppercase dark:bg-gray-200 dark:text-black">
                                    Status
                                </span>
                                @if ($esta->status == 'Activo')
                                    <span
                                        class="rounded bg-green-200 py-1 px-3 text-xs text-green-500 font-bold">{{ $esta->status }}</span>
                                @else
                                    <span
                                        class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold">{{ $esta->status }}</span>
                                @endif
                            </div>
                        </th>
                        <th
                            class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                            <div class="w-full flex justify-center gap-2">
                                    @livewire('estacion.show-estacion', ['estacion_show_id' => $esta->id], key('show' . $esta->id))
                                    @livewire('estacion.estacion-edit', ['estacion_id' => $esta->id], key('edit' . $esta->id))
                                    @livewire('estacion.estacion-delete', ['estaID' => $esta->id], key('delete' . $esta->id))
                            </div>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-2">
            {{ $estaciones->links() }}
        </div>
    </div>
</div>
