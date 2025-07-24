<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Kardex extends Model
{
    use HasFactory;

    protected $table = 'kardex';


    protected $fillable = [
        'id_producto',
        'entradas_cantidad',
        'costo_entradas_cantidad',
        'total_entradas_cantidad',
        'salidas_cantidad',
        'costo_salidas_cantidad',
        'total_salidas_cantidad',
        'saldos_cantidad',
        'costo_saldos_cantidad',
        'total_saldos_cantidad'
    ];

    public function listar_kardex_ajax($p){

        return $this->readFuntionPostgres('sp_listar_kardex_paginado',$p);

    }

    public function listar_kardex_existencia_ajax($p){

        return $this->readFuntionPostgres('sp_listar_kardex_existencia_paginado',$p);

    }

    public function listar_kardex_existencia_producto_ajax($p){

        return $this->readFuntionPostgres('sp_listar_kardex_existencia_producto_paginado',$p);

    }

    public function listar_kardex_consulta_producto_ajax($p){

        return $this->readFuntionPostgres('sp_listar_kardex_consulta_producto_paginado',$p);

    }

    public function listar_kardex_consulta_producto_orden_compra_ajax($p){

        return $this->readFuntionPostgres('sp_listar_kardex_orden_compra_saldos_paginado',$p);

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

    function getExistenciaProductoById($id, $id_almacen_salida){

        $cad = "select *, k.saldos_cantidad - coalesce((select sum(ocd.cantidad_requerida) cantidad_requerida from orden_compra_detalles ocd where ocd.id_producto = '".$id."' and ocd.comprometido = '1' and ocd.cerrado = '1'),0) stock_comprometido
        from kardex k 
        where k.id_producto = '".$id."' and  k.id_almacen_destino = '".$id_almacen_salida."'
        order by 1 desc
        limit 1";

		$data = DB::select($cad);
        return $data;
    }

    function getStockComprometidoProductoById($id, $id_almacen_salida){

        $cad = "select k.saldos_cantidad - (select sum(ocd.cantidad_requerida) cantidad_requerida from orden_compra_detalles ocd where ocd.id_producto = '".$id."' and ocd.comprometido = '".$id_almacen_salida."') stock_comprometido
        from kardex k 
        where k.id_producto = '".$id."' and k.id_almacen_destino = '".$id_almacen_salida."'
        order by k.id desc
        limit 1";

		$data = DB::select($cad);
        return $data;
    }

}
