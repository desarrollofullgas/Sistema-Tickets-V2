<?php

namespace App\Http\Livewire\Analytics\Compras;

use App\Models\CompraDetalle;
use App\Models\CompraServicio;
use Carbon\Carbon;
use Livewire\Component;

class Servicios extends Component
{
    public $mes,$data=[],$labels=['productos','Servicios'];
    public function mount(){
        $dia=Carbon::now();
        $cantServ=CompraServicio::whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
        $cantProd=CompraDetalle::whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
        array_push($this->data,$cantProd);
        array_push($this->data,$cantServ);
    }
    public function updateData(){
        $dia=Carbon::create($this->mes);
        $this->data=[];
        $cantServ=CompraServicio::whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
        $cantProd=CompraDetalle::whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()])->count();
        array_push($this->data,$cantProd);
        array_push($this->data,$cantServ);
        $this->emit('updateChart');
    }
    public function render()
    {
        return view('livewire.analytics.compras.servicios');
    }
}
