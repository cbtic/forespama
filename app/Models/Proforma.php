<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Proforma extends Model
{
    public function registrar_proforma1($p){
		return $this->readFunctionPostgres('sp_crud_proforma',$p);
    }

    public function registrar_proforma($p, $pd) {
        $cad = "Select sp_crud_proforma(?,?)";
		//echo "Select sp_crud_proforma('".$p."', '".$pd."')";
        //exit();
		$data = DB::select($cad, array($p, $pd));
        return $data[0]->sp_crud_proforma;
    }

    function getProformaDetalle($id){

        $cad = "SELECT p.id, p.serie, p.numero, p.fecha, p.id_moneda, p.moneda, p.sub_total sub_total_, p.igv igv_, p.total total_, p.fecha_vencimiento,
            pd.id_producto,  pr.codigo, pr.denominacion,
            case when  p.id_empresa = 23 then 
            (SELECT pe.codigo_producto ||'-'|| pe.descripcion_producto||'('|| pe.codigo_empresa||'-'|| pe. descripcion_empresa||')'  
            FROM equivalencia_productos pe
            where pe.id_empresa = p.id_empresa and pe.id_producto = pd.id_producto and pe.estado= '1'
            )	else pr.codigo ||'-'|| pr.denominacion end  producto_prof,
            um.denominacion um, pd.cantidad, pd.id_descuento,
            pd.precio_unitario, pd.sub_total, pd.igv, pd.total, pd.id_unidad_medida, pd.descuento, pd.valor_venta_bruto, pd.precio_venta, pd.valor_venta 
        FROM proformas p
        inner join proforma_detalles pd on pd.id_proforma = p.id 
        inner join productos pr on pr.id = pd.id_producto
        inner join tabla_maestras um on um.codigo::int = pd.id_unidad_medida and um.tipo = '57'
        where p.id = ".$id." and 
        pd.estado = '1'
        order by pd.id";
    
    //echo $cad;
    $data = DB::select($cad);
    return $data;
}



    public function readFunctionPostgres($function, $parameters = null){

        $_parameters = '';
        if (count($parameters) > 0) {
            $_parameters = implode("','", $parameters);
            $_parameters = "'" . $_parameters . "',";
        }
        DB::select("BEGIN;");
        $cad = "select " . $function . "(" . $_parameters . "'ref_cursor');";
        DB::select($cad);
        $cad = "FETCH ALL IN ref_cursor;";
        $data = DB::select($cad);
        DB::select("END;");
        return $data;
     }



    function getProformaById($id){

        $cad =  "select id, numero, id_empresa, id_persona, fecha, id_moneda, moneda, sub_total, igv, total, 
                        estado, cerrado, serie, fecha_vencimiento, descuento			
                from proformas p                   
                Where  p.id = ".$id."                     
                limit 1";

        
        //echo $cad; exit();
        $data = DB::select($cad);
        
        if (!empty($data)) {
            return $data[0];
        } else {
            
            return null;
        }

    }

}
