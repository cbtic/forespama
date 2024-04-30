<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EntradaProductoDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_entrada_productos',
        'id_producto',
        'item',
        'cantidad',
        'numero_lote',
        'fecha_vencimiento',
        'aplica_precio',
        'id_um',
        'id_estado_bien',
        'id_marca',
        'estado'
    ];

    public function scopeWithRowNumber($query, $column = 'id'){
        $sub = static::selectRaw('row_number() OVER () as row_number, *')
            ->toSql();
        $query->from(DB::raw("({$sub}) as entrada_producto_detalles"));
    }
}
