<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
