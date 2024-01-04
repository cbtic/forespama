<?php

namespace App\Models;

<<<<<<< HEAD
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
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class TablaMaestra extends Model
{
    protected $fillable = ['tipo', 'denominacion', 'orden', 'estado', 'codigo', 'tipo_nombre'];

    // contantes TIPO
    const NC = 'NC';
    const ND = 'ND';
    const GUIA = 'GUIA';
    const DOC_RELA = 'DOC_RELA';
    const TIPO_OPE = 'TIPO_OPE';
    const TIPO_IGV = 'TIPO_IGV';
    const UNIDADES = 'UNIDADES';
    const CODIGOBYS = 'CODIGOBYS';
    const ESTADO_BALANZA = 'ESTADO BALANZA';
    const G_DOC_RELA = 'G_DOC_RELA';
    const MOTIVO_T = 'MOTIVO_T';
    const MODAL_T = 'MODAL_T';
    const SERIES = 'SERIES';
    const CAJA = 'CAJA';
    const BALANZA = 'BALANZA';
    const CARRETA = 'CARRETA';
    const ESPACIO = 'ESPACIO';
    const ESTACIONAMIENTO = 'ESTACIONAMIENTO';

    const ACTIVO = 'A';
    const CANCELADO = 'C';

    use HasFactory;

	public function listar_tabla_maestras_ajax($p){
		return $this->readFunctionPostgres('sp_listar_tabla_maestra_paginado',$p);
    }

	public function readFunctionPostgres($function, $parameters = null){

        $_parameters = '';
        if (count($parameters) > 0) {
            $_parameters = implode("','", $parameters);
            $_parameters = "'" . $_parameters . "',";
        }
        $data = DB::select("BEGIN;");
        $cad = "select " . $function . "(" . $_parameters . "'ref_cursor');";
        $data = DB::select($cad);
        $cad = "FETCH ALL IN ref_cursor;";
        $data = DB::select($cad);
        return $data;
     }
>>>>>>> 9a4f1f2bb159b571d65fee9572af8b1a5a93ac9f
}
