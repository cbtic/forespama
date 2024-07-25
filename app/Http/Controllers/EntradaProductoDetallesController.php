<?php

namespace App\Http\Controllers;

use Auth;
use DateTime;
use App\Models\Kardex;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use App\Models\EntradaProductoDetalle;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\EntradaProductoRequest;
use App\Http\Requests\EntradaProductoDetalleRequest;

class EntradaProductoDetallesController extends Controller
{
	public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($entrada_producto)
    {
        // dd(2);
        $entrada_producto_detalles = EntradaProductoDetalle::latest()->paginate(10);

        return view('frontend.entrada_producto_detalles.index', compact('entrada_producto_detalles', 'entrada_producto'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($entrada_producto)
    {
        return view('frontend.entrada_producto_detalles.create', compact('entrada_producto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        // exit;
        $entrada_producto_detalles = EntradaProductoDetalle::create($request->all());

        $kardex = Kardex::updateOrCreate(
            ['id_producto' => $entrada_producto_detalles->id_producto]
        );

        $kardex = Kardex::updateOrCreate(
            ['id_producto' => $entrada_producto_detalles->id_producto],
            ['entradas_cantidad' => ($kardex->entradas_cantidad + $entrada_producto_detalles->cantidad)]
        );

        Kardex::updateOrCreate(
            ['id_producto' => $entrada_producto_detalles->id_producto],
            ['saldos_cantidad' => ($kardex->entradas_cantidad - $kardex->salidas_cantidad)]
        );

        $movimiento = new Movimiento;
        $movimiento->id_producto = $entrada_producto_detalles->id_producto;
        $movimiento->numero_lote = $entrada_producto_detalles->numero_lote;
        $movimiento->tipo_movimiento = 'ENTRADA';
        $movimiento->entrada_salida_cantidad = $entrada_producto_detalles->cantidad;
        $movimiento->costo_entrada_salida = $entrada_producto_detalles->costo;
        $movimiento->id_users = Auth::id();
        $movimiento->id_personas = Auth::id();
        $movimiento->fecha_movimiento = date_format(new DateTime(), 'Y-m-d H:i:s');
        $movimiento->save();

        return redirect()->route('frontend.entrada_productos.edit', $entrada_producto_detalles['id_entrada_productos']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(EntradaProductoDetalle $entrada_producto_detalles)
    {
        return view('frontend.entrada_producto_detalles.show', compact('entrada_producto_detalles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function edit(EntradaProductoDetalle $entrada_producto_detalles)
     {
         return view('frontend.entrada_producto_detalles.edit', compact('entrada_producto_detalles'));
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EntradaProductoDetalleRequest $request, EntradaProductoDetalle $entrada_producto_detalles)
    {

        $kardex = Kardex::updateOrCreate(
            ['id_producto' => $entrada_producto_detalles->id_producto]
        );

        $kardex = Kardex::updateOrCreate(
            ['id_producto' => $entrada_producto_detalles->id_producto],
            ['entradas_cantidad' => ($kardex->entradas_cantidad + $request->cantidad - $entrada_producto_detalles->cantidad)]
        );

        Kardex::updateOrCreate(
            ['id_producto' => $entrada_producto_detalles->id_producto],
            ['saldos_cantidad' => ($kardex->entradas_cantidad - $kardex->salidas_cantidad)]
        );

        $entrada_producto_detalles->update($request->all());

        return redirect()->route('frontend.entrada_productos.edit', $entrada_producto_detalles['id_entrada_productos']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EntradaProductoDetalle $entrada_producto_detalles)
    {
        $kardex = Kardex::updateOrCreate(
            ['id_producto' => $entrada_producto_detalles->id_producto]
        );

        $kardex = Kardex::updateOrCreate(
            ['id_producto' => $entrada_producto_detalles->id_producto],
            ['entradas_cantidad' => ($kardex->entradas_cantidad - $entrada_producto_detalles->cantidad)]
        );

        Kardex::updateOrCreate(
            ['id_producto' => $entrada_producto_detalles->id_producto],
            ['saldos_cantidad' => ($kardex->entradas_cantidad - $kardex->salidas_cantidad)]
        );

        if ($entrada_producto_detalles->delete()) {
            Alert::success('Proceso completo', 'Se ha eliminado la entrada '.$entrada_producto_detalles['id']);
        };
        return redirect()->route('frontend.entrada_productos.edit', $entrada_producto_detalles['id_entrada_productos']);
    }
}
