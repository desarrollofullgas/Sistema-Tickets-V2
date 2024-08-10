<?php

namespace App\Http\Controllers;

use App\Models\FoliosEntrada;
use App\Models\FoliosSalida;
use Illuminate\Http\Request;

class FolioController extends Controller
{
    public function entradas(Request $request){
        // $folios=FoliosEntrada::orderBy('id','DESC')->paginate(15);
        // $folios = FoliosEntrada::where(function ($query) use ($request) {
        //     $search = $request->input('search');
        //     if ($search ) {
        //         $query->where('id', 'LIKE', '%' . $search . '%')
        //             ->orWhere('folio', 'LIKE', '%' . $search . '%');
        //     } 
        // })
        // ->orderBy('id', 'desc')
        // ->paginate(10)
        // ->withQueryString();
        return view('modules.folios.entrada');
    }
    public function salidas(Request $request){
        //$folios=FoliosSalida::orderBy('id','DESC')->paginate(15);
        // $folios = FoliosSalida::where(function ($query) use ($request) {
        //     $search = $request->input('search');
        //     if ($search ) {
        //         $query->where('id', 'LIKE', '%' . $search . '%')
        //             ->orWhere('folio', 'LIKE', '%' . $search . '%');
        //     } 
        // })
        // ->orderBy('id', 'desc')
        // ->paginate(10)
        // ->withQueryString();
        return view('modules.folios.salida');
    }
    public function editEntrada($id){
        $id=$id;
        return view('modules.folios.entrada.edit', compact('id'));
    }
    public function editSalida($id){
        $id=$id;
        return view('modules.folios.salida.edit', compact('id'));
    }
}
