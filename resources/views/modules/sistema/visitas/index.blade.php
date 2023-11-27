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
    @if (Auth::user()->permiso_id != 3 && Auth::user()->permiso_id != 5)
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
    @elseif(Auth::user()->permiso_id == 5 || Auth::user()->permiso_id != 3)
        <form action="{{ route('users.visita') }}" method="GET">
            <div class="flex mb-4">
                <div class="relative">
                    <label for="filter" class="sr-only">Filtrar por estacion</label>
                    <select id="filter" wire:model="filter"
                        class="border-gray-300 dark:bg-dark-eval-1 dark:text-gray focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('filter') ? 'is-invalid' : '' }}"
                        name="filter">
                        <option value="">Estaciones</option>
                        </option>
                        @foreach ($estacionesAsignadas as $esta)
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
                <blockquote
                    class="p-4 my-4 border-s-4 border-gray-800 shadow-lg rounded-md bg-white dark:border-gray-500 dark:bg-gray-800">
                    <div class="mb-4">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div style="display: flex; justify-content: center;">
                                <div class="font-bold dark:text-gray-400 mr-1">
                                    #{{ $item->id }}
                                </div>
                                |
                                @if ($item->status == 'Pendiente')
                                    <p class="text-sm text-gray-500 flex items-center">
                                        <svg width="15" height="15" viewBox="0 0 2048 2048"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill="currentColor"
                                                d="M1024 0q141 0 272 36t244 104t207 160t161 207t103 245t37 272q0 141-36 272t-104 244t-160 207t-207 161t-245 103t-272 37q-141 0-272-36t-244-104t-207-160t-161-207t-103-245t-37-272q0-141 36-272t104-244t160-207t207-161T752 37t272-37zm512 1024h-512V384H896v768h640v-128z" />
                                        </svg>
                                        <span class="ml-1"> {{ $item->status }}</span>
                                    </p>
                                @elseif($item->status == 'En proceso')
                                    <p class="text-sm text-yellow-500 flex items-center">
                                        <svg width="15" height="15" viewBox="0 0 2048 2048"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill="currentColor"
                                                d="M1024 0q141 0 272 36t244 104t207 160t161 207t103 245t37 272q0 141-36 272t-104 244t-160 207t-207 161t-245 103t-272 37q-141 0-272-36t-244-104t-207-160t-161-207t-103-245t-37-272q0-141 36-272t104-244t160-207t207-161T752 37t272-37zm0 1558q77 0 149-21t136-62t114-96t84-126l-156-74q-23 47-57 85t-77 65t-92 42t-101 15q-72 0-137-28t-117-78h126v-128H512v384h128v-142q75 78 175 121t209 43zm512-662V512h-128v142q-75-78-175-121t-209-43q-77 0-149 21t-136 62t-114 96t-84 126l156 74q22-47 56-85t78-65t92-42t101-15q72 0 137 28t117 78h-126v128h384z" />
                                        </svg>
                                        <span class="ml-1"> {{ $item->status }}</span>
                                    </p>
                                @elseif($item->status == 'No realizado')
                                    <p class="text-sm text-red-500 flex items-center">
                                        <svg width="15" height="15" viewBox="0 0 12 12"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill="currentColor" fill-rule="evenodd"
                                                d="M12 6A6 6 0 1 1 0 6a6 6 0 0 1 12 0zM5 3a1 1 0 0 1 2 0v3a1 1 0 0 1-2 0V3zm1 5a1 1 0 1 0 0 2a1 1 0 0 0 0-2z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="ml-1"> {{ $item->status }}</span>
                                    </p>
                                @elseif($item->status == 'Cancelada')
                                    <p class="text-sm text-orange-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                        </svg>
                                        <span class="ml-1"> {{ $item->status }}</span>
                                    </p>
                                @elseif($item->status == 'Completado')
                                    <p class="text-sm text-green-500 flex items-center">
                                        <svg width="20" height="20" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill="currentColor" fill-rule="evenodd"
                                                d="M12 21a9 9 0 1 0 0-18a9 9 0 0 0 0 18Zm-.232-5.36l5-6l-1.536-1.28l-4.3 5.159l-2.225-2.226l-1.414 1.414l3 3l.774.774l.701-.84Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="ml-1"> {{ $item->status }}</span>
                                    </p>
                                @endif
                            </div>
                            <div style="display: flex; justify-content: center;">
                                <div class="flex gap-2">
                                    {{-- @livewire('visitas.edit-visit', ['visitaID' => $item->id], key('edit' . $item->id)) --}}
                                    <div class="flex items-center gap-5">
                                        <div class="flex items-center mt-3 mb-3">
                                            <div class="relative" x-data="{ toggle: false }">
                                                <button class="text-gray-400 duration-300 block hover:text-gray-600"
                                                    @click="toggle=!toggle">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 "
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                                        <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                                        <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                                    </svg>
                                                </button>
                                                <div class="absolute z-50 flex flex-col w-max rounded-md overflow-hidden bg-white p-1 dark:bg-dark-eval-3 shadow-md top-0 right-full"
                                                    x-cloak x-collapse x-show="toggle">
                                                    @livewire('visitas.edit-visit', ['visitaID' => $item->id], key('edit' . $item->id))
                                                    @livewire('visitas.reprogram-visit', ['visitaID' => $item->id], key('repro' . $item->id))
                                                    @livewire('visitas.cancel-visit', ['visitaID' => $item->id], key('cancel' . $item->id))
                                                    @livewire('visitas.finalizar-visita', ['visitaID' => $item->id], key('final' . $item->id))
                                                    @livewire('visitas.show-visita', ['visitaID' => $item->id], key('show' . $item->id))
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-gray-900 dark:text-gray-400 font-bold text-xl mb-2">
                            {{ $item->estacion->name }}</div>
                        <div class="text-gray-600 dark:text-gray-400 font-light text-xs mb-2">
                            {{ $item->solicita->name }}
                        </div>
                        <div class="text-gray-600 dark:text-gray-400 font-light text-xs mb-2">
                            {{ \Carbon\Carbon::parse($item->fecha_programada)->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}
                        </div>
                        <p class="text-gray-70 dark:text-gray-400">{{ $item->motivo_visita }}</p>
                    </div>
                    @if (
                        $item->usuario == null ||
                            ($item->status != 'No realizado' && $item->status != 'Cancelada' && $item->status != 'Completado'))
                        @if (Auth::user()->permiso_id == 3)
                            @livewire('visitas.barcode-scanner', ['visitaID' => $item->id], key('scan' . $item->id))
                        @endif
                        {{-- @elseif($item->status == 'No realizado' || $item->status == 'Cancelada')
                        @if (Auth::user()->permiso_id == 3)
                            @livewire('visitas.reprogram-visit', ['visitaID' => $item->id], key('repro' . $item->id))
                        @endif
                    @endif
                    @if ($item->status == 'Pendiente')
                        @livewire('visitas.cancel-visit', ['visitaID' => $item->id], key('cancel' . $item->id)) --}}
                    @endif

                    @if (isset($item->usuario))
                        <hr class="h-px my-2 bg-gray-300 border-0 dark:bg-slate-400">
                        <div class="flex items-center ">
                            @foreach ($item->usuario as $user)
                                @if ($user->profile_photo_path)
                                    <img class="h-10 w-10 rounded-full object-cover mr-4"
                                        src="/storage/{{ $user->profile_photo_path }}" alt="{{ $user->name }}" />
                                @else
                                    <img class="h-10 w-10 rounded-full object-cover mr-4"
                                        src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
                                @endif

                                <div class="text-sm">
                                    <p class="text-gray-900 dark:text-gray-400 leading-none">
                                        {{ $user->name }}
                                    </p>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        @foreach ($item->users as $visita)
                                        <div class="text-sm font-bold text-green-500" style="display: flex; justify-content: center;">
                                            {{ $horaLlegada = $visita->pivot->llegada }}
                                        </div>
                                        <div class="text-sm font-bold text-gray-500" style="display: flex; justify-content: center;">
                                            {{ $horaRetirada = $visita->pivot->retirada }}
                                        </div>
                                        @endforeach
                                    </p>
                                    {{-- @if ($item->status != 'Completado')
                                        @livewire('visitas.finalizar-visita', ['visitaID' => $item->id], key('final' . $item->id))
                                    @endif
                                    @if ($item->status == 'Completado')
                                        @livewire('visitas.show-visita', ['visitaID' => $item->id], key('show' . $item->id))
                                    @endif --}}
                                </div>
                            @endforeach
                        </div>
                    @endif
                </blockquote>
            </div>
        @empty
            <div class="items-center justify-evenly text-center">
                <img src="{{ asset('img/icons/novisits.svg') }}" alt="Sin Visitas" style="width: 320px;">
                Sin visitas programadas.
            </div>
        @endforelse
    </div>
</x-app-layout>
