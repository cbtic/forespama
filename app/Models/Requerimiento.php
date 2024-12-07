<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Requerimiento extends Model
{
    use HasFactory;

    public function listar_requerimiento_ajax($p){

        return $this->readFuntionPostgres('sp_listar_requerimiento_paginado',$p);

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

    function getCodigoRequerimiento($tipo_documento){

        $cad = "select lpad(coalesce(max(r.codigo::int) + 1, 1)::varchar, 6, '0') codigo
        from requerimientos r
        where id_tipo_documento = '".$tipo_documento."'";

		$data = DB::select($cad);
        return $data;
    }

    function getDetalleRequerimientoId($id){

        $cad = "select rd.id,  ROW_NUMBER() OVER (PARTITION BY rd.id_requerimiento ) AS row_num, p.numero_serie item, rd.id_producto, p.codigo, p.denominacion nombre_producto, rd.id_marca, rd.id_unidad_medida, 
        rd.id_estado_producto , rd.cantidad, r.id_almacen_destino 
        from requerimiento_detalles rd 
        inner join productos p on rd.id_producto = p.id
        inner join requerimientos r on rd.id_requerimiento = r.id
        where id_requerimiento ='".$id."'
        and rd.estado='1'";

		$data = DB::select($cad);
        return $data;
    }

    function getRequerimientoById($id){

        $cad = "select r.id, tm.denominacion tipo_documento, a.denominacion almacen, r.fecha, r.codigo, u.name responsable_atencion, tm2.denominacion estado_atencion, r.sustento_requerimiento
        from requerimientos r
        inner join tabla_maestras tm on r.id_tipo_documento ::int = tm.codigo::int and tm.tipo = '59'
        inner join almacenes a on r.id_almacen_destino = a.id
        left join users u on r.responsable_atencion = u.id
        left join tabla_maestras tm2 on r.estado_atencion ::int = tm2.codigo::int and tm2.tipo = '60'
        where r.id ='".$id."'";

		$data = DB::select($cad);
        return $data;
    }

}
