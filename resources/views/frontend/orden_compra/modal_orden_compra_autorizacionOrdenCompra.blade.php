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

.btn-fosforescente {
    background-color: #FFFF00 !important; /* Amarillo fosforescente */
    color: black; /* Texto negro */
    font-weight: bold;
    border: none !important; /* Elimina cualquier borde */
    outline: none; /* Evita bordes al hacer clic */
    transition: background-color 0.3s ease-in-out;
}

.btn-fosforescente:hover {
    background-color:  #E5D100 !important; /* Se oscurece un poco */
}

.fila-autorizacion {
    background-color: #f8d7da !important;
}


.fila-autorizacion input[readonly] {
    border: 1px solid #dc3545 !important;
    background-color: #ffcbcbff; /* un rosado muy suave */
}

.fila-autorizacion input,
.fila-autorizacion select {
    border: 1px solid #dc3545 !important;
    background-color: #fff5f5; /* un rosado muy suave */
}

.fila-autorizacion .select2-container--default .select2-selection--single {
    border: 1px solid #dc3545 !important;
    background-color: #fff5f5 !important;
    border-radius: 4px;
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

    $('#fecha_orden_compra').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    $('#fecha_vencimiento').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });
    
    obtenerDescuentoAutorizacion();
    obtenerFechaVencimiento();
    obtenerCanal();

    $("#item").select2({ width: '100%' });
    $("#ubicacion_fisica_seccion").select2({ width: '100%' });
    $("#ubicacion_fisica_anaquel").select2({ width: '100%' });
    $("#empresa_vende").select2({ width: '100%' });
    $("#empresa_compra").select2({ width: '100%' });
    $("#persona_compra").select2({ width: '100%' });
    

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

    cambiarCliente();
    obtenerPrioridad();

    if($('#id').val()>0){
        cargarDetalle();
        cambiarOrigen();
        obtenerEntradaSalida();
    }
});

function cambiarTipoCambio(){

    var moneda = $('#moneda').val();
    //alert(moneda);
    if(moneda==2){
        $('#tipo_cambio_dolar_, #tipo_cambio_dolar_input').show();
    }else if(moneda==1){
        $('#tipo_cambio_dolar_, #tipo_cambio_dolar_input').hide();
    }else{
        $('#tipo_cambio_dolar_, #tipo_cambio_dolar_input').hide();
    }
}

