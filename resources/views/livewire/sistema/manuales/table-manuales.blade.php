<div class="grid grid-cols-2 gap-4">

    @foreach ($manuals as $tem)
        @foreach ($tem->permisos as $item)
            @if ($item->pivot->permiso_id == Auth::user()->permiso_id)
                <div
                    class="mx-auto mt-2 w-full transform overflow-hidden rounded-lg bg-white dark:bg-dark-eval-1 shadow-md  hover:shadow-lg">
                    <a href="{{ asset('storage/' . $tem->manual_path) }}" target="_blank">
                        <iframe  src="{{ asset('storage/' . $tem->manual_path) }}" width="100%" height="500" title="Manual">
                        </iframe>
                    </a>
                    <div class="p-4">
                        <p class="mb-2 text-base dark:text-gray-300 text-gray-700 font-bold">
                            Leer:
                            <a class="text-sm font-bold text-gray-500 no-underline hover:underline hover:text-blue-700"
                                href="{{ asset('storage/' . $tem->manual_path) }}" target="_blank">
                                {{ __($tem->titulo_manual . ' (') }}
                                @if (strlen($tem->size) == 3)
                                    {{ __(substr($tem->size, 0, 2) . ' ' . 'KB )') }}
                                @elseif (strlen($tem->size) == 4)
                                    {{ __(substr($tem->size, 0, 1) . ' ' . 'KB )') }}
                                @elseif (strlen($tem->size) == 5)
                                    {{ __(substr($tem->size, 0, 2) . ' ' . 'KB )') }}
                                @elseif (strlen($tem->size) == 6)
                                    {{ __(substr($tem->size, 0, 3) . ' ' . 'KB )') }}
                                @elseif (strlen($tem->size) == 7)
                                    {{ __(substr($tem->size, 0, 1) . ' ' . 'MB )') }}
                                @elseif (strlen($tem->size) == 8)
                                    {{ __(substr($tem->size, 0, 2) . ' ' . 'MB )') }}
                                @endif
                            </a>
                        </p>
                        <div class="flex items-center mt-3">
                            <p class="ml-auto font-medium text-xs text-gray-500 dark:text-white">
                                {{ $tem->created_at->locale('es')->isoFormat('D / MMMM / YYYY H:mm:ss a') }}</p>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach

    <x-confirmation-modal wire:model="confirmingManuDeletion">
        <x-slot name="title">
            {{ __('Eliminar') }}
        </x-slot>

        <x-slot name="content">
            {{ __('¿Está seguro que desea eliminar el manual?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingManuDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="deleteManu ({{ $confirmingManuDeletion }})"
                wire:loading.attr="disabled">
                {{ __('Eliminar') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
