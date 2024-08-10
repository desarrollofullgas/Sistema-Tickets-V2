<?php

namespace App\Http\Livewire\Correos\Lista;

use App\Models\CorreosCompra;
use Livewire\Component;

class EditCorreo extends Component
{
    public $mailID,$correo;
    public function mount(){
        $this->correo=CorreosCompra::find($this->mailID)->correo;
    }
    public function updateCorreo(CorreosCompra $email){
        $this->validate([
            'correo' =>['required','email']
        ],[
            'correo.required' =>'required',
            'correo.email' =>'Ingrese un correo válido'
        ]);
        if(CorreosCompra::where([['id','!=',$this->mailID],['correo',$this->correo]])->count()==0){
            $email->correo=$this->correo;
            $email->save();
            return redirect()->route('correos');
        }else{
            $this->addError('correo','El correo ingresado ya existe');
        }
    }
    public function render()
    {
        return view('livewire.correos.lista.edit-correo');
    }
}