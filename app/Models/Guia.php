<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Guia extends Model
{
    public function registrar_guia($serie,$numero,$tipo,$serie_relacionado,$num_relacionado,$tipo_relacionado,$serie_baja,$num_baja,$tipo_baja,$emisor_numdoc,$emisor_tipodoc,$emisor_razsocial,$receptor_numdoc,$receptor_tipodoc,$receptor_razsocial,$tercero_numdoc,$tercero_tipodoc,$tercero_razsocial,$cod_motivo,$desc_motivo,$transbordo,$peso_bruto,$bultos,$modo_traslado,$fecha_traslado,$transportista_numdoc,$transportista_tipo_doc,$transportista_razsoc,$vehiculo_placa,$conductor_numdoc,$conductor_tipodoc,$llegada_ubigeo,$llegada_direccion,$partida_ubigeo,$partida_direccion,$numero_contenedor,$puerto_desembarque,$observaciones,$ruta_comprobante,$email,$estado_email,$estado_sunat,$anulado,$orden_item,$codigo,$descripcion,$cantidad,$unid_medida,$accion) {

        $cad = "Select sp_crud_guia(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        //echo "Select sp_crud_factura(".$serie.",".$numero.", ".$tipo.", ".$ubicacion.",".$persona.",".$total.",".$descripcion.",".$cod_contable.",".$codigo_v.",".$estab_v.",".$modulo.",".$smodulo.",".$descuento.",".$accion.",".$id_user.")";

		$data = DB::select($cad, array($serie,$numero,$tipo,$serie_relacionado,$num_relacionado,$tipo_relacionado,$serie_baja,$num_baja,$tipo_baja,$emisor_numdoc,$emisor_tipodoc,$emisor_razsocial,$receptor_numdoc,$receptor_tipodoc,$receptor_razsocial,$tercero_numdoc,$tercero_tipodoc,$tercero_razsocial,$cod_motivo,$desc_motivo,$transbordo,$peso_bruto,$bultos,$modo_traslado,$fecha_traslado,$transportista_numdoc,$transportista_tipo_doc,$transportista_razsoc,$vehiculo_placa,$conductor_numdoc,$conductor_tipodoc,$llegada_ubigeo,$llegada_direccion,$partida_ubigeo,$partida_direccion,$numero_contenedor,$puerto_desembarque,$observaciones,$ruta_comprobante,$email,$estado_email,$estado_sunat,$anulado,$orden_item,$codigo,$descripcion,$cantidad,$unid_medida,$accion));
        return $data[0]->sp_crud_guia;
    }

    function getGuiaId($id){

        $cad = "select c.licencia, g.*, p.nombres ||' '|| p.apellido_paterno || ' '|| p.apellido_materno razon_social_conductor, p.numero_documento
            from guias g
            inner join vehiculos v on v.placa = g.guia_vehiculo_placa 
            inner join vehiculos_conductores vc on vc.id_vehiculos = v.id
            inner join conductores c on c.id = vc.id_conductores
            inner join personas p on p.id = c.id_personas 
            where g.id = '".$id."' ";
    
        $data = DB::select($cad);
        if($data)return $data[0];
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
   
   
}
