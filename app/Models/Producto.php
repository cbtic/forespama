<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = [
        'numero_serie',
        'codigo',
        'denominacion',
        'id_unidad_medida',
        'stock_actual',
        'costo_unitario',
        'id_moneda',
        'id_tipo_producto',
        'fecha_vencimiento',
        'id_estado_bien',
        'stock_minimo',
        'observacion',
        'estado'
    ];

    public function entrada_producto_detalles()
    {
        return $this->belongsTo('EntradaProductoDetalle', 'id_producto');
    }

    public function listar_producto_ajax($p){

        return $this->readFuntionPostgres('sp_listar_productos_paginado',$p);

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

    function getProductoAll(){

        $cad = "select id, numero_serie, codigo, trim(denominacion) denominacion, id_unidad_medida, stock_actual, id_moneda, id_tipo_producto, fecha_vencimiento, id_estado_bien, stock_minimo, observacion, estado, created_at, updated_at, costo_unitario, contenido, id_unidad_producto, id_marca, numero_corrrelativo, id_tipo_origen_producto
        from productos p 
        where p.estado='1'
        order by p.id ";

        //limit 2620";

		$data = DB::select($cad);
        return $data;
    }

    function getProductoInterno(){

        $cad = "select * from productos p
        where p.id_tipo_origen_producto = '1'
        and p.estado='1'";

		$data = DB::select($cad);
        return $data;
    }

    function getProductoExterno(){

        $cad = "select * from productos p
        where p.id_tipo_origen_producto = '2'
        and p.estado='1'";

		$data = DB::select($cad);
        return $data;
    }

    function getProductoTipo($tipo){

        $tipo_v = " and p.id_tipo_origen_producto = '".$tipo."' ";

        if ($tipo == '') $tipo_v =" ";

        $cad = "SELECT p.id, p.codigo ||' - '|| p.denominacion producto_desc,  p.codigo, p.denominacion, p.id_unidad_medida, um.denominacion um,  p.stock_actual, 
                    p.id_moneda, m.denominacion moneda_desc, m.abreviatura moneda_abreviatura, p.costo_unitario, p.numero_corrrelativo, p.id_tipo_origen_producto 
                from productos p
                    left join tabla_maestras um on um.codigo::int=p.id_unidad_medida and um.tipo = '43'
                    left join tabla_maestras m on m.codigo::int=p.id_moneda and m.tipo = '1'
                where p.estado = '1' 
                ".$tipo_v."
                order by p.denominacion"
		;

		$data = DB::select($cad);
        return $data;
    }

    function getProductoTipoDen($tipo, $filtro, $id_empresa, $origen){

        $tipo_v = " and p.id_tipo_origen_producto = '".$tipo."' ";

        if ($tipo == '') $tipo_v =" ";

        $cad = "SELECT p.id, p.codigo ||' - '|| p.denominacion denominacion,   p.denominacion producto, p.codigo,  p.id_unidad_producto id_unidad_medida, um.denominacion um, um.abreviatura,  p.stock_actual, 
                    p.id_moneda, m.denominacion moneda_desc, m.abreviatura moneda_abreviatura, p.costo_unitario, p.numero_corrrelativo, p.id_tipo_origen_producto,
                    case when  e.id_empresa = '".$id_empresa."' then 
                    (SELECT pe.codigo_producto ||'-'|| pe.descripcion_producto||' ('|| pe.codigo_empresa||'-'|| pe. descripcion_empresa||')'  
                    FROM equivalencia_productos pe
                    where pe.id_empresa = e.id_empresa and pe.id_producto = p.id 
                    )	else p.codigo ||'-'|| p.denominacion end  denominacion
                from productos p
                    left join tabla_maestras um on um.codigo::int=p.id_unidad_producto and um.tipo = '43'
                    left join tabla_maestras m on m.codigo::int=p.id_moneda and m.tipo = '1'
                    left join equivalencia_productos e on e.id_producto = p.id
                where p.estado = '1' 
                and case when  e.id_empresa = '".$id_empresa."' then 
                    (SELECT pe.codigo_producto ||'-'|| pe.descripcion_producto||' ('|| pe.codigo_empresa||'-'|| pe. descripcion_empresa||')'  
                    FROM equivalencia_productos pe
                    where pe.id_empresa = e.id_empresa and pe.id_producto = p.id 
                    )	else p.codigo ||'-'|| p.denominacion end ilike '%".$filtro."%'
                and  p.id_tipo_origen_producto = '".$origen."'
                ".$tipo_v."
                order by p.denominacion "
        
		;
        //print_r($cad);

		$data = DB::select($cad);
        return $data;
    }

    function getProductoEquiById($id,$id_empresa, $origen){


        $cad = "SELECT p.id, p.codigo ||' - '|| p.denominacion denominacion,   p.denominacion producto, p.codigo,  p.id_unidad_producto id_unidad_medida, um.denominacion um, um.abreviatura, p.stock_actual, 
                    p.id_moneda, m.denominacion moneda_desc, m.abreviatura moneda_abreviatura, p.costo_unitario, p.numero_corrrelativo, p.id_tipo_origen_producto,
                    case when  e.id_empresa = '".$id_empresa."' then 
                    (SELECT pe.codigo_producto ||'-'|| pe.descripcion_producto||' ('|| pe.codigo_empresa||'-'|| pe. descripcion_empresa||')'  
                    FROM equivalencia_productos pe
                    where pe.id_empresa = e.id_empresa and pe.id_producto = p.id 
                    )	else p.codigo ||'-'|| p.denominacion end  denominacion                    
                from productos p
                    left join tabla_maestras um on um.codigo::int=p.id_unidad_producto and um.tipo = '43'
                    left join tabla_maestras m on m.codigo::int=p.id_moneda and m.tipo = '1'
                    left join equivalencia_productos e on e.id_producto = p.id
                where  
                p.id = '".$id."'";
		;
        //echo($cad);

		$data = DB::select($cad);
        return $data;
    }

    function getProductoById($id_producto){

        $cad = "select * from productos p 
        where p.id='".$id_producto."'";

		$data = DB::select($cad);
        return $data;
    }

    function getCorrelativo(){

        $cad = "select (max(p.numero_corrrelativo::int)+1) numero_correlativo from productos p ";

		$data = DB::select($cad);
        return $data;
    }

    function getProductoByIdAlmacen($id_almacen){

        $cad = "select distinct on (p.id) p.id, p.codigo, p.denominacion, k.saldos_cantidad, a.denominacion AS almacen
        from kardex k
        inner join almacenes a on k.id_almacen_destino = a.id and a.estado ='1'
        inner join productos p on k.id_producto = p.id and p.estado = '1'
        where k.id_almacen_destino = '".$id_almacen."'
        order by p.id desc";

		$data = DB::select($cad);
        return $data;
    }

    function getImagenProducto($id){

        $cad = "select p.id, p.denominacion producto, pi.ruta_imagen from productos p 
        inner join producto_imagenes pi on pi.id_producto = p.id
        where p.id='".$id."'";

		$data = DB::select($cad);
        return $data;
    }

    function getCodigoProducto($familia, $sub_familia){

        $cad = "select sf.inicial_codigo || lpad((coalesce(MAX(SUBSTRING(p.codigo from '.{4}$')::INT), 0) + 1)::TEXT,4, '0') as codigo
        from sub_familias sf
        left join productos p on p.id_sub_familia = sf.id and p.id_familia = '".$familia."' and p.id_sub_familia = '".$sub_familia."'
        where sf.id = '".$sub_familia."'
        group by sf.inicial_codigo";

		$data = DB::select($cad);
        return $data;
    }
}
