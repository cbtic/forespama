<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\EntradaProductoDetalle;
use RealRashid\SweetAlert\Facades\Alert;
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
    public function create()
    {
        return view('frontend.entrada_producto_detalles.create');
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

        return redirect()->route('frontend.entrada_producto_detalles.index');
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
        $entrada_producto_detalles->update($request->all());

        return redirect()->route('frontend.entrada_producto_detalles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EntradaProductoDetalle $entrada_producto_detalles)
    {
        if ($entrada_producto_detalles->delete()) {
            Alert::success('Proceso completo', 'Se ha eliminado la entrada '.$entrada_producto_detalles['id']);
        };
        return redirect()->route('frontend.entrada_producto_detalles.index');
    }
}
