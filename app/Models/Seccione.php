<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccione extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'denominacion',
        'estado'
    ];

    public function almacenes()
    {
        return $this->belongsToMany(Almacene::class, "almacenes_secciones", "id_secciones", "id_almacenes");
    }

    public function anaqueles()
    {
        return $this->belongsToMany(Anaquele::class, "anaqueles_secciones", "id_secciones", "id_anaqueles");
    }
}
