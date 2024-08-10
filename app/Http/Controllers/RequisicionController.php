<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Estacion;
use App\Models\Ticket;
use App\Models\UserArea;
use App\Models\UserZona;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequisicionController extends Controller
{
    public $filterSoli, $filterSolic, $tickets, $clientes;

    public function home(Request $request)
    {
        $valid = Auth::user()->permiso->panels->where('id', 4)->first();
        // $user = Auth::user();
        // $userID = Auth::user()->id;
        // $usuario = User::where('name', 'LIKE', '%' . $request->search . '%')->get();
        // // $tickets = Ticket::has('compras')->get();
        // $tickets = Ticket::has('compras')->where('user_id', $userID)->get();
        // // $clientes = User::has('tckGen')->get();
        // $usuarios = Ticket::has('compras')
        //     ->where('user_id', $userID)
        //     ->with('compras') // Cargar las compras relacionadas para su uso posterior si es necesario
        //     ->select('solicitante_id')
        //     ->groupBy('solicitante_id')
        //     ->get();
        // $clientes = User::whereIn('id', $usuarios->pluck('solicitante_id')->toArray())->get();

        // $this->filterSoli = $request->input('filterSoli') == 'Tickets' ? null : $request->input('filterSoli');
        // $this->filterSolic = $request->input('filterSolic') == 'Clientes' ? null : $request->input('filterSolic');

        // if (!in_array($user->permiso_id, [1, 2, 7, 8])) {
        //     $tck = Ticket::where(function ($q) use ($user) {
        //         $q->where('user_id', $user->id)
        //             ->orWhere('solicitante_id', $user->id);
        //     })->pluck('id');

        //     $compras = Compra::whereIn('ticket_id', $tck);

        //     $search = $request->input('search');
        //     if ($search) {
        //         $compras->where(function ($query) use ($search) {
        //             $query->where('id', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('ticket_id', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('titulo_correo', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('solucion', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('problema', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('status', 'LIKE', '%' . $search . '%');
        //         });
        //     }
        //     // Verifica si existe el filtro y no está vacío o es diferente de "Tickets"
        //     if ($request->filled('filter') && $request->input('filter') !== 'Tickets') {
        //         $filterSoli = $request->input('filter');
        //         $compras->where('ticket_id', $filterSoli);
        //     }
        //     if ($request->filled('filterc') && $request->input('filterc') !== 'Clientes') {
        //         $filterSolic = $request->input('filterc');
        //         $compras->whereHas('ticket', function ($query) use ($filterSolic) {
        //             $query->where('solicitante_id', $filterSolic);
        //         });
        //     }

        //     $compras = $compras->orderBy('id', 'DESC')->paginate(10)->withQueryString();
        // }
        // //listado para supervisores
        // if ($user->permiso_id == 2) {
        //     $gerentes = Estacion::where('supervisor_id', $user->id)->pluck('user_id');
        //     $gerentes->push($user->id);
        //     $tck = Ticket::whereIn('solicitante_id', $gerentes)->pluck('id');
        //     $compras = Compra::whereIn('ticket_id', $tck)->paginate(10)->withQueryString();
        // }
        // //listado para jefes de area
        // if ($user->permiso_id == 7) {
        //     $personal = UserArea::whereIn('area_id', $user->areas->pluck('id'))->pluck('user_id');
        //     $tck = Ticket::where(function ($q) use ($personal) {
        //         $q->whereIn('user_id', $personal)
        //             ->orWhereIn('solicitante_id', $personal);
        //     })->pluck('id');
        //     $compras = Compra::whereIn('ticket_id', $tck)->paginate(10)->withQueryString();
        // }
        // //listado para compras
        // if ($user->permiso_id == 4) {
        //     $personal = UserZona::whereNotIn('zona_id', [1])->whereIn('zona_id', $user->zonas->pluck('id'))->pluck('user_id');
        //     $tck = Ticket::where(function ($q) use ($personal) {
        //         $q->whereIn('user_id', $personal)
        //             ->orWhereIn('solicitante_id', $personal);
        //     })->pluck('id');
        //     $compras = Compra::whereIn('ticket_id', $tck)->paginate(10)->withQueryString();
        // }
        // //todos los tickets cuando sea admin o auditoria
        // if (in_array($user->permiso_id, [1, 8]) || (isset($user->areas->first()->name) && $user->areas->first()->name == 'Compras')) {
        //     $compras = Compra::orderBy('id', 'DESC')->paginate(10)->withQueryString();
        // }
        
        if (Auth::user()->permiso->id == 1) {
             return view('modules.tickets.compras.compras-list', compact( 'valid'));
        } elseif ($valid->pivot->re == 1) {
             return view('modules.tickets.compras.compras-list', compact( 'valid'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function edit($id)
    {
        $compraID = $id;
        return view('modules.tickets.compras.compra-edit', compact('compraID'));
    }
}