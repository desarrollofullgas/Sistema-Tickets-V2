<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegionController extends Controller
{
    public function home(Request $request){
        $valid = Auth::user()->permiso->panels->where('id', 9)->first();
        
        $trashed = Region::onlyTrashed()->count();
        
        if (Auth::user()->permiso->id == 1) {
            return view('modules.regiones.regiones',compact('trashed','valid'));
        } elseif ($valid->pivot->re == 1) {
            return view('modules.regiones.regiones',compact('trashed','valid'));
        } else {
            return redirect()->route('dashboard');
        }
    }


    public function trashed_regiones()
    {
        // $valid = Auth::user()->permiso->panels->where('id', 7)->first();
        $trashed = Region::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.regiones.regionestrashed", [
            "trashed" => $trashed
        ]);
    }

    public function do_restore()
{
    $region = Region::withTrashed()->find(request()->id);
    if ($region == null)
    {
        abort(404);
    }
    $region->status='Activo';
    $region->restore();
    return redirect()->route('regiones');
}

public function delete_permanently()
{
    $region = Region::withTrashed()->find(request()->id);
    if ($region == null)
    {
        abort(404);
    }
 
    $region->forceDelete();
    return redirect()->route('regiones');
}
}
