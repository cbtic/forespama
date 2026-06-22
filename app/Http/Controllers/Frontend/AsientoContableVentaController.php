<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AsientoContableVenta;
use App\Models\StarsoftTipoAnexo;
use App\Models\Comprobante;
use Illuminate\Support\Facades\Http;
use Auth;
use Illuminate\Support\Facades\DB;

class AsientoContableVentaController extends Controller
{

    public function __construct(){

		$this->middleware('auth');
		$this->middleware('can:Asiento Contable Venta')->only(['create']);
	}

    public function create(){
	
        $starsoft_tipo_anexos_model = New StarsoftTipoAnexo;
        $tipo_anexo = $starsoft_tipo_anexos_model->getStarsoftTipoAnexos();

		return view('frontend.asiento_contable_venta.create',compact('tipo_anexo'));

	}

    public function listar_asiento_contable_venta_ajax(Request $request){

		$asiento_contable_venta_model = new AsientoContableVenta;
		$p[]=$request->numero_comprobante;
		$p[]=$request->numero_documento;
		$p[]=$request->fecha_inicio;
		$p[]=$request->fecha_fin;
		$p[]=$request->migrado;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $asiento_contable_venta_model->listar_asiento_contable_venta_ajax($p);
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

    public function generar_asiento_contable_venta(Request $request){

        $id_user = Auth::user()->id;

        $asiento_contable_venta_model = new AsientoContableVenta;
		
        $asientos_contables_ventas = $asiento_contable_venta_model->generarAsientosVentas();

        foreach($asientos_contables_ventas as $row){
            $asiento_contable_anexo_venta = new AsientoContableVenta;
		
            $asiento_contable_anexo_venta->cuenta = $row->cuenta;
            $asiento_contable_anexo_venta->annomes = $row->annomes;
            $asiento_contable_anexo_venta->subdiario = $row->subdiario;
            $asiento_contable_anexo_venta->comprobante = $row->comprobante;
            $asiento_contable_anexo_venta->fecha_registro = $row->fecha_registro;
            $asiento_contable_anexo_venta->tipo_anexo = $row->tipo_anexo;
            $asiento_contable_anexo_venta->codigo_cliente = $row->codigo_cliente;
            $asiento_contable_anexo_venta->tipo_documento = $row->tipo_documento;
            $asiento_contable_anexo_venta->numero_documento = $row->numero_documento;
            $asiento_contable_anexo_venta->fecha_documento = $row->fecha_documento;
            $asiento_contable_anexo_venta->tipo_documento_referencial = $row->tipo_documento_referencial;
            $asiento_contable_anexo_venta->numero_documento_referencial = $row->numero_documento_referencial;
            $asiento_contable_anexo_venta->igv = $row->igv;
            $asiento_contable_anexo_venta->valor_isc = $row->valor_isc;
            $asiento_contable_anexo_venta->tasa_igv = $row->tasa_igv;
            $asiento_contable_anexo_venta->importe = $row->importe;
            $asiento_contable_anexo_venta->tasa_cambio_conversion = $row->tasa_conversion;
            $asiento_contable_anexo_venta->tasa_cambio = $row->tc;
            $asiento_contable_anexo_venta->glosa = $row->glosa_documento;
            $asiento_contable_anexo_venta->glosa_movimiento = $row->glosa_movimiento;
            $asiento_contable_anexo_venta->anulado = $row->anulado;
            $asiento_contable_anexo_venta->debe_haber = $row->debe_haber;
            $asiento_contable_anexo_venta->ruc_cliente = $row->ruc_cliente;
            $asiento_contable_anexo_venta->razon_social = $row->razon_social;
            //$asiento_contable_anexo_venta->centro_costo = $row->razon_social;
            $asiento_contable_anexo_venta->fecha_vencimiento = $row->fecha_vencimiento;
            $asiento_contable_anexo_venta->fecha_documento_referencial = $row->fecha_documento_referencial;
            $asiento_contable_anexo_venta->exportacion = $row->exportacion;
            $asiento_contable_anexo_venta->otro_impuesto = $row->otros_impuestos;
            $asiento_contable_anexo_venta->exonerado = $row->exonerado;
            $asiento_contable_anexo_venta->otros_cargos = $row->otros_cargos;
            $asiento_contable_anexo_venta->impuesto_bolsa = $row->impuesto_bolsa;
            $asiento_contable_anexo_venta->id_comprobante = $row->id;
            $asiento_contable_anexo_venta->estado = 1;
            $asiento_contable_anexo_venta->id_usuario_inserta = $id_user;
            $asiento_contable_anexo_venta->save();

            $comprobante = Comprobante::find($row->id);
            $comprobante->asiento_generado = 1;
            $comprobante->save();
        }

        return response()->json(['success' => 'Asientos generados exitosamente.']);

    }

    public function migrar_ventas_starsoft(Request $request){

        try {

            $token = $request->token;

            $asiento_contable_venta_model = new AsientoContableVenta;
            $asiento_contable_venta = $asiento_contable_venta_model->asientosContableVentaPendientes();

            $payload = [];

            foreach ($asiento_contable_venta as $item) {

                $payload[] = [
                    'cuenta' => (string)$item->cuenta,
                    'annomes' => (string)$item->annomes,
                    'subdiario' => (string)$item->subdiario,
                    'comprobante' => $item->comprobante ?? '',
                    'fecha_Registro' => $item->fecha_registro,
                    'tipo_Anexo' => (string)$item->tipo_anexo,
                    'cod_Cliente' => (string)$item->codigo_cliente,
                    'tipo_Doc' => (string)$item->tipo_documento,
                    'nro_Doc' => $item->numero_documento,
                    'fecha_Documento' => $item->fecha_documento,
                    'tipo_Doc_Ref' => $item->tipo_documento_referencial ?? '',
                    'nro_Doc_Ref' => $item->numero_documento_referencial ?? '',
                    'igv' =>  (float)($item->igv ?? 0),
                    'valor_ISC' => (float)($item->valor_isc ?? 0),
                    'tasa_Igv' => (float)($item->tasa_igv ?? 0),
                    'importe' => (float)($item->importe),
                    'conv_Tc' => (string)($item->tasa_cambio_conversion ?? ''),
                    'tc' => (float)($item->tasa_cambio ?? 0),
                    'glosa' => $item->glosa_documento ?? '',
                    'glosa_Mov' => $item->glosa_movimiento ?? '',
                    'anulado' => (bool)$item->anulado,
                    'debe_Haber' => $item->debe_haber,
                    'ruc_Cliente' => $item->ruc_cliente ?? '',
                    'razon_Social' => $item->razon_social ?? '',
                    'centro_Costos' => '',
                    'fecha_Vencimiento' => $item->fecha_vencimiento ?: null,
                    'fecha_Doc_Ref' => $item->fecha_documento_referencial ?: null,
                    'exportacion' => (bool)$item->exportacion,
                    'otro_Imp' => (float)($item->otros_impuestos ?? 0),
                    'exonerado' => (float)($item->exonerado ?? 0),
                    'otros_Cargos' => (float)($item->otros_cargos ?? 0),
                    'impBolsa' => (float)($item->impuesto_bolsa ?? 0)
                ];
                
                $asiento_contable_venta_igv_model = new AsientoContableVenta;
                $asiento_contable_venta_igv = $asiento_contable_venta_igv_model->asientosContableVentaIgvPendientes($item->id_comprobante);

                if($asiento_contable_venta_igv[0]->afect_igv == 10){

                    $payload[] = [
                        'cuenta' => (string)$item->cuenta,
                        'annomes' => (string)$item->annomes,
                        'subdiario' => (string)$item->subdiario,
                        'comprobante' => $item->comprobante ?? '',
                        'fecha_Registro' => $item->fecha_registro,
                        'tipo_Anexo' => (string)$item->tipo_anexo,
                        'cod_Cliente' => (string)$item->codigo_cliente,
                        'tipo_Doc' => (string)$item->tipo_documento,
                        'nro_Doc' => $item->numero_documento,
                        'fecha_Documento' => $item->fecha_documento,
                        'tipo_Doc_Ref' => $item->tipo_documento_referencial ?? '',
                        'nro_Doc_Ref' => $item->numero_documento_referencial ?? '',
                        'igv' =>  (float)($item->igv ?? 0),
                        'valor_ISC' => (float)($item->valor_isc ?? 0),
                        'tasa_Igv' => (float)($item->tasa_igv ?? 0),
                        'importe' => (float)($item->importe),
                        'conv_Tc' => (string)($item->tasa_cambio_conversion ?? ''),
                        'tc' => (float)($item->tasa_cambio ?? 0),
                        'glosa' => $item->glosa_documento ?? '',
                        'glosa_Mov' => $item->glosa_movimiento ?? '',
                        'anulado' => (bool)$item->anulado,
                        'debe_Haber' => $item->debe_haber,
                        'ruc_Cliente' => $item->ruc_cliente ?? '',
                        'razon_Social' => $item->razon_social ?? '',
                        'centro_Costos' => '',
                        'fecha_Vencimiento' => $item->fecha_vencimiento ?: null,
                        'fecha_Doc_Ref' => $item->fecha_documento_referencial ?: null,
                        'exportacion' => (bool)$item->exportacion,
                        'otro_Imp' => (float)($item->otros_impuestos ?? 0),
                        'exonerado' => (float)($item->exonerado ?? 0),
                        'otros_Cargos' => (float)($item->otros_cargos ?? 0),
                        'impBolsa' => (float)($item->impuesto_bolsa ?? 0)
                    ];
                }

                $asiento_contable_venta_detalles_model = new AsientoContableVenta;
                $asiento_contable_venta_detalle = $asiento_contable_venta_detalles_model->asientosContableVentaDetallePendientes($item->id_comprobante);


            }
            //dd($payload);exit();
            $response = Http::withHeaders([
                'Accept' => 'text/plain',
                //'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ])->withBody(
                json_encode($payload),
                'application/json'
            )->post(
                'https://starsoftweb.com/ApiHub/api/Contabilidad/registrarAsientoVentas'
            );

            if ($response->successful() && data_get($response->json(), 'success') === true)
            {
                DB::table('asiento_contable_ventas')->whereIn('id',collect($asiento_contable_venta)->pluck('id'))->update(['flag_migrado' => 1, 'fecha_migrado' => now()]);
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
