<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoteRequest;
use App\Models\Lote;
use RealRashid\SweetAlert\Facades\Alert;

class LoteController extends Controller
{
    public function index()
    {
        $lotes = Lote::latest()->paginate(10);
        return view('frontend.lotes.index', compact('lotes'));
    }

    public function create()
    {
        return view('frontend.lotes.create');
    }

    public function store(LoteRequest $request)
    {
        $lotes = Lote::create($request->all());

        return redirect()->route('frontend.lotes.index');
    }

    public function edit(Lote $lotes)
    {

        return view('frontend.lotes.edit', compact('lotes'));
    }

    public function update(LoteRequest $request, Lote $lotes)
    {
        $lotes->update($request->all());

        return redirect()->route('frontend.lotes.index');
    }

    public function show(Lote $lotes)
    {
        return view('frontend.lotes.show', compact('lotes'));
    }

    public function destroy(Lote $lotes)
    {
        if ($lotes->delete()) {
            Alert::success('Proceso completo', 'Se ha eliminado el lote #'.$lotes['numero_lote']);
        };
        return redirect()->route('frontend.lotes.index');
    }
}
