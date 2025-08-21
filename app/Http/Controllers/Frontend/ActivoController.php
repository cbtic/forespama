<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use App\Models\Activo;
use App\Models\Persona;
use App\Models\Ubigeo;
use App\Models\Marca;
use App\Models\SoatActivo;
use App\Models\RevisionTecnicaActivo;
use App\Models\ControlMantenimientoActivo;
use App\Models\Familia;
use App\Models\SubFamilia;
use Auth;
use Carbon\Carbon;

class ActivoController extends Controller
{
    
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function create(){
		
		$tabla_maestra_model = new TablaMaestra;

		$tipo_activo = $tabla_maestra_model->getMaestroByTipo('84');

		return view('frontend.activos.create',compact('tipo_activo'));

	}

	public function create_activo(){
		
		$id = 0;
		$tabla_maestra_model = new TablaMaestra;
		$activo = new Activo;
        $marca_model = new Marca;
        $ubigeo_model = new Ubigeo;
        $soat_activo_model = new SoatActivo;
        $revision_tecnica_activo_model = new RevisionTecnicaActivo;
        $control_mantenimiento_activo_model = new ControlMantenimientoActivo;
        $familia_model = new Familia;

		$sub_tipo_activo = $tabla_maestra_model->getMaestroByTipo('84');
		$marca = $marca_model->getMarcaVehiculo();
		$tipo_combustible = $tabla_maestra_model->getMaestroByTipo('86');
		$estado_activos = $tabla_maestra_model->getMaestroByTipo('85');
        $departamento = $ubigeo_model->getDepartamento();
		$soat_activo = $soat_activo_model->getSoatActivo($id);
		$revision_tecnica_activo = $revision_tecnica_activo_model->getRevisionTecnicaActivo($id);
		$control_mantenimiento_activo = $control_mantenimiento_activo_model->getControlMantenimientoActivo($id);
		$familia = $familia_model->getFamiliaAll();
		$tipo_activo = $tabla_maestra_model->getMaestroByTipo('94');
		$tipo_operacion_maquinaria = $tabla_maestra_model->getMaestroByTipo('97');
		$pais = $tabla_maestra_model->getMaestroByTipo('96');

		return view('frontend.activos.create_activo',compact('id','activo','marca','tipo_combustible','estado_activos','soat_activo','departamento','sub_tipo_activo','tipo_activo','id','revision_tecnica_activo','control_mantenimiento_activo','familia','tipo_operacion_maquinaria','pais'));

	}

	public function editar_activo($id){
		
		$tabla_maestra_model = new TablaMaestra;
		$activo = Activo::find($id);
        $marca_model = new Marca;
        $ubigeo_model = new Ubigeo;
        $soat_activo_model = new SoatActivo;
        $revision_tecnica_activo_model = new RevisionTecnicaActivo;
        $control_mantenimiento_activo_model = new ControlMantenimientoActivo;
		$familia_model = new Familia;

		$tipo_activo = $tabla_maestra_model->getMaestroByTipo('84');
		if($activo->id_tipo_activo==2){
			$marca = $marca_model->getMarcaVehiculo();
		}
		if($activo->id_tipo_activo==3){
			$marca = $marca_model->getMarcaEquipo();
		}
		if($activo->id_tipo_activo==1){
			$marca = $marca_model->getMarcaVehiculo();
		}
		
		$tipo_combustible = $tabla_maestra_model->getMaestroByTipo('86');
		$estado_activos = $tabla_maestra_model->getMaestroByTipo('85');
        $departamento = $ubigeo_model->getDepartamento();
		$soat_activo = $soat_activo_model->getSoatActivo($id);
		$revision_tecnica_activo = $revision_tecnica_activo_model->getRevisionTecnicaActivo($id);
		$control_mantenimiento_activo = $control_mantenimiento_activo_model->getControlMantenimientoActivo($id);
		$familia = $familia_model->getFamiliaAll();
		$tipo_activo = $tabla_maestra_model->getMaestroByTipo('94');
		$tipo_operacion_maquinaria = $tabla_maestra_model->getMaestroByTipo('95');
		$pais = $tabla_maestra_model->getMaestroByTipo('96');
		
		return view('frontend.activos.create_activo',compact('id','activo','marca','tipo_combustible','estado_activos','soat_activo','departamento','tipo_activo','id','revision_tecnica_activo','control_mantenimiento_activo','familia','tipo_activo','tipo_operacion_maquinaria','pais'));

	}

