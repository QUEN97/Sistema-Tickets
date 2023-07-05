<div
    class="p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md lg:flex-row md:justify-between dark:bg-dark-eval-1">
    <div class="w-full">
        <div class="grid grid-cols-2 mb-2">
            <div>
                <span>{{ __('Buscar por Categoría') }}</span>
                <select id="filterAlma" wire:model="filterAlma"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-0
                        dark:text-black dark:focus:ring-offset-dark-eval-1 {{ $errors->has('filterAlma') ? 'is-invalid' : '' }}"
                    name="filterAlma" required aria-required="true">
                    <option value="Todas">Todas</option>
                    @foreach ($categos as $filtAlm)
                        <option value="{{ $filtAlm->id }}">{{ $filtAlm->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                @if (Auth::user()->permiso_id == 3)
                    <div class="float-right ">
                        <x-input type="text" wire:model="search"
                            class="bg-white border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-0
                        dark:text-black dark:focus:ring-offset-dark-eval-1"
                            placeholder="Buscar Por Producto" />
                    </div>
                @else
                    <div class="float-right">
                        <x-input type="text" wire:model="search" class="dark:bg-dark-eval-0 dark:text-black"
                            placeholder="Buscar Por Estación..." />
                    </div>
                @endif
            </div>
        </div>
        @if (Auth::user()->permiso_id != 3 || Auth::user()->permiso_id == 4)
            <table
                class="border-collapse w-full  bg-white text-center text-sm text-gray-500  dark:bg-dark-eval-0 dark:text-black">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Id</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Producto</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Imagen</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Estación</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Stock</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Status</th>
                        <th
                            class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Fecha</th>
                        @if (Auth::user()->permiso_id == 1)
                            <th
                                class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                Opciones</th>
                        @elseif ($valid->pivot->vermas == 1 || $valid->pivot->de == 1)
                            <th
                                class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                Opciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 border-t border-gray-100 dark:border-gray-800 ">
                    @if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3)
                        @forelse ($allmacen as $allma)
                            <tr>
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-black text-center border border-b block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold ">Id</span>
                                    {{ $allma->id }}
                                </td>
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-black text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Producto</span>
                                    {{ $allma->producto }}
                                </td>
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-black text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Imagen</span>
                                    @if ($allma->imagen == null)
                                        <img class="rounded-full" name="photo"
                                            src="{{ asset('storage/product-photos/imagedefault.jpg') }}"
                                            style="height: 4rem;" />
                                    @else
                                        <img class="rounded-full" name="photo"
                                            src="{{ asset('storage/' . $allma->imagen) }}" style="height: 4rem;" />
                                    @endif
                                </td>
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-black text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Estación</span>
                                    {{ $allma->name }}
                                </td>
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-black text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Stock</span>
                                    @if ($allma->stock <= $allma->fijo)
                                        <span
                                            class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">{{ $allma->stock }}</span>
                                    @else
                                        <span
                                            class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                            {{ $allma->stock }}</span>
                                    @endif
                                </td>
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-black text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Activo</span>
                                    @if ($allma->status == 'Activo')
                                        <div class="flex flex-wrap">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-4 h-4 text-green-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                {{ $allma->status }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex flex-wrap">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-4 h-4 text-red-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                {{ $allma->status }}
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-black text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Fecha</span>
                                    {{ date('d-m-Y H:i:s', strtotime($allma->fecha)) }}
                                </td>
                                @if ($valid->pivot->vermas == 1 || $valid->pivot->de == 1 || $valid->pivot->ed == 1)
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 dark:text-black border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Opciones</span>
                                        <div style="display: flex; justify-content: center;">
                                            <div class="flex gap-2">
                                                <div>
                                                    @if ($valid->pivot->vermas == 1)
                                                        <livewire:almacenes.ver-mas-almacen :almacen_show_id="$allma->id"
                                                            :wire:key="'ver-mas-almacen-'.$allma->id">
                                                    @endif
                                                </div>
                                                <div>
                                                    @if ($valid->pivot->ed == 1 && $allma->stock != 0)
                                                        <livewire:almacenes.almacen-edit :almacen_edit_id="$allma->id"
                                                            :almacen_produ_id="$allma->produ" :wire:key="'edit-almacen-'.$allma->id">
                                                    @endif
                                                </div>
                                                <div>
                                                    @if ($valid->pivot->de == 1)
                                                        @livewire('almacenes.almacen-delete', ['almaID' => $allma->id])
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td class="p-4" colspan="8">
                                    <span class="text-danger text-lg">
                                        <p style="display: flex; justify-content: center;"><img src="{{asset('img/logo/buzon.png')}}" style="max-width: 150px" alt="Buzón Vacío"></p>
                                    </span>
                                </td>
                            </tr>
                        @endforelse
                    @elseif (Auth::user()->permiso_id == 2)
                        @forelse ($isSuper as $allmaSup)
                            <tr>
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-black text-center border border-b block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Id</span>
                                    {{ $allmaSup->id }}
                                </td>
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-black text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Producto</span>
                                    {{ $allmaSup->producto }}
                                </td>
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-black text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Imagen</span>
                                    @if ($allmaSup->imagen == null)
                                        <img class="rounded-full" name="photo"
                                            src="{{ asset('storage/product-photos/imagedefault.jpg') }}"
                                            style="height: 4rem;" />
                                    @else
                                        <img class="rounded-full" name="photo"
                                            src="{{ asset('storage/' . $allmaSup->imagen) }}" style="height: 4rem;" />
                                    @endif
                                </td>
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-black text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Estación</span>
                                    {{ $allmaSup->name }}
                                </td>
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-black text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Stock</span>
                                    @if ($allmaSup->stock <= $allmaSup->fijo)
                                        <div
                                            class="tooltip bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                            {{ $allmaSup->stock }}
                                            <span class="tooltiptext">Stock de producto bajo, se recomienda solicitar
                                                más producto</span>
                                            <div>
                                            @else
                                                <span
                                                    class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                                    {{ $allmaSup->stock }}</span>
                                    @endif
                                </td>
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-black text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Activo</span>
                                    @if ($allmaSup->status == 'Activo')
                                        <div class="flex flex-wrap">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-4 h-4 text-green-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                {{ $allmaSup->status }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex flex-wrap">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-4 h-4 text-red-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                {{ $allmaSup->status }}
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-black text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Fecha</span>
                                    {{ date('d-m-Y H:i:s', strtotime($allmaSup->fecha)) }}
                                </td>
                                @if ($valid->pivot->vermas == 1 || $valid->pivot->de == 1 || $valid->pivot->ed == 1)
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 dark:text-black text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Opciones</span>
                                        <div style="display: flex; justify-content: center;">
                                            <div class="flex gap-2">
                                                @if ($valid->pivot->vermas == 1)
                                                    {{-- @livewire('almacenes.ver-mas-almacen', ['almacen_show_id' => $allma->id], key('ver-mas-almacen-'.$allma->id)) --}}
                                                    <livewire:almacenes.ver-mas-almacen :almacen_show_id="$allmaSup->id"
                                                        :wire:key="'ver-mas-almacen-'.$allmaSup->id">
                                                @endif

                                                @if ($valid->pivot->ed == 1 && $allmaSup->stock != 0)
                                                    {{-- @livewire('almacenes.ver-mas-almacen', ['almacen_show_id' => $allma->id], key('ver-mas-almacen-'.$allma->id)) --}}
                                                    <livewire:almacenes.almacen-edit :almacen_edit_id="$allmaSup->id" :almacen_produ_id="$allmaSup->produ"
                                                        :wire:key="'edit-almacen-'.$allmaSup->id">
                                                @endif

                                                @if ($valid->pivot->de == 1)
                                                    @livewire('almacenes.almacen-delete', ['almaID' => $allmaSup->id])
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td class="p-4" colspan="8">
                                    <span class="text-danger text-lg">
                                        <p style="display: flex; justify-content: center;"><img src="{{asset('img/logo/buzon.png')}}" style="max-width: 150px" alt="Buzón Vacío"></p>
                                    </span>
                                </td>
                            </tr>
                        @endforelse

                    @endif
                </tbody>
            </table>
        @endif

        @if (Auth::user()->permiso_id == 3)
            <div class="flex flex-wrap justify-center items-stretch gap-3">
                @forelse ($isGeren as $produc)
                    {{-- {{$gerent->producto}} --}}
                    <div class="flex flex-wrap justify-center items-stretch gap-3">
                        <div
                            class="shadow-lg group container  rounded-md bg-white dark.bg-gray400 max-w-sm flex justify-center items-center  mx-left content-div">
                            <div>
                                <div class="w-full image-cover rounded-t-md">
                                    @if ($produc->stock <= $produc->fijo)
                                        <div
                                            class="p-3 m-4 w-18 h-18 text-center bg-red-700 dark:bg-dark-eval-3 rounded-full  text-white float-right fd-cl group-hover:opacity-25">
                                            <span class="text-xs tracking-wide  font-bold font-sans"> Solicitar</span>
                                            <span class="text-xs tracking-wide  font-bold font-sans block">+</span>
                                            <span
                                                class="text-xs tracking-wide font-bold block font-sans">Producto</span>
                                        </div>
                                    @endif
                                </div>
                                <div
                                    class="py-6 px-2 bg-white dark:bg-dark-eval-2 rounded-b-md fd-cl group-hover:opacity-25">
                                    <span
                                        class="block text-lg text-gray-800 dark:text-white font-bold tracking-wide">{{ $produc->producto }}</span>
                                    <span class="invisible">Nombre del Producto</span>
                                    <span class="block text-gray-600 text-sm">
                                        @if ($produc->stock <= $produc->fijo)
                                            <span
                                                class="bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
                                                {{ __(' Total de productos disponibles:') . ' ' . $produc->stock }}
                                            </span>
                                            <span class="invisible">Solicitar Productos</span>
                                        @else
                                            <span
                                                class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                                {{ __(' Total de productos disponibles:') . ' ' . $produc->stock }}
                                            </span>
                                            <span class="invisible">No Solicitar Productos</span>
                                        @endif
                                        <div class="dark:text-white">
                                            {{ __('Fecha de registro:') . ' ' . $produc->fecha }}
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="absolute opacity-0 fd-sh group-hover:opacity-100">
                                <div class="pt6 text-center">
                                    @if ($valid->pivot->de == 1)
                                        @livewire('almacenes.almacen-delete', ['almaID' => $produc->id])
                                    @endif
                                </div>
                                <div class="pt-8 text-center">
                                    @if ($valid->pivot->vermas == 1)
                                        <div>
                                            @livewire('almacenes.ver-mas-almacen', ['almacen_show_id' => $produc->id])
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if ($produc->imagen == null)
                            <style>
                                .content-div {
                                    background-image: url('storage/product-photos/imagedefault.jpg');
                                    background-repeat: no-repeat;
                                    background-size: cover;
                                    background-position: center;
                                }

                                .content-div:hover {
                                    background-image:
                                        linear-gradient(to right,
                                            rgba(73, 72, 72, 0.658), hsla(0, 1%, 48%, 0.712)),
                                        url('storage/product-photos/imagedefault.jpg');
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
                        @else
                            <style>
                                .content-div {
                                    background-image: url('storage/<?php echo $produc->imagen; ?>');
                                    background-repeat: no-repeat;
                                    background-size: cover;
                                    background-position: center;
                                }

                                .content-div:hover {
                                    background-image:
                                        linear-gradient(to right,
                                            rgba(73, 72, 72, 0.658), hsla(0, 1%, 48%, 0.712)),
                                        url('storage/<?php echo $produc->imagen; ?>');
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
                        @endif
                @empty
                <p style="display: flex; justify-content: center;"><img src="{{asset('img/logo/buzon.png')}}" style="max-width: 150px" alt="Buzón Vacío"></p>
                @endforelse
            </div>
        @endif



        @if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3)
            {{ $allmacen->links() }}
        @elseif(Auth::user()->permiso_id == 2)
            {{ $isSuper->links() }}
        @elseif(Auth::user()->permiso_id == 3)
            {{ $isGeren->links() }}
        @endif
    </div>
</div>
