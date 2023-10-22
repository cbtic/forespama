<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IngresoVehiculoTroncoController extends Controller
{
    public function index(){
		/*
		$proyecto_model = new Proyecto;
		$tablaMaestra_model = new TablaMaestra;
		$departamento = $proyecto_model->getDepartamento();
		$estado_proyecto = $tablaMaestra_model->getMaestroByTipo("EST_PY");
		*/
		return view('frontend.ingreso.create'/*,compact('departamento','estado_proyecto')*/);
	
	}
}
