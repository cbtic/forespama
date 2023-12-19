<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class TablaMaestra extends Model
{
	function getCajaAllTipo($tipo){

        $cad = "select t1.id,t1.denominacion,t1.codigo 
		from tabla_maestras t1
		where t1.tipo='".$tipo."' and t1.estado='A' 
		And t1.id not in (select distinct id_caja from caja_ingresos where estado = '1')
		order by t1.id ";
    
		$data = DB::select($cad);
        return $data;
    }
	
    function getMaestro($tipo, $codigo){

        $cad = "select id,denominacion 
                from tabla_maestras 
                where tipo='".$tipo."' 
                and codigo like '".$codigo."%'
                order by orden ";
    
		$data = DB::select($cad);
        return $data;
    }
	
	function getMaestroByTipo($tipo){

        $cad = "select id,denominacion 
                from tabla_maestras 
                where tipo='".$tipo."' 
                order by orden ";
    
		$data = DB::select($cad);
        return $data;
    }
	
	function getMaestroByTipoAndTipoNombre($tipo,$tipo_nombre){

        $cad = "select id,denominacion 
                from tabla_maestras 
                where tipo='".$tipo."' 
				And tipo_nombre='".$tipo_nombre."' 
                order by orden ";
    
		$data = DB::select($cad);
        return $data;
    }
	
	function getMaestroByTipoIn($tipo1,$tipo2){

        $cad = "select id,denominacion 
                from tabla_maestras 
                where tipo in('".$tipo1."','".$tipo2."') 
                order by 1 asc ";
    
		$data = DB::select($cad);
        return $data;
    }
}
