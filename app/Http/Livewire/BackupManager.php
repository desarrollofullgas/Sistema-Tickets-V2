<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

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
     // Cambiar el directorio de trabajo actual al directorio raíz de la aplicación Laravel
     chdir(base_path());

     // Ejecutar el comando de backup utilizando exec()
     exec('php artisan backup:run --only-db', $output, $returnVar);
 
     // Verificar si ocurrió un error durante la ejecución
    if ($returnVar !== 0) {
        // Manejar el error
        $errorMessage = implode("\n", $output); // Concatenar la salida de error en un solo mensaje
		dd($errorMessage);
        return redirect(request()->header('Referer'))->with([
            'flash.banner' => "ERROR AL REALIZAR BACKUP: {$errorMessage}",
            'flash.bannerStyle' => 'danger'
        ]);
    } else {
        // Backup realizado con éxito
        return redirect(request()->header('Referer'))->with([
            'flash.banner' => 'BACKUP COMPLETADO CON ÉXITO.',
            'flash.bannerStyle' => 'success'
        ]);
    }
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

        return redirect(request()->header('Referer'))->with([
            'flash.banner' => "BACKUP {$fileName} HA SIDO ELIMINADO.",
            'flash.bannerStyle' => 'danger'
        ]);
    }

    public function render()
    {
        return view('livewire.backup-manager');
    }
}
