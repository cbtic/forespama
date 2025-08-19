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
    max-width:80%!important
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
		container: '#openOverlayOpc modal-body'
     });
	 
});

$(document).ready(function() {
    if($('#id').val()==0){
        obtenerCodigo();
    }

    if($('#id').val()>0){
        cargarDetalle();
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
    const tbody = $('#divOrdenProduccionDetalle');

    tbody.empty();

    $.ajax({
        url: "/orden_produccion/cargar_detalle_orden_produccion/"+id,
        type: "GET",
        success: function (result) {

            let n = 1;

            var total_acumulado=0;

            result.orden_produccion.forEach(orden_produccion => {

                let productoOptions = '<option value="">--Seleccionar--</option>';
                let unidadMedidaOptions = '<option value="">--Seleccionar--</option>';
                
                result.producto.forEach(producto => {
                    let selected = (producto.id == orden_produccion.id_producto) ? 'selected' : '';
                    productoOptions += `<option value="${producto.id}" ${selected}>${producto.codigo} - ${producto.denominacion}</option>`;
                });
                result.unidad_medida.forEach(unidad_medida => {
                    let selected = (unidad_medida.codigo == orden_produccion.id_unidad_producto) ? 'selected' : '';
                    unidadMedidaOptions += `<option value="${unidad_medida.codigo}" ${selected}>${unidad_medida.denominacion}</option>`;
                });

                if (orden_produccion.id_producto) {
                    productosSeleccionados.push(orden_produccion.id_producto);
                }
                
                let cantidad = parseFloat(orden_produccion.cantidad || 0);

                const row = `
                    <tr>
                        <td>${n}</td>
                        <td style="width: 760px !important;display:block"><input name="id_orden_produccion_detalle[]" id="id_orden_produccion_detalle${n}" class="form-control form-control-sm" value="${orden_produccion.id}" type="hidden"><input name="descripcion[]" id="descripcion${n}" class="form-control form-control-sm" value="${orden_produccion.id_producto}" type="hidden"><select name="descripcion_[]" id="descripcion_${n}" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ${n});" disabled>${productoOptions}</select></td>
                        <td><input name="codigo[]" id="codigo${n}" class="form-control form-control-sm" value="${orden_produccion.codigo}" type="text" readonly></td>
                        <td><input name="unidad[]" id="unidad${n}" class="form-control form-control-sm" value="${orden_produccion.id_unidad_producto}" type="hidden"><select name="unidad_[]" id="unidad_${n}" class="form-control form-control-sm" disabled>${unidadMedidaOptions}</select></td>
                        <td><input name="cantidad_pendiente[]" id="cantidad_pendiente${n}" class="cantidad_ingreso form-control form-control-sm" value="${orden_produccion.cantidad}" type="text" oninput="" readonly></td>
                        <td><input name="cantidad_atendida[]" id="cantidad_atendida${n}" class="cantidad_ingreso form-control form-control-sm" value="${orden_produccion.cantidad-orden_produccion.cantidad_atendida}" type="text" oninput=""></td>
                        
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button></td>
                    </tr>
                `;
                tbody.append(row);
                $('#descripcion_' + n).select2({ 
                    width: '100%', 
                    dropdownCssClass: 'custom-select2-dropdown'
                });

                n++;
            });
        }
    });
}

function eliminarFila(button){
    $(button).closest('tr').remove();
    //actualizarTotalGeneral();
}

function save_orden_compra_orden_produccion(){
	
    var msg = "";

    var fecha_produccion = $('#fecha_produccion').val();
    var almacen_origen = $('#almacen_origen').val();
    var almacen_destino = $('#almacen_destino').val();

    if(fecha_produccion == ""){msg+="Ingrese la Fecha de Fabricacion <br>";}
    if(almacen_origen == ""){msg+="Ingrese el Almacen Origen <br>";}
    if(almacen_destino == ""){msg+="Ingrese el Almacen Destino <br>";}

    if ($('#tblOrdenProduccionDetalle tbody tr').length == 0) {
        msg += "No se ha agregado ningún producto <br>";
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
            url: "/orden_produccion/send_orden_produccion_orden_compra",
            type: "POST",
            data : $("#frmAtenderOrdenProduccion").serialize(),
            success: function (result) {
                datatablenew();
                $('.loader').hide();
                bootbox.alert("Se guard&oacute; satisfactoriamente");
                $('#openOverlayOpc').modal('hide');
            }
        });
    }
}

function cerrar_orden_produccion(){

    var id = $('#id').val();

    $.ajax({
        url: "/orden_produccion/cerrar_orden_produccion/"+id,
        type: "GET",
        success: function (result) {
            datatablenew();
            //$('.loader').hide();
            $('#openOverlayOpc').modal('hide');
        }
    });
}

function obtenerCodigo(){

    var tipo_documento = $('#tipo_documento').val();

    $.ajax({
        url: "/requerimiento/obtener_codigo_requerimiento/"+tipo_documento,
        dataType: "json",
        success: function (result) {

            $('#numero_requerimiento').val(result[0].codigo);

        }
    });
}

function pdf_documento(){

    var id = $('#id').val();

    var href = '/requerimiento/movimiento_pdf_requerimiento/'+id;
    window.open(href, '_blank');

}

function cerrarModalAtenderOrdenProduccion(){

    $('#openOverlayOpc').modal('hide');

    datatablenew();
}

</script>

