<?php

namespace App\Http\Livewire\Productos\Existencias;

use Livewire\Component;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithFileUploads;

class ProductoEdit extends Component
{
    use WithFileUploads;
    public $productoID,$name,$descripcion,$unidad,$modelo,$categoria,$marca,$prioridad,$imagen,$urlImg,$modal=false;

    public function editProducto(Producto $dato){
        //dd($this->descripcion);
        $this->name=$dato->name;
        $this->descripcion=$dato->descripcion;
        $this->unidad=$dato->unidad;
        $this->modelo=$dato->modelo;
        $this->categoria=$dato->categoria_id;
        $this->marca=$dato->marca_id;
        $this->prioridad=$dato->prioridad;
        $this->modal=true;
    }
    public function updateProducto(Producto $dato){
        $this->validate([
            'name' =>['required'],
            'descripcion' =>['required'],
            'unidad' => ['required','not_in:0'],
            'modelo' =>['required'],
            'categoria' =>['required','not_in:0'],
            'marca' =>['required','not_in:0'],
            'prioridad'=>['required','not_in:0'],
        ],[
            'name.required' => 'Ingrese el nombre del producto',
            'descripcion.required' =>'Ingrese la descripcion o las caracteristicas',
            'unidad.required' => 'Seleccione una unidad de medida',
            'modelo.required' => 'Ingrese el modelo del producto',
            'categoria.required' => 'Seleccione una categoría para el producto',
            'marca.required' => 'Seleccione la marca del producto',
            'prioridad.required' => 'Seleccione la prioridad del producto',
        ]);
        $dato->name=$this->name;
        $dato->descripcion=$this->descripcion;
        $dato->unidad=$this->unidad;
        $dato->modelo=$this->modelo;
        $dato->categoria_id=$this->categoria;
        $dato->marca_id=$this->marca;
        $dato->prioridad=$this->prioridad;
        if($this->imagen !=null){
            $this->urlImg=$this->imagen->store('tck/productos', 'public');
            Storage::disk('public')->delete($dato->product_photo_path);
            $dato->product_photo_path=$this->urlImg;
        }
        $dato->save();
        Alert::success('Actualización realizada','Los datos del registro se actualizaron con éxito');
        // return redirect()->route('productos');
        return redirect(request()->header('Referer'));
    }
    public function render()
    {
        $categorias = Categoria::all();
        $marcas=Marca::select('*')->orderBy('name', 'ASC')->get();
        return view('livewire.productos.existencias.producto-edit', compact('categorias','marcas'));
    }
}
