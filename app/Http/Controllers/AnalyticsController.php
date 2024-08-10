<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    public function general(){
        $valid = Auth::user()->permiso->panels->where('id', 26)->first();
        return view('modules.analytics.general', compact('valid'));
    }
    public function users(){
        $valid = Auth::user()->permiso->panels->where('id', 27)->first();
        return view('modules.analytics.users', compact('valid'));
    }
    public function compras(){
        $valid = Auth::user()->permiso->panels->where('id', 28)->first();
        return view('modules.analytics.compras', compact('valid'));
    }
    public function calificaciones() {
        $valid = Auth::user()->permiso->panels->where('id', 29)->first();
        return view('modules.analytics.calificaciones', compact('valid'));
    }
}
