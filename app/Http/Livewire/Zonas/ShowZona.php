<?php

namespace App\Http\Livewire\Zonas;

use App\Models\Estacion;
use App\Models\Producto;
use App\Models\User;
use App\Models\Zona;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowZona extends Component
{
    public $ShowgZona, $db, $dbsup;
    public $zona_show_id, $gerent, $supervi;
    public $name, $ubicacion, $created_at, $gerentes, $estacions, $status;

    public function mount()
    {
        $this->ShowgZona = false;
    }

    public function confirmShowZona(int $id)
    {
        $zona = Zona::where('id', $id)->first();

        $this->zona_show_id = $id;
        $this->name = $zona->name;
        $this->created_at = Carbon::parse($zona['created_at'])->isoFormat('D MMMM Y  h:mm:ss A ');

        foreach ($zona->users as $lue) {
            if ($lue->permiso_id == 3) {
                $this->gerentes = $zona->users->count();
            } else {
                $this->gerentes = 0;
            }
        }

        $this->db = User::join('user_zona as uz', 'users.id', 'uz.user_id')->where('uz.zona_id', $this->zona_show_id)
            ->where('users.permiso_id', 3)->select('users.*')->count();
        $this->dbsup = User::join('user_zona as uz', 'users.id', 'uz.user_id')->where('uz.zona_id', $this->zona_show_id)
            ->where('users.permiso_id', 2)->select('users.*')->count();
        // dd($this->db);
        if ($this->db != 0) {
            $this->gerent = $this->db;
        } else {
            $this->gerent = "Sin Gerentes en esta Zona.";
        }
        if ($this->dbsup != 0) {
            $this->supervi = $this->dbsup;
        } else {
            $this->supervi = "Sin Supervisores en esta Zona.";
        }


        if (Auth::user()->permiso_id == 2) {
            $this->estaciones = $zona->estacions->where('supervisor_id', Auth::user()->id)->count();
        } else {
            $this->estaciones = $zona->estacions->count();
        }
        if ($this->estaciones != 0) {
            $this->estacions = $this->estaciones;
        } else {
            $this->estacions = "Sin Estaciones en esta Zona.";
        }



        $this->status = $zona->status;

        $this->ShowgZona = true;
    }

    public function render()
    {
        $this->users = User::join('user_zona as uz', 'users.id', 'uz.user_id')->where('uz.zona_id', $this->zona_show_id)
            ->where('users.permiso_id', 3)->select('users.*')->get();
        $this->estaciones = Estacion::where('zona_id', $this->zona_show_id)->get();

        $this->isSuper = User::join('user_zona as uz', 'users.id', 'uz.user_id')->where('uz.zona_id', $this->zona_show_id)
            ->where('users.permiso_id', 2)->select('users.*')->get();
       

        return view('livewire.zonas.show-zona');
    }
}
