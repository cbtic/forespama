<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Activo extends Model
{
    use HasFactory;

    public function listar_activos_ajax($p){

        return $this->readFuntionPostgres('sp_listar_activos_paginado',$p);

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
    
    function getProvinciaDistritoById($id){

        $cad = "select u.id_provincia provincia_partida, u.id_ubigeo distrito_partida from activos a 
        inner join ubigeos u on a.id_ubigeo = u.id_ubigeo::int
        where a.id = '".$id."' ";

		$data = DB::select($cad);
        return $data;
    }

    function getCodigoActivo($familia, $sub_familia){

        $cad = "select sf.inicial_codigo || lpad((coalesce(MAX(SUBSTRING(a.codigo_activo from '.{4}$')::INT), 0) + 1)::TEXT,4, '0') as codigo
        from sub_familias sf
        left join activos a on a.id_sub_familia = sf.id and a.id_familia = '".$familia."' and a.id_sub_familia = '".$sub_familia."'
        where sf.id = '".$sub_familia."'
        group by sf.inicial_codigo";

		$data = DB::select($cad);
        return $data;
    }

    function getSubTipoActivo($id){

        $cad = "select a.id, a.id_sub_tipo_activo 
        from activos a 
        where a.id = '".$id."' 
        and a.estado = '1' ";

		$data = DB::select($cad);
        return $data;
    }

    function getSubFamilia($id){

        $cad = "select a.id, a.id_sub_familia 
        from activos a
        where a.id = '".$id."' 
        and a.estado = '1' ";

		$data = DB::select($cad);
        return $data;
    }

    function getActivoSinEntrega(){

        $cad = " select a.*
        from activos a
        left join activo_usuarios au on a.id = au.id_activo
        where au.id_activo is null 
        or au.fecha_devolucion is not null
        and a.estado ='1'
        and au.estado ='1' ";

		$data = DB::select($cad);
        return $data;
    }

    function getActivosById($id){

        $cad = " select a.*
        from activos a
        inner join activo_usuarios au on a.id = au.id_activo
        where au.id = '".$id."' ";

		$data = DB::select($cad);
        return $data;
    }
}
