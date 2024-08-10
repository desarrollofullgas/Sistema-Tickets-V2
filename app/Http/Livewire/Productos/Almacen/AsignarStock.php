<?php

namespace App\Http\Livewire\Productos\Almacen;

use App\Models\AlmacenCi;
use App\Models\Producto;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class AsignarStock extends Component
{
    public $productos=[],$productslist,$stock,$stock_base,$count=0,$search,$lista;
    public function mount(){
        $this->productslist=Producto::all();
        //$this->productos[0]=['stock'=>0];
        foreach($this->productslist as $p){
            $enAlmacen=AlmacenCi::where('producto_id',$p->id)->get();
            $p->show=false;
            if($enAlmacen->count()>0){
                $p->stock=$enAlmacen[0]->stock;
                $p->base=$enAlmacen[0]->stock_base;
            }else{
                $p->stock=0;
                $p->base=0;
            }
        }
    }
    public function addAlmacen(){
        $this->validate([
            'productos'=>['required'],
            'productos.*.base'=>['required','gt:0'],
            'productos.*.stock'=>['required','gt:0']
        ],[
            'productos.required'=>'Seleccione los productos que se ingesarán al almacén',
            'productos.*.base'=>'Revise sus productos, el stock base debe ser mayor a cero',
            'productos.*.stock'=>'Revise sus productos, debe de contar con existencias en el almacén'
        ]);
        $count=0;
        foreach($this->productos as $producto){
            if (AlmacenCi::where('producto_id',$producto['id'])->count() > 0) {
                $update=AlmacenCi::where('producto_id',$producto['id'])
                ->update([
                    'stock_base'=>$producto['base'],
                    'stock'=>$producto['stock']
                ]);
                $count++;
            } else {
                $almacen=new AlmacenCi();
                $almacen->producto_id=$producto['id'];
                $almacen->stock_base=$producto['base'];
                $almacen->stock=$producto['stock'];
                $almacen->save();
            }
        }
        $count>0
        ?Alert::warning('Almacén Actualizado','Algunos productos seleccionados han sido actualizados')
        :Alert::success('Nuevos productos','Los registros han sido agregados correctamente');
        return redirect()->route('almacenCIS');
    }
    public function render()
    {
        return view('livewire.productos.almacen.asignar-stock');
    }
}
