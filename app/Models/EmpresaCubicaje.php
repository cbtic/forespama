<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class EmpresaCubicaje extends Model
{
    use HasFactory;

    public function listar_empresa_cubicaje_ajax($p){

        return $this->readFuntionPostgres('sp_listar_empresa_cubicaje_paginado',$p);

    }

    public function readFuntionPostgres($function, $parameters = null){

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

    function obtenerLetraEmpresa(){

        $cad = "select ec.letra from empresa_cubicajes ec
        where ec.letra is not null 
        order by letra asc ";

		$data = DB::select($cad);
        return $data;
    }
}
