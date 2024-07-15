<?php

namespace App\Http\Controllers;

use App\Models\comercio\Detalle_venta;
use App\Models\comercio\Secuenciales_venta;
use App\Models\Comercio\Venta;
use App\Models\inventario\Almacen;
use App\Models\inventario\CategoriaProducto;
use App\Models\inventario\Precios_add_producto;
use App\Models\inventario\Producto;
use App\Models\users\Cliente;
use Illuminate\Http\Request;

class VentaController extends Controller
{

    public function index()
    {
        return response()->json("LLEGO");
    }

    public function show(Request $request, $id)
    {
        $user_id = auth()->user()->id;
        // $clientes = Cliente::where('user_id',auth()->user()->id)->where('deshabilitado',0)->paginate(10);
        $almacenes = Almacen::where('user_id', $user_id)->where('deshabilitado', 0)->get();
        // $productos = Producto::where('user_id',auth()->user()->id)->where('deshabilitado',0)->paginate(10);
        $categoriasProducto = CategoriaProducto::where('user_id', $user_id)->where('deshabilitado', 0)->orderBy('nombre', 'ASC')->get();
        $preciosadicionales = Precios_add_producto::where('user_id', $user_id)->orderBy('descripcion', 'ASC')->get();
        $clientes = [];
        $venta = null;
        $detalles = [];
        $cliente = "";

        if ($id) {
            $venta = Venta::where('user_id', $user_id)->find($id);
            $detalles = Detalle_venta::where('venta_id', $id)->get();
            $cliente = @$venta->data_cliente;
        }

        return response()->json(compact('almacenes', 'preciosadicionales', 'categoriasProducto', 'venta', 'detalles', 'cliente'));
    }

    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        if ($request->id) {
           
            $venta = Venta::find($request->id);
        } else {
            $venta = new Venta;
            $secuencial = Secuenciales_venta::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->first();
            if (!$secuencial) {
                $secuencial = '000000001';
            } else {
                $secuencial = str_pad((intval($secuencial->secuencial) + 1), 9, "0", STR_PAD_LEFT);
            }
            $sv = new Secuenciales_venta;
            $sv->secuencial = $secuencial;
            $sv->user_id = $user_id;
            $sv->save();

            $venta->secuencial = $secuencial;
        }
        
        $venta->fill($request->totales);

        if ($request->cliente) {
            $cliente = $request->cliente;
            $venta->data_cliente = json_encode($cliente);
            $venta->cliente_id = 1;
        }

        $venta->user_id = $user_id;
        // totales = {
        //     subtotal_iva: 0,
        //     iva: 0,
        //     no_iva: 0,
        //     descuento: 0,
        //     total_sin_iva: 0,
        //     total: 0,
        //   };


        $venta->save();
        $id = $venta->id;
        Detalle_venta::where('venta_id', $request->id)->delete();
        foreach ($request->detalles as $index => $d) {
            $jsonArray = $d;
            $jsonArray = str_replace('{', '[', $jsonArray);
            $jsonArray = str_replace('}', ']', $jsonArray);
            // $jsonArray = json_decode($jsonArray);



            //  return response()->json((array)$jsonArray);
            $d = new Detalle_venta;
            $d->fill((array) $jsonArray);
            $d->venta_id = $venta->id;
            $d->save();
        }

        return response()->json(compact("venta", "id"));

        // totales
        // $venta->fill($request->all());
    }
}
