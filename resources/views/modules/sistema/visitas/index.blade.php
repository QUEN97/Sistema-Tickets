@php
    $canSelectStation = Auth::user()->permiso_id != 3 && Auth::user()->permiso_id != 2;
@endphp
<x-app-layout>

    @section('title', 'Visitas')

    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet-header>
                {{ __('VISITAS') }}
            </x-card-greet-header>
            @livewire('visitas.new-visita')
        </div>
    </x-slot>
    @if (Auth::user()->permiso_id != 3)
        <form action="{{ route('users.visita') }}" method="GET">
            <div class="flex mb-4">
                <div class="relative">
                    <label for="filter" class="sr-only">Filtrar por estacion</label>
                    <select id="filter" wire:model="filter"
                        class="border-gray-300 dark:bg-dark-eval-{{ $canSelectStation ? '1' : '0' }} dark:text-{{ $canSelectStation ? 'gray' : 'black' }} focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('filter') ? 'is-invalid' : '' }}"
                        name="filter">
                        <option value="">Estaciones</option>
                        </option>
                        @foreach ($canSelectStation ? $estacions : $superEsta as $esta)
                            <option value="{{ $esta->id }}"{{ request('filter') == $esta->id ? 'selected' : '' }}>
                                {{ $esta->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="estacion"></x-input-error>
                </div>
                <button type="submit" class="ml-4 p-2 bg-black text-white rounded-md hover:bg-gray-600">Buscar</button>
            </div>
        </form>
    @endif


    <div class="flex flex-wrap justify-evenly">
        @forelse ($visitas as $item)
                <div class="w-full mb-1 lg:max-w-full lg:flex rounded-lg" style="width: 450px;">
                    <blockquote class="p-4 my-4 border-s-4 border-indigo-400 bg-indigo-100 dark:border-indigo-500 dark:bg-indigo-800">
                        <div class="mb-4">
                            @if ($item->status == 'Pendiente')
                                <p class="text-sm text-gray-600 flex items-center">
                                    <svg width="15" height="15" viewBox="0 0 2048 2048"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill="currentColor"
                                            d="M1024 0q141 0 272 36t244 104t207 160t161 207t103 245t37 272q0 141-36 272t-104 244t-160 207t-207 161t-245 103t-272 37q-141 0-272-36t-244-104t-207-160t-161-207t-103-245t-37-272q0-141 36-272t104-244t160-207t207-161T752 37t272-37zm512 1024h-512V384H896v768h640v-128z" />
                                    </svg>
                                    {{ $item->status }}
                                </p>
                            @elseif($item->status == 'En proceso')
                                <p class="text-sm text-gray-600 flex items-center">
                                    <svg width="15" height="15" viewBox="0 0 2048 2048"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill="currentColor"
                                            d="M1024 0q141 0 272 36t244 104t207 160t161 207t103 245t37 272q0 141-36 272t-104 244t-160 207t-207 161t-245 103t-272 37q-141 0-272-36t-244-104t-207-160t-161-207t-103-245t-37-272q0-141 36-272t104-244t160-207t207-161T752 37t272-37zm0 1558q77 0 149-21t136-62t114-96t84-126l-156-74q-23 47-57 85t-77 65t-92 42t-101 15q-72 0-137-28t-117-78h126v-128H512v384h128v-142q75 78 175 121t209 43zm512-662V512h-128v142q-75-78-175-121t-209-43q-77 0-149 21t-136 62t-114 96t-84 126l156 74q22-47 56-85t78-65t92-42t101-15q72 0 137 28t117 78h-126v128h384z" />
                                    </svg>
                                    {{ $item->status }}
                                </p>
                            @elseif($item->status == 'No realizado')
                                <p class="text-sm text-gray-600 flex items-center">
                                    <svg width="15" height="15" viewBox="0 0 12 12"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill="currentColor" fill-rule="evenodd"
                                            d="M12 6A6 6 0 1 1 0 6a6 6 0 0 1 12 0zM5 3a1 1 0 0 1 2 0v3a1 1 0 0 1-2 0V3zm1 5a1 1 0 1 0 0 2a1 1 0 0 0 0-2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $item->status }}
                                </p>
                            @elseif($item->status == 'Completado')
                                <p class="text-sm text-gray-600 flex items-center">
                                    <svg width="20" height="20" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill="currentColor" fill-rule="evenodd"
                                            d="M12 21a9 9 0 1 0 0-18a9 9 0 0 0 0 18Zm-.232-5.36l5-6l-1.536-1.28l-4.3 5.159l-2.225-2.226l-1.414 1.414l3 3l.774.774l.701-.84Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $item->status }}
                                </p>
                            @endif
    
                            <div class="text-gray-900 font-bold text-xl mb-2">{{ $item->estacion->name }}</div>
                            <div class="text-gray-600 font-light text-xs mb-2">
                                {{ $item->solicita->name }}
                            </div>
                            <div class="text-gray-600 font-light text-xs mb-2">
                                {{ \Carbon\Carbon::parse($item->fecha_programada)->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}
                            </div>
                            <p class="text-gray-700">{{ $item->motivo_visita }}</p>
                        </div>
                        @if ($item->usuario == null)
                            @if (Auth::user()->permiso_id == 3)
                                @livewire('visitas.barcode-scanner')
                            @endif
                        @endif
                        @if (isset($item->usuario->name))
                            <div class="flex items-center">
                                @if ($item->usuario->profile_photo_path)
                                    <a href="{{ asset('/storage/' . $item->usuario->profile_photo_path) }}">
                                        <img class="h-10 w-10 rounded-full object-cover mr-4"
                                            src="/storage/{{ $item->usuario->profile_photo_path }}"
                                            alt="{{ $item->usuario->name }}" />
                                    </a>
                                @else
                                    <a href="{{ asset($item->usuario->profile_photo_url) }}">
                                        <img class="h-10 w-10 rounded-full object-cover mr-4"
                                            src="{{ $item->usuario->profile_photo_url }}"
                                            alt="{{ $item->usuario->name }}" />
                                    </a>
                                @endif
                                <div class="text-sm">
                                    <p class="text-gray-900 leading-none"> {{ $item->usuario->name }}</p>
                                    <p class="text-gray-600">Aug 18</p>
                                </div>
                            </div>
                        @endif
                    </blockquote>
                </div>
        @empty
        @endforelse
    </div>
</x-app-layout>
