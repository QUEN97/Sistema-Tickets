<div class="flex flex-wrap  gap-3 py-3">
    <div class="p-2">
        <span class=" bg-dark-eval-1 p-2 rounded-md text-white text-center mb-2">
            {{ __('Nuevas') }}
        </span>
        <div
            class="flex flex-wrap  bg-white dark:bg-dark-eval-3 p-4 shadow-lg rounded-md  mb-3 max-h-[320px] overflow-y-auto">
            @if ($notificationsNew->count())
                <ul class="divide-y divide-gray-100">
                    @foreach ($notificationsNew as $notification)
                        <li {{-- wire:click="readNotification('{{ $notification->id }}')" --}} @class([
                            'bg-blue-200 dark:bg-gray-500 rounded-md' => !$notification->read_at,
                        ])>
                            {{-- <x-dropdown-link href="{{ $notification->data['url'] }}"> --}}
                            <div class="flex">
                                <div class="flex-1 ml-4">
                                    @if (isset($notification->data['user']))
                                        <!-- Verifica si la propiedad "user" existe -->
                                        <b>{{ $notification->data['user'] }}</b>
                                    @endif
                                    {{ $notification->data['message'] }}
                                    <div class="flex justify-between items-center">
                                        <span class="block text-sm text-blue-600">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>

                                        <svg width="20" height="20" viewBox="0 0 32 32"
                                            xmlns="http://www.w3.org/2000/svg" class="text-gray-400 items-end">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="m4 17l5 5l12-12m-5 10l2 2l12-12" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex gap-2">
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
                                                <button wire:click="readNotification('{{ $notification->id }}')">Marcar
                                                    como leída</button>
                                                <a href="{{ $notification->data['url'] }}"
                                                    wire:click="readNotification('{{ $notification->id }}')">Ver</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- </x-dropdown-link> --}}
                        </li>
                        <div class="border-t border-gray-100 dark:border-gray-700"></div>
                    @endforeach
                </ul>
            @else
                <div>
                    <p align="center"><img src="{{ asset('img/logo/emptystate.svg') }}" style="max-width: 200px"
                            alt="Sin notificaciones nuevas"></p>
                </div>
            @endif
        </div>
        <div class="mt-3">
            {{ $notificationsNew->links() }}
        </div>
    </div>
</div>
