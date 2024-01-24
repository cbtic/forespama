<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Vehiculo extends Model
{
    protected $fillable = [
        'placa',
        'ejes',
        'peso_tracto',
        'peso_carreta',
        'peso_seco',
        'estado',
        'id_usuario_actualiza',
        'id_usuario_inserta'
    ];

	public function listar_vehiculo_ajax($p){
		return $this->readFunctionPostgres('sp_listar_vehiculo_paginado',$p);
    }

	public function readFunctionPostgres($function, $parameters = null){

      $_parameters = '';
      if (count($parameters) > 0) {
          $_parameters = implode("','", $parameters);
          $_parameters = "'" . $_parameters . "',";
      }
	  DB::select("BEGIN;");
	  $cad = "select " . $function . "(" . $_parameters . "'ref_cursor');";
	  DB::select($cad);
	  $cad = "FETCH ALL IN ref_cursor;";
	  $data = DB::select($cad);
	  DB::select("END;");
      return $data;
   }

   public function empresas()
   {
     return $this->belongsToMany(Empresa::class, 'empresas_vehiculos', 'empresas_id', 'vehiculos_id');
     //  return $this->belongsTo(Empresa::class);
   }

   public function conductores()
   {
       return $this->belongsToMany(Conductores::class,'vehiculos_conductores', 'vehiculos_id', 'conductores_id');
   }
}
