<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Area extends Model
{
    use HasFactory;

    // Método para obtener todos los areas
    public function all_ajax($p)
    {
        return readFunctionPostgres('sp_listar_area_paginado',$p);
    }

}
