<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class RequerimientoDispensacione extends Model
{
    use HasFactory;

    public function listar_requerimiento_dispensacion_ajax($p){

        return $this->readFuntionPostgres('sp_listar_requerimiento_dispensacion_paginado',$p);

    }

    public function listar_reporte_requerimiento_dispensacion_ajax($p){

        return $this->readFuntionPostgres('sp_listar_reporte_requerimiento_dispensacion_paginado',$p);

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

    function getCodigoRequerimientoDispensacion(){

        $cad = "select lpad(coalesce(max(rd.codigo::int) + 1, 1)::varchar, 6, '0') codigo
        from requerimiento_dispensaciones rd";

		$data = DB::select($cad);
        return $data;
    }

    function getDetalleRequerimientoDispensacionId($id){

        $cad = "select rdd.id,  ROW_NUMBER() OVER (PARTITION BY rdd.id_requerimiento_dispensacion ) AS row_num, rdd.id_producto, p.codigo, p.denominacion nombre_producto, rdd.id_marca, rdd.id_unidad_medida, 
        rdd.cantidad, rd.id_almacen
        from requerimiento_dispensacion_detalles rdd 
        inner join productos p on rdd.id_producto = p.id
        inner join requerimiento_dispensaciones rd on rdd.id_requerimiento_dispensacion = rd.id
        where rdd.id_requerimiento_dispensacion = '".$id."'
        and rdd.estado = '1'
        order by 1 asc ";

		$data = DB::select($cad);
        return $data;
    }

    function getRequerimientoDispensacionById($id){

        $cad = "select rd.id, tm.denominacion tipo_documento, s.denominacion sede, a.denominacion almacen, cc.denominacion centro_costo, rd.fecha, rd.codigo, p.nombres ||' '|| p.apellido_paterno ||' '|| p.apellido_materno usuario_recibe 
        from requerimiento_dispensaciones rd 
        inner join tabla_maestras tm on rd.id_tipo_documento ::int = tm.codigo::int and tm.tipo = '53'
        left join sedes s on rd.id_sede = s.id 
        inner join almacenes a on rd.id_almacen = a.id 
        left join centro_costos cc on rd.id_centro_costo = cc.id 
        left join personas p on rd.id_persona = p.id
        where rd.id ='".$id."'";

		$data = DB::select($cad);
        return $data;
    }
}
