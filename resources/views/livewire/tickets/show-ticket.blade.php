<div class="p-4  overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
    <div class="bg-dark-eval-1 p-1 rounded-md text-white text-center mb-2">
        {{ __('Detalles Ticket') }}
    </div>
    <div class=" flex gap-2 justify-evenly pb-4">
        <div class="w-full">
            <x-label value="{{ __('Asunto') }}" for="asunto" />
            <x-input wire:model="asunto" type="text" name="asunto" disabled id="asunto"
                class="w-full border-gray-300 dark:bg-slate-800 dark:border-gray-700" required autofocus
                autocomplete="asunto" />
            <x-input-error for="asunto"></x-input-error>
        </div>
        <div class="w-full">
            <x-label value="{{ __('Descripción') }}" for="mensaje" />
            <textarea wire:model="mensaje" disabled
                class="resize-none w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700 {{ $errors->has('mensaje') ? 'is-invalid' : '' }} resize-none"
                name="mensaje" required autofocus autocomplete="mensaje">
            </textarea>
            <x-input-error for="mensaje"></x-input-error>
        </div>
    </div>
    <hr>
    {{-- Evidencias en BD --}}
    <div class="max-h-[150px] overflow-auto">
        @if ($evidenciaArc)
            @if ($evidenciaArc->count() > 0)
                <label class="flex justify-center gap-3 items-center text-white bg-amber-600 p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="16" height="16"
                        viewBox="0 0 576 512">
                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                            d="M384 480h48c11.4 0 21.9-6 27.6-15.9l112-192c5.8-9.9 5.8-22.1 .1-32.1S555.5 224 544 224H144c-11.4 0-21.9 6-27.6 15.9L48 357.1V96c0-8.8 7.2-16 16-16H181.5c4.2 0 8.3 1.7 11.3 4.7l26.5 26.5c21 21 49.5 32.8 79.2 32.8H416c8.8 0 16 7.2 16 16v32h48V160c0-35.3-28.7-64-64-64H298.5c-17 0-33.3-6.7-45.3-18.7L226.7 50.7c-12-12-28.3-18.7-45.3-18.7H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H87.7 384z" />
                    </svg>
                    {{ __('Archivos Almacenados') }}
                </label>
                <div class="flex justyfy-venly flex-wrap gap-3 py-2">
                    @foreach ($evidenciaArc as $antigArch)
                        @if ($antigArch->flag_trash == 0)
                            <div class="p-1">
                                @if (
                                    $antigArch->mime_type == 'image/png' ||
                                        $antigArch->mime_type == 'image/jpg' ||
                                        $antigArch->mime_type == 'image/jpeg' ||
                                        $antigArch->mime_type == 'image/webp')
                                    <a href="{{ asset('storage/' . $antigArch->archivo_path) }}" target="_blank"
                                        data-lightbox="imagenes-edit-{{ $antigArch->repuesto_id }}"
                                        data-title="{{ $antigArch->nombre_archivo }}"  class="text-xs">
                                        <figure class="d-inline-block max-w-[90px]" tabindex="0">
                                            <img class="w-full" src="{{ asset('storage/' . $antigArch->archivo_path) }}">
                                            <p class="break-all">{{ $antigArch->nombre_archivo }}</p>
                                            @if (strlen($antigArch->size) == 4)
                                                <p>
                                                    {{ __(substr($antigArch->size, 0, 1) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($antigArch->size) == 5)
                                                <p>
                                                    {{ __(substr($antigArch->size, 0, 2) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($antigArch->size) == 6)
                                                <p>
                                                    {{ __(substr($antigArch->size, 0, 3) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($antigArch->size) == 7)
                                                <p>
                                                    {{ __(substr($antigArch->size, 0, 1) . ' ' . 'MB') }}
                                                </p>
                                            @elseif (strlen($antigArch->size) == 8)
                                                <p>
                                                    {{ __(substr($antigArch->size, 0, 2) . ' ' . 'MB') }}
                                                </p>
                                            @endif
                                        </figure>
                                    </a>
                                @elseif ($antigArch->mime_type == 'application/pdf')
                                    <a href="{{ asset('storage/' . $antigArch->archivo_path) }}" target="_blank"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar"
                                        class="text-xs">
                                        <figure class="d-inline-block max-w-[90px]" tabindex="0" >
                                            <img class="w-100" src="{{ asset('img/icons/pdf.png') }}">
                                            <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
                                            @if (strlen($antigArch->size) == 4)
                                                <p>
                                                    {{ __(substr($antigArch->size, 0, 1) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($antigArch->size) == 5)
                                                <p>
                                                    {{ __(substr($antigArch->size, 0, 2) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($antigArch->size) == 6)
                                                <p>
                                                    {{ __(substr($antigArch->size, 0, 3) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($antigArch->size) == 7)
                                                <p>
                                                    {{ __(substr($antigArch->size, 0, 1) . ' ' . 'MB') }}
                                                </p>
                                            @elseif (strlen($antigArch->size) == 8)
                                                <p>
                                                    {{ __(substr($antigArch->size, 0, 2) . ' ' . 'MB') }}
                                                </p>
                                            @endif
                                        </figure>
                                    </a>
                                @elseif ($antigArch->mime_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                                    <a href="{{ asset('storage/' . $antigArch->archivo_path) }}" target="_blank"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar"
                                        class="text-xs">
                                        <figure class="d-inline-block max-w-[90px]" tabindex="0">
                                            <img class="w-100" src="{{ asset('img/icons/word-2019.svg') }}">
                                            <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
                                            @if (strlen($antigArch->size) == 4)
                                                <p>
                                                    {{ __(substr($antigArch->size, 0, 1) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($antigArch->size) == 5)
                                                <p>
                                                    {{ __(substr($antigArch->size, 0, 2) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($antigArch->size) == 6)
                                                <p>
                                                    {{ __(substr($antigArch->size, 0, 3) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($antigArch->size) == 7)
                                                <p>
                                                    {{ __(substr($antigArch->size, 0, 1) . ' ' . 'MB') }}
                                                </p>
                                            @elseif (strlen($antigArch->size) == 8)
                                                <p>
                                                    {{ __(substr($antigArch->size, 0, 2) . ' ' . 'MB') }}
                                                </p>
                                            @endif
                                        </figure>
                                    </a>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
                    <img src="{{ asset('img/logo/emptystate.svg') }}" style="width: 500px" alt="Buzón Vacío">
                    <span class="">No se encontraron evidencias.</span>
                </div>
            @endif
        @endif
    </div>
</div>
