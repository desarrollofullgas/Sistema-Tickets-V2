<?php

namespace App\Http\Livewire\Correos\Asignados;

use App\Models\Categoria;
use App\Models\CorreosCompra;
use App\Models\CorreosServicio;
use App\Models\CorreosZona;
use App\Models\Zona;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class Asignar extends Component
{
    public $modal=false;
    public $tipo,$emails,$correos=[],$tipos,$categoria,$zonas,$zonasAsignadas=[];

    public function mount (){
        $this->emails=CorreosCompra::all(['id','correo']);
        $this->tipos=Categoria::all(['id','name']);
        $this->zonas=Zona::all(['id','name']);
    }
    public function addCorreo(){
        if($this->tipo=='Producto'){
            $this->validate([
                'categoria' =>['required'],
            ],[
                'categoria.required'=> 'Seleccione el tipo de compra',
            ]);
        }
        $this->validate([
            //'categoria' =>['required'],
            'correos'=>['required'],
            'zonasAsignadas'=>['required'],
        ],[
            //'categoria.required'=> 'Seleccione el tipo de compra',
            'correos.required'=> 'Seleccione los correos de destino',
            'zonasAsignadas.required'=>'Seleccione las zonas para este registro'
        ]);
        foreach($this->correos as $correo){
            foreach($this->zonasAsignadas as $zona){
                if ($this->tipo=='Producto') {
                    if(CorreosZona::where([['correo_id',$correo],['zona_id',$zona],['categoria_id',$this->categoria]])->get()->count()==0){
                        $reg=new CorreosZona();
                        $reg->categoria_id=$this->categoria;
                        $reg->zona_id=$zona;
                        $reg->correo_id=$correo;
                        $reg->save();
                    }
                } else {
                    if(CorreosServicio::where([['correo_id',$correo],['zona_id',$zona]])->get()->count()==0){
                        $reg=new CorreosServicio();
                        $reg->zona_id=$zona;
                        $reg->correo_id=$correo;
                        $reg->save();
                    }
                }
                
            }
        }
        // Alert::success('Asignación registrada','Los datos han sido registrados en el sistema');
        session()->flash('flash.banner', 'Asignación registrada','Los datos han sido registrados en el sistema');
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->route('correos.asignados');
    }
    public function render()
    {
        return view('livewire.correos.asignados.asignar');
    }
}