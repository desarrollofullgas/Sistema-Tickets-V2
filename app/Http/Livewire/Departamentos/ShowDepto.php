<?php

namespace App\Http\Livewire\Departamentos;

use App\Models\Departamento;
use Livewire\Component;

class ShowDepto extends Component
{
    public $modal=false;
    public $deptoID,$depto;
    public function showDepto(Departamento $depto){
        $this->depto = $depto;
        $this->modal=true;
    }
    public function render()
    {
        return view('livewire.departamentos.show-depto');
    }
}