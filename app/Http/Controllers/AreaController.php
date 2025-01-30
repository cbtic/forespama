<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;

class AreaController extends Controller
{
    //
    public function all_ajax(Request $request)
    {
        $modelo = new Area;
        $p[] = $request->id;
		$p[] = $request->producto;
		$p[] = $request->montoinicio;
		$p[] = $request->total;
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
        return view('area.index');
    }

    public function all()
    {
        return view('area.all');
    }

    public function modal($id)
    {
        if ($id > 0) {
            $area = Area::find($id);
        } else {
            $area = new Area;
        }
        return view('area.modal',compact('id','area'));
    }

    public function send(Request $request)
    {
        if ($request->id == 0) {
            $modelo = new Area;
        } else {
            $modelo = Area::find($request->id);
            
            if (!$modelo) {
                return response()->json(['error' => 'Registro no encontrado'], 404);
            }

        }
        $modelo->producto = $request->producto;
		$modelo->montoinicio = $request->montoinicio;
		$modelo->total = $request->total;
		$modelo->estado = $request->estado;
        $modelo->save();
        return response()->json(['success' => true, 'message' => 'Registro guardado correctamente.']);
    }

    public function eliminar($id, $estado)
    {
        $modelo = Area::find($request->id);
        $modelo->estado = $estado;
        $modelo->save();
        return response()->json(['success' => true, 'message' => 'Registro elimino correctamente.']);
    }

}
