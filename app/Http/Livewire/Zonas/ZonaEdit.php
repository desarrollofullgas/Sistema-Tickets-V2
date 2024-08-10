<?php

namespace App\Http\Livewire\Zonas;

use App\Models\Region;
use App\Models\Zona;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class ZonaEdit extends Component
{
    public $EditZona;
    public $zona_id, $name, $status
    ,$regionsUpdate=[];

    public function resetFilters()
    {
        $this->reset(['name','status']);
    }

    public function mount()
    {
        $this->resetFilters();

        $this->EditZona = false;
    }

    public function confirmZonaEdit(int $id)
    {
        $zona = Zona::where('id', $id)->first();

        $this->zona_id = $id;
        $this->name = $zona->name;
        $this->status = $zona->status;

        $this->EditZona = true;

        $arrayID = [];//Se recopilan los IDs de las zonas asociadas al usuario en un array
        $regionesArray = DB::table('zona_region')->select('region_id')->where('zona_id', $id)->get();
        foreach ($regionesArray as $region) { //utilizando una consulta de base de datos y un bucle foreach. Los IDs se almacenan en el atributo $regionsUpdate.

            $arrayID[] = $region->region_id;
        }
        $this->regionsUpdate = $arrayID;
    }

    public function EditarZona($id)
    {
        $zona = Zona::where('id', $id)->first();

        $this->validate([
            'name' => ['required', 'string', 'max:250'],
            'status' => ['required', 'not_in:0'],
        ],
        [
            'name.required' => 'El Nombre de la Zona es obligatorio',
            'name.string' => 'El Nombre de la Zona debe ser solo Texto',
            'name.max' => 'El Nombre de la Zona no debe ser mayor a 250 caracteres',
            'status.required' => 'El Status es obligatorio'
        ]);

        $zona->forceFill([
            'name' => $this->name,
            'status' => $this->status,
        ])->save();
        if (isset($zona->regions)){
            $zona->regions()->sync($this->regionsUpdate);
            }else{
                $zona->regions()->sync(array());
            }

        $this->mount();
        //Alert::success('Zona Actualizada', "La Zona". ' '.$this->name. ' '. "ha sido actualizada en el sistema");
        session()->flash('flash.banner', 'Zona Actualizada, la zona " ' . $zona->name . ' " ha sido actualizada en el sistema.');
        session()->flash('flash.bannerStyle', 'success');
        //return redirect()->route('zonas');
        return redirect(request()->header('Referer'));
    }
    public function render()
    {
        $regions = Region::where('status', 'Activo')->get(); // Regiones
        return view('livewire.zonas.zona-edit',['regions'=>$regions]);
    }
}
