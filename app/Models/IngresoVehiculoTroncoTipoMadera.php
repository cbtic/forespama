<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class IngresoVehiculoTroncoTipoMadera extends Model
{
    function getCantidadMaderaByLetraEmpresa($letra_empresa_cubicaje){

        $cad = "select coalesce((select ivttm.cantidad from ingreso_vehiculo_troncos ivt
        inner join ingreso_vehiculo_tronco_tipo_maderas ivttm on ivt.id = ivttm.id_ingreso_vehiculo_troncos and ivttm.estado ='1'
        left join empresa_cubicajes ec on ivt.id_empresa_proveedor = ec.id_empresa and ec.estado ='1'
        where ec.letra is not null and ivttm.estado_acerrado ='1'
        and ec.letra ='".$letra_empresa_cubicaje."'
        order by ivttm.id desc limit 1),0) cantidad";

		$data = DB::select($cad);
        return $data;
    }
}
