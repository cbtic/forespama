<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SalidaProducto extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_salida',
        'id_tipo_documento',
        'unidad_destino',
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

    function getSalidaById($id){

        $cad = "select sp.id, 'SALIDA' tipo, sp.fecha_salida fecha_movimiento, tm.denominacion tipo_documento, tm2.denominacion unidad_destino, '' razon_social, sp.numero_comprobante, sp.fecha_comprobante, sp.estado, sp.created_at, tm3.denominacion moneda, sp.observacion, '' unidad_origen  
        from salida_productos sp 
        inner join tabla_maestras tm on sp.id_tipo_documento = tm.codigo ::int and tm.tipo = '49'
        inner join tabla_maestras tm2 on sp.unidad_destino ::int = tm2.codigo::int and tm2.tipo = '50'
        inner join tabla_maestras tm3 on sp.id_moneda ::int = tm3.codigo::int and tm3.tipo = '1'
        where sp.id='".$id."'
        and sp.estado='1'";

		$data = DB::select($cad);
        return $data;
    }
}
