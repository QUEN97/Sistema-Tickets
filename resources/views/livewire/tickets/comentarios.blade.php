<div class="col-md-4 col-sm-6 col-6 d-flex justify-content-end justify-content-md-end justify-content-sm-end">
    <div>
        <x-button class="tooltip" wire:click="$set('modal',true)">
            {{ __('Comentar') }}
            <span class="tooltiptext">Comentar</span>
        </x-button>
    </div>

    <x-dialog-modal wire:model="modal" id="modalRepuesto" class="flex items-center">
        <x-slot name="title">
            {{ __('Comentarios') }}
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-wrap gap-3 justify-evenly items-center">
                <div>
                    <x-label value="{{ __('Status del ticket') }}" for="status"/>
                    <select wire:model="status" name="status" id="status"
                        class=" border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        <option hidden value="" selected>Seleccionar status</option>
                        <option value="En proceso">En proceso</option>
                        <option value="Cerrado">Cerrado</option>
                    </select>
                    <x-input-error for="status"></x-input-error>
                </div>
            </div>
            <div class="w-full">
                <x-label value="{{ __('Mensaje') }}" for="mensaje" />
                <textarea wire:model="mensaje"
                        class="resize-none w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700 {{ $errors->has('mensaje') ? 'is-invalid' : '' }} resize-none"
                        name="mensaje" required autofocus autocomplete="mensaje">
                </textarea>
                <x-input-error for="mensaje"></x-input-error>
            </div>
            <div class="mb-3 col-12 w-full"
                    x-data="{ isUploading: false, progress: 0 }"
                    x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false"
                    x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">

                <x-label value="{{ __('Evidencias') }}" class="border-b border-gray-400 w-full text-left mb-2"/>
                <input type="file" wire:model="evidencias" class="flex flex-wrap file:text-sm file:font-semibold file:bg-blue-300 file:text-blue-700 hover:file:bg-blue-100 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0"
                multiple name="evidencias" required autocomplete="evidencias" accept="image/*, .pdf, .doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                <x-input-error for="evidencias"></x-input-error>

                <!-- Progress Bar -->
                <div wire:loading wire:target="evidencias"></div>
                <div class="progress" x-show="isUploading" id="archivoRemis">
                    <div class="relative pt-1">
                        <div class="flex mb-2 items-center justify-between">
                            <div>
                                <span
                                    class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-red-600 bg-red-200">
                                    Subiendo...
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-semibold inline-block text-red-300">
                                    50%
                                </span>
                            </div>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-300">
                            <div style="width: 10%"
                                class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500">
                            </div>
                            <div style="width: 15%"
                                class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-600">
                            </div>
                            <div style="width: 25%"
                                class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-700">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addCom({{$ticketID}})" wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$set('modal',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>