    public function listar_activos_ajax(Request $request){

		$activos_model = new Activo;
		$p[]=$request->tipo_activo;
		$p[]=$request->descripcion;
		$p[]=$request->placa;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $activos_model->listar_activos_ajax($p);
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

    public function modal_activos_horno($id){
		
		$tabla_maestra_model = new TablaMaestra;
        $persona_model = new Persona;
        $ubigeo_model = new Ubigeo;
        $marca_model = new Marca;
        $soat_activo_model = new SoatActivo;
        $revision_tecnica_activo_model = new RevisionTecnicaActivo;
		
		if($id>0){
			$activo = Activo::find($id);
		}else{
			$activo = new Activo;
		}

		$tipo_activo = $tabla_maestra_model->getMaestroByTipo('84');
		$estado_activos = $tabla_maestra_model->getMaestroByTipo('85');
		$tipo_combustible = $tabla_maestra_model->getMaestroByTipo('86');
        $departamento = $ubigeo_model->getDepartamento();
        $marca = $marca_model->getMarcaVehiculo();
		$soat_activo = $soat_activo_model->getSoatActivo($id);
		$revision_tecnica_activo = $revision_tecnica_activo_model->getRevisionTecnicaActivo($id);

		return view('frontend.activos.modal_activos_nuevoActivo',compact('id','activo','tipo_activo','estado_activos','marca','tipo_combustible','departamento','soat_activo','revision_tecnica_activo'));

    }

    public function send_activo(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$activo = new Activo;
		}else{
			$activo = Activo::find($request->id);
		}

		$valor_libros = str_replace(',', '', $request->valor_libros);
		$valor_comercial = str_replace(',', '', $request->valor_comercial);

        $activo->codigo_activo = $request->codigo;
        $activo->id_ubigeo = $request->distrito;
        $activo->direccion = $request->direccion;
        $activo->id_tipo_activo = $request->tipo_activo;
        $activo->descripcion = $request->descripcion;
        $activo->placa = $request->placa;
        $activo->modelo = $request->modelo;
        $activo->serie = $request->serie;
        $activo->id_marca = $request->marca;
        $activo->color = $request->color;
        $activo->titulo = $request->titulo;
        $activo->partida_registral = $request->partida_registral;
        $activo->partida_circulacion = $request->partida_circulacion;
        $activo->vigencia_circulacion = $request->vigencia_circulacion;
        $activo->fecha_vencimiento_soat = $request->fecha_vencimiento_soat;
        $activo->fecha_vencimiento_revision_tecnica = $request->fecha_vencimiento_revision_tecnica;
        $activo->valor_libros = $valor_libros;
        $activo->valor_comercial = $valor_comercial;
        $activo->id_tipo_combustible = $request->tipo_combustible;
        $activo->dimensiones = $request->dimension;
        $activo->id_estado_activo = $request->estado_activo;
        $activo->ruta_imagen = $request->img_foto;
		$activo->estado = 1;
        $activo->id_usuario_inserta = $id_user;
		$activo->save();
		$id_activo = $activo->id; 

		$activo_id = $id_activo;
		$path = public_path("img/activos/".$activo_id);
		if (!is_dir($path)) {
			mkdir($path, 0777, true);
		}

		if($request->img_foto!=""){
			$filepath_tmp = public_path('img/tmp_activos/');
			$filepath_nuevo = public_path('img/activos/'. $activo_id . '/');
             if (!is_dir($filepath_nuevo)) {
                mkdir($filepath_nuevo, 0777, true);
            }
			if ($request->img_foto != "") {
                if (file_exists($filepath_tmp . $request->img_foto)) {
                    copy($filepath_tmp . $request->img_foto, $filepath_nuevo . $request->img_foto);
                }
            }
		}

        return response()->json(['success' => 'Registro de activo guardado exitosamente.']);

    }

