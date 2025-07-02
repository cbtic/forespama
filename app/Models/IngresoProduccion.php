<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class IngresoProduccion extends Model
{
    protected $table = 'ingreso_produccion';

    use HasFactory;

    public function listar_ingreso_produccion_ajax($p){

        return $this->readFuntionPostgres('sp_listar_ingreso_produccion_paginado',$p);

    }

    public function listar_ingreso_produccion_detalle_ajax($p){

        return $this->readFuntionPostgres('sp_listar_ingreso_produccion_detalle_paginado',$p);

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

    function getCodigoIngresoProduccion($tipo_documento){

        $cad = "select lpad(coalesce(max(ip.codigo::int) + 1, 1)::varchar, 6, '0') codigo
        from ingreso_produccion ip
        where ip.id_tipo_documento = '".$tipo_documento."'";

		$data = DB::select($cad);
        return $data;
    }

    function getDetalleIngresoProduccionById($id){

        $cad = "select ipd.id,  ROW_NUMBER() OVER (PARTITION BY ipd.id_ingreso_produccion) AS row_num, p.numero_serie item, ipd.id_producto, p.codigo, ipd.id_marca, ipd.id_unidad_medida, 
        ipd.id_estado_producto , ipd.cantidad, ip.id_almacen_destino 
        from ingreso_produccion_detalles ipd 
        inner join productos p on ipd.id_producto = p.id
        inner join ingreso_produccion ip on ipd.id_ingreso_produccion = ip.id
        where ipd.id_ingreso_produccion ='".$id."'
        and ipd.estado='1'";

		$data = DB::select($cad);
        return $data;
    }

    function getIngresoProduccionById($id){

        $cad = "select ip.id, tm.denominacion tipo_documento, a.denominacion almacen, ip.fecha, ip.codigo, u.name usuario_ingreso
        from ingreso_produccion ip 
        inner join tabla_maestras tm on ip.id_tipo_documento ::int = tm.codigo::int and tm.tipo = '53'
        inner join almacenes a on ip.id_almacen_destino = a.id 
        inner join users u on ip.id_usuario_inserta = u.id
        where ip.id ='".$id."'";

		$data = DB::select($cad);
        return $data;
    }
}
