<?php

namespace App\Http\Controllers\inventario;
use App\Http\Controllers\Controller;
use App\Models\inventario\Almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AlmacenController extends Controller
{
    
    public function index(Request $request)
    {
        $request->estado == 'Activos' ? $disable = 0 : $disable = 1;
        $Almacens = Almacen::where('deshabilitado', $disable)->get();
        return response()->json(['data' => $Almacens]);
    }
  
    public function store(Request $request)
    {
        if ($request->id) {
            $c = Almacen::find($request->id);
            $action = 'actualizado';
        } else {
            $c = new Almacen;
            $action = 'guardado';
        }

        $c->fill($request->all());
        $c->user_id = auth()->user()->id;
        $c->save();

        return response()->json(['message'=>'El Almacén ha sido ' . $action . ' con éxito.']);
    }

    public function disabled($id)
    {
        $c = Almacen::find($id);
        $c->deshabilitado = 1;
        $c->save();

        return response()->json(['message'=>'El elemento ha sido deshailitado.']);
    }

    public function habilitar_eliminar_lote(Request $request)
    {
        if ($request->accion == 'eliminar') {
            if (!Hash::check($request->password, auth()->user()->password)) {
                $errors = ['password' => 'La contraseña ingresada es incorrecta'];
                return response()->json(['message'=>'Se detectaron errores de algunos campos','errors'=>$errors], 400);
            }
            $Almacens = Almacen::where('user_id', auth()->user()->id)->whereIn('id', $request->selected)->get();
            foreach ($Almacens as $index => $s) {
                $s->delete();
            }
            return response()->json(['message' => 'Los elementos han sido eliminados con éxito.']);
        } else if ($request->accion == 'habilitar') {
            $Almacens = Almacen::where('user_id', auth()->user()->id)->where('deshabilitado',1)->whereIn('id', $request->selected)->get();
            foreach ($Almacens as $index => $s) {
                $s->deshabilitado = 0;
                $s->save();
            }
            return response()->json(['message' => 'Los elementos han sido habilitados con éxito.']);
        }
    }
}
