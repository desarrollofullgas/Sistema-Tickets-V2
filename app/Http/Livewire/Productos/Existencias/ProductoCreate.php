<?php

namespace App\Http\Livewire\Productos\Existencias;

use Livewire\Component;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Zona;
use App\Models\Marca;
use App\Models\Modelo;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithFileUploads;

class ProductoCreate extends Component
{
    use WithFileUploads;
    public $name,$descripcion,$unidad,$modelo,$categoria,$marca,$imagen,$urlImg,$modal=false,$prioridad;
    public function addProducto(){
        $this->validate([
            'name' =>['required'],
            'descripcion' =>['required'],
            'unidad' => ['required','not_in:0'],
            'imagen' =>['required'],
            'modelo' =>['required'],
            'prioridad' => ['required','not_in:0'],
            'categoria' =>['required','not_in:0'],
            'marca' =>['required','not_in:0'],
        ],[
            'name.required' => 'Ingrese el nombre del producto',
            'descripcion.required' =>'Ingrese la descripcion o las caracteristicas',
            'unidad.required' => 'Seleccione una unidad de medida',
            'imagen.required' => 'Cargue una imagen del producto',
            'modelo.required' => 'Ingrese el modelo del producto',
            'categoria.required' => 'Seleccione una categoría para el producto',
            'marca.required' => 'Seleccione la marca del producto',
            'prioridad.required' => 'Seleccione una prioridad para el producto',
        ]);
        $this->urlImg=$this->imagen->store('tck/productos', 'public');
        $producto=new Producto();
        $producto->name=$this->name;
        $producto->descripcion=$this->descripcion;
        $producto->unidad=$this->unidad;
        $producto->modelo=$this->modelo;
        $producto->categoria_id=$this->categoria;
        $producto->marca_id=$this->marca;
        $producto->prioridad=$this->prioridad;
        $producto->product_photo_path=$this->urlImg;
        $producto->save();
        Alert::success('Nuevo Producto', "EL producto ha sido registrado en el sistema");
        return redirect()->route('productos');
        
        //dd($this->imagen);
    }
  
    public function render()
    { 
        $categorias = Categoria::where('status','Activo')->get();
        $marcas=Marca::select('*')->orderBy('name', 'ASC')->get();
        return view('livewire.productos.existencias.producto-create', compact('categorias','marcas'));
    }
}
