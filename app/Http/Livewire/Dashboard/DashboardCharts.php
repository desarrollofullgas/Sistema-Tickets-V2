<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Ticket;
use Livewire\Component;
use App\Models\UserZona;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardCharts extends Component
{

    public function render()
    {
        $user = Auth::user();
        $currentMonth = Carbon::now()->monthName;

        $chartTickets = new LarapexChart();
        $chartTicketsAsignados = new LarapexChart();
        $chartTicketsPrioridad = new LarapexChart();
        $chartTicketsStatus = new LarapexChart();
        $chartTicketsHora = new LarapexChart();
        $chartTicketsDeptos = new LarapexChart();

        $labelsT = [];
        $labelsA = [];
        $labelsP = [];
        $labelsE = [];
        $labelsH = [];
        $labelsD = [];

        //Tickets por estación
        $estaciones = DB::table('tickets')
            ->join('users', 'tickets.solicitante_id', 'users.id')
            ->where('users.permiso_id', 3)
            ->whereMonth('tickets.created_at', Carbon::now()->month)
            ->selectRaw('count(tickets.user_id) as tcks, users.name as estacion')
            ->groupBy('estacion')
            ->orderBy('tcks', 'desc')
            ->orderBy('tickets.created_at', 'desc')
            ->take(5)
            ->get();

        foreach ($estaciones as $estacion) {
            $labelsT[] = $estacion->estacion;
        }
        $chartTickets->setType('area')
            ->setTitle('TICKETS POR ESTACIÓN')
            ->setSubtitle('Top 5 del Mes ' . ' - ' . $currentMonth)
            ->setXAxis($labelsT)
            ->setDataset([[
                'name' => 'Tickets',
                'data' => $estaciones->pluck('tcks')
            ]])
            ->setHeight(320)
            ->setColors(['#1bf242'])
            ->setToolbar(true);

        //Total tickets asignados 
        $asignados = DB::table('tickets')
            ->join('users', 'tickets.user_id', 'users.id')
            ->whereIn('users.permiso_id', [5, 7])
            ->whereMonth('tickets.created_at', Carbon::now()->month)
            ->selectRaw('count(tickets.user_id) as tcks, users.name as nombre')
            ->groupBy('nombre')
            ->orderBy('tcks', 'desc')
            ->orderBy('tickets.created_at', 'desc')
            ->take(5)
            ->get();

        foreach ($asignados as $asignado) {
            $labelsA[] = $asignado->nombre;
        }
        $chartTicketsAsignados->setType('donut')
            ->setTitle('Tickets Asignados por Usuario')
            ->setSubtitle('Top 5 del Mes' . ' - ' . $currentMonth)
            ->setDataset($asignados->pluck('tcks'))
            ->setLabels($labelsA)
            ->setToolbar(true);


        //Tickets por prioridad      
        $userId = Auth::user();
		$minions = UserZona::whereIn('zona_id', $userId->zonas->pluck('id'))->pluck('user_id');//para los jefes de zona
        $prioridades = DB::table('tickets')
            ->where(function ($query) use ($userId, $minions) {
                if ($userId->permiso_id !== 1 && $userId->permiso_id !== 7) {
                    $query->where('user_id', $userId->id)
                        ->orWhere('solicitante_id', $userId->id);
                }elseif($userId->permiso_id === 7){
			$query->where('user_id', $userId->id)
                ->orWhereIn('solicitante_id', $minions);
		}
            })
            ->join('fallas', 'tickets.falla_id', 'fallas.id')
            ->join('prioridades', 'fallas.prioridad_id', 'prioridades.id')
            ->join('tipos', 'prioridades.tipo_id', 'tipos.id')
            ->whereMonth('tickets.created_at', Carbon::now()->month)
            ->selectRaw('count(tickets.user_id) as tcks, prioridades.name as prioridad, tipos.name as tipo')
            ->groupBy('fallas.id', 'prioridad', 'tipo')
            ->orderBy('tcks', 'desc')
            ->orderBy('tickets.created_at', 'desc')
            ->get();

        foreach ($prioridades as $prioridad) {
            $labelsP[] = $prioridad->tipo . ' - ' . $prioridad->prioridad;
        }
        $chartTicketsPrioridad->setTitle('TICKETS POR PRIORIDAD')
            ->setSubtitle('MES EN CURSO' . ' - ' . mb_strtoupper($currentMonth))
            ->setType('bar')->setXAxis($labelsP)->setGrid(true)->setDataset([[
                'name'  => 'Tickets',
                'data'  =>  $prioridades->pluck('tcks')->toArray()
            ]])
            ->setColors(['#e81388'])
            ->setHeight(320)
            ->setToolbar(true);

        //Tickets por status
        $userId = Auth::user();
		$minions = UserZona::whereIn('zona_id', $userId->zonas->pluck('id'))->pluck('user_id');//para los jefes de zona
        $estados = DB::table('tickets')
            ->where(function ($query) use ($userId,$minions) {
                if ($userId->permiso_id !== 1 && $userId->permiso_id !== 7) {
                    $query->where('user_id', $userId->id)
                        ->orWhere('solicitante_id', $userId->id);
                }elseif($userId->permiso_id === 7){
			$query->where('user_id', $userId->id)
                ->orWhereIn('solicitante_id', $minions);
		}
            })
            ->whereMonth('tickets.created_at', Carbon::now()->month)
            ->selectRaw('count(tickets.user_id) as tcks, tickets.status as nombre')
            ->groupBy('nombre')
            ->orderBy('tcks', 'desc')
            ->orderBy('tickets.created_at', 'desc')
            ->get();
            //dd($estados);
        foreach ($estados as $estado) {
            $labelsE[] = $estado->nombre;
        }
        $chartTicketsStatus->setType('pie')
            ->setTitle('TICKETS POR ESTADO')
            ->setSubtitle('MES EN CURSO' . ' - ' . mb_strtoupper($currentMonth))
            ->setDataset($estados->pluck('tcks'))
            ->setLabels($labelsE)
            ->setToolbar(true);

        //Horas trabajo x ticket
        $userId = Auth::id();
        $horas = DB::table('tickets')
            ->where(function ($query) use ($userId) {
                if ($userId !== 1) {
                    $query->where('user_id', $userId)
                        ->orWhere('solicitante_id', $userId);
                }
            })
            ->join('users', 'tickets.user_id', 'users.id')
            ->whereIn('users.permiso_id', [5, 7])
            ->join('fallas', 'tickets.falla_id', 'fallas.id')
            ->join('prioridades', 'fallas.prioridad_id', 'prioridades.id')
            ->whereMonth('tickets.created_at', Carbon::now()->month)
            ->selectRaw('SUM(tiempo) as tcks, users.name as usuario')
            ->groupBy('falla_id', 'usuario')
            ->orderBy('tcks', 'desc')
            ->orderBy('tickets.created_at', 'desc')
            ->get();
            //dd($horas);
        foreach ($horas as $hora) {
            $labelsH[] = $hora->usuario;
        }
        $chartTicketsHora->setTitle('Carga de Trabajo por Horas')
            ->setSubtitle('Mes en Curso' . ' - ' . $currentMonth)
            ->setType('area')->setXAxis($labelsH)->setGrid(true)->setDataset([[
                'name'  => 'Horas',
                'data'  =>  $horas->pluck('tcks')->toArray()
            ]])
            ->setColors(['#e81388'])
            ->setHeight(320)
            ->setToolbar(true);

        //Total tickets por Departamento
        $deptos = DB::table('departamentos')
            ->join('areas', 'departamentos.id', 'areas.departamento_id')
            ->join('servicios', 'areas.id', 'servicios.area_id')
            ->join('fallas', 'areas.id', 'fallas.servicio_id')
            ->join('tickets', 'fallas.id', 'tickets.falla_id')
            ->whereMonth('tickets.created_at', Carbon::now()->month)
            ->selectRaw('count(tickets.id) as total, departamentos.name as nombre')
            ->groupBy('nombre')
            ->orderBy('total', 'desc')
            ->orderBy('tickets.created_at', 'desc')
            ->take(5)
            ->get();
            
        foreach ($deptos as $depto) {
            $labelsD[] = $depto->nombre;
        }
        $chartTicketsDeptos->setTitle('Tickets por Departamento')
            ->setSubtitle('Mes en Curso' . ' - ' . $currentMonth)
            ->setType('bar')->setXAxis($labelsD)->setGrid(true)->setDataset([[
                'name'  => 'Horas',
                'data'  =>  $deptos->pluck('total')->toArray()
            ]])
            ->setColors(['#e81388'])
            ->setHeight(320)
            ->setToolbar(true);
        return view('livewire.dashboard.dashboard-charts', compact('chartTickets', 'chartTicketsAsignados', 'chartTicketsPrioridad', 'chartTicketsStatus', 'chartTicketsHora', 'chartTicketsDeptos'));
    }
}