function cambiarOrigen(){

    var unidad_origen = $('#unidad_origen').val();

    //alert(moneda);
    if(unidad_origen==1){
        $('#proveedor_select, #proveedor_').hide();
        $('#almacen_select, #almacen_').show();
        $('#almacen_salida_select, #almacen_salida_').show();
    }else if(unidad_origen==2){
        $('#almacen_salida').val("");
        $('#proveedor_select, #proveedor_').show();
        $('#almacen_select, #almacen_').show();
        $('#almacen_salida_select, #almacen_salida_').hide();
        //$('#proveedor').val("");
    }else if(unidad_origen==3){
        $('#proveedor_select, #proveedor_').show();
        $('#almacen_select, #almacen_').show();
        $('#almacen_salida_select, #almacen_salida_').show();
        //$('#proveedor').val(30);
    }else if(unidad_origen==4){
        $('#almacen').val("");
        $('#proveedor_select, #proveedor_').show();
        $('#almacen_select, #almacen_').hide();
        $('#almacen_salida_select, #almacen_salida_').show();
        //$('#proveedor').val(30);
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
            $('#precio_unitario' + n).val(result[0].costo_unitario);
            
            /*if(result[0].bien_servicio == 2){
                $('#precio_unitario' + n).val(result[0].costo_unitario);
            }*/

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

function calcularSubTotal(input) {
    var fila = $(input).closest('tr');

    var cantidad_ingreso = parseFloat(fila.find('.cantidad_ingreso').val()) || 0;
    var precio_unitario = parseFloat(fila.find('.precio_unitario').val()) || 0;
    var valor_venta = parseFloat(fila.find('.valor_venta').val()) || 0;

    var sub_total = valor_venta;

    var igvInputId = fila.find('.igv').attr('id');
    var totalInputId = fila.find('.total').attr('id');

}

function calcularPrecioUnitario(input) {

    var fila = $(input).closest('tr');
    var igvPorcentaje = $('#igv_compra').val() == 2 ? 1.18 : 0;
    var precio_unitario_ = 0;
    var valor_venta_bruto = 0;
    var valor_venta = 0;
    var igv = 0;
    var total = 0;

    var precio_venta = parseFloat(fila.find('.precio_unitario').val()) || 0;
    var cantidad_ingreso = parseFloat(fila.find('.cantidad_ingreso').val()) || 0;
    var descuento = parseFloat(fila.find('.descuento').val()) || 0;
    var porcentaje = parseFloat(fila.find('.porcentaje').val()) || 0;

    if(igvPorcentaje==1.18){
        precio_unitario_ = precio_venta / igvPorcentaje;
    }else{
        precio_unitario_ = precio_venta
    }

    if(igvPorcentaje==1.18){
        valor_venta_bruto = (cantidad_ingreso * precio_venta) / igvPorcentaje;
    }else{
        valor_venta_bruto = cantidad_ingreso * precio_venta;
    }
    
    if(descuento!= "" || porcentaje != ""){
        if(descuento!= ""){
            valor_venta = valor_venta_bruto - descuento;
        }else if(porcentaje != ""){
            valor_venta = valor_venta_bruto - (valor_venta_bruto * (porcentaje / 100));
        }
    }else{
        valor_venta = valor_venta_bruto;
    }

    if(igvPorcentaje==1.18){
        igv = valor_venta * 0.18;
    }

    total = valor_venta + igv;

    fila.find('.precio_unitario_').val(precio_unitario_.toFixed(2));
    fila.find('.valor_venta_bruto').val(valor_venta_bruto.toFixed(2));
    fila.find('.valor_venta').val(valor_venta.toFixed(2));
    fila.find('.igv').val(igv.toFixed(2));
    fila.find('.sub_total').val(valor_venta.toFixed(2));
    fila.find('.total').val(total.toFixed(2));

    actualizarTotalGeneral();
}

function calcularPrecioUnitario_(input, decimales) {

    var fila = $(input).closest('tr');
    var igvPorcentaje = $('#igv_compra').val() == 2 ? 1.18 : 0;
    var precio_unitario_ = 0;
    var valor_venta_bruto = 0;
    var valor_venta = 0;
    var igv = 0;
    var total = 0;

    var precio_venta = parseFloat(fila.find('.precio_unitario').val()) || 0;
    var cantidad_ingreso = parseFloat(fila.find('.cantidad_ingreso').val()) || 0;
    var descuento = parseFloat(fila.find('.descuento').val()) || 0;
    var porcentaje = parseFloat(fila.find('.porcentaje').val()) || 0;

    if(igvPorcentaje==1.18){
        precio_unitario_ = precio_venta / igvPorcentaje;
    }else{
        precio_unitario_ = precio_venta
    }

    if(igvPorcentaje==1.18){
        valor_venta_bruto = (cantidad_ingreso * precio_venta) / igvPorcentaje;
    }else{
        valor_venta_bruto = cantidad_ingreso * precio_venta;
    }
    
    if(descuento!= "" || porcentaje != ""){
        if(descuento!= ""){
            valor_venta = valor_venta_bruto - descuento;
        }else if(porcentaje != ""){
            valor_venta = valor_venta_bruto - (valor_venta_bruto * (porcentaje / 100));
        }
    }else{
        valor_venta = valor_venta_bruto;
    }

    if(igvPorcentaje==1.18){
        igv = valor_venta * 0.18;
    }

    total = valor_venta + igv;

    fila.find('.precio_unitario_').val(precio_unitario_.toFixed(decimales));
    fila.find('.valor_venta_bruto').val(valor_venta_bruto.toFixed(decimales));
    fila.find('.valor_venta').val(valor_venta.toFixed(decimales));
    fila.find('.igv').val(igv.toFixed(decimales));
    fila.find('.sub_total').val(valor_venta.toFixed(decimales));
    fila.find('.total').val(total.toFixed(decimales));

    actualizarTotalGeneral_(decimales);
}

function calcularIGV(subTotal, igvInputId, totalInputId) {
    subTotal = parseFloat(subTotal) || 0;
    
    var igvPorcentaje = $('#igv_compra').val() == 2 ? 0.18 : 0;
    var igvValor = subTotal * igvPorcentaje;
    var total = subTotal + igvValor;

    if (!igvInputId || !totalInputId) {
        console.error("Error: Los IDs de IGV o Total no son válidos.");
        return;
    }
    
    $('#' + igvInputId).val(igvValor.toFixed(2));
    
    $('#' + totalInputId).val(total.toFixed(2));
}

function actualizarTotalGeneral() {
    var sub_totalGeneral = 0;
    var igv_totalGeneral = 0;
    var totalGeneral = 0;
    var descuentolGeneral = 0;
    
    $('#tblOrdenCompraDetalle tbody tr').each(function() {
        var sub_totalFila = parseFloat($(this).find('.sub_total').val()) || 0;
        var igv_totalFila = parseFloat($(this).find('.igv').val()) || 0;
        var totalFila = parseFloat($(this).find('.total').val()) || 0;
        var precioVentaFila = parseFloat($(this).find('.precio_unitario').val()) || 0;
        var descuentoFila = 0;
        var porcentajeFila = 0;
        var totalPorcentajeFila = 0;
        if($(this).find('.descuento').val()!=""){
            descuentoFila = parseFloat($(this).find('.descuento').val()) || 0;
        }else if($(this).find('.porcentaje').val()!=""){
            porcentajeFila = parseFloat($(this).find('.porcentaje').val()) || 0;
            totalPorcentajeFila = precioVentaFila * (porcentajeFila / 100);
        }
        
        sub_totalGeneral += sub_totalFila;
        igv_totalGeneral += igv_totalFila;
        totalGeneral += totalFila;
        descuentolGeneral += descuentoFila;
        descuentolGeneral += totalPorcentajeFila;
    });
    
    $('#sub_total_general').val(sub_totalGeneral.toFixed(2));
    $('#igv_general').val(igv_totalGeneral.toFixed(2));
    $('#total_general').val(totalGeneral.toFixed(2));
    $('#descuento_general').val(descuentolGeneral.toFixed(2));
}

function actualizarTotalGeneral_(decimales) {
    var sub_totalGeneral = 0;
    var igv_totalGeneral = 0;
    var totalGeneral = 0;
    var descuentolGeneral = 0;
    
    $('#tblOrdenCompraDetalle tbody tr').each(function() {
        var sub_totalFila = parseFloat($(this).find('.sub_total').val()) || 0;
        var igv_totalFila = parseFloat($(this).find('.igv').val()) || 0;
        var totalFila = parseFloat($(this).find('.total').val()) || 0;
        var precioVentaFila = parseFloat($(this).find('.precio_unitario').val()) || 0;
        var descuentoFila = 0;
        var porcentajeFila = 0;
        var totalPorcentajeFila = 0;
        if($(this).find('.descuento').val()!=""){
            descuentoFila = parseFloat($(this).find('.descuento').val()) || 0;
        }else if($(this).find('.porcentaje').val()!=""){
            porcentajeFila = parseFloat($(this).find('.porcentaje').val()) || 0;
            totalPorcentajeFila = precioVentaFila * (porcentajeFila / 100);
        }
        
        sub_totalGeneral += sub_totalFila;
        igv_totalGeneral += igv_totalFila;
        totalGeneral += totalFila;
        descuentolGeneral += descuentoFila;
        descuentolGeneral += totalPorcentajeFila;
    });
    
    $('#sub_total_general').val(sub_totalGeneral.toFixed(decimales));
    $('#igv_general').val(igv_totalGeneral.toFixed(decimales));
    $('#total_general').val(totalGeneral.toFixed(decimales));
    $('#descuento_general').val(descuentolGeneral.toFixed(decimales));
}

function aplicaDescuento(inputElement) {
    
    var fila = $(inputElement).closest('tr');
    var subtotalInput = fila.find('.sub_total');

    var descuentoEnSoles = parseFloat($(inputElement).val()) || 0;
    var subtotal = parseFloat(subtotalInput.val()) || 0; 

    if(descuentoEnSoles > 0 && descuentoEnSoles <= subtotal) {
        actualizarTotalGeneral();
    }else {
        calcularSubTotal(subtotalInput);
    }
}

function aplicaDescuentoEnSoles(inputElement) {
    var fila = $(inputElement).closest('tr');

    if (!fila.data('subtotal-original')) {
        fila.data('subtotal-original', parseFloat(fila.find('.sub_total').val()) || 0);
    }

    var subtotalOriginal = fila.data('subtotal-original');
    var descuentoEnSoles = parseFloat($(inputElement).val()) || 0;

    if (descuentoEnSoles >= 0 && descuentoEnSoles <= subtotalOriginal) {
        actualizarTotalGeneral();
    } else {
        fila.find('.sub_total').val(subtotalOriginal.toFixed(2));
    }
}

function aplicaDescuentoEnPorcentaje(inputElement) {
    
    var fila = $(inputElement).closest('tr');

    if (!fila.data('subtotal-original')) {
        fila.data('subtotal-original', parseFloat(fila.find('.sub_total').val()) || 0);
    }

    var subtotalOriginal = fila.data('subtotal-original');
    var descuentoEnSoles = parseFloat($(inputElement).val()) || 0;

    if (descuentoEnSoles >= 0 && descuentoEnSoles <= subtotalOriginal) {
        var nuevoSubTotal = subtotalOriginal - (subtotalOriginal*descuentoEnSoles/100);

        fila.find('.sub_total').val(nuevoSubTotal.toFixed(2));

        var igvInputId = fila.find('.igv').attr('id');
        var totalInputId = fila.find('.total').attr('id');
        calcularIGV(nuevoSubTotal, igvInputId, totalInputId);

        actualizarTotalGeneral();
    } else {
        fila.find('.sub_total').val(subtotalOriginal.toFixed(2));
    }
}

var productosSeleccionados = [];

function cargarDetalle(){

    var id = $("#id").val();
    var tipo_documento = $("#tipo_documento").val();
    var decimales = (tipo_documento == "1") ? 3 : 2;
    const tbody = $('#divOrdenCompraDetalle');

    tbody.empty();

    $.ajax({
        url: "/orden_compra/cargar_detalle/"+id,
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

                result.unidad_medida.forEach(unidad_medida => {
                    let selected = (unidad_medida.codigo == orden_compra.id_unidad_medida) ? 'selected' : '';
                    unidadMedidaOptions += `<option value="${unidad_medida.codigo}" ${selected}>${unidad_medida.denominacion}</option>`;
                });

                if (orden_compra.id_producto) {
                    productosSeleccionados.push(orden_compra.id_producto);
                }

                var stock_mostrar = (tipo_documento == 1) ? producto_stock.saldos_cantidad : producto_stock.stock_comprometido;

                const row = `
                    <tr class="${orden_compra.id_autorizacion == 1 ? 'fila-autorizacion' : ''}">
                        <td>${n}</td>
                        <td style="width: 400px !important;display:block"><input name="id_orden_compra_detalle[]" id="id_orden_compra_detalle${n}" class="form-control form-control-sm" value="${orden_compra.id}" type="hidden"><input name="id_autorizacion_detalle[]" id="id_autorizacion_detalle${n}" class="form-control form-control-sm" value="2" type="hidden"><select name="descripcion[]" id="descripcion${n}" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ${n});">${productoOptions}</select></td>
                        
                        <td><select name="marca[]" id="marca${n}" class="form-control form-control-sm">${marcaOptions}</select></td>
                        <td><input name="cod_interno[]" id="cod_interno${n}" class="form-control form-control-sm" value="${orden_compra.codigo}" type="text"></td>
                        <td><select name="unidad[]" id="unidad${n}" class="form-control form-control-sm">${unidadMedidaOptions}</select></td>
                        <td><input name="cantidad_ingreso[]" id="cantidad_ingreso${n}" class="cantidad_ingreso form-control form-control-sm" value="${orden_compra.cantidad_requerida}" type="text" oninput="calcularCantidadPendiente(this);calcularSubTotal(this);calcularPrecioUnitario(this)" readonly="readonly"></td>
                        <td><input name="precio_unitario[]" id="precio_unitario${n}" class="precio_unitario form-control form-control-sm" value="${parseFloat(orden_compra.precio_venta || 0).toFixed(decimales)}" type="text" oninput="limitarDecimalesYCalcular(this, ${decimales})" readonly="readonly"></td>
                        <td><input name="precio_unitario_[]" id="precio_unitario_${n}" class="precio_unitario_ form-control form-control-sm" value="${parseFloat(orden_compra.precio || 0).toFixed(decimales)}" type="text" oninput="calcularPrecioUnitario(this)" readonly="readonly"></td>
                        <td><input name="valor_venta_bruto[]" id="valor_venta_bruto${n}" class="valor_venta_bruto form-control form-control-sm" value="${parseFloat(orden_compra.valor_venta_bruto || 0).toFixed(decimales)}" type="text" oninput="calcularSubTotal(this)" readonly="readonly"></td>
                        
                        <td><div style="display: flex; align-items: center; gap: 5px;"> <button type="button" class="btn-custom" onclick="cambiarDescuento(this);calcularPrecioUnitario(this)" hidden><i class="${orden_compra.id_descuento == 2 ? 'fas fa-percentage' : 'fas fa-paint-brush'}"></i></button> <input name="descuento[]" id="descuento${n}" class="descuento form-control form-control-sm" placeholder="S/ Descuento" value="${parseFloat((orden_compra.descuento ?? 0) || 0).toFixed(decimales)}" type="text" oninput="aplicaDescuentoEnSoles(this);calcularPrecioUnitario(this)" style="display: ${(!orden_compra.id_descuento || orden_compra.id_descuento == 1 || orden_compra.descuento == null || orden_compra.descuento === "") ? 'block' : 'none'};"> <input name="porcentaje[]" id="porcentaje${n}" class="porcentaje form-control form-control-sm" placeholder="% Descuento" value="${parseFloat(orden_compra.id_descuento == 2 ? (orden_compra.descuento ?? 0) : 0).toFixed(decimales)}" type="text" oninput="aplicaDescuentoEnPorcentaje(this);calcularPrecioUnitario(this)" style="display: ${orden_compra.id_descuento == 2 ? 'block' : 'none'};"><input name="id_descuento[]" id="id_descuento${n}" type="hidden" value="${orden_compra.id_descuento ?? 1}"></div></td>
                        <td><input name="porcentaje_descuento[]" id="porcentaje_descuento${n}" class="porcentaje_descuento form-control form-control-sm" value="" type="text" oninput="" readonly="readonly"></td>

                        <td><input name="valor_venta[]" id="valor_venta${n}" class="valor_venta form-control form-control-sm" value="${parseFloat(orden_compra.valor_venta || 0).toFixed(decimales)}" type="text" oninput="calcularSubTotal(this)" readonly="readonly"></td>
                        <td><input name="sub_total[]" id="sub_total${n}" class="sub_total form-control form-control-sm" value="${parseFloat(orden_compra.sub_total || 0).toFixed(decimales) }" type="text" readonly="readonly"></td>
                        <td><input name="igv[]" id="igv${n}" class="igv form-control form-control-sm" value="${parseFloat(orden_compra.igv || 0).toFixed(decimales)}" type="text" readonly="readonly"></td>
                        <td><input name="total[]" id="total${n}" class="total form-control form-control-sm" value="${parseFloat(orden_compra.total || 0).toFixed(decimales)}" type="text" readonly="readonly"></td>

                    </tr>
                `;
                tbody.append(row);
                $('#descripcion' + n).select2({ 
                    width: '100%', 
                    dropdownCssClass: 'custom-select2-dropdown'
                });

                $('#marca' + n).select2({
                    width: '100%',
                });

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

                let descuentoMonto = 0;

                if (parseInt(orden_compra.id_descuento || 1) === 2) {
                    let pct = parseFloat(orden_compra.descuento || 0);
                    descuentoMonto = (pct / 100) * parseFloat(orden_compra.valor_venta_bruto || 0);
                } else {
                    descuentoMonto = parseFloat(orden_compra.descuento || 0);
                }

                let cantidadVal = parseFloat(orden_compra.cantidad_requerida || 1);

                let precioVentaUnitario = parseFloat(orden_compra.precio_venta || 0);
                let baseBrutoConIGV = precioVentaUnitario * cantidadVal;

                let porcentajeRelativoAlBruto = (baseBrutoConIGV > 0) ? (descuentoMonto / baseBrutoConIGV * 100) : 0;

                $(`#porcentaje_descuento${n}`).val(porcentajeRelativoAlBruto.toFixed(decimales));

                n++;

                sub_total_acumulado += parseFloat(orden_compra.sub_total || 0);
                igv_total_acumulado += parseFloat(orden_compra.igv || 0);
                descuento_total_acumulado += parseFloat(orden_compra.descuento || 0);
                descuento_total_acumulado += parseFloat(orden_compra.porcentaje || 0);
                total_acumulado += parseFloat(orden_compra.total || 0);

            });

            $('#sub_total_general').val(sub_total_acumulado.toFixed(decimales) || '0.00');
            $('#igv_general').val(igv_total_acumulado.toFixed(decimales) || '0.00');
            $('#descuento_general').val(descuento_total_acumulado.toFixed(decimales) || '0.00');
            $('#total_general').val(total_acumulado.toFixed(decimales) || '0.00');
        }
    });
}

function limitarDecimalesYCalcular(input, decimales) {
    input.value = input.value
        .replace(/[^0-9.]/g, '')
        .replace(/(\..*?)\..*/g, '$1')
        .replace(new RegExp('(\\d+\\.\\d{0,' + decimales + '}).*'), '$1');

    calcularSubTotal(input);
    calcularPrecioUnitario_(input, decimales);
}

function cambiarDescuento(button){

    var parent = button.parentElement;

    var porcentajeInput = parent.querySelector('.porcentaje');
    var descuentoInput = parent.querySelector('.descuento');
    var idDescuentoInput = parent.querySelector('[name="id_descuento[]"]');

    if (porcentajeInput.style.display == 'none' || porcentajeInput.style.display == '') {
        porcentajeInput.style.display = 'block';
        descuentoInput.style.display = 'none';
        idDescuentoInput.value = '2';
        button.innerHTML = '<i class="fas fa-percentage"></i>';
    } else {
        porcentajeInput.style.display = 'none';
        descuentoInput.style.display = 'block';
        idDescuentoInput.value = '1';
        button.innerHTML = '<i class="fas fa-paint-brush"></i>';
    }
}

function restaurarDescuento(button) {
    var parent = button.parentElement;

    var porcentajeInput = parent.querySelector('.porcentaje');
    porcentajeInput.style.display = 'none';

    var descuentoInput = parent.querySelector('.descuento');
    descuentoInput.style.display = 'block';

    button.innerHTML = '<i class="fas fa-paint-brush"></i>';
    button.onclick = function () {
        cambiarDescuento(button);
    };
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
            obtenerStock(selectElement, rowIndex);
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

function obtenerDescuentoAutorizacion(){

    var id_user = $('#id_user').val();

    $.ajax({
        url: "/orden_compra/obtener_descuento_usuario/"+id_user,
        dataType: "json",
        success: function(result){

            $('#id_descuento_usuario').val(result[0].descuento);
            //alert(result[0].descuento);
            
        }
    });
}

function fn_save_autorizacion_orden_compra(){
	
    var msg = "";

    var id_descuento_usuario = $('#id_descuento_usuario').val();
    var descuento_num = parseFloat(id_descuento_usuario.replace('%', '')) / 100;

    $('#tblOrdenCompraDetalle tbody tr').each(function(index, fila){
        var filaIndex = index + 1;

        var valorVentaBruto = parseFloat($(fila).find('.valor_venta_bruto').val()) || 0;
        var descuentoFila   = parseFloat($(fila).find('.descuento').val()) || 0;
        var descripcion = $(fila).find('select[name="descripcion[]"] option:selected').text();

        var precio_unitario = parseFloat($(fila).find('.precio_unitario').val()) || 0;
        var cantidad_ingreso = parseFloat($(fila).find('.cantidad_ingreso').val()) || 0;

        var precio_total = precio_unitario * cantidad_ingreso;

        var descuentoPermitidoFila = precio_total * descuento_num;

        if(descuentoFila > descuentoPermitidoFila){
            msg += "El producto " + descripcion + " supera el m&aacute;ximo de Descuento permitido <br>";
            
            $('#id_autorizacion_detalle'+filaIndex).val(1);

            $('#id_autorizacion').val(1);
            
        }
    });

    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

    $.ajax({
        url: "/orden_compra/send_orden_compra_autorizacion",
        type: "POST",
        data : $("#frmAutorizacionOrdenCompra").serialize(),
        success: function (result) {
            datatablenew();
            $('.loader').hide();
            if (msg !== "") {
                bootbox.alert(msg, function () {
                    bootbox.alert("Se guard&oacute; satisfactoriamente", function () {
                        if (result.id > 0) {
                            modalOrdenCompraAutorizacion(result.id);
                        }
                    });
                });
            } else {
                bootbox.alert("Se guard&oacute; satisfactoriamente", function () {
                    if (result.id > 0) {
                        modalOrdenCompraAutorizacion(result.id);
                    }
                });
            }
        }
    });
}

function obtenerCodigo(){

    var tipo_documento = $('#tipo_documento').val();
    
    if(tipo_documento==1){
        $('#empresa_compra').val('30').trigger('change');
        $('#empresa_vende').val('').trigger('change');
        $('#label_numero_orden_compra_matriz').hide();
        $('#input_numero_orden_compra_matriz').hide();
        $('#numero_orden_compra_matriz').val('');
    }else if(tipo_documento==2){
        $('#empresa_compra').val('').trigger('change');
        $('#empresa_vende').val('30').trigger('change');
        $('#label_numero_orden_compra_matriz').hide();
        $('#input_numero_orden_compra_matriz').hide();
        $('#numero_orden_compra_matriz').val('');
    }else if(tipo_documento==4){
        $('#label_numero_orden_compra_matriz').show();
        $('#input_numero_orden_compra_matriz').show();
    }else{
        $('#label_numero_orden_compra_matriz').hide();
        $('#input_numero_orden_compra_matriz').hide();
        $('#numero_orden_compra_matriz').val('');
    }
}

$('#moneda').on('change', function(){

    var descripcion = $('#moneda option:selected').text();

    $('#moneda_descripcion').val(descripcion);

});

function obtenerEntradaSalida(){

    $('#label_entrada_salida').hide();
    $('#input_entrada_salida').hide();
    var id_orden_compra = $('#id').val();
    var tipo_documento = $('#tipo_documento').val();

    $.ajax({
        url: "/orden_compra/obtener_entrada_salida/"+id_orden_compra+"/"+tipo_documento,
        type: "GET",
        success: function (result) {

            var codigoDocumento = result[0].codigo;

            $('#label_entrada_salida').show();
            $('#input_entrada_salida').show();

            $('#numero_entrada_salida').val(codigoDocumento);

        }
	});
}

function obtenerPrioridad(){

    $('#prioridad_label').hide();
    $('#prioridad_select').hide();
    var vendedor = $('#id_vendedor').val();

    if(vendedor==35){
        $('#prioridad_label').show();
        $('#prioridad_select').show();
    }
}

function obtenerDescuento(){

    var id_vendedor = $('#id_vendedor').val();

    $.ajax({
        url: "/orden_compra/obtener_descuento/"+id_vendedor,
        type: "GET",
        success: function (result) {

            var usuario_descuento = result[0].descuento;

            $('#id_descuento_usuario').val(usuario_descuento);

        }
	});
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
    var tipo_documento = $('#tipo_documento').val();
    
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
            
            if(tipo_documento == 1){
                $('#stock_actual' + n).val(producto_stock.saldos_cantidad);
            }else{
                $('#stock_actual' + n).val(producto_stock.stock_comprometido);
            }
        }
    });
}

