<?php

namespace App\Http\Livewire\Folios\Entradas;

use App\Models\AlmacenCi;
use App\Models\Entrada;
use App\Models\Estacion;
use App\Models\ProductosEntrada;
use App\Models\ProductoSerieEntrada;
use App\Models\Producto;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\EntradaEditNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EditEntrada extends Component
{
    public $entradaID,$entrada,$motivo,$productos,$newProductos,$tickets,$estaciones,$listProductos,$carrito;
    public function mount(){
        $user=Auth::user();
        $this->entrada=Entrada::find($this->entradaID);
        $this->motivo=$this->entrada->motivo;
        //si el usuario es admin se muestran todos los tickets si no, se muesran los del usuario
        $user->permiso_id!=1&&$user->permiso_id!=4
        ?$this->tickets=$user->tickets
        :$this->tickets=Ticket::whereHas('compras')->orderBy('id','DESC')->get();
        
        $this->estaciones=User::select('id','name')->get();
        $this->listProductos=Producto::select('id','name','product_photo_path')->orderBy('name','ASC')->get();
        //dd($this->motivo);
    }
    public function updateEntrada(){
		$Admins = User::where('status', 'Activo')->where('permiso_id', 1)->get();
        $Compras = User::where('status', 'Activo')->where('permiso_id', 4)->get();
        //dd($this->carrito);
        foreach($this->productos as $pr){
            $reg=ProductosEntrada::find($pr['id']);
            $serie=ProductoSerieEntrada::find($reg->serie->id);
            if($pr['tck']!='NULL'){
                $reg->ticket_id=$pr['tck'];
            }
            if($pr['est']!='NULL'){
                $reg->estacion_id=$pr['est'];
            }
            //actualizamos el stock del producto
            $almCi=AlmacenCi::where('producto_id',$pr['producto'])->first();
            $almCi->stock-=$reg->cantidad;
            $almCi->stock+=$pr['cant'];
            $almCi->save();
            $reg->cantidad=$pr['cant'];
            $reg->observacion=$pr['obs'];
            $reg->save();
            $serie->serie=$pr['serie'];
            $serie->save();
        }
        //insertamos nuevos los nuevos datos que están en el carrito
        foreach($this->carrito as $pr){
            $newReg= new ProductosEntrada();
            $newSerie= new ProductoSerieEntrada();
            $newReg->entrada_id=$this->entradaID;
            $newReg->producto_id=$pr['prod'];
            if($pr['tck']!='NULL'){
                $newReg->ticket_id=$pr['tck'];
            }
            /* if($pr['estacion']!='NULL'){
                $newReg->estacion_id=$pr['estacion'];
            } */
            $newReg->cantidad=$pr['cantsol'];
            $newReg->observacion=$pr['observacion'];
            $newReg->save();
            $newSerie->producto_entrada_id=$newReg->id;
            $newSerie->serie=$pr['serie'];
            $newSerie->save();
        }
		Notification::send($Admins, new EntradaEditNotification($reg));
        Notification::send($Compras, new EntradaEditNotification($reg));
        $pdf=$this->PDF($this->entradaID);
        $nameArchivo=$this->entrada->folio->folio.' '.Auth::user()->name.'.pdf';
        //Alert::success('Cambios guardados','La informacion ha sido actualizada');
        return response()->streamDownload(function()use ($pdf){print($pdf);},$nameArchivo);
    }
    public function refresh(){
		session()->flash('flash.banner',' Cambios Guardados, la ENTRADA ha sido actualizada');
        session()->flash('flash.bannerStyle', 'success');
        //recargamos la página
        return redirect(request()->header('Referer'));
    }
    public function PDF($id){
        $hora=Carbon::now();
        $table=Entrada::find($id);
        $resEntrega = $table->productos->first()->ticket->cliente->zonas->first()->regions[0]->id;
        $ticket = $table->productos->first()->ticket->agente->name; 
        $archivo='Folios/'.$table->folio->folio.' '.Auth::user()->name.''.$hora->hour.'-'.$hora->minute.'-'.$hora->second.'.pdf';
        $pdf=Pdf::loadView('modules.folios.PDF',['folio'=>$table,'tipo'=>'Entrada','archivo' => $archivo, 'resEntrega' => $resEntrega, 'name' => $ticket]);
        Storage::disk('public')->put($archivo,$pdf->output());
        $table->pdf=$archivo;
        $table->save();
        return $pdf->output();
    }
    public function deleteCarrito(ProductosEntrada $prod){
        $almacen=AlmacenCi::where('producto_id',$prod->producto_id)->first();
        $almacen->stock-=$prod->cantidad;
        $almacen->save();
        $prod->delete();
        $this->PDF($this->entradaID);
    }
    public function render()
    {
        $this->entrada=Entrada::find($this->entradaID);
        foreach($this->entrada->productos as $key => $pr){
            $this->productos[$key]=[
                'id'=>$pr->id,
                'producto'=>$pr->producto_id,
                'est'=>$pr->estacion_id,
                'obs'=>$pr->observacion,
                'cant'=>$pr->cantidad,
                'tck'=>$pr->ticket_id,
                'serie'=>$pr->serie->serie
            ];
        }
        return view('livewire.folios.entradas.edit-entrada');
    }
}