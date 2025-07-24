<title>FORESPAMA</title>

<style>

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

.modal-tienda .modal-dialog {
    width: 65% !important;
}

.modal-tienda .modal-body {
    height: auto !important;
}

.modal-datos_pedido .modal-dialog {
    width: 65% !important;
}

.modal-datos_pedido .modal-body {
    height: auto !important;
}

.custom-select2-dropdown {
    width: 700px !important; 
}

#tablemodal{
    border-spacing: 0;
    display: flex;
    max-height: 80vh;
    overflow-y: auto;
    overflow-x: hidden;
    table-layout: fixed;
    width: 98vw;
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

.btn-custom {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 5px 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
}

.btn-custom i {
    color: #e74c3c;
    font-size: 16px;
}

.btn-custom:hover {
    background-color: #f8f9fa;
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

$(document).ready(function() {

    $('#fecha_orden_compra').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    $("#empresa_compra").select2({ width: '100%' });
    $("#persona_compra").select2({ width: '100%' });
    
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

    cambiarCliente();

    if($('#id').val()>0){
        cargarDetalle();
        cambiarOrigen();
    }
});

function cambiarOrigen(){

    var unidad_origen = $('#unidad_origen').val();

    if(unidad_origen==1){
        $('#proveedor_select, #proveedor_').hide();
        $('#almacen_select, #almacen_').show();
        $('#almacen_salida_select, #almacen_salida_').show();
    }else if(unidad_origen==2){
        $('#almacen_salida').val("");
        $('#proveedor_select, #proveedor_').show();
        $('#almacen_select, #almacen_').show();
        $('#almacen_salida_select, #almacen_salida_').hide();
    }else if(unidad_origen==3){
        $('#proveedor_select, #proveedor_').show();
        $('#almacen_select, #almacen_').show();
        $('#almacen_salida_select, #almacen_salida_').show();
    }else if(unidad_origen==4){
        $('#almacen').val("");
        $('#proveedor_select, #proveedor_').show();
        $('#almacen_select, #almacen_').hide();
        $('#almacen_salida_select, #almacen_salida_').show();
    }else{
        $('#proveedor_select, #proveedor_').hide();
        $('#almacen_select, #almacen_').show();
        $('#almacen_salida_select, #almacen_salida_').show();
    }
}

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
            
            if(result[0].bien_servicio == 2){
                $('#precio_unitario' + n).val(result[0].costo_unitario);
            }

            $('#fecha_vencimiento_' + n).datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                changeMonth: true,
                changeYear: true,
                language: 'es'
            });
            
        }
    });

    obtenerStock(selectElement, n);
}

function obtenerCodigo(selectElement){

    var selectedOption = selectElement.options[selectElement.selectedIndex];
    var codigo = selectedOption.text.split('-')[0].trim();

    selectedOption.text = codigo;

}

function calcularCantidadPendiente(input) {

    var fila = $(input).closest('tr');
    var cantidad_ingreso = parseFloat(fila.find('.cantidad_ingreso').val()) || 0;
    var cantidad_compra = parseFloat(fila.find('.cantidad_compra').val()) || 0;

    var cantidad_pendiente = cantidad_compra - cantidad_ingreso;

    fila.find('.cantidad_pendiente').val(cantidad_pendiente.toFixed(2));
}

var productosSeleccionados = [];

