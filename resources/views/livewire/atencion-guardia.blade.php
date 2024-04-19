<div class="fixed left-0 bottom-0 z-40" x-data="{ guardias: true }"
    x-init='
        $watch("guardias", o => {
            if (!o) {
                window.setTimeout(() => (guardias = true), 1000);
            }
        });
        setTimeout(() => guardias = true, 300000)'
    @keydown.window.escape="guardias = false">

    @if ($showPopup)
        <div x-show="guardias"
            class="fixed left-1/2 bottom-20 transform -translate-x-1/2 rounded-lg bg-white dark:bg-dark-eval-2 shadow-2xl w-full sm:w-11/12 md:w-10/12 lg:w-9/12 xl:w-8/12 max-w-screen-lg overflow-hidden"
            x-transition:enter="transition ease-in duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-40"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-40">

            <!-- Elemento SVG decorativo -->
            <div class="absolute -top-10 -right-10 text-red-500 dark:text-dark-eval-0" width="80" height="77">
                <svg width="120" height="119" viewBox="0 0 120 119" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3"
                        d="M6.38128 49.1539C3.20326 32.893 13.809 17.1346 30.0699 13.9566L70.3846 6.07751C86.6455 2.89948 102.404 13.5052 105.582 29.7661L113.461 70.0808C116.639 86.3417 106.033 102.1 89.7724 105.278L49.4577 113.157C33.1968 116.335 17.4384 105.729 14.2604 89.4686L6.38128 49.1539Z"
                        fill="currentColor" />
                </svg>
            </div>

            <!-- Contenido -->
            <div class="relative overflow-hidden px-4 pt-6 sm:px-8 sm:pt-8">
                <div class="flex flex-col items-center pb-6 sm:pb-8">
                    <small class="text-xs sm:text-sm font-semibold">Durante la Guardia</small>
                    <h2 class="text-2xl sm:text-3xl font-bold text-center">RECUERDA QUE...</h2>
                </div>
                <div class="pb-4 sm:pb-6">
                    <p class="text-sm sm:text-base">La <strong class="font-semibold">PRIORIDAD</strong> de atención es para:</p>
                    <ul class="text-xs sm:text-sm list-disc list-inside">
                        <li><strong class="font-semibold">Dispensarios:</strong> Deje de funcionar un dispensario, marque error o no despache.</li>
                        <li><strong class="font-semibold">Facturación:</strong> No permita facturar en ninguno de los medios establecidos.</li>
                        <li><strong class="font-semibold">Fletera:</strong> Correciones de sistema.</li>
                        <li><strong class="font-semibold">Terminales:</strong> Dejen de emitir tickets.</li>
                        <li><strong class="font-semibold">Volumétricos:</strong> Se apague y no encienda, deje de comunicar con los dispensarios o se quede atorado.</li>
                    </ul>
                    <p class="text-xs sm:text-sm">Cualquier otra incidencia <strong class="font-semibold">NO</strong> listada con anterioridad, <strong class="font-semibold">FAVOR</strong> de levantar ticket al siguiente día hábil.</p>
                </div>
            </div>

            <!-- Botones -->
            <div class="w-full flex justify-center items-center border-t border-solid border-gray-200">
                <button class="flex-1 px-4 py-3 text-gray-500 hover:text-white hover:bg-red-500 dark:hover:bg-dark-eval-0 duration-150"
                    wire:click="togglePopup">
                    Enterado
                </button>
            </div>
        </div>
    @endif
</div