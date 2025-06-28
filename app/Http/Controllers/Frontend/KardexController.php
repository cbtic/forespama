<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests\KardexRequest;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use App\Models\Kardex;
use App\Models\Producto;
use App\Models\Almacene;
use App\Models\TablaMaestra;
use App\Models\Empresa;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use stdClass;
use Auth;

class KardexController extends Controller
{
    /*public function index()
    {
        $kardex = Kardex::latest()->paginate(10);
        return view('frontend.kardex.index', compact('kardex'));
    }*/

    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function create(){

		//$tablaMaestra_model = new TablaMaestra;
		//$estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
		$id_user = Auth::user()->id;

        $producto_model = new Producto;
		$almacen_model = new Almacene;
        $producto = $producto_model->getProductoAll();
		$almacen = $almacen_model->getAlmacenByUser($id_user);
		
		return view('frontend.kardex.create',compact('producto','almacen'));

	}

    public function listar_kardex_ajax(Request $request){

		$kardex_model = new Kardex;
		$p[]=$request->producto;
		$p[]=$request->almacen;
		$p[]=$request->fecha_inicio;
		$p[]=$request->fecha_fin;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $kardex_model->listar_kardex_ajax($p);
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

	public function create_consulta(){

		//$tablaMaestra_model = new TablaMaestra;
		//$estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
		$id_user = Auth::user()->id;

        $producto_model = new Producto;
		$almacen_model = new Almacene;
        $producto = $producto_model->getProductoAll();
		$almacen = $almacen_model->getAlmacenByUser($id_user);
		
		return view('frontend.kardex.create_consulta',compact('producto','almacen'));

	}

	public function listar_kardex_existencia_ajax(Request $request){

		$kardex_model = new Kardex;
		$p[]="";
		$p[]=$request->almacen_existencia;
		$p[]=$request->cantidad_producto;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $kardex_model->listar_kardex_existencia_ajax($p);

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

	public function listar_kardex_existencia_producto_ajax(Request $request){

		$kardex_model = new Kardex;
		$p[]=$request->producto_existencia;
		$p[]=$request->almacen_existencia;
		$p[]=$request->cantidad_producto;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $kardex_model->listar_kardex_existencia_producto_ajax($p);
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

	public function exportar_listar_existencia($consulta_almacen) {

		if($consulta_almacen=="0")$consulta_almacen = "";

		$kardex_model = new Kardex;
		$p[]="";
		$p[]=$consulta_almacen;
		$p[]=1;
		$p[]=10000;
		$data = $kardex_model->listar_kardex_existencia_ajax($p);
	
		$variable = [];
		$n = 1;

		array_push($variable, array("N","Codigo","Producto","Saldos","Almacen"));
		
		foreach ($data as $r) {

			array_push($variable, array($n++,$r->codigo, $r->denominacion, $r->saldos_cantidad, $r->almacen_kardex));
		}
		
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'Reporte_existencias.xlsx');
		
    }

	public function create_consulta_productos(){

		
		$id_user = Auth::user()->id;

        $producto_model = new Producto;
		$almacen_model = new Almacene;
		$tablaMaestra_model = new TablaMaestra;

		$tipo_producto = $tablaMaestra_model->getMaestroByTipo(44);
        $producto = $producto_model->getProductoExterno();
        $producto_all = $producto_model->getProductoAll();
		$almacen = $almacen_model->getAlmacenByUser($id_user);
		
		return view('frontend.kardex.create_consulta_productos',compact('producto','almacen','tipo_producto','producto_all'));

	}

	public function listar_kardex_consulta_producto_ajax(Request $request){

		$id_user = Auth::user()->id;

		$kardex_model = new Kardex;
		$p[]=$request->consulta_existencia_producto;
		$p[]=$request->consulta_almacen_producto;
		$p[]=$request->cantidad_existencia_producto;
		$p[]=$request->consulta_tipo_producto;
		$p[]=$id_user;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $kardex_model->listar_kardex_consulta_producto_ajax($p);
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

	public function exportar_listar_existencia_consulta_producto($consulta_existencia_producto, $consulta_almacen_producto, $consulta_tipo_producto, $cantidad_existencia_producto) {

		$id_user = Auth::user()->id;

		if($consulta_existencia_producto=="0")$consulta_existencia_producto = "";
		if($consulta_almacen_producto=="0")$consulta_almacen_producto = "";
		if($consulta_tipo_producto=="0")$consulta_tipo_producto = "";

		$kardex_model = new Kardex;
		$p[]=$consulta_existencia_producto;
		$p[]=$consulta_almacen_producto;
		$p[]=$cantidad_existencia_producto;
		$p[]=$consulta_tipo_producto;
		$p[]=$id_user;
		$p[]=1;
		$p[]=10000;
		$data = $kardex_model->listar_kardex_consulta_producto_ajax($p);
		
		$variable = [];
		$n = 1;

		array_push($variable, array("N","Codigo","Producto","Saldos","Stock Comprometido","Cantidad Disponible","Unidad Medida","Tipo Producto","Almacen"));
		
		foreach ($data as $r) {

			array_push($variable, array($n++,$r->codigo, $r->denominacion, $r->saldos_cantidad, $r->cantidad_orden_compra, $r->saldo_final, $r->unidad_medida, $r->tipo_producto, $r->almacen_kardex));
		}
		
		$export = new InvoicesExport2([$variable]);
		return Excel::download($export, 'Reporte_existencias_consulta_producto.xlsx');
		
    }

	public function exportar_listar_consulta_kardex($almacen, $producto, $fecha_inicio, $fecha_fin) {

		if($almacen==0)$almacen = "";
		if($producto==0)$producto = "";
		if($fecha_inicio=="0")$fecha_inicio = "";
		if($fecha_fin=="0")$fecha_fin = "";

		$kardex_model = new Kardex;
		$p[]=$producto;
		$p[]=$almacen;
		$p[]=$fecha_inicio;
		$p[]=$fecha_fin;
		$p[]=1;
		$p[]=10000;
		$data = $kardex_model->listar_kardex_ajax($p);
		
		$variable = [];
		$n = 1;

		array_push($variable, array("N","Codigo","Producto","Entrada","Costo Entrada","Total Entrada","Salidas","Costo Salidas","Total Salidas","Saldos","Costo Saldos","Total Saldos","Almacen","Fecha","Tipo Movimiento","Codigo Movimiento"));
		
		foreach ($data as $r) {

			array_push($variable, array($n++,$r->codigo, $r->producto, $r->entrada, $r->costo_entrada, $r->total_entrada, $r->salida, $r->costo_salida, $r->total_salida, $r->saldos, $r->costo_saldos, $r->total_saldos, $r->almacen_destino, $r->fecha_kardex, $r->tipo_movimiento, $r->codigo_movimiento));
		}
		
		$export = new InvoicesExport3([$variable]);
		return Excel::download($export, 'Reporte_kardex.xlsx');
		
    }

	public function create_consulta_productos_orden_compra(){

		
		$id_user = Auth::user()->id;

        $producto_model = new Producto;
		$almacen_model = new Almacene;
		$tablaMaestra_model = new TablaMaestra;
		$empresa_model = new Empresa;

        $producto = $producto_model->getProductoExterno();
        $producto_all = $producto_model->getProductoAll();
		$almacen = $almacen_model->getAlmacenByUser($id_user);
		$empresas = $empresa_model->getEmpresaAll();
		
		return view('frontend.kardex.create_consulta_productos_orden_compra',compact('producto','almacen','producto_all','empresas'));

	}

	public function listar_kardex_consulta_producto_orden_compra_ajax(Request $request){

		$id_user = Auth::user()->id;

		$kardex_model = new Kardex;
		$p[]=$request->consulta_oc_existencia_producto;
		$p[]=$request->consulta_oc_almacen_producto;
		$p[]=$id_user;
		$p[]=$request->consulta_oc_empresa;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $kardex_model->listar_kardex_consulta_producto_orden_compra_ajax($p);
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

	public function exportar_listar_consulta_producto_oc($consulta_oc_existencia_producto, $consulta_oc_almacen_producto, $consulta_oc_empresa) {

		$id_user = Auth::user()->id;

		if($consulta_oc_existencia_producto==0)$consulta_oc_existencia_producto = "";
		if($consulta_oc_almacen_producto==0)$consulta_oc_almacen_producto = "";
		if($consulta_oc_empresa==0)$consulta_oc_empresa = "";

		$kardex_model = new Kardex;
		$p[]=$consulta_oc_existencia_producto;
		$p[]=$consulta_oc_almacen_producto;
		$p[]=$id_user;
		$p[]=$consulta_oc_empresa;
		$p[]=1;
		$p[]=10000;
		$data = $kardex_model->listar_kardex_consulta_producto_orden_compra_ajax($p);
		
		$variable = [];
		$n = 1;

		array_push($variable, array("N","Codigo","Producto","Saldos","Stock Comprometido","Cantidad Disponible","Almacen"));
		
		foreach ($data as $r) {

			array_push($variable, array($n++,$r->codigo, $r->producto, $r->saldos_cantidad, $r->cantidad_orden_compra, $r->saldo_final, $r->almacen_kardex));
		}
		
		$export = new InvoicesExport4([$variable]);
		return Excel::download($export, 'Reporte_Productos_Orden_Compra.xlsx');
		
    }

}

class InvoicesExport implements FromArray, WithHeadings, WithStyles
{
	protected $invoices;

	public function __construct(array $invoices)
	{
		$this->invoices = $invoices;
	}

	public function array(): array
	{
		return $this->invoices;
	}

    public function headings(): array
    {
        return ["N","Codigo","Producto","Saldos","Almacen"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:E1');

        $sheet->setCellValue('A1', "REPORTE DE CONSULTA DE EXISTENCIAS - FORESPAMA");
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '246257'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

		$sheet->getStyle('A1')->getAlignment()->setWrapText(true);
		$sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->getStyle('A2:E2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2EB85C'],
            ],
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    		],
        ]);

		$sheet->fromArray($this->headings(), NULL, 'A2');

		/*$sheet->getStyle('L3:L'.$sheet->getHighestRow())
		->getNumberFormat()
		->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);*/ //SIRVE PARA PONER 2 DECIMALES A ESA COLUMNA
        
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}

class InvoicesExport2 implements FromArray, WithHeadings, WithStyles
{
	protected $invoices;

	public function __construct(array $invoices)
	{
		$this->invoices = $invoices;
	}

	public function array(): array
	{
		return $this->invoices;
	}

    public function headings(): array
    {
        return ["N","Codigo","Producto","Saldos","Stock Comprometido","Cantidad Disponible","Unidad Medida","Tipo Producto","Almacen"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:I1');

        $sheet->setCellValue('A1', "REPORTE DE CONSULTA DE EXISTENCIAS POR PRODUCTO- FORESPAMA");
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '246257'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

		$sheet->getStyle('A1')->getAlignment()->setWrapText(true);
		$sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->getStyle('A2:I2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2EB85C'],
            ],
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    		],
        ]);

