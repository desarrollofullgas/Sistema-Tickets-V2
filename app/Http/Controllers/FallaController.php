<?php

namespace App\Http\Controllers;

use App\Models\Falla;
use App\Models\Prioridad;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FallaController extends Controller
{
    public $filterSoli;
    public $agentes;

    public function home(Request $request){
        $valid = Auth::user()->permiso->panels->where('id', 16)->first();
        
        $trashed = Falla::onlyTrashed()->count();
         if (Auth::user()->permiso->id == 1) {
            return view('modules.fallas.fallas',compact(
                'trashed'
                ,'valid'));
          } elseif ($valid->pivot->re == 1) {
            return view('modules.fallas.fallas',compact(
                'trashed'
                ,'valid'));
          }else {
              return redirect()->route('dashboard');
          }
    }


    public function trashed_fallas()
    {
        // $valid = Auth::user()->permiso->panels->where('id', 7)->first();
        $trashed = Falla::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.fallas.fallastrashed", [
            "trashed" => $trashed
        ]);
    }

    public function do_restore()
{
    $falla = Falla::withTrashed()->find(request()->id);
    if ($falla == null)
    {
        abort(404);
    }
    $falla->status='Activo';
    $falla->restore();
    return redirect()->route('fallas');
}

public function delete_permanently()
{
    $falla = Falla::withTrashed()->find(request()->id);
    if ($falla == null)
    {
        abort(404);
    }
 
    $falla->forceDelete();
    return redirect()->route('fallas');
}
}
