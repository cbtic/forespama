<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Moneda;

class MonedaController extends Controller
{
    
    public function all_ajax(Request $request)
    {
        $modelo = new Moneda;
        $p[] = $request->id;
		$p[] = $request->denominacion;
		$p[] = $request->abreviatura;
		$p[] = $request->simbolo;
		$p[] = $request->estado;
        $p[] = $request->NumeroPagina;
        $p[] = $request->NumeroRegistros;
        $data = $modelo->all_ajax($p);
        $iTotalDisplayRecords = isset($data[0]->totalrows) ? $data[0]->totalrows : 0;

        $result = [
            "PageStart" => $request->NumeroPagina,
            "pageSize" => $request->NumeroRegistros,
            "SearchText" => "",
            "ShowChildren" => true,
            "iTotalRecords" => $iTotalDisplayRecords,
            "iTotalDisplayRecords" => $iTotalDisplayRecords,
            "aaData" => $data
        ];

        return response()->json($result);
    }

    public function index()
    {
        return view('moneda.index');
    }

    public function all()
    {
        return view('moneda.all');
    }

    public function modal($id)
    {
        if ($id > 0) {
            $moneda = Moneda::find($id);
        } else {
            $moneda = new Moneda;
        }
        return view('moneda.modal',compact('id','moneda'));
    }

    public function send(Request $request)
    {
        if ($request->id == 0) {
            $modelo = new Moneda;
        } else {
            $modelo = Moneda::find($request->id);
            
            if (!$modelo) {
                return response()->json(['error' => 'Registro no encontrado'], 404);
            }

        }
        $modelo->denominacion = $request->denominacion;
		$modelo->abreviatura = $request->abreviatura;
		$modelo->simbolo = $request->simbolo;
		$modelo->estado = $request->estado;
        $modelo->save();
        return response()->json(['success' => true, 'message' => 'Registro guardado correctamente.']);
    }

    public function eliminar($id, $estado)
    {
        $modelo = Moneda::find($id);
        $modelo->estado = $estado;
        $modelo->save();
        return response()->json(['success' => true, 'message' => 'Registro elimino correctamente.']);
    }

}
