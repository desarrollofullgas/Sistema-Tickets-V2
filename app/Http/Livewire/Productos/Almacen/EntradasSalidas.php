<?php

namespace App\Http\Livewire\Productos\Almacen;

use App\Models\AlmacenCi;
use App\Models\Entrada;
use App\Models\Estacion;
use App\Models\FoliosEntrada;
use App\Models\FoliosSalida;
use App\Models\Producto;
use App\Models\ProductosEntrada;
use App\Models\ProductoSerieEntrada;
use App\Models\ProductoSerieSalida;
use App\Models\ProductosSalida;
use App\Models\Salida;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\EntradaNotification;
use App\Notifications\SalidaNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EntradasSalidas extends Component
{
    public $tipo, $motivo, $productosEntradaSalida, $usuarios, $carrito, $tck, $productosSerie, $prod, $series = [];
    public function mount()
    {
        // Recuperar tickets con compras relacionadas que tengan productos asociados
        $this->tck = Ticket::whereHas('compras')->orderBy('id', 'asc')->get();

        // Recuperar todos los productos de entrada y salida que tienen los IDs obtenidos
        $this->productosEntradaSalida = Producto::select('id', 'name', 'product_photo_path')->orderBy('name', 'asc')->get();
            $this->series = [];
        $this->productosSerie = ProductoSerieEntrada::select('id', 'producto_entrada_id', 'serie')->get();
        //dd($this->usuarios);
        //$this->estaciones = Estacion::select('id', 'name', 'user_id')->orderBy('name')->get();
        foreach ($this->productosEntradaSalida as $p) {
            $alm = AlmacenCi::where('producto_id', $p->id)->get();
            $p->show = false;
            $p->cantsol = null;
            $p->observacion = "";
            $p->estacion = "";
            if ($alm->count() > 0) {
                $p->cant = $alm[0]->stock;
            } else {
                $p->cant = 'No registrado';
            }
        }
        foreach (ProductosEntrada::all() as $pr) {
            // Verificar si existe la serie antes de agregar al array
            if ($pr->serie2 && isset($pr->serie2->serie)) {
                array_push($this->series, ['id' => $pr->id, 'producto' => $pr->producto_id, 'serie' => $pr->serie2->serie]);
            }
        }
    }
    public function numero($number)
    {
        $sec = "";
        if ($number <= 9) {
            $sec = '00' . $number;
        } elseif ($number <= 99) {
            $sec = '0' . $number;
        } else {
            $sec = $number;
        }
        return $sec;
    }
    public function folioSalida()
    {
        $hoy = Carbon::now()->format('Y-m-d');
        $user = Auth::user();
        $folioSalida = FoliosSalida::whereBetween('created_at', [$hoy . ' 00:00:00', $hoy . ' 23:59:00']);
        if ($folioSalida->count() > 0) {
            $newFolio = $folioSalida->first();
        } else {
            $userArea = "";
            $number = $this->numero(((FoliosSalida::count()) + 1));
            if ($user->areas->count() > 0) {
                foreach ($user->areas as $area) {
                    $userArea .= substr($area->name, 0, 1);
                }
            } else {
                $userArea = substr($user->permiso->titulo_permiso, 0, 1);
            }
            $folio = 'F-' . $number . '-' . $userArea;
            $newFolio = new FoliosSalida();
            $newFolio->folio = $folio;
            $newFolio->save();
        }
        return $newFolio->id;
    }
    public function folioEntrada()
    {
        $hoy = Carbon::now()->format('Y-m-d');
        $folioEntrada = FoliosEntrada::whereBetween('created_at', [$hoy . ' 00:00:00', $hoy . ' 23:59:00']);
        if ($folioEntrada->count() > 0) {
            $newFolio = $folioEntrada->first();
        } else {
            $number = $this->numero(((FoliosEntrada::count()) + 1));
            $folio = 'S-M-D-' . $number;
            $newFolio = new FoliosEntrada();
            $newFolio->folio = $folio;
            $newFolio->save();
        }
        return $newFolio->id;
    }
    public function PDF($tipo, $id)
    {
        $hora = Carbon::now();
        if ($tipo == 'salida') {
            $table = Salida::find($id);
           $resEntrega = $table->productos->first()->ticket->cliente->zonas->first()->regions[0]->id;
            $ticket = $table->productos->first()->ticket->agente->name;
        } else {
            $table = Entrada::find($id);
            $resEntrega = $table->productos->first()->ticket->cliente->zonas->first()->regions[0]->id;
            $ticket = $table->productos->first()->ticket->agente->name;
        }
        $archivo = 'Folios/' . $table->folio->folio . ' ' . Auth::user()->name . '' . $hora->hour . '-' . $hora->minute . '-' . $hora->second . '.pdf';
        $pdf = Pdf::loadView('modules.folios.PDF', ['folio' => $table, 'tipo' => $this->tipo, 'archivo' => $archivo, 'resEntrega' => $resEntrega, 'name' => $ticket]);
        Storage::disk('public')->put($archivo, $pdf->output());
        $table->pdf = $archivo;
        $table->save();
        return $pdf->output();
    }

    public function operacion()
    {
        $Admins = User::where('status', 'Activo')->where('permiso_id', 1)->get();
        $Compras = User::where('status', 'Activo')->where('permiso_id', 4)->get();
        $user = Auth::user();
        $folio = "";
        $this->validate([
            'tipo' => ['required'],
            'motivo' => ['required'],
            //'carrito' => ['required'],
            //'carrito.*.*' => ['required'],
            'carrito.*.prod' => ['required'],
            //'carrito.*.cantsol' => ['required', 'gt:0'],
            //'carrito.*.estacion' => ['required'],
            'carrito.*.observacion' => ['required'],
            'carrito.*.serie' => ['nullable'],
        ], [
            'tipo.required' => 'Seleccione la operacion a realizar',
            'motivo.required' => 'Ingrese el motivo de la operacion a realizar',
            //'carrito.required' => 'Seleccione al menos un producto',
            //'carrito.*.*.required' => 'Complete toda la información de cada producto',
            'carrito.*.prod.required' => 'Seleccione un producto',
            //'carrito.*.cantsol.required' => 'Ingrese una catidad para los productos seleccionados',
            //'carrito.*.cantsol.gt' => 'La cantidad debe de ser mayor a cero',
            //'carrito.*.estacion' => 'Seleccione una estación',
            'carrito.*.observacion' => 'Ingrese una observacion para cada producto seleccionado',
        ]);
        if ($this->tipo == 'salida') {
            $folio = $this->folioSalida();
            //guardamos la salida
            $salida = new Salida();
            $salida->folio_id = $folio;
            $salida->user_id = $user->id;
            $salida->motivo = $this->motivo;
            $salida->save();
        } else {
            $folio = $this->folioEntrada();
            $entrada = new Entrada();
            $entrada->folio_id = $folio;
            $entrada->user_id = $user->id;
            $entrada->motivo = $this->motivo;
            $entrada->save();
        }
        // guardamos los productos 
        foreach ($this->carrito as $p) {
            $pAlm = AlmacenCi::where('producto_id', $p['prod']);
            if ($pAlm->count() > 0) {
                $updateAlma = AlmacenCi::find($pAlm->first()->id);
                $this->tipo == 'entrada'
                    ? $updateAlma->stock += 1
                    : $updateAlma->stock -= 1;
                $updateAlma->save();
            } else {
                $newpAlm = new AlmacenCi();
                $newpAlm->producto_id = $p['prod'];
                $newpAlm->stock_base = 1;
                $this->tipo == 'entrada'
                    ? $newpAlm->stock = 1
                    : $newpAlm->stock = 0;
                $newpAlm->save();
            }
            //registramos los productos de entrada o salida
            if ($this->tipo == 'entrada') {
                $pe = new ProductosEntrada();
                $pe->producto_id = $p['prod'];
                $pe->cantidad = 1;
                $pe->entrada_id = $entrada->id;
                // if ($p['estacion'] != 'NULL') {
                //     $pe->estacion_id = $p['estacion'];
                // }
                if ($p['tck'] != 'NULL') {
                    $pe->ticket_id = $p['tck'];
                }
                $pe->observacion = $p['observacion'];
                $pe->save(); //Almacenamos la serie en la tabla ProductoSerie por cada producto
                $productoSerie = new ProductoSerieEntrada();
                $productoSerie->serie = $p['serie'];
                $productoSerie->producto_entrada_id = $pe->id;
                $productoSerie->save();

                Notification::send($Admins, new EntradaNotification($pe));
                Notification::send($Compras, new EntradaNotification($pe));
            } else {
                $ps = new ProductosSalida();
                $ps->producto_id = $p['prod'];
                $ps->cantidad = 1;
                $ps->salida_id = $salida->id;
                // if ($p['estacion'] != 'NULL') {
                //     $ps->estacion_id = $p['estacion'];
                // }
                if ($p['tck'] != 'NULL') {
                    $ps->ticket_id = $p['tck'];
                }
                $ps->observacion = $p['observacion'];
                $ps->save();
                $productoSerie = new ProductoSerieSalida();
                $productoSerie->serie = $p['serie'];
                $productoSerie->producto_salida_id = $ps->id;
                $productoSerie->save();

                Notification::send($Admins, new SalidaNotification($ps));
                Notification::send($Compras, new SalidaNotification($ps));
                // Cambiar el valor de 'ha_salido' a 1 en lugar de eliminar el registro
                ProductoSerieEntrada::where('serie', $p['serie'])->update(['ha_salido' => 1]);
            }
        }


        if ($this->tipo == 'salida') {
            $pdf = $this->PDF($this->tipo, $salida->id);
            $nameArchivo = $salida->folio->folio . ' ' . $user->name . '.pdf';
            /* $salida->pdf='Folios/'.$nameArchivo;
            $salida->save(); */
            //return $this->docWord($this->tipo,$salida->id);
        } else {
            $pdf = $this->PDF($this->tipo, $entrada->id);
            $nameArchivo = $entrada->folio->folio . ' ' . $user->name . '.pdf';
            /* $entrada->pdf='Folios/'.$nameArchivo;
            $entrada->save(); */
            //return $this->docWord($this->tipo,$entrada->id);
        }
        //$pdf=Pdf::loadView('modules.folios.PDF',['pdf'=>'hola'])->output();
        // Alert::success($this->tipo . ' registrada', 'Los datos han sido registrados');
        return response()->streamDownload(function () use ($pdf) {
            print($pdf);
        }, $nameArchivo);
    }
    public function refresh()
    {
        session()->flash('flash.banner', mb_strtoupper($this->tipo) . ' registrada, el almacén ha sido actualizado');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('almacenCIS');
    }
    public function render()
    {
        return view('livewire.productos.almacen.entradas-salidas');
    }
}
