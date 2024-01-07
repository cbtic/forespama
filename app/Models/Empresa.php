<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Empresa extends Model
{
    protected $fillable = ['ruc', 'razon_social', 'nombre_comercial', 'direccion', 'representante'];

	public function listar_empresa_ajax($p){
		return $this->readFunctionPostgres('sp_listar_empresa_paginado',$p);
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

}
