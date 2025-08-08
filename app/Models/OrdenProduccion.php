<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class OrdenProduccion extends Model
{
    protected $table = 'orden_produccion';

    use HasFactory;

    public function listar_orden_produccion_ajax($p){

        return $this->readFuntionPostgres('sp_listar_orden_produccion_paginado',$p);

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

    function getCodigoOrdenProduccion(){

        $cad = "select lpad(coalesce(max(op.codigo::int) + 1, 1)::varchar, 6, '0') codigo
        from orden_produccion op ";

		$data = DB::select($cad);
        return $data;
    }

    function getDetalleOrdenProduccionById($id){

        $cad = "select opd.id,  ROW_NUMBER() OVER (PARTITION BY opd.id_orden_produccion ) AS row_num, p.numero_serie item, opd.id_producto, p.codigo, p.denominacion nombre_producto, tm.denominacion unidad_medida, p.id_unidad_medida, opd.cantidad
        from orden_produccion_detalles opd 
        inner join productos p on opd.id_producto = p.id
        inner join orden_produccion op on opd.id_orden_produccion = op.id
        left join tabla_maestras tm on p.id_unidad_medida::int = tm.codigo::int and tm.tipo = '43'
        where opd.id_orden_produccion='".$id."'
        and opd.estado='1'
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }
}
