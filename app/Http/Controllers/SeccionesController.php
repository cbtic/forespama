<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeccioneRequest;
use App\Models\Seccione;
use Illuminate\Http\Request;

class SeccionesController extends Controller
{
    public function index()
    {
        $secciones = Seccione::latest()->paginate(10);
        return view('frontend.secciones.index', compact('secciones'));
    }

    public function create()
    {
        return view('frontend.secciones.create');
    }

    public function store(SeccioneRequest $request)
    {
        $secciones = Seccione::create($request->all());

        $secciones->almacenes()->sync($request->id_almacenes);
        $secciones->anaqueles()->sync($request->id_anaqueles);

        return redirect()->route('frontend.secciones.index');
    }

    public function edit(Seccione $secciones)
    {

        return view('frontend.secciones.edit', compact('secciones'));
    }

    public function update(SeccioneRequest $request, Seccione $secciones)
    {
        $secciones->update($request->all());

        $secciones->almacenes()->sync($request->id_almacenes);
        $secciones->anaqueles()->sync($request->id_anaqueles);

        // return redirect()->route('frontend.secciones.show', $secciones->id);
        return redirect()->route('frontend.secciones.index');
    }

    public function show(Seccione $secciones)
    {
        return view('frontend.secciones.show', compact('secciones'));
    }

    public function destroy(Seccione $secciones)
    {
        $secciones->delete();

        Alert::success('Proceso completo', 'Se ha eliminado el conductor');

        return redirect()->route('frontend.secciones.index');
    }
}
