<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class UsuarioDescuento extends Model
{
    use HasFactory;

    public function listar_usuario_descuento_ajax($p){

        return $this->readFuntionPostgres('sp_listar_usuario_descuento_paginado',$p);

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

    function getUsuarioDescuento(){

        $cad = "select ud.id , u.id id_usuario, u.name usuario, ud.estado from usuario_descuentos ud 
        inner join users u on ud.id_usuario = u.id and u.active ='1'
        where ud.estado ='1'
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }

    function getDescuentoByUser($id_vendedor){

        $cad = "select coalesce((select tm.denominacion
        from usuario_descuentos ud
        inner join tabla_maestras tm on tm.codigo::int = ud.id_descuento and tm.tipo = '55'
        where ud.estado = '1'
        and ud.id_usuario = '".$id_vendedor."'
        limit 1), '0') descuento";

		$data = DB::select($cad);
        return $data;
    }
}
