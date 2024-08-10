<?php

namespace App\Http\Livewire\Folios\Salida;

use App\Models\AlmacenCi;
use App\Models\Estacion;
use App\Models\ProductosEntrada;
use App\Models\ProductoSerieSalida;
use App\Models\ProductosSalida;
use App\Models\Salida;
use App\Models\Producto;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\SalidaEditNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EditSalida extends Component
{
    public $salidaID,$salida,$series=[],$motivo,$productos,$newProductos,$tickets,$estaciones,$listProductos,$carrito;
    public function mount(){
        $user=Auth::user();
        $this->salida=Salida::find($this->salidaID);
        $this->motivo=$this->salida->motivo;
        //si el usuario es admin se muestran todos los tickets si no, se muesran los del usuario
        $user->permiso_id!=1
        ?$this->tickets=$user->tickets
        :$this->tickets=Ticket::select('id')->where('status','En proceso')->get();
        
        $this->estaciones=Estacion::select('id','name')->get();
        $this->listProductos=Producto::select('id','name','product_photo_path')->get();
        foreach (ProductosEntrada::all() as $pr){
            array_push($this->series,['id'=>$pr->id,'producto'=>$pr->producto_id,'serie'=>isset($pr->serie->serie)?$pr->serie->serie:'sin serie']);
        }
    }
    public function updateEntrada(){
		  $Admins = User::where('status', 'Activo')->where('permiso_id', 1)->get();
        $Compras = User::where('status', 'Activo')->where('permiso_id', 4)->get();
        //dd($this->carrito);
        foreach($this->productos as $pr){
            $reg=ProductosSalida::find($pr['id']);
            $serie=ProductoSerieSalida::find($reg->serie->id);
            if($pr['tck']!='NULL'){
                $reg->ticket_id=$pr['tck'];
            }
            /* if($pr['est']!='NULL'){
                $reg->estacion_id=$pr['est'];
            } */

            $almCi=AlmacenCi::where('producto_id',$pr['producto'])->first();
            $almCi->stock-=$reg->cantidad;
            
            $almCi->save();
            $reg->cantidad=$pr['cant'];
            $reg->observacion=$pr['obs'];
            $reg->save();
            $serie->serie=$pr['serie'];
            $serie->save();
        }
        //insertamos nuevos los nuevos datos que están en el carrito
        foreach($this->carrito as $pr){
            $newReg= new ProductosSalida();
            $newSerie= new ProductoSerieSalida();
            $serieEntrada=ProductosEntrada::find($pr['serie']);
            $newReg->salida_id=$this->salidaID;
            $newReg->producto_id=$pr['prod'];
            if($pr['tck']!='NULL'){
                $newReg->ticket_id=$pr['tck'];
            }
            /*if($pr['estacion']!='NULL'){
                $newReg->estacion_id=$pr['estacion'];
            }*/
            $newReg->cantidad=$pr['cantsol'];
            $newReg->observacion=$pr['observacion'];
            $newReg->save();
            $newSerie->producto_salida_id=$newReg->id;
            $newSerie->serie=$serieEntrada->serie->serie;
            $newSerie->save();
        }
		Notification::send($Admins, new SalidaEditNotification($reg));
        Notification::send($Compras, new SalidaEditNotification($reg));
        $pdf=$this->PDF($this->salidaID);
        $nameArchivo=$this->salida->folio->folio.' '.Auth::user()->name.'.pdf';
        //Alert::success('Cambios guardados','La informacion ha sido actualizada');
        return response()->streamDownload(function()use ($pdf){print($pdf);},$nameArchivo);
    }
    public function refresh(){
		session()->flash('flash.banner', ' Cambios Guardados, la SALIDA ha sido actualizada');
        session()->flash('flash.bannerStyle', 'success');
        //recargamos la página
        return redirect(request()->header('Referer'));
    }
    public function PDF($id){
        $hora=Carbon::now();
        $table=Salida::find($id);
        $resEntrega = $table->productos->first()->ticket->cliente->zonas->first()->regions[0]->id;
        $ticket = $table->productos->first()->ticket->agente->name;
        $archivo='Folios/'.$table->folio->folio.' '.Auth::user()->name.''.$hora->hour.'-'.$hora->minute.'-'.$hora->second.'.pdf';
        $pdf=Pdf::loadView('modules.folios.PDF',['folio'=>$table,'tipo'=>'Salida', 'archivo' => $archivo, 'resEntrega' => $resEntrega, 'name' => $ticket]);
        Storage::disk('public')->put($archivo,$pdf->output());
        $table->pdf=$archivo;
        $table->save();
        return $pdf->output();
    }
    public function deleteCarrito(ProductosSalida $prod){
        $almacen=AlmacenCi::where('producto_id',$prod->producto_id)->first();
        $almacen->stock+=$prod->cantidad;
        $almacen->save();
        $prod->delete();
        $this->PDF($this->salidaID);
    }
    public function render()
    {
        $this->salida=Salida::find($this->salidaID);
        foreach($this->salida->productos as $key => $pr){
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
        return view('livewire.folios.salida.edit-salida');
    }
}