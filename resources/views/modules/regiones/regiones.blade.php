<x-app-layout>
    @section('title', 'Regiones')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('REGIONES') }}
            </h2>
           <div>
                @livewire('regiones.new-region')
           </div>
        </div>
    </x-slot>
    <div class="p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="flex gap-1 flex-col">
            <form action="{{ route('regiones') }}" method="GET">
                <div class="flex">
                   
                    <div class="relative">
                        <label for="search" class="sr-only">Buscar</label>
                        <input type="text" name="search" id="search"
                            class="block w-full p-3 pl-10 text-sm border-gray-200 rounded-md focus:border-gray-500 focus:ring-gray-500 dark:bg-dark-eval-0 dark:border-gray-700 dark:text-white"
                            placeholder="Buscar..." value="{{ request('search') }}">
                        <div class="absolute top-0 left-0 mt-3 ml-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.5 9a6.5 6.5 0 10-13 0 6.5 6.5 0 0013 0z" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"></path>
                                <path d="M22 22L18 18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <button type="submit"
                        class="ml-4 py-2 px-4 bg-gray-600 text-white rounded-md hover:bg-gray-700">Buscar</button>
                    
                </div>
            </form>
            <div class="">
                <a class="inline-flex items-center px-3 py-2.5 text-sm font-medium text-center float-right text-white bg-gray-400 rounded-lg hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-dark-eval-3 "
                    href="{{ route('areas.trashed') }}">
                    Eliminados
                    <span
                        class="inline-flex items-center justify-center w-4 h-4 ml-2 text-xs font-semibold text-black bg-white rounded-full">
                        {{ $trashed }}
                    </span>
                </a>
            </div>
        </div>
        @if ($regiones->count()>0)
            <table>
                <thead>
                    <tr>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                            ID
                        </th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                            Nombre de la región
                        </th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                            Status
                        </th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                            Fecha de creación
                        </th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                            Opciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($regiones as $region)
                        <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0 dark:bg-slate-800 dark:lg:hover:bg-slate-600">
                            <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    <span class="lg:hidden bg-blue-200 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white">
                                        Id
                                    </span>
                                    {{$region->id}}
                                </div>
                            </th>
                            <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    <span class="lg:hidden bg-blue-200 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white">
                                        Región
                                    </span>
                                    {{$region->name}}
                                </div>
                            </th>
                            <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    <span class="lg:hidden bg-blue-200 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white">
                                        Status
                                    </span>
                                    @if ($region->status == 'Activo')
                                        <div class="rounded bg-green-200 py-1 px-3 text-xs text-green-500 font-bold  dark:bg-green-300 dark:text-green-900">
                                            {{$region->status}}
                                        </div>
                                    @else
                                        <div>
                                            <div class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold  dark:bg-red-300 dark:text-red-900">
                                                {{$region->status}}
                                            </div>
                                        </div>
                                    @endif
                                    
                                </div>
                            </th>
                            <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    <span class="lg:hidden bg-blue-200 p-1 text-xs font-bold uppercase dark:bg-blue-600 dark:text-white">
                                        Fecha
                                    </span>
                                    {{$region->created_at->locale('es')->isoFormat('D / MMMM / YYYY H:mm:ss a')}}
                                </div>
                            </th>
                            <th  class="w-full font-medium text-sm lg:w-auto p-3 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                <div class="w-full flex justify-center gap-2">
                                    @livewire('regiones.edit-region',['regionID'=>$region->id])
                                    @livewire('regiones.delete-region',['regionID'=>$region->id])
                                    {{-- @livewire('areas.show-area',['areaID' =>$area->id])
                                    @livewire('areas.edit-area',['areaID' =>$area->id])
                                    @livewire('areas.delete-area',['areaID' =>$area->id]) --}}
                                </div>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$regiones->links()}}
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
</x-app-layout>