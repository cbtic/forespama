<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ProduccionAcerradoMadera extends Model
{
    use HasFactory;

    public function listar_produccion_acerrado_madera_ajax($p){

        return $this->readFuntionPostgres('sp_listar_produccion_acerrado_madera_paginado',$p);

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

    public function getDetalleAcerrado(){
    
        $cad="select pamd.id, pam.fecha_produccion, pamd.id_tipo_madera, tm.denominacion tipo_madera, pamd.id_medida, tm2.denominacion medida, pamd.cantidad_pendiente cantidad_paquetes, pamd.medida1_paquete, pamd.medida2_paquete, pamd.total_n_piezas 
        from produccion_acerrado_madera_detalles pamd 
        inner join produccion_acerrado_maderas pam on pamd.id_produccion_acerrado_maderas = pam.id 
        inner join tabla_maestras tm on tm.codigo::int = pamd.id_tipo_madera and tm.tipo ='42'
        inner join tabla_maestras tm2 on tm2.codigo::int = pamd.id_medida and tm2.tipo ='82'
        where pamd.estado_produccion_acerrado ='1'
        order by 1 asc";

        $data = DB::select($cad);
        return $data;

    }

    public function getDetalleAcerradoPendienteByLote(){
    
        $cad="select ipam.id, ipam.lote, sum(ipamd.cantidad_ingreso_tronco) cantidad from ingreso_produccion_acerrado_madera_detalles ipamd 
        inner join ingreso_produccion_acerrado_maderas ipam on ipamd.id_ingreso_produccion_acerrado_maderas = ipam.id 
        where ipamd.estado_ingreso_acerrado ='1'
        and ipamd.estado ='1'
        group by ipam.id, ipam.lote";
        
        $data = DB::select($cad);
        return $data;

    }
}
