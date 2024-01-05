<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Conductore;
use Illuminate\Http\Request;

class ConductoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return view('frontend.conductores.all');
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
     * @param  \App\Models\Conductore  $Conductore
     * @return \Illuminate\Http\Response
     */
    public function show(Conductore $Conductore)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conductore  $Conductore
     * @return \Illuminate\Http\Response
     */
    public function edit(Conductore $Conductore)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conductore  $Conductore
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conductore $Conductore)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conductore  $Conductore
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conductore $Conductore)
    {
        //
    }

	public function listar_tabla_maestras_ajax(Request $request){

		$tabla_maestras_model = new Conductore;
		$p[]=$request->tipo;
		$p[]=$request->estado;
		$p[]=$request->codigo;
		$p[]=$request->tipo_nombre;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
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

	public function send(Request $request){

		if($request->id == 0){

			// $tipo=$request->tipo;

			// if($tipo==""){
			// 	$array_tipo = array('DNI' => 'DNI','CARNET_EXTRANJERIA' => 'CE','PASAPORTE' => 'PAS','RUC' => 'RUC','CEDULA' => 'CED','PTP/PTEP' => 'PTP/PTEP');
			// 	$codigo = $array_tipo[$request->tipo]."-".$request->numero_documento;
			// }

			$tabla_maestra = new Conductore;
			$tabla_maestra->tipo = $request->tipo;
			$tabla_maestra->denominacion = $request->denominacion;
			$tabla_maestra->orden = $request->orden;
			$tabla_maestra->estado = $request->estado;
			$tabla_maestra->codigo = $request->codigo;
			$tabla_maestra->tipo_nombre = $request->tipo_nombre;
			$tabla_maestra->save();
		}else{
			$tabla_maestra = Conductore::find($request->id);
			$tabla_maestra->tipo = $request->tipo;
			$tabla_maestra->denominacion = $request->denominacion;
			$tabla_maestra->orden = $request->orden;
			$tabla_maestra->estado = $request->estado;
			$tabla_maestra->codigo = $request->codigo;
			$tabla_maestra->tipo_nombre = $request->tipo_nombre;
			$tabla_maestra->save();
		}
    }

	public function modal_Conductores($id){

		if ($id>0) $tabla_maestra = Conductore::find($id);
		else $tabla_maestra = new Conductore;

		return view('frontend.conductores.modal_Conductores',compact('id','tabla_maestra'));
	}

	public function eliminar_tabla_maestra($id,$estado)
    {
		$tabla_maestra = Conductore::find($id);
		$tabla_maestra->estado = $estado;
		$tabla_maestra->save();

		echo $tabla_maestra->id;
    }
}
