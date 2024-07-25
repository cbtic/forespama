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

    public function modal_create($modal = 'modal')
    {
        return view('frontend.lotes.modal_create', compact('modal'));
    }

    public function store(LoteRequest $request)
    {
        $lote = Lote::create($request->all());

        if($lote->save()) {
            return response()->json( [ 'success' => 'Lote guardado!', 'id' => $lote->id, 'numero_serie' => $lote->numero_serie ] );
        } else {
            return response()->json( [ 'errors' => 'Errores!' ] );
        }
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
