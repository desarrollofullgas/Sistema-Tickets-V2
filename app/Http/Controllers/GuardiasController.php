<?php

namespace App\Http\Controllers;

use App\Models\Guardia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuardiasController extends Controller
{
    public function home(){
        $valid = Auth::user()->permiso->panels->where('id', 25)->first();
        $orden=Guardia::paginate(10);
         if (Auth::user()->permiso->id == 1) {
            return view('modules.usuarios.guardias.guardiasOrden',compact('orden','valid'));
          } elseif ($valid->pivot->re == 1) {
            return view('modules.usuarios.guardias.guardiasOrden',compact('orden','valid'));
          }else {
              return redirect()->route('dashboard');
          }
    }
}
