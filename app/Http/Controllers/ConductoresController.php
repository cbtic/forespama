<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConductoresRequest;
use App\Models\Conductores;

class ConductoresController extends Controller
{
    public function index()
    {
        $conductores = Conductores::latest()->paginate(12);

        return view('conductores.index', compact('conductores'));
    }

    public function create()
    {
        return view('conductores.create');
    }

    public function store(ConductoresRequest $request)
    {
        Conductores::create($request->all());

        return redirect()->route('conductores.index');
    }

    public function edit(Conductores $conductores)
    {
        return view('conductores.edit', compact('conductores'));
    }

    public function update(ConductoresRequest $request, Conductores $conductores)
    {
        $conductores->update($request->all());

        return redirect()->route('conductores.show', $conductores->id);
    }

    public function show(Conductores $conductores)
    {
        return view('conductores.show', compact('conductores'));
    }

    public function destroy(Conductores $conductores)
    {
        $conductores->delete();

        return redirect()->route('conductores.index');
    }
}