function obtenerFechaVencimiento(){

    var tipo_documento = $('#tipo_documento').val();

    if(tipo_documento == 2){
        $('#label_fecha_vencimiento').show();
        $('#input_fecha_vencimiento').show();
    } else {
        $('#label_fecha_vencimiento').hide();
        $('#input_fecha_vencimiento').hide();
        $('#fecha_vencimiento').val('');
    }
}

function obtenerOrdenCompraMatriz(){

    var numero_orden_compra_matriz = $('#numero_orden_compra_matriz').val();

    $.ajax({
        url: "/orden_compra/obtener_orden_compra_matriz/"+numero_orden_compra_matriz,
        dataType: "json",
        success: function(result){
            
            if (result.length > 0) {
                var orden_compra_matriz = result[0];

                $('#tipo_documento_cliente').val(orden_compra_matriz.id_tipo_cliente).trigger('change');
                $('#empresa_compra').val(orden_compra_matriz.id_empresa_compra).trigger('change');
                $('#empresa_vende').val(orden_compra_matriz.id_empresa_vende).trigger('change');
                $('#persona_compra').val(orden_compra_matriz.id_persona).trigger('change');
                $('#unidad_origen').val(orden_compra_matriz.id_unidad_origen).trigger('change');
                $('#almacen_salida').val(orden_compra_matriz.id_almacen_salida);
                $('#almacen').val(orden_compra_matriz.id_almacen_destino);
                $('#igv_compra').val(orden_compra_matriz.igv_compra);
                $('#id_vendedor').val(orden_compra_matriz.id_vendedor);
                $('#numero_orden_compra_cliente').val(orden_compra_matriz.numero_orden_compra_cliente);
            } else {
                bootbox.alert('No se encontró la orden de compra matriz');
            }
        }
    });
}

