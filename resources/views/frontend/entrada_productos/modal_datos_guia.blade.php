<title>FORESPAMA</title>

<style>
/*
.datepicker {
  z-index: 1600 !important; 
}
*/
/*.datepicker{ z-index:99999 !important; }*/

.datepicker,
.table-condensed {
  width: 250px;
  height:250px;
}

.modal-dialog {
    width: 100%;
    max-width:100%!important
}

.modal-tienda .modal-dialog {
    width: 65% !important;
}

.modal-tienda .modal-body {
    height: auto !important;
}

.custom-select2-dropdown {
    width: 700px !important; 
}

#tablemodal{
    border-spacing: 0;
    display: flex;/*Se ajuste dinamicamente al tamano del dispositivo**/
    max-height: 80vh; /*El alto que necesitemos**/
    overflow-y: auto; /**El scroll verticalmente cuando sea necesario*/
    overflow-x: hidden;/*Sin scroll horizontal*/
    table-layout: fixed;/**Forzamos a que las filas tenga el mismo ancho**/
    width: 98vw; /*El ancho que necesitemos*/
    border:1px solid #c4c0c9;
}

#tablemodal thead{
    background-color: #e2e3e5;
    position: fixed !important;
}


#tablemodal th{
    border-bottom: 1px solid #c4c0c9;
    border-right: 1px solid #c4c0c9;
}

#tablemodal th{
    font-weight: normal;
    margin: 0;
    max-width: 9.5vw; 
    min-width: 9.5vw;
    word-wrap: break-word;
    font-size: 10px;
	font-weight:bold;
    height: 3.5vh !important;
	line-height:12px;
	vertical-align:middle;
	/*height:20px;*/
    padding: 4px;
    border-right: 1px solid #c4c0c9;
}

#tablemodal td{
    font-weight: normal;
    margin: 0;
    max-width: 9.5vw; 
    min-width: 9.5vw;
    word-wrap: break-word;
    font-size: 11px;
    height: 3.5vh !important;
    padding: 4px;
    border-right: 1px solid #c4c0c9;
}

#tablemodal tbody tr:hover td, #tablemodal tbody tr:hover th {
  /*background-color: red!important;*/
  font-weight:bold;
  /*mix-blend-mode: difference;*/
  
}

#tablemodalm{
	
}
</style>

<!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>-->
<!--<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>-->
<!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>-->


<!--<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>-->


<!--Se quito estas dos lineas de datepicker y se puso las 3 de abajo -->
<!--<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />-->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/locales/bootstrap-datepicker.es.min.js" charset="UTF-8"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker3.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>


<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>-->

<!--
<script src="resources/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<link rel="stylesheet" href="resources/plugins/timepicker/bootstrap-timepicker.min.css">
-->

<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.css">
-->

<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/js/bootstrap-datetimepicker.min.js" integrity="sha512-r/mHP22LKVhxWFlvCpzqMUT4dWScZc6WRhBMVUQh+SdofvvM1BS1Hdcy94XVOod7QqQMRjLQn5w/AQOfXTPvVA==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/css/bootstrap-datetimepicker.css" integrity="sha512-HWqapTcU+yOMgBe4kFnMcJGbvFPbgk39bm0ExFn0ks6/n97BBHzhDuzVkvMVVHTJSK5mtrXGX4oVwoQsNcsYvg==" crossorigin="anonymous" />
-->

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>-->
<script type="text/javascript">
/*
jQuery(function($){
$.mask.definitions['H'] = "[0-1]";
$.mask.definitions['h'] = "[0-9]";
$.mask.definitions['M'] = "[0-5]";
$.mask.definitions['m'] = "[0-9]";
$.mask.definitions['P'] = "[AaPp]";
$.mask.definitions['p'] = "[Mm]";
});
*/
$(document).ready(function() {

    $('#fecha_emision').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    $('#fecha_inicio_traslado').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    $("#destinatario").select2({ width: '100%' });

    $("#transporte_razon_social").select2({ width: '100%' });

});

</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
     $('#fecha_solicitud').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
     });
});

$(document).ready(function() {
    
    

});

function limpiar(){
	$('#id').val("0");
	$('#id_tipo_documento').val("");
	$('#denominacion').val("");
	$('#img_foto').val("");
}

