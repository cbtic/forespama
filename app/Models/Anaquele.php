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
        'estado'
    ];

    public function secciones()
    {
        return $this->belongsToMany(Seccione::class, "anaqueles_secciones", "id_anaqueles", "id_secciones");
    }
}
