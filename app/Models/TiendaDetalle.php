<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class TiendaDetalle extends Model
{
    protected $table = 'tienda_detalle';
    
    use HasFactory;

    function getTiendaByEmpresa($empresa){

        $cad = "select t.id, e.razon_social, t.denominacion from tienda_detalle td 
        inner join tiendas t on td.id_tienda = t.id 
        inner join empresas e on td.id_empresa = e.id 
        where td.id_empresa ='".$empresa."'
        order by 1 desc";
    
		$data = DB::select($cad);
        return $data;
    }
}
