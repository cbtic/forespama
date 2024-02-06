<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlmaceneRequest;
use App\Models\Almacene;
use RealRashid\SweetAlert\Facades\Alert;

class AlmacenesController extends Controller
{
    public function index()
    {
        $almacenes = Almacene::latest()->paginate(10);
        return view('frontend.almacenes.index', compact('almacenes'));
    }

    public function create()
    {
        return view('frontend.almacenes.create');
    }

    public function store(AlmaceneRequest $request)
    {
        Almacene::create($request->all());

        return redirect()->route('frontend.almacenes.index');
    }

    public function edit(Almacene $almacenes)
    {

        return view('frontend.almacenes.edit', compact('almacenes'));
    }

    public function update(AlmaceneRequest $request, Almacene $almacenes)
    {
        $almacenes->update($request->all());

        // return redirect()->route('frontend.almacenes.show', $almacenes->id);
        return redirect()->route('frontend.almacenes.index');
    }

    public function show(Almacene $almacenes)
    {
        return view('frontend.almacenes.show', compact('almacenes'));
    }

    public function destroy(Almacene $almacenes)
    {
        $almacenes->delete();

        Alert::success('Proceso completo', 'Se ha eliminado el conductor');

        return redirect()->route('frontend.almacenes.index');
    }
}
