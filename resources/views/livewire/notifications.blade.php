<div>
    <x-dropdown align="right" width="80">
        <x-slot name="trigger">
            @if (Auth::user()->unreadNotifications->count() == 0)
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 cursor-pointer text-gray-600 dark:text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
            @else
                <div class="top-0 absolute left-3">
                    <p class="flex h-2 w-2 items-center justify-center rounded-full bg-red-500 p-2 text-xs text-white">
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
            <div class="block px-4 py-2 text-xs text-center text-gray-900 dark:text-white">
                @if (Auth::user()->unreadNotifications->count() == 1)
                    {{ __(Auth::user()->unreadNotifications->count() . ' ' . 'Notificación nueva.') }}
                @else
                    {{ __(Auth::user()->unreadNotifications->count() . ' ' . 'Notificaciones nuevas.') }}
                @endif
            </div>
            <div class="max-h-[320px] overflow-y-auto">
                @if (auth()->user()->notifications->count())
                    <ul class="divide-y divide-gray-100">
                        @foreach (auth()->user()->notifications as $notification)
                            <li wire:click="readNotification('{{ $notification->id }}')" @class(['bg-blue-200' => !$notification->read_at])>
                                <x-dropdown-link href="{{ $notification->data['url'] }}">
                                    <div class="flex">
                                        @if (isset($notification->data['photo']))
                                            <!-- Verifica si la propiedad "photo" existe -->
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ $notification->data['photo'] }}"
                                                alt="{{ $notification->data['user'] }}">
                                        @endif
                                        <div class="flex-1 ml-4">
                                            @if (isset($notification->data['user']))
                                                <b>{{ $notification->data['user'] }}</b>
                                            @endif
                                            {{ $notification->data['message'] }}
                                            <span class="block text-sm text-blue-600">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </x-dropdown-link>
                            </li>
                            <div class="border-t border-gray-100 dark:border-gray-700"></div>
                        @endforeach
                    </ul>
                @else
                    <div>
                        <p align="center"><img src="{{ asset('img/logo/emptystate.svg') }}" style="max-width: 200px"
                                alt="Sin notificaciones"></p>
                    </div>
                @endif
            </div>
            @if (Auth::user()->unreadNotifications->count() >= 1)
                <div class="block px-4 py-2 text-xs text-center text-gray-400">
                    @if (Auth::user()->unreadNotifications->count() == 1)
                        <button wire:click="readAllNotification({{ $notification->notifiable_id }})"
                            class="text-xs justify-items-center content-center items-center text-gray-900 dark:text-white">Marcar
                            Como Leida</button>
                    @else
                        <button wire:click="readAllNotification({{ $notification->notifiable_id }})"
                            class="text-xs justify-items-center content-center items-center text-gray-900 dark:text-white">Marcar
                            Como Leidas</button>
                    @endif
                </div>
            @endif
        </x-slot>
    </x-dropdown>
</div>
