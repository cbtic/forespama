<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalidaProductoDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_salida_productos',
        'id_producto',
        'item',
        'cantidad',
        'numero_lote',
        'fecha_vencimiento',
        'aplica_precio',
        'id_um',
        'id_estado_productos',
        'id_marca',
        'estado'
    ];
}
