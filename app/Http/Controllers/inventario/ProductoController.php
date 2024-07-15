<?php

namespace App\Http\Controllers\inventario;

use App\Http\Controllers\Controller;
use App\Models\inventario\Almacen;
use App\Models\inventario\Almacenes_producto;
use App\Models\inventario\CategoriaProducto;
use App\Models\inventario\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProductoController extends Controller
{

    public function index(Request $request)
    {

        if (!$request->estado) {
            $disable = 0;
        } else {
            $request->estado == 'Activos' ? $disable = 0 : $disable = 1;
        }

        if ($request->almacen_id) {
            $columns = ['productos.id', 'productos.categoria_producto_id', 'productos.imagenes', 'productos.descripcion', 'productos.codigo', 'productos.precio_compra', 'productos.porcentaje_ganancia', 'productos.ganancia', 'productos.precio_venta_sin_iva', 'productos.editar_precio', 'productos.grabaiva', 'productos.precio_venta', 'productos.precio_venta', 'categoria_productos.nombre as categoria', 'almacenes_productos.cantidad as stock'];
        } else {
            $columns = ['productos.id', 'productos.categoria_producto_id', 'productos.imagenes', 'productos.descripcion', 'productos.codigo', 'productos.precio_compra', 'productos.porcentaje_ganancia', 'productos.ganancia', 'productos.precio_venta_sin_iva', 'productos.editar_precio', 'productos.grabaiva', 'productos.precio_venta', 'productos.precio_venta', 'categoria_productos.nombre as categoria'];
        }

        $disable = 0;
        $productos = Producto::where('productos.user_id', auth()->user()->id)

            ->leftJoin('almacenes_productos', 'almacenes_productos.producto_id', '=', 'productos.id')
            ->leftJoin('categoria_productos', 'productos.categoria_producto_id', '=', 'categoria_productos.id')

            ->where(function ($query) use ($request) {
                if ($request->almacen_id)
                    $query->where('almacenes_productos.almacen_id', $request->almacen_id);
                if ($request->categoria_id)
                    $query->where('productos.categoria_producto_id', $request->categoria_id);

            })

            ->with('almacenes')

            ->select($columns)
            ->distinct('productos.id')
            ->get();

        return response()->json($productos);
    }

    public function recursos(Request $request)
    {
        $almacenes = Almacen::where('user_id', auth()->user()->id)->orderBy('nombre', 'ASC')->get();
        $categorias = CategoriaProducto::where('user_id', auth()->user()->id)->orderBy('nombre', 'ASC')->get();

        return response()->json(compact('almacenes', 'categorias'));
    }

    public function store(Request $request)
    {
        // $request->validate
        $this->validate($request, [
            'codigo' => 'unique:productos,codigo,' . $request->id,
        ]);
        if ($request->id) {
            $c = Producto::find($request->id);
            $action = 'actualizado';
        } else {
            $c = new Producto;
            $action = 'guardado';
        }

        $c->fill($request->all());
        $c->user_id = auth()->user()->id;
        $c->save();

        $almacenesSelect = [];
        // guarda los almacenes 
        foreach ($request->almacenes as $index => $a) {

            $alm_p = Almacenes_producto::where('almacen_id', $a['almacen_id'])->where('producto_id', $c->id)->first();
            if (!$alm_p) {
                $alm_p = new Almacenes_producto;
                $alm_p->producto_id = $c->id;
                $alm_p->almacen_id = $a['almacen_id'];
            }
            $alm_p->cantidad = $a['cantidad'];
            $alm_p->save();
            $almacenesSelect[] = $a['almacen_id'];
        }

        // borra los almacenes quitados de selección
        if (count($almacenesSelect) != 0) {
            $alm_no_selec = Almacenes_producto::whereNotIn('almacen_id', $almacenesSelect)->where('producto_id', $c->id)->delete();
        }

        return response()->json(['message' => 'La categoría ha sido ' . $action . ' con éxito.']);
    }

    public function disabled($id)
    {
        $c = Producto::find($id);
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
            $Productos = Producto::where('user_id', auth()->user()->id)->whereIn('id', $request->selected)->get();
            foreach ($Productos as $index => $s) {
                $s->delete();
            }
            return response()->json(['message' => 'Los elementos han sido eliminados con éxito.']);
        } else if ($request->accion == 'habilitar') {
            $Productos = Producto::where('user_id', auth()->user()->id)->where('deshabilitado', 1)->whereIn('id', $request->selected)->get();
            foreach ($Productos as $index => $s) {
                $s->deshabilitado = 0;
                $s->save();
            }
            return response()->json(['message' => 'Los elementos han sido habilitados con éxito.']);
        }
    }
}