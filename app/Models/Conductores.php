<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conductores extends Model
{
    use HasFactory;
    protected $fillable = ["licencia","fecha_licencia","estado","id_personas"];

    public function personas()
    {
	  //return $this->hasMany(EstacionamientoEmpresa::class,'empresa_id');
        return $this->belongsTo(Persona::class,"id_personas");
    }

   public function vehiculos()
   {
       return $this->belongsToMany(Vehiculo::class,'vehiculos_conductores', 'id_vehiculos', 'id_conductores');
   }
}
