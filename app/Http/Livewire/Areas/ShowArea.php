<?php

namespace App\Http\Livewire\Areas;

use App\Models\Areas;
use App\Models\UserArea;
use Livewire\Component;

class ShowArea extends Component
{
    public $areaID;
    public $modal=false;
    public $area,$users;
    //funcion para obtener los datos del area a mostrar
    public function showArea(Areas $area){
        $this->modal=true;
        $this->area=$area;
        $this->users=UserArea::join('users as u','u.id','user_areas.user_id')->where('area_id',$area->id)->get();
    }
    public function render()
    {
        return view('livewire.areas.show-area');
    }
}