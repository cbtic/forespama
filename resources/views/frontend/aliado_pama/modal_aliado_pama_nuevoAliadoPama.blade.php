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
	max-width:40%!important
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
     $('#fecha_inicio').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    $('#fecha_nacimiento').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });
});

$(document).ready(function() {

	var id_ubigeo = "<?php echo $persona->id_ubigeo_nacimiento?>";
    var idProvincia = id_ubigeo.substring(2,4);
    var idDistrito = id_ubigeo.substring(4,6);

    obtenerProvinciaNacimientoEdit(idProvincia);
    obtenerDistritoNacimientoEdit(idProvincia,idDistrito);
});

function limpiar(){
	$('#id').val("0");
	$('#id_tipo_documento').val("");
	$('#denominacion').val("");
	$('#img_foto').val("");
}

function fn_save_aliado_comision(){

    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
        url: "/aliado_pama/send_aliado_pama",
        type: "POST",
        data : $("#frmAliadoPama").serialize(),
        success: function (result) {
            //alert(result);
            $('.loader').hide();
            if (result.success) {
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

function obtenerProvinciaNacimiento(){

    var id = $('#id_departamento_nacimiento').val();
    if(id=="")return false;
    $('#id_provincia_nacimiento').attr("disabled",true);
    $('#id_distrito_nacimiento').attr("disabled",true);

    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

    $.ajax({
        url: '/persona/obtener_provincia/'+id,
        dataType: "json",
        success: function(result){
            var option = "<option value='' selected='selected'>Seleccionar</option>";
            $('#id_provincia_nacimiento').html("");
            $(result).each(function (ii, oo) {
                option += "<option value='"+oo.id_provincia+"'>"+oo.desc_ubigeo+"</option>";
            });
            $('#id_provincia_nacimiento').html(option);

            var option2 = "<option value=''>Seleccionar</option>";
            $('#id_distrito_nacimiento').html(option2);

            $('#id_provincia_nacimiento').attr("disabled",false);
            $('#id_distrito_nacimiento').attr("disabled",false);

            $('.loader').hide();

        }
    });
}

function obtenerDistritoNacimiento(){

    var id_departamento = $('#id_departamento_nacimiento').val();
    var id = $('#id_provincia_nacimiento').val();
    if(id=="")return false;
    $('#id_distrito_nacimiento').attr("disabled",true);

    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

    $.ajax({
        url: '/persona/obtener_distrito/'+id_departamento+'/'+id,
        dataType: "json",
        success: function(result){
            var option = "<option value=''>Seleccionar</option>";
            $('#id_distrito_nacimiento').html("");
            $(result).each(function (ii, oo) {
                option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
            });
            $('#id_distrito_nacimiento').html(option);

            $('#id_distrito_nacimiento').attr("disabled",false);
            $('.loader').hide();

        }
    });
}

function obtenerProvinciaNacimientoEdit(idProvincia){

		var id = $('#id_departamento_nacimiento').val();
		if(id=="")return false;
		$('#id_provincia_nacimiento').attr("disabled",true);
		$('#id_distrito_nacimiento').attr("disabled",true);

		var msgLoader = "";
		msgLoader = "Procesando, espere un momento por favor";
		var heightBrowser = $(window).width()/2;
		$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
		$('.loader').show();

		$.ajax({
			url: '/persona/obtener_provincia/'+id,
			dataType: "json",
			success: function(result){
				var option = "<option value='' selected='selected'>Seleccionar</option>";
				$('#id_provincia_nacimiento').html("");
				var selected = "";
				$(result).each(function (ii, oo) {
					selected = "";
					if(idProvincia == oo.id_provincia)selected = "selected='selected'";
					option += "<option value='"+oo.id_provincia+"' "+selected+" >"+oo.desc_ubigeo+"</option>";
				});
				$('#id_provincia_nacimiento').html(option);

				$('#id_provincia_nacimiento').attr("disabled",false);

				$('.loader').hide();

			}
		});
	}

	function obtenerDistritoNacimientoEdit(idProvincia,idDistrito){
		//alert("ok");
		var id_departamento = $('#id_departamento_nacimiento').val();
		var id = idProvincia;
		if(id=="")return false;
		$('#id_distrito_nacimiento').attr("disabled",true);

		var msgLoader = "";
		msgLoader = "Procesando, espere un momento por favor";
		var heightBrowser = $(window).width()/2;
		$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
		$('.loader').show();

		$.ajax({
			url: '/persona/obtener_distrito/'+id_departamento+'/'+id,
			dataType: "json",
			success: function(result){
				var option = "<option value=''>Seleccionar</option>";
				$('#id_distrito_nacimiento').html("");
				var selected = "";
				$(result).each(function (ii, oo) {
					selected = "";
					if(id_departamento+idProvincia+idDistrito == oo.id_ubigeo)selected = "selected='selected'";
					option += "<option value='"+oo.id_ubigeo+"' "+selected+" >"+oo.desc_ubigeo+"</option>";
				});
				$('#id_distrito_nacimiento').html(option);
				$('#id_distrito_nacimiento').attr("disabled",false);
				$('.loader').hide();

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
                
                <div class="card-header" style="padding:5px!important;padding-left:20px!important">
                    Editar Aliado Pama
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmAliadoPama" name="frmAliadoPama">

                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                            
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                            
                            <div style="padding-left:15px">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Tipo Documento</label>
                                            <select name="tipo_documento" id="tipo_documento" class="form-control form-control-sm" onchange="" disabled>
                                                <option value="">--Selecionar--</option>
                                                <?php
                                                foreach ($tipo_documento as $row) { ?>
                                                    <option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == $persona->id_tipo_documento) echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
                                            <label class="control-label form-control-sm">N&uacute;mero Documento</label>
                                            <input id="numero_documento" name="numero_documento" class="form-control form-control-sm" value="<?php echo $persona->numero_documento ?>" type="text" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Nombres</label>
                                            <input id="nombre" name="nombre" class="form-control form-control-sm" value="<?php echo $persona->nombres ?>" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Apellido Paterno</label>
                                            <input id="apellido_paterno" name="apellido_paterno" class="form-control form-control-sm" value="<?php echo $persona->apellido_paterno ?>" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Apellido Materno</label>
                                            <input id="apellido_materno" name="apellido_materno" class="form-control form-control-sm" value="<?php echo $persona->apellido_materno ?>" type="text" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Fecha Nacimiento</label>
                                            <input placeholder="yyyy-mm-dd" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control form-control-sm" value="<?php echo $persona->fecha_nacimiento ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Departamento</label>
                                            <input type="hidden" name="id_ubigeo_nacimiento" id="id_ubigeo_nacimiento" value="<?php echo $persona->id_ubigeo_nacimiento?>">
                                            <select name="id_departamento_nacimiento" id="id_departamento_nacimiento" class="form-control form-control-sm" onChange="obtenerProvinciaNacimiento()">
                                                <option value="">--Selecionar--</option>
                                                <?php
                                                foreach ($departamento as $row) {?>
                                                <option value="<?php echo $row->id_departamento?>" <?php if($row->id_departamento==substr($persona->id_ubigeo_nacimiento,0,2))echo "selected='selected'"?>><?php echo $row->desc_ubigeo ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Provincia</label>
                                            <select name="id_provincia_nacimiento" id="id_provincia_nacimiento" class="form-control form-control-sm" onChange="obtenerDistritoNacimiento()">
                                                <option value="">--Selecionar--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Distrito</label>
                                            <select name="id_distrito_nacimiento" id="id_distrito_nacimiento" class="form-control form-control-sm" onChange="">
                                                <option value="">--Selecionar--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">N&uacute;mero Celular</label>
                                            <input id="numero_celular" name="numero_celular" class="form-control form-control-sm" value="<?php echo $persona->telefono ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Correo</label>
                                            <input id="correo" name="correo" class="form-control form-control-sm" value="<?php echo $persona->email ?>" type="text">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Direcci&oacute;n</label>
                                            <input id="direccion" name="direccion" class="form-control form-control-sm" value="<?php echo $persona->direccion ?>" type="text">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Fecha Afiliaci&oacute;n</label>
                                            <input placeholder="yyyy-mm-dd" type="text" id="fecha_inicio" name="fecha_inicio" class="form-control form-control-sm" value="<?php echo $aliado_pama->fecha_inicio ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Porcentaje Comisi&oacute;n</label>
                                            <input id="porcentaje_comision" name="porcentaje_comision" class="form-control form-control-sm" value="<?php echo $aliado_pama->porcentaje_comision ?>" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <!--<label class="control-label">Porcentaje Personalizado</label>-->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="porcentaje_personalizado" value="1" id="porcentaje_personalizado" <?php if($aliado_pama->porcentaje_personalizado == 1) echo 'checked'; ?>>
                                            <label class="form-check-label" for="porcentaje_personalizado">Porcentaje Personalizado</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top:15px" class="form-group">
                            <div class="col-sm-12 controls">
                                <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                    <!--<a href="javascript:void(0)" onClick="fn_save_marca()" class="btn btn-sm btn-success">Guardar</a>-->
                                    <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-nuevo" data-toggle="modal" onclick="fn_save_aliado_comision()">
                                        <i class="fas fa-save" style="font-size:18px;"></i> Guardar
                                    </button>
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
	});
});

</script>

<script type="text/javascript">
$(document).ready(function() {
	
});

</script>
