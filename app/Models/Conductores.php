<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conductores extends Model
{
    use HasFactory;
    protected $fillable = ["licencia","fecha_licencia","estado"];

    public function personas()
    {
	  //return $this->hasMany(EstacionamientoEmpresa::class,'empresa_id');
        return $this->belongsTo(Persona::class);
    }
}