<body class="hold-transition skin-blue sidebar-mini">
    
    <div>
		<div class="justify-content-center">

            <div class="card">
                <div style="text-align: center; font-size:16px; margin-top: 20px">
                    <b>Orden Fabricaci&oacute;n</b>
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmAtenderOrdenProduccion" name="frmAtenderOrdenProduccion">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                        
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                        
                        <div class="row" style="padding-left:10px">

                            <div class="col-lg-2">
                                N&uacute;mero Orden Fabricaci&oacute;n
                            </div>
                            <div class="col-lg-2">
                                <input id="numero_orden_fabricacion" name="numero_orden_fabricacion" on class="form-control form-control-sm"  value="<?php if($id>0){echo $orden_produccion->codigo;}?>" type="text" readonly ="readonly">
                            </div>
                            <div class="col-lg-2">
                                Fecha Producci&oacute;n
                            </div>
                            <div class="col-lg-2">
                                <input id="fecha_produccion" name="fecha_produccion" on class="form-control form-control-sm"  value="<?php echo isset($orden_produccion) && $orden_produccion->fecha_produccion ? $orden_produccion->fecha_produccion : date('Y-m-d'); ?>" type="text">
                            </div>
                            <div class="col-lg-2">
                                &Aacute;rea
                            </div>
                            <div class="col-lg-2">
                            <select name="area" id="area" class="form-control form-control-sm" onchange="" disabled>
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($area as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php if($row->id==$orden_produccion->id_area)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        </div>
                        <div class="row" style="padding-left:10px">
                            <div class="col-lg-2" style="color:red; font-weight:bold">
                                Almacen Origen
                            </div>
                            <div class="col-lg-2">
                                <select name="almacen_origen" id="almacen_origen" class="form-control form-control-sm" onchange="">
                                    <option value="">--Seleccionar--</option>
                                    <?php 
                                    foreach ($almacen as $row){?>
                                        <option value="<?php echo $row->id ?>"><?php echo $row->denominacion ?></option>
                                        <?php 
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2" style="color:green; font-weight:bold">
                                Almacen Destino
                            </div>
                            <div class="col-lg-2">
                                <select name="almacen_destino" id="almacen_destino" class="form-control form-control-sm" onchange="">
                                    <option value="">--Seleccionar--</option>
                                    <?php 
                                    foreach ($almacen as $row){?>
                                        <option value="<?php echo $row->id ?>"><?php echo $row->denominacion ?></option>
                                        <?php 
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="padding-left:10px">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Observaci&oacute;n</label>
                                    <textarea id="observacion" name="observacion" class="form-control form-control-sm"><?php //echo $orden_compra_pago->observacion?></textarea>
                                </div>
                            </div>
                        </div>
                        <!--<div class="row" style="padding-left:10px">
                            <div class="col-lg-2">
                                Sustento Requerimiento
                            </div>
                            <div class="col-lg-10">
                                <textarea id="sustento_requerimiento" name="sustento_requerimiento" class="form-control form-control-sm" rows="2"><?php //echo $requerimiento->sustento_requerimiento?></textarea>
                            </div>
                        </div>
                            <div style="margin-top:15px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                        <a href="javascript:void(0)" onClick="agregarProducto()" class="btn btn-sm btn-success">Agregar</a>
                                    </div>
                                </div>
                            </div>-->

                            <div class="card-body">

                        <div class="table-responsive">
                            <table id="tblOrdenProduccionDetalle" class="table table-hover table-sm">
                                <thead>
                                <tr style="font-size:13px">
                                    <th>#</th>
                                    <th>Descripci&oacute;n</th>
                                    <th style="width : 10%">CODIGO</th>
                                    <th style="width : 10%">Unidad</th>
                                    <th style="width : 10%">Cantidad</th>
                                    <th style="width : 10%">Cantidad Pendiente</th>
                                </tr>
                                </thead>
                                <tbody id="divOrdenProduccionDetalle">
                                </tbody>
                            </table>
                        </div>
                        <div style="margin-top:15px" class="form-group">
                            <div class="col-sm-12 controls">
                                <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                    <?php 
                                        if($id>0){
                                    ?>
                                    <!--<button style="font-size:12px;margin-left:10px;margin-right:20px" type="button" class="btn btn-sm btn-primary" data-toggle="modal" onclick="pdf_documento()" ><i class="fa fa-edit"></i> Imprimir</button>-->
                                    
                                    <button style="font-size:12px;margin-right:20px" type="button" class="btn btn-sm btn-danger" data-toggle="modal" onclick="cerrar_orden_produccion()" ><i class="fa fa-edit"></i> Cerrar Orden Fabricaci&oacute;n</button>

                                    <button style="font-size:12px;margin-right:20px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="save_orden_compra_orden_produccion()" ><i class="fa fa-edit"></i> Generar Orden Compra</button>

                                    <?php 
                                        }
                                    ?>
                                    <!--<a href="javascript:void(0)" onClick="fn_save_requerimiento()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>-->
                                    <a href="javascript:void(0)" onClick="cerrarModalAtenderOrdenProduccion()" class="btn btn-sm btn-info" style="">Cerrar</a>
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

<div id="openOverlayOpc2" class="modal fade modal-observacion" tabindex="-1" role="dialog">
	  <div class="modal-dialog" >
	
		<div id="id_content_OverlayoneOpc" class="modal-content" style="padding: 0px;margin: 0px">
		
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

