<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    protected $table = 'lote_productos';

    protected $fillable = [
        'id_producto',
        'id_marca',
        'numero_lote',
        'numero_serie',
        'id_unidad_medida',
        'cantidad',
        'costo',
        'id_moneda',
        'fecha_fabricacion',
        'fecha_vencimiento',
        'id_almacen',
        'id_seccion',
        'id_anaquel',
        'estado'
    ];
}
