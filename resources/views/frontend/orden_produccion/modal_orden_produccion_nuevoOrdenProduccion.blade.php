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
    max-height: 90vh; /*El alto que necesitemos**/
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

.btn-custom {
    background-color: #fff; /* Fondo blanco */
    border: 1px solid #ccc; /* Borde gris */
    border-radius: 4px; /* Bordes redondeados */
    padding: 5px 8px; /* Espaciado interno */
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); /* Sombra */
}

.btn-custom i {
    color: #e74c3c; /* Rojo para el ícono */
    font-size: 16px; /* Tamaño del ícono */
}

.btn-custom:hover {
    background-color: #f8f9fa; /* Fondo ligeramente gris al pasar el cursor */
    border-color: #bbb;
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
    
    if($('#id').val() == 0){
        cargarDetalle();
    }else{
        cargarDetalleGuardado();
    }

    $('#area').select2({ width : '100%'})

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
            $('#marca' + n).val(result[0].id_marca).trigger('change');
            $('#unidad' + n).val(result[0].id_unidad_producto);
            
        }
    });
}

var productosSeleccionados = [];

function cargarDetalle(){

    var id = $("#id").val();
    const tbody = $('#divOrdenProduccionDetalle');

    tbody.empty();

    $.ajax({
        url: "/orden_produccion/cargar_detalle",
        type: "GET",
        success: function (result) {

            let n = 1;

            result.orden_produccion.forEach(orden_produccion => {

                let productoOptions = '<option value="">--Seleccionar--</option>';
                let unidadMedidaOptions = '<option value="">--Seleccionar--</option>';

                result.producto.forEach(producto => {
                    let selected = (producto.id == orden_produccion.id) ? 'selected' : '';
                    productoOptions += `<option value="${producto.id}" ${selected}>${producto.codigo} - ${producto.denominacion}</option>`;
                });

                result.unidad_medida.forEach(unidad_medida => {
                    let selected = (unidad_medida.codigo == orden_produccion.id_unidad_medida) ? 'selected' : '';
                    unidadMedidaOptions += `<option value="${unidad_medida.codigo}" ${selected}>${unidad_medida.denominacion}</option>`;
                });
                
                if (orden_produccion.id) {
                    productosSeleccionados.push(orden_produccion.id);
                }

                const row = `
                    <tr>
                        <td>${n}</td>
                        <td style="width: 800px !important;display:block"><input name="id_producto[]" id="id_producto${n}" class="form-control form-control-sm" value="${orden_produccion.id}" type="hidden"><select name="descripcion[]" id="descripcion${n}" class="form-control form-control-sm" onChange="">${productoOptions}</select></td>
                        <td><input name="cod_interno[]" id="cod_interno${n}" class="form-control form-control-sm" value="${orden_produccion.codigo}" type="text"></td>
                        
                        <td><select name="unidad[]" id="unidad${n}" class="form-control form-control-sm">${unidadMedidaOptions}</select></td>
                        <td><input name="cantidad_ingreso[]" id="cantidad_ingreso${n}" class="cantidad_ingreso form-control form-control-sm" value="${orden_produccion.cantidad_total}" type="text" readonly></td>
                        
                        <td><input name="cantidad_producir[]" id="cantidad_producir${n}" class="cantidad_producir form-control form-control-sm" value="" type="text"></td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button></td>

                    </tr>
                `;

                tbody.append(row);
                $('#descripcion' + n).select2({ 
                    width: '100%', 
                    dropdownCssClass: 'custom-select2-dropdown'
                });

                n++;
            });
        }
    });
}

function cargarDetalleGuardado(){

    var id = $("#id").val();
    const tbody = $('#divOrdenProduccionDetalle');

    tbody.empty();

    $.ajax({
        url: "/orden_produccion/cargar_detalle_guardado/"+id,
        type: "GET",
        success: function (result) {

            let n = 1;

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
                
                if (orden_produccion.id) {
                    productosSeleccionados.push(orden_produccion.id);
                }

                const row = `
                    <tr>
                        <td>${n}</td>
                        <td style="width: 800px !important;display:block"><input name="id_producto[]" id="id_producto${n}" class="form-control form-control-sm" value="${orden_produccion.id}" type="hidden"><select name="descripcion[]" id="descripcion${n}" class="form-control form-control-sm" onChange="">${productoOptions}</select></td>
                        <td><input name="cod_interno[]" id="cod_interno${n}" class="form-control form-control-sm" value="${orden_produccion.codigo}" type="text"></td>
                        
                        <td><select name="unidad[]" id="unidad${n}" class="form-control form-control-sm">${unidadMedidaOptions}</select></td>
                        <td><input name="cantidad_ingreso[]" id="cantidad_ingreso${n}" class="cantidad_ingreso form-control form-control-sm" value="" type="text" readonly></td>
                        
                        <td><input name="cantidad_producir[]" id="cantidad_producir${n}" class="cantidad_producir form-control form-control-sm" value="${orden_produccion.cantidad}" type="text"></td>
                        
                    </tr>
                `;

                tbody.append(row);
                $('#descripcion' + n).select2({ 
                    width: '100%', 
                    dropdownCssClass: 'custom-select2-dropdown'
                });

                n++;
            });
        }
    });
}

