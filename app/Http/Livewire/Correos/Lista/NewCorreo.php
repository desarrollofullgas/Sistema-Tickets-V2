<?php

namespace App\Http\Livewire\Correos\Lista;

use App\Models\CorreosCompra;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class NewCorreo extends Component
{
    public $correo;

    public function addCorreo(){
        $this->validate([
            'correo' =>['required','email']
        ],[
            'correo.required' =>'El correo es Obligatorio',
            'correo.email' =>'Ingrese un correo válido'
        ]);
        if(CorreosCompra::where('correo',$this->correo)->get()->count()==0){
            $nuevo=new CorreosCompra();
            $nuevo->correo=$this->correo;
            $nuevo->save();
            Alert::success('Correo añadido','El correo ha sido registrado en el sistema.');
            return redirect()->route('correos');
        }else{
            $this->addError('correo','El correo ingresado ya existe');
        }
    }
    public function render()
    {
        return view('livewire.correos.lista.new-correo');
    }
}