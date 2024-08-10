<?php

namespace App\Http\Livewire\Tickets\Compras;

use App\Models\ArchivosCompra;
use App\Models\Categoria;
use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\CompraServicio;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\TckServicio;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\NewCompraNotification;
use App\Notifications\NewCompraServicioNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use RealRashid\SweetAlert\Facades\Alert;

class NewCompra extends Component
{
    use WithFileUploads;
    public $ticketID,$w=0,$w2=0,$step=1,$tipo;
    //variables del formulario
    public $titulo,$problema,$solucion,$evidencias=[],$urlArchi,$categoria,$productos,$servicios,$carrito=[],$search,$searchService;
    public function mount(){
        $this->productos= Producto::select('id','name','categoria_id','product_photo_path')->get();
        foreach($this->productos as $p){
           $p->selected=false;
           $p->cantidad=0;
        }
        $this->servicios=TckServicio::select('id','name')->get();
        foreach($this->servicios as $p){
            $p->selected=false;
            $p->cantidad=0;
         }
        //dd($this->servicios);
    }
    public function addCompra(){
        $Admins = User::where('permiso_id',1)->get();
        //dd($this->tipo);
        $this->validate([
            'titulo' => ['required'],
            'problema' => ['required'],
            'solucion' => ['required'],
            'evidencias' => ['required'],
            'tipo' => ['required'],
            'carrito' => ['required'],
           /*  'carrito.*.prioridad' => ['required'], */
            'carrito.*.id' => ['required'],
            'carrito.*.cantidad' => ['required','gt:0'],
        ],[
            'titulo.required' => 'Ingrese un título',
            'problema.required' => 'Describa el problema',
            'solucion.required' => 'Ingrese la solución',
            'evidencias.required' => 'Cargue sus evidencias',
            'tipo.required'=>'Seleccione el tipo de requisición que  desea realizar',
            'carrito.required' => 'Seleccione productos/servicios para la requisición',
           /*  'carrito.*.prioridad.required' => 'Seleccione la prioridad del producto', */
            'carrito.*.cantidad.required' => 'La cantidad es requerida',
            'carrito.*.cantidad.gt' => 'La cantidad solicitada para cada producto/servicio debe ser 1 o más'
        ]);

        $ticket = Ticket::find($this->ticketID); // Obtener el ticket correspondiente
        if ($ticket->status === 'Abierto') {
            Alert::warning('Ticket Abierto', 'No se puede crear una requisicion para un ticket abierto.');
            return redirect()->route('tickets');
        }elseif($ticket->status === 'Cerrado'){// por si admin intenta crear una tarea con ticket cerrado
            Alert::warning('Ticket Cerrado', 'No se puede crear una requisicion para un ticket cerrado.');
            return redirect()->route('tickets');
        }

        //guardamos compra
        $compra=new Compra();
        $compra->ticket_id=$this->ticketID;
        $compra->problema=$this->problema;
        $compra->solucion=$this->solucion;
        $compra->titulo_correo=$this->titulo;
        $compra->status='Solicitado';
		$clienter = $compra->ticket->cliente->zonas->first()->id;
        $compra->save();
        //guardamos evidencias
        foreach ($this->evidencias as $lue) {
            $this->urlArchi = $lue->store('tck/compras/evidencias', 'public');
            $archivo=new ArchivosCompra();
            $archivo->compra_id=$compra->id;
            $archivo->nombre_archivo=$lue->getClientOriginalName();
            $archivo->mime_type=$lue->getMimeType();
            $archivo->archivo_path=$this->urlArchi;
            $archivo->save();
        }
		$Compras = User::where([['permiso_id',4],['status','Activo']])->whereHas('zonas',function(Builder $zonas) use ($clienter){
            $zonas->where('zona_id',$clienter);
        })->get();
        //guardamos productos de la compra de acuerdo al tipo
        if($this->tipo=="Producto"){
            foreach($this->carrito as $p){
                $cp=new CompraDetalle();
                $cp->compra_id=$compra->id;
                $cp->producto_id=$p['id'];
                // $cp->prioridad=$p['prioridad'];
                $cp->cantidad=$p['cantidad'];
                Notification::send($Admins, new NewCompraNotification($compra));
                Notification::send($Compras, new NewCompraNotification($compra));
                $cp->save();
            }
        }else{
            foreach($this->carrito as $p){
                $cp=new CompraServicio();
                $cp->compra_id=$compra->id;
                $cp->servicio_id=$p['id'];
                // $cp->prioridad=$p['prioridad'];
                $cp->cantidad=$p['cantidad'];
                Notification::send($Admins, new NewCompraServicioNotification($compra));
                Notification::send($Compras, new NewCompraServicioNotification($compra));
                $cp->save();
            }
        }
        
        $this->PDF($compra);
        
        //dd($this->carrito);
        // Alert::success('Nueva requisición', "La requisición ha sido registrada");
        session()->flash('flash.banner', 'La requisicion ha sido registrada');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('tickets');
    }
    public function PDF($compra){
        $this->tipo=="Servicio"?$categoria="Servicio"
        : $categoria=Categoria::find($this->categoria)->name;
        $compra=$compra;
        $nombre='R'.$compra->id.'-'.$categoria.'-'.$compra->ticket->agente->name.'-'.$compra->ticket->cliente->name;
        $pdf=Pdf::loadView('livewire.tickets.compras.PDFCompra',compact('categoria','compra','nombre'))->output();
        Storage::disk('public')->put('tck/compras/documentos/'.$nombre.'.pdf', $pdf); 
        $compra->documento='tck/compras/documentos/'.$nombre.'.pdf';
        $compra->save();
    }
    public function render()
    {
        $categorias=Categoria::all();
        return view('livewire.tickets.compras.new-compra',compact('categorias'));
    }
}
