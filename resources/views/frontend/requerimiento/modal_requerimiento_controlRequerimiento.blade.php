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

    $('#fecha_requerimiento').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    $("#item").select2({ width: '100%' });

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
    if($('#id').val()==0){
        obtenerCodigo();
    }

    if($('#id').val()>0){
        cargarDetalle();
        cambiarOrigen();
    }
});

function obtenerDescripcion(selectElement){

    var fila = $(selectElement).closest('tr');

    var descripcion_completo = $(selectElement).find('option:selected').text();

    var descripcion_partes = descripcion_completo.split('-');

    var descripcion = descripcion_partes.length > 1 ? descripcion_partes[1].trim() : '';

    fila.find('input[name="descripcion[]"]').val(descripcion);

}

function obtenerCodInterno(selectElement, n){

    var id_producto = $(selectElement).val();

    $.ajax({
            url: "/productos/obtener_producto/"+id_producto,
            dataType: "json",
            success: function(result){
                //alert(result[0].codigo);
                $('#cod_interno' + n).val(result[0].codigo);
                $('#item' + n).val(result[0].numero_serie);
                $('#marca' + n).val(result[0].id_marca).trigger('change');
                $('#unidad' + n).val(result[0].id_unidad_producto);

                $('#fecha_vencimiento_' + n).datepicker({
                    autoclose: true,
                    format: 'yyyy-mm-dd',
                    changeMonth: true,
                    changeYear: true,
                    language: 'es'
                });
                
            }
        });
}

function obtenerCodigo(selectElement){

    var selectedOption = selectElement.options[selectElement.selectedIndex];
    
    var codigo = selectedOption.text.split('-')[0].trim();

    selectedOption.text = codigo;

}

var productosSeleccionados = [];

function cargarDetalle(){

var id = $("#id").val();
const tbody = $('#divRequerimientoDetalle');

tbody.empty();

$.ajax({
        url: "/requerimiento/cargar_detalle_control/"+id,
        type: "GET",
        success: function (result) {

            let n = 1;

            var total_acumulado=0;

            result.requerimiento.forEach(requerimiento => {

                let marcaOptions = '<option value="">--Seleccionar--</option>';
                let productoOptions = '<option value="">--Seleccionar--</option>';
                let estadoBienOptions = '<option value="">--Seleccionar--</option>';
                let unidadMedidaOptions = '<option value="">--Seleccionar--</option>';
                
                result.marca.forEach(marca => {
                    let selected = (marca.id == requerimiento.id_marca) ? 'selected' : '';
                    marcaOptions += `<option value="${marca.id}" ${selected}>${marca.denominiacion}</option>`;
                });

                result.producto.forEach(producto => {
                    let selected = (producto.id == requerimiento.id_producto) ? 'selected' : '';
                    productoOptions += `<option value="${producto.id}" ${selected}>${producto.codigo} - ${producto.denominacion}</option>`;
                });

                result.estado_bien.forEach(estado_bien => {
                    let selected = (estado_bien.codigo == requerimiento.id_estado_producto) ? 'selected' : '';
                    estadoBienOptions += `<option value="${estado_bien.codigo}" ${selected}>${estado_bien.denominacion}</option>`;
                });

                result.unidad_medida.forEach(unidad_medida => {
                    let selected = (unidad_medida.codigo == requerimiento.id_unidad_medida) ? 'selected' : '';
                    unidadMedidaOptions += `<option value="${unidad_medida.codigo}" ${selected}>${unidad_medida.denominacion}</option>`;
                });

                if (requerimiento.id_producto) {
                    productosSeleccionados.push(requerimiento.id_producto);
                }

                const idMarca = requerimiento.id_marca ?? '';

                const row = `
                    <tr>
                        <td>${n}</td>
                        <td><input name="item[]" id="item${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${requerimiento.item}" type="text" disabled></td>
                        <td style="width: 450px!important; display:block!important"><textarea name="descripcion[]" id="descripcion${n}" class="form-control form-control-sm" style="border: none; background-color: transparent " type="text" disabled>${requerimiento.nombre_producto}</textarea></td>
                        <td><input name="marca[]" id="marca${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${requerimiento.marca}" type="text" disabled></td>
                        <td><input name="cod_interno[]" id="cod_interno${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${requerimiento.codigo}" type="text" disabled></td>
                        <td><input name="estado_bien[]" id="estado_bien${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${requerimiento.estado_producto}" type="text" disabled></td>
                        <td><input name="unidad[]" id="unidad${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${requerimiento.unidad_medida}" type="text" disabled></td>
                        <td><input name="cantidad_ingreso[]" id="cantidad_ingreso${n}" class="cantidad_ingreso form-control form-control-sm" style="border: none; background-color: transparent;" value="${requerimiento.cantidad}" type="text" oninput="" disabled></td>
                        <td><input name="cantidad_atendida[]" id="cantidad_atendida${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${requerimiento.cantidad_atendida}" type="text" disabled></td>
                        <td><input name="orden_compra[]" id="orden_compra${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${requerimiento.orden_compra}" type="text" disabled></td>

                    </tr>
                `;
                tbody.append(row);
                $('#descripcion_' + n).select2({ 
                    width: '100%', 
                    dropdownCssClass: 'custom-select2-dropdown'
                });

                $('#marca_' + n).select2({
                    width: '100%',
                });

                n++;
                });
            }
            
    });

}

