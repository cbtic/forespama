<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class TablaMaestra extends Model
{
    use HasFactory;

	public function listar_persona_ajax($p){
		return $this->readFunctionPostgres('listar_tabla_maestras_ajax',$p);
    }

}