	public function send(Request $request){
		
		$msg = "";
		$id_user = Auth::user()->id;
		
		$id_activo = $request->id_activo;
		
		if($request->tipo_activo==2){
			if($id_activo==0){
				$activoExiste = Activo::where("placa",$request->placa)->where("estado",1)->get();
				if(count($activoExiste)>0){
					echo "1";
					exit();
				}
			}
		}
		
		if($id_activo> 0){
			$activo = Activo::find($id_activo);
			$activo->id_usuario_actualiza = $id_user;
			$codigo_activo = $request->codigo;
		}else{
			$activo = new Activo;
			$activo->id_usuario_inserta = $id_user;
			$activo_model = new Activo;
			$codigo_activo = $activo_model->getCodigoActivo($request->familia, $request->sub_familia);
		}

		$valor_libros = trim($request->valor_libros) !== '' ? str_replace(',', '', $request->valor_libros) : null;
		$valor_comercial = trim($request->valor_comercial) !== '' ? str_replace(',', '', $request->valor_comercial) : null;

        $activo->id_familia = $request->familia;
        $activo->id_sub_familia = $request->sub_familia;
        $activo->id_sub_tipo_activo = $request->sub_tipo_activo;
        if($request->id_activo == 0){
            $activo->codigo_activo = $codigo_activo[0]->codigo;
        }else{
            $activo->codigo_activo = $codigo_activo;
        }
        $activo->id_ubigeo = $request->distrito;
        $activo->direccion = $request->direccion;
        $activo->id_tipo_activo = $request->tipo_activo;
        $activo->descripcion = $request->descripcion;
        $activo->placa = $request->placa;
        $activo->modelo = $request->modelo;
        $activo->serie = $request->serie;
        $activo->id_marca = $request->marca;
        $activo->color = $request->color;
        $activo->titulo = $request->titulo;
        $activo->partida_registral = $request->partida_registral;
        $activo->partida_circulacion = $request->partida_circulacion;
        $activo->vigencia_circulacion = $request->vigencia_circulacion;
        $activo->fecha_vencimiento_soat = $request->fecha_vencimiento_soat;
        $activo->fecha_vencimiento_revision_tecnica = $request->fecha_vencimiento_revision_tecnica;
        $activo->valor_libros = $valor_libros;
        $activo->valor_comercial = $valor_comercial;
        $activo->id_tipo_combustible = $request->tipo_combustible;
        $activo->dimensiones = $request->dimension;
        $activo->id_estado_activo = $request->estado_activo;
        $activo->ruta_imagen = $request->img_foto;
        $activo->id_pais_procedencia = $request->pais_procedencia;
        $activo->anio_fabricacion = $request->anio_fabricacion;
        $activo->potencia = $request->potencia;
        $activo->id_tipo_operacion = $request->tipo_operacion_maquinaria;
		$activo->estado = 1;
		$activo->save();
		$id_activo = $activo->id;

		$activo_id = $id_activo;
		$path = public_path("img/activos/".$activo_id);
		if (!is_dir($path)) {
			mkdir($path, 0777, true);
		}

		if($request->img_foto!=""){
			$filepath_tmp = public_path('img/tmp_activos/');
			$filepath_nuevo = public_path('img/activos/'. $activo_id . '/');
             if (!is_dir($filepath_nuevo)) {
                mkdir($filepath_nuevo, 0777, true);
            }
			if ($request->img_foto != "") {
                if (file_exists($filepath_tmp . $request->img_foto)) {
                    copy($filepath_tmp . $request->img_foto, $filepath_nuevo . $request->img_foto);
                }
            }
		}

        return response()->json([
			'success' => 'Registro de activo guardado exitosamente.',
			'id' => $id_activo
		]);
		
	}

