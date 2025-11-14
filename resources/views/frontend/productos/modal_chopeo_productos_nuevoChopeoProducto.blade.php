<title>FORESPAMA</title>

<style>

/*.modal-dialog {
	//width: 100%;
	max-width:60%!important;
    margin: 1.75rem auto;
}

.modal-content {
  border-radius: 10px;
  overflow: hidden;
}

.modal-body {
  //max-height: 70vh;  scroll interno 
  overflow-y: auto;
}*/

.datepicker,
.table-condensed {
  width: 250px;
  height:250px;
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
	overflow-x: scroll;
	overflow-y: hidden;
	height: 200px;
	white-space:nowrap
}

.delete_ruta{
	background-image:url(/img/delete.png);
	top:0px;
	left:110px;
	background-size: 100%;
	position:absolute;
	display:block;
	width:30px;
	height:30px;
	cursor:pointer
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

    $('#fecha_chopeo').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    $("#producto").select2({ width: '100%' });

    $("#tienda").select2({ width: '100%' });

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

function fn_save_chopeo_producto(){

    var msg = "";

    var tienda = $('#tienda').val();
    var fecha_chopeo = $('#fecha_chopeo').val();
    var btnPrecioDimfer = $('#btnPrecioDimfer').val();
	
    if(tienda==""){msg+="Ingrese la Tienda <br>";}
    if(fecha_chopeo==""){msg+="Ingrese la Fecha <br>";}
    if(btnPrecioDimfer==""){msg+="Ingrese la Imagen del Producto <br>";}

    if(msg!=""){

        bootbox.alert(msg);
        return false;

    }else{

        var msgLoader = "";
        msgLoader = "Procesando, espere un momento por favor";
        var heightBrowser = $(window).width()/2;
        $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
        $('.loader').show();
        let form = document.getElementById('frmChopeoProducto');
        let formData = new FormData(form);

        $.ajax({
            url: "/productos/send_chopeo_producto",
            type: "POST",
            data : formData,
            contentType: false,
            processData: false,
            success: function (result) {
                $('.loader').hide();

                /*if (result.error) {
                    bootbox.alert(result.error);
                    return;
                }
                
                if (result.msg2 && result.msg2 !== "") {
                    modalProductoCompetencia(result.numero, result.nombre, result.competencia_);
                    return;
                }

                if (result.success) {
                    bootbox.alert("Chopeo registrado correctamente", function() {
                        datatablenew();
                        $('#btnPrecioDimfer').val("");
                    });
                    return;
                }*/
                
                if (result.success === true) {
                    bootbox.alert(result.message || "Chopeo registrado correctamente.", function() {

                        datatablenew();

                        bootbox.confirm({
                            message: "¿Desea continuar con otro producto?",
                            buttons: {
                                confirm: {
                                    label: 'Sí',
                                    className: 'btn-success'
                                },
                                cancel: {
                                    label: 'No',
                                    className: 'btn-danger'
                                }
                            },
                            callback: function (result) {
                                if (result) {
                                    $('#btnPrecioDimfer').val("");
                                } else {
                                    $('#openOverlayOpc').modal('hide');
                                }
                            }
                        });
                    });
                }else if (result.error) {
                    bootbox.alert(result.error);
                }else if (result.msg2) {
                    if (result.msg2 !== "") {
                        bootbox.alert(result.msg2, function() {
                            var codigo_producto_competencia = result.numero;
                            var nombre_producto_competencia = result.nombre;
                            var competencia_producto_competencia = result.competencia_;
                            modalProductoCompetencia(codigo_producto_competencia, nombre_producto_competencia, competencia_producto_competencia);
                        });
                    }
                }
            },
            error: function (xhr) {
                $('.loader').hide();
                console.error(xhr.responseText);
                bootbox.alert("Ocurrió un error al procesar la solicitud.");
            }
        });
    }
}

function modalProductoCompetencia(codigo_producto_competencia,nombre_producto_competencia,competencia_producto_competencia){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc2 .modal-body').css('height', 'auto');

	$.ajax({
		url: "/productos/modal_producto_competencia/"+codigo_producto_competencia+"/"+nombre_producto_competencia+"/"+competencia_producto_competencia,
		type: "GET",
		success: function (result) {
			$("#diveditpregOpc2").html(result);
			$('#openOverlayOpc2').modal('show');
		}
	});
}

</script>

<div class="modal-header bg-success text-white">
    <h5 class="modal-title" id="chopeoModalLabel">Registrar Chopeo de Producto</h5>
    <!--<button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
    <span aria-hidden="true">&times;</span>
    </button>-->
</div>

<div class="modal-body">
<form method="post" action="#" id="frmChopeoProducto" name="frmChopeoProducto" enctype="multipart/form-data">
                
    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id" id="id" value="<?php echo $id?>">

    <div class="row">
    
        <div class="form-group col-md-4">
            <label class="form-control-sm">Competencia</label>
            <select name="competencia" id="competencia" class="form-control form-control-sm">
                <option value="">--Seleccionar--</option>
                <?php
                foreach ($competencia as $row){?>
                    <option value="<?php echo $row->codigo ?>"><?php echo $row->denominacion ?></option>
                <?php 
                }
                ?>
            </select>
        </div>

        <div class="form-group col-md-4">
            <label class="form-control-sm">Tienda</label>
            <select name="tienda" id="tienda" class="form-control form-control-sm" onchange="">
                <option value="">--Seleccionar--</option>
                <?php
                foreach ($tienda as $row){?>
                    <option value="<?php echo $row->id ?>"><?php echo $row->denominacion ?></option>
                <?php 
                }
                ?>
            </select>
        </div>

        <div class="form-group col-md-3">
            <label class="form-control-sm">Fecha</label>
            <input id="fecha_chopeo" name="fecha_chopeo" on class="form-control form-control-sm"  value="<?php echo date('Y-m-d'); ?>" type="text">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-4">
            <label class="control-label form-control-sm">Cargar Precio</label>
            <input type="file" class="form-control-file btn btn-sm btn-success" style="background-color: #F6F6F6 !important; border: none !important; padding: 0 !important; box-shadow: none !important; color:black" id="btnPrecioDimfer" name="btnPrecioDimfer">
            <?php if (!empty($producto->ruta_ficha_tecnica)) : ?>
                <div class="mt-2">
                    <i class="fa fa-file-pdf-o"></i>
                    <a href="<?php echo asset($producto->ruta_ficha_tecnica); ?>" target="_blank">Descargar Precio Dimfer</a>
                </div>
            <?php endif; ?>
        </div>
    </div>  
    <div class="modal-footer">
        <!--<a href="javascript:void(0)" onClick="fn_save_chopeo_producto()" class="btn btn-sm btn-success">Guardar</a>-->
        <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-nuevo" data-toggle="modal" onclick="fn_save_chopeo_producto()">
            <i class="fas fa-save" style="font-size:18px;"></i> Guardar
        </button>
        <!--<a href="javascript:void(0)" onClick="$('#openOverlayOpc').modal('hide');" class="btn btn-sm btn-info" style="margin-left:10px">Cerrar</a>-->
        <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-cerrar" data-toggle="modal" onclick="$('#openOverlayOpc').modal('hide');">
            <i class="fas fa-times-circle" style="font-size:18px;"></i> Cerrar
        </button>
    </div>
</form>
</div>

<script type="text/javascript">

    $(document).ready(function() {

    });

</script>

