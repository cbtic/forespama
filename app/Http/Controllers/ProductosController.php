<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoRequest;
use App\Models\Producto;
use RealRashid\SweetAlert\Facades\Alert;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::latest()->paginate(10);

        return view('frontend.productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.productos.create');
    }

    public function modal_create($modal = 'modal')
    {
        return view('frontend.productos.modal_create', compact('modal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductoRequest $request)
    {
        $secciones = Producto::create($request->all());

        return redirect()->route('frontend.productos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $productos)
    {
        return view('frontend.productos.show', compact('productos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $productos)
    {
        return view('frontend.productos.edit', compact('productos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductoRequest $request, Producto $productos)
    {
        $productos->update($request->all());

        return redirect()->route('frontend.productos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $productos)
    {
        if ($productos->delete()) {
            Alert::success('Proceso completo', 'Se ha eliminado el producto '.$productos['codigo']);
        };
        return redirect()->route('frontend.productos.index');
    }
}
