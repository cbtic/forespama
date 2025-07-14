<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class IngresoVehiculoTroncoTipoMadera extends Model
{
    function getDetalleIngresoVehiculoAcerrado(){

        $cad = "select ivttm.id, e.ruc, e.razon_social, v.placa, tm.denominacion tipo_madera, ivttm.cantidad,
        (select ec.letra from empresa_cubicajes ec
        where ec.id_empresa = ivt.id_empresa_proveedor 
        limit 1)
        from ingreso_vehiculo_tronco_tipo_maderas ivttm 
        inner join ingreso_vehiculo_troncos ivt on ivttm.id_ingreso_vehiculo_troncos = ivt.id
        inner join empresas e on ivt.id_empresa_proveedor = e.id 
        inner join vehiculos v on ivt.id_vehiculos = v.id 
        inner join tabla_maestras tm on tm.codigo::int = ivttm.id_tipo_maderas and tm.tipo ='42'
        where ivttm.estado_acerrado ='1'
        and ivttm.estado = '1' ";

		$data = DB::select($cad);
        return $data;
    }
}
