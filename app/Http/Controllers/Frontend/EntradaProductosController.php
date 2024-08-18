<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests\EntradaProductoRequest;
use App\Models\EntradaProducto;
use App\Models\TablaMaestra;
use App\Models\Empresa;
use App\Models\TipoCambio;
use App\Models\EntradaProductoDetalle;
use App\Models\Producto;
use App\Models\Almacene;
use App\Models\AlmacenesSeccione;
use App\Models\Anaquele;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class EntradaProductosController extends Controller
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

		/*$tablaMaestra_model = new TablaMaestra;
		$estado_bien = $tablaMaestra_model->getMaestroByTipo(4);*/
		
		return view('frontend.entrada_productos.create');

	}

    public function listar_entrada_productos_ajax(Request $request){

		$entrada_producto_model = new EntradaProducto;
		$p[]=$request->denominacion;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $entrada_producto_model->listar_entrada_productos_ajax($p);
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

    public function modal_entrada_producto($id){
		
        $tablaMaestra_model = new TablaMaestra;
        $tipo_cambio_model = new TipoCambio;
        $almacen_model = new Almacene;
        $id_user = Auth::user()->id;
		
		if($id>0){
			$entrada_producto = EntradaProducto::find($id);
            $proveedor = Empresa::find($entrada_producto->id_proveedor);
            $tipo_cambio = null;
            //$proveedor = $almacen_model->getAlmacenAll();
            $almacen = null;
		}else{
			$entrada_producto = new EntradaProducto;
            $proveedor = Empresa::all();
            $tipo_cambio = $tipo_cambio_model->getTipoCambioUltimo();
            $almacen = $almacen_model->getAlmacenByUser($id_user);
		}

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(48);
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);
        $unidad_origen = $tablaMaestra_model->getMaestroByTipo(50);
        $cerrado_entrada = $tablaMaestra_model->getMaestroByTipo(52);
        $igv_compra = $tablaMaestra_model->getMaestroByTipo(51);

        //$producto = $producto_model->getProductoAll();
        
        //dd($proveedor);exit();

		return view('frontend.entrada_productos.modal_entradas_nuevoEntrada',compact('id','entrada_producto','tipo_documento','moneda','unidad_origen','proveedor','tipo_cambio','cerrado_entrada','igv_compra','almacen'));

    }

    public function send_entrada_producto(Request $request){

        if($request->tipo_movimiento==1){
            if($request->id == 0){
                $entrada_producto = new EntradaProducto;
            }else{
                $entrada_producto = EntradaProducto::find($request->id);
            }
            
            $entrada_producto->fecha_ingreso = $request->fecha_entrada;
            $entrada_producto->id_tipo_documento = $request->tipo_documento;
            $entrada_producto->unidad_origen = $request->unidad_origen;
            $entrada_producto->id_proveedor = $request->proveedor;
            $entrada_producto->numero_comprobante = $request->numero_comprobante;
            $entrada_producto->fecha_comprobante = "18/08/2024";
            $entrada_producto->id_moneda = $request->moneda;
            $entrada_producto->tipo_cambio_dolar = $request->tipo_cambio_dolar;
            $entrada_producto->sub_total_compra = 100;
            $entrada_producto->igv_compra = $request->igv_compra;
            $entrada_producto->total_compra = 100;
            $entrada_producto->cerrado = $request->cerrado;
            $entrada_producto->observacion = $request->observacion;
            $entrada_producto->estado = 1;
            $entrada_producto->save();

        }else if($request->tipo_movimiento==2){
            if($request->id == 0){
                $salida_producto = new SalidaProducto;
            }else{
                $salida_producto = SalidaProducto::find($request->id);
            }
            
            $salida_producto->fecha_salida = $request->fecha_entrada;
            $salida_producto->id_tipo_documento = $request->tipo_documento;
            $salida_producto->unidad_destino = $request->unidad_origen;
            $salida_producto->numero_comprobante = $request->numero_comprobante;
            $salida_producto->fecha_comprobante = "18/08/2024";
            $salida_producto->id_moneda = $request->moneda;
            $salida_producto->tipo_cambio_dolar = $request->tipo_cambio_dolar;
            $salida_producto->sub_total_compra = 100;
            $salida_producto->igv_compra = $request->igv_compra;
            $salida_producto->total_compra = 100;
            $salida_producto->cerrado = $request->cerrado;
            $salida_producto->observacion = $request->observacion;
            $salida_producto->estado = 1;
            $salida_producto->save();
        }
    }

    public function eliminar_entrada_producto($id,$estado)
    {
		$entrada_producto = EntradaProducto::find($id);

		$entrada_producto->estado = $estado;
		$entrada_producto->save();

		echo $entrada_producto->id;
    }

    public function modal_detalle_producto($id){
        
        $tablaMaestra_model = new TablaMaestra;
        $empresa_model = new Empresa;
        $producto_model = new Producto;
        $almacen_model = new Almacene;
        $almacen_seccion_model = new AlmacenesSeccione;
        $anaquel_model = new Anaquele;
        $tipo_cambio_model = new TipoCambio;
        $id_user = Auth::user()->id;
		
        //$datos = $request->all();
        //$id = $datos['id'];
       
        if($id>0){
			$entrada_producto_detalle = EntradaProductoDetalle::find($id);
            $entrada_producto = EntradaProducto::find($id);
            $proveedor_ = Empresa::find($entrada_producto->id_proveedor);
            $proveedor = $proveedor_->getEmpresa($entrada_producto->id_proveedor);
            //dd($proveedor);exit();
            //dd($entrada_producto->tipo_cambio_dolar);exit();
            $tipo_cambio = null;
            $almacen_ = null;
            //$almacen__ = Almacene::getAlmacenById($entrada_producto->id_almacen);
            
            $almacen = $almacen_model->getAlmacenByUser($id_user);
		}else{
			$entrada_producto_detalle = new EntradaProductoDetalle;
            $entrada_producto = new EntradaProducto;
            $proveedor = Empresa::all();
            //dd($proveedor);exit();
            $tipo_cambio = $tipo_cambio_model->getTipoCambioUltimo();
            $almacen = $almacen_model->getAlmacenByUser($id_user);
		}
        
        //$tipo_documento = $tablaMaestra_model->getMaestroC(48,$datos['tipo_documento']);
        //var_dump($tipo_documento[0]->denominacion);exit();
        //$moneda = $tablaMaestra_model->getMaestroC(1,$datos['moneda']);
        //$unidad_origen = $tablaMaestra_model->getMaestroC(50,$datos['unidad_origen']);
        //$cerrado_entrada = $tablaMaestra_model->getMaestroC(52,$datos['cerrado']);
        //$igv_compra = $tablaMaestra_model->getMaestroC(51,$datos['igv_compra']);
        //$proveedor = $empresa_model->getEmpresa($datos['proveedor']);
        $producto = $producto_model->getProductoAll();
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        //$almacen = $almacen_model->getAlmacenById($datos['almacen']);
        
        //$almacen_seccion = $almacen_seccion_model->getSeccionByAlmacen($datos['almacen']);

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(48);
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);
        $unidad_origen = $tablaMaestra_model->getMaestroByTipo(50);
        $cerrado_entrada = $tablaMaestra_model->getMaestroByTipo(52);
        $igv_compra = $tablaMaestra_model->getMaestroByTipo(51);
        $tipo_movimiento = $tablaMaestra_model->getMaestroByTipo(53);


		return view('frontend.entrada_productos.modal_entradas_detalleEntrada',compact('id','entrada_producto_detalle','tipo_documento','moneda','unidad_origen','cerrado_entrada','igv_compra','proveedor','producto','unidad','almacen'/*,'almacen_seccion'*/,'tipo_cambio','tipo_movimiento','entrada_producto'));

    }

    public function obtener_documento_entrada(){
		
		$tabla_maestra_model = new TablaMaestra;
		$ubigeo_usuario = $tabla_maestra_model->getMaestroByTipo(48);
		
		echo json_encode($ubigeo_usuario);
	}

    public function obtener_documento_salida(){
		
		$tabla_maestra_model = new TablaMaestra;
		$ubigeo_usuario = $tabla_maestra_model->getMaestroByTipo(49);
		
		echo json_encode($ubigeo_usuario);
	}


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function index()
    {
        $entrada_productos = EntradaProducto::latest()->paginate(10);

        return view('frontend.entrada_productos.index', compact('entrada_productos'));
    }*/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function create()
    {
        return view('frontend.entrada_productos.create');
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*public function store(Request $request)
    {
        $entrada_productos = EntradaProducto::create($request->all());

        return redirect()->route('frontend.entrada_productos.edit', compact('entrada_productos'));
    }*/

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function show(EntradaProducto $entrada_productos)
    {
        // dd($entrada_productos);exit;

        return view('frontend.entrada_productos.show', compact('entrada_productos'));
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function edit(EntradaProducto $entrada_productos)
    {
        return view('frontend.entrada_productos.edit', compact('entrada_productos'));
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function update(EntradaProductoRequest $request, EntradaProducto $entrada_productos)
    {
        $entrada_productos->update($request->all());

        return redirect()->route('frontend.entrada_productos.edit', compact('entrada_productos'));
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function destroy(EntradaProducto $entrada_productos)
    {
        if ($entrada_productos->delete()) {
            Alert::success('Proceso completo', 'Se ha eliminado la entrada '.$entrada_productos['id']);
        };
        return redirect()->route('frontend.entrada_productos.index');
    }*/
}
