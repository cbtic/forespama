<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Conductores extends Model
{
    use HasFactory;
    protected $fillable = ["licencia","fecha_licencia","estado","id_personas"];

    public function personas()
    {
	  //return $this->hasMany(EstacionamientoEmpresa::class,'empresa_id');
        return $this->belongsTo(Persona::class,"id_personas");
    }

    public function full_name2($id, $activo='inactivo')
    {
        $nombre_completo_sin_dni = Conductores::find($id)->personas['nombre_completo_sin_dni'];

        return ['nombre_completo_sin_dni' => $nombre_completo_sin_dni];
    }

    public function full_name($activo='CANCELADO')
    {
        $conductores_estado = Conductores::where('estado', $activo)->get();

        $array_conductores=[];

        foreach ($conductores_estado  as $key => $conductor) {
            $array_conductores[] = ['id' => $conductor->id, 'nombre_completo_sin_dni' => $conductor->personas['nombre_completo_sin_dni']];
        }

        $json = json_encode($array_conductores);
        $obj = json_decode($json);

        return $obj;
    }

   public function vehiculos()
   {
       return $this->belongsToMany(Vehiculo::class,'vehiculos_conductores', 'id_vehiculos', 'id_conductores');
   }

   function getConductorAll(){

        $cad = "select c.id, c.licencia, c.fecha_licencia, c.estado, c.id_personas, p.nombres||' '||p.apellido_paterno||' '||p.apellido_materno nombre_conductor from conductores c 
        inner join personas p on c.id_personas = p.id ";

        //limit 2620";

        $data = DB::select($cad);
        return $data;
    }

    function getLicenciaByConductor($conductor){

        $cad = "select * from conductores c 
        where c.id='".$conductor."'
        and c.estado='ACTIVO'";

        //limit 2620";

        $data = DB::select($cad);
        return $data;
    }

    public function listar_conductor_ajax($p){
		return $this->readFunctionPostgres('sp_listar_conductor_paginado',$p);
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

}
