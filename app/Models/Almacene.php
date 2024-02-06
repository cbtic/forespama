<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacene extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'denominacion',
        'id_ubigeo',
        'direccion',
        'estado'
    ];

    public function ubigeos()
    {
        return $this->belongsTo(Ubigeo::class,"id_ubigeo","id_ubigeo");
    }

}
