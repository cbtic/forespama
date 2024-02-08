<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = [
        'numero_serie',
        'codigo',
        'denominacion',
        'id_unidad_medida',
        'stock_actual',
        'precio_unitario',
        'id_moneda',
        'id_tipo_producto',
        'fecha_vencimiento',
        'id_estado_bien',
        'stock_minimo',
        'id_marca',
        'observacion',
        'id_seccion',
        'id_anaquel',
        'estado'
    ];


}
