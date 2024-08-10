<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManualController extends Controller
{
    public function show()
    {
        $valid = Auth::user()->permiso->panels->where('id', 20)->first();
        
        if (Auth::user()->permiso->id == 1) {
            return view('modules.sistema.manuales.index', ['val' => $valid]);
        } elseif ($valid->pivot->re == 1) {
            return view('modules.sistema.manuales.index', ['val' => $valid]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function index()
    {
        $valid = Auth::user()->permiso->panels->where('id', 24)->first();
         if (Auth::user()->permiso->id == 1) {
            return view('modules.horarios.index', compact('valid'));
        } elseif ($valid->pivot->re == 1) {
            return view('modules.horarios.index', compact('valid'));
        } else {
            return redirect()->route('dashboard');
        }
    }
}
