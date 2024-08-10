<?php

namespace App\Http\Livewire\Visitas;

use App\Models\ArchivosVisita;
use App\Models\Estacion;
use App\Models\Falla;
use App\Models\User;
use App\Models\Visita;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditVisit extends Component
{
    public $visitaID;
    public $modal=false,$fecha,$estacion,$usuario,$status,$solicita,$motivo;
    public $userIds = [];
    public $estacions,$superEsta,$users,$solicitan;
    public $fallasUpdate = [],$fallas; //es una propiedad pública que almacena un array vacío y se utiliza para actualizar las fallas de la visita.
    public $evidencias=[],$evidenciaArc,$urlArchi;

    public function mount(){

        $visita = Visita::find($this->visitaID);
        $this->fecha=$visita->fecha_programada;
        $this->estacion=$visita->estacion->id;
        $this->solicita=$visita->solicita->id;

        foreach ($visita->usuario as $user) {
            $this->userIds[] = User::where('id', $user->id)->value('id');
        }
        $this->usuario = $this->userIds;
        //dd($this->usuario);

        $arraycollectID = [];//Se recopilan los IDs de las areas asociadas al usuario en un array
        $fallasArray = DB::table('visita_fallas')->where('visita_id', $visita->id)->get();
        foreach ($fallasArray as $falla) { //utilizando una consulta de base de datos y un bucle foreach. Los IDs se almacenan en el atributo $fallasUpdate.

            $arraycollectID[] = $falla->falla_id;
        }
        $this->fallasUpdate = $arraycollectID; //Esto se utiliza para mostrar y mantener las areas seleccionadas por el usuario en el formulario de edición.

        $this->status=$visita->status;
        $this->motivo=$visita->motivo_visita;

        $this->estacions = Estacion::where('status','Activo')->get();
        $this->superEsta = Estacion::where('status', 'Activo')->where('supervisor_id', Auth::user()->id)->get();
        $this->users = User::where('status','Activo')->whereNotIn('permiso_id',[3,4,6])->get();
        $this->solicitan = User::where('status','Activo')->whereNotIn('permiso_id',[4,6])->get();
        $this->fallas = Falla::where('status','Activo')->where('servicio_id', 23)->get();
    }
    public function updateVisita(Visita $visita){
       
        $visita = Visita::find($this->visitaID);
        //actualizamos los datos del ticket en la base de datos
        $visita->fecha_programada=$this->fecha;
        $visita->estacion_id=$this->estacion;
        $visita->solicita_id=$this->solicita;
        $visita->status=$this->status;
        $visita->motivo_visita=$this->motivo;
        $visita->save();

        if (count($this->evidencias) >0){
            foreach ($this->evidencias as $lue) {
                $this->urlArchi = $lue->store('visitas/evidencias', 'public');
                $archivo=new ArchivosVisita();
                $archivo->visita_id=$visita->id;
                $archivo->nombre_archivo=$lue->getClientOriginalName();
                $archivo->mime_type=$lue->getMimeType();
                // $archivo->size=$lue->getSize();
                $archivo->archivo_path=$this->urlArchi;
                $archivo->save();
            }
        }

        if (isset($visita->fallas)){
            $visita->fallas()->sync($this->fallasUpdate);
            }else{
                $visita->fallas()->sync(array());
            }
            
        //Alert::success('Ticket Actualizado', "La información del ticket ha sido actualizada");
        session()->flash('flash.banner', 'Ticket Actualizado, los cambios en el ticket se han registrado correctamente.');
       session()->flash('flash.bannerStyle', 'success');
        //return redirect()->route('tickets');
        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.visitas.edit-visit');
    }
}
