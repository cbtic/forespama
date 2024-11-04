<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Dispensacione extends Model
{
    use HasFactory;

    public function listar_dispensacion_ajax($p){

        return $this->readFuntionPostgres('sp_listar_dispensacion_paginado',$p);

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

    function getCodigoDispensacion($tipo_documento){

        $cad = "select lpad(coalesce(max(d.codigo::int) + 1, 1)::varchar, 6, '0') codigo
        from dispensaciones d
        where d.id_tipo_documento = '".$tipo_documento."'";

		$data = DB::select($cad);
        return $data;
    }

    function getDetalleDispensacionById($id){

        $cad = "select dd.id,  ROW_NUMBER() OVER (PARTITION BY dd.id_dispensacion ) AS row_num, p.numero_serie item, dd.id_producto, p.codigo, dd.id_marca, dd.id_unidad_medida, 
        dd.id_estado_producto , dd.cantidad, d.id_almacen 
        from dispensacion_detalles dd 
        inner join productos p on dd.id_producto = p.id
        inner join dispensaciones d on dd.id_dispensacion = d.id
        where dd.id_dispensacion ='".$id."'
        and dd.estado='1'";

		$data = DB::select($cad);
        return $data;
    }

    function getDispensacionById($id){

        $cad = "select d.id, tm.denominacion tipo_documento, at.denominacion area_trabajo, a.denominacion almacen, ut.denominacion unidad_trabajo, d.fecha, d.codigo, p.nombres ||' '|| p.apellido_paterno ||' '|| p.apellido_materno usuario_recibe from dispensaciones d 
        inner join tabla_maestras tm on d.id_tipo_documento ::int = tm.codigo::int and tm.tipo = '53'
        inner join area_trabajo at on d.id_area_trabajo = at.id 
        inner join almacenes a on d.id_almacen = a.id 
        inner join unidad_trabajo ut on d.id_unidad_trabajo = ut.id 
        left join personas p on d.id_usuario_recibe = p.id
        where d.id ='".$id."'";

		$data = DB::select($cad);
        return $data;
    }

}
