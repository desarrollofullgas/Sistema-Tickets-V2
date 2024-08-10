<?php

namespace App\Http\Controllers;

use App\Exports\TicketsExport;
use App\Models\AlmacenCi;
use App\Models\ArchivosTicket;
use App\Models\Areas;
use App\Models\Comentario;
use App\Models\Falla;
use App\Models\Servicio;
use App\Models\Tarea;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class TicketController extends Controller
{

    //Vista Lista de tickets
    public function home()
    {
        $valid = Auth::user()->permiso->panels->where('id', 2)->first();
        $pendientes = Ticket::where('status', 'Por abrir')->count();
        return view('modules.tickets.index', compact('pendientes', 'valid'));
    }
	
	public function open()
    {
        $valid = Auth::user()->permiso->panels->where('id', 2)->first();
        return view('modules.tickets.open', compact('valid'));
    }
    public function process()
    {
        $valid = Auth::user()->permiso->panels->where('id', 2)->first();
        return view('modules.tickets.process', compact('valid'));
    }
    public function closed()
    {
        $valid = Auth::user()->permiso->panels->where('id', 2)->first();
        return view('modules.tickets.closed', compact('valid'));
    }

    //vista tickets pendientes
    public function pendientes()
    {
        return view('modules.tickets.abiertos');
    }

    //Vista Detalles y comentarios de ticket
    public function ver($ticketID)
    {
		$valid = Auth::user()->permiso->panels->where('id', 2)->first();
        // Obtén el ticket por su ID
        $tck = Ticket::findOrFail($ticketID);
    
        // Verifica si el usuario autenticado es el propietario del ticket
		// if ($tck->user_id !== auth()->user()->id && $tck->solicitante_id !== auth()->user()->id && auth()->user()->permiso_id !== 1 && auth()->user()->permiso_id !== 4 && auth()->user()->permiso_id !== 8) {
        //     abort(403, 'No tienes permisos para ver este ticket.');
        // }
    
        // Ahora que sabemos que el usuario tiene permisos, obtenemos los datos adicionales
        $ticketOwner = $tck->solicitante_id;
        $comentarios = Comentario::where([['ticket_id', $ticketID], ['tipo', 'Comentario']])->orderBy('id', 'desc')->get();
        $comReasignados = Comentario::where([['ticket_id', $ticketID], ['tipo', 'Reasignacion']])->orderBy('id', 'desc')->get();
        $comAbierto = Comentario::where([['ticket_id', $ticketID], ['tipo', 'Abrir']])->orderBy('id', 'desc')->get();
		$tareasCount = Tarea::where('ticket_id', $tck->id)->count();
    
        // Retornar la vista con los datos necesarios
        return view('modules.tickets.detalles.ver', compact('valid','ticketID', 'tck', 'comentarios', 'ticketOwner', 'comReasignados', 'comAbierto','tareasCount'));
    }

    //Vista editar ticket
    public function editar($request)
    {
		$valid = Auth::user()->permiso->panels->where('id', 2)->first();
        $ticketID = $request;
        $tck = Ticket::findOrFail($ticketID);
        $evidenciaArc = $tck->archivos;
		 $tareasCount = Tarea::where('ticket_id', $tck->id)->count();
        return view('modules.tickets.detalles.editar', compact('valid','ticketID', 'tck', 'evidenciaArc','tareasCount'));
    }

    //Eliminar Evidencias Tickets
    public function removeArch($id)
    {
        $archivo = ArchivosTicket::findOrFail($id);
        $archivo->flag_trash = 1;
        $archivo->save();
        Alert::warning('Eliminado', "El archivo ha sido eliminado correctamente");
        return redirect()->back();
    }

    //Eliminar Comentario
    public function removeCom($id)
    {
        $dato = Comentario::findOrFail($id);
        foreach ($dato->archivos as $archivo) {
            $archivo->delete();
        }
        $dato->delete();
        Alert::warning('Eliminado', "El comentario ha sido eliminado correctamente");
        return redirect()->back();
    }

    //Tareas
    public function tarea($request)
    {
		$valid = Auth::user()->permiso->panels->where('id', 2)->first();
        $ticketID = $request;
        $tck = Ticket::findOrFail($ticketID);
        $task=Tarea::where('ticket_id', $ticketID)->get()->first();
        if ($task) {
            $solicitaTarea = $task->user_id;
        } else {
            $solicitaTarea = null; 
        }
        $tareas = Tarea::where('ticket_id', $ticketID)->orderBy('id', 'desc')->paginate(5);
        return view('modules.tickets.tareas.index', compact('valid','ticketID', 'tck', 'tareas','solicitaTarea'));
    }

    //Compras
    public function compra($request)
    {
		$valid = Auth::user()->permiso->panels->where('id', 2)->first();
        $ticketID = $request;
        $tck = Ticket::findOrFail($ticketID);
		$tareasCount = Tarea::where('ticket_id', $tck->id)->count();
        return view('modules.tickets.compras.compras', compact('valid','ticketID', 'tck','tareasCount'));
    }

    //Almácen
    public function almacenCIS()
    {
        $valid = Auth::user()->permiso->panels->where('id', 5)->first();
        $productos = AlmacenCi::select('*')->paginate(10);
        return view('modules.productos.almacen.cis', compact('valid','productos'));
    }
	
	    public function exportTickets()
{
    // Retrieve the tickets data as needed
    $tickets = Ticket::all();

    return Excel::download(new TicketsExport($tickets), 'TICKETS.xlsx');
}
	public function backup()
    {
        $valid = Auth::user()->permiso->panels->where('id', 31)->first();
        if (Auth::user()->permiso->id == 1) {
            return view('modules.sistema.backups.index', ['valid' => $valid]);
        } elseif ($valid->pivot->re == 1) {
            return view('modules.sistema.backups.index', ['valid' => $valid]);
        } else {
            return redirect()->route('dashboard');
        }
    }
}
