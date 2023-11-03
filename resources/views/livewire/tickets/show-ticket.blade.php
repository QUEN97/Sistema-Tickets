<div class="p-4  overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
    <div class="bg-dark-eval-1 p-1 rounded-md text-white text-center mb-2">
        {{ __('Detalles Ticket') }}
    </div>
    <div>
        <x-label value="{{ __('Servicio') }}" for="servicio" />
        <x-input wire:model="servicio" disabled type="text"
        class="w-full  border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700 dark:text-white"
            name="servicio" required  autocomplete="servicio"/>
        <x-input-error for="servicio"></x-input-error>
    </div>
    <div>
        <x-label value="{{ __('Falla') }}" for="falla" />
        <x-input wire:model="falla" disabled type="text"
        class="w-full  border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700 dark:text-white"
            name="falla" />
        <x-input-error for="falla"></x-input-error>
    </div>
   <div class=" flex flex-wrap gap-1 pb-4"> 
        <div class="w-full">
            <x-label value="{{ __('Asunto') }}" for="asunto" />
            <x-input wire:model="asunto" disabled type="text"
            class="w-full  border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700 dark:text-white"
                name="asunto" required  autocomplete="asunto"/>
            <x-input-error for="asunto"></x-input-error>
        </div>
        <div class="w-full">
            <x-label value="{{ __('Descripción') }}" for="mensaje" />
            <textarea wire:model="mensaje" disabled
                class="w-full resize-none border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('mensaje') ? 'is-invalid' : '' }} " rows="4" cols="50"
                name="mensaje" required  autocomplete="mensaje">
            </textarea>
            <x-input-error for="mensaje"></x-input-error>
        </div>
   </div> 
    <hr>
    @if ($evidenciaArc->count() > 0)
    <div class="flex items-center ml-2 mt-3"> <!-- Agregado el contenedor flex -->
        @if ($evidenciaArc)
            <select name="select" size="1"
                class="block w-full p-1 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                style="width: 150px; font-size: 12px;"
                onChange="window.open(this.options[this.selectedIndex].value,'_blank')">
                <option value="" selected>
                    Evidencias
                </option>
                @foreach ($evidenciaArc as $antigArch)
                    @if ($antigArch->flag_trash == 0)
                        <option
                            value="{{ asset('storage/' . $antigArch->archivo_path) }}">
                            {{ $antigArch->nombre_archivo }}
                        </option>
                    @endif
                @endforeach
            </select>
        @endif
    </div>
@endif
</div>
