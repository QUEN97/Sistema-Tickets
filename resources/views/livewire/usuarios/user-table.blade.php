<div
    class="p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md lg:flex-row md:justify-between dark:bg-dark-eval-1">
    <div class="w-full">
        <div class="flex gap-1 flex-col">
            <form action="{{ route('users') }}" method="GET">
                <div class="flex mb-3">
                    <div class="relative mr-4">
                        <label for="filter" class="sr-only">Filtrar por departamento</label>
                        <select name="filter" id="filter"
                            class="block w-full p-3 pl-10 text-sm border-gray-200 rounded-md focus:border-gray-500 focus:ring-gray-500 dark:bg-dark-eval-0 dark:border-gray-700 dark:text-white">
                            <option value="">Todos</option>
                            @foreach ($permisos as $permiso)
                                <option value="{{ $permiso->id }}"
                                    {{ request('filter') == $permiso->id ? 'selected' : '' }}>
                                    {{ $permiso->titulo_permiso }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute top-0 left-0 mt-3 ml-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6 8H2a2 2 0 00-2 2v12a2 2 0 002 2h4a2 2 0 002-2V10a2 2 0 00-2-2zm0 0V4a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h12m-6 0a2 2 0 00-2 2v8a2 2 0 002 2h4a2 2 0 002-2v-8a2 2 0 00-2-2h-4a2 2 0 00-2 2z"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </div>
                    </div>
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
        </div>
        <table
            class="border-collapse w-full  bg-white text-center text-sm text-gray-500  dark:bg-dark-eval-0 dark:text-gray-400">
            <thead class="bg-gray-50">
                <tr>
                <tr>
                    <th
                        class=" p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                        Usuario</th>
                    {{-- <th
                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                        Email</th> --}}
                    <th
                        class=" p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                        Zona/Área</th>
                    <th
                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                        Status</th>
                    <th
                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                        Disponibilidad</th>
                    <th
                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                        Opciones</th>
                </tr>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 ">
                @if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3)
                    @forelse ($users as $user)
                        <tr>
                            <th class="flex gap-3 px-6 py-4 font-normal text-gray-900 ">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Usuario</span>
                                <div class="relative h-10 w-10">
                                    @if ($user->profile_photo_path)
                                        <div
                                            onclick="window.location.href='{{ asset('/storage/' . $user->profile_photo_path) }}'">
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="/storage/{{ $user->profile_photo_path }}"
                                                alt="{{ $user->name }}" />
                                        </div>
                                    @else
                                        <div onclick="window.location.href='{{ asset($user->profile_photo_url) }}'">
                                            <img class="object-cover w-10 h-10 rounded-full"
                                                src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
                                        </div>
                                    @endif
                                    @if (Cache::has('user-is-online-' . $user->id))
                                        <span
                                            class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-green-400 ring ring-white"></span>
                                    @else
                                        <span
                                            class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-red-600 ring ring-white"></span>
                                    @endif
                                </div>
                                <div class="text-sm">
                                    <div class="font-medium text-gray-700">{{ $user->name }}</div>
                                    <div class="text-gray-400">{{ $user->permiso->titulo_permiso }}</div>
                                </div>
                            </th>
                            {{-- <td
                                class="w-full lg:w-auto p-3 dark:text-gray-400 text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Email</span>
                                {{ $user->email }}
                            </td> --}}
                            <td
                                class="w-full lg:w-auto p-3 text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Zonas</span>
                                <div class="flex flex-wrap">
                                    {{-- @if ($user->zonas->count() > 0) --}}
                                    @foreach ($user->zonas as $zona)
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-1 text-xs font-semibold text-red-600  dark:bg-red-900 dark:text-red-300">
                                            {{ $zona->name }}
                                        </span>
                                    @endforeach
                                {{-- @else --}}
                                    @foreach ($user->areas as $area)
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-sky-600 px-2 py-1 text-xs font-semibold text-white">
                                            {{ $area->name }}
                                        </span>
                                    @endforeach
                                {{-- @endif --}}
                                </div>
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Status</span>
                                @if (Cache::has('user-is-online-' . $user->id))
                                    <span
                                        class="inline-flex items-center m-2 px-3 py-1 bg-green-200 rounded-full text-sm font-semibold text-green-600  dark:bg-green-900 dark:text-green-300">
                                        <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path
                                                d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z" />
                                        </svg>
                                        <span class="ml-1">
                                            Online
                                        </span>
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center m-2 px-2 py-1 bg-gray-200 rounded-full text-sm font-semibold text-gray-600  dark:bg-gray-900 dark:text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                                        </svg>
                                        <span class="ml-1">
                                            Offline
                                        </span>
                                    </span>
                                    <br>
                                    @if ($user->last_seen)
                                        <span class="dark:text-gray-400 text-xs">
                                            Últ. vez: {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Disponibilidad</span>
                                @if ($user->status == 'Activo')
                                    <span
                                        class="rounded bg-green-200 py-1 px-3 text-xs text-green-500 font-bold  dark:bg-green-900 dark:text-green-300">{{ $user->status }}</span>
                                @else
                                    <span
                                        class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold  dark:bg-red-900 dark:text-red-300">{{ $user->status }}</span>
                                @endif
                            </td>
                            @if ($valid->pivot->vermas == 1 || $valid->pivot->ed == 1 || $valid->pivot->de == 1)
                                <td
                                    class="w-full lg:w-auto p-3 border border-b block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Opciones</span>
                                    <div class="grid grid-cols-3">
                                        <div>
                                            @if ($valid->pivot->ed == 1)
                                                @livewire('usuarios.user-edit', ['user_edit_id' => $user->id])
                                            @endif
                                        </div>
                                        <div>
                                            @if ($valid->pivot->vermas == 1)
                                                @livewire('usuarios.show-user', ['user_show_id' => $user->id])
                                            @endif
                                        </div>
                                        <div>
                                            @if ($valid->pivot->de == 1)
                                                @livewire('usuarios.user-delete', ['userID' => $user->id])
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td class="w-full lg:w-auto p-3  text-center border border-b  block lg:table-cell relative lg:static"
                                colspan="6">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Sin
                                    registros</span>
                                {{ __('No hay usuarios registrados') }}
                            </td>
                        </tr>
                    @endforelse
                @elseif (Auth::user()->permiso_id == 2)
                    @foreach ($isSupervi as $user)
                        <tr>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static dark:border-gray-800">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Nombre</span>
                                <div class="text-sm">
                                    <div class="font-medium text-gray-700 dark:text-gray-400">{{ $user->name }}
                                    </div>
                                    <div class="text-gray-400 dark:ttext-gray-400">
                                        {{ $user->permiso->titulo_permiso }}
                                    </div>
                                </div>
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 dark:text-gray-400 text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Email</span>
                                {{ $user->email }}
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Zonas</span>
                                @foreach ($user->zonas as $zona)
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-1 text-xs font-semibold text-red-600  dark:bg-red-900 dark:text-red-300">
                                        {{ $zona->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Status</span>
                                @if (Cache::has('user-is-online-' . $user->id))
                                    <span
                                        class="inline-flex items-center m-2 px-3 py-1 bg-green-200 rounded-full text-sm font-semibold text-green-600  dark:bg-green-900 dark:text-green-300">
                                        <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path
                                                d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z" />
                                        </svg>
                                        <span class="ml-1">
                                            Online
                                        </span>
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center m-2 px-2 py-1 bg-gray-200 rounded-full text-sm font-semibold text-gray-600  dark:bg-gray-900 dark:text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                                        </svg>
                                        <span class="ml-1">
                                            Offline
                                        </span>
                                    </span>
                                    <br>
                                    @if ($user->last_seen)
                                        <span class="dark:text-gray-400 text-xs">
                                            Últ. vez: {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Disponibilidad</span>
                                @if ($user->status == 'Activo')
                                    <span
                                        class="rounded bg-green-200 py-1 px-3 text-xs text-green-500 font-bold  dark:bg-green-900 dark:text-green-300">{{ $user->status }}</span>
                                @else
                                    <span
                                        class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold  dark:bg-red-900 dark:text-red-300">{{ $user->status }}</span>
                                @endif
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800  border border-b block lg:table-cell relative lg:static dark:border-gray-800">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Opciones</span>
                                <div class="grid grid-cols-3">
                                    <div>
                                        @if ($valid->pivot->ed == 1)
                                            @livewire('usuarios.user-edit', ['user_edit_id' => $user->id])
                                        @endif
                                    </div>
                                    <div>
                                        @if ($valid->pivot->vermas == 1)
                                            @livewire('usuarios.show-user', ['user_show_id' => $user->id])
                                        @endif
                                    </div>
                                    <div>
                                        @if ($valid->pivot->de == 1)
                                            @livewire('usuarios.user-delete', ['userID' => $user->id])
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="mt-2 mr-2 mb-2">
            @if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3)
                {{ $users->appends($_GET)->links() }}
            @elseif(Auth::user()->permiso_id == 2)
                {{ $isSupervi->appends($_GET)->links() }}
            @endif
        </div>
    </div>
</div>