function cargarDetalle(){

    var id = $("#id").val();
    const tbody = $('#divOrdenCompraDetalle');

    tbody.empty();

    $.ajax({
        url: "/orden_compra/cargar_detalle_control_produccion/"+id,
        type: "GET",
        success: function (result) {

            let n = 1;

            var sub_total_acumulado=0;
            var igv_total_acumulado=0;
            var total_acumulado=0;
            var descuento_total_acumulado=0;

            result.orden_compra.forEach(orden_compra => {

                let marcaOptions = '<option value="">--Seleccionar--</option>';
                let productoOptions = '<option value="">--Seleccionar--</option>';
                let estadoBienOptions = '<option value="">--Seleccionar--</option>';
                let unidadMedidaOptions = '<option value="">--Seleccionar--</option>';
                var producto_stock = result.producto_stock[orden_compra.id_producto];

                result.marca.forEach(marca => {
                    let selected = (marca.id == orden_compra.id_marca) ? 'selected' : '';
                    marcaOptions += `<option value="${marca.id}" ${selected}>${marca.denominiacion}</option>`;
                });

                result.producto.forEach(producto => {
                    let selected = (producto.id == orden_compra.id_producto) ? 'selected' : '';
                    productoOptions += `<option value="${producto.id}" ${selected}>${producto.codigo} - ${producto.denominacion}</option>`;
                });

                result.estado_bien.forEach(estado_bien => {
                    let selected = (estado_bien.codigo == orden_compra.id_estado_producto) ? 'selected' : '';
                    estadoBienOptions += `<option value="${estado_bien.codigo}" ${selected}>${estado_bien.denominacion}</option>`;
                });

                result.unidad_medida.forEach(unidad_medida => {
                    let selected = (unidad_medida.codigo == orden_compra.id_unidad_medida) ? 'selected' : '';
                    unidadMedidaOptions += `<option value="${unidad_medida.codigo}" ${selected}>${unidad_medida.denominacion}</option>`;
                });

                if (orden_compra.id_producto) {
                    productosSeleccionados.push(orden_compra.id_producto);
                }

                let cantidad_ingreso = parseFloat(orden_compra.cantidad_requerida);
                let stock_actual = parseFloat(producto_stock.stock_comprometido);
                let stock_comprometido = orden_compra.comprometido;

                let boton_comprometer;

                if(stock_comprometido == 1){
                    boton_comprometer = `<button type="button" class="btn btn-success btn-sm" disabled>Comprometer Stock</button>`;
                }else{
                    if (cantidad_ingreso < stock_actual) {
                        boton_comprometer = `<button type="button" class="btn btn-warning btn-sm" onclick="comprometerStock(this)">Comprometer Stock</button>`;
                    } else {
                        boton_comprometer = `<button type="button" class="btn btn-warning btn-sm" disabled>Comprometer Stock</button>`;
                    }
                }

                const row = `
                    <tr>
                        <td>${n}</td>
                        <td><input name="id_orden_compra_detalle[]" id="id_orden_compra_detalle${n}" class="id_orden_compra_detalle form-control form-control-sm" value="${orden_compra.id}" type="hidden"><input name="item[]" id="item${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${orden_compra.item}" type="text" readonly="readonly"></td>
                        
                        <td style="width: 400px !important;display:block"><input name="descripcion[]" id="descripcion${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${orden_compra.nombre_producto}" type="text" readonly="readonly"></td>
                        <<td><input name="marca[]" id="marca${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${orden_compra.marca}" type="text" readonly="readonly"></td>
                        <td><input name="cod_interno[]" id="cod_interno${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${orden_compra.codigo}" type="text" readonly="readonly"></td>
                        <td><input name="estado_bien[]" id="estado_bien${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${orden_compra.estado_producto}" type="text" oninput="" readonly="readonly"></td>
                        <td><input name="unidad[]" id="unidad${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${orden_compra.unidad_medida}" type="text" oninput="" readonly="readonly"></td>
                        <td><input name="cantidad_ingreso[]" id="cantidad_ingreso${n}" class="cantidad_ingreso form-control form-control-sm" style="border: none; background-color: transparent;" value="${orden_compra.cantidad_requerida}" type="text" oninput="" readonly="readonly"></td>
                        <td><input name="stock_actual[]" id="stock_actual${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${producto_stock.stock_comprometido}" type="text" readonly="readonly"></td>
                        <td style="width:150px">
                            ${boton_comprometer}
                        </td>

                    </tr>
                `;

                tbody.append(row);
                
                $('#fecha_fabricacion_' + n).datepicker({
                    autoclose: true,
                    format: 'yyyy-mm-dd',
                    changeMonth: true,
                    changeYear: true,
                    language: 'es'
                });

                $('#fecha_vencimiento_' + n).datepicker({
                    autoclose: true,
                    format: 'yyyy-mm-dd',
                    changeMonth: true,
                    changeYear: true,
                    language: 'es'
                });

                n++;

            });

        }
    });
}

