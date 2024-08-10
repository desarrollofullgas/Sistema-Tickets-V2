<?php

namespace App\Http\Livewire\Sistema\Manuales;

use Livewire\Component;
use App\Models\Manual;
use App\Models\Panel;
use App\Models\Permiso;
use App\Models\ManualPermiso;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class NewManual extends Component
{
    use WithFileUploads;

    public $newgManual, $manual, $categoria,$subcat,$urlArchi,$permisos;
    public $permis = [];

    public function resetFilters()
    {
        $this->reset(['manual', 'categoria','subcat','permis']);
    }

    public function mount()
    {
        $this->permisos = Permiso::all();
        $this->resetFilters();
        $this->newgManual = false;
    }

    public function showModalFormManual()
    {
        $this->resetFilters();
        $this->newgManual=true;
    }

    public function addManual()
    {
        $this->validate( [
            'permis' => ['required'],
            'categoria' => ['required'],
            'subcat' => ['required'],
            'manual' => 'required|max:12288|mimes:pdf,mp4',
        ],
        [
            'permis.required' => 'Debes elegir un permiso',
            'categoria.required' => 'Ingresa la categoría del manual',
            'subcat.required' => 'Ingresa la subcategoría del manual',
            'manual.max' => 'El archivo no debe ser mayor a 12 MB',
            'manual.required' => 'El campo Manual es obligatorio',
            'manual.mimes' => 'El archivo debe ser un PDF o un video MP4',
        ]);

        $this->urlArchi = $this->manual->storeAs('manuales', $this->manual->getClientOriginalName(), 'public');

        DB::transaction(function () {
            return tap(Manual::create([
                'user_id' => Auth::user()->id,
                'titulo_manual' => $this->manual->getClientOriginalName(),
                'categoria'=>$this->categoria,
                'sub_categoria'=>$this->subcat,
                'manual_path' => $this->urlArchi,
                'mime_type' => $this->manual->getMimeType(),
                'size' => $this->manual->getSize(),
                'flag_trash' => 0,
            ]));
        });

        $ultid = Manual::latest('id')->first();

        foreach ($this->permis as $key => $value) {
            ManualPermiso::create([
                'manual_id' => $ultid->id,
                'permiso_id' => $value,
                'flag_trash' => 0,
            ]);
        }

        $this->mount();

        Alert::success('Nuevo Manual', "El Manual". ' '.$ultid->titulo_manual. ' '. "ha sido subido al sistema");

        return redirect()->route('manuales');
    }

    public function render()
    {
        return view('livewire.sistema.manuales.new-manual');
    }
}
