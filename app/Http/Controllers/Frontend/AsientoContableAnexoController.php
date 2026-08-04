<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AsientoContableAnexo;
use App\Models\Persona;
use App\Models\Empresa;
use App\Models\StarsoftTipoAnexo;
use Illuminate\Support\Facades\Http;
use Auth;
use Illuminate\Support\Facades\DB;

class AsientoContableAnexoController extends Controller
{
    public function __construct(){

		$this->middleware('auth');
		$this->middleware('can:Asiento Contable Anexo')->only(['create']);
	}

    public function create(){
	
        $starsoft_tipo_anexos_model = New StarsoftTipoAnexo;
        $tipo_anexo = $starsoft_tipo_anexos_model->getStarsoftTipoAnexos();

		return view('frontend.asiento_contable_anexo.create',compact('tipo_anexo'));

	}

    public function listar_asiento_contable_anexo_ajax(Request $request){

		$asiento_contable_anexo_model = new AsientoContableAnexo;
		$p[]=$request->numero_documento;
		$p[]=$request->razon_social;
		$p[]=$request->tipo_anexo;
		$p[]=$request->migrado;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $asiento_contable_anexo_model->listar_asiento_contable_anexo_ajax($p);
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

    public function generar_asiento_contable_anexo(Request $request){

        $id_user = Auth::user()->id;

        $asiento_contable_anexo_model = new AsientoContableAnexo;
		
        $asientos_contables_personas = $asiento_contable_anexo_model->generarAsientosPersonas();

        foreach($asientos_contables_personas as $row){
            $asiento_contable_anexo_persona = new AsientoContableAnexo;
		
            $asiento_contable_anexo_persona->tipo_anexo = $row->tipo_anexo;
            $asiento_contable_anexo_persona->codigo_anexo = $row->codigo_anexo;
            $asiento_contable_anexo_persona->ruc = $row->ruc;
            $asiento_contable_anexo_persona->razon_social = $row->razon_social;
            $asiento_contable_anexo_persona->direccion = $row->direccion;
            $asiento_contable_anexo_persona->tipo_documento = $row->tipo_documento;
            $asiento_contable_anexo_persona->nro_documento = $row->numero_documento;
            $asiento_contable_anexo_persona->tipo_personal = $row->tipo_personal;
            $asiento_contable_anexo_persona->apellido_paterno = $row->apellido_paterno;
            $asiento_contable_anexo_persona->apellido_materno = $row->apellido_materno;
            $asiento_contable_anexo_persona->primer_nombre = $row->primer_nombre;
            $asiento_contable_anexo_persona->segundo_nombre = $row->segundo_nombre;
            $asiento_contable_anexo_persona->nacionalidad = $row->nacionalidad;
            $asiento_contable_anexo_persona->sexo = $row->sexo;
            $asiento_contable_anexo_persona->estado = 1;
            $asiento_contable_anexo_persona->id_usuario_inserta = $id_user;
            $asiento_contable_anexo_persona->save();

            $persona = Persona::find($row->id);
            $persona->asiento_generado = 1;
            $persona->save();
        }

        $asientos_contables_empresas = $asiento_contable_anexo_model->generarAsientosEmpresas();

        //dd($asientos_contables_empresas);exit();

        foreach($asientos_contables_empresas as $row2){
            $asiento_contable_anexo_empresa = new AsientoContableAnexo;
		
            $asiento_contable_anexo_empresa->tipo_anexo = $row2->tipo_anexo;
            $asiento_contable_anexo_empresa->codigo_anexo = $row2->codigo_anexo;
            $asiento_contable_anexo_empresa->ruc = $row2->ruc;
            $asiento_contable_anexo_empresa->razon_social = $row2->razon_social;
            $asiento_contable_anexo_empresa->direccion = $row2->direccion;
            $asiento_contable_anexo_empresa->tipo_documento = $row2->tipo_documento;
            $asiento_contable_anexo_empresa->nro_documento = $row2->numero_documento;
            $asiento_contable_anexo_empresa->tipo_personal = $row2->tipo_personal;
            $asiento_contable_anexo_empresa->apellido_paterno = $row2->apellido_paterno;
            $asiento_contable_anexo_empresa->apellido_materno = $row2->apellido_materno;
            $asiento_contable_anexo_empresa->primer_nombre = $row2->primer_nombre;
            $asiento_contable_anexo_empresa->segundo_nombre = $row2->segundo_nombre;
            $asiento_contable_anexo_empresa->nacionalidad = $row2->nacionalidad;
            $asiento_contable_anexo_empresa->sexo = $row2->sexo;
            $asiento_contable_anexo_empresa->estado = 1;
            $asiento_contable_anexo_empresa->id_usuario_inserta = $id_user;
            $asiento_contable_anexo_empresa->save();

            $empresa = Empresa::find($row2->id);
            $empresa->asiento_generado = 1;
            $empresa->save();
        }

        return response()->json(['success' => 'Asientos generados exitosamente.']);

    }

    public function generar_token_starsoft(){
        try {

            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post(
                'https://starsoftweb.com/ApiHub/api/Authentication/GenerateToken',
                [
                    'clientID' => '6528cc2f-ae25-49b1-bb1a-25103fd4f9b3',
                    'clientSecret' => 'A67Q1jEHlK2oZ11w/rsx5A==',
                    'codEmpresa' => '003',
                    'codSistema' => 'FORESP'
                ]
            );

            return response()->json([
                'success' => true,
                'data' => $response->json()
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function migrar_anexos_starsoft(Request $request){

        try {

            $token = $request->token;

            $asiento_contable_anexo_model = new AsientoContableAnexo;
            $asiento_contable_anexo = $asiento_contable_anexo_model->asientosContableAnexoPendientes();

            $payload = [];

            foreach ($asiento_contable_anexo as $item) {

                $payload[] = [
                    'tipo_Anexo' => $item->tipo_anexo,
                    'codigo_Anexo' => $item->codigo_anexo,
                    'ruc' => $item->ruc ?? '',
                    'razon_Social' => $item->razon_social ?? '',
                    'direccion' => $item->direccion ?? '',
                    'tipo_Documento' => $item->tipo_documento,
                    'nro_Documento' => $item->nro_documento ?? '',
                    'tipo_Personal' => $item->tipo_personal,
                    'apellido_Paterno' => $item->apellido_paterno ?? '',
                    'apellido_Materno' => $item->apellido_materno ?? '',
                    'primer_Nombre' => $item->primer_nombre ?? '',
                    'segundo_Nombre' => $item->segundo_nombre ?? '',
                    'nacionalidad' => $item->nacionalidad ?? '',
                    'sexo' => is_numeric($item->sexo)
                        ? (int) $item->sexo
                        : 0
                ];
            }

            $response = Http::withHeaders([
                'Accept' => 'text/plain',
                //'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ])->withBody(
                json_encode($payload),
                'application/json'
            )->post(
                'https://starsoftweb.com/apihub/api/Contabilidad/registrarAnexos'
            );

            if ($response->successful() && data_get($response->json(), 'success') === true)
            {
                DB::table('asiento_contable_anexos')->whereIn('id',collect($asiento_contable_anexo)->pluck('id'))->update(['flag_migrado' => 1, 'fecha_migrado' => now()]);
            }

            return response()->json([
                'success' => $response->successful(),
                'status' => $response->status(),
                //'payload_enviado' => $payload,
                //'response_raw' => $response->body(),
            'data' => $response->json()
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