function comprometerStock(input){

    var fila = $(input).closest('tr');
    var id_orden_compra_detalle = parseFloat(fila.find('.id_orden_compra_detalle').val()) || 0;

    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
    
    $.ajax({
        url: "/orden_compra/send_comprometer_stock/"+id_orden_compra_detalle,
        type: "GET",
        success: function (result) {
            //$('#openOverlayOpc').modal('hide');
            $('.loader').hide();
            bootbox.alert("Se guardó satisfactoriamente", function () {

                cargarDetalle();
                datatablenew();
            });
        }
    });
}

function fn_save_orden_compra(){
	
    var msg = "";

    var tipo_documento = $('#tipo_documento').val();
    var empresa_vende = $('#empresa_vende').val();
    var igv_compra = $('#igv_compra').val();

    if(tipo_documento==""){msg+="Ingrese el Tipo de Documento <br>";}
    if(empresa_vende==""){msg+="Ingrese la Empresa que Vende <br>";}
    if(igv_compra==""){msg+="Ingrese el IGV <br>";}

    if ($('#tblOrdenCompraDetalle tbody tr').length == 0) {
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
            url: "/orden_compra/send_orden_compra",
            type: "POST",
            data : $("#frmOrdenCompra").serialize(),
            success: function (result) {
                datatablenew();
                $('.loader').hide();
                bootbox.alert("Se guard&oacute; satisfactoriamente"); 
                if (result.id>0) {
                    modalOrdenCompra(result.id);
                }
            }
        });
    }
}

function cambiarCliente(){

    var tipo_documento_cliente = $('#tipo_documento_cliente').val();

    $('#label_empresa_compra').hide();
    $('#select_empresa_compra').hide();
    $('#label_persona_compra').hide();
    $('#select_persona_compra').hide();

    if(tipo_documento_cliente==1){

        $('#label_empresa_compra').hide();
        $('#select_empresa_compra').hide();
        $('#label_persona_compra').show();
        $('#select_persona_compra').show();
        
    }else if(tipo_documento_cliente==5){

        $('#label_empresa_compra').show();
        $('#select_empresa_compra').show();
        $('#label_persona_compra').hide();
        $('#select_persona_compra').hide();
        
    }
}

