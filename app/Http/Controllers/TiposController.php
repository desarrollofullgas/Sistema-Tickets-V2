<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TiposController extends Controller
{
    public function home(Request $request){
        $valid = Auth::user()->permiso->panels->where('id', 19)->first();
        
        $trashed = Tipo::onlyTrashed()->count();
       if (Auth::user()->permiso->id == 1) {
            return view('modules.tipos.tipos',compact('trashed','valid'));
      } elseif ($valid->pivot->re == 1) {
            return view('modules.tipos.tipos',compact('trashed','valid'));
      } else {
          return redirect()->route('dashboard');
      }
    }


    public function trashed_tipos()
    {
        // $valid = Auth::user()->permiso->panels->where('id', 7)->first();
        $trashed = Tipo::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.tipos.tipostrashed", [
            "trashed" => $trashed
        ]);
    }

    public function do_restore()
{
    $tipo = Tipo::withTrashed()->find(request()->id);
    if ($tipo == null)
    {
        abort(404);
    }
    $tipo->status='Activo';
    $tipo->restore();
    return redirect()->route('tipos');
}

public function delete_permanently()
{
    $tipo = Tipo::withTrashed()->find(request()->id);
    if ($tipo == null)
    {
        abort(404);
    }
 
    $tipo->forceDelete();
    return redirect()->route('tipos');
}
}
