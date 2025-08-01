<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class TipoEncargado extends Model
{
    use HasFactory;

    public function obtenerEncargadoByTipo($tipo){
    
        $cad="select te.id, p.nombres ||' '|| p.apellido_paterno ||' '|| p.apellido_materno encargado, te.estado from tipo_encargados te 
        inner join personas p on te.id_persona = p.id 
        where te.id_tipo_encargado ='".$tipo."'
        and te.estado = '1'";

        $data = DB::select($cad);
        return $data;

    }
}
