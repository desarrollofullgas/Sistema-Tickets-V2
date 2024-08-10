<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    public $filterSoli;
    public $categos;

    public function index(Request $request)
    {
        $valid = Auth::user()->permiso->panels->where('id', 15)->first();

        
        $trashed = Producto::onlyTrashed()->count();
       if (Auth::user()->permiso->id == 1) {
             return view('modules.productos.existencias.productos',compact('trashed','valid'));
         } elseif ($valid->pivot->re == 1) {
             return view('modules.productos.existencias.productos',compact('trashed','valid'));
         } else {
             return redirect()->route('dashboard');
         }
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return back()->with('eliminar', 'ok');
    }

    public function trashed_productos()
    {
        $valid = Auth::user()->permiso->panels->where('id', 8)->first();

        $trashed = Producto::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.productos.existencias.productotrashed", [
            "trashed" => $trashed,
            "valid" => $valid,
        ]);
    }

    public function do_restore()
{
    $producto = Producto::withTrashed()->find(request()->id);
    if ($producto == null)
    {
        abort(404);
    }
 
    $producto->restore();
    return redirect()->back();
}

public function delete_permanently()
{
    $producto = Producto::withTrashed()->find(request()->id);
    if ($producto == null)
    {
        abort(404);
    }
 
    $producto->forceDelete();
    return redirect()->back();
}
}
