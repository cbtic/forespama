<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AliadosPamaComisione extends Model
{
    use HasFactory;

    public function listar_aliados_pama_comisiones_ajax($p){

        return $this->readFuntionPostgres('sp_listar_aliados_pama_comisiones_paginado',$p);

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

    public function getDetalleComisionAliadoPama($numero_documento){
    
        $cad="select c.id, c.serie, c.numero, to_char(c.fecha,'yyyy-mm-dd') fecha, c.destinatario, c.cod_tributario, c.total, c.porcentaje_comision, p.nombres ||' '|| p.apellido_paterno ||' '|| p.apellido_materno nombre_aliado,
        tm.denominacion estado_solicitud, (c.total * c.porcentaje_comision / 100) - COALESCE(c.monto_pagado_comision, 0) total_pendiente_comision, c.monto_pagado_comision  
        from comprobantes c 
        inner join aliado_pamas ap on c.id_aliado_pama = ap.id
        inner join personas p on ap.id_persona = p.id and p.estado = '1'
        inner join tabla_maestras tm on c.estado_pago_comision ::int = tm.codigo ::int and tm.tipo= '125'
        Where 1=1 and c.anulado = 'N' and ap.estado = '1' and c.estado_pago_comision = '1' and p.id='".$numero_documento."'";

        $data = DB::select($cad);
        return $data;

    }
    
}
