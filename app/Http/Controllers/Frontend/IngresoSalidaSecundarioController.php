<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use App\Models\Producto;
use App\Models\Almacene;
use App\Models\Empresa;
use App\Models\Persona;
use App\Models\Marca;
use App\Models\IngresoSalidaSecundario;
use App\Models\IngresoSalidaSecundarioDetalle;
use App\Models\KardexSecundario;
use App\Models\Sede;
use Auth;
use Carbon\Carbon;

class IngresoSalidaSecundarioController extends Controller
{
    public function __construct(){

        $this->middleware('auth');
		$this->middleware('can:Ingreso Salida Secundario')->only(['create']);
	}

    public function create(){

		$tablaMaestra_model = new TablaMaestra;
		$empresa_model = new Empresa;
		$persona_model = new Persona;

		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(54);
        //$proveedor = Empresa::all();
        $proveedor = $empresa_model->getEmpresaAll();
        $persona = $persona_model->obtenerPersonaAll();
		
		return view('frontend.ingreso_salida_secundarios.create',compact('tipo_documento','proveedor','persona'));

	}

    public function listar_ingreso_salida_secundarios_ajax(Request $request){

		$ingreso_salida_secundario_model = new IngresoSalidaSecundario;
		$p[]=$request->tipo_documento;
        $p[]=$request->empresa;
        $p[]=$request->persona;
        $p[]=$request->fecha_inicio;
        $p[]=$request->fecha_fin;
        $p[]=$request->numero_ingreso_salida;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $ingreso_salida_secundario_model->listar_ingreso_salida_secundarios_ajax($p);
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

    public function modal_ingreso_salida_secundario($id){
		
        $id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $almacen_model = new Almacene;
        $empresa_model = new Empresa;
        $persona_model = new Persona;
		$sede_model = new Sede;
		
        if($id>0){
            $ingreso_salida_secundario = IngresoSalidaSecundario::find($id);
        }else{
            $ingreso_salida_secundario = new IngresoSalidaSecundario;
        }
        
        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(54);
        $unidad_origen = $tablaMaestra_model->getMaestroByTipo(50);
        $empresas = $empresa_model->getEmpresaAll();
        $personas = $persona_model->obtenerPersonaAll();
        $producto = $producto_model->getProductoAllB();
        $marca = $marca_model->getMarcaAll();
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $igv_compra = $tablaMaestra_model->getMaestroByTipo(51);
        $almacen = $almacen_model->getAlmacenB();
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);
        $tipo_documento_cliente = $tablaMaestra_model->getMaestroByTipo(75);
        $sede = $sede_model->getSedeAll();
        
		return view('frontend.ingreso_salida_secundarios.modal_ingreso_salida_secundario_nuevoIngresoSalidaSecundario',compact('id','ingreso_salida_secundario','tipo_documento','unidad_origen','empresas','personas','producto','marca','unidad','igv_compra','almacen','moneda','unidad_medida','tipo_documento_cliente','sede'));

    }

