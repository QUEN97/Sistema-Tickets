<div class="p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
    <div class="w-full flex pb-4">
        <div class="w-3/6 mx-1">
            <label for="search">Busqueda:</label>
            <input wire:model.debounce.300ms="search" type="text"
                class="block appearance-none w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 dark:bg-dark-eval-0 dark:text-white dark:border-gray-900"
                placeholder="Buscar areas...">
        </div>
        <div class="w-1/6 relative mx-1">
            <label for="filterDeptos">Filtrar:</label>
            <select wire:model="filterDeptos" id="filterDeptos" class="block appearance-none w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 dark:bg-dark-eval-0 dark:text-white dark:border-gray-900">
                <option value="">Todos</option>
                @foreach ($deptos as $depto)
                    <option value="{{ $depto->id }}">{{ $depto->name }}</option>
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
                <option value="departamento_id">Departamento</option>
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
                        Área
                    </th>
                    <th class="p-3 font-bold uppercase bg-gray-800 text-white  hidden lg:table-cell dark:bg-slate-700">
                        Departamento
                    </th>
                    <th class="p-3 font-bold uppercase bg-gray-800 text-white  hidden lg:table-cell dark:bg-slate-700">
                        Status
                    </th>
                    <th class="p-3 font-bold uppercase bg-gray-800 text-white  hidden lg:table-cell dark:bg-slate-700">
                        Fecha de creación
                    </th>
                    <th class="p-3 font-bold uppercase bg-gray-800 text-white  hidden lg:table-cell dark:bg-slate-700">
                        Opciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($areas as $area)
                    <tr
                        class="bg-white lg:hover:bg-blue-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0 dark:bg-slate-800 dark:lg:hover:bg-slate-600">
                        <th
                            class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                            <div class="w-full flex justify-center gap-2">
                                <span
                                    class="lg:hidden rounded-sm bg-black p-1 text-xs text-white font-bold uppercase dark:bg-gray-200 dark:text-black">
                                    ID
                                </span>
                                {{ $area->id }}
                            </div>
                        </th>
                        <th
                            class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                            <div class="w-full flex justify-center gap-2">
                                <span
                                    class="lg:hidden rounded-sm bg-black p-1 text-xs text-white font-bold uppercase dark:bg-gray-200 dark:text-black">
                                    Área
                                </span>
                                {{ $area->name }}
                            </div>
                        </th>
                        <th
                            class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                            <div class="w-full flex justify-center gap-2">
                                <span
                                    class="lg:hidden rounded-sm bg-black p-1 text-xs text-white font-bold uppercase dark:bg-gray-200 dark:text-black">
                                    Departamento
                                </span>
                                {{ $area->departamento->name }}
                            </div>
                        </th>
                        <th
                            class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                            <div class="w-full flex justify-center gap-2">
                                <span
                                    class="lg:hidden rounded-sm bg-black p-1 text-xs text-white font-bold uppercase dark:bg-gray-200 dark:text-black">
                                    Status
                                </span>
                                @if ($area->status == 'Activo')
                                    <div
                                        class="rounded bg-green-200 py-1 px-3 text-xs text-green-500 font-bold  dark:bg-green-300 dark:text-green-900">
                                        {{ $area->status }}
                                    </div>
                                @else
                                    <div>
                                        <div
                                            class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold  dark:bg-red-300 dark:text-red-900">
                                            {{ $area->status }}
                                        </div>
                                    </div>
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
                                {{ $area->created_at->locale('es')->isoFormat('D / MMMM / YYYY H:mm:ss a') }}
                            </div>
                        </th>
                        <th
                            class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                            <div class="w-full flex justify-center gap-2">
                                @livewire('areas.show-area', ['areaID' => $area->id], key('show' . $area->id))
                                @livewire('areas.edit-area', ['areaID' => $area->id], key('edit' . $area->id))
                                @livewire('areas.delete-area', ['areaID' => $area->id], key('delete' . $area->id))
                            </div>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-2">
            {{ $areas->links() }}
        </div>
    </div>
</div>
