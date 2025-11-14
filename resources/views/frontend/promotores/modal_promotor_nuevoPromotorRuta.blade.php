<title>FORESPAMA</title>

<style>
/*
.datepicker {
  z-index: 1600 !important; 
}
*/
/*.datepicker{ z-index:99999 !important; }*/

.modal-dialog {
  max-height: 100vh;
  display: flex;
  flex-direction: column;
}

.modal-content {
  flex: 1 1 auto;
  overflow: hidden;
}

.modal-body {
  overflow-y: auto;
}

.datepicker,
.table-condensed {
  width: 250px;
  height:250px;
}

.modal-dialog {
    width: 100%;
    max-width:100%!important
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

    $('#fecha').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

});

</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
	 
});

$(document).ready(function() {

    agregarHorario();

});

function fn_save_promotor_ruta(){
	
    var msg = "";

    var id_promotor = $('#id_promotor').val();

    if(id_promotor==""){msg+="Ingrese el Promotor <br>";}
    
    if ($('#tblPromotorRutaDetalle tbody tr').length == 0) {
        msg += "No tiene ningun horario <br>";
    }

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
                url: "/promotores/send_promotor_ruta",
                type: "POST",
                data : $("#frmDispensacion").serialize(),
                success: function (result) {
                    //alert(result.id)
                    $('#openOverlayOpc').modal('hide');
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

function agregarHorario(){

    var opcionesTienda = `<?php
        echo '<option value="">--Seleccionar--</option>';
        foreach ($tiendas as $row) {
            echo '<option value="' . htmlspecialchars($row->id, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($row->id . ' - ' . $row->denominacion, ENT_QUOTES, 'UTF-8') . '</option>';
        }
    ?>`;

    var cantidad = 7;
    
    for (var i = 0; i < cantidad; i++) {
        var n = $('#tblPromotorRutaDetalle tbody tr').length + 1;
        var fecha = '<input name="id_promotor_ruta_detalle[]" id="id_promotor_ruta_detalle${n}" class="form-control form-control-sm" value="${promotor_ruta.id}" type="hidden"><input name="fecha[]" id="fecha' + n + '" class="form-control form-control-sm" value="" type="text">';
        //var cantidad = '<input name="cantidad[]" id="cantidad' + n + '" class="form-control form-control-sm" value="" type="text">';
        var tienda = '<select name="tienda[]" id="tienda' + n + '" class="form-control form-control-sm"> ' + opcionesTienda +' </select>';
        var hora_llegada = '<input name="hora_llegada[]" id="hora_llegada' + n + '" class="form-control form-control-sm" value="" type="time">'
        var hora_salida = '<input name="hora_salida[]" id="hora_salida' + n + '" class="form-control form-control-sm" value="" type="time">'
        var hora_estado_situacional = '<input name="hora_estado_situacional[]" id="hora_estado_situacional' + n + '" class="form-control form-control-sm" value="" type="time">'
        var hora_estado_promocion = '<input name="hora_estado_promocion[]" id="hora_estado_promocion' + n + '" class="form-control form-control-sm" value="" type="time">'
        
        var btnEliminar = '<button type="button" class="btn btn-sm btn-clasico btn-eliminar" onclick="eliminarFila(this)"><i class="fas fa-trash" style="font-size:18px;"></i></button>';
        var newRow = "";
        newRow += '<tr>';
        newRow += '<td>' + n + '</td>';
        newRow += '<td>' + fecha + '</td>';
        newRow += '<td>' + tienda + '</td>';
        newRow += '<td>' + hora_llegada + '</td>';
        newRow += '<td>' + hora_salida + '</td>';
        newRow += '<td>' + hora_estado_situacional + '</td>';
        newRow += '<td>' + hora_estado_promocion + '</td>';
        newRow += '<td>' + btnEliminar + '</td>';
        newRow += '</tr>';

        $('#tblPromotorRutaDetalle tbody').append(newRow);
        
        $('#tienda' + n).select2({
            width: '100%',
        });

        $('#fecha' + n).datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            changeMonth: true,
            changeYear: true,
            language: 'es'
        });
    }
}

function eliminarFila(button){
    $(button).closest('tr').remove();
    actualizarTotalGeneral();
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
                    <b>Registrar Rutas Promotor</b>
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmPromotorRuta" name="frmPromotorRuta">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                    
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                    
                    <div class="row" style="padding-left:10px">

                        <div class="col-lg-2">
                            Promotor
                        </div>
                        <div class="col-lg-4">
                            <select name="id_promotor" id="id_promotor" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($promotores as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php //if($row->codigo==$selectedDocumento)echo "selected='selected'"?>><?php echo $row->name ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="card-body" style="margin-top:15px">	
                    <div class="table-responsive" style="overflow-y: auto; max-height: 400px;">
						<table id="tblPromotorRutaDetalle" class="table table-hover table-sm">
							<thead>
							<tr style="font-size:13px">
								<th>#</th>
								<th>D&iacute;a</th>
								<th>Tienda</th>
								<th>Hora Llegada</th>
                                <th>Hora Salida</th>
                                <th>Hora Estado Situacional</th>
                                <th>Hora Estado Promoci&oacute;n</th>
							</tr>
							</thead>
							<tbody id="divPromotorRutaDetalle">
							</tbody>
						</table>
					</div>
                    
                    <div style="margin-top:15px" class="form-group">
                        <div class="col-sm-12 controls">
                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                
                                <!--<a href="javascript:void(0)" onClick="fn_save_promotor_ruta()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>-->
                                <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-nuevo" data-toggle="modal" onclick="fn_save_promotor_ruta()">
                                    <i class="fas fa-save" style="font-size:18px;"></i> Guardar
                                </button>
                                
                                <!--<a href="javascript:void(0)" onClick="$('#openOverlayOpc').modal('hide');" class="btn btn-sm btn-info" style="">Cerrar</a>-->
                                <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-cerrar" data-toggle="modal" onclick="$('#openOverlayOpc').modal('hide');">
                                    <i class="fas fa-times-circle" style="font-size:18px;"></i> Cerrar
                                </button>
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
	
});


</script>

<script type="text/javascript">
$(document).ready(function() {
	//$('#numero_placa').focus();
	//$('#numero_placa').mask('AAA-000');
	//$('#vehiculo_numero_placa').mask('AAA-000');
	
	
});




</script>

