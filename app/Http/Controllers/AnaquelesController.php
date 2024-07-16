<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnaqueleRequest;
use App\Models\Anaquele;
use RealRashid\SweetAlert\Facades\Alert;

class AnaquelesController extends Controller
{
    public function index()
    {
        $anaqueles = Anaquele::latest()->paginate(10);
        return view('frontend.anaqueles.index', compact('anaqueles'));
    }

    public function create()
    {
        return view('frontend.anaqueles.create');
    }

    public function modal_create($modal = 'modal')
    {
        return view('frontend.anaqueles.modal_create', compact('modal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnaqueleRequest $request)
    {
        $anaquele = Anaquele::create($request->all());

        if($anaquele->save()) {
            return response()->json( [ 'success' => 'Anaquel guardado!', 'id' => $anaquele->id, 'denominacion' => $anaquele->denominacion ] );
        } else {
            return response()->json( [ 'errors' => 'Errores!' ] );
        }
        // return redirect()->route('frontend.productos.index');
    }

    public function edit(Anaquele $anaqueles)
    {

        return view('frontend.anaqueles.edit', compact('anaqueles'));
    }

    public function update(AnaqueleRequest $request, Anaquele $anaqueles)
    {
        $anaqueles->update($request->all());

        $anaqueles->secciones()->sync($request->id_secciones);

        // return redirect()->route('frontend.anaqueles.show', $anaqueles->id);
        return redirect()->route('frontend.anaqueles.index');
    }

    public function show(Anaquele $anaqueles)
    {
        return view('frontend.anaqueles.show', compact('anaqueles'));
    }

    public function destroy(Anaquele $anaqueles)
    {
        if ($anaqueles->delete()) {
            Alert::success('Proceso completo', 'Se ha eliminado el anaquel '.$anaqueles['codigo']);
        }
        return redirect()->route('frontend.anaqueles.index');
    }
}
