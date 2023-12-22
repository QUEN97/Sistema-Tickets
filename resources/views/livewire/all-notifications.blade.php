<div class="flex flex-wrap  gap-3 py-3">
    <div class="p-2">
        <span class=" bg-dark-eval-1 p-2 rounded-md text-white text-center mb-2">
            {{ __('Anteriores') }}
        </span>
        <div class="flex flex-wrap  bg-white dark:bg-dark-eval-3 p-4 shadow-lg rounded-md  mb-3 max-h-[320px] overflow-y-auto">
            @if ($notifications->count())
                <ul class="divide-y divide-gray-100">
                    @foreach ($notifications as $notification)
                        <li {{-- wire:click="readNotification('{{ $notification->id }}')"--}} @class(['bg-blue-200' => !$notification->read_at])>
                            {{-- <x-dropdown-link href="{{ $notification->data['url'] }}"> --}}
                                <div class="flex">
                                    <div class="flex-1 ml-4">
                                        @if (isset($notification->data['user']))
                                            <!-- Verifica si la propiedad "user" existe -->
                                            <b>{{ $notification->data['user'] }}</b>
                                        @endif
                                        {{ $notification->data['message'] }}
                                        <div class="flex gap-20">
                                            <span class="block text-sm text-blue-600">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                            @if ($notification->read_at != null)
                                                <div style="display: flex; justify-content: flex-end;">
                                                    <div class="text-sm">
                                                        {{ __('Leído') }}
                                                    </div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="w-5 h-5 text-blue-600">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            @endif
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
                                                    <a href="{{ $notification->data['url'] }}">Ver</a>
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
            {{ $notifications->links() }}
        </div>
    </div>
</div>
