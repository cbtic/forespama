<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anaquele extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'denominacion',
        'id_seccion',
        'id_almacen',
        'estado'
    ];

    public function almacenes()
    {
        return $this->belongsTo(Almacene::class, "id_almacen", "id");
    }

}