function agregarProducto(){

    var opcionesDescripcion = `<?php
        echo '<option value="">--Seleccionar--</option>';
        foreach ($producto as $row) {
            echo '<option value="' . htmlspecialchars($row->id, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($row->codigo . ' - ' . $row->denominacion, ENT_QUOTES, 'UTF-8') . '</option>';
        }
    ?>`;

    var cantidad = 1;
    var newRow = "";
    for (var i = 0; i < cantidad; i++) { 
        var n = $('#tblOrdenProduccionDetalle tbody tr').length + 1;
        var descripcion = '<input name="id_producto_detalle[]" id="id_producto_detalle${n}" class="form-control form-control-sm" value="${orden_produccion.id}" type="hidden"><select name="descripcion[]" id="descripcion' + n + '" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ' + n + '); obtenerCodInterno(this, ' + ');">' + opcionesDescripcion +' </select>';
        var descripcion_ant = '<input type="hidden" name="descripcion_ant[]" id="descripcion_ant' + n + '" class="form-control form-control-sm" />';
        
        var cod_interno = '<input name="cod_interno[]" id="cod_interno' + n + '" class="form-control form-control-sm" value="" type="text">';
        var unidad = '<select name="unidad[]" id="unidad' + n + '" class="form-control form-control-sm" onChange=""> <option value="">--Seleccionar--</option> <?php foreach ($unidad as $row) {?> <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option> <?php } ?> </select>';
        var cantidad_comprometida = '<input name="cantidad_comprometida[]" id="cantidad_comprometida' + n + '" class="cantidad_comprometida form-control form-control-sm" value="0" type="text" readonly>';
        var cantidad_producir = '<input name="cantidad_producir[]" id="cantidad_producir' + n + '" class="form-control form-control-sm" value="" type="text">';
        
        var btnEliminar = '<button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button>';

        newRow += '<tr>';
        newRow += '<td>' + n + '</td>';
        newRow += '<td style="width: 400px!important; display:block!important">' +descripcion_ant + descripcion + '</td>';
        newRow += '<td>' + cod_interno + '</td>';
        newRow += '<td>' + unidad + '</td>';
        newRow += '<td>' + cantidad_comprometida + '</td>';
        newRow += '<td>' + cantidad_producir + '</td>';
        newRow += '<td>' + btnEliminar + '</td>';
        newRow += '</tr>';

        $('#tblOrdenProduccionDetalle tbody').append(newRow);

        $('#descripcion' + n).select2({
            width: '100%',
            dropdownCssClass: 'custom-select2-dropdown',
        });
    }
}

function verificarProductoSeleccionado(selectElement, rowIndex, valor) {
    var selectedValue = $(selectElement).val();

    if (selectedValue) {
        var selectedValueAnt = $("#descripcion_ant"+rowIndex).val();
        if(selectedValueAnt != ""){
            const index_ant = productosSeleccionados.indexOf(Number(selectedValueAnt));
            console.log(index_ant);
            productosSeleccionados.splice(index_ant, 1);
            $("#descripcion_ant"+rowIndex).val("");
        }

        if (!productosSeleccionados.includes(Number(selectedValue))) {
            productosSeleccionados.push(Number(selectedValue));
            $("#descripcion_ant"+rowIndex).val(selectedValue);

            obtenerCodInterno(selectElement, rowIndex);
        } else {
            bootbox.alert("Este producto ya ha sido seleccionado. Por favor elige otro.");
            $(selectElement).val('').trigger('change');
        }
    } else {
        
        const index = productosSeleccionados.indexOf(Number(selectedValue));
        if (index > -1) {
            productosSeleccionados.splice(index, 1);
        }
    }

    console.log(productosSeleccionados);
}

