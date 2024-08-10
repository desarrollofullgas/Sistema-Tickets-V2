<?php

namespace App\Http\Controllers;

use App\Models\Prioridad;
use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrioridadController extends Controller
{
    public $filterSoli;
    public $tipos;

    public function home(Request $request){
        $valid = Auth::user()->permiso->panels->where('id', 17)->first();
        
        $trashed = Prioridad::onlyTrashed()->count();
        if (Auth::user()->permiso->id == 1) {
           return view('modules.prioridades.prioridades',compact('trashed','valid'));
        } elseif ($valid->pivot->re == 1) {
           return view('modules.prioridades.prioridades',compact('trashed','valid'));
        } else {
            return redirect()->route('dashboard');
        }
    }


    public function trashed_prioridades()
    {
        // $valid = Auth::user()->permiso->panels->where('id', 7)->first();
        $trashed = Prioridad::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.prioridades.prioridadestrashed", [
            "trashed" => $trashed
        ]);
    }

    public function do_restore()
{
    $prioridad = Prioridad::withTrashed()->find(request()->id);
    if ($prioridad == null)
    {
        abort(404);
    }
    $prioridad->status='Activo';
    $prioridad->restore();
    return redirect()->route('prioridades');
}

public function delete_permanently()
{
    $prioridad = Prioridad::withTrashed()->find(request()->id);
    if ($prioridad == null)
    {
        abort(404);
    }
 
    $prioridad->forceDelete();
    return redirect()->route('tipos');
}
}