function obtenerStock(selectElement, n){

    var id_producto = $(selectElement).val();
    var unidad_origen = $('#unidad_origen').val();
    var almacen = "";

    if(unidad_origen==1){
        almacen = $('#almacen_salida').val();
    }else if(unidad_origen==2){
        almacen = $('#almacen').val();
    }else if(unidad_origen==3){
        almacen = $('#almacen_salida').val();
    }else if(unidad_origen==4){
        almacen = $('#almacen_salida').val();
    }

    $.ajax({
        url: "/productos/obtener_stock_producto/"+almacen+"/"+id_producto,
        dataType: "json",
        success: function(result){

            var producto_stock = result.producto_stock[id_producto];
            
            $('#stock_actual' + n).val(producto_stock.saldos_cantidad);
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
                <!--<div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <img width="200px" height="80px" style="top:-30px" src="/img/logo_forestalpama.jpg">
                    </div>
                </div>-->
                <div style="text-align: center; font-size:16px; margin-top: 20px">
                    <b>Control Produccion de Orden de Venta</b>
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmOrdenCompraProduccionControl" name="frmOrdenCompraProduccionControl">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                    
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                    
                    <div class="row" style="padding-left:10px">

                        <div class="col-lg-2">
                            N&uacute;mero Orden Compra
                        </div>
                        <div class="col-lg-2">
                            <input id="numero_orden_compra" name="numero_orden_compra" on class="form-control form-control-sm"  value="<?php if($id>0){echo $orden_compra->numero_orden_compra;}?>" type="text" readonly ="readonly">
                        </div>
                        <div class="col-lg-2">
                            Tipo Documento Cliente
                        </div>
                        <div class="col-lg-2">
                            <select name="tipo_documento_cliente" id="tipo_documento_cliente" class="form-control form-control-sm" onchange="cambiarCliente()">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($tipo_documento_cliente as $row){?>
                                    <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$orden_compra->id_tipo_cliente)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2" id="label_empresa_compra">
                            Empresa Compra
                        </div>
                        <div class="col-lg-2" id="select_empresa_compra">
                            <select name="empresa_compra" id="empresa_compra" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($proveedor as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php if($row->id==$orden_compra->id_empresa_compra)echo "selected='selected'"?>><?php echo $row->razon_social ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2" id="label_persona_compra">
                            Persona Compra
                        </div>
                        <div class="col-lg-2" id="select_persona_compra">
                            <select name="persona_compra" id="persona_compra" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($persona as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php if($row->id==$orden_compra->id_persona)echo "selected='selected'"?>><?php echo $row->nombres .' '. $row->apellido_paterno .' '. $row->apellido_materno  ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            Fecha Orden Compra
                        </div>
                        <div class="col-lg-2">
                            <input id="fecha_orden_compra" name="fecha_orden_compra" on class="form-control form-control-sm"  value="<?php echo isset($orden_compra) && $orden_compra->fecha_orden_compra ? $orden_compra->fecha_orden_compra : date('Y-m-d'); ?>" type="text">
                        </div>
                        <div class="col-lg-2">
                            N&uacute;mero Orden Compra Cliente
                        </div>
                        <div class="col-lg-2">
                            <input id="numero_orden_compra_cliente" name="numero_orden_compra_cliente" on class="form-control form-control-sm"  value="<?php echo $orden_compra->numero_orden_compra_cliente;?>" type="text">
                        </div>
                        <div class="col-lg-2">
                            Unidad Origen
                        </div>
                        <?php
                        ?>
                        <div class="col-lg-2">
                            <select name="unidad_origen" id="unidad_origen" class="form-control form-control-sm" onchange="cambiarOrigen()">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($unidad_origen as $row){?>
                                    <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$orden_compra->id_unidad_origen)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2" id="almacen_salida_" style="color:green; font-weight:bold">
                            Almacen Origen
                        </div>
                        <div class="col-lg-2" id="almacen_salida_select">
                            <select name="almacen_salida" id="almacen_salida" class="form-control form-control-sm" onchange="//actualizarSecciones(this)">
                                <option value="">--Seleccionar--</option>
                                <?php 
                                foreach ($almacen as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php if($row->id==$orden_compra->id_almacen_salida)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2" id="almacen_" style="color:red; font-weight:bold">
                            Almacen Destino
                        </div>
                        <div class="col-lg-2">
                            Aplica IGV
                        </div>
                        <div class="col-lg-2">
                            <select name="igv_compra" id="igv_compra" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($igv_compra as $row){?>
                                    <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$orden_compra->igv_compra)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            Vendedor
                        </div>
                        <div class="col-lg-2">
                            <select name="id_vendedor" id="id_vendedor" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($vendedor as $row){?>
                                    <option value="<?php echo $row->id; ?>"<?php if($row->id==$orden_compra->id_vendedor)echo "selected='selected'"?>><?php echo $row->name ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="card-body">	

					<div class="table-responsive" style="overflow-y: auto; max-height: 400px;">
						<table id="tblOrdenCompraDetalle" class="table table-hover table-sm">
							<thead>
							<tr style="font-size:13px">
								<th>#</th>
								<th>Item</th>
								<th>Descripci&oacute;n</th>
								<th>Marca</th>
                                <th>COD. INT.</th>
                                <th>Estado Bien</th>
                                <th>Unidad</th>
                                <th>Cantidad</th>
                                <th>Stock Disponible</th>
							</tr>
							</thead>
							<tbody id="divOrdenCompraDetalle">
							</tbody>
						</table>
					</div>
                    <div style="margin-top:15px" class="form-group">
                        <div class="col-sm-12 controls">
                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                <!--<a href="javascript:void(0)" onClick="fn_save_orden_compra()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>
                                <a href="javascript:void(0)" onClick="$('#openOverlayOpc').modal('hide');" class="btn btn-sm btn-info" style="">Cerrar</a>-->
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

	$('#ruc_').blur(function () {
		var id = $('#id').val();
			if(id==0) {
				validaRuc(this.value);
			}
	});
});


</script>
