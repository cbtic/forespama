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

});

$(document).ready(function() {

});

function fn_save_retiro_aliado_comision(){

    var numero_documento_aliado_pama = $('#numero_documento_aliado_pama').val();
    var nombre_aliado_pama = $('#nombre_aliado_pama').val();

    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
        url: "/aliados_pama_comisiones/send_retiro_comision_aliado_pama",
        type: "POST",
        data : $("#frmRetiroComisionAliadoPama").serialize(),
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

function activarAliado(){

    if ($('#venta_aliado').is(':checked')) {

        $('#datos_aliado_pama').show();

    } else {

        $('#datos_aliado_pama').hide();

        $('#numero_documento_aliado_pama').val('');
        $('#nombre_aliado_pama').val('');
    }

}

function obtenerAliadoPama(){
	
	var numero_documento_aliado_pama = $("#numero_documento_aliado_pama").val();
		
	$.ajax({
		url: '/aliados_pama_comisiones/obtener_datos_aliado/' + numero_documento_aliado_pama,
		dataType: "json",
		success: function(result){
			
			var aliadosPama = result.aliado_pama;
            if(aliadosPama != ""){
                $('#nombre_aliado_pama').val(aliadosPama[0].nombres);
            }else{
                bootbox.alert("No se encuentra registrado el Aliado Pama.")
            }
			
		}
	});
}

function copiar_caja_aliado_comision(){

    var tipo_venta = $('input[name="venta"]:checked').val();

    var numero_documento_aliado_pama = $('#numero_documento_aliado_pama').val();
    var nombre_aliado_pama = $('#nombre_aliado_pama').val();

    if(tipo_venta == 'venta_tienda'){
        $('#titulo_tipo_venta').text('Venta en Tienda');
        $('#openOverlayOpc').modal('hide');
    }else{
        if(numero_documento_aliado_pama != "" && nombre_aliado_pama != ""){

            $('#numero_documento_aliado').val(numero_documento_aliado_pama);
            $('#nombre_aliado').val(nombre_aliado_pama);
            var tipo_venta = $('input[name="venta"]:checked').val();

            if (tipo_venta == 'venta_tienda') {
                $('#titulo_tipo_venta').text('Venta en Tienda');
            } else if (tipo_venta == 'venta_aliado') {
                $('#titulo_tipo_venta').text('Venta Aliado');
            }
            $('#openOverlayOpc').modal('hide');
        }else{
            bootbox.alert("Falta ingresar datos")
        }
    }
}

/*function copiar_caja_aliado_comision(){

    var numero_documento_aliado_pama = $('#numero_documento_aliado_pama').val();
    var nombre_aliado_pama = $('#nombre_aliado_pama').val();

    $('#numero_documento_aliado').val(numero_documento_aliado_pama);
    $('#nombre_aliado').val(nombre_aliado_pama);

    var tipo_venta = $('input[name="venta"]:checked').val();

    if (tipo_venta == 'venta_tienda') {
        $('#titulo_tipo_venta').text('Venta en Tienda');
    } else if (tipo_venta == 'venta_aliado') {
        $('#titulo_tipo_venta').text('Venta Aliado');
    }

    $('#openOverlayOpc').modal('hide');
    
}*/

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
                    Tipo de Venta
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmCajaComisionAliadoPama" name="frmCajaComisionAliadoPama">

                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                            
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            
                            <div style="padding-left:15px">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label" for="tienda">Venta en Tienda</label>
                                            <input type="radio" name="venta" value="venta_tienda" id="venta_tienda" checked onchange="activarAliado()">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label ml-3" for="aliado">Venta Aliado</label>
                                            <input type="radio" name="venta" value="venta_aliado" id="venta_aliado" onchange="activarAliado()">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="datos_aliado_pama" style="display:none;">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">N&uacute;mero de Documento</label>
                                            <input id="numero_documento_aliado_pama" name="numero_documento_aliado_pama" class="form-control form-control-sm" value="" type="text" onchange="obtenerAliadoPama()">
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label class="form-control-sm form-control-sm">Nombres y Apellidos</label>
                                            <input name="nombre_aliado_pama" id="nombre_aliado_pama" class="form-control form-control-sm" readonly type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top:15px" class="form-group">
                            <div class="col-sm-12 controls">
                                <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                    <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-nuevo" data-toggle="modal" onclick="copiar_caja_aliado_comision()">
                                        <i class="fas fa-save" style="font-size:18px;"></i> Aceptar
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
