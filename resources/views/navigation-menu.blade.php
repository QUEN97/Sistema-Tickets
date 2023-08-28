<nav aria-label="secondary" x-data="{ open: false }"
    class="sticky top-0 z-10 flex items-center justify-between px-4 py-4 sm:px-6 transition-transform duration-500 bg-white dark:bg-dark-eval-1"
    {{-- :class="{
        '-translate-y-full': scrollingDown,
        'translate-y-0': scrollingUp,
    }" --}}>

    <div class="flex items-center gap-3">
        <x-button type="button" class="md:hidden" iconOnly variant="secondary" srText="Toggle dark mode"
            @click="toggleTheme">
            <x-heroicon-o-moon x-show="!isDarkMode" aria-hidden="true" class="w-6 h-6" />
            <x-heroicon-o-sun x-show="isDarkMode" aria-hidden="true" class="w-6 h-6" />
        </x-button>
    </div>

    <div class="flex items-center gap-3">
        <x-button type="button" class="hidden md:inline-flex" iconOnly variant="secondary" srText="Toggle dark mode"
            @click="toggleTheme">
            <x-heroicon-o-moon x-show="!isDarkMode" aria-hidden="true" class="w-6 h-6" />
            <x-heroicon-o-sun x-show="isDarkMode" aria-hidden="true" class="w-6 h-6" />
        </x-button>

        {{-- Notificaciones --}}
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                @if (Auth::user()->unreadNotifications->count() == 0)
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 cursor-pointer text-gray-600 dark:text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                @else
                    <div class="top-0 absolute left-3">
                        <p
                            class="flex h-2 w-2 items-center justify-center rounded-full bg-red-500 p-2 text-xs text-white">
                            {{ __(Auth::user()->unreadNotifications->count()) }}
                        </p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 cursor-pointer text-gray-600 dark:text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                @endif
            </x-slot>

            <x-slot name="content">
                <div class="block px-4 py-2 text-xs text-center text-gray-400">
                    @if (Auth::user()->unreadNotifications->count() == 1)
                        {{ __(Auth::user()->unreadNotifications->count() . ' ' . 'Notificación') }}
                    @else
                        {{ __(Auth::user()->unreadNotifications->count() . ' ' . 'Notificaciones') }}
                    @endif
                </div>

                <div class="border-t border-gray-100 dark:border-gray-700"></div>

                <div class="max-h-[320px] overflow-y-auto">
                    @forelse (Auth::user()->unreadNotifications as $item)
                        {{-- Notif ticket asignado --}}
                        @if ($item->type == 'App\Notifications\TicketAsignadoNotificacion')
                            <x-dropdown-link href="{{ route('tickets') }}" wire:click="leerNoti({{ $item }})"
                                class="mb-4">
                                <svg class="w-4 h-4" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="#6b7280"
                                        d="m490.18 181.4l-44.13-44.13a20 20 0 0 0-27-1a30.81 30.81 0 0 1-41.68-1.6a30.81 30.81 0 0 1-1.6-41.67a20 20 0 0 0-1-27L330.6 21.82a19.91 19.91 0 0 0-28.13 0l-70.35 70.34a39.87 39.87 0 0 0-9.57 15.5a7.71 7.71 0 0 1-4.83 4.83a39.78 39.78 0 0 0-15.5 9.58l-180.4 180.4a19.91 19.91 0 0 0 0 28.13L66 374.73a20 20 0 0 0 27 1a30.69 30.69 0 0 1 43.28 43.28a20 20 0 0 0 1 27l44.13 44.13a19.91 19.91 0 0 0 28.13 0l180.4-180.4a39.82 39.82 0 0 0 9.58-15.49a7.69 7.69 0 0 1 4.84-4.84a39.84 39.84 0 0 0 15.49-9.57l70.34-70.35a19.91 19.91 0 0 0-.01-28.09Zm-228.37-29.65a16 16 0 0 1-22.63 0l-11.51-11.51a16 16 0 0 1 22.63-22.62l11.51 11.5a16 16 0 0 1 0 22.63Zm44 44a16 16 0 0 1-22.62 0l-11-11a16 16 0 1 1 22.63-22.63l11 11a16 16 0 0 1 .01 22.66Zm44 44a16 16 0 0 1-22.63 0l-11-11a16 16 0 0 1 22.63-22.62l11 11a16 16 0 0 1 .05 22.67Zm44.43 44.54a16 16 0 0 1-22.63 0l-11.44-11.5a16 16 0 1 1 22.68-22.57l11.45 11.49a16 16 0 0 1-.01 22.63Z" />
                                </svg>
                                <div class="text-sm">{{ __('Hola') }} "{{ $item->data['asignado'] }}",
                                    {{ $item->data['cliente'] }}
                                    {{ __('necesita tu apoyo con el ticket #') }}{{ $item->data['tckId'] }}
                                    {{ $item->data['fecha'] }}</div>
                            </x-dropdown-link>
                            {{-- Notif cliente comenta ticket --}}
                        @elseif ($item->type == 'App\Notifications\TicketAgenteComentarioNotification')
                            <x-dropdown-link href="{{ route('tck.ver', ['id' => $item->data['tckId']]) }}"
                                wire:click="leerNoti({{ $item }})" class="mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-4 h-4">
                                    <path fill-rule="evenodd"
                                        d="M10 3c-4.31 0-8 3.033-8 7 0 2.024.978 3.825 2.499 5.085a3.478 3.478 0 01-.522 1.756.75.75 0 00.584 1.143 5.976 5.976 0 003.936-1.108c.487.082.99.124 1.503.124 4.31 0 8-3.033 8-7s-3.69-7-8-7zm0 8a1 1 0 100-2 1 1 0 000 2zm-2-1a1 1 0 11-2 0 1 1 0 012 0zm5 1a1 1 0 100-2 1 1 0 000 2z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="text-sm">{{ __('Hola') }} "{{ $item->data['asignado'] }}",
                                    "{{ $item->data['cliente'] }}",
                                    {{ __('ha realizado un nuevo comentario para el ticket #') }}{{ $item->data['tckId'] }}
                                    {{ $item->data['fecha'] }}</div>
                            </x-dropdown-link>
                            {{-- Notif agente comenta ticket --}}
                        @elseif ($item->type == 'App\Notifications\TicketClienteComentarioNotification')
                            <x-dropdown-link href="{{ route('tck.ver', ['id' => $item->data['tckId']]) }}"
                                wire:click="leerNoti({{ $item }})" class="mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-4 h-4">
                                    <path fill-rule="evenodd"
                                        d="M10 3c-4.31 0-8 3.033-8 7 0 2.024.978 3.825 2.499 5.085a3.478 3.478 0 01-.522 1.756.75.75 0 00.584 1.143 5.976 5.976 0 003.936-1.108c.487.082.99.124 1.503.124 4.31 0 8-3.033 8-7s-3.69-7-8-7zm0 8a1 1 0 100-2 1 1 0 000 2zm-2-1a1 1 0 11-2 0 1 1 0 012 0zm5 1a1 1 0 100-2 1 1 0 000 2z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="text-sm">{{ __('Hola') }} "{{ $item->data['cliente'] }}",
                                    "{{ $item->data['asignado'] }}",
                                    {{ __('ha realizado un nuevo comentario para el ticket #') }}{{ $item->data['tckId'] }}
                                    {{ $item->data['fecha'] }}</div>
                            </x-dropdown-link>
                            {{-- Notif Admin/Supervisor/Jefe de área commentan ticket --}}
                        @elseif ($item->type == 'App\Notifications\TicketComentarioNotification')
                            <x-dropdown-link href="{{ route('tck.ver', ['id' => $item->data['tckId']]) }}"
                                wire:click="leerNoti({{ $item }})" class="mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-4 h-4">
                                    <path
                                        d="M3.505 2.365A41.369 41.369 0 019 2c1.863 0 3.697.124 5.495.365 1.247.167 2.18 1.108 2.435 2.268a4.45 4.45 0 00-.577-.069 43.141 43.141 0 00-4.706 0C9.229 4.696 7.5 6.727 7.5 8.998v2.24c0 1.413.67 2.735 1.76 3.562l-2.98 2.98A.75.75 0 015 17.25v-3.443c-.501-.048-1-.106-1.495-.172C2.033 13.438 1 12.162 1 10.72V5.28c0-1.441 1.033-2.717 2.505-2.914z" />
                                    <path
                                        d="M14 6c-.762 0-1.52.02-2.271.062C10.157 6.148 9 7.472 9 8.998v2.24c0 1.519 1.147 2.839 2.71 2.935.214.013.428.024.642.034.2.009.385.09.518.224l2.35 2.35a.75.75 0 001.28-.531v-2.07c1.453-.195 2.5-1.463 2.5-2.915V8.998c0-1.526-1.157-2.85-2.729-2.936A41.645 41.645 0 0014 6z" />
                                </svg>
                                @if ($item->data['permiTie'] == 1)
                                    <div class="text-sm">{{ __('El usuario') }} "{{ $item->data['userEs'] }}",
                                        {{ __('ha realizado un nuevo comentario para el ticket #') }}{{ $item->data['tckId'] }}
                                        {{ $item->data['fecha'] }}</div>
                                @elseif ($item->data['permiTie'] == 2)
                                    <div class="text-sm">{{ __('El supervisor') }} "{{ $item->data['userEs'] }}",
                                        {{ __('ha realizado un nuevo comentario para el ticket #') }}{{ $item->data['tckId'] }}
                                        {{ $item->data['fecha'] }}</div>
                                @elseif ($item->data['permiTie'] == 7)
                                    <div class="text-sm">{{ __('El jefe de área') }} "{{ $item->data['userEs'] }}",
                                        {{ __('ha realizado un nuevo comentario para el ticket #') }}{{ $item->data['tckId'] }}
                                        {{ $item->data['fecha'] }}</div>
                                @endif
                            </x-dropdown-link>
                            {{-- Notif si se reabrio el ticket --}}
                        @elseif ($item->type == 'App\Notifications\TicketReAbiertoNotification')
                            <x-dropdown-link href="{{ route('tck.ver', ['id' => $item->data['tckId']]) }}"
                                wire:click="leerNoti({{ $item }})" class="mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-4 h-4">
                                    <path fill-rule="evenodd"
                                        d="M14.5 1A4.5 4.5 0 0010 5.5V9H3a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-1.5V5.5a3 3 0 116 0v2.75a.75.75 0 001.5 0V5.5A4.5 4.5 0 0014.5 1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="text-sm">{{ __('El usuario') }} "{{ $item->data['userEs'] }}",
                                    {{ __('ha Abierto nuevamente el ticket #') }}{{ $item->data['tckId'] }}
                                    {{ $item->data['fecha'] }}</div>
                            </x-dropdown-link>
                        @elseif ($item->type == 'App\Notifications\TicketReasignadoNotification')
                            <x-dropdown-link href="{{ route('tck.ver', ['id' => $item->data['tckId']]) }}"
                                wire:click="leerNoti({{ $item }})" class="mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-4 h-4">
                                    <path fill-rule="evenodd"
                                        d="M15.312 11.424a5.5 5.5 0 01-9.201 2.466l-.312-.311h2.433a.75.75 0 000-1.5H3.989a.75.75 0 00-.75.75v4.242a.75.75 0 001.5 0v-2.43l.31.31a7 7 0 0011.712-3.138.75.75 0 00-1.449-.39zm1.23-3.723a.75.75 0 00.219-.53V2.929a.75.75 0 00-1.5 0V5.36l-.31-.31A7 7 0 003.239 8.188a.75.75 0 101.448.389A5.5 5.5 0 0113.89 6.11l.311.31h-2.432a.75.75 0 000 1.5h4.243a.75.75 0 00.53-.219z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="text-sm">{{ _('Hola') }} "{{ $item->data['asignado'] }}",
                                    {{ __('el usuario') }} "{{ $item->data['userEs'] }}"
                                    {{ __('te ha reasignado el ticket #') }}{{ $item->data['tckId'] }}
                                    {{ $item->data['fecha'] }}</div>
                            </x-dropdown-link>
                        @elseif ($item->type == 'App\Notifications\TareaAsignadaNotification')
                            <x-dropdown-link href="{{ route('tck.tarea', ['id' => $item->data['tckId']]) }}"
                                wire:click="leerNoti({{ $item }})" class="mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-4 h-4">
                                    <path fill-rule="evenodd"
                                        d="M15.312 11.424a5.5 5.5 0 01-9.201 2.466l-.312-.311h2.433a.75.75 0 000-1.5H3.989a.75.75 0 00-.75.75v4.242a.75.75 0 001.5 0v-2.43l.31.31a7 7 0 0011.712-3.138.75.75 0 00-1.449-.39zm1.23-3.723a.75.75 0 00.219-.53V2.929a.75.75 0 00-1.5 0V5.36l-.31-.31A7 7 0 003.239 8.188a.75.75 0 101.448.389A5.5 5.5 0 0113.89 6.11l.311.31h-2.432a.75.75 0 000 1.5h4.243a.75.75 0 00.53-.219z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="text-sm">{{ _('Hola') }} "{{ $item->data['asignado'] }}",
                                    {{ __('el usuario') }} "{{ $item->data['userEs'] }}"
                                    {{ __('te ha creado la tarea #') }}{{ $item->data['tareaId'] }}
                                    {{ __('en  el ticket #') }}{{ $item->data['tckId'] }}
                                    {{ $item->data['fecha'] }}</div>
                            </x-dropdown-link>
                        @elseif ($item->type == 'App\Notifications\TareaComentarioNotification')
                            <x-dropdown-link href="{{ route('tck.tarea', ['id' => $item->data['tckId']]) }}"
                                wire:click="leerNoti({{ $item }})" class="mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-4 h-4">
                                    <path fill-rule="evenodd"
                                        d="M15.312 11.424a5.5 5.5 0 01-9.201 2.466l-.312-.311h2.433a.75.75 0 000-1.5H3.989a.75.75 0 00-.75.75v4.242a.75.75 0 001.5 0v-2.43l.31.31a7 7 0 0011.712-3.138.75.75 0 00-1.449-.39zm1.23-3.723a.75.75 0 00.219-.53V2.929a.75.75 0 00-1.5 0V5.36l-.31-.31A7 7 0 003.239 8.188a.75.75 0 101.448.389A5.5 5.5 0 0113.89 6.11l.311.31h-2.432a.75.75 0 000 1.5h4.243a.75.75 0 00.53-.219z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="text-sm">{{ _('Hola') }} "{{ $item->data['asignado'] }}",
                                    {{ __('el usuario') }} "{{ $item->data['userEs'] }}"
                                    {{ __('ha realizado un comentario en la tarea #') }}{{ $item->data['tareaId'] }}
                                    {{ __('en  el ticket #') }}{{ $item->data['tckId'] }}
                                    {{ $item->data['fecha'] }}</div>
                            </x-dropdown-link>
                        @endif

                        @if ($loop->last)
                            <div class="border-t border-gray-100 dark:border-gray-700"></div>
                            <div class="text-center">
                                @if (Auth::user()->unreadNotifications->count() == 1)
                                    <button wire:click="leerTodo({{ $item->notifiable_id }})"
                                        class="text-xs justify-items-center content-center items-center text-gray-400">Marcar
                                        Como Leida</button>
                                @else
                                    <button wire:click="leerTodo({{ $item->notifiable_id }})"
                                        class="text-xs justify-items-center content-center items-center text-gray-400">Marcar
                                        Como Leidas</button>
                                @endif
                            </div>
                        @endif
                    @empty
                        <img src="{{ asset('img/logo/emptystate.svg') }}" style="max-width: 190px"
                            alt="Buzón Vacío">
                    @endforelse
                </div>
            </x-slot>

        </x-dropdown>
        {{-- Notificaciones --}}

        <!-- Teams Dropdown -->
        @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
            <x-dropdown align="right" width="60">
                <x-slot name="trigger">
                    <button type="button"
                        class="inline-flex items-center rounded-md p-2 text-sm font-medium text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none focus:ring focus:ring-purple-500 focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark-eval-1 dark:text-gray-400 dark:hover:text-gray-200">
                        {{ Auth::user()->currentTeam->name }}

                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="w-60">
                        <!-- Team Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Team') }}
                        </div>

                        <!-- Team Settings -->
                        <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                            {{ __('Team Settings') }}
                        </x-dropdown-link>

                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <x-dropdown-link href="{{ route('teams.create') }}">
                                {{ __('Create New Team') }}
                            </x-dropdown-link>
                        @endcan

                        <div class="border-t border-gray-100 dark:border-gray-700"></div>

                        <!-- Team Switcher -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-switchable-team :team="$team" />
                        @endforeach
                    </div>
                </x-slot>
            </x-dropdown>
        @endif

        <!-- Settings Dropdown -->
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <span class="inline-flex rounded-md">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <button
                            class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                            @if (Auth::user()->profile_photo_path)
                                <img class="h-8 w-8 rounded-full object-cover"
                                    src="/storage/{{ Auth::user()->profile_photo_path }}"
                                    alt="{{ Auth::user()->name }}" />
                            @else
                                <img class="h-8 w-8 rounded-full object-cover"
                                    src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            @endif
                        </button>
                        {{-- @else --}}
                        {{-- Here goes the span tag if you want quit the profile picture --}}
                        <button type="button"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-white dark:hover:text-gray-300 bg-white dark:bg-transparent hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                            {{ Auth::user()->name }}

                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                </span>
                @endif
            </x-slot>

            <x-slot name="content">
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Administrar Cuenta') }}
                </div>

                <x-dropdown-link href="{{ route('profile.show') }}">
                    {{ __('Perfil') }}
                </x-dropdown-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-dropdown-link href="{{ route('api-tokens.index') }}">
                        {{ __('API Tokens') }}
                    </x-dropdown-link>
                @endif

                <div class="border-t border-gray-100 dark:border-gray-700"></div>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar sesión') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>
