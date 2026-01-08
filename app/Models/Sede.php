<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Sede extends Model
{
    protected $fillable = ['denominacion','estado'];

    use HasFactory;

    public function listar_sede_ajax($p){

        return $this->readFuntionPostgres('sp_listar_sedes_paginado',$p);

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

    function getSerie($id_sede, $tipo_documento){

        if($tipo_documento=='FT'){
            $serie = " s.serie_factura ";
        }

        if($tipo_documento=='BV'){
            $serie = " s.serie_boleta ";
        }

        if($tipo_documento=='GR'){
            $serie = " s.serie_guia ";
        }

        $cad = "select ".$serie." denominacion from sedes s 
        where s.id = '".$id_sede."'
        and s.estado='1'";

		$data = DB::select($cad);
        return $data;
    }

    public function users() 
    {
        return $this->belongsToMany(User::Class);
    }

    public function empresas()
    {
        return $this->belongsToMany(Empresa::class);
    }
}