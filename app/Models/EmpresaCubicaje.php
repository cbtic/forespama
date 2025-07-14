<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class EmpresaCubicaje extends Model
{
    use HasFactory;

    public function listar_empresa_cubicaje_ajax($p){

        return $this->readFuntionPostgres('sp_listar_empresa_cubicaje_paginado',$p);

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

    function obtenerLetraEmpresa(){

        $cad = "select ec.letra, SUM(ivttm.cantidad) total_cantidad
        from ingreso_vehiculo_tronco_tipo_maderas ivttm
        inner join ingreso_vehiculo_troncos ivt on ivttm.id_ingreso_vehiculo_troncos = ivt.id
        left join empresa_cubicajes ec on ((ec.id_tipo_empresa = 2 and ec.id_empresa = ivt.id_empresa_proveedor and ec.id_conductor = ivt.id_conductores) or (ec.id_tipo_empresa = 1 and ec.id_empresa = ivt.id_empresa_proveedor))
        where ivttm.estado_acerrado = '1'
        group by ec.letra";

		$data = DB::select($cad);
        return $data;
    }
}
