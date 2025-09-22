<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SoatActivo extends Model
{
    use HasFactory;

    function getSoatActivo($id){

        $cad = "select sa.id, sa.id_activos, sa.numero_poliza, sa.fecha_emision, sa.fecha_vencimiento, tm.denominacion estado_soat, sa.estado from soat_activos sa 
        left join tabla_maestras tm on sa.estado_soat = tm.codigo::int and tm.tipo ='89'
        where sa.id_activos = '".$id."'
        and sa.estado = '1'
        order by 1 desc";
        
		$data = DB::select($cad);
        return $data;
    }

    function actualizarVigenciaSoat(){
        $p=array();
		return $this->readFunctionPostgresTransaction('sp_crud_actualizar_vigencia_soat',$p);
    }

    public function readFunctionPostgresTransaction($function, $parameters = null){
	
      $_parameters = '';
      if (count($parameters) > 0) {
	  		
			foreach($parameters as $par){
				if(is_string($par))$_parameters .= "'" . $par . "',";
				else $_parameters .= "" . $par . ",";
		  	}
			if(strlen($_parameters)>1)$_parameters= substr($_parameters,0,-1);
			
      }

	  $cad = "select " . $function . "(" . $_parameters . ");";
	  $data = DB::select($cad);
	  return $data[0]->$function;
   }
}
