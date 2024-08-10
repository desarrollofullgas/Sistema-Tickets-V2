<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use App\Models\User;
use App\Models\Visita;
use App\Models\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $valid = Auth::user()->permiso->panels->where('id', 11)->first();
        $trashed = User::onlyTrashed()->count();

        if (Auth::user()->permiso->id == 1) {
            return view('modules.usuarios.usuarios', ['val' => $valid, 'trashed' => $trashed]);
        } elseif ($valid->pivot->re == 1) {
            return view('modules.usuarios.usuarios', ['val' => $valid, 'trashed' => $trashed]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    // public function destroy(User $user)
    // {
    //     $user->delete();
    //     return back()->with('eliminar', 'ok');
    // }

    public function trashed_users()
    {

        $valid = Auth::user()->permiso->panels->where('id', 11 )->first();
        $trashed = User::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.usuarios.usertrashed", [
            "trashed" => $trashed,
            "valid" => $valid,
        ]);
    }

    public function do_restore()
    {
        $user = User::withTrashed()->find(request()->id);
        if ($user == null) {
            abort(404);
        }

        $user->restore();
        return redirect()->back();
    }

    public function delete_permanently()
    {
        $user = User::withTrashed()->find(request()->id);
        if ($user == null) {
            abort(404);
        }

        $user->forceDelete();
        return redirect()->back();
    }
	 public function visita_users(Request $request)
    {
        $this->filterSoli = $request->input('filterSoli') == 'Estación' ? null : $request->input('filterSoli');
        $estacions = Estacion::where('status', 'Activo')->get();
        $superEsta = Estacion::where('status', 'Activo')->where('supervisor_id', Auth::user()->id)->get();
        $userID = Auth::id();
        $estacionesAsignadas = DB::table('visitas')
        ->join('estacions', 'visitas.estacion_id', '=', 'estacions.id')
        ->join('user_visitas', 'visitas.id', '=', 'user_visitas.visita_id')
        ->where('user_visitas.user_id', '=', $userID)
        ->select('estacions.*')
        ->get();
       

        $usuario = User::where('name', 'LIKE', '%' . $request->search . '%')->get();

        //$visitas = Visita::all();
        if (Auth::user()->permiso_id == 1) {
            $visitas = Visita::where(function ($query) use ($request, $usuario) {
                $search = $request->input('search');
                if ($search && $usuario->count() === 0) {
                    $query->where('id', 'LIKE', '%' . $search . '%')
                        ->orWhere('motivo visita', 'LIKE', '%' . $search . '%')
                        ->orWhere('observacion_visita', 'LIKE', '%' . $search . '%');
                } else {
                    $query->whereIn('solicita_id', User::where('name', 'LIKE', '%' . $search . '%')->pluck('id'))
                        ->orWhereIn('estacion_id', Estacion::where('name', 'LIKE', '%' . $search . '%')->pluck('id'));
                }
            })
                ->when($request->has('filter') && $request->input('filter') != '', function ($query) use ($request) {
                    $filterSoli = $request->input('filter');
                    $query->where('estacion_id', $filterSoli);
                })
                ->orderBy('id', 'desc')
                ->orderBy('fecha_programada', 'desc')
                ->paginate(10)
                ->withQueryString();
        }
        if (Auth::user()->permiso_id == 2) {
            $userID = Auth::id();
            $estas = Visita::whereHas('estacion', function ($query) use ($userID) {
                $query->where('supervisor_id', $userID);
            })->pluck('estacion_id');
            //dd($estas);
            $visitas = Visita::where(function ($query) use ($request, $usuario) {
                $search = $request->input('search');
                if ($search && $usuario->count() === 0) {
                    $query->where('id', 'LIKE', '%' . $search . '%')
                        ->orWhere('motivo visita', 'LIKE', '%' . $search . '%')
                        ->orWhere('observacion_visita', 'LIKE', '%' . $search . '%');
                } else {
                    $query->whereIn('solicita_id', User::where('name', 'LIKE', '%' . $search . '%')->pluck('id'))
                        ->orWhereIn('estacion_id', Estacion::where('name', 'LIKE', '%' . $search . '%')->pluck('id'));
                }
            })
                ->when($request->has('filter') && $request->input('filter') != '', function ($query) use ($request) {
                    $filterSoli = $request->input('filter');
                    $query->where('estacion_id', $filterSoli);
                })->where(function ($query) use ($estas, $userID) {
                    $query->whereIn('estacion_id', $estas)
                          ->orWhere('solicita_id', $userID);
                })
                ->orWhere('solicita_id', $userID)
                ->orderBy('id', 'desc')
                ->orderBy('fecha_programada', 'desc')
                ->paginate(10)
                ->withQueryString();
        }
        if (Auth::user()->permiso_id == 3) {
            $gerenEstas = Estacion::where('status', 'Activo')->where('user_id', Auth::user()->id)->first()->id;
            $visitas = Visita::where(function ($query) use ($request, $usuario) {
                $search = $request->input('search');
                if ($search && $usuario->count() === 0) {
                    $query->where('id', 'LIKE', '%' . $search . '%')
                        ->orWhere('motivo visita', 'LIKE', '%' . $search . '%')
                        ->orWhere('observacion_visita', 'LIKE', '%' . $search . '%');
                } else {
                    $query->whereIn('solicita_id', User::where('name', 'LIKE', '%' . $search . '%')->pluck('id'));
                }
            })
                ->where('estacion_id', $gerenEstas)
                ->orderBy('id', 'desc')
                ->orderBy('fecha_programada', 'desc')
                ->paginate(10)
                ->withQueryString();
        }
        if (Auth::user()->permiso_id == 5) {
            $userID = Auth::id();
            $visitas = Visita::where(function ($query) use ($request, $usuario) {
                $search = $request->input('search');
                if ($search && $usuario->count() === 0) {
                    $query->where('id', 'LIKE', '%' . $search . '%')
                        ->orWhere('motivo_visita', 'LIKE', '%' . $search . '%')
                        ->orWhere('observacion_visita', 'LIKE', '%' . $search . '%');
                } 
            })
            ->whereHas('usuario', function ($query) use ($userID) {
                $query->where('user_id', $userID);
            })
            ->orWhere('solicita_id', $userID)
                ->orderBy('id', 'desc')
                ->orderBy('fecha_programada', 'desc')
                ->paginate(10)
                ->withQueryString();
        }
        return view('modules.sistema.visitas.index', ['visitas' => $visitas, 'estacions' => $estacions,
         'superEsta' => $superEsta, 'estacionesAsignadas'=>$estacionesAsignadas]);
    }
}
