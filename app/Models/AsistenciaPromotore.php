<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AsistenciaPromotore extends Model
{
    use HasFactory;

    public function listar_asistencia_promotores_ajax($p){

        return $this->readFuntionPostgres('sp_listar_asistencia_promotor_paginado',$p);

    }

    public function readFuntionPostgres($function, $parameters = null){

        $_parameters = '';
        if (count($parameters) > 0) {
            $_parameters = implode("','", $parameters);
            $_parameters = "'" . $_parameters . "',";
        }
        $data = DB::select("BEGIN;");
        $cad = "select " . $function . "(" . $_parameters . "'ref_cursor');";
        $data = DB::select($cad);
        $cad = "FETCH ALL IN ref_cursor;";
        $data = DB::select($cad);
        return $data;

    }

    function getHoraIngresoDiario($id_promotor, $fecha){

        $cad = "select ap.hora_entrada from asistencia_promotores ap 
        where ap.id_promotor ='".$id_promotor."'
        and ap.fecha ='".$fecha."'
        and ap.estado ='1'
        order by 1 asc
        limit 1";

		$data = DB::select($cad);
        return $data;
    }

    function getPromotoresAll(){

        $cad = "select distinct u.id, u.name promotor from  asistencia_promotores ap 
        inner join users u on ap.id_promotor = u.id 
        where u.active = '1'";

		$data = DB::select($cad);
        return $data;
    }

    public function getAsistenciasPendientes()
    {
        $cad = "select ap.id, p.numero_documento, ap.fecha, ap.hora_entrada, ap.hora_salida  from asistencia_promotores ap 
            inner join users u on ap.id_promotor = u.id 
            inner join personas p on u.id_persona = p.id 
            where ap.flag_enviado = '0' 
            and ap.estado = '1'
            order by ap.fecha, ap.hora_entrada ";

        $data = DB::select($cad);
        
        /*$ids = array_column($data, 'id');

        if(!empty($ids)){
            DB::table('asistencia_promotores')->whereIn('id',$ids)->update(['flag_enviado' => 1,'fecha_envio_api' => now(),'updated_at' => now()]);
        }*/

        return $data;
    }
}
