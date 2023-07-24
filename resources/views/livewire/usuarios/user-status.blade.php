<div class="w-full max-w-sm flex flex-col mx-auto text-center">
    <div x-data="{ selected: true }" class="w-full rounded bg-white h-auto m-auto shadow flex flex-col p-8 pt-6 rounded-xl">
        <div class="relative w-full mt-4 rounded-md border h-10 p-1 bg-gray-200">
            <div class="relative w-full h-full flex items-center">
                <div @click="selected=!selected" wire:click="toggleStatus" class="w-full flex justify-center text-gray-400 cursor-pointer">
                    <button>ACTIVAR</button>
                </div>
                <div @click="selected=!selected" wire:click="toggleStatus" class="w-full flex justify-center text-gray-400 cursor-pointer">
                    <button>¡A COMER!</button>
                </div>
            </div>
            <input type="checkbox" class="hidden" wire:click="toggleStatus" @if($userStatus === 'Activo') checked @endif>
            <span :class="{ 'left-1/2 -ml-1 text-gray-800':!selected, 'left-1 text-indigo-600 font-semibold':selected }"
                x-text="selected ? 'ACTIVO' : '¡BUEN PROVECHO!'"
            class="bg-white shadow text-sm flex items-center justify-center w-1/2 rounded h-[1.88rem] transition-all duration-150 ease-linear top-[4px] absolute"></span>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.3.0/alpine-ie11.js" integrity="sha512-6m6AtgVSg7JzStQBuIpqoVuGPVSAK5Sp/ti6ySu6AjRDa1pX8mIl1TwP9QmKXU+4Mhq/73SzOk6mbNvyj9MPzQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>