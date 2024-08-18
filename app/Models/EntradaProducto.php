<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class EntradaProducto extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_ingreso',
        'id_tipo_documento',
        'unidad_origen',
        'id_proveedor',
        'numero_comprobante',
        'fecha_comprobante',
        'id_moneda',
        'tipo_cambio_dolar',
        'sub_total_compra',
        'igv_compra',
        'total_compra',
        'cerrado',
        'observacion',
        'estado'
    ];

    public function listar_entrada_productos_ajax($p){

        return $this->readFuntionPostgres('sp_listar_entrada_producto_paginado',$p);

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
}
