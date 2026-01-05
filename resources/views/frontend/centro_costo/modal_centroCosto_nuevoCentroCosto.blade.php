<title>FORESPAMA</title>

<style>

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
  font-weight:bold;
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
     $('#fecha_solicitud').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
     });	 
});

function limpiar(){
	$('#id').val("0");
	$('#id_tipo_documento').val("");
	$('#denominacion').val("");
	$('#img_foto').val("");
}

function fn_save_centro_costo(){

    $('#denominacion').val($('#denominacion').val().toUpperCase());
	
	$.ajax({
        url: "/centro_costo/send_centro_costo",
        type: "POST",
        data : $("#frmCentroCosto").serialize(),
        success: function (result) {
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
                    Registrar Centro de Costo
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmCentroCosto" name="frmCentroCosto">

                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                                
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                            
                            <div class="row" style="padding-left:10px">
                                
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="control-label form-control-sm">Periodo</label>
                                        <input id="periodo" name="periodo" on class="form-control form-control-sm"  value="<?php echo $centro_costo->periodo?>" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label form-control-sm">Operaciones</label>
                                        <input id="operacion" name="operacion" on class="form-control form-control-sm"  value="<?php echo $centro_costo->operacion?>" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label class="control-label form-control-sm">Denominaci&oacute;n</label>
                                        <input id="denominacion" name="denominacion" on class="form-control form-control-sm"  value="<?php echo $centro_costo->denominacion?>" type="text" style="text-transform: uppercase;">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="control-label form-control-sm">C&oacute;digo</label>
                                        <input id="codigo" name="codigo" on class="form-control form-control-sm"  value="<?php echo $centro_costo->codigo?>" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top:15px" class="form-group">
                        <div class="col-sm-12 controls">
                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-nuevo" data-toggle="modal" onclick="fn_save_centro_costo()">
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