function fn_save_datos_guia(){
	
    var msg = "";

    var fecha_emision = $('#fecha_emision').val();
    var punto_partida = $('#punto_partida').val();
    var punto_llegada = $('#punto_llegada').val();
    var fecha_inicio_traslado = $('#fecha_inicio_traslado').val();
    var costo_minimo = $('#costo_minimo').val();
    var destinatario = $('#destinatario').val();
    var ruc = $('#ruc').val();
    var marca_placa = $('#marca_placa').val();
    var numero_inscripcion = $('#numero_inscripcion').val();
    var numero_licencia = $('#numero_licencia').val();
    var transporte_razon_social = $('#transporte_razon_social').val();
    var ruc_transporte = $('#ruc_transporte').val();

    if(fecha_emision==""){msg+="Ingrese la Fecha de Emision <br>";}
    if(punto_partida==""){msg+="Ingrese el Punto de Partida <br>";}
    if(punto_llegada==""){msg+="Ingrese el Punto de Llegada <br>";}
    if(fecha_inicio_traslado==""){msg+="Ingrese la Fecha de Inicio de Traslado <br>";}
    if(costo_minimo==""){msg+="Ingrese el Costo Minimo <br>";}
    if(destinatario==""){msg+="Ingrese el Destinatario <br>";}
    if(ruc==""){msg+="Ingrese el RUC <br>";}
    if(marca_placa==""){msg+="Ingrese la Marca y Placa <br>";}
    if(numero_inscripcion==""){msg+="Ingrese el Numero de Inscripcion <br>";}
    if(numero_licencia==""){msg+="Ingrese el Numero de Licencia <br>";}
    if(transporte_razon_social==""){msg+="Ingrese la Razon Social del Transporte <br>";}
    if(ruc_transporte==""){msg+="Ingrese el RUC del Transporte <br>";}

    if(msg!=""){
        bootbox.alert(msg);
        return false;
    }else{
        var msgLoader = "";
        msgLoader = "Procesando, espere un momento por favor";
        var heightBrowser = $(window).width()/2;
        $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
        $('.loader').show();

        $.ajax({
            url: "/entrada_productos/send_datos_guia",
            type: "POST",
            data : $("#frmGuia").serialize(),
            success: function (result) {
                datatablenew();
                $('.loader').hide();
                bootbox.alert("Se guard&oacute; satisfactoriamente"); 
                $('#openOverlayOpc2').modal('hide');
            }
        });
    }
}

function obtener_ruc(){

    destinatario = $('#destinatario').val();

    $.ajax({
        url: "/empresa/obtener_empresa_id/"+destinatario,
        dataType: "json",
        success: function (result) {

            $('#ruc').val(result.empresa[0].ruc);

        }
    });
}

function obtener_ruc_transporte(){

    transporte_razon_social = $('#transporte_razon_social').val();

    $.ajax({
        url: "/empresa/obtener_empresa_id/"+transporte_razon_social,
        dataType: "json",
        success: function (result) {

            $('#ruc_transporte').val(result.empresa[0].ruc);

        }
    });
}

</script>

<body class="hold-transition skin-blue sidebar-mini">
    
    <div>
		<!--
        <section class="content-header">
          <h1>
            <small style="font-size: 20px">Programados del Medicos del dia <?php //echo $fecha_atencion?></small>
          </h1>
        </section>
		-->
		<div class="justify-content-center">

            <div class="card">
                <!--<div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <img width="200px" height="80px" style="top:-30px" src="/img/logo_forestalpama.jpg">
                    </div>
                </div>-->
                <div style="text-align: center; font-size:16px; margin-top: 20px">
                    <b>Datos Guia</b>
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmGuia" name="frmGuia">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                    
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                    
                    <div class="row" style="padding-left:10px; padding-bottom:10px;">

                        <div class="col-lg-2">
                            Fecha de Emisi&oacute;n
                        </div>
                        <div class="col-lg-2">
                            <input id="fecha_emision" name="fecha_emision" on class="form-control form-control-sm"  value="<?php echo isset($entrada_producto) && $entrada_producto->fecha ? $requerimiento->fecha : date('Y-m-d'); ?>" type="text">
                        </div>
                    </div>
                    <div class="row" style="padding-left:10px; padding-bottom:10px;">
                        <div class="col-lg-2">
                            Punto de Partida
                        </div>
                        <div class="col-lg-4">
                            <input id="punto_partida" name="punto_partida" on class="form-control form-control-sm"  value="<?php //if($id>0){echo $requerimiento->codigo;}?>" type="text">
                        </div>
                        <div class="col-lg-2">
                            Punto de Llegada
                        </div>
                        <div class="col-lg-4">
                            <input id="punto_llegada" name="punto_llegada" on class="form-control form-control-sm"  value="<?php //echo isset($requerimiento) && $requerimiento->fecha ? $requerimiento->fecha : date('Y-m-d'); ?>" type="text">
                        </div>
                    </div>
                    <div class="row" style="padding-left:10px; padding-bottom:10px;">
                        <div class="col-lg-2">
                            Fecha de Inicio Traslado
                        </div>
                        <div class="col-lg-2">
                            <input id="fecha_inicio_traslado" name="fecha_inicio_traslado" on class="form-control form-control-sm"  value="<?php //echo isset($entrada_producto) && $entrada_producto->fecha ? $requerimiento->fecha : date('Y-m-d'); ?>" type="text">
                        </div>
                        <div class="col-lg-2">
                            Costo M&iacute;nimo
                        </div>
                        <div class="col-lg-2">
                            <input id="costo_minimo" name="costo_minimo" on class="form-control form-control-sm"  value="<?php //echo isset($requerimiento) && $requerimiento->fecha ? $requerimiento->fecha : date('Y-m-d'); ?>" type="text">
                        </div>
                    </div>
                    <div class="row" style="padding-left:10px; padding-bottom:10px;">
                        <div class="col-lg-2">
                            Destinatario
                        </div>
                        <div class="col-lg-4" id="almacen_salida_select">
                            <select name="destinatario" id="destinatario" class="form-control form-control-sm" onchange="obtener_ruc()">
                                <option value="">--Seleccionar--</option>
                                <?php 
                                foreach ($empresas as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php //if($row->id==$requerimiento->id_almacen_destino)echo "selected='selected'"?>><?php echo $row->razon_social ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            RUC
                        </div>
                        <div class="col-lg-2">
                            <input id="ruc" name="ruc" on class="form-control form-control-sm"  value="<?php //echo isset($requerimiento) && $requerimiento->fecha ? $requerimiento->fecha : date('Y-m-d'); ?>" type="text">
                        </div>
                    </div>
                    <div class="row" style="padding-left:10px; padding-bottom:10px;">
                        <div class="col-lg-2">
                            Marca y N° de Placa
                        </div>
                        <div class="col-lg-2">
                            <input id="marca_placa" name="marca_placa" on class="form-control form-control-sm"  value="<?php //echo isset($requerimiento) && $requerimiento->fecha ? $requerimiento->fecha : date('Y-m-d'); ?>" type="text">
                        </div>
                        <div class="col-lg-2">
                            N° Constancia Inscripci&oacute;n
                        </div>
                        <div class="col-lg-2">
                            <input id="numero_inscripcion" name="numero_inscripcion" on class="form-control form-control-sm"  value="<?php //echo isset($requerimiento) && $requerimiento->fecha ? $requerimiento->fecha : date('Y-m-d'); ?>" type="text">
                        </div>
                        <div class="col-lg-2">
                            N° de Licencia de Conducir
                        </div>
                        <div class="col-lg-2">
                            <input id="numero_licencia" name="numero_licencia" on class="form-control form-control-sm"  value="<?php //echo isset($requerimiento) && $requerimiento->fecha ? $requerimiento->fecha : date('Y-m-d'); ?>" type="text">
                        </div>
                    </div>
                    <div class="row" style="padding-left:10px; padding-bottom:10px;">
                        <div class="col-lg-2" id="almacen_salida_">
                            Raz&oacute;n Social Transporte
                        </div>
                        <div class="col-lg-4" id="almacen_salida_select">
                            <select name="transporte_razon_social" id="transporte_razon_social" class="form-control form-control-sm" onchange="obtener_ruc_transporte(this)">
                                <option value="">--Seleccionar--</option>
                                <?php 
                                foreach ($transporte_razon_social as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php //if($row->id==$requerimiento->responsable_atencion)echo "selected='selected'"?>><?php echo $row->razon_social ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            RUC Transporte
                        </div>
                        <div class="col-lg-2">
                            <input id="ruc_transporte" name="ruc_transporte" on class="form-control form-control-sm"  value="<?php //echo isset($requerimiento) && $requerimiento->fecha ? $requerimiento->fecha : date('Y-m-d'); ?>" type="text">
                        </div>
                    </div>
                    <div style="margin-top:15px" class="form-group">
                        <div class="col-sm-12 controls">
                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                <a href="javascript:void(0)" onClick="fn_save_datos_guia()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>
                                <a href="javascript:void(0)" onClick="$('#openOverlayOpc2').modal('hide');" class="btn btn-sm btn-info" style="">Cerrar</a>
                            </div>
                                                
                        </div>
                    </div> 

				</div>
                            
                    </div>
                </form>
                </div>
                <!-- /.box -->
                
            </div>
            <!--/.col (left) -->

        </div>
        <!-- /.row -->
    
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div id="openOverlayOpc2" class="modal fade modal-tienda" tabindex="-1" role="dialog">
	  <div class="modal-dialog" >
	
		<div id="id_content_OverlayoneOpc2" class="modal-content" style="padding: 0px;margin: 0px">
		
		  <div class="modal-body" style="padding: 0px;margin: 0px">
	
				<div id="diveditpregOpc2"></div>
	
		  </div>
		
		</div>
	
	  </div>
		
	</div>

    
<script type="text/javascript">
$(document).ready(function () {

	$('#ruc_').blur(function () {
		var id = $('#id').val();
			if(id==0) {
				validaRuc(this.value);
			}
		//validaRuc(this.value);
	});
	
	
	
	
});


</script>

<script type="text/javascript">
$(document).ready(function() {
	//$('#numero_placa').focus();
	//$('#numero_placa').mask('AAA-000');
	//$('#vehiculo_numero_placa').mask('AAA-000');
	
	
});




</script>