function pdf_documento(){

    var id = $('#id').val();
    //var tipo_movimiento = $('#tipo_movimiento').val();

    var href = '/requerimiento/movimiento_pdf_requerimiento/'+id;
    window.open(href, '_blank');

}

function cerrarModalRequerimiento(){

    $('#openOverlayOpc').modal('hide');

    datatablenew();
}

function pdf_documento_control(){

    var id = $('#id').val();
    //var tipo_movimiento = $('#tipo_movimiento').val();

    var href = '/requerimiento/movimiento_pdf_requerimiento_control/'+id;
    window.open(href, '_blank');

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
                    <b>Control de Requerimiento</b>
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmControlRequerimiento" name="frmControlRequerimiento">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                    
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                    
                    <div class="row" style="padding-left:10px">

                        <div class="col-lg-2">
                            Tipo Documento
                        </div>
                        <div class="col-lg-2">
                            <input id="numero_requerimiento" name="numero_requerimiento" on class="form-control form-control-sm" style="background-color: transparent;" value="<?php echo $datos_requerimiento[0]->tipo_documento; ?>" type="text" disabled ="disabled">
                        </div>
                        <div class="col-lg-2">
                            N&uacute;mero Requerimiento
                        </div>
                        <div class="col-lg-2">
                            <input id="numero_requerimiento" name="numero_requerimiento" on class="form-control form-control-sm" style="background-color: transparent;" value="<?php echo $datos_requerimiento[0]->codigo; ?>" type="text" disabled ="disabled">
                        </div>
                        <div class="col-lg-2">
                            Fecha Requerimiento
                        </div>
                        <div class="col-lg-2">
                            <input id="fecha_requerimiento" name="fecha_requerimiento" on class="form-control form-control-sm" style="background-color: transparent;" value="<?php echo $datos_requerimiento[0]->fecha; ?>" type="text" disabled ="disabled">
                        </div>
                        <div class="col-lg-2">
                            Unidad Origen
                        </div>
                        <div class="col-lg-2">
                            <input id="unidad_origen" name="unidad_origen" on class="form-control form-control-sm" style="background-color: transparent;" value="<?php echo $datos_requerimiento[0]->unidad_origen; ?>" type="text" disabled ="disabled">
                        </div>
                        <div class="col-lg-2" id="almacen_" style="color:green; font-weight:bold">
                            Almacen Origen
                        </div>
                        <div class="col-lg-2" id="almacen_select">
                            <input id="unidad_origen" name="unidad_origen" on class="form-control form-control-sm" style="background-color: transparent;" value="<?php echo $datos_requerimiento[0]->almacen; ?>" type="text" disabled ="disabled">
                        </div>
                        <div class="col-lg-2" id="almacen_salida_" style="color:green; font-weight:bold">
                            Almacen Solicitante
                        </div>
                        <div class="col-lg-2" id="almacen_salida_select">
                            <input id="unidad_origen" name="unidad_origen" on class="form-control form-control-sm" style="background-color: transparent;" value="<?php echo $datos_requerimiento[0]->almacen; ?>" type="text" disabled ="disabled">
                        </div><div class="col-lg-2" id="almacen_salida_">
                            Responsable de Atenci&oacute;n
                        </div>
                        <div class="col-lg-2" id="almacen_salida_select">
                            <input id="unidad_origen" name="unidad_origen" on class="form-control form-control-sm" style="background-color: transparent;" value="<?php echo $datos_requerimiento[0]->reponsable_atencion; ?>" type="text" disabled ="disabled">
                        </div>
                        <div class="col-lg-2">
                            Estado Atenci&oacute;n
                        </div>
                        <div class="col-lg-2">
                            <input id="unidad_origen" name="unidad_origen" on class="form-control form-control-sm" style="background-color: transparent;" value="<?php echo $datos_requerimiento[0]->estado_atencion; ?>" type="text" disabled ="disabled">
                        </div>
                        <div class="col-lg-2">
                            Cerrado
                        </div>
                        <div class="col-lg-2">
                            <input id="unidad_origen" name="unidad_origen" on class="form-control form-control-sm" style="background-color: transparent;" value="<?php echo $datos_requerimiento[0]->cerrado; ?>" type="text" disabled ="disabled">
                        </div>
                    </div>
                    <div class="row" style="padding-left:10px">
                        <div class="col-lg-2">
                            Sustento Requerimiento
                        </div>
                        <div class="col-lg-10">
                            <textarea id="sustento_requerimiento" name="sustento_requerimiento" class="form-control form-control-sm" style="background-color: transparent;" disabled ="disabled" rows="2"><?php echo $datos_requerimiento[0]->sustento_requerimiento?></textarea>
                        </div>
                    </div>
                        <!--<div style="margin-top:15px" class="form-group">
                            <div class="col-sm-12 controls">
                                <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                    <a href="javascript:void(0)" onClick="agregarProducto()" class="btn btn-sm btn-success">Agregar</a>
                                </div>
                            </div>
                            
                        </div>-->
                        <div class="card-body">

					<div class="table-responsive">
						<table id="tblRequerimientoDetalle" class="table table-hover table-sm">
							<thead>
							<tr style="font-size:13px">
								<th>#</th>
								<th>Item</th>
								<th>Descripci&oacute;n</th>
								<th>Marca</th>
                                <th>COD. INT.</th>
                                <th>Estado Bien</th>
                                <th>Unidad</th>
                                <th>Cantidad Requerida</th>
                                <th>Cantidad Atendida</th>
                                <th>N° Orden Compra</th>
							</tr>
							</thead>
							<tbody id="divRequerimientoDetalle">
							</tbody>
						</table>
					</div>
                    <div style="margin-top:15px" class="form-group">
                        <div class="col-sm-12 controls">
                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                <?php 
                                    /*if($id>0){
                                ?>
                                <button style="font-size:12px;margin-left:10px;margin-right:10px" type="button" class="btn btn-sm btn-primary" data-toggle="modal" onclick="pdf_documento()" ><i class="fa fa-edit"></i>Imprimir</button>
                                <button style="font-size:12px;margin-right:10px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="save_orden_compra_requerimiento()" ><i class="fa fa-edit"></i>Generar Orden Compra</button>
                                <?php 
                                    }*/
                                ?>
                                <!--<a href="javascript:void(0)" onClick="fn_save_requerimiento()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>-->
                                <button style="font-size:12px;margin-left:10px;margin-right:10px" type="button" class="btn btn-sm btn-clasico btn-enviar" data-toggle="modal" onclick="pdf_documento_control()" >
                                    <i class="far fa-file-pdf" style="font-size:18px;"></i>Imprimir
                                </button>
                                <!--<a href="javascript:void(0)" onClick="cerrarModalRequerimiento()" class="btn btn-sm btn-info" style="">Cerrar</a>-->
                                <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-cerrar" data-toggle="modal" onclick="cerrarModalRequerimiento()">
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

