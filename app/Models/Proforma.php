<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Proforma extends Model
{
    public function registrar_proforma1($p){
		return $this->readFunctionPostgres('sp_crud_proforma',$p);
    }

    public function registrar_proforma($p, $pd) {
        $cad = "Select sp_crud_proforma(?,?)";
		//echo "Select sp_crud_proforma('".$p."', '".$pd."')";
        //exit();
		$data = DB::select($cad, array($p, $pd));
        return $data[0]->sp_crud_proforma;
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
