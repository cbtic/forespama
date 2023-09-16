<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConductoreRequest;
use App\Models\Conductore;

class ConductoreController extends Controller
{
    public function index()
    {
        $conductores = Conductore::latest()->paginate(12);

        return view('conductores.index', compact('conductores'));
    }

    public function create()
    {
        $options = ['ACTIVO' => 'ACTIVO', 'CANCELADO' => 'CANCELADO'];
        return view('conductores.create', compact('options'));
    }

    // public function store()
    public function store()
    {
        // Conductore::create($request->all());
        $data = request()->validate([
            'licencia' => 'required',
            'estado' => 'required',
        ]);

        dd('Conductore', $data);

        return redirect()->route('admin.conductores.index');
    }

    public function edit(Conductore $conductore)
    {
        return view('conductores.edit', compact('conductore'));
    }

    public function update(ConductoreRequest $request, Conductore $conductore)
    {
        $conductore->update($request->all());

        return redirect()->route('admin.conductores.show', $conductore->id);
    }

    public function show(Conductore $conductore)
    {
        return view('conductores.show', compact('conductore'));
    }

    public function destroy(Conductore $conductore)
    {
        $conductore->delete();

        return redirect()->route('admin.conductores.index');
    }
}
