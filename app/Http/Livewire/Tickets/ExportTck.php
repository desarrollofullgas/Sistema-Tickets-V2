<?php

namespace App\Http\Livewire\Tickets;

use App\Exports\TicketsExport;
use App\Models\Estacion;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ExportTck extends Component
{
    public $tipo, $dateIn, $dateEnd;
    //función para calcular el tiempo total de las tareas que tenga el ticket
    public function tiempoTareas($tareas){
        $total=0;
        foreach($tareas as $tarea){
                $creacion=Carbon::create($tarea->created_at);
                $cierre=Carbon::create($tarea->fecha_cierre);
                $total+=$cierre->floatDiffInHours($creacion);
        }
        return number_format($total,2);
    }
    public function generarArchivo()
    {
        $this->validate(['tipo' => ['required']], ['tipo.required' => 'Seleccione una opción']);
        if ($this->tipo == 'gral') {
            $currentMonth = Carbon::now()->month;
            if (Auth::user()->permiso_id == 1 || Auth::user()->permiso_id == 8) {
                //Usuarios Administrador o Auditoría
                //Todos los tickets
                $tickets = Ticket::whereMonth('created_at', $currentMonth)->orderBy('created_at', 'desc')->get();
                foreach($tickets as $tck){
                    $creacion=Carbon::create($tck->created_at);
                    $vencimiento=Carbon::create($tck->fecha_cierre);
                    $cierre=Carbon::create($tck->cerrado);
        
                    //validamos si el ticket fue creado dentro del horario de oficina L-V 9-18:30 S 9-13:00
                    if($creacion->dayOfWeek > 0){ //0=domingo
                        $inicio=Carbon::create($tck->created_at)->startOfDay()->addHours(9);
                        $creacion->dayOfWeek==6
                        ?$limite=Carbon::create($tck->created_at)->startOfDay()->addHours(13)
                        :$limite=Carbon::create($tck->created_at)->startOfDay()->addHours(18)->addMinutes(30);
        
                        $creacion->greaterThanOrEqualTo($inicio)&&$creacion->lessThanOrEqualTo($limite)
                        ?$tck->oficina='SI'
                        :$tck->oficina='NO';
                    }else{
                        $tck->oficina='NO';
                    }
                    
                    $tck->tiempo_total=$creacion->floatDiffInHours($cierre);
                    $tck->tiempo_tarea=$this->tiempoTareas($tck->tareas->where('status','Cerrado'));
                    $tck->tiempo_efectivo=number_format(($tck->tiempo_total - floatval($tck->tiempo_tarea)),2);
        
                    $tck->falla->prioridad->tiempo >= $tck->tiempo_efectivo
                    ?$tck->nivel_servicio='DENTRO'
                    :$tck->nivel_servicio='FUERA';
        
                }
            } elseif (Auth::user()->permiso_id == 2) {
                // Usuarios Supervisores
                // Obtenemos el ID de la zona a la que pertenece el supervisor
                $zonaSuper = DB::table('user_zona')->where('user_id', Auth::user()->id)->pluck('zona_id');
                //dd($zonaSuper);
                // Devuelve los usuarios activos en la misma zona que el supervisor
                $tckSupers = User::where('status', 'Activo')
                    ->join('user_zona as uz', 'uz.user_id', 'users.id')
                    ->whereIn('uz.zona_id', $zonaSuper)
                    ->select('users.*')
                    ->get();
                //dd($tckSupers);
                // Devuelve los tickets de los usuarios en la misma zona que el supervisor
                $tickets = Ticket::whereIn('solicitante_id', function ($query) {
                    $query->select('solicitante_id')
                        ->from('estacions')
                        ->where('supervisor_id', Auth::user()->id);
                })
                ->whereMonth('created_at', $currentMonth)
                ->orderBy('created_at', 'desc')
                ->where(function ($query) use ($tckSupers) {
                    $query->whereIn('solicitante_id', $tckSupers->pluck('id'))
                          ->orWhereIn('user_id', $tckSupers->pluck('id'));
                })
                ->get();
                foreach($tickets as $tck){
                    $creacion=Carbon::create($tck->created_at);
                    $vencimiento=Carbon::create($tck->fecha_cierre);
                    $cierre=Carbon::create($tck->cerrado);
        
                    //validamos si el ticket fue creado dentro del horario de oficina L-V 9-18:30 S 9-13:00
                    if($creacion->dayOfWeek > 0){ //0=domingo
                        $inicio=Carbon::create($tck->created_at)->startOfDay()->addHours(9);
                        $creacion->dayOfWeek==6
                        ?$limite=Carbon::create($tck->created_at)->startOfDay()->addHours(13)
                        :$limite=Carbon::create($tck->created_at)->startOfDay()->addHours(18)->addMinutes(30);
        
                        $creacion->greaterThanOrEqualTo($inicio)&&$creacion->lessThanOrEqualTo($limite)
                        ?$tck->oficina='SI'
                        :$tck->oficina='NO';
                    }else{
                        $tck->oficina='NO';
                    }
                    
                    $tck->tiempo_total=$creacion->floatDiffInHours($cierre);
                    $tck->tiempo_tarea=$this->tiempoTareas($tck->tareas->where('status','Cerrado'));
                    $tck->tiempo_efectivo=number_format(($tck->tiempo_total - floatval($tck->tiempo_tarea)),2);
        
                    $tck->falla->prioridad->tiempo >= $tck->tiempo_efectivo
                    ?$tck->nivel_servicio='DENTRO'
                    :$tck->nivel_servicio='FUERA';
        
                }
            } elseif (Auth::user()->permiso_id == 4) {
                // Usuarios Compras
                // Obtenemos el ID de la zona a la que pertenece el personal de Compras
                $zonasCom = DB::table('user_zona')->where('user_id', Auth::user()->id)->pluck('zona_id');
                //dd($zonasCom);
                // Devuelve los usuarios activos en la misma zona que el personal de Compras
                $tckComp = User::where('status', 'Activo')
                    ->join('user_zona as uz', 'uz.user_id', 'users.id')
                    ->whereIn('uz.zona_id', $zonasCom)
                    ->select('users.id')
                    ->get();
                //dd($tckComp);
                // Devuelve los tickets de los usuarios en la misma zona que el personal de Compras
                $tickets = Ticket::whereIn('solicitante_id', $tckComp->pluck('id'))
                ->whereMonth('created_at', $currentMonth)->orderBy('created_at', 'desc')->get();
                foreach($tickets as $tck){
                    $creacion=Carbon::create($tck->created_at);
                    $vencimiento=Carbon::create($tck->fecha_cierre);
                    $cierre=Carbon::create($tck->cerrado);
        
                    //validamos si el ticket fue creado dentro del horario de oficina L-V 9-18:30 S 9-13:00
                    if($creacion->dayOfWeek > 0){ //0=domingo
                        $inicio=Carbon::create($tck->created_at)->startOfDay()->addHours(9);
                        $creacion->dayOfWeek==6
                        ?$limite=Carbon::create($tck->created_at)->startOfDay()->addHours(13)
                        :$limite=Carbon::create($tck->created_at)->startOfDay()->addHours(18)->addMinutes(30);
        
                        $creacion->greaterThanOrEqualTo($inicio)&&$creacion->lessThanOrEqualTo($limite)
                        ?$tck->oficina='SI'
                        :$tck->oficina='NO';
                    }else{
                        $tck->oficina='NO';
                    }
                    
                    $tck->tiempo_total=$creacion->floatDiffInHours($cierre);
                    $tck->tiempo_tarea=$this->tiempoTareas($tck->tareas->where('status','Cerrado'));
                    $tck->tiempo_efectivo=number_format(($tck->tiempo_total - floatval($tck->tiempo_tarea)),2);
        
                    $tck->falla->prioridad->tiempo >= $tck->tiempo_efectivo
                    ?$tck->nivel_servicio='DENTRO'
                    :$tck->nivel_servicio='FUERA';
        
                }
            }elseif (Auth::user()->permiso_id != 1 && Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 7 && Auth::user()->permiso_id != 8 && Auth::user()->permiso_id != 4) {
                // Usuarios 
                // Devuelve los tickets de los usuarios 
                $tickets = Ticket::whereMonth('created_at', $currentMonth)
                ->orderBy('created_at', 'desc')
                ->where(function ($query) {
                    $query->where('solicitante_id', Auth::user()->id)
                          ->orWhere('user_id', Auth::user()->id);
                })
                ->get();
                foreach($tickets as $tck){
                    $creacion=Carbon::create($tck->created_at);
                    $vencimiento=Carbon::create($tck->fecha_cierre);
                    $cierre=Carbon::create($tck->cerrado);
        
                    //validamos si el ticket fue creado dentro del horario de oficina L-V 9-18:30 S 9-13:00
                    if($creacion->dayOfWeek > 0){ //0=domingo
                        $inicio=Carbon::create($tck->created_at)->startOfDay()->addHours(9);
                        $creacion->dayOfWeek==6
                        ?$limite=Carbon::create($tck->created_at)->startOfDay()->addHours(13)
                        :$limite=Carbon::create($tck->created_at)->startOfDay()->addHours(18)->addMinutes(30);
        
                        $creacion->greaterThanOrEqualTo($inicio)&&$creacion->lessThanOrEqualTo($limite)
                        ?$tck->oficina='SI'
                        :$tck->oficina='NO';
                    }else{
                        $tck->oficina='NO';
                    }
                    
                    $tck->tiempo_total=$creacion->floatDiffInHours($cierre);
                    $tck->tiempo_tarea=$this->tiempoTareas($tck->tareas->where('status','Cerrado'));
                    $tck->tiempo_efectivo=number_format(($tck->tiempo_total - floatval($tck->tiempo_tarea)),2);
        
                    $tck->falla->prioridad->tiempo >= $tck->tiempo_efectivo
                    ?$tck->nivel_servicio='DENTRO'
                    :$tck->nivel_servicio='FUERA';
        
                }
            }
        } else {
            $this->validate([
                'dateIn' => ['required'],
                'dateEnd' => ['required'],
            ], [
                'dateIn.required' => 'Ingrese una fecha inicial',
                'dateEnd.required' => 'Ingrese una fecha Final',
            ]);
            if (Auth::user()->permiso_id == 1 || Auth::user()->permiso_id == 8) {
                //Usuarios Administrador o Auditoría
                //Todos los tickets
                $tickets = Ticket::whereBetween('created_at', [$this->dateIn, $this->dateEnd . ' 23:59:00'])->get();
                foreach($tickets as $tck){
                    $creacion=Carbon::create($tck->created_at);
                    $vencimiento=Carbon::create($tck->fecha_cierre);
                    $cierre=Carbon::create($tck->cerrado);
        
                    //validamos si el ticket fue creado dentro del horario de oficina L-V 9-18:30 S 9-13:00
                    if($creacion->dayOfWeek > 0){ //0=domingo
                        $inicio=Carbon::create($tck->created_at)->startOfDay()->addHours(9);
                        $creacion->dayOfWeek==6
                        ?$limite=Carbon::create($tck->created_at)->startOfDay()->addHours(13)
                        :$limite=Carbon::create($tck->created_at)->startOfDay()->addHours(18)->addMinutes(30);
        
                        $creacion->greaterThanOrEqualTo($inicio)&&$creacion->lessThanOrEqualTo($limite)
                        ?$tck->oficina='SI'
                        :$tck->oficina='NO';
                    }else{
                        $tck->oficina='NO';
                    }
                    
                    $tck->tiempo_total=$creacion->floatDiffInHours($cierre);
                    $tck->tiempo_tarea=$this->tiempoTareas($tck->tareas->where('status','Cerrado'));
                    $tck->tiempo_efectivo=number_format(($tck->tiempo_total - floatval($tck->tiempo_tarea)),2);
        
                    $tck->falla->prioridad->tiempo >= $tck->tiempo_efectivo
                    ?$tck->nivel_servicio='DENTRO'
                    :$tck->nivel_servicio='FUERA';
        
                }
            } elseif (Auth::user()->permiso_id == 2) {
                // Usuarios Supervisores
                // Obtenemos el ID de la zona a la que pertenece el supervisor
                $zonaSuper = DB::table('user_zona')->where('user_id', Auth::user()->id)->pluck('zona_id');
                //dd($zonaSuper);
                // Devuelve los usuarios activos en la misma zona que el supervisor
                $tckSupers = User::where('status', 'Activo')
                    ->join('user_zona as uz', 'uz.user_id', 'users.id')
                    ->whereIn('uz.zona_id', $zonaSuper)
                    ->select('users.*')
                    ->get();
                //dd($tckSupers);
                // Devuelve los tickets de los usuarios en la misma zona que el supervisor
                $tickets = Ticket::where(function ($query) use ($tckSupers) {
                    $query->whereIn('solicitante_id', $tckSupers->pluck('id'))
                          ->orWhereIn('user_id', $tckSupers->pluck('id'));
                })
                ->whereBetween('created_at', [Carbon::parse($this->dateIn), Carbon::parse($this->dateEnd)->endOfDay()])
                ->get();
                foreach($tickets as $tck){
                    $creacion=Carbon::create($tck->created_at);
                    $vencimiento=Carbon::create($tck->fecha_cierre);
                    $cierre=Carbon::create($tck->cerrado);
        
                    //validamos si el ticket fue creado dentro del horario de oficina L-V 9-18:30 S 9-13:00
                    if($creacion->dayOfWeek > 0){ //0=domingo
                        $inicio=Carbon::create($tck->created_at)->startOfDay()->addHours(9);
                        $creacion->dayOfWeek==6
                        ?$limite=Carbon::create($tck->created_at)->startOfDay()->addHours(13)
                        :$limite=Carbon::create($tck->created_at)->startOfDay()->addHours(18)->addMinutes(30);
        
                        $creacion->greaterThanOrEqualTo($inicio)&&$creacion->lessThanOrEqualTo($limite)
                        ?$tck->oficina='SI'
                        :$tck->oficina='NO';
                    }else{
                        $tck->oficina='NO';
                    }
                    
                    $tck->tiempo_total=$creacion->floatDiffInHours($cierre);
                    $tck->tiempo_tarea=$this->tiempoTareas($tck->tareas->where('status','Cerrado'));
                    $tck->tiempo_efectivo=number_format(($tck->tiempo_total - floatval($tck->tiempo_tarea)),2);
        
                    $tck->falla->prioridad->tiempo >= $tck->tiempo_efectivo
                    ?$tck->nivel_servicio='DENTRO'
                    :$tck->nivel_servicio='FUERA';
        
                }
            } elseif (Auth::user()->permiso_id == 4) {
                // Usuarios Compras
                // Obtenemos el ID de la zona a la que pertenece el personal de Compras
                $zonasCom = DB::table('user_zona')->where('user_id', Auth::user()->id)->pluck('zona_id');
                //dd($zonasCom);
                // Devuelve los usuarios activos en la misma zona que el personal de Compras
                $tckComp = User::where('status', 'Activo')
                    ->join('user_zona as uz', 'uz.user_id', 'users.id')
                    ->whereIn('uz.zona_id', $zonasCom)
                    ->select('users.id')
                    ->get();
                //dd($tckComp);
                // Devuelve los tickets de los usuarios en la misma zona que el personal de Compras
                $tickets = Ticket::whereIn('solicitante_id', $tckComp->pluck('id'))
                ->whereBetween('created_at', [Carbon::parse($this->dateIn), Carbon::parse($this->dateEnd)->endOfDay()])
                    ->get();
                    foreach($tickets as $tck){
                        $creacion=Carbon::create($tck->created_at);
                        $vencimiento=Carbon::create($tck->fecha_cierre);
                        $cierre=Carbon::create($tck->cerrado);
            
                        //validamos si el ticket fue creado dentro del horario de oficina L-V 9-18:30 S 9-13:00
                        if($creacion->dayOfWeek > 0){ //0=domingo
                            $inicio=Carbon::create($tck->created_at)->startOfDay()->addHours(9);
                            $creacion->dayOfWeek==6
                            ?$limite=Carbon::create($tck->created_at)->startOfDay()->addHours(13)
                            :$limite=Carbon::create($tck->created_at)->startOfDay()->addHours(18)->addMinutes(30);
            
                            $creacion->greaterThanOrEqualTo($inicio)&&$creacion->lessThanOrEqualTo($limite)
                            ?$tck->oficina='SI'
                            :$tck->oficina='NO';
                        }else{
                            $tck->oficina='NO';
                        }
                        
                        $tck->tiempo_total=$creacion->floatDiffInHours($cierre);
                        $tck->tiempo_tarea=$this->tiempoTareas($tck->tareas->where('status','Cerrado'));
                        $tck->tiempo_efectivo=number_format(($tck->tiempo_total - floatval($tck->tiempo_tarea)),2);
            
                        $tck->falla->prioridad->tiempo >= $tck->tiempo_efectivo
                        ?$tck->nivel_servicio='DENTRO'
                        :$tck->nivel_servicio='FUERA';
            
                    }
            }elseif (Auth::user()->permiso_id != 1 && Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 7 && Auth::user()->permiso_id != 8 && Auth::user()->permiso_id != 4) {
                // Usuarios 
                // Devuelve los tickets de los usuarios 
                $tickets = Ticket::where(function ($query) {
                    $query->where('solicitante_id', Auth::user()->id)
                          ->orWhere('user_id', Auth::user()->id);
                })
                ->whereBetween('created_at', [Carbon::parse($this->dateIn), Carbon::parse($this->dateEnd)->endOfDay()])
                ->get();
                foreach($tickets as $tck){
                    $creacion=Carbon::create($tck->created_at);
                    $vencimiento=Carbon::create($tck->fecha_cierre);
                    $cierre=Carbon::create($tck->cerrado);
        
                    //validamos si el ticket fue creado dentro del horario de oficina L-V 9-18:30 S 9-13:00
                    if($creacion->dayOfWeek > 0){ //0=domingo
                        $inicio=Carbon::create($tck->created_at)->startOfDay()->addHours(9);
                        $creacion->dayOfWeek==6
                        ?$limite=Carbon::create($tck->created_at)->startOfDay()->addHours(13)
                        :$limite=Carbon::create($tck->created_at)->startOfDay()->addHours(18)->addMinutes(30);
        
                        $creacion->greaterThanOrEqualTo($inicio)&&$creacion->lessThanOrEqualTo($limite)
                        ?$tck->oficina='SI'
                        :$tck->oficina='NO';
                    }else{
                        $tck->oficina='NO';
                    }
                    
                    $tck->tiempo_total=$creacion->floatDiffInHours($cierre);
                    $tck->tiempo_tarea=$this->tiempoTareas($tck->tareas->where('status','Cerrado'));
                    $tck->tiempo_efectivo=number_format(($tck->tiempo_total - floatval($tck->tiempo_tarea)),2);
        
                    $tck->falla->prioridad->tiempo >= $tck->tiempo_efectivo
                    ?$tck->nivel_servicio='DENTRO'
                    :$tck->nivel_servicio='FUERA';
        
                }
            }
            //$tickets = Ticket::whereBetween('created_at', [$this->dateIn, $this->dateEnd . ' 23:59:00'])->get();
        }
        return Excel::download(new TicketsExport($tickets), 'TICKETS.xlsx');
    }
    public function render()
    {
        return view('livewire.tickets.export-tck');
    }
}
