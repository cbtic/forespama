<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class GuiaInterna extends Model
{
    use HasFactory;

    public function listar_guia_interna_ajax($p){

        return $this->readFuntionPostgres('sp_listar_guia_interna_paginado',$p);

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

    function getProvinciaDistritoById($id){

        $cad = "select u.id_provincia provincia_partida, u.id_ubigeo distrito_partida, u2.id_provincia provincia_llegada, u2.id_ubigeo distrito_llegada from guia_internas gi 
        inner join ubigeos u on gi.id_ubigeo_partida = u.id_ubigeo 
        inner join ubigeos u2 on gi.id_ubigeo_llegada = u2.id_ubigeo 
        where gi.id='".$id."'";

		$data = DB::select($cad);
        return $data;
    }

    function getNumeroGuia($serie){

        $cad = "select lpad(coalesce (max(gi.guia_numero::int)+1,1 )::varchar, 4,'0') codigo from guia_internas gi 
        where gi.guia_serie = '".$serie."'";

		$data = DB::select($cad);
        return $data;
    }

    function getGuiaInternaById($id){

        $cad = "select gi.id, gi.fecha_emision, gi.punto_partida, gi.punto_llegada, gi.fecha_traslado, gi.costo_minimo, e.razon_social destinatario, gi.ruc_destinatario, m.denominiacion marca, gi.placa, gi.constancia_inscripcion, gi.licencia_conducir, e2.razon_social empresa_transporte, gi.ruc_empresa_transporte, tm.denominacion motivo_traslado, p.nombres||' '||p.apellido_paterno ||' '||p.apellido_materno conductor, gi.guia_serie, gi.guia_numero, gi.id_destinatario, 
        CASE 
        WHEN gi.id_tipo_documento=1 THEN 
        (select oc.numero_orden_compra_cliente from entrada_productos ep 
        inner join orden_compras oc on ep.id_orden_compra = oc.id
        where gi.numero_documento::int = ep.id)
        WHEN gi.id_tipo_documento=2 THEN 
        (select oc.numero_orden_compra_cliente from salida_productos sp 
        inner join orden_compras oc on sp.id_orden_compra = oc.id
        where gi.numero_documento::int = sp.id)
        end as numero_orden_compra_cliente
        from guia_internas gi
        inner join empresas e on gi.id_destinatario = e.id 
        inner join marcas m on gi.marca::int = m.id 
        inner join empresas e2 on gi.id_empresa_transporte = e2.id
        left join tabla_maestras tm on gi.id_motivo_traslado ::int = tm.codigo::int and tm.tipo = '63'
        left join conductores c on gi.id_conductor = c.id
        inner join personas p on c.id_personas = p.id
        where gi.id='".$id."'";

		$data = DB::select($cad);
        return $data;
    }

}