		//$sheet->fromArray($this->headings(), NULL, 'I2');

		/*$sheet->getStyle('L3:L'.$sheet->getHighestRow())
		->getNumberFormat()
		->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);*/ //SIRVE PARA PONER 2 DECIMALES A ESA COLUMNA
        
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}

class InvoicesExport3 implements FromArray, WithHeadings, WithStyles
{
	protected $invoices;

	public function __construct(array $invoices)
	{
		$this->invoices = $invoices;
	}

	public function array(): array
	{
		return $this->invoices;
	}

    public function headings(): array
    {
        return ["N","Codigo","Producto","Entrada","Costo Entrada","Total Entrada","Salidas","Costo Salidas","Total Salidas","Saldos","Costo Saldos","Total Saldos","Almacen","Fecha","Tipo Movimiento","Codigo Movimiento"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:P1');

        $sheet->setCellValue('A1', "REPORTE DE KARDEX - FORESPAMA");
        $sheet->getStyle('A1:P1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '246257'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

		$sheet->getStyle('A1')->getAlignment()->setWrapText(true);
		$sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->getStyle('A2:P2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2EB85C'],
            ],
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    		],
        ]);

		//$sheet->fromArray($this->headings(), NULL, 'I2');

		/*$sheet->getStyle('L3:L'.$sheet->getHighestRow())
		->getNumberFormat()
		->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);*/ //SIRVE PARA PONER 2 DECIMALES A ESA COLUMNA
        
        foreach (range('A', 'P') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}

class InvoicesExport4 implements FromArray, WithHeadings, WithStyles
{
	protected $invoices;

	public function __construct(array $invoices)
	{
		$this->invoices = $invoices;
	}

	public function array(): array
	{
		return $this->invoices;
	}

    public function headings(): array
    {
        return ["N","Codigo","Producto","Saldos","Stock Comprometido","Cantidad Disponible","Almacen"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:G1');

        $sheet->setCellValue('A1', "REPORTE DE PRODUCTOS POR ORDEN DE COMPRA - FORESPAMA");
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '246257'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

		$sheet->getStyle('A1')->getAlignment()->setWrapText(true);
		$sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->getStyle('A2:G2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2EB85C'],
            ],
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    		],
        ]);

		//$sheet->fromArray($this->headings(), NULL, 'I2');

		/*$sheet->getStyle('L3:L'.$sheet->getHighestRow())
		->getNumberFormat()
		->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);*/ //SIRVE PARA PONER 2 DECIMALES A ESA COLUMNA
        
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
