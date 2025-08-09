<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class EmpresaVehiculo extends Model
{
    protected $table = 'empresas_vehiculos';

    public $timestamps = false;

    use HasFactory;

    function getEmpresaTransporte(){

        $cad = "select distinct e.id, e.razon_social from empresas_vehiculos ev 
        inner join empresas e on ev.id_empresas = e.id
        where e.estado = '1'
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }
}
