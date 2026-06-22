<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AsientoContableVenta extends Model
{
    use HasFactory;

    public function listar_asiento_contable_venta_ajax($p){

        return $this->readFuntionPostgres('sp_listar_asiento_contable_venta_paginado',$p);

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

    function generarAsientosVentas(){

        $cad = "select c.id,
        case
            when c.id_moneda = '1' then '1212101'
            else '1212102'
        end cuenta, to_char(c.fecha, 'YYYYMM') annomes, '03' subdiario, c.correlativo_starsoft comprobante, to_char(c.fecha,'yyyy-mm-dd') fecha_registro, '02' tipo_anexo, c.cod_tributario codigo_cliente,
        c.tipo tipo_documento, c.serie ||'-'|| c.numero numero_documento, to_char(c.fecha,'yyyy-mm-dd') fecha_documento, (select c2.tipo from comprobantes c2 where c.id_comprobante_ncnd = c2.id ) tipo_documento_referencial, 
        (select c2.serie ||' '|| c2.numero from comprobantes c2 where c.id_comprobante_ncnd = c2.id ) numero_documento_referencial, c.impuesto igv, '' valor_isc, c.impuesto_factor tasa_igv,
        c.total importe, tm2.denominacion tasa_conversion, ocp.tasa_cambio tc, c.tipo ||' '|| c.serie ||'-'|| c.numero glosa_documento, ocp.glosa_movimiento,
        case 
            when c.anulado = 'N' then false
            else true
        end anulado /*debe - haber consultar*/, c.cod_tributario ruc_cliente, c.destinatario razon_social, /*centro_costos consultar*/ to_char(c.fecha_vencimiento,'yyyy-mm-dd') fecha_vencimiento,
        (select to_char(c2.fecha,'yyyy-mm-dd') from comprobantes c2 where c.id_comprobante_ncnd = c2.id ) fecha_documento_referencial, false exportacion, '' otros_impuestos, '' exonerado, '' otros_cargos, '' impuesto_bolsa
        from comprobantes c 
        inner join orden_compras oc on  NULLIF(c.orden_compra,'')::int = oc.id
        left join orden_compra_pagos ocp on oc.id = ocp.id_orden_compra
        left join tabla_maestras tm on ocp.id_banco = tm.codigo::int and tm.tipo ='16'
        left join tabla_maestras tm2 on ocp.id_conversion = tm2.codigo::int and tm2.tipo ='122'
        left join starsoft_bancos sb on tm.codigo::int = sb.id_banco_tm 
        left join starsoft_banco_detalles sbd on sb.id = sbd.id_starsoft_banco and c.id_moneda = sbd.id_moneda 
        where c.serie <> 'E001'
        and c.asiento_generado = '0'
        order by c.id desc";

		$data = DB::select($cad);
        return $data;
    }

    function asientosContableVentaPendientes(){

        $cad = "select acv.id, acv.id_comprobante, acv.cuenta, acv.annomes, acv.subdiario, acv.comprobante, acv.fecha_registro, acv.tipo_anexo, acv.codigo_cliente, acv.tipo_documento,
        acv.numero_documento, acv.fecha_documento, acv.tipo_documento_referencial, acv.numero_documento_referencial, acv.igv, acv.valor_isc, acv.tasa_igv, acv.importe, acv.tasa_cambio_conversion,
        acv.tasa_cambio, acv.glosa, acv.glosa_movimiento, acv.anulado, acv.debe_haber, acv.ruc_cliente, acv.razon_social, acv.centro_costo, acv.fecha_vencimiento, acv.fecha_documento_referencial,
        acv.exportacion, acv.otros_cargos, acv.impuesto_bolsa, acv.flag_migrado, acv.fecha_migrado, acv.estado
        from asiento_contable_ventas acv 
        where acv.flag_migrado = '0'
        and acv.estado ='1'
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }

    function asientosContableVentaDetallePendientes($id){

        $cad = "select acv.id, acv.cuenta, acv.annomes, acv.subdiario, acv.comprobante, acv.fecha_registro, acv.tipo_anexo, acv.codigo_cliente, acv.tipo_documento,
        acv.numero_documento, acv.fecha_documento, acv.tipo_documento_referencial, acv.numero_documento_referencial, acv.igv, acv.valor_isc, acv.tasa_igv, acv.importe, acv.tasa_cambio_conversion,
        acv.tasa_cambio, acv.glosa, acv.glosa_movimiento, acv.anulado, acv.debe_haber, acv.ruc_cliente, acv.razon_social, acv.centro_costo, acv.fecha_vencimiento, acv.fecha_documento_referencial,
        acv.exportacion, acv.otros_cargos, acv.impuesto_bolsa, acv.flag_migrado, acv.fecha_migrado, acv.estado
        from asiento_contable_ventas acv 
        where acv.flag_migrado = '0'
        and acv.estado ='1'
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }

    function asientosContableVentaIgvPendientes($id){

        $cad = "select cd.id, cd.id_comprobante, cd.afect_igv from comprobante_detalles cd 
        where cd.id_comprobante ='".$id."'
        and cd.estado ='1'
        order by 1 asc
        limit 1";

		$data = DB::select($cad);
        return $data;
    }
}
