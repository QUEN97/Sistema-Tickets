<div x-data="{ edit: false }" class="w-full">
    <div class="">
        <button @click="edit =!edit" wire:loading.attr="disabled" aria-label="editar ticket" class="tooltip">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-6 h-6 text-gray-400 hover:text-indigo-500 transition duration-300">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
            <span class="tooltiptext">Editar</span>
        </button>
    </div>
    <div wire:sortable="updateList" class="flex flex-col gap-2 ">
        {{-- <ul wire:sortable="updateList" class="flex flex-col gap-2">
            @foreach ($guardias as $usuario)
                <li wire:sortable.item="{{ $usuario->user_id }}" wire:key="task-{{ $usuario->id }}" class="border">
                    <h4 wire:sortable.handle>{{ $usuario->usuario->name }}</h4>
                </li>
            @endforeach
        </ul> --}}
        @foreach ($guardias as $key=>$usuario)
        <div wire:sortable.item="{{ $usuario->user_id }}" wire:key="task-{{ $usuario->id }}" class="flex items-stretch gap-1 w-auto border rounded-md overflow-hidden dark:border-gray-600 " :class="edit && 'shadow-md dark:bg-dark-eval-2 dark:shadow-slate-900/60 '">
            <div wire:sortable.handle class="flex items-center justify-center text-white p-2 bg-gray-300 dark:bg-gray-600 cursor-move" x-show="edit" x-cloak x-transition>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 9H5c-.55 0-1 .45-1 1s.45 1 1 1h14c.55 0 1-.45 1-1s-.45-1-1-1zM5 15h14c.55 0 1-.45 1-1s-.45-1-1-1H5c-.55 0-1 .45-1 1s.45 1 1 1z"/>
                </svg>
            </div>
            <div class="flex-auto p-2 grid justify-items-center items-center grid-cols-[repeat(auto-fit,minmax(200px,1fr))]">
                <div>{{$usuario->orden}}</div>
                <h4>{{ $usuario->usuario->name }}</h4>
                <template x-if="edit==false">
                    <div>{{$usuario->status}}</div>
                </template>
                <div x-show="edit">
                    <select wire:model="arrSave.{{$key}}.status" wire:change="change()" name="status" id="status"
                        class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        <option value="En espera">En espera</option>
                        <option value="Esta semana">Esta semana</option>
                        <option value="Próximo">Próximo</option>
                    </select>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>