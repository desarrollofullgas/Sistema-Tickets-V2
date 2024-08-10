<?php

namespace App\Http\Livewire\Usuarios\Guardias;

use App\Models\Guardia;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EditOrden extends Component
{
    public $guardias, $backupData = [], $arrSave = [], $edit = false;
    public function mount()
    {
        $this->guardias = Guardia::select('id', 'user_id', 'status', 'orden')->orderBy('orden', 'ASC')->get();
        //guardamos los datos en caso que el usuario decida no guardar los cambios
        if($this->guardias->count() > 0){
        foreach($this->guardias as $reg){
            array_push($this->backupData,['id' =>$reg->id,'user' =>$reg->user_id,'orden'=>$reg->orden,'status' =>$reg->status]);
        }
    }
        $this->respaldar();
    }
    //respaldamos la información en un array 
    //(esto sirve para el SELECT en caso que se haya editado el status de algún registro)
    public function respaldar()
    {
        foreach ($this->guardias as $key => $user) {
            $this->arrSave[$key] = ['user' => $user->user_id, 'status' => $user->status];
        }
    }

    public function change()
    {
        foreach ($this->arrSave as $respaldo) {
            foreach ($this->guardias as $user) {
                if ($respaldo['user'] == $user->user_id && $respaldo['status'] != $user->status) {
                    $dato = Guardia::find($user->id);
                    $dato->status = $respaldo['status'];
                    $dato->save();
                }
            }
        }
        $this->respaldar();
    }
    //funcion del Drag and Drop (se ejecuta cuando se detecta un cambio)
    public function updateList($list)
    {
        foreach ($list as $item){
            foreach($this->guardias as $user){
                if($item['value']==$user->user_id){
                    $dato=Guardia::find($user->id);
                    $dato->orden=$item['order'];
                    $dato->save();
                }
            }
        }
        $this->respaldar();
    }
     //funcion para devolver los datos a su version base (antes de editar)
     public function restoreData(){
        foreach($this->backupData as $resp){
            if(Guardia::find($resp['id'])){
                $dato=Guardia::find($resp['id']);
                $dato->status= $resp['status'];
                $dato->orden= $resp['orden'];
                $dato->save();
            }else{
                Guardia::create([
                    'id' => $resp['id'],
                    'user_id' =>$resp['user'],
                    'status' =>$resp['status'],
                    'orden' =>$resp['orden']
                ]);
            }
        }
    }
    public function deleteGuardia(Guardia $reg){
        $reg->delete();
        //actualizamos el orden cuando se elimina un usuario
        $newOrden=Guardia::select('id','user_id','status','orden')->orderBy('orden', 'ASC')->get();
        foreach($newOrden as $key=> $orden){
            $reOrden=Guardia::find($orden->id);
            $reOrden->orden=$key+1;
            $reOrden->save();
        }
    }
    public function update()
    {
        $count=Guardia::all();
        //en caso de existir más de un usuario con status 'Esta semana o próximo'
        if($count->where('status','Esta semana')->count()>1){
            $excluir=Guardia::select('id','orden')->where('status','Esta semana')->orderBy('orden', 'ASC')->first();
            foreach($count->where('status','Esta semana') as $user){
                if($user->id != $excluir->id){
                    $update=Guardia::find($user->id);
                    $update->status = 'En espera';
                    $update->save();
                }
            }
        }
        if($count->where('status','Próximo')->count()>1){
            $excluir=Guardia::select('id','orden')->where('status','Próximo')->orderBy('orden', 'ASC')->first();
            foreach($count->where('status','Próximo') as $user){
                if($user->id != $excluir->id){
                    $update=Guardia::find($user->id);
                    $update->status = 'En espera';
                    $update->save();
                }
            }
        }
        Alert::success('Guardia actualizada','los datos se han actalizado');
        return redirect()->route('guardias.home');
    }
    public function render()
    {
        $valid = Auth::user()->permiso->panels->where('id', 25)->first();
        $this->guardias = Guardia::select('id', 'user_id', 'status', 'orden')->orderBy('orden', 'ASC')->get();
        $this->respaldar();
        return view('livewire.usuarios.guardias.edit-orden',['valid'=>$valid]);
    }
}
