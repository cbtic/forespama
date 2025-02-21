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
     return $this->belongsToMany(Empresa::class, 'empresas_vehiculos', 'id_vehiculos', 'id_empresas');
     //  return $this->belongsTo(Empresa::class);
   }

   public function conductores()
   {
       return $this->belongsToMany(Conductores::class,'vehiculos_conductores', 'id_vehiculos', 'id_conductores');
   }

   public function personas($id_conductores)
   {
       return Persona::with('conductores')->where('id_conductores',$id_conductores);
   }

   function getVehiculoDatos($placa){

        $cad = "select c.id, c.licencia, c.fecha_licencia, c.estado, c.id_personas, p.nombres||' '||p.apellido_paterno||' '||p.apellido_materno nombre_conductor from conductores c 
        inner join personas p on c.id_personas = p.id ";

        //limit 2620";

        $data = DB::select($cad);
        return $data;
    }

    function getVehiculoDatosGuia($placa){

        $cad = "select v.id, v.id_marca, v.ejes, v.peso_tracto, v.peso_carreta, v.peso_seco, v.exonerado, v.control, v.bloqueado, v.estado, v.constancia_inscripcion
        from vehiculos v 
        where v.placa ='".$placa."'
        order by 1 desc
        limit 1";
    
        $data = DB::select($cad);
        return $data;
    }

}