    public function send_ingreso_salida_secundario(Request $request){

        $id_user = Auth::user()->id;

        if($request->id == 0){
            $ingreso_salida_secundario = new IngresoSalidaSecundario;
            $ingreso_salida_secundario_model = new IngresoSalidaSecundario;
            $codigo_ingreso_salida_secundario = $ingreso_salida_secundario_model->getCodigoIngresoSalidaB($request->tipo_documento);
        }else{
            $ingreso_salida_secundario = IngresoSalidaSecundario::find($request->id);
            $codigo_ingreso_salida_secundario = $request->numero_ingreso_salida;
        }

        $descripcion = $request->input('descripcion');
        $codigo = $request->input('codigo');
        $marca = $request->input('marca');
        $unidad = $request->input('unidad');
        $cantidad = $request->input('cantidad');
        $precio_unitario = $request->input('precio_unitario');
        $precio_dolar = $request->input('precio_dolar');
        $sub_total = $request->input('sub_total');
        $igv = $request->input('igv');
        $total = $request->input('total');
        $id_ingreso_salida_b_detalle =$request->id_ingreso_salida_b_detalle;

        $ingreso_salida_secundario->id_tipo_documento = $request->tipo_documento;
        $ingreso_salida_secundario->id_tipo_cliente = $request->tipo_documento_cliente;
        $ingreso_salida_secundario->id_persona = $request->persona;
        $ingreso_salida_secundario->id_empresa = $request->empresa;
        $ingreso_salida_secundario->id_almacen = $request->almacen;
        $ingreso_salida_secundario->fecha_ingreso_salida = $request->fecha;
        $ingreso_salida_secundario->fecha_comprobante = $request->fecha_comprobante;
        if($request->id == 0){
            $ingreso_salida_secundario->numero_ingreso_salida = $codigo_ingreso_salida_secundario[0]->codigo;
        }else{
            $ingreso_salida_secundario->numero_ingreso_salida = $codigo_ingreso_salida_secundario;
        }
        $ingreso_salida_secundario->id_unidad_origen = $request->unidad_origen;
        $ingreso_salida_secundario->id_almacen_salida = $request->almacen_salida;
        $ingreso_salida_secundario->id_sede = $request->sede;
        $ingreso_salida_secundario->id_centro_costo = $request->centro_costo;
        $ingreso_salida_secundario->observacion = $request->observacion;
        $ingreso_salida_secundario->igv_compra = $request->igv_compra;
        $ingreso_salida_secundario->id_moneda = $request->moneda;
        $ingreso_salida_secundario->tipo_cambio = $request->tipo_cambio;
        $ingreso_salida_secundario->tipo_cambio_sunat = $request->tipo_cambio_sunat;
        $ingreso_salida_secundario->sub_total = round($request->sub_total_general,2);
        $ingreso_salida_secundario->igv = round($request->igv_general,2);
        $ingreso_salida_secundario->total = round($request->total_general,2);
        $ingreso_salida_secundario->total_contabilidad = round($request->total_contable_general,2);
        $ingreso_salida_secundario->id_usuario_inserta = $id_user;
        $ingreso_salida_secundario->estado = 1;
        $ingreso_salida_secundario->save();
        $id_ingreso_salida_secundario = $ingreso_salida_secundario->id;
        $array_ingreso_salida_secundario_detalle = array();

        foreach($descripcion as $index => $value) {
            
            if($id_ingreso_salida_b_detalle[$index] == 0){
                $ingreso_salida_secundario_detalle = new IngresoSalidaSecundarioDetalle;
            }else{
                $ingreso_salida_secundario_detalle = IngresoSalidaSecundarioDetalle::find($id_ingreso_salida_b_detalle[$index]);
            }
            
            $ingreso_salida_secundario_detalle->id_ingreso_salida_secundario = $id_ingreso_salida_secundario;
            $ingreso_salida_secundario_detalle->id_producto = $descripcion[$index];
            $ingreso_salida_secundario_detalle->cantidad = $cantidad[$index];
            $ingreso_salida_secundario_detalle->precio = round($precio_unitario[$index],2);
            $ingreso_salida_secundario_detalle->precio_dolar = round($precio_dolar[$index],2);
            $ingreso_salida_secundario_detalle->sub_total = round($sub_total[$index],2);
            $ingreso_salida_secundario_detalle->igv = round($igv[$index],2);
            $ingreso_salida_secundario_detalle->total = round($total[$index],2);
            $ingreso_salida_secundario_detalle->id_unidad_medida = $unidad[$index];
            $ingreso_salida_secundario_detalle->id_marca = $marca[$index];
            $ingreso_salida_secundario_detalle->estado = 1;
            $ingreso_salida_secundario_detalle->id_usuario_inserta = $id_user;
            $ingreso_salida_secundario_detalle->save();

            $array_ingreso_salida_secundario_detalle[] = $ingreso_salida_secundario_detalle->id;

            /*$IngresoSalidaSecundarioAll = IngresoSalidaSecundarioDetalle::where("id_ingreso_salida_secundario",$id_ingreso_salida_secundario)->where("estado","1")->get();
            
            foreach($IngresoSalidaSecundarioAll as $key=>$row){
                
                if (!in_array($row->id, $array_ingreso_salida_secundario_detalle)){
                    $ingreso_salida_secundario_detalle = IngresoSalidaSecundarioDetalle::find($row->id);
                    $ingreso_salida_secundario_detalle->estado = 0;
                    $ingreso_salida_secundario_detalle->save();
                }
            }*/

            $producto = Producto::find($descripcion[$index]);
            
            $idProducto = $descripcion[$index];
			
            $idCorte = KardexSecundario::where('id_producto', $descripcion[$index])->where('id_almacen', $request->almacen)->whereDate('fecha', '<=', Carbon::now())->orderBy('fecha', 'desc')->orderBy('id', 'desc')->value('id');
            
            $saldoBase = $idCorte > 0 ? KardexSecundario::where('id', $idCorte)->value('saldos_cantidad') : 0;
            $costoBase = $idCorte > 0 ? KardexSecundario::where('id', $idCorte)->value('costo_saldos_cantidad') : 0;
            $totalBase = $idCorte > 0 ? KardexSecundario::where('id', $idCorte)->value('total_saldos_cantidad') : 0;

            $kardex_secundario = new KardexSecundario;
            $kardex_secundario->id_producto = $idProducto;
            $kardex_secundario->id_unidad_medida = $unidad[$index];
            $kardex_secundario->id_almacen = $request->almacen;
            $kardex_secundario->fecha = Carbon::now();

            if($request->tipo_documento == 1){
                if($saldoBase == 0){
                    if($request->igv_compra == 2){
                        $costo_unitario = round(($precio_unitario[$index] / 1.18),2);
                        $costo_unitario_ = $costo_unitario;
                        $total_kardex = round($sub_total[$index],2);
                    }else{
                        $costo_unitario = round(($precio_unitario[$index]),2);
                        $costo_unitario_ = $costo_unitario;
                        $total_kardex = round($sub_total[$index],2);
                    }
                }else{
                    $total_kardex = $totalBase + $sub_total[$index];
                    $costo_unitario = round($total_kardex / ($saldoBase + $cantidad[$index]),2);
                    $costo_unitario_ = round(($precio_unitario[$index] / 1.18),2);
                }
            }else{
                $costo_unitario_ = $costoBase;
                $total_salida = round(($costo_unitario_ * $cantidad[$index]),2);
                $total_kardex = round(($totalBase - $total_salida),2);
                $costo_unitario = round($total_kardex / ($saldoBase - $cantidad[$index]),2);
            }

            if($request->tipo_documento == 1){
                $kardex_secundario->entradas_cantidad = $cantidad[$index];
                $kardex_secundario->salidas_cantidad = 0;
                $kardex_secundario->costo_entradas_cantidad = $costo_unitario_;
                $kardex_secundario->total_entradas_cantidad = $sub_total[$index];
                $kardex_secundario->saldos_cantidad = $saldoBase + $cantidad[$index];
                $kardex_secundario->costo_saldos_cantidad = $costo_unitario;
                $kardex_secundario->total_saldos_cantidad = $total_kardex;
            }else{
                $kardex_secundario->entradas_cantidad = 0;
                $kardex_secundario->salidas_cantidad = $cantidad[$index];
                $kardex_secundario->costo_salidas_cantidad = $costo_unitario_;
                $kardex_secundario->total_salidas_cantidad = $total_salida;
                $kardex_secundario->saldos_cantidad = $saldoBase - $cantidad[$index];
                $kardex_secundario->costo_saldos_cantidad = $costo_unitario;
                $kardex_secundario->total_saldos_cantidad = $total_kardex;
            }

            $kardex_secundario->id_entrada_salida_secundario = $id_ingreso_salida_secundario;
            $kardex_secundario->id_usuario_inserta = $id_user;
            $kardex_secundario->save();
        }
        
        return response()->json(['id' => $id_ingreso_salida_secundario]);
        
    }

    public function cargar_detalle($id)
    {

        $ingreso_salida_secundario_model = new IngresoSalidaSecundario;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;

        $ingreso_salida_secundario = $ingreso_salida_secundario_model->getDetalleIngresoSalidaSecundarioById($id);
        $marca = $marca_model->getMarcaAll();
        $producto = $producto_model->getProductoAllB();
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);

        return response()->json([
            'ingreso_salida_secundario' => $ingreso_salida_secundario,
            'marca' => $marca,
            'producto' => $producto,
            'unidad_medida' => $unidad_medida
        ]);
    }
}
