<?php

namespace App\Http\Controllers;

use App\Models\Areas;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AreaController extends Controller
{
    public function home(Request $request)
    {

        $valid = Auth::user()->permiso->panels->where('id', 6)->first();
        $trashed = Areas::onlyTrashed()->count();
        
        if (Auth::user()->permiso->id == 1) {
            return view('modules.areas.areas', compact('valid','trashed'));
        } elseif ($valid->pivot->re == 1) {
            return view('modules.areas.areas', compact('valid','trashed'));
        }else {
            return redirect()->route('dashboard');
        }
    }


    public function trashed_areas()
    {
        // $valid = Auth::user()->permiso->panels->where('id', 7)->first();
        $trashed = Areas::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.areas.areastrashed", [
            "trashed" => $trashed,

        ]);
    }

    public function do_restore()
    {
        $area = Areas::withTrashed()->find(request()->id);
        if ($area == null) {
            abort(404);
        }
        $area->status = 'Activo';
        $area->restore();
        return redirect()->route('areas');
    }

    public function delete_permanently()
    {
        $area = Areas::withTrashed()->find(request()->id);
        if ($area == null) {
            abort(404);
        }

        $area->forceDelete();
        return redirect()->route('areas');
    }
}
