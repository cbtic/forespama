<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Proforma extends Model
{
    public function registrar_proforma($datos, $ddatos) {

        $cad = "Select sp_crud_proforma(?, ?)";
		$data = DB::select($cad, array($datos[0]), array($ddatos[0]));
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
