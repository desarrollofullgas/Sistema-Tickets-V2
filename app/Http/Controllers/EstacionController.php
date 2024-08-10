<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use App\Models\User;
use App\Models\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstacionController extends Controller
{
    public $filterSoli;
    public $zonas;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $trashed = Estacion::onlyTrashed()->count();
        $valid = Auth::user()->permiso->panels->where('id', 8)->first();
        if (Auth::user()->permiso->id == 1) {
            return view('modules.estaciones.estaciones', compact('trashed', 'valid'));
        } elseif ($valid->pivot->re == 1) {
            return view('modules.estaciones.estaciones', compact('trashed', 'valid'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function destroy(Estacion $estacion)
    {
        $estacion->delete();
        return back()->with('eliminar', 'ok');
    }

    public function trashed_estaciones()
    {
        $valid = Auth::user()->permiso->panels->where('id', 8)->first();

        $trashed = Estacion::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.estaciones.estaciontrashed", [
            "trashed" => $trashed,
            'valid' => $valid,
        ]);
    }

    public function do_restore()
    {
        $estacion = Estacion::withTrashed()->find(request()->id);
        if ($estacion == null) {
            abort(404);
        }

        $estacion->restore();
        return redirect()->back();
    }

    public function delete_permanently()
    {
        $estacion = Estacion::withTrashed()->find(request()->id);
        if ($estacion == null) {
            abort(404);
        }

        $estacion->forceDelete();
        return redirect()->back();
    }
}
