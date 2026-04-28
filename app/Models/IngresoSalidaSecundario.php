<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class IngresoSalidaSecundario extends Model
{
    use HasFactory;

    public function listar_ingreso_salida_secundarios_ajax($p){

        return $this->readFuntionPostgres('sp_listar_ingreso_salida_secundario_paginado',$p);

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

    function getCodigoIngresoSalidaB($tipo_documento){

        $cad = "select lpad(coalesce(max(iss.numero_ingreso_salida::int) + 1, 1)::varchar, 6, '0') codigo
        from ingreso_salida_secundarios iss
        where iss.id_tipo_documento = '".$tipo_documento."' ";

		$data = DB::select($cad);
        return $data;
    }

    function getDetalleIngresoSalidaSecundarioById($id){

        $cad = "select issd.id,  ROW_NUMBER() OVER (PARTITION BY issd.id_ingreso_salida_secundario ) AS row_num, issd.id_producto, p.codigo, p.denominacion nombre_producto, 
        issd.id_marca, issd.id_unidad_medida, issd.cantidad, issd.precio, issd.precio_dolar, issd.sub_total, issd.igv, issd.total, iss.id_almacen, m.denominiacion marca
        from ingreso_salida_secundario_detalles issd 
        inner join productos p on issd.id_producto = p.id
        inner join ingreso_salida_secundarios iss on issd.id_ingreso_salida_secundario = iss.id
        left join marcas m on issd.id_marca=m.id
        where issd.id_ingreso_salida_secundario = '".$id."'
        and issd.estado = '1'
        order by issd.id asc";

		$data = DB::select($cad);
        return $data;
    }

}