function obtenerCanal(){

    var tipo_documento = $('#tipo_documento').val();

    if(tipo_documento == 2){
        $('#label_canal').show();
        $('#select_canal').show();
    } else {
        $('#label_canal').hide();
        $('#select_canal').hide();
        $('#canal').val('');
    }
}

function obtenerBeneficiario(){

    var canal = $('#canal').val();

    if(canal == 1){
        $('#tipo_documento_cliente').val(1);
        cambiarCliente();
        $('#label_empresa_compra').show();
        $('#select_empresa_compra').show();
    } else {
        $('#tipo_documento_cliente').val(5);
        cambiarCliente();
    }
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
                    <b>Orden de Compra y Venta</b>
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmAutorizacionOrdenCompra" name="frmAutorizacionOrdenCompra">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                    
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                    <input type="hidden" name="id_descuento_usuario" id="id_descuento_usuario" value="<?php echo $id_descuento_usuario?>">
                    <input type="hidden" name="id_autorizacion" id="id_autorizacion" value="2">
                    <input type="hidden" name="id_user" id="id_user" value="<?php echo $id_user?>">
                    
                    <div class="row" style="padding-left:10px">

                        <div class="col-lg-2">
                            Tipo Documento
                        </div>
                        <div class="col-lg-2">
                            <select name="tipo_documento" id="tipo_documento" class="form-control form-control-sm" onchange="obtenerCodigo(); obtenerFechaVencimiento(); obtenerCanal()">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($tipo_documento as $row){?>
                                    <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$orden_compra->id_tipo_documento)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2" id="label_canal">
                            Canal
                        </div>
                        <div class="col-lg-2" id="select_canal">
                            <select name="canal" id="canal" class="form-control form-control-sm" onchange="obtenerBeneficiario()">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($canal as $row){?>
                                    <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$orden_compra->id_canal)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div id="label_numero_orden_compra_matriz" class="col-lg-2" @if($orden_compra->id_tipo_documento != 4) style="display:none;" @endif>
                            N&uacute;mero Orden Compra Matriz
                        </div>
                        <div id="input_numero_orden_compra_matriz" class="col-lg-2" @if($orden_compra->id_tipo_documento != 4) style="display:none;" @endif>
                            <input id="numero_orden_compra_matriz" name="numero_orden_compra_matriz" on class="form-control form-control-sm"  value="" type="text" onchange="obtenerOrdenCompraMatriz()">
                        </div>
                        <div class="col-lg-2">
                            N&uacute;mero Orden Compra
                        </div>
                        <div class="col-lg-2">
                            <input id="numero_orden_compra" name="numero_orden_compra" on class="form-control form-control-sm"  value="<?php if($id>0){echo $orden_compra->numero_orden_compra;}?>" type="text" readonly ="readonly">
                        </div>
                        <div class="col-lg-2">
                            Empresa Vende
                        </div>
                        <div class="col-lg-2">
                            <select name="empresa_vende" id="empresa_vende" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($proveedor as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php if($row->id==$orden_compra->id_empresa_vende)echo "selected='selected'"?>><?php echo $row->razon_social ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
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
                        <div class="col-lg-2">
                            Fecha Orden Compra
                        </div>
                        <div class="col-lg-2">
                            <input id="fecha_orden_compra" name="fecha_orden_compra" on class="form-control form-control-sm"  value="<?php echo isset($orden_compra) && $orden_compra->fecha_orden_compra ? $orden_compra->fecha_orden_compra : date('Y-m-d'); ?>" type="text">
                        </div>
                        <div id="label_fecha_vencimiento" class="col-lg-2" @if($orden_compra->id_tipo_documento != 2) style="display:none;" @endif>
                            Fecha Vencimiento
                        </div>
                        <div id="input_fecha_vencimiento" class="col-lg-2" @if($orden_compra->id_tipo_documento != 2) style="display:none;" @endif>
                            <input id="fecha_vencimiento" name="fecha_vencimiento" class="form-control form-control-sm" type="text" value="{{ $orden_compra->fecha_vencimiento ?? '' }}" placeholder="YYYY-MM-DD">
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
                        /*if($orden_compra->id_empresa_compra==30 && $orden_compra->id_empresa_vende==30){
                            $origen=3;
                        }else if($orden_compra->id_empresa_compra==30){
                            $origen=2;
                        }else if($orden_compra->id_empresa_vende==30){
                            $origen=1;
                        }else{
                            $origen=null;
                        }*/
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
                        <div class="col-lg-2" id="almacen_select">
                            <select name="almacen" id="almacen" class="form-control form-control-sm" onchange="//actualizarSecciones(this)">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($almacen as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php if($row->id==$orden_compra->id_almacen_destino)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
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
                            Moneda
                        </div>
                        <div class="col-lg-2">
                            <select name="moneda" id="moneda" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($moneda as $row){?>
                                    <option value="<?php echo $row->codigo; ?>" <?php echo ($id > 0 && $row->codigo == $orden_compra->id_moneda) ? "selected='selected'" : (($row->codigo == 1) ? "selected='selected'" : ""); ?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                            <input name="moneda_descripcion" id="moneda_descripcion" type="hidden">
                        </div>
                        <div class="col-lg-2" id="label_entrada_salida">
                            N&uacute;mero Entrada/Salida
                        </div>
                        <div class="col-lg-2" id="input_entrada_salida">
                            <input id="numero_entrada_salida" name="numero_entrada_salida" style="color:red; font-weight:bold" on class="form-control form-control-sm"  value="<?php echo $orden_compra->numero_orden_compra_cliente;?>" type="text" readonly="readonly">
                        </div>

                        <div class="col-lg-2">
                            Vendedor
                        </div>
                        <div class="col-lg-2">
                            <select name="id_vendedor" id="id_vendedor" class="form-control form-control-sm" onchange="obtenerPrioridad(); obtenerDescuento()">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($vendedor as $row){?>
                                    <option value="<?php echo $row->id; ?>"<?php if($row->id==$orden_compra->id_vendedor)echo "selected='selected'"?>><?php echo $row->name ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                            <!--<input name="moneda_descripcion" id="moneda_descripcion" type="hidden">-->
                        </div>

                        <div class="col-lg-2" id="prioridad_label">
                            Prioridad
                        </div>
                        <div class="col-lg-2" id="prioridad_select">
                            <select name="prioridad" id="prioridad" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($prioridad as $row){?>
                                    <option value="<?php echo $row->codigo; ?>"<?php if($row->codigo==$orden_compra->id_prioridad)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                            <input name="moneda_descripcion" id="moneda_descripcion" type="hidden">
                        </div>

                        <div class="col-lg-2" id="label_entrada_salida">
                            Observaci&oacute;n
                        </div>
                        <div class="col-lg-2" id="input_entrada_salida">
                            <textarea id="observacion_vendedor" name="observacion_vendedor" class="form-control form-control-sm"><?php echo $orden_compra->observacion_vendedor?></textarea>
                        </div>

                    </div>
                        <!--<div style="margin-top:15px" class="form-group">
                            <div class="col-sm-12 controls">
                                <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                <?php //if($id_user==$orden_compra->id_usuario_inserta && $orden_compra->cerrado == 1 ){?>
                                    <a href="javascript:void(0)" onClick="agregarProducto()" class="btn btn-sm btn-success">Agregar</a>
                                <?php //}?>
                                <?php //if($id==0){?>
                                    <a href="javascript:void(0)" onClick="agregarProducto()" class="btn btn-sm btn-success">Agregar</a>
                                <?php //}?>
                                </div>
                            </div>
                        </div>-->

                        <div class="card-body" style="padding-right: 0px !important; padding-left: 0px !important;">	

					<div class="table-responsive" style="overflow-y: auto; max-height: 350px;">
						<table id="tblOrdenCompraDetalle" class="table table-hover table-sm">
							<thead>
							<tr style="font-size:13px">
								<th>#</th>
								<th>Descripci&oacute;n</th>
								<th>Marca</th>
                                <th>COD. INT.</th>
                                <th>Unidad</th>
                                <th>Cantidad</th>
                                <!--<th>Stock Disponible</th>-->
                                <th>Precio Venta</th>
                                <th>Precio Unitario</th>
                                <th>Valor Venta Bruto</th>
                                <th>Valor Descuento</th>
                                <th>Porcentaje Descuento</th>
                                <th>Valor Venta</th>
                                <th>Sub Total</th>
                                <th>IGV</th>
                                <th>Total</th>
							</tr>
							</thead>
							<tbody id="divOrdenCompraDetalle">
							</tbody>
						</table>
					</div>
                    <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; width: 100%; margin: 0 auto; font-size:12px">
                        <tbody>
                            <tr>
                                <td class="td" style ="text-align: left; width: 5%; font-size:13px"><b>Sub-Total:</b></td>
                                <td id="subTotalGeneral" class="td" style="text-align: left; width: 10%; font-size:13px">
                                    <input type="text" name="sub_total_general" id="sub_total_general" class="form-control" value="0.00" readonly style="border: none; background: transparent; text-align: left; pointer-events: none;">
                                </td>
                                <td class="td" style ="text-align: left; width: 10%; font-size:13px"></td>
                                <td class="td" style ="text-align: left; width: 5%; font-size:13px"><b>IGV Total:</b></td>
                                <td id="igvGeneral" class="td" style="text-align: left; width: 10%; font-size:13px">
                                    <input type="text" name="igv_general" id="igv_general" class="form-control" value="0.00" readonly style="border: none; background: transparent; text-align: left; pointer-events: none;">
                                </td>
                                <td class="td" style ="text-align: left; width: 10%; font-size:13px"></td>
                                <td class="td" style ="text-align: left; width: 5%; font-size:13px"><b>Descuento Total:</b></td>
                                <td id="descuentoGeneral" class="td" style="text-align: left; width: 5%; font-size:13px">
                                    <input type="text" name="descuento_general" id="descuento_general" class="form-control" value="0.00" readonly style="border: none; background: transparent; text-align: left; pointer-events: none;">
                                </td>
                                <td class="td" style ="text-align: left; width: 10%; font-size:13px"></td>
                                <td class="td" style ="text-align: left; width: 5%; font-size:13px"><b>Total:</b></td>
                                <td id="totalGeneral" class="td" style="text-align: left; width: 10%; font-size:13px">
                                    <input type="text" name="total_general" id="total_general" class="form-control" value="0.00" readonly style="border: none; background: transparent; text-align: left; pointer-events: none;">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="margin-top:15px" class="form-group">
                        <div class="col-sm-12 controls">
                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                <?php if($orden_compra->id_autorizacion == 1){?>
                                <a href="javascript:void(0)" onClick="fn_save_autorizacion_orden_compra()" class="btn btn-sm btn-success" style="margin-right:10px">Autorizar</a>
                                <?php }?>
                                <a href="javascript:void(0)" onClick="$('#openOverlayOpc').modal('hide');" class="btn btn-sm btn-info" style="margin-left:10px;">Cerrar</a>
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

