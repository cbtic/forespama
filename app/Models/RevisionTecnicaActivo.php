<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class RevisionTecnicaActivo extends Model
{
    use HasFactory;

    function getRevisionTecnicaActivo($id){

        $cad = "select rta.id, rta.id_activos, rta.numero_certificado, rta.fecha_emision, rta.fecha_vencimiento, tm.denominacion estado_revision, tm2.denominacion resultado_revision, rta.estado from revision_tecnica_activos rta 
        left join tabla_maestras tm on rta.estado_revision = tm.codigo::int and tm.tipo ='89'
        left join tabla_maestras tm2 on rta.id_resultado_revision  = tm2.codigo::int and tm2.tipo ='90'
        where rta.id_activos = '".$id."'
        and rta.estado = '1'
        order by 1 desc";

		$data = DB::select($cad);
        return $data;
    }

    function actualizarVigenciaRevisionTecnica(){
        $p=array();
		return $this->readFunctionPostgresTransaction('sp_crud_actualizar_vigencia_revision_tecnica',$p);
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
