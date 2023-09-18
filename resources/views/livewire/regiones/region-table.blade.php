<div class="p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
    <div class="w-full flex pb-4">
        <div class="w-3/6 mx-1">
            <label for="search">Busqueda:</label>
            <input wire:model.debounce.300ms="search" type="text"
                class="block appearance-none w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 dark:bg-dark-eval-0 dark:text-white dark:border-gray-900"
                placeholder="Buscar regiones...">
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
                        Status
                    </th>
                    <th class="p-3 font-bold uppercase bg-gray-800 text-white  hidden lg:table-cell dark:bg-slate-700">
                        Fecha de Registro
                    </th>
                    <th class="p-3 font-bold uppercase bg-gray-800 text-white  hidden lg:table-cell dark:bg-slate-700">
                        Opciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($regiones as $reg)
                    <tr
                        class="bg-white lg:hover:bg-blue-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0 dark:bg-slate-800 dark:lg:hover:bg-slate-600">
                        <th
                            class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                            <div class="w-full flex justify-center gap-2">
                                <span
                                    class="lg:hidden rounded-sm bg-black p-1 text-xs text-white font-bold uppercase dark:bg-gray-200 dark:text-black">
                                    ID
                                </span>
                                {{ $reg->id }}
                            </div>
                        </th>
                        <th
                            class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                            <div class="w-full flex justify-center gap-2">
                                <span
                                    class="lg:hidden rounded-sm bg-black p-1 text-xs text-white font-bold uppercase dark:bg-gray-200 dark:text-black">
                                    Nombre
                                </span>
                                {{ $reg->name }}
                            </div>
                        </th>
                        <th
                            class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                            <div class="w-full flex justify-center gap-2">
                                <span
                                    class="lg:hidden rounded-sm bg-black p-1 text-xs text-white font-bold uppercase dark:bg-gray-200 dark:text-black">
                                    Fecha
                                </span>
                                {{ $reg->created_at->locale('es')->isoFormat('D / MMMM / YYYY H:mm:ss a') }}
                            </div>
                        </th>
                        <th
                            class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                            <div class="w-full flex justify-center gap-2">
                                <span
                                    class="lg:hidden rounded-sm bg-black p-1 text-xs text-white font-bold uppercase dark:bg-gray-200 dark:text-black">
                                    Status
                                </span>
                                @if ($reg->status == 'Activo')
                                    <span
                                        class="rounded bg-green-200 py-1 px-3 text-xs text-green-500 font-bold">{{ $reg->status }}</span>
                                @else
                                    <span
                                        class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold">{{ $reg->status }}</span>
                                @endif
                            </div>
                        </th>
                        <th
                            class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                            <div class="w-full flex justify-center gap-2">
                                    @livewire('regiones.edit-region',['regionID'=>$reg->id], key('show' . $reg->id))
                                    @livewire('regiones.delete-region',['regionID'=>$reg->id], key('show' . $reg->id))
                            </div>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-2">
            {{ $regiones->links() }}
        </div>
    </div>
</div>
