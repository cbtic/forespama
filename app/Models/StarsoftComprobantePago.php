<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class StarsoftComprobantePago extends Model
{
    use HasFactory;

    function getImportePago($id){

        $cad = "select 
        coalesce((select sum(c.total) 
        from comprobantes c  
        where c.id = '".$id."'), 0)precio,
        coalesce((select sum(importe) 
        from starsoft_comprobante_pagos scp 
        where scp.id_comprobante = '".$id."'
        and scp.estado = '1'), 0) pago";

		$data = DB::select($cad);
        return $data[0];
    }

    function getComprobantePagoById($id){

        $cad = " select scp.id, scp.fecha, tm.denominacion tipodesembolso, scp.importe, scp.observacion, scp.nro_cheque, scp.foto_desembolso, scp.id_comprobante, c.orden_compra 
        from comprobantes c
        left join starsoft_comprobante_pagos scp on c.id = scp.id_comprobante 
        left join tabla_maestras tm on scp.id_tipo_desembolso = tm.codigo::int and tm.tipo='65'
        where scp.id_comprobante = '".$id."'
        and scp.estado = '1'
        order by scp.id desc ";

		$data = DB::select($cad);
        return $data;
    }

    function getComprobanteGuiaById($id){

        $cad = " select gi.id, gi.fecha_traslado, gi.guia_serie || '-' || gi.guia_numero AS serie_numero, gi.ruta_imagen, gi.observacion_recepcion, oc.id AS id_orden_compra
        FROM comprobantes c
        LEFT JOIN orden_compras oc ON oc.id = CASE WHEN c.orden_compra = '' THEN 0 ELSE c.orden_compra::int END
        LEFT JOIN salida_productos sp ON sp.id_orden_compra = oc.id
        LEFT JOIN guia_internas gi ON gi.numero_documento::int = sp.id
        WHERE c.id = '".$id."'
        AND c.estado = '1'
        AND c.anulado = 'N'
        AND sp.tipo_devolucion = '3'
        AND gi.id_tipo_documento <> '4'
        AND gi.guia_anulado = 'N'
        AND gi.estado = '1' ";

		$data = DB::select($cad);
        return $data;
    }
}
