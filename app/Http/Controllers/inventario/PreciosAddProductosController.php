<?php

namespace App\Http\Controllers\inventario;

use App\Http\Controllers\Controller;
use App\Models\inventario\Precios_add_producto;
use Illuminate\Http\Request;

class PreciosAddProductosController extends Controller
{

    public function index(Request $request)
    {
        $request->estado == 'Activos' ? $disable = 0 : $disable = 1;
        $Productos = Precios_add_producto::where('user_id', auth()->user()->id)->get();

        return response()->json(['data' => $Productos]);
    }

    public function store(Request $request)
    {
       
        if ($request->id) {
            $c = Precios_add_producto::find($request->id);
            $action = 'actualizado';
        } else {
            $c = new Precios_add_producto;
            $action = 'guardado';
        }

        $c->fill($request->all());
        $c->user_id = auth()->user()->id;
        $c->save();

        return response()->json(['message' => 'El precio adicional ha sido ' . $action . ' con éxito.']);
    }

    public function destroy($id)
    {
        $c = Precios_add_producto::find($id);
        $c->delete();

        return response()->json(['message' => 'El recio adicional ha sido eliminado.']);
    }


}
