<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TablaMaestra;
use Illuminate\Http\Request;

class TablaMaestraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return view('frontend.tabla_maestras.all');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TablaMaestra  $tablaMaestra
     * @return \Illuminate\Http\Response
     */
    public function show(TablaMaestra $tablaMaestra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TablaMaestra  $tablaMaestra
     * @return \Illuminate\Http\Response
     */
    public function edit(TablaMaestra $tablaMaestra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TablaMaestra  $tablaMaestra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TablaMaestra $tablaMaestra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TablaMaestra  $tablaMaestra
     * @return \Illuminate\Http\Response
     */
    public function destroy(TablaMaestra $tablaMaestra)
    {
        //
    }

	public function listar_tabla_maestras_ajax(Request $request){

		$tabla_maestras_model = new TablaMaestra;
		$p[]=$request->tipo;
		$p[]=$request->denominacion;
		$p[]=$request->orden;
		$p[]=$request->estado;
		$p[]=$request->codigo;
		$p[]=$request->tipo_nombre;
		$data = $tabla_maestras_model->listar_tabla_maestras_ajax($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;

		$result["PageStart"] = $request->NumeroPagina;
		$result["pageSize"] = $request->NumeroRegistros;
		$result["SearchText"] = "";
		$result["ShowChildren"] = true;
		$result["iTotalRecords"] = $iTotalDisplayRecords;
		$result["iTotalDisplayRecords"] = $iTotalDisplayRecords;
		$result["aaData"] = $data;

		echo json_encode($result);

	}

	public function modal_tablamaestras($id){

		if ($id>0) $tabla_maestra = TablaMaestra::find($id);
		else $tabla_maestra = new TablaMaestra;

		return view('frontend.tabla_maestras.modal_tablamaestras',compact('id','tabla_maestra'));
	}

	public function eliminar_tablamaestras($id,$estado)
    {
		$tabla_maestra = TablaMaestra::find($id);
		$tabla_maestra->estado = $estado;
		$tabla_maestra->save();

		echo $tabla_maestra->id;
    }
}
