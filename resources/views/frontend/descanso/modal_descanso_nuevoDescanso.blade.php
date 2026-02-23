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
	max-width:60%!important
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

    cargarDetalle();

    $('#fecha_ingreso_descanso').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        changeMonth: true,
        changeYear: true,
        language: 'es'
    }).on('changeDate', calcularDiasDescanso);

    $('#fecha_salida_descanso').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        changeMonth: true,
        changeYear: true,
        language: 'es'
    }).on('changeDate', calcularDiasDescanso);

    calcularDiasDescanso();

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

function limpiar(){
	$('#id').val("0");
	$('#id_tipo_documento').val("");
	$('#denominacion').val("");
	$('#img_foto').val("");
}

function fn_save_descanso(){
	
	$.ajax({
        url: "/descanso/send_descanso",
        type: "POST",
        data : $("#frmDescanso").serialize(),
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

function cargarDetalle(){

    var id = $("#id").val();
    const tbody = $('#divDescansoDetalle');

    tbody.empty();
    
    $.ajax({
        url: "/descanso/cargar_detalle/"+id,
        type: "GET",
        success: function (result) {

            let n = 1;

            result.descanso.forEach(descanso => {

                let productoOptions = '<option value="">--Seleccionar--</option>';
                let unidadMedidaOptions = '<option value="">--Seleccionar--</option>';

                result.producto.forEach(producto => {
                    let selected = (producto.id == descanso.id_producto) ? 'selected' : '';
                    productoOptions += `<option value="${producto.id}" ${selected}>${producto.codigo} - ${producto.denominacion}</option>`;
                });

                result.unidad_medida.forEach(unidad_medida => {
                    let selected = (unidad_medida.codigo == descanso.id_unidad_medida) ? 'selected' : '';
                    unidadMedidaOptions += `<option value="${unidad_medida.codigo}" ${selected}>${unidad_medida.denominacion}</option>`;
                });

                /*if (descanso.id_producto) {
                    productosSeleccionados.push(descanso.id_producto);
                }*/

                const row =`
                <tr>
                    <td>${n}</td>
                    <td style="width: 550px !important;display:block"><input name="id_descanso_detalle[]" id="id_descanso_detalle${n}" class="form-control form-control-sm" value="${descanso.id}" type="hidden"><input name="descripcion[]" id="descripcion${n}" class="form-control form-control-sm" value="${descanso.id_producto}" type="hidden"><select name="descripcion_[]" id="descripcion_${n}" class="form-control form-control-sm select-producto" onChange="verificarProductoSeleccionado(this, ${n});" disabled>${productoOptions}</select></td>
                    
                    <td><input name="cod_interno[]" id="cod_interno${n}" class="form-control form-control-sm" value="${descanso.codigo}" type="text" readonly></td>
                    <td><input name="unidad[]" id="unidad${n}" class="form-control form-control-sm" value="${descanso.id_unidad_medida}" type="hidden"><select name="unidad_[]" id="unidad_${n}" class="select-unidad form-control form-control-sm" disabled>${unidadMedidaOptions}</select></td>
                    <td><input name="cantidad_ingreso[]" id="cantidad_ingreso${n}" class="cantidad_ingreso form-control form-control-sm" value="${descanso.cantidad}" type="text" oninput="calcularCantidadPendiente(this);"></td>
                    
                    <td><button type="button" class="btn btn-sm btn-clasico btn-eliminar" onclick="eliminarFila(this)"><i class="fas fa-trash" style="font-size:18px;"></i></button></td>
                </tr>
                `;

                tbody.append(row);

                n++;
                
            });

            //$('.select-unidad').select2({ width: '100%' });
        }
    });
}

function calcularDiasDescanso() {

    var ingreso = document.getElementById('fecha_ingreso_descanso').value;
    var salida  = document.getElementById('fecha_salida_descanso').value;

    if (!ingreso) {
        document.getElementById('dias_descanso').value = '';
        return;
    }

    var fechaIngreso = new Date(ingreso);
    var fechaSalida  = salida ? new Date(salida) : new Date();

    var diferencia = fechaSalida - fechaIngreso;
    var dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));

    document.getElementById('dias_descanso').value = dias >= 0 ? dias : 0;
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
                    Registrar Salida de Descanso
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmDescanso" name="frmDescanso">

                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                                
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                            <input type="hidden" name="id_ingreso_horno" id="id_ingreso_horno" value="<?php echo $descanso->id_ingreso_horno?>">
                            
                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-2">
                                    Fecha Ingreso Descanso
                                </div>
                                <div class="col-lg-2">
                                    <input id="fecha_ingreso_descanso_" name="fecha_ingreso_descanso_" on class="form-control form-control-sm"  value="<?php echo isset($descanso) && $descanso->fecha_ingreso_descanso ? $descanso->fecha_ingreso_descanso : date('Y-m-d');  ?>" type="text" disabled>
                                    <input name="fecha_ingreso_descanso" id="fecha_ingreso_descanso" class="form-control form-control-sm" value="<?php echo isset($descanso) && $descanso->fecha_ingreso_descanso ? $descanso->fecha_ingreso_descanso : date('Y-m-d');  ?>" type="hidden">
                                </div>

                                <div class="col-lg-2">
                                    Fecha Salida Descanso
                                </div>
                                <div class="col-lg-2">
                                    <input id="fecha_salida_descanso" name="fecha_salida_descanso" on class="form-control form-control-sm"  value="<?php echo date('Y-m-d'); ?>" type="text">
                                </div>

                                <div class="col-lg-2">
                                    D&iacute;as Descanso
                                </div>
                                <div class="col-lg-2">
                                    <input id="dias_descanso" name="dias_descanso" on class="form-control form-control-sm"  value="" type="text" readonly>
                                </div>
                                <div class="col-lg-2" style="color:red; font-weight:bold">
                                    Almacen Destino
                                </div>
                                <div class="col-lg-3">
                                    <select name="almacen_" id="almacen_" class="form-control form-control-sm" disabled>
                                        <option value="">--Seleccionar--</option>
                                        <?php
                                        foreach ($almacen as $row){?>
                                            <option value="<?php echo $row->id ?>" <?php if($row->id==8)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                            <?php 
                                        }
                                        ?>
                                    </select>
                                    <input name="almacen" id="almacen" class="form-control form-control-sm" value="8" type="hidden">
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card-body" style="padding-right: 0px !important; padding-left: 0px !important;">
                        <div class="table-responsive" style="overflow-y: auto; max-height: 350px;">
                            <table id="tblDescansoDetalle" class="table table-hover table-sm">
                                <thead>
                                <tr style="font-size:12px">
                                    <th style="width : 5%">#</th>
                                    <th style="width : 50%">Descripci&oacute;n</th>
                                    <th style="width : 10%">COD. INT.</th>
                                    <th style="width : 20%">Unidad</th>
                                    <th style="width : 10%">Cantidad</th>
                                </tr>
                                </thead>
                                <tbody id="divDescansoDetalle" style="font-size:14px">
                                </tbody>
                            </table>
                        </div>
                    </div>
                        <div style="margin-top:15px" class="form-group">
                            <div class="col-sm-12 controls">
                                <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                    <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-nuevo" data-toggle="modal" onclick="fn_save_descanso()">
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

