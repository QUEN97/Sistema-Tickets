<?php
$inspire = App\Models\Inspire::inRandomOrder()->first();
if ($inspire) {
    $message = $inspire->data;
} else {
    $message = 'No inspiration found';
}
?>
<div id="alert-border-4"
class="flex items-center w-full p-2 text-gray-800 border border-l-4 rounded-md shadow-lg border-gray-300 bg-gray-50 dark:text-white dark:bg-gray-800 dark:border-gray-500">
    <h1 class="text-2xl">👋</h1>
    <div class="ml-3">
        <h1 class="text-xl font-extrabold uppercase">{{ $slot }}</h1>
        <div style="display: flex; align-items: flex-start;">
            <div class="text-sm text-gray-400">
                <i>"{{ $message }}"</i>
            </div>
            <svg id="refresh-button" class="cursor-pointer" width="25" height="25" viewBox="0 0 50 50"
                xmlns="http://www.w3.org/2000/svg">
                <path fill="#000000"
                    d="M25 38c-7.2 0-13-5.8-13-13c0-3.2 1.2-6.2 3.3-8.6l1.5 1.3C15 19.7 14 22.3 14 25c0 6.1 4.9 11 11 11c1.6 0 3.1-.3 4.6-1l.8 1.8c-1.7.8-3.5 1.2-5.4 1.2zm9.7-4.3l-1.5-1.3c1.8-2 2.8-4.6 2.8-7.3c0-6.1-4.9-11-11-11c-1.6 0-3.1.3-4.6 1l-.8-1.8c1.7-.8 3.5-1.2 5.4-1.2c7.2 0 13 5.8 13 13c0 3.1-1.2 6.2-3.3 8.6z" />
                <path fill="#000000" d="M18 24h-2v-6h-6v-2h8zm22 10h-8v-8h2v6h6z" />
            </svg>
        </div>
    </div>
</div>
<script>
    // Array para almacenar los mensages del modelo Inspire
    var messages = <?php echo json_encode(App\Models\Inspire::all()->pluck('data')); ?>;

    // Funcion para obtener los mensajes random
    function getRandomMessage() {
        var randomIndex = Math.floor(Math.random() * messages.length);
        return messages[randomIndex];
    }

    // funcion para refrescar los mensajes al hacer click
    document.getElementById("refresh-button").addEventListener("click", function() {
        var newMessage = getRandomMessage();
        document.querySelector('.text-sm.text-gray-400 i').textContent = '"' + newMessage + '"';
    });
</script>
