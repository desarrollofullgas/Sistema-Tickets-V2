<?php

namespace App\Http\Controllers;

use App\Models\Areas;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicioController extends Controller
{
    public $filterSoli;
    public $areas;

    public function home(Request $request)
    {
        $valid = Auth::user()->permiso->panels->where('id', 18)->first();

       
        $trashed = Servicio::onlyTrashed()->count();
          if (Auth::user()->permiso->id == 1) {
            return view('modules.servicios.servicios', compact( 'trashed','valid'));
       } elseif ($valid->pivot->re == 1) {
            return view('modules.servicios.servicios', compact( 'trashed','valid'));
       } else {
           return redirect()->route('dashboard');
       }
    }


    public function trashed_servicios()
    {
        // $valid = Auth::user()->permiso->panels->where('id', 7)->first();
        $trashed = Servicio::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.servicios.serviciostrashed", [
            "trashed" => $trashed
        ]);
    }

    public function do_restore()
    {
        $servicio = Servicio::withTrashed()->find(request()->id);
        if ($servicio == null) {
            abort(404);
        }
        $servicio->status = 'Activo';
        $servicio->restore();
        return redirect()->route('servicios');
    }

    public function delete_permanently()
    {
        $servicio = Servicio::withTrashed()->find(request()->id);
        if ($servicio == null) {
            abort(404);
        }

        $servicio->forceDelete();
        return redirect()->route('servicios');
    }
}
