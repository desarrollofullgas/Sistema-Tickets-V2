<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlmacenController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        $valid = Auth::user()->permiso->panels->where('id', 5)->first();

        if (Auth::user()->permiso->id == 1) {
        return view('modules.almacenes.index', ['val' => $valid, 'user' => $user]);
    } elseif ($valid->pivot->re == 1) {
        return view('modules.almacenes.index', ['val' => $valid, 'user' => $user]);
    }else {
        return redirect()->route('dashboard');
    }
}
}
