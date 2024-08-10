<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\User;
use App\Models\UserArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TareaController extends Controller
{
    public $filterSoli;
    public $agentes;
    public function home(Request $request)
    {
        $valid = Auth::user()->permiso->panels->where('id', 3)->first();

        // $this->filterSoli = $request->input('filterSoli') == 'Agentes' ? null : $request->input('filterSoli');

        // $agentes = User::where('status', 'Activo')->where('permiso_id', 5)->get();
        // $usuario = User::where('name', 'LIKE', '%' . $request->search . '%')->get();
        // $user = Auth::user();
        // $userId = Auth::user()->id;

        // if (Auth::user()->permiso_id == 1 || Auth::user()->permiso_id == 8) {
        //     $tareasList = Tarea::where(function ($query) use ($request, $usuario) {
        //         $search = $request->input('search');
        //         if ($search && $usuario->count() === 0) {
        //             $query->where('id', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('ticket_id', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('status', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('asunto', 'LIKE', '%' . $search . '%');
        //         } else {
        //             $query->whereIn('user_id', User::where('name', 'LIKE', '%' . $search . '%')->pluck('id'));
        //         }
        //     })
        //         ->when($request->has('filter') && $request->input('filter') != '', function ($query) use ($request) {
        //             $filterSoli = $request->input('filter');
        //             $query->where('user_id', $filterSoli);
        //         })
        //         ->orderBy('id', 'desc')
        //         ->orderBy('fecha_cierre', 'desc')
        //         ->paginate(10)
        //         ->withQueryString();
        // }

        // if (Auth::user()->permiso_id == 4) {
        //     $tareasList = Tarea::where(function ($query) use ($request, $usuario) {
        //         $search = $request->input('search');
        //         if ($search && $usuario->count() === 0) {
        //             $query->where('id', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('ticket_id', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('status', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('asunto', 'LIKE', '%' . $search . '%');
        //         } else {
        //             $query->whereIn('user_id', User::where('name', 'LIKE', '%' . $search . '%')->pluck('id'));
        //         }
        //     })
        //         ->when($request->has('filter') && $request->input('filter') != '', function ($query) use ($request) {
        //             $filterSoli = $request->input('filter');
        //             $query->where('user_id', $filterSoli);
        //         })
        //         ->where('user_asignado', $userId)
        //         ->orderBy('id', 'desc')
        //         ->orderBy('fecha_cierre', 'desc')
        //         ->paginate(10)
        //         ->withQueryString();
        // }

        // if (Auth::user()->permiso_id == 5) {
        //     $tareasList = Tarea::where(function ($query) use ($request, $usuario) {
        //         $search = $request->input('search');
        //         if ($search && $usuario->count() === 0) {
        //             $query->where('id', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('ticket_id', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('status', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('asunto', 'LIKE', '%' . $search . '%');
        //         } else {
        //             $query->whereIn('user_id', User::where('name', 'LIKE', '%' . $search . '%')->pluck('id'));
        //         }
        //     })
        //         ->when($request->has('filter') && $request->input('filter') != '', function ($query) use ($request) {
        //             $filterSoli = $request->input('filter');
        //             $query->where('user_id', $filterSoli);
        //         })
        //         ->where('user_asignado', $userId)
        //         ->orderBy('id', 'desc')
        //         ->orderBy('fecha_cierre', 'desc')
        //         ->paginate(10)
        //         ->withQueryString();
        // }

        // if (Auth::user()->permiso_id == 7) {
        //     $personal=UserArea::whereIn('area_id',$user->areas->pluck('id'))->pluck('user_id');
        //     $tareasList = Tarea::where(function ($query) use ($request, $usuario) {
        //         $search = $request->input('search');
        //         if ($search && $usuario->count() === 0) {
        //             $query->where('id', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('ticket_id', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('status', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('asunto', 'LIKE', '%' . $search . '%');
        //         } else {
        //             $query->whereIn('user_id', User::where('name', 'LIKE', '%' . $search . '%')->pluck('id'));
        //         }
        //     })
        //         ->when($request->has('filter') && $request->input('filter') != '', function ($query) use ($request) {
        //             $filterSoli = $request->input('filter');
        //             $query->where('user_id', $filterSoli);
        //         })
        //         ->whereIn('user_asignado', [$userId, $personal])
        //         ->orderBy('id', 'desc')
        //         ->orderBy('fecha_cierre', 'desc')
        //         ->paginate(10)
        //         ->withQueryString();
        // }
       
        if (Auth::user()->permiso->id == 1) {
             return view('modules.tickets.tareas.tareas-list', compact('valid'));
       } elseif ($valid->pivot->re == 1) {
             return view('modules.tickets.tareas.tareas-list', compact('valid'));
       } else {
           return redirect()->route('dashboard');
       }
    }
}
