<?php

namespace App\Http\Livewire\Tickets\Compras;

use App\Mail\SendEmailRequi;
use App\Mail\SendEmailRequiGT;
use App\Mail\SendEmailRequisicion;
use App\Models\Categoria;
use App\Models\ComentarioTarea;
use App\Models\Compra;
use App\Models\CorreosCompra;
use App\Models\CorreosServicio;
use App\Models\CorreosZona;
use App\Models\Permiso;
use App\Models\Tarea;
use App\Models\User;
use App\Models\UserZona;
use Illuminate\Support\Facades\Mail;
use App\Notifications\AgenteCompraEnviadaNotification;
use App\Notifications\AprobadaCompraNotification;
use App\Notifications\CompletadaCompraAgenteNotification;
use App\Notifications\CompletadaCompraNotification;
use App\Notifications\ComprasRequiNotification;
use App\Notifications\TareaAsignadaNotification;
use App\Notifications\TareaRequisicionNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class AcepCompra extends Component
{
    public $compraID, $status, $permiso, $personal,
        $asignado, $emailAddress = [], $emailAddressServ = [],
        $open = false,$mailPS,$bccEmails, $mensaje_opcion, $mensaje;

    public function mount()
    {
        $compra=Compra::findOrFail($this->compraID);
        $cliente = $compra->ticket->cliente->zonas->pluck('id');

        $this->personal = User::where([['permiso_id',4],['status','Activo']])
        ->join('user_zona','users.id','=','user_zona.user_id')
        ->whereIn('user_zona.zona_id',$cliente)->select('users.id')->get();
        //dd($this->personal);
        $catego = null;
        foreach ($compra->productos as $prod) {
            $catego = $prod->producto->categoria->id;
        }
        //$correosZona = CorreosZona::whereIn('zona_id', $cliente)->where('categoria_id', $catego)->get();
        //cambio para obtener los correos de la primera zona registrada del cliente del ticket
        $correosZona = CorreosZona::whereIn('zona_id', [$compra->ticket->cliente->zonas->first()->id])->where('categoria_id', $catego)->get();

        $emailAddress = [];
        foreach ($correosZona as $correoZona) {
            $email = $correoZona->correo->correo;
            if (!in_array($email, $emailAddress)) {//se verifica si ya existe en el array utilizando in_array. Si ya existe, no se agrega nuevamente, lo que evita duplicados en los arrays.
                $emailAddress[] = $email;
            }
        }
        //$correosServicio = CorreosServicio::whereIn('zona_id', $cliente)->get();
        $correosServicio = CorreosServicio::whereIn('zona_id', [$compra->ticket->cliente->zonas->first()->id])->get();
        $emailAddressServ = [];
        foreach ($correosServicio as $correoServicio) {
            $email = $correoServicio->correo->correo;
            if (!in_array($email, $emailAddressServ)) {//se verifica si ya existe en el array utilizando in_array. Si ya existe, no se agrega nuevamente, lo que evita duplicados en los arrays.
                $emailAddressServ[] = $email;
            }
        }
        $this->mailPS = $compra->productos->count() > 0 ? $emailAddress : $emailAddressServ;

        $agenteMail = $compra->ticket->agente->email; //email del agente
        $this->bccEmails = [
            'iiuit@fullgas.com.mx', //Irvin Iuit
            'achavez@fullgas.com.mx', //Arlenny Chavez
            'auxsistemas@fullgas.com.mx',
            $agenteMail, //Obtenemos el mail del agente 
            // Agrega más direcciones de correo aquí...
        ];
    }
    //función para encontrar el agente con permiso de compras con menor cant. de tareas asignados el día de hoy
    public function agenteDisponible()
    {
        $desocupado = [];
        $disponible = [];
        foreach ($this->personal as $key => $personal) { // En el Mount definimos que $this->personal sean usuarios Compra
            if ($personal->status === 'Activo') { //Personal con status Activo
                $desocupado[$key]['id'] = $personal->id; //tomamos el id
                $desocupado[$key]['cant'] = $personal->tareasHoy->count(); //validamos total de asignamiento
            }
        }
        if (empty($this->personal)) {
            // Devuelve un mensaje de error si no hay agentes activos disponibles
            Alert::warning('Atención', "No hay agentes disponibles, favor de intentar más tarde");
        } else {
            // Ordena los agentes según la cantidad de tareas manejados hoy
            usort($desocupado, function ($a, $b) {
                return $a['cant'] <=> $b['cant'];
            });

            // Compruebe si el array $desocupado no está vacía antes de acceder a sus elementos
            if (isset($desocupado[0])) {
                $disponible = $desocupado[0];
                return $disponible['id'];
            } else {
                // Manejar la situación donde $desocupado está vacío (no hay agentes disponibles)
                Alert::warning('Atención', "No hay agentes disponibles, favor de intentar más tarde");
            }
        }
    }

    //Aprobar requisición - Notificar al agente - Crear tarea
    public function aprobar(Compra $compra)
    {
        $Admins = User::where('permiso_id', 1)->get(); //Usuarios Administradores
        //$Compras = User::where('permiso_id', 4)->get();
        $Agente = $compra->ticket->agente; // Usuario Agente

        $this->asignado = $this->agenteDisponible(); // Llamado a la función disponibilidad de agente
        //dd($this->asignado);

        // Se cambia el Status de la compra 
        $compra->status = 'Aprobado';
        $compra->save();

        //Creamos tarea al Agente con perfil de Compras
        $tarea = new Tarea();
        $tarea->asunto = 'Requisición #' . $compra->id;
        $tarea->mensaje = 'Tarea creada para llevar a cabo el debido seguimiento para la requisición, por parte de Compras';
        $tarea->ticket_id = $compra->ticket->id;
        $tarea->user_id = Auth::user()->id;
        $tarea->user_asignado = $this->asignado;

        // Guardar la tarea en la base de datos
        $tarea->save();

        $tareaId = $tarea->id; // ID de la tarea creada anteriormente
        $compraId = $compra->id; // ID de la compra aprobada

        // Relacionamos la tarea con la compra y la almacenamos en la tabla pivote "tarea_compra"
        $tarea->compras()->attach($compraId);

        $asignadoUser = User::find($this->asignado); //  Usuario asignado a la tarea
        //dd($asignadoUser);
        $notification = new TareaRequisicionNotification($tarea, $this->compraID); // le enviamos notificacion de la tarea al usuario
        $asignadoUser->notify($notification);

        // Notificaciones por sistema
        if (Auth::user()->permiso_id == 1) {
            // Notification::send($Compras, new AprobadaCompraNotification($compra)); Desactivada por ambiguedad de notif
            Notification::send($Agente, new AprobadaCompraNotification($compra));
        } elseif (Auth::user()->permiso_id == 4) {
            Notification::send($Admins, new AprobadaCompraNotification($compra));
            Notification::send($Agente, new AprobadaCompraNotification($compra));
        }

        // Alert::success('Aprobado','La requisición ha sido aprobada');
        session()->flash('flash.banner', 'Requisición Aprobada, se ha creado una tarea a "' . $asignadoUser->name . '" para realizar el seguimiento.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('requisiciones');
    }

    //enviar a compras
    public function enviar(Compra $compra)
    {
        $Admins = User::where('permiso_id', 1)->get(); //Administradores

        $clienter = $compra->ticket->cliente->zonas->first()->id;
        $Compras = User::where([['permiso_id',4],['status','Activo']])->whereHas('zonas',function(Builder $zonas) use ($clienter){
            $zonas->where('zona_id',$clienter);
        })->get(); //Compras

        $Agente = $compra->ticket->agente; // id del agente
        $agenteMail = $compra->ticket->agente->email; //email del agente

        foreach ($compra->ticket->cliente->areas as $area) { //mediante este foreach anidado obtenemos del area actual del cliente
            $areaCliente = $area->name;
            // Ahora, $areaCliente contiene la propiedad de nombre del elemento actual en la colección.
        }
        //dd($areaCliente);
        foreach ($compra->productos as $prod) { //mediante este foreach anidado obtenemos del array el nombre del producto
            $producto = $prod->producto->name;
        }
        //dd($producto);
        foreach ($compra->servicios as $serv) { //mediante este foreach anidado obtenemos del array el nombre del servicio
            $servicio = $serv->servicio->name;
        }
        //dd($servicio);

        $cliente = $compra->ticket->cliente->zonas->first()->id; //zona del cliente, tenía pluck('id')

        $clienter = $compra->ticket->cliente->zonas->first()->regions[0]->id;
        //dd($compra->ticket->cliente->zonas->first()->id);

        $catego = null;
        foreach ($compra->productos as $prod) { //categoria del producto
            $catego = $prod->producto->categoria->id;
        }
        //dd($catego);
        //dd(CorreosZona::whereIn('zona_id',[$cliente])->where('categoria_id', $catego)->get());

        $correosZona = CorreosZona::whereIn('zona_id', [$cliente])->where('categoria_id', $catego)->get();
        foreach ($correosZona as $correoZona) { //correos por zona y categoria de requisición, Productos
            array_push($this->emailAddress, $correoZona->correo->correo);
        }
        //dd($this->emailAddress);
       /*  $this->emailAddress=CorreosCompra::whereHas('correosZona',function(Builder $correos)use($cliente,$catego){
            $correos->where('categoria_id', $catego)->whereIn('zona_id',$cliente);
        })->get(); */
        //dd($this->emailAddress->pluck('correo'),$compra->ticket->cliente->zonas->first()->id,$clienter);

        $correosServicio = CorreosServicio::whereIn('zona_id', [$cliente])->get();
        foreach ($correosServicio as $correoServicio) { //correos por zona, Servicios
            array_push($this->emailAddressServ, $correoServicio->correo->correo);
        }
        //dd($this->emailAddressServ);
		
		$evidencias = [];
        $evidenciaspath = [];

        foreach ($compra->evidencias as $ev) {
            // Cobtenemos nombre y ruta de las evidencias adjuntas en el correo
            $evidencias[] = $ev->nombre_archivo;
            $evidenciaspath[] = $ev->archivo_path;
        }

        $catPS = $compra->productos->count() > 0 ? 'Producto' : 'Servicio';
        $mailPS = $compra->productos->count() > 0 ? $this->emailAddress : $this->emailAddressServ;
        //dd($catPS);

        // Actualiza el status de la compra
        $compra->status = 'Enviado a compras';
        $compra->mensaje_opcion = $this->mensaje;
        //dd($this->mensaje);
        $compra->save();

        // Accede a la tarea relacionada
        $tarea = $compra->tareas->first(); // Esto obtendría la primera tarea relacionada
        //dd($tarea);
        $tarea->status = 'En Proceso';
        $tarea->updated_at = Carbon::now();
        $tarea->save();
        $comt = new ComentarioTarea();
        $comt->tarea_id = $tarea->id;
        $comt->user_id = Auth::user()->id;
        $comt->comentario = 'Dando seguimiento a la requisición, se informa que el/los'.' '.$catPS.' '.'han sido solicitados al departamento de compras';
        $comt->statustarea = $tarea->status;
        $comt->save();

        // Propiedades para el correo
        $mailDataU = [
            'ticket' => $compra->ticket->id, //Atraves de la compra obtenemos el ID del ticket 
             'asunto' => mb_strtoupper($compra->titulo_correo), //Asunto del correo
            'solicitadopor' => $compra->ticket->cliente->name, // Usuario Cliente, quien creo el ticket
            'verificadopor' => $compra->ticket->agente->name, // Usuario agente, quien lleva seguimiento del ticket (Asignado)
            'areacliente' => $areaCliente, //Área del cliente
            'fechaSolicitud' => Carbon::now(), //fecha actual
            'prodserv' => $compra->productos->count() > 0 ? $producto : $servicio, //El nombre del producto o servicio
            'catPS' => $catPS, //Categoría Producto o Servicio
            'problema' => $compra->problema, // de la requisición
            'solucion' => $compra->solucion, // de la requisición
            'mensaje' => $compra->mensaje_opcion,
			 'pdf' => $compra->documento,
            'evidencias' => $evidencias,
            'archivo' => $evidenciaspath,
        ];

        //En todas las requisiciones sin importar zona, se envia correo con copia a irvin, arlenny y al agente
        $bccEmails = [
            'iiuit@fullgas.com.mx', //Irvin Iuit
            'achavez@fullgas.com.mx', //Arlenny Chavez
			'auxsistemas@fullgas.com.mx', // Viridiana Cadena
            'desarrollo@fullgas.com.mx', // Desarrollo FullGas -> para control
            $agenteMail, //Obtenemos el mail del agente 
            // Agrega más direcciones de correo aquí...
        ];

        //Correo
        if($clienter == 3){//Occidente
        Mail::to($mailPS) // dependiendo si son productos o servicios establecemos los correos
            ->cc($bccEmails) // se usa un array porque de otro modo no es posible el envio multiple
            ->send(new SendEmailRequi($mailDataU)); //Pasamos la propiedades a la vista del correo
        }elseif($clienter == 4 || $clienter == 1){//Sureste
            Mail::to($mailPS) // dependiendo si son productos o servicios establecemos los correos
            ->cc($bccEmails) // se usa un array porque de otro modo no es posible el envio multiple
            ->send(new SendEmailRequisicion($mailDataU)); //Pasamos la propiedades a la vista del correo
        }elseif($clienter == 2){//Guatemala
            Mail::to($mailPS) // dependiendo si son productos o servicios establecemos los correos
            ->cc($bccEmails) // se usa un array porque de otro modo no es posible el envio multiple
            ->send(new SendEmailRequiGT($mailDataU)); //Pasamos la propiedades a la vista del correo
        }

        // Notificaciones por sistema
        if (Auth::user()->permiso_id == 1) {
            Notification::send($Compras, new ComprasRequiNotification($compra));
            Notification::send($Agente, new AgenteCompraEnviadaNotification($compra));
        } elseif (Auth::user()->permiso_id == 4) {
            Notification::send($Admins, new ComprasRequiNotification($compra));
            Notification::send($Agente, new AgenteCompraEnviadaNotification($compra));
        }

        // Alert::success('Enviado','La requisición ha sido enviada al departamento de compras');
        session()->flash('flash.banner', 'La requisición ha sido enviada a Compras');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('requisiciones');
    }

    //finalizar compra
    public function finish(Compra $compra)
    {
        $Admins = User::where('permiso_id', 1)->get();
        $clienter = $compra->ticket->cliente->zonas->first()->id;
        $Compras = User::where([['permiso_id',4],['status','Activo']])->whereHas('zonas',function(Builder $zonas) use ($clienter){
            $zonas->where('zona_id',$clienter);
        })->get(); //Compras
        $Agente = $compra->ticket->agente;
		
		$catPS = $compra->productos->count() > 0 ? 'Producto' : 'Servicio';
        $statPS = $compra->productos->count() > 0 ? 'Entregado' : 'Realizado';

        $compra->status = 'Completado';
        $compra->save();

        // Accede a la tarea relacionada
        $tarea = $compra->tareas->first(); // Esto obtendría la primera tarea relacionada
        //dd($tarea);
        $tarea->status = 'Cerrado';
        $tarea->fecha_cierre = Carbon::now();
        $tarea->save();
        $comt = new ComentarioTarea();
        $comt->tarea_id = $tarea->id;
        $comt->user_id = Auth::user()->id;
        $comt->comentario = $catPS.' '.$statPS;
        $comt->statustarea = $tarea->status;
        $comt->save();

        if (Auth::user()->permiso_id == 1) {
            Notification::send($Compras, new CompletadaCompraNotification($compra));
            Notification::send($Agente, new CompletadaCompraNotification($compra));
        } elseif (Auth::user()->permiso_id == 4) {
            Notification::send($Admins, new CompletadaCompraNotification($compra));
            Notification::send($Agente, new CompletadaCompraNotification($compra));
        }

        // Alert::success('Enviado','La requisición ha sido enviada al departamento de compras');
        session()->flash('flash.banner', 'La requisición ha sido completada');
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->route('requisiciones');
    }

    public function render()
    {
        return view('livewire.tickets.compras.acep-compra');
    }
}
