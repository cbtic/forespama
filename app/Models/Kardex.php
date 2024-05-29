<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    use HasFactory;

    protected $table = 'kardex';


    protected $fillable = [
        'id_producto',
        'id_unidad_medida',
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
}
