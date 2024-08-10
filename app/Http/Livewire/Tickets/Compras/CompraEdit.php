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
use App\Models\User;
use App\Notifications\EditCompraProductNotification;
use App\Notifications\EditCompraServicioNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use RealRashid\SweetAlert\Facades\Alert;

class CompraEdit extends Component
{
    use WithFileUploads;
    public $compraID, $titulo, $problema, $solucion, $evidencias = [], $urlArchi, $categoria, $productos, $servicios, $carrito = [], $newCarrito = [], $search, $searchService;
    public $tipo;
    public function mount()
    {
        $compra = Compra::find($this->compraID);
        $compra->productos->count() > 0 ? $this->tipo = "prod"
            : $this->tipo = "serv";
        $this->servicios = TckServicio::select('id', 'name')->get();
        $this->productos = Producto::select('id', 'name', 'categoria_id', 'product_photo_path')->get();
        foreach ($this->productos as $key => $producto) {
            $producto->cantidad = '';
            $producto->selected = false;
        }
        foreach ($this->servicios as $key => $servicio) {
            $servicio->cantidad = '';
            $servicio->selected = false;
        }
    }
    public function updatedCategoria($id)
    {
        $categoria = Categoria::find($id);
        // $excluir=CompraDetalle::whereIn('id',array_column($this->carrito, 'id'))->pluck('producto_id');
        // $this->productos=Producto::where('categoria_id',$categoria->id)->whereNotIn('id',$excluir)->get();
    }
    public function updatedSearchService($query)
    {
        $excluir = CompraServicio::where('id', array_column($this->carrito, 'id'))->pluck('servicio_id');
        $this->servicios = TckServicio::where('name', 'LIKE', '%' . $query . '%')->whereNotIn('id', $excluir)->get();
    }
    public function updatedSearch($query)
    {
        $marca = Marca::where('name', 'LIKE', '%' . $query . '%')->first();
        $excluir = CompraDetalle::whereIn('id', array_column($this->carrito, 'id'))->pluck('producto_id');
        $this->productos = Producto::where([[function ($q) use ($marca, $query) {
            if (isset($marca->id)) {
                $q->where('name', 'LIKE', '%' . $query . '%')
                    ->orWhere('marca_id', $marca->id);
            } else {
                $q->where('name', 'LIKE', '%' . $query . '%');
            }
        }], ['categoria_id', $this->categoria]])->whereNotIn('id', $excluir)->get();
    }
    public function deleteEvidencia(ArchivosCompra $archivo)
    {
        Storage::disk('public')->delete($archivo->archivo_path);
        $archivo->delete();
    }
    public function deleteCarrito($id)
    {
        $this->tipo == 'prod'
            ? $pr = CompraDetalle::find($id)
            : $pr = CompraServicio::find($id);
        $this->carrito = array_filter($this->carrito, function ($element) use ($pr) {
            if ($element['id'] != $pr->id) {
                return $element;
            }
        });
        $pr->delete();
    }
    public function updateCompra()
    {
        $Admins = User::where('permiso_id', 1)->get();

        //dd($this->carrito);
        $compra = Compra::find($this->compraID);
        $Agente = $compra->ticket->agente;
        //dd($agente);
        if ($compra->evidencias->count() == 0) {
            $this->validate([
                'evidencias' => ['required']
            ], [
                'evidencias.required' => 'Cargue sus evidencias'
            ]);
        }
        if ($compra->productos->count() == 0 && $compra->servicios->count() == 0) {
            // $this->newCarrito=array_filter($this->newCarrito,function($element){
            //     if(count($element)==3 && $element['id']!=false){
            //         return $element;
            //     }
            // });
            $this->validate([
                'newCarrito' => ['required'],
                'newCarrito.*.cantidad' => ['required'],
            ], [
                'newCarrito.required' => 'Seleccione sus productos',
                'newCarrito.*.cantidad.required' => 'Ingrese la cantidad para todos sus productos/servicios',
            ]);
        }
        if (count($this->newCarrito) > 0) {
            $this->validate([
                'newCarrito.*.cantidad' => ['required'],
            ], [
                'newCarrito.*.cantidad.required' => 'Ingrese la cantidad para todos sus productos/servicios',
            ]);
        }
        $this->validate([
            'titulo' => 'required',
            'problema' => 'required',
            'solucion' => 'required',
        ], [
            'titulo.required' => 'Ingrese un título',
            'problema.required' => 'Ingrese el problema',
            'solucion.required' => 'Ingrese una solución',
        ]);
        $compra->titulo_correo = $this->titulo;
        $compra->problema = $this->problema;
        $compra->solucion = $this->solucion;
        if($compra->status == 'Rechazado'){
            $compra->status="Solicitado";
        }
        $compra->save();
        if ($compra->productos->count() > 0 && $this->categoria != null) {
            if ($compra->productos->first()->producto->categoria_id != $this->categoria) {
                foreach ($this->carrito as $product) {
                    $out = CompraDetalle::find($product['id']);
                    $out->delete();
                }
                $this->carrito = [];
            }
        }
		
		$clienter = $compra->ticket->cliente->zonas->first()->id;
        $Compras = User::where([['permiso_id',4],['status','Activo']])->whereHas('zonas',function(Builder $zonas) use ($clienter){
            $zonas->where('zona_id',$clienter);
        })->get(); //Compras
        //dd($Compras);

        //actualizamos los productos actuales de la requisicion
        //dd($this->carrito);
        if (count($this->carrito) > 0) {
            if ($this->tipo == 'prod') {
                foreach ($this->carrito as $pr) {
                    $producto = CompraDetalle::find($pr['id']);
                    $producto->cantidad = $pr['cantidad'];
                    if(Auth::user()->permiso_id == 1){
                    Notification::send($Compras, new EditCompraProductNotification($compra));
                    Notification::send($Agente, new EditCompraProductNotification($compra));
                    }elseif(Auth::user()->permiso_id == 4){
                        Notification::send($Admins, new EditCompraProductNotification($compra));
                        Notification::send($Agente, new EditCompraProductNotification($compra));
                    }else{
                        Notification::send($Admins, new EditCompraProductNotification($compra));
                        Notification::send($Compras, new EditCompraProductNotification($compra));
                    }
                    $producto->save();
                }
            } else {
                foreach ($this->carrito as $serv) {
                    $servicio = CompraServicio::find($serv['id']);
                    $servicio->cantidad = $serv['cantidad'];
                    if(Auth::user()->permiso_id == 1){
                        Notification::send($Compras, new EditCompraServicioNotification($compra));
                        Notification::send($Agente, new EditCompraServicioNotification($compra));
                        }elseif(Auth::user()->permiso_id == 4){
                            Notification::send($Admins, new EditCompraServicioNotification($compra));
                            Notification::send($Agente, new EditCompraServicioNotification($compra));
                        }else{
                            Notification::send($Admins, new EditCompraServicioNotification($compra));
                            Notification::send($Compras, new EditCompraServicioNotification($compra));
                        }
                    $servicio->save();
                }
            }
        }
        //guardamos evidencias
        //dd($this->evidencias);
        foreach ($this->evidencias as $lue) {
            $this->urlArchi = $lue->store('tck/compras/evidencias', 'public');
            $archivo = new ArchivosCompra();
            $archivo->compra_id = $compra->id;
            $archivo->nombre_archivo = $lue->getClientOriginalName();
            $archivo->mime_type = $lue->getMimeType();
            $archivo->archivo_path = $this->urlArchi;
            $archivo->save();
        }
        if (count($this->newCarrito) > 0) {
            if ($this->tipo == 'prod') {
                foreach ($this->newCarrito as $p) {
                    $cp = new CompraDetalle();
                    $cp->compra_id = $compra->id;
                    $cp->producto_id = $p['id'];
                    // $cp->prioridad=$p['prioridad'];
                    $cp->cantidad = $p['cantidad'];
                    $cp->save();
                }
            } else {
                foreach ($this->newCarrito as $s) {
                    $cs = new CompraServicio();
                    $cs->compra_id = $compra->id;
                    $cs->servicio_id = $s['id'];
                    // $cs->prioridad=$s['prioridad'];
                    $cs->cantidad = $s['cantidad'];
                    $cs->save();
                }
            }
        }
        $this->PDF($compra->id);
        // Alert::success('Requisición actualizada', "La información de la requisición ha sido actualizada exitosamente");
        session()->flash('flash.banner', 'La requisición ha sido editada');
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->route('req.edit', $this->compraID);
    }
    public function PDF($id)
    {
        $compra = Compra::find($id);
        //dd($compra->productos);
        $this->tipo == 'prod'
            ? $categoria = $compra->productos->first()->producto->categoria->name
            : $categoria = "Servicio";
            $nombre='R'.$compra->id.'-'.$categoria.'-'.$compra->ticket->agente->name.'-'.$compra->ticket->cliente->name;
        //eliminamos el PDF antiguo
        Storage::disk('public')->delete($compra->documento);
        $pdf = Pdf::loadView('livewire.tickets.compras.PDFCompra', compact('categoria', 'compra','nombre'))->output();
        Storage::disk('public')->put('tck/compras/documentos/' . $nombre . '.pdf', $pdf);
        $compra->documento = 'tck/compras/documentos/' . $nombre . '.pdf';
        $compra->save();
    }
    public function render()
    {
        $compra = Compra::find($this->compraID);
        $categorias = Categoria::all();
        $this->titulo = $compra->titulo_correo;
        $this->problema = $compra->problema;
        $this->solucion = $compra->solucion;
        if ($this->tipo == "prod") {
            foreach ($compra->productos as $key => $value) {
                $this->carrito[$key] = ['id' => $value->id, 'prioridad' => $value->prioridad, 'cantidad' => $value->cantidad];
            }
        } else {
            foreach ($compra->servicios as $key => $value) {
                $this->carrito[$key] = ['id' => $value->id, 'prioridad' => $value->prioridad, 'cantidad' => $value->cantidad];
            }
        }
        //dd($this->carrito);
        return view('livewire.tickets.compras.compra-edit', compact('categorias', 'compra'));
    }
}
