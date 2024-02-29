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
        'telefono',
        'encargado',
        'estado'
    ];

    public function ubigeos()
    {
        return $this->belongsTo(Ubigeo::class,"id_ubigeo","id_ubigeo");
    }

    public function secciones()
    {
        return $this->belongsToMany(Seccione::class, "almacenes_secciones", "id_almacenes", "id_secciones");
    }
}
