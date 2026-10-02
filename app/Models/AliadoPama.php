<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AliadoPama extends Model
{
    use HasFactory;

    //protected $table = 'aliado_pama';

    protected $fillable = [
        'id_persona',
        'porcentaje_comision',
        'fecha_inicio',
        'id_usuario_inserta',
    ];

    public function listar_aliado_pama_ajax($p){

        return $this->readFuntionPostgres('sp_listar_aliado_pama_paginado',$p);

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

    public function getDatosAliado($numero_documento){
    
        $cad="select p.id, ap.id id_aliado, p.nombres ||' '|| p.apellido_paterno ||' '|| p.apellido_materno nombres, p.direccion, p.telefono, p.email, p.estado 
        from personas p 
        inner join aliado_pamas ap on p.id = ap.id_persona and ap.estado ='1' 
        where p.estado = '1' 
        and p.numero_documento = '".$numero_documento."'
        order by p.nombres asc";

        $data = DB::select($cad);
        return $data;

    }
}
