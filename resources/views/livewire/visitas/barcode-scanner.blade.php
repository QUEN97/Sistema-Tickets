<div class="mb-4">
    <input type="text" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
    dark:focus:ring-offset-dark-eval-1 w-full"" wire:model="barcode" wire:keydown.enter="buscarUsuario" placeholder="Escanea el código de barras">
    @if ($usuario)
        <div
            class="w-full mt-4 max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex justify-end px-4 pt-4">
                <span>{{ $usuario->status }}</span>
            </div>
            <div class="flex flex-col items-center pb-10">
                @if ($usuario->profile_photo_path)
                    <img class="w-24 h-24 mb-3 rounded-full shadow-lg"
                        src="{{ Storage::url($usuario->profile_photo_path) }}" alt="{{ $usuario->name }} foto">
                @else
                    <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="{{ $usuario->profile_photo_url }}"
                        alt="{{ $usuario->name }}'s profile photo">
                @endif
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $usuario->name }}</h5>
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $usuario->permiso->titulo_permiso }} </span>
                <div class="flex mt-4 md:mt-6">
                    <x-danger-button class="mr-2" wire:click="updateVisita({{ $visita->id }})" wire:loading.attr="disabled">
                        Registrar Visita
                    </x-danger-button>
                </div>
            </div>
        </div>
    @endif
</div>
