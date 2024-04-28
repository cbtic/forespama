<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
