<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;

use App\Models\users\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{

    public function index(Request $request)
    {
        ($request->estado == 'Activos' || !$request->estado) ? $disable = 0 : $disable = 1;
        $clientes = Cliente::where('deshabilitado', $disable)
            ->where(function ($query) use ($request) {
                if ($request->busqueda)
                    $query->where('clientes.razon_social', 'LIKE', '%' . $request->busqueda . '%')->orWhere('clientes.identificacion', $request->busqueda);
            })
            ->select('id', 'tipo_ident', 'identificacion', 'nombre_comercial', 'razon_social', 'email', 'telefono', 'ciudad', 'direccion')
            ->get();
        return response()->json(['data' => $clientes]);
    }


    public function store(Request $request)
    {
        if ($request->id) {
            $c = Cliente::find($request->id);
            $action = 'actualizado';
        } else {
            $c = new Cliente;
            $action = 'guardado';
        }

        $c->fill($request->all());
        $c->user_id = auth()->user()->id;
        $c->save();

        return response()->json(['message' => 'El cliente ha sido ' . $action . ' con éxito.', 'cliente' => $c]);
    }

    public function disabled($id)
    {
        $c = Cliente::find($id);
        $c->deshabilitado = 1;
        $c->save();

        return response()->json(['message' => 'El elemento ha sido deshailitado.']);
    }

    public function habilitar_eliminar_lote(Request $request)
    {
        if ($request->accion == 'eliminar') {
            if (!Hash::check($request->password, auth()->user()->password)) {
                $errors = ['password' => 'La contraseña ingresada es incorrecta'];
                return response()->json(['message' => 'Se detectaron errores de algunos campos', 'errors' => $errors], 400);
            }
            $clientes = Cliente::where('user_id', auth()->user()->id)->whereIn('id', $request->selected)->get();
            foreach ($clientes as $index => $s) {
                $s->delete();
            }
            return response()->json(['message' => 'Los elementos han sido eliminados con éxito.']);
        } else if ($request->accion == 'habilitar') {
            $clientes = Cliente::where('user_id', auth()->user()->id)->where('deshabilitado', 1)->whereIn('id', $request->selected)->get();
            foreach ($clientes as $index => $s) {
                $s->deshabilitado = 0;
                $s->save();
            }
            return response()->json(['message' => 'Los elementos han sido habilitados con éxito.']);
        }
    }
}