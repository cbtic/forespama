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

.modal-dialog3 {
    width: 100%;
    max-width:50%!important
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

    if($('#id_datos_pedido').val()>0){
        obtenerProvinciaContacto();
		obtenerDatosUbigeoContacto();
	}

    $("#item").select2({ width: '100%' });
    $("#ubicacion_fisica_seccion").select2({ width: '100%' });
    $("#ubicacion_fisica_anaquel").select2({ width: '100%' });
    $("#empresa_vende").select2({ width: '100%' });
    $("#empresa_compra").select2({ width: '100%' });
    

});

</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
     $('#fecha_solicitud').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		//container: '#openOverlayOpc modal-body'
		container: '#openOverlayOpc modal-body'
     });
	 
});

$(document).ready(function() {

});


function obtenerProvinciaContacto(){
	
	var id = $('#departamento_contacto').val();
	if(id=="")return false;
	$('#provincia_contacto').attr("disabled",true);
	$('#distrito_contacto').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/almacenes/obtener_provincia/'+id,
		dataType: "json",
		success: function(result){
			var option = "<option value='' selected='selected'>--Seleccionar--</option>";
			$('#provincia_contacto').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_provincia+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#provincia_contacto').html(option);
			
			var option2 = "<option value=''>--Seleccionar--</option>";
			$('#distrito_contacto').html(option2);
			
			$('#provincia_contacto').attr("disabled",false);
			$('#distrito_contacto').attr("disabled",false);
			
			$('.loader').hide();
		}
	});
}

function obtenerDistritoContacto(){
	
	var id_departamento = $('#departamento_contacto').val();
	var id = $('#provincia_contacto').val();
	if(id=="")return false;
	$('#distrito_contacto').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/almacenes/obtener_distrito/'+id_departamento+'/'+id,
		dataType: "json",
		success: function(result){
			var option = "<option value=''>Seleccionar</option>";
			$('#distrito_contacto').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#distrito_contacto').html(option);
			
			$('#distrito_contacto').attr("disabled",false);
			$('.loader').hide();
		}
	});
}

function fn_save_datos_pedido(){
	
    var msg = "";

    var nombre_contacto = $('#nombre_contacto').val();
    var telefono_contacto = $('#telefono_contacto').val();
    var direccion_contacto = $('#direccion_contacto').val();

    if(nombre_contacto==""){msg+="Ingrese el Nombre <br>";}
    if(telefono_contacto==""){msg+="Ingrese el Telefono <br>";}
    if(direccion_contacto==""){msg+="Ingrese la Direccion <br>";}

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
            url: "/orden_compra/send_datos_contacto",
            type: "POST",
            data : $("#frmOrdenCompraContacto").serialize(),
            success: function (result) {
                //alert(result.id)
                $('#openOverlayOpc3').modal('hide');
                datatablenew();
                $('.loader').hide();
                bootbox.alert("Se guard&oacute; satisfactoriamente"); 
                /*if (result.id>0) {
                    modalOrdenCompra(result.id);
                }*/
                
            }
        });
    }
}

function obtenerDatosUbigeoContacto(){

    var id = $('#id_datos_pedido').val();

    $.ajax({
        url: '/orden_compra/obtener_provincia_distrito/'+id,
        dataType: "json",
        success: function(result){
            
            //alert(result[0].provincia_partida);

            $('#provincia_contacto').val(result[0].provincia_partida);

            obtenerDistritoContacto_(function(){

                $('#distrito_contacto').val(result[0].distrito_partida);

            });
        }
    });
}

function obtenerDistritoContacto_(callback){

    var departamento = $('#departamento_contacto').val();
    var id = $('#provincia_contacto').val();
    if(id=="")return false;
    $('#distrito_contacto').attr("disabled",true);

    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

    $.ajax({
        url: '/almacenes/obtener_distrito/'+departamento+'/'+id,
        dataType: "json",
        success: function(result){
            var option = "<option value=''>Seleccionar</option>";
            $('#distrito_contacto').html("");
            $(result).each(function (ii, oo) {
                option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
            });
            $('#distrito_contacto').html(option);
            
            $('#distrito_contacto').attr("disabled",false);
            $('.loader').hide();

            callback();
        
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
                    <b>Datos de Contacto Entrega de Orden Compra</b>
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmOrdenCompraContacto" name="frmOrdenCompraContacto">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                    
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                    <input type="hidden" name="id_datos_pedido" id="id_datos_pedido" value="<?php echo $orden_compra_contacto_entrega->id?>">

                    <div class="row" style="padding-left:10px; padding-top: 15px;">
                        <div class="col-lg-2">
                                Nombres
                        </div>
                        <div class="col-lg-2">
                            <input id="nombre_contacto" name="nombre_contacto" on class="form-control form-control-sm"  value="<?php if($orden_compra_contacto_entrega){echo $orden_compra_contacto_entrega->nombre;}?>" type="text">
                        </div>
                        
                        <div class="col-lg-2">
                            Tel&eacute;fono
                        </div>
                        <div class="col-lg-2">
                            <input id="telefono_contacto" name="telefono_contacto" on class="form-control form-control-sm"  value="<?php if($orden_compra_contacto_entrega){echo $orden_compra_contacto_entrega->telefono;}?>" type="text">
                        </div>
                    </div>
                    <div class="row" style="padding-top: 15px;">
                        <div class="col-lg-12">
                            <fieldset name="punto_partida_name" style="border:1px solid #A4A4A4; padding: 10px">
                                <legend class="control-label form-control-sm">Punto de Partida</legend>
                                <div class="row" style="padding-left:10px; padding-bottom:10px;">
                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                Departamento
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <select name="departamento_contacto" id="departamento_contacto" onChange="obtenerProvinciaContacto()" class="form-control form-control-sm">
                                                        <?php if($id>0){ ?> 
                                                        <option value="">--Seleccionar--</option>
                                                        <?php
                                                        foreach ($departamento as $row) {?>
                                                        <option value="<?php echo $row->id_departamento?>" <?php if($row->id_departamento==substr($orden_compra_contacto_entrega->id_ubigeo,0,2))echo "selected='selected'"?>><?php echo $row->desc_ubigeo ?></option>
                                                        <?php 
                                                        }
                                                        }else{?>
                                                        <option value="">--Seleccionar--</option>
                                                            <?php
                                                            foreach ($departamento as $row) {
                                                            ?>
                                                            <option value="<?php echo $row->id_departamento?>"><?php echo $row->desc_ubigeo ?></option>
                                                            <?php 
                                                                
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                Provincia
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <select name="provincia_contacto" id="provincia_contacto" class="form-control form-control-sm" onchange="obtenerDistritoContacto()">
                                                        <option value="">--Seleccionar--</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                Distrito
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <select name="distrito_contacto" id="distrito_contacto" class="form-control form-control-sm" onchange="">
                                                        <option value="">--Seleccionar--</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12"  style="padding-top: 15px;">
                                        <div class="row">
                                            <div class="col-lg-1">
                                                Direci&oacute;n
                                            </div>
                                            <div class="col-lg-11">
                                                <input id="direccion_contacto" name="direccion_contacto" on class="form-control form-control-sm"  value="<?php if($orden_compra_contacto_entrega){echo $orden_compra_contacto_entrega->direccion;}?>" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div style="margin-top:15px" class="form-group">
                        <div class="col-sm-12 controls">
                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                               
                                <a href="javascript:void(0)" onClick="fn_save_datos_pedido()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>
                                <a href="javascript:void(0)" onClick="$('#openOverlayOpc3').modal('hide');" class="btn btn-sm btn-info" style="margin-left:10px">Cerrar</a>
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

