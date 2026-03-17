<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AsistenciaPromotore;

class AsistenciaController extends Controller
{
    public function index()
    {
        $asistencia = new AsistenciaPromotore();

        $datos = $asistencia->getAsistenciasPendientes();

        return response()->json($datos);
    }
}
