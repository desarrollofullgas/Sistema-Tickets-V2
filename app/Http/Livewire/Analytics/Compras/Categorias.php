<?php

namespace App\Http\Livewire\Analytics\Compras;

use App\Models\Categoria;
use Carbon\Carbon;
use Livewire\Component;

class Categorias extends Component
{
    public $categorias,$mes,$data=[],$labels=[];
    public function mount(){
        $dia=Carbon::now();
        $this->categorias=Categoria::all();
        foreach($this->categorias as $categoria){
            $cont=0;
            foreach($categoria->productos as $producto){
                $cont+=$producto->compras->whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
            }
            array_push($this->labels,$categoria->name);
            array_push($this->data,$cont);
        }
    }
    public function updateData(){
        $this->data = [];
        $this->labels = [];
        $dia=Carbon::create($this->mes);
        foreach($this->categorias as $categoria){
            $cont=0;
            foreach($categoria->productos as $producto){
                $cont+=$producto->compras->whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
            }
            array_push($this->labels,$categoria->name);
            array_push($this->data,$cont);
        }
        $this->emit('updateChart');
    }
    public function render()
    {
        return view('livewire.analytics.compras.categorias');
    }
}
