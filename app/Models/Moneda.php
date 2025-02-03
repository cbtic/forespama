<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Moneda extends Model
{
    use HasFactory;

    // Método para obtener todos los monedas
    public function all_ajax($p)
    {
        return readFunctionPostgres('sp_listar_moneda_paginado',$p);
    }

}
