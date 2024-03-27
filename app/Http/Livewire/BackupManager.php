<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class BackupManager extends Component
{
    public $backups;

    public function mount()
    {
        // Obtener la lista de backups del directorio de almacenamiento
        $this->backups = collect(Storage::files('Laravel'))->map(function ($file) {
            return basename($file); // Obtener solo el nombre del archivo sin la ruta completa
        });
        //dd($this->backups);
    }
    public function createBackup()
    {
        // Ejecutar el comando de backup
        Artisan::call('backup:run --only-db');

        // Manejo de errores
        $output = Artisan::output();
        dd($output);
        if (strpos($output, 'Backup failed') !== false) {
            // Manejar la falla del backup
            session()->flash('flash.banner', 'BACKUP NO SE HA PODIDO REALIZAR.');
            session()->flash('flash.bannerStyle', 'danger');
        } else {
            // Backup realizado
            session()->flash('flash.banner', 'BACKUP COMPLETADO CON ÉXITO.');
            session()->flash('flash.bannerStyle', 'success');
        }
        // Recargar la lista de backups después de crear uno nuevo
        $this->mount();
    }

    public function downloadBackup($fileName)
    {
        // Descargar el archivo de backup
        return Storage::download("Laravel/{$fileName}");
    }

    public function deleteBackup($fileName)
    {
        // Eliminar el archivo de backup
        Storage::delete("Laravel/{$fileName}");

        // Recargar la lista de backups después de eliminar uno
        $this->mount();
    }

    public function render()
    {
        return view('livewire.backup-manager');
    }
}
