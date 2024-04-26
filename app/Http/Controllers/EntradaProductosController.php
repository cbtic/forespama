<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EntradaProductoRequest;
use App\Models\EntradaProducto;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;

class EntradaProductosController extends Controller
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
    public function index()
    {
        $entrada_productos = EntradaProducto::latest()->paginate(10);

        return view('frontend.entrada_productos.index', compact('entrada_productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.entrada_productos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $entrada_productos = EntradaProducto::create($request->all());

        return redirect()->route('frontend.entrada_productos.edit', compact('entrada_productos'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(EntradaProducto $entrada_productos)
    {
        // dd($entrada_productos);exit;

        return view('frontend.entrada_productos.show', compact('entrada_productos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(EntradaProducto $entrada_productos)
    {
        return view('frontend.entrada_productos.edit', compact('entrada_productos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EntradaProductoRequest $request, EntradaProducto $entrada_productos)
    {
        $entrada_productos->update($request->all());

        return redirect()->route('frontend.entrada_productos.edit', compact('entrada_productos'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EntradaProducto $entrada_productos)
    {
        if ($entrada_productos->delete()) {
            Alert::success('Proceso completo', 'Se ha eliminado la entrada '.$entrada_productos['id']);
        };
        return redirect()->route('frontend.entrada_productos.index');
    }
}
