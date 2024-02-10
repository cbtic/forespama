<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ubigeo;

class UbigeoController extends Controller
{

    public function getProvincias(Request $request)
    {
        $data = Ubigeo::select("name as value", "id")
                    ->where('name', 'LIKE', '%'. $request->get('search'). '%')
                    ->get();

        return response()->json($data);
    }

    public function getDistritos(Request $request)
    {
        $data = Ubigeo::select("name as value", "id")
                    ->where('name', 'LIKE', '%'. $request->get('search'). '%')
                    ->get();

        return response()->json($data);
    }
}
