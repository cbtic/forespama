<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConductoresRequest;
use App\Models\Conductores;
use App\Models\TablaMaestra;
use App\Models\Persona;
use App\Models\EmpresasConductoresVehiculo;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class ConductoresController extends Controller
{
	public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function index()
    {
        $conductores = Conductores::latest()->paginate(10);

        return view('frontend.conductores.index', compact('conductores'));
    }

	public function create()
    {
        return view('frontend.conductores.all');
    }

    /*public function create()
    {
        return view('frontend.conductores.create');
    }*/

	public function listar_conductor_ajax(Request $request){

		$conductor_model = new Conductores;
		$p[]=$request->nombres;
		$p[]=$request->licencia;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $conductor_model->listar_conductor_ajax($p);
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

    public function store(ConductoresRequest $request)
    {
        Conductores::create($request->all());

        return redirect()->route('frontend.conductores.index');
    }

    public function edit(Conductores $conductores)
    {

        return view('frontend.conductores.edit', compact('conductores'));
    }

    public function update(ConductoresRequest $request, Conductores $conductores)
    {
        $conductores->update($request->all());

        // return redirect()->route('frontend.conductores.show', $conductores->id);
        return redirect()->route('frontend.conductores.index');
    }

    /*public function show(Conductores $conductores)
    {
        return view('frontend.conductores.show', compact('conductores'));
    }*/

    public function destroy(Conductores $conductores)
    {
        if ($conductores->delete()) {
            Alert::success('Proceso completo', 'Se ha eliminado al conductor '.$conductores->personas['nombre_completo_sin_dni']);
        }

        return redirect()->route('frontend.conductores.index');
    }

	public function send_conductor_ingreso(Request $request){

		$id_user = Auth::user()->id;
		$sw = true;
		$msg = "";

		if($request->id == 0){

			if($request->id_personas==0){
				$persona = new Persona;
				$persona->id_tipo_documento = $request->id_tipo_documento;
				$persona->numero_documento = $request->numero_documento;
				$persona->apellido_paterno = $request->apellido_paterno;
				$persona->apellido_materno = $request->apellido_materno;
				$persona->nombres = $request->nombres;
				$persona->fecha_nacimiento = "1990-01-01";
				$persona->estado = "A";
				$persona->save();
				$request->id_personas = $persona->id;
			}

			$conductorExiste = Conductores::where("id_personas",$request->id_personas)->get();
			if(count($conductorExiste)==0){
				$conductor = new Conductores;
				$conductor->licencia = $request->licencia;
				$conductor->id_personas = $request->id_personas;
				$conductor->fecha_licencia = Carbon::now()->format('Y-m-d');
				$conductor->estado = "ACTIVO";
				$conductor->save();
			}else{
				$conductor = $conductorExiste[0];
				$sw = false;
				$msg = "El Conductor ingresado ya existe !!!";
			}


		}else{
			$conductor = Conductores::find($request->id);
			$conductor->licencia = $request->licencia;
			$conductor->id_personas = $request->id_personas;
			$conductor->save();
		}

		$persona = Persona::find($conductor->id_personas);

		$array["sw"] = $sw;
		$array["msg"] = $msg;
		$array["persona"] = $persona;
		$array["conductor"] = $conductor;
        echo json_encode($array);

    }

	public function modal_conductor_guia($id, $id_empresa_conductor_vehiculo){
		
		$id_user = Auth::user()->id;
		$tablaMaestra_model = new TablaMaestra;
		if($id>0){
			$conductor = Conductores::find($id);
			$persona = Persona::find($conductor->id_personas);
		}else{
			$conductor = new Conductores;
			$persona = new Persona;
		} 
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(9);
		$empresa_conductor_vehiculo = EmpresasConductoresVehiculo::find($id_empresa_conductor_vehiculo);

		return view('frontend.conductores.modal_conductor_guia',compact('id','conductor','tipo_documento','persona','empresa_conductor_vehiculo'));

    }

	public function eliminar_conductor($id,$estado)
    {
		$conductor = Conductores::find($id);
		$conductor->estado = $estado;
		$conductor->save();

		echo $conductor->id;

    }

	public function obtener_licencia($conductor){

		$sw = true;
		$msg = "";
		$conductores_model = new Conductores;
		$conductores = $conductores_model->getLicenciaByConductor($conductor);
		
		$array["sw"] = $sw;
		$array["msg"] = $msg;
		$array["conductores"] = $conductores;
        echo json_encode($array);
		
	}

	public function send_conductor_guia(Request $request){

		$id_user = Auth::user()->id;
		$sw = true;
		$msg = "";

		if($request->id == 0){

			$personaExiste = Persona::where("id_tipo_documento",$request->id_tipo_documento)->where("numero_documento",$request->numero_documento)->where("estado",1)->get();
			
			if(count($personaExiste)==0){
				$persona = new Persona;
				$persona->id_tipo_documento = $request->licencia;
				$persona->numero_documento = $request->numero_documento_;
				$persona->apellido_paterno = $request->apellido_paterno_;
				$persona->apellido_materno = $request->apellido_materno_;
				$persona->nombres = $request->nombres_;
				$persona->estado = 1;
				$persona->save();

				$conductor = new Conductores;
				$conductor->licencia = $request->licencia;
				$conductor->fecha_licencia = Carbon::now()->format('Y-m-d');
				$conductor->estado = "ACTIVO";
				$conductor->id_personas = $persona->id;
				$conductor->save();
				//$empresa_razon_social = $persona->razon_social;

				//$vehiculo = Vehiculo::find($request->id_vehiculo);

				$empresas_conductores_vehiculo = EmpresasConductoresVehiculo::find($request->id_empresa_conductor_vehiculo);
				$new_empresas_conductores_vehiculo = new EmpresasConductoresVehiculo;
				$new_empresas_conductores_vehiculo->id_empresas = $empresas_conductores_vehiculo->id_empresas;
				$new_empresas_conductores_vehiculo->id_vehiculos = $empresas_conductores_vehiculo->id_vehiculos;
				$new_empresas_conductores_vehiculo->id_conductores = $conductor->id;
				$new_empresas_conductores_vehiculo->save();

			}else{
				$sw = false;
				$msg = "La persona ingresada ya existe !!!";
				$id_persona = $personaExiste[0]->id;

				$conductor = Conductores::find($id_persona);

				if(!$conductor){
					$conductor = new Conductores;
					$conductor->licencia = $request->licencia;
					$conductor->fecha_licencia = Carbon::now()->format('Y-m-d');
					$conductor->estado = "ACTIVO";
					$conductor->id_personas = $id_persona;
					$conductor->save();
				}

				//$empresa_razon_social = $empresaExiste[0]->razon_social;

				$empresas_conductores_vehiculo = EmpresasConductoresVehiculo::find($request->id_empresa_conductor_vehiculo);
				$new_empresas_conductores_vehiculo = new EmpresasConductoresVehiculo;
				$new_empresas_conductores_vehiculo->id_empresas = $empresas_conductores_vehiculo->id_empresas;
				$new_empresas_conductores_vehiculo->id_vehiculos = $empresas_conductores_vehiculo->id_vehiculos;
				$new_empresas_conductores_vehiculo->id_conductores = $conductor->id;
				$new_empresas_conductores_vehiculo->save();
			}

			/*$conductorExiste = Conductores::where("id_personas",$persona->id)->get();
			if(count($conductorExiste)==0){
				$conductor = new Conductores;
				$conductor->licencia = $request->licencia;
				$conductor->id_personas = $request->id_personas;
				$conductor->fecha_licencia = Carbon::now()->format('Y-m-d');
				$conductor->estado = "ACTIVO";
				$conductor->save();
			}else{
				$conductor = $conductorExiste[0];
				$sw = false;
				$msg = "El Conductor ingresado ya existe !!!";
			}*/

		}else{
			$conductor = Conductores::find($request->id);
			$conductor->licencia = $request->licencia;
			$conductor->id_personas = $request->id_personas;
			$conductor->save();
		}

		//EmpresasConductoresVehiculo::find();

		$persona = Persona::find($conductor->id_personas);
		$conductor = Conductores::find($conductor->id);

		$array["sw"] = $sw;
		$array["msg"] = $msg;
		$array["persona"] = $persona;
		$array["conductor"] = $conductor;
        echo json_encode($array);

    }

	public function modal_nuevo_conductor($id){
		
		$id_user = Auth::user()->id;
		$tablaMaestra_model = new TablaMaestra;
		if($id>0){
			$conductor = Conductores::find($id);
			$persona = Persona::find($conductor->id_personas);
		}else{
			$conductor = new Conductores;
			$persona = new Persona;
		}
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(9);

		return view('frontend.conductores.modal_nuevo_conductor',compact('id','conductor','tipo_documento','persona'));

    }

	public function send_conductor_nuevo(Request $request){

		$id_user = Auth::user()->id;
		$sw = true;
		$msg = "";

		if($request->id == 0){

			$personaExiste = Persona::where("id_tipo_documento",$request->id_tipo_documento)->where("numero_documento",$request->numero_documento)->where("estado",1)->get();
			
			if(count($personaExiste)==0){
				$persona = new Persona;
				$persona->id_tipo_documento = $request->licencia;
				$persona->id_tipo_documento = $request->id_tipo_documento;
				$persona->numero_documento = $request->numero_documento;
				$persona->apellido_paterno = $request->apellido_paterno;
				$persona->apellido_materno = $request->apellido_materno;
				$persona->fecha_nacimiento = Carbon::now()->format('Y-m-d');
				$persona->nombres = $request->nombres;
				$persona->estado = 1;
				$persona->save();

				$conductor = new Conductores;
				$conductor->licencia = $request->licencia;
				$conductor->fecha_licencia = Carbon::now()->format('Y-m-d');
				$conductor->estado = "ACTIVO";
				$conductor->id_personas = $persona->id;
				$conductor->save();

			}else{
				$sw = false;
				$msg = "La persona ingresada ya existe !!!";
				$id_persona = $personaExiste[0]->id;

				$conductor = Conductores::find($id_persona);

				if(!$conductor){
					$conductor = new Conductores;
					$conductor->licencia = $request->licencia;
					$conductor->fecha_licencia = Carbon::now()->format('Y-m-d');
					$conductor->estado = "ACTIVO";
					$conductor->id_personas = $id_persona;
					$conductor->save();
				}

			}

		}else{
			$conductor = Conductores::find($request->id);
			$conductor->licencia = $request->licencia;
			$conductor->id_personas = $request->id_personas;
			$conductor->save();
		}

		$persona = Persona::find($conductor->id_personas);
		$conductor = Conductores::find($conductor->id);

		$array["sw"] = $sw;
		$array["msg"] = $msg;
		$array["persona"] = $persona;
		$array["conductor"] = $conductor;
        echo json_encode($array);

    }

	public function obtener_conductores_nuevos(){
 		
        $conductores_model = new Conductores;
        $conductor = $conductores_model->getConductoresAll();
        
        $array["conductor"] = $conductor;
        echo json_encode($array);

    }

}