function eliminarFila(button){

    $(button).closest('tr').remove();
    
}

function limpiar(){
	$('#id').val("0");
	$('#id_tipo_documento').val("");
	$('#denominacion').val("");
	$('#img_foto').val("");
}

function fn_save_orden_produccion(){
	
    var msg = "";

    var fecha_orden_produccion = $('#fecha_orden_produccion').val();
    var area = $('#area').val();

    if(fecha_orden_produccion==""){msg+="Ingrese la Fecha de la Orden de Produccion <br>";}
    if(area==""){msg+="Ingrese un Area <br>";}

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
            url: "/orden_produccion/send_orden_produccion",
            type: "POST",
            data : $("#frmOrdenFabricacion").serialize(),
            success: function (result) {

                datatablenew();
                $('.loader').hide();
                bootbox.alert("Se guard&oacute; satisfactoriamente");
                if (result.id>0) {
                    modalOrdenProduccion(result.id);
                }
            }
        });
    }
}

function pdf_documento(){

    var id = $('#id').val();

    var href = '/orden_produccion/movimiento_pdf/'+id;
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
                    <b>Orden de Fabricaci&oacute;n</b>
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmOrdenFabricacion" name="frmOrdenFabricacion">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                    
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                    
                    <div class="row" style="padding-left:10px">

                        <div class="col-lg-2">
                            N&uacute;mero Orden Fabricacion
                        </div>
                        <div class="col-lg-2">
                            <input id="numero_orden_produccion" name="numero_orden_produccion" on class="form-control form-control-sm"  value="<?php if($id>0){echo $orden_produccion->codigo;}?>" type="text" readonly ="readonly">
                        </div>
                        
                        <div class="col-lg-2">
                            Fecha Orden Fabricaci&oacute;n
                        </div>
                        <div class="col-lg-2">
                            <input id="fecha_orden_produccion" name="fecha_orden_produccion" on class="form-control form-control-sm"  value="<?php echo isset($orden_produccion) && $orden_produccion->fecha_orden_produccion ? $orden_produccion->fecha_orden_produccion : date('Y-m-d'); ?>" type="text">
                        </div>
                        <div class="col-lg-2">
                            &Aacute;rea
                        </div>
                        <div class="col-lg-2">
                            <select name="area" id="area" class="form-control form-control-sm" onchange="">
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
                        <div style="margin-top:15px" class="form-group">
                            <div class="col-sm-12 controls">
                                <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                <?php if($id==0){?>
                                    <a href="javascript:void(0)" onClick="agregarProducto()" class="btn btn-sm btn-success">Agregar</a>
                                <?php }?>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">

					<div class="table-responsive" style="overflow-y: auto; max-height: 600px;">
						<table id="tblOrdenProduccionDetalle" class="table table-hover table-sm">
							<thead>
							<tr style="font-size:13px">
								<th>#</th>
								<th>Descripci&oacute;n</th>
                                <th>COD. INT.</th>
                                <th>Unidad</th>
                                <th>Cantidad Comprometida</th>
                                <th>Cantidad Producir</th>
							</tr>
							</thead>
							<tbody id="divOrdenProduccionDetalle">
							</tbody>
						</table>
					</div>
                    <div style="margin-top:15px" class="form-group">
                        <div class="col-sm-12 controls">
                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                
                                <button style="font-size:12px;margin-left:10px;margin-right:10px" type="button" class="btn btn-sm btn-primary" data-toggle="modal" onclick="pdf_documento()" ><i class="fa fa-edit"></i>Imprimir</button>
                                
                                <?php //if($id_user==$orden_compra->id_usuario_inserta){?>
                                    <!--<a href="javascript:void(0)" onClick="fn_save_orden_compra()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>-->
                                <?php //}?>
                                <?php if($id==0){?>
                                    <a href="javascript:void(0)" onClick="fn_save_orden_produccion()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>
                                <?php }?>
                                <a href="javascript:void(0)" onClick="$('#openOverlayOpc').modal('hide');" class="btn btn-sm btn-info" style="">Cerrar</a>
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

<div id="openOverlayOpc3" class="modal fade modal-datos_pedido" tabindex="-1" role="dialog">
    <div class="modal-dialog" >

        <div id="id_content_OverlayoneOpc3" class="modal-content" style="padding: 0px;margin: 0px">
        
            <div class="modal-body" style="padding: 0px;margin: 0px">

                <div id="diveditpregOpc3"></div>

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

