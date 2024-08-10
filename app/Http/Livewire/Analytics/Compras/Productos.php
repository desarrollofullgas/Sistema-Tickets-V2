<?php

namespace App\Http\Livewire\Analytics\Compras;

use App\Models\Producto;
use Carbon\Carbon;
use Livewire\Component;

class Productos extends Component
{
    public $comprasProductos,$mes,$data=[],$labels=[];
    public function mount(){
        $dia=Carbon::now();
        $this->comprasProductos=Producto::all();
        foreach($this->comprasProductos as $producto){
                $cont=$producto->compras->whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
                if($cont>0){
                    array_push($this->labels,$producto->name);
                    array_push($this->data,$cont);
                }
        }
    }
    public function updateData(){
        $dia=Carbon::create($this->mes);
        $this->data=[];
        $this->labels=[];
        foreach($this->comprasProductos as $producto){
            $cont=$producto->compras->whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
            if($cont>0){
                array_push($this->labels,$producto->name);
                array_push($this->data,$cont);
            }
        }
        $this->emit('updateChart');
    }
    public function render()
    {
        return view('livewire.analytics.compras.productos');
    }
}
