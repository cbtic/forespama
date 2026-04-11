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

    public function confirmar(Request $request)
    {
        $ids = $request->input('ids');
        
        if (empty($ids)) {
            return response()->json([
                'message' => 'No se recibieron IDs'
            ], 400);
        }

        DB::table('asistencia_promotores')
            ->whereIn('id', $ids)
            ->update([
                'flag_enviado' => 1,
                'fecha_envio_api' => now(),
                'updated_at' => now()
            ]);

        return response()->json([
            'message' => 'Registros actualizados correctamente'
        ]);
    }
}
