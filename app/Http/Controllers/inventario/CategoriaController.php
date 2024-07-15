<?php

namespace App\Http\Controllers\inventario;

use App\Http\Controllers\Controller;
use App\Models\inventario\CategoriaProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $request->estado == 'Activos' ? $disable = 0 : $disable = 1;
        $CategoriaProductos = CategoriaProducto::where('deshabilitado', $disable)->get();
        return response()->json(['data' => $CategoriaProductos]);
    }

    public function store(Request $request)
    {
        if ($request->id) {
            $c = CategoriaProducto::find($request->id);
            $action = 'actualizado';
        } else {
            $c = new CategoriaProducto;
            $action = 'guardado';
        }

        $c->fill($request->all());
        $c->user_id = auth()->user()->id;
        $c->save();

        return response()->json(['message' => 'La categoría ha sido ' . $action . ' con éxito.']);
    }

    public function disabled($id)
    {
        $c = CategoriaProducto::find($id);
        $c->deshabilitado = 1;
        $c->save();

        return response()->json(['message' => 'El elemento ha sido deshabilitado.']);
    }

    public function habilitar_eliminar_lote(Request $request)
    {
        if ($request->accion == 'eliminar') {
            if (!Hash::check($request->password, auth()->user()->password)) {
                $errors = ['password' => 'La contraseña ingresada es incorrecta'];
                return response()->json(['message' => 'Se detectaron errores de algunos campos', 'errors' => $errors], 400);
            }
            $CategoriaProductos = CategoriaProducto::where('user_id', auth()->user()->id)->whereIn('id', $request->selected)->get();
            foreach ($CategoriaProductos as $index => $s) {
                $s->delete();
            }
            return response()->json(['message' => 'Los elementos han sido eliminados con éxito.']);
        } else if ($request->accion == 'habilitar') {
            $CategoriaProductos = CategoriaProducto::where('user_id', auth()->user()->id)->where('deshabilitado', 1)->whereIn('id', $request->selected)->get();
            foreach ($CategoriaProductos as $index => $s) {
                $s->deshabilitado = 0;
                $s->save();
            }
            return response()->json(['message' => 'Los elementos han sido habilitados con éxito.']);
        }
    }
}