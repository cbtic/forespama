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
	max-width:75%!important
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

.scrolls {
	height: 100px;
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
	 /*
	 $('#hora_solicitud').timepicker({
		showInputs: false,
		container: '#openOverlayOpc modal-body'
	});
	*/
	 
});

$(document).ready(function() {

    $('#placa').mask('AAA-000');

    $('#fecha_vencimiento_soat').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    $('#fecha_vencimiento_revision_tecnica').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    $('#vigencia_circulacion').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    if($('#id').val()>0){
        obtenerProvincia(function() {
            obtenerDatosUbigeo();
        });
	}

    $('#marca').select2({ width : '100%' })

});

$(document).ready(function() {
	 
    $(".upload").on('click', function() {
        var formData = new FormData();
        var files = $('#image')[0].files[0];
        formData.append('file',files);
        $.ajax({
			headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/activos/upload_activo",
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response != 0) {
                    $("#img_ruta").attr("src", "/img/tmp_activos/"+response);
					$("#img_foto").val(response);
                } else {
                    alert('Formato de imagen incorrecto.');
                }
            }
        });
        return false;
    });
});

$(function() {
    $('.mayusculas').keyup(function() {
        this.value = this.value.toUpperCase();
    });
});

function limpiar(){
	$('#id').val("0");
	$('#id_tipo_documento').val("");
	$('#denominacion').val("");
	$('#img_foto').val("");
}

function fn_save_activos(){

    var msg = "";

    var departamento = $('#departamento').val();
    var provincia = $('#provincia').val();
    var distrito = $('#distrito').val();
    var direccion = $('#direccion').val();
    var tipo_activo = $('#tipo_activo').val();
    var descripcion = $('#descripcion').val();
    var tipo_combustible = $('#tipo_combustible').val();
    var estado_activo = $('#estado_activo').val();
    var valor_libros = $('#valor_libros').val();
    var valor_comercial = $('#valor_comercial').val();

    if(departamento==""){msg+="Ingrese el Departamento <br>";}
    if(provincia==""){msg+="Ingrese ls Provincia <br>";}
    if(distrito==""){msg+="Ingrese el Distrito <br>";}
    if(direccion==""){msg+="Ingrese la Direccion <br>";}
    if(tipo_activo==""){msg+="Ingrese el Tipo de Activo <br>";}
    if(descripcion==""){msg+="Ingrese la Descripcion <br>";}
    if(tipo_combustible==""){msg+="Ingrese el Tipo de Combustible <br>";}
    if(estado_activo==""){msg+="Ingrese el Estado del Activo <br>";}
    if(valor_libros==""){msg+="Ingrese el Valor en Libros <br>";}
    if(valor_comercial==""){msg+="Ingrese el Valor Comercial <br>";}
	
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
            url: "/activos/send_activo",
            type: "POST",
            data : $("#frmActivos").serialize(),
            success: function (result) {
                
                if (result.success) {
                    $('.loader').hide();
                    bootbox.alert(result.success, function() {
                        
                        $('#openOverlayOpc').modal('hide');
                        datatablenew();
                    });
                } else if (result.error) {
                    bootbox.alert(result.error);
                }
            },
        });
    }
}

function obtenerDistrito(){
	
	var id_departamento = $('#departamento').val();
	var id = $('#provincia').val();
	if(id=="")return false;
	$('#distrito').attr("disabled",true);
	
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
			$('#distrito').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#distrito').html(option);
			
			$('#distrito').attr("disabled",false);
			$('.loader').hide();
		}
	});
}

function obtenerProvincia(callback){
	
	var id = $('#departamento').val();
	if(id=="")return false;
	$('#provincia').attr("disabled",true);
	$('#distrito').attr("disabled",true);
	
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
			$('#provincia').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_provincia+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#provincia').html(option);
			
			var option2 = "<option value=''>--Seleccionar--</option>";
			$('#distrito').html(option2);
			
			$('#provincia').attr("disabled",false);
			$('#distrito').attr("disabled",false);
			
			$('.loader').hide();
            if (callback) callback();
		}
	});
}

function obtenerDatosUbigeo(){

    var id = $('#id').val();

    $.ajax({
        url: '/activos/obtener_provincia_distrito/'+id,
        dataType: "json",
        success: function(result){
            
            //alert(result[0].provincia_partida);

            $('#provincia').val(result[0].provincia_partida);

            obtenerDistrito_(function(){

                $('#distrito').val(result[0].distrito_partida);

            });
        }
    });
}

function obtenerDistrito_(callback){

    var departamento = $('#departamento').val();
    var id = $('#provincia').val();
    if(id=="")return false;
    $('#distrito').attr("disabled",true);

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
            $('#distrito').html("");
            $(result).each(function (ii, oo) {
                option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
            });
            $('#distrito').html(option);
            
            $('#distrito').attr("disabled",false);
            $('.loader').hide();

            callback();
        
        }
    });
}

$(function() {
    $('.solo-decimal').on('input', function () {
        this.value = this.value.replace(/[^0-9.]/g, '');

        if ((this.value.match(/\./g) || []).length > 1) {
            this.value = this.value.substr(0, this.value.lastIndexOf('.'));
        }

        if (this.value.startsWith('.')) {
            this.value = '';
        }
    });
});

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
                
                
                <div class="" style="padding-top:20px!important;padding-left:20px!important;padding-right:20px; text-align: center">
                    <b style="font-size : 15px">Registrar Activos</b>
                    <img src="/img/logo_forestalpama.jpg" align="right" style="width: 120px; height: 50px">
                </div>

                <div class="card-body">
                <form method="post" action="#" id="frmActivos" name="frmActivos">

                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                                
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                            
                            <fieldset name="datos_activo" style="border:1px solid #A4A4A4; padding: 10px;">
                            <legend class="control-label form-control-sm"><b>Datos del Activo</b></legend>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Tipo Activo</label>
                                                <select name="tipo_activo" id="tipo_activo" class="form-control form-control-sm">
                                                    <option value="">--Seleccionar--</option>
                                                    <?php 
                                                    foreach ($tipo_activo as $row){?>
                                                        <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$activo->id_tipo_activo)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                                        <?php 
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">C&oacute;digo</label>
                                                <input id="codigo" name="codigo" on class="form-control form-control-sm mayusculas"  value="<?php //echo $activo->codigo?>" type="text">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Descripci&oacute;n</label>
                                                <input id="descripcion" name="descripcion" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->descripcion?>" type="text">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Placa</label>
                                                <input id="placa" name="placa" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->placa?>" type="text" placeholder="ABC-123">
                                            </div>
                                        </div>
                                        </div>
                                    <div class="row">
                                    <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Modelo</label>
                                                <input id="modelo" name="modelo" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->modelo?>" type="text">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Serie</label>
                                                <input id="serie" name="serie" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->serie?>" type="text">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Marca</label>
                                                <select name="marca" id="marca" class="form-control form-control-sm">
                                                    <option value="">--Seleccionar--</option>
                                                    <?php 
                                                    foreach ($marca as $row){?>
                                                        <option value="<?php echo $row->id ?>" <?php if($row->id==$activo->id_marca)echo "selected='selected'"?>><?php echo $row->denominiacion ?></option>
                                                        <?php 
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Color</label>
                                                <input id="color" name="color" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->color?>" type="text">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Tipo Combustible</label>
                                                <select name="tipo_combustible" id="tipo_combustible" class="form-control form-control-sm">
                                                    <option value="">--Seleccionar--</option>
                                                    <?php 
                                                    foreach ($tipo_combustible as $row){?>
                                                        <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$activo->id_tipo_combustible)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                                        <?php 
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Dimesiones</label>
                                                <input id="dimension" name="dimension" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->dimensiones?>" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                    
                                                <span class="btn btn-sm btn-warning btn-file">
                                                    Examinar <input id="image" name="image" type="file" />
                                                </span>
                                                <input type="button" class="btn btn-sm btn-primary upload" value="Subir" style="margin-left:10px">
                                                
                                                <?php
                                                    $url_foto = "/img/logo_forestalpama.jpg";
                                                    if ($activo->ruta_imagen != "") $url_foto = "/img/activos/" . $id_activo . "/" . $activo->ruta_imagen;

                                                    $foto = "";
                                                    if ($activo->ruta_imagen != "") $foto = $activo->ruta_imagen;
                                                ?>

                                                <img src="<?php echo $url_foto ?>" id="img_ruta" width="240px" height="150px" alt="" style="margin-top:10px" />
                                                <input type="hidden" id="img_foto" name="img_foto" value="<?php echo $foto ?>" />
                                            </div>	
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </fieldset>
                            <fieldset name="ubicacion" style="margin-top: 20px; border:1px solid #A4A4A4; padding: 10px">
                            <legend class="control-label form-control-sm"><b>Ubicaci&oacute;n</b></legend>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Departamento</label>
                                            <select name="departamento" id="departamento" onchange="obtenerProvincia()" class="form-control form-control-sm">
                                                <?php if($id>0){ ?> 
                                                <option value="">--Seleccionar--</option>
                                                <?php
                                                foreach ($departamento as $row) {?>
                                                <option value="<?php echo $row->id_departamento?>" <?php if($row->id_departamento==substr($activo->id_ubigeo,0,2))echo "selected='selected'"?>><?php echo $row->desc_ubigeo ?></option>
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
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Provincia</label>
                                            <select name="provincia" id="provincia" class="form-control form-control-sm" onchange="obtenerDistrito()">
                                                <option value="">--Seleccionar--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Distrito</label>
                                            <select name="distrito" id="distrito" class="form-control form-control-sm" onchange="">
                                                <option value="">--Seleccionar--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Direcci&oacute;n</label>
                                            <input id="direccion" name="direccion" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->direccion?>" type="text">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="row">
                                <div class="col-lg-4">
                                    <fieldset name="tarjeta_propiedad" style="margin-top: 20px; border:1px solid #A4A4A4; padding: 10px">
                                    <legend class="control-label form-control-sm"><b>Tarjeta Propiedad</b></legend>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label form-control-sm">Titulo</label>
                                                    <input id="titulo" name="titulo" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->titulo?>" type="text">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label form-control-sm">Partida Registral</label>
                                                    <input id="partida_registral" name="partida_registral" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->partida_registral?>" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-lg-8">
                                    <fieldset name="tarjeta_circulacion" style="margin-top: 20px; border:1px solid #A4A4A4; padding: 10px">
                                    <legend class="control-label form-control-sm"><b>Tarjeta Circulaci&oacute;n</b></legend>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label form-control-sm">Partida Circulaci&oacute;n</label>
                                                    <input id="partida_circulacion" name="partida_circulacion" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->partida_circulacion?>" type="text">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label form-control-sm">Vigencia Circulaci&oacute;n</label>
                                                    <input id="vigencia_circulacion" name="vigencia_circulacion" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->vigencia_circulacion?>" type="text" placeholder="YYYY-MM-DD">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label form-control-sm">Estado de Activo</label>
                                                    <select name="estado_activo" id="estado_activo" class="form-control form-control-sm">
                                                        <option value="">--Seleccionar--</option>
                                                        <?php 
                                                        foreach ($estado_activos as $row){?>
                                                            <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$activo->id_estado_activo)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                                            <?php 
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <!--<div class="row">
                                <div class="col-lg-6">
                                    <fieldset name="fecha_vencimiento" style="margin-top: 20px; border:1px solid #A4A4A4; padding: 10px">
                                    <legend class="control-label form-control-sm"><b>Fecha Vencimiento</b></legend>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label form-control-sm">Fecha Vencimiento SOAT</label>
                                                    <input id="fecha_vencimiento_soat" name="fecha_vencimiento_soat" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->fecha_vencimiento_soat?>" type="text" placeholder="YYYY-MM-DD">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label form-control-sm">Fecha Vencimiento Revisi&oacute;n T&eacute;cnica</label>
                                                    <input id="fecha_vencimiento_revision_tecnica" name="fecha_vencimiento_revision_tecnica" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->fecha_vencimiento_revision_tecnica?>" type="text" placeholder="YYYY-MM-DD">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>-->
                                <fieldset name="costos" style="margin-top: 20px; border:1px solid #A4A4A4; padding: 10px">
                                <legend class="control-label form-control-sm"><b>Valorizaci&oacute;n</b></legend>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Valor Libros</label>
                                                <input id="valor_libros" name="valor_libros" on class="form-control form-control-sm solo-decimal" <?= ($activo->valor_libros !== null && $activo->valor_libros !== '') ? 'value="' . number_format($activo->valor_libros, 2) . '"' : '' ?> type="text" placeholder="0.00">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Valor Comercial</label>
                                                <input id="valor_comercial" name="valor_comercial" on class="form-control form-control-sm solo-decimal" <?= ($activo->valor_comercial !== null && $activo->valor_comercial !== '') ? 'value="' . number_format($activo->valor_comercial, 2) . '"' : '' ?> type="text" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
                    <div style="margin-top:15px" class="form-group">
                        <div class="col-sm-12 controls">
                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                <a href="javascript:void(0)" onClick="fn_save_activos()" class="btn btn-sm btn-success">Registrar</a>
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