	public function eliminar_activo($id,$estado)
    {
		$activo = Activo::find($id);

		$activo->estado = $estado;
		$activo->save();

		echo $activo->id;
    }

	public function obtener_provincia_distrito($id){
		
		$activos_model = new Activo;
		$ubigeo_activo = $activos_model->getProvinciaDistritoById($id);
		
		echo json_encode($ubigeo_activo);
	}

	function extension($filename){$file = explode(".",$filename); return strtolower(end($file));}

    public function upload_activo(Request $request){
		
		$path = "img/tmp_activos";
		if (!is_dir($path)) {
			mkdir($path);
		}

        $filename = date("YmdHis") . substr((string)microtime(), 1, 6);
		$type="";

    	$filepath = public_path('img/tmp_activos/');

        $type=$this->extension($_FILES["file"]["name"]);
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath . $filename.".".$type);

		echo $filename.".".$type;
	}

	public function modal_soat_activo($id){
		
		if($id>0){
			$soat_activo = SoatActivo::find($id);
		}else{
			$soat_activo = new SoatActivo;
		}

		$tabla_maestra_model = new TablaMaestra;

		$estado_soat = $tabla_maestra_model->getMaestroByTipo('89');
		
		return view('frontend.activos.modal_soat_activo',compact('id','soat_activo','estado_soat'));
	
	}

	public function modal_revision_tecnica_activo($id){
		
		if($id>0){
			$revision_tecnica_activo = RevisionTecnicaActivo::find($id);
		}else{
			$revision_tecnica_activo = new RevisionTecnicaActivo;
		}

		$tabla_maestra_model = new TablaMaestra;

		$estado_revision_tecnica = $tabla_maestra_model->getMaestroByTipo('89');
		$resultado_revision_tecnica = $tabla_maestra_model->getMaestroByTipo('90');
		
		return view('frontend.activos.modal_revision_tecnica_activo',compact('id','revision_tecnica_activo','estado_revision_tecnica','resultado_revision_tecnica'));
	
	}

	public function modal_control_mantenimiento_activo($id){
		
		if($id>0){
			$control_mantenimiento_activo = ControlMantenimientoActivo::find($id);
		}else{
			$control_mantenimiento_activo = new ControlMantenimientoActivo;
		}

		$tabla_maestra_model = new TablaMaestra;

		$tipo_mantenimiento = $tabla_maestra_model->getMaestroByTipo('91');
				
		return view('frontend.activos.modal_control_mantenimiento_activo',compact('id','control_mantenimiento_activo','tipo_mantenimiento'));
	
	}

	public function send_soat_activo(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$soat_activo = new SoatActivo;
			$soat_activo->id_usuario_inserta = $id_user;
		}else{
			$soat_activo = SoatActivo::find($request->id);
			$soat_activo->id_usuario_actualiza = $id_user;
		}
		
		$soat_activo->id_activos = $request->id_activo;
		$soat_activo->numero_poliza = $request->numero_poliza;
		$soat_activo->fecha_emision = $request->fecha_emision;
		$soat_activo->fecha_vencimiento = $request->fecha_vencimiento;
		$soat_activo->estado_soat = $request->estado_soat;
		$soat_activo->estado = 1;
		$soat_activo->save();
		
    }

	public function send_revision_tecnica_activo(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$revision_tecnica_activo = new RevisionTecnicaActivo;
			$revision_tecnica_activo->id_usuario_inserta = $id_user;
		}else{
			$revision_tecnica_activo = RevisionTecnicaActivo::find($request->id);
			$revision_tecnica_activo->id_usuario_actualiza = $id_user;
		}
		
		$revision_tecnica_activo->id_activos = $request->id_activo;
		$revision_tecnica_activo->numero_certificado = $request->numero_certificado;
		$revision_tecnica_activo->fecha_emision = $request->fecha_emision;
		$revision_tecnica_activo->fecha_vencimiento = $request->fecha_vencimiento;
		$revision_tecnica_activo->id_resultado_revision = $request->resultado_revision_tecnica;
		$revision_tecnica_activo->estado_revision = $request->estado_revision_tecnica;
		$revision_tecnica_activo->estado = 1;
		$revision_tecnica_activo->save();
		
    }

	public function send_control_mantenimiento_activo(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$control_mantenimiento_activo = new ControlMantenimientoActivo;
			$control_mantenimiento_activo->id_usuario_inserta = $id_user;
		}else{
			$control_mantenimiento_activo = ControlMantenimientoActivo::find($request->id);
			$control_mantenimiento_activo->id_usuario_actualiza = $id_user;
		}
		
		$control_mantenimiento_activo->id_activos = $request->id_activo;
		$control_mantenimiento_activo->fecha_mantenimiento = $request->fecha_mantenimiento;
		$control_mantenimiento_activo->kilometraje = $request->kilometraje;
		$control_mantenimiento_activo->proximo_kilometraje = $request->proximo_kilometraje;
		$control_mantenimiento_activo->id_tipo_mantenimiento = $request->tipo_mantenimiento;
		$control_mantenimiento_activo->costo = $request->costo;
		$control_mantenimiento_activo->fecha_proximo_mantenimiento = $request->fecha_proximo_mantenimiento;
		$control_mantenimiento_activo->observacion = $request->observacion;
		$control_mantenimiento_activo->estado = 1;
		$control_mantenimiento_activo->save();
		
    }

	public function eliminar_soat_activo($id){

		$soat_activo = SoatActivo::find($id);
		$soat_activo->estado= "0";
		$soat_activo->save();
		
		echo "success";

    }

	public function eliminar_revision_tecnica_activo($id){

		$revision_tecnica_activo = RevisionTecnicaActivo::find($id);
		$revision_tecnica_activo->estado= "0";
		$revision_tecnica_activo->save();
		
		echo "success";

    }

	public function eliminar_control_mantenimiento_activo($id){

		$control_mantenimiento_activo = ControlMantenimientoActivo::find($id);
		$control_mantenimiento_activo->estado= "0";
		$control_mantenimiento_activo->save();
		
		echo "success";

    }

	public function cambiarVigenciaSoat(){

		$soat_activo_model = new SoatActivo;

		$soat_activo_model->actualizarVigenciaSoat();
		
	}

	public function cambiarVigenciaRevisionTecnica(){

		$revision_tecnica_activo_model = new RevisionTecnicaActivo;

		$revision_tecnica_activo_model->actualizarVigenciaRevisionTecnica();
		
	}

	public function obtener_sub_tipo_activo($tipo_activo){
		
		$tabla_maestra_model = new TablaMaestra;
		$sub_tipo_activo = $tabla_maestra_model->getMaestroByTipoAndSubTipo(84,$tipo_activo);
		echo json_encode($sub_tipo_activo);
	}

	public function obtener_datos_sub_tipo_activo($id){
		
		$activo_model = new Activo;
		$activo = $activo_model->getSubTipoActivo($id);

		echo json_encode($activo);
	}

	public function obtener_datos_sub_familia($id){
		
		$activo_model = new Activo;
		$activo = $activo_model->getSubFamilia($id);
		
		echo json_encode($activo);
	}

	public function obtener_marca($tipo_activo){
		
		$marca_model = new Marca;
		$marca = $marca_model->getMarcaByTipoActivo($tipo_activo);

		echo json_encode($marca);
	}
}
