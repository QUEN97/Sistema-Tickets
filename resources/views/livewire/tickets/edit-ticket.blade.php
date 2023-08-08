<div class="p-4  overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
    <div class="bg-dark-eval-1 p-1 rounded-md text-white text-center mb-2">
        {{ __('Editar Ticket') }}
    </div>
    <div class="max-h-[150px] overflow-auto">
        <div class="flex  gap-2 justify-evenly items-center mb-2">
            <div>
                <x-label value="{{ __('Creado') }}" for="creado" />
                <x-input wire:model.defer="creado" type="datetime-local" name="creado" id="creado"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1" />
                <x-input-error for="creado"></x-input-error>
            </div>
            <div>
                <x-label value="{{ __('Vencimiento') }}" for="vence" />
                <x-input wire:model.defer="vence" type="datetime-local" name="vence" id="vence"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1" />
                <x-input-error for="vence"></x-input-error>
            </div>
        </div>
        @if ($this->cerrado != NULL)
            <div class="text-center mb-2">
                <x-label value="{{ __('Cerrado') }}" for="cerrado" />
                <x-input wire:model.defer="cerrado" type="datetime-local" name="cerrado" id="cerrado"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1" />
                <x-input-error for="cerrado"></x-input-error>
            </div>
        @endif
        <div class="flex  gap-2 justify-evenly items-center mb-2">
            <div>
                <x-label value="{{ __('Departamento') }}" for="departamento" />
                <select id="departamento" name="departamento"
                    class="border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700"
                    wire:model.defer="departamento">
                    <option value="">Seleccionar Departamento</option>
                    @foreach ($departamentos as $dep)
                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                    @endforeach
                </select>
                <x-input-error for="departamento"></x-input-error>
            </div>
            <div>
                <x-label value="{{ __('Área') }}" for="area" />
                <select wire:model.defer="area" name="area" id="area"
                    class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                    <option hidden value="" selected>Seleccionar Área</option>
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                    @endforeach
                </select>
                <x-input-error for="area"></x-input-error>
            </div>
        </div>
        <div class="flex gap-2 justify-evenly items-center mb-2">
            @if ($servicios)
                <div>
                    <x-label value="{{ __('Servicio') }}" for="servicio" />
                    <select wire:model.defer="servicio" name="servicio" id="servicio"
                        class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        <option hidden value="" selected>Seleccionar Servicio</option>
                        @foreach ($servicios as $servicio)
                            <option value="{{ $servicio->id }}">{{ $servicio->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="servicio"></x-input-error>
                </div>
            @endif
            @if ($fallas)
                <div>
                    <x-label value="{{ __('Falla') }}" for="falla" />
                    <select wire:model.defer="falla" name="falla" id="falla"
                        class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        <option hidden value="" selected>Seleccionar falla</option>
                        @foreach ($fallas as $falla)
                            <option value="{{ $falla->id }}">{{ $falla->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="falla"></x-input-error>
                </div>
            @endif

        </div>
        <div class="flex gap-2 justify-evenly items-center mb-2">
            @if ($agentes)
                <div>
                    <x-label value="{{ __('Agente') }}" for="personal" />
                    <select wire:model.defer="agente" name="personal" id="personal"
                        class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        <option hidden value="" selected>Seleccionar agente</option>
                        @foreach ($agentes as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="agente"></x-input-error>
                </div>
            @endif
            <div>
                <x-label value="{{ __('Status') }}" />
                <select id="status" wire:model.defer="status"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('status') ? 'is-invalid' : '' }}"
                    name="status" required aria-required="true">
                    <option hidden value="">Seleccionar Status</option>
                    <option value="Abierto" @if ($status == 'Abierto') {{ 'selected' }} @endif>
                        Abierto</option>
                    <option value="En proceso" @if ($status == 'En proceso') {{ 'selected' }} @endif>
                        En proceso</option>
                    <option value="Cerrado" @if ($status == 'Cerrado') {{ 'selected' }} @endif>
                        Cerrado</option>
                        <option value="Por abrir" @if ($status == 'Por abrir') {{ 'selected' }} @endif>
                            Por abrir</option>
                </select>
                <x-input-error for="status"></x-input-error>
            </div>
        </div>
        <div class="flex flex-wrap gap-2 ">
            <div class="w-full">
                <x-label value="{{ __('Asunto') }}" for="asunto" />
                <x-input wire:model.defer="asunto" type="text" name="asunto" id="asunto" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                dark:text-gray-300 dark:focus:ring-offset-dark-eval-1" required
                    autofocus autocomplete="asunto" />
                <x-input-error for="asunto"></x-input-error>
            </div>
            <div class="w-full">
                <x-label value="{{ __('Descripción') }}" for="mensaje" />
                <textarea wire:model.defer="mensaje"
                    class="resize-none w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700 {{ $errors->has('mensaje') ? 'is-invalid' : '' }} resize-none"
                    name="mensaje" required autofocus autocomplete="mensaje">
                            </textarea>
                <x-input-error for="mensaje"></x-input-error>
            </div>
        </div>
    </div>
    <div class="mb-3 col-12 w-full" x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
        x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress">

        <x-label value="{{ __('Subir evidencias') }}" class="border-b border-gray-400 w-full text-left mb-2" />
        <input type="file" wire:model="evidencias"
            class="flex flex-wrap file:text-sm file:font-semibold file:bg-blue-300 file:text-blue-700 hover:file:bg-blue-100 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0"
            multiple name="evidencias" required autocomplete="evidencias"
            accept="image/*, .pdf, .doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
        <x-input-error for="evidencias"></x-input-error>

        <!-- Progress Bar -->
        <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-2.5 mb-2 dark:bg-gray-700">
            <div class="bg-red-600 h-2.5 rounded-full dark:bg-red-500 transition-[width] duration-500"
                x-bind:style="`width:${progress}%`"></div>
        </div>
    </div>

    <x-danger-button class="mr-2 float-right" wire:click="updateTicket({{ $ticketID }})"
        wire:loading.attr="disabled">
        Aceptar
    </x-danger-button>
</div>
