<?php

namespace App\Http\Controllers;

use Illuminate\Http\AnaqueleRequest;
use App\Models\Anaquele;
use RealRashid\SweetAlert\Facades\Alert;

class AnaqueleController extends Controller
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

    public function store(AnaqueleRequest $request)
    {
        Anaquele::create($request->all());

        return redirect()->route('frontend.anaqueles.index');
    }

    public function edit(Anaquele $anaqueles)
    {

        return view('frontend.anaqueles.edit', compact('anaqueles'));
    }

    public function update(AnaqueleRequest $request, Anaquele $anaqueles)
    {
        $anaqueles->update($request->all());

        // return redirect()->route('frontend.anaqueles.show', $anaqueles->id);
        return redirect()->route('frontend.anaqueles.index');
    }

    public function show(Anaquele $anaqueles)
    {
        return view('frontend.anaqueles.show', compact('anaqueles'));
    }

    public function destroy(Anaquele $anaqueles)
    {
        $anaqueles->delete();

        Alert::success('Proceso completo', 'Se ha eliminado el conductor');

        return redirect()->route('frontend.anaqueles.index');
    }
}
