<?php
$inspire = App\Models\Inspire::inRandomOrder()->first();
if ($inspire) {
    $message = $inspire->data;
} else {
    $message = "No inspiration found";
}
?>
<div id="alert-border-4" class="flex items-center w-full p-6 text-indigo-800 border border-l-4 border-indigo-300 bg-indigo-50 dark:text-white dark:bg-gray-800 dark:border-indigo-800">
    <h1 class="text-2xl">👋</h1>
    <div class="ml-3">
      <h1 class="text-xl font-extrabold uppercase">{{$slot}}</h1>
      <h6 class="text-sm text-gray-400"> <i>"{{ $message}}"</i> </h6>
    </div>
</div>