<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Requerimiento extends Model
{
    use HasFactory;

    public function listar_requerimiento_ajax($p){

        return $this->readFuntionPostgres('sp_listar_requerimiento_paginado',$p);

    }

    public function listar_reporte_requerimiento_ajax($p){

        return $this->readFuntionPostgres('sp_listar_reporte_requerimiento_paginado',$p);

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

    function getCodigoRequerimiento($tipo_documento){

        $cad = "select lpad(coalesce(max(r.codigo::int) + 1, 1)::varchar, 6, '0') codigo
        from requerimientos r
        where id_tipo_documento = '".$tipo_documento."'";

		$data = DB::select($cad);
        return $data;
    }

    function getDetalleRequerimientoId($id){

        $cad = "select rd.id,  ROW_NUMBER() OVER (PARTITION BY rd.id_requerimiento ) AS row_num, p.numero_serie item, rd.id_producto, p.codigo, p.denominacion nombre_producto, rd.id_marca, rd.id_unidad_medida, 
        rd.id_estado_producto , rd.cantidad, r.id_almacen_destino,
        (select coalesce(sum(ocd.cantidad_requerida),0) from orden_compras oc
        inner join orden_compra_detalles ocd on ocd.id_orden_compra = oc.id 
        where oc.id_requerimiento = r.id and ocd.id_producto = rd.id_producto) cantidad_atendida, coalesce(rd.observacion,'') observacion, coalesce(rd.observacion_atencion,'') observacion_atencion
        from requerimiento_detalles rd 
        inner join productos p on rd.id_producto = p.id
        inner join requerimientos r on rd.id_requerimiento = r.id
        where id_requerimiento ='".$id."'
        and rd.estado='1'
        order by 1 asc ";

		$data = DB::select($cad);
        return $data;
    }

    function getRequerimientoById($id){

        $cad = "select r.id, tm.denominacion tipo_documento, a.denominacion almacen, r.fecha, r.codigo, u.name responsable_atencion, tm2.denominacion estado_atencion, r.sustento_requerimiento
        from requerimientos r
        inner join tabla_maestras tm on r.id_tipo_documento ::int = tm.codigo::int and tm.tipo = '59'
        inner join almacenes a on r.id_almacen_destino = a.id
        left join users u on r.responsable_atencion = u.id
        left join tabla_maestras tm2 on r.estado_atencion ::int = tm2.codigo::int and tm2.tipo = '60'
        where r.id ='".$id."'";

		$data = DB::select($cad);
        return $data;
    }

    function getControlRequerimientoById($id){

        $cad = "select r.id, tm.denominacion tipo_documento, r.codigo, r.fecha, tm2.denominacion unidad_origen, a.denominacion almacen, u.name reponsable_atencion, tm5.denominacion tipo_requerimiento, tm3.denominacion estado_atencion, tm4.denominacion cerrado, r.sustento_requerimiento  from requerimientos r 
        inner join tabla_maestras tm on r.id_tipo_documento = tm.codigo::int and tm.tipo ='59'
        inner join almacenes a on r.id_almacen_destino = a.id
        inner join tabla_maestras tm2 on r.id_unidad_origen = tm2.codigo::int and tm2.tipo ='50'
        inner join tabla_maestras tm3 on r.estado_atencion::int  = tm3.codigo::int and tm3.tipo ='60'
        inner join users u on r.responsable_atencion = u.id
        inner join tabla_maestras tm4 on r.cerrado::int = tm4.codigo::int and tm4.tipo ='52'
        inner join tabla_maestras tm5 on r.id_tipo_requerimiento = tm5.codigo::int and tm5.tipo ='67'
        where r.id='".$id."'
        and r.estado ='1' ";

		$data = DB::select($cad);
        return $data;
    }

    function getControlDetalleRequerimientoId($id){

        $cad = "select rd.id,  ROW_NUMBER() OVER (PARTITION BY rd.id_requerimiento ) AS row_num, coalesce(p.numero_serie,'') item, rd.id_producto, p.codigo, p.denominacion nombre_producto, coalesce(m.denominiacion,'') marca, coalesce(tm.denominacion,'') estado_producto, coalesce(tm2.denominacion ,'') unidad_medida, rd.cantidad, r.id_almacen_destino,
        (select coalesce(sum(ocd.cantidad_requerida),0) from orden_compras oc
        inner join orden_compra_detalles ocd on ocd.id_orden_compra = oc.id 
        where oc.id_requerimiento = r.id and ocd.id_producto = rd.id_producto and oc.estado ='1') cantidad_atendida,
        (select COALESCE(STRING_AGG(DISTINCT oc.numero_orden_compra ::TEXT, ', '), '') from orden_compras oc 
        inner join orden_compra_detalles ocd on oc.id = ocd.id_orden_compra  
        where rd.id_producto = ocd.id_producto and oc.id_requerimiento = r.id and oc.estado ='1') orden_compra
        from requerimiento_detalles rd 
        inner join productos p on rd.id_producto = p.id
        inner join requerimientos r on rd.id_requerimiento = r.id
        left join marcas m on rd.id_marca = m.id 
        left join tabla_maestras tm on rd.id_estado_producto = tm.codigo::int and tm.tipo ='56'
        left join tabla_maestras tm2 on rd.id_unidad_medida = tm2.codigo::int and tm2.tipo ='43'
        where id_requerimiento ='".$id."'
        and rd.estado='1'
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }

    function getDetalleRequerimientoIdAbierto($id){

        $cad = "select rd.id,  ROW_NUMBER() OVER (PARTITION BY rd.id_requerimiento ) AS row_num, p.numero_serie item, rd.id_producto, p.codigo, p.denominacion nombre_producto, rd.id_marca, rd.id_unidad_medida, 
        rd.id_estado_producto , rd.cantidad, r.id_almacen_destino,
        (select coalesce(sum(ocd.cantidad_requerida),0) from orden_compras oc
        inner join orden_compra_detalles ocd on ocd.id_orden_compra = oc.id 
        where oc.id_requerimiento = r.id and ocd.id_producto = rd.id_producto and oc.estado ='1') cantidad_atendida, rd.id_usuario_inserta
        from requerimiento_detalles rd 
        inner join productos p on rd.id_producto = p.id
        inner join requerimientos r on rd.id_requerimiento = r.id
        where id_requerimiento ='".$id."'
        and rd.estado='1'
        and rd.cerrado='1'
        order by 1 asc ";

		$data = DB::select($cad);
        return $data;
    }

    function inhabilitarModificacionRequerimiento(){
        $p=array();
		return $this->readFunctionPostgresTransaction('sp_crud_requerimiento_inhabilitar_editar',$p);
    }

    public function readFunctionPostgresTransaction($function, $parameters = null){
	
      $_parameters = '';
      if (count($parameters) > 0) {
	  		
			foreach($parameters as $par){
				if(is_string($par))$_parameters .= "'" . $par . "',";
				else $_parameters .= "" . $par . ",";
		  	}
			if(strlen($_parameters)>1)$_parameters= substr($_parameters,0,-1);
			
      }

	  $cad = "select " . $function . "(" . $_parameters . ");";
	  $data = DB::select($cad);
	  return $data[0]->$function;
   }

}
