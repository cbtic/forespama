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

    $("#item").select2({ width: '100%' });
    $("#ubicacion_fisica_seccion").select2({ width: '100%' });
    $("#ubicacion_fisica_anaquel").select2({ width: '100%' });
    $("#empresa_vende").select2({ width: '100%' });
    $("#empresa_compra").select2({ width: '100%' });
    

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
    /*if($('#id').val()==0){
        cambiarTipoCambio();
        cambiarOrigen();
    }*/

    if($('#id').val()>0){
        cargarDetalle();
        cambiarOrigen();
        //obtenerEntradaSalida();
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

function obtenerAnaquel(selectElement){

    var fila = $(selectElement).closest('tr');
    var id =  $(selectElement).val();

    $.ajax({
            url: "/lotes/obtener_anaquel_seccion/"+id,
            dataType: "json",
            success: function (result) {

                var option = "<option value=''>--Seleccionar--</option>";
                //$('#ubicacion_fisica_anaquel').html("");
                var anaquelSelect = fila.find('select[name="ubicacion_fisica_anaquel[]"]');
                anaquelSelect.html("");
                $(result).each(function (ii, oo) {
                    option += "<option value='"+oo.id+"'>"+oo.anaquel+"</option>";
                });
                //$('#ubicacion_fisica_anaquel').html(option);
                anaquelSelect.html(option); 
                //$('#seccion').attr("disabled",false);
                                
            }
    });

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

    //fila.find('.sub_total').val(sub_total.toFixed(2));

    var igvInputId = fila.find('.igv').attr('id');
    var totalInputId = fila.find('.total').attr('id');

    //console.log('IGV ID:', igvInputId);
    //console.log('Total ID:', totalInputId);

    //calcularIGV(sub_total, igvInputId, totalInputId, valor_venta);

    //actualizarTotalGeneral();
}

function calcularPrecioUnitario(input) {

    var fila = $(input).closest('tr');
    var igvPorcentaje = 1.18;
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

    //var igvInputId = fila.find('.igv').attr('id');
    //var totalInputId = fila.find('.total').attr('id');

    //console.log('IGV ID:', igvInputId);
    //console.log('Total ID:', totalInputId);

    //calcularIGV(sub_total, igvInputId, totalInputId);

    actualizarTotalGeneral();
}

function calcularIGV(subTotal, igvInputId, totalInputId) {
    subTotal = parseFloat(subTotal) || 0;
    
    var igvPorcentaje = $('#igv_compra').val() == 2 ? 0.18 : 0;
    //var valor_venta = parseFloat(fila.find('.valor_venta').val()) || 0;
    //alert(valor_venta);
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
   
    $('#tblDevolucionDetalle tbody tr').each(function() {
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

function aplicaDescuento(inputElement) {
    
    var fila = $(inputElement).closest('tr');
    var subtotalInput = fila.find('.sub_total');

    var descuentoEnSoles = parseFloat($(inputElement).val()) || 0;
    var subtotal = parseFloat(subtotalInput.val()) || 0; 

    if(descuentoEnSoles > 0 && descuentoEnSoles <= subtotal) {
        /*var nuevo_sub_total = subtotal - descuentoEnSoles;

        subtotalInput.val(nuevo_sub_total.toFixed(2));

        var igvInputId = fila.find('.igv').attr('id');
        var totalInputId = fila.find('.total').attr('id');
        calcularIGV(nuevo_sub_total, igvInputId, totalInputId);*/

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
        /*var nuevoSubTotal = subtotalOriginal - descuentoEnSoles;

        fila.find('.sub_total').val(nuevoSubTotal.toFixed(2));

        var igvInputId = fila.find('.igv').attr('id');
        var totalInputId = fila.find('.total').attr('id');
        calcularIGV(nuevoSubTotal, igvInputId, totalInputId);*/

        actualizarTotalGeneral();
    } else {
        // Si el descuento es inválido, recalcula el subtotal original
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
        // Si el descuento es inválido, recalcula el subtotal original
        fila.find('.sub_total').val(subtotalOriginal.toFixed(2));
    }
}

$('#almacen').change(function() {
    
    var almacenElement = this;
    
    $('#tblOrdenCompraDetalle tbody tr').each(function(index, row) {
        var n = index + 1;
        actualizarSecciones(almacenElement, n);
    });
});

function actualizarSecciones(selectElement, n) {
    //var id_almacen = $('#almacen').val();
    var id_almacen = $(selectElement).val();

    //alert(id_almacen);

    $.ajax({
        url: "/lotes/obtener_seccion_almacen/"+id_almacen,
        dataType: "json",
        success: function (result) {

            var option = "<option value=''>--Seleccionar--</option>";

            var ubicacionFisicaSeccion = $('#ubicacion_fisica_seccion' + n);
            //console.log(ubicacionFisicaSeccion);
            ubicacionFisicaSeccion.html("");

            $(result).each(function (ii, oo) {
                option += "<option value='" + oo.id + "'>" + oo.codigo_seccion + "-" + oo.seccion + "</option>";
            });

            ubicacionFisicaSeccion.html(option);
        }
    });
}

var productosSeleccionados = [];

function cargarDetalle(){

    var id = $("#id").val();
    var id_tipo_documento = $("#id_tipo_documento").val();
    const tbody = $('#divDevolucionDetalle');

    tbody.empty();

    $.ajax({
        url: "/devolucion/cargar_detalle/"+id+"/"+id_tipo_documento,
        type: "GET",
        success: function (result) {

            let n = 1;

            var sub_total_acumulado=0;
            var igv_total_acumulado=0;
            var total_acumulado=0;
            var descuento_total_acumulado=0;

            result.devolucion.forEach(devolucion => {

                let marcaOptions = '<option value="">--Seleccionar--</option>';
                let productoOptions = '<option value="">--Seleccionar--</option>';
                let estadoBienOptions = '<option value="">--Seleccionar--</option>';
                let unidadMedidaOptions = '<option value="">--Seleccionar--</option>';
                //let descuentoOptions = '<option value="">--Seleccionar--</option>';

                result.marca.forEach(marca => {
                    let selected = (marca.id == devolucion.id_marca) ? 'selected' : '';
                    marcaOptions += `<option value="${marca.id}" ${selected}>${marca.denominiacion}</option>`;
                });

                result.producto.forEach(producto => {
                    let selected = (producto.id == devolucion.id_producto) ? 'selected' : '';
                    productoOptions += `<option value="${producto.id}" ${selected}>${producto.codigo} - ${producto.denominacion}</option>`;
                });

                result.unidad_medida.forEach(unidad_medida => {
                    let selected = (unidad_medida.codigo == devolucion.id_um) ? 'selected' : '';
                    unidadMedidaOptions += `<option value="${unidad_medida.codigo}" ${selected}>${unidad_medida.denominacion}</option>`;
                });

                /*result.descuento.forEach(descuento => {
                    let selected = (descuento.codigo == orden_compra.id_descuento) ? 'selected' : '';
                    descuentoOptions += `<option value="${descuento.codigo}" ${selected}>${descuento.denominacion}</option>`;
                });*/

                if (devolucion.id_producto) {
                    productosSeleccionados.push(devolucion.id_producto);
                }

                const row = `
                    <tr>
                        <td>${n}</td>
                        <td style="width: 450px !important;display:block"><input name="id_devolucion_detalle[]" id="id_devolucion_detalle${n}" class="form-control form-control-sm" value="${devolucion.id}" type="hidden"><select name="descripcion[]" id="descripcion${n}" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ${n});">${productoOptions}</select></td>
                        
                        <td><select name="marca[]" id="marca${n}" class="form-control form-control-sm">${marcaOptions}</select></td>
                        <td><input name="cod_interno[]" id="cod_interno${n}" class="form-control form-control-sm" value="${devolucion.codigo}" type="text"></td>
                        <td><select name="unidad[]" id="unidad${n}" class="form-control form-control-sm">${unidadMedidaOptions}</select></td>
                        <td><input name="cantidad_ingreso[]" id="cantidad_ingreso${n}" class="cantidad_ingreso form-control form-control-sm" value="${devolucion.cantidad}" type="text" oninput="calcularSubTotal(this);calcularPrecioUnitario(this)"></td>
                        <td><input name="precio_unitario[]" id="precio_unitario${n}" class="precio_unitario form-control form-control-sm" value="${parseFloat(devolucion.precio_venta || 0).toFixed(2)}" type="text" oninput="calcularSubTotal(this);calcularPrecioUnitario(this)"></td>
                        <td><input name="precio_unitario_[]" id="precio_unitario_${n}" class="precio_unitario_ form-control form-control-sm" value="${parseFloat(devolucion.costo || 0).toFixed(2)}" type="text" oninput="calcularPrecioUnitario(this)"></td>
                        <td><input name="valor_venta_bruto[]" id="valor_venta_bruto${n}" class="valor_venta_bruto form-control form-control-sm" value="${parseFloat(devolucion.valor_venta_bruto || 0).toFixed(2)}" type="text" oninput="calcularSubTotal(this)"></td>
                        <td><input name="valor_venta[]" id="valor_venta${n}" class="valor_venta form-control form-control-sm" value="${parseFloat(devolucion.valor_venta || 0).toFixed(2)}" type="text" oninput="calcularSubTotal(this)"></td>

                        <td><div style="display: flex; align-items: center; gap: 5px;"> <button type="button" class="btn-custom" onclick="cambiarDescuento(this);calcularPrecioUnitario(this)"><i class="${devolucion.id_descuento == 2 ? 'fas fa-percentage' : 'fas fa-paint-brush'}"></i></button> <input name="descuento[]" id="descuento${n}" class="descuento form-control form-control-sm" placeholder="S/ Descuento" value="${parseFloat((devolucion.descuento ?? 0) || 0).toFixed(2)}" type="text" oninput="aplicaDescuentoEnSoles(this);calcularPrecioUnitario(this)" style="display: ${(!devolucion.id_descuento || devolucion.id_descuento == 1 || devolucion.descuento == null || devolucion.descuento === "") ? 'block' : 'none'};"> <input name="porcentaje[]" id="porcentaje${n}" class="porcentaje form-control form-control-sm" placeholder="% Descuento" value="${parseFloat(devolucion.id_descuento == 2 ? (devolucion.descuento ?? 0) : 0).toFixed(2)}" type="text" oninput="aplicaDescuentoEnPorcentaje(this);calcularPrecioUnitario(this)" style="display: ${devolucion.id_descuento == 2 ? 'block' : 'none'};"><input name="id_descuento[]" id="id_descuento${n}" type="hidden" value="${devolucion.id_descuento ?? 1}"></div></td>
                        <td><input name="sub_total[]" id="sub_total${n}" class="sub_total form-control form-control-sm" value="${parseFloat(devolucion.sub_total || 0).toFixed(2) }" type="text" readonly="readonly"></td>
                        <td><input name="igv[]" id="igv${n}" class="igv form-control form-control-sm" value="${parseFloat(devolucion.igv || 0).toFixed(2)}" type="text" readonly="readonly"></td>
                        <td><input name="total[]" id="total${n}" class="total form-control form-control-sm" value="${parseFloat(devolucion.total || 0).toFixed(2)}" type="text" readonly="readonly"></td>
                        <td><button type="button" class="btn btn-sm btn-clasico btn-eliminar" onclick="eliminarFila(this)"><i class="fas fa-trash" style="font-size:18px;"></i></button></td>

                    </tr>
                `;
                //alert(orden_compra.id_descuento);
                tbody.append(row);
                $('#descripcion' + n).select2({ 
                    width: '100%', 
                    dropdownCssClass: 'custom-select2-dropdown'
                });

                $('#marca' + n).select2({
                    width: '100%',
                });

                n++;
                sub_total_acumulado += parseFloat(devolucion.sub_total || 0);
                igv_total_acumulado += parseFloat(devolucion.igv || 0);
                descuento_total_acumulado += parseFloat(devolucion.descuento || 0);
                descuento_total_acumulado += parseFloat(devolucion.porcentaje || 0);
                total_acumulado += parseFloat(devolucion.total || 0);
                });
                $('#sub_total_general').val(sub_total_acumulado.toFixed(2) || '0.00');
                $('#igv_general').val(igv_total_acumulado.toFixed(2) || '0.00');
                $('#descuento_general').val(descuento_total_acumulado.toFixed(2) || '0.00');
                $('#total_general').val(total_acumulado.toFixed(2) || '0.00');
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
        var n = $('#tblOrdenCompraDetalle tbody tr').length + 1;
        var item = '<input name="id_orden_compra_detalle[]" id="id_orden_compra_detalle${n}" class="form-control form-control-sm" value="${orden_compra.id}" type="hidden"><input name="item[]" id="item' + n + '" class="form-control form-control-sm" value="" type="text">';
        //var cantidad = '<input name="cantidad[]" id="cantidad' + n + '" class="form-control form-control-sm" value="" type="text">';
        var descripcion = '<select name="descripcion[]" id="descripcion' + n + '" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ' + n + ')"> '+ opcionesDescripcion +' </select>';
        
        var descripcion_ant = '<input type="hidden" name="descripcion_ant[]" id="descripcion_ant' + n + '" class="form-control form-control-sm" />';
        
        //var ubicacion_fisica_seccion = '<select name="ubicacion_fisica_seccion[]" id="ubicacion_fisica_seccion' + n + '" class="form-control form-control-sm" onChange="obtenerAnaquel(this)"> <option value="">- Selecione -</option> <?php //foreach ($almacen_seccion as $row) {?> <option value="<?php //echo $row->id?>"><?php //echo $row->codigo_seccion."-".$row->seccion?></option> <?php //} ?> </select>';
        //var ubicacion_fisica_anaquel = '<select name="ubicacion_fisica_anaquel[]" id="ubicacion_fisica_anaquel' + n + '" class="form-control form-control-sm" onChange=""> <option value="">- Selecione -</option>} ?> </select>';
        var cod_interno = '<input name="cod_interno[]" id="cod_interno' + n + '" class="form-control form-control-sm" value="" type="text">';
        var marca = '<select name="marca[]" id="marca' + n + '" class="form-control form-control-sm" onchange=""> <option value="">--Seleccionar--</option><?php foreach ($marca as $row){?><option value="<?php echo htmlspecialchars($row->id); ?>"><?php echo htmlspecialchars(addslashes($row->denominiacion)); ?></option><?php }?></select>'
        var estado_bien =  '<select name="estado_bien[]" id="estado_bien' + n + '" class="form-control form-control-sm" onChange=""><option value="">--Seleccionar--</option> <?php foreach ($estado_bien as $row) { ?> <option value="<?php echo $row->codigo ?>" <?php echo ($row->codigo == 1) ? "selected" : ""; ?>><?php echo $row->denominacion ?></option> <?php } ?> </select>';
        var unidad = '<select name="unidad[]" id="unidad' + n + '" class="form-control form-control-sm" onChange=""> <option value="">--Seleccionar--</option> <?php foreach ($unidad as $row) {?> <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option> <?php } ?> </select>';
        var cantidad_ingreso = '<input name="cantidad_ingreso[]" id="cantidad_ingreso' + n + '" class="cantidad_ingreso form-control form-control-sm" value="" type="text" oninput="calcularSubTotal(this)">';
        var precio_unitario = '<input name="precio_unitario[]" id="precio_unitario' + n + '" class="precio_unitario form-control form-control-sm" value="" type="text" oninput="calcularSubTotal(this);calcularPrecioUnitario(this)">';
        var precio_unitario_ = '<input name="precio_unitario_[]" id="precio_unitario_' + n + '" class="precio_unitario_ form-control form-control-sm" value="" type="text" oninput="calcularPrecioUnitario(this)">';
        var valor_venta_bruto = '<input name="valor_venta_bruto[]" id="valor_venta_bruto' + n + '" class="valor_venta_bruto form-control form-control-sm" value="" type="text" oninput="calcularSubTotal(this)">';
        var valor_venta = '<input name="valor_venta[]" id="valor_venta' + n + '" class="valor_venta form-control form-control-sm" value="" type="text" oninput="calcularSubTotal(this)">';
        var descuento = '<div style="display: flex; align-items: center; gap: 5px;"><button type="button" class="btn-custom" onclick="cambiarDescuento(this);calcularPrecioUnitario(this)"><i class="fas fa-paint-brush"></i></button><input name="descuento[]" id="descuento' + n + '" class="descuento form-control form-control-sm" placeholder="S/ Descuento" value="" type="text" oninput="aplicaDescuentoEnSoles(this);calcularPrecioUnitario(this)"><input name="porcentaje[]" id="porcentaje' + n + '" class="porcentaje form-control form-control-sm" placeholder="% Descuento" type="text" oninput="aplicaDescuentoEnPorcentaje(this);calcularPrecioUnitario(this)" style="display: none;"> <input name="id_descuento[]" id="id_descuento${n}" type="hidden" value="1"></div>';
        var sub_total = '<input name="sub_total[]" id="sub_total' + n + '" class="sub_total form-control form-control-sm" value="" type="text" readonly="readonly">';
        var igv = '<input name="igv[]" id="igv' + n + '" class="igv form-control form-control-sm" value="" type="text" readonly="readonly">';
        var total = '<input name="total[]" id="total' + n + '" class="total form-control form-control-sm" value="" type="text" readonly="readonly">';
        
        var btnEliminar = '<button type="button" class="btn btn-sm btn-clasico btn-eliminar" onclick="eliminarFila(this)"><i class="fas fa-trash" style="font-size:18px;"></i></button>';

        newRow += '<tr>';
        newRow += '<td>' + n + '</td>';
        newRow += '<td>' + item + '</td>';
        //newRow += '<td>' + cantidad + '</td>';
        newRow += '<td style="width: 400px!important; display:block!important">' +descripcion_ant + descripcion + '</td>';
        //newRow += '<td>' + ubicacion_fisica_seccion + '</td>';
        newRow += '<td>' + marca + '</td>';
        newRow += '<td>' + cod_interno + '</td>';
        newRow += '<td>' + estado_bien + '</td>';
        newRow += '<td>' + unidad + '</td>';
        newRow += '<td>' + cantidad_ingreso + '</td>';
        newRow += '<td>' + precio_unitario + '</td>';
        newRow += '<td>' + precio_unitario_ + '</td>';
        newRow += '<td>' + valor_venta_bruto + '</td>';
        newRow += '<td>' + valor_venta + '</td>';
        newRow += '<td>' + descuento + '</td>';
        newRow += '<td>' + sub_total + '</td>';
        newRow += '<td>' + igv + '</td>';
        newRow += '<td>' + total + '</td>';
        newRow += '<td>' + btnEliminar + '</td>';
        newRow += '</tr>';

        $('#tblOrdenCompraDetalle tbody').append(newRow);

        $('#descripcion' + n).select2({
            width: '100%',
            dropdownCssClass: 'custom-select2-dropdown'
            //dropdownCssClass: 'form-control form-control-sm',
            //containerCssClass: 'form-control form-control-sm'
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

    }

    actualizarTotalGeneral();
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
    actualizarTotalGeneral();
}

function limpiar(){
	$('#id').val("0");
	$('#id_tipo_documento').val("");
	$('#denominacion').val("");
	$('#img_foto').val("");
}

function fn_save_devolucion(){
	
    var msg = "";

    var tipo_documento = $('#tipo_documento').val();
    var empresa_compra = $('#empresa_compra').val();
    var empresa_vende = $('#empresa_vende').val();
    var igv_compra = $('#igv_compra').val();

    if(tipo_documento==""){msg+="Ingrese el Tipo de Documento <br>";}
    if(empresa_compra==""){msg+="Ingrese la Empresa que Compra <br>";}
    if(empresa_vende==""){msg+="Ingrese la Empresa que Vende <br>";}
    if(igv_compra==""){msg+="Ingrese el IGV <br>";}

    if ($('#tblDevolucionDetalle tbody tr').length == 0) {
        msg += "No se ha agregado ningún producto <br>";
    }

    if(msg!=""){
        bootbox.alert(msg);
        return false;
    }else{
        bootbox.confirm({ 
            size: "small",
            message: "&iquest;Ha verificado que los productos que se est&aacute;n devolviendo son los correctos?", 
            callback: function(result){
                if (result==true) {
                    save_devolucion();
                }
            }
        });
    }
}

function save_devolucion(){

    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

    $.ajax({
            url: "/devolucion/send_devolucion",
            type: "POST",
            data : $("#frmDevolucion").serialize(),
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

function obtenerCodigo(){

    var tipo_documento = $('#tipo_documento').val();
    
    if(tipo_documento==1){
        $('#empresa_compra').val('30').trigger('change');
        $('#empresa_vende').val('').trigger('change');
    }else if(tipo_documento==2){
        $('#empresa_compra').val('').trigger('change');
        $('#empresa_vende').val('30').trigger('change');
    }

    /*$.ajax({
        url: "/orden_compra/obtener_codigo_orden_compra/"+tipo_documento,
        dataType: "json",
        success: function (result) {

            //alert(result[0].codigo);
            //console.log(result);
            $('#numero_orden_compra').val(result[0].codigo);

        }
    });*/

}

function pdf_documento(){

    var id = $('#id').val();
    //var tipo_movimiento = $('#tipo_movimiento').val();

    var href = '/orden_compra/movimiento_pdf/'+id;
    window.open(href, '_blank');

}

function pdf_guia(){

    var id = $('#id').val();
    var tipo_movimiento = $('#tipo_movimiento').val();

    var href = '/entrada_productos/guia_electronica_pdf/'+id+'/'+2;
    window.open(href, '_blank');

}

function modal_tiendas_orden_compra(id){
	
	var id = $('#id').val();

	$.ajax({
        url: "/orden_compra/modal_tiendas_orden_compra/"+id,
        type: "GET",
        success: function (result) {  
                $("#diveditpregOpc2").html(result);
                $('#openOverlayOpc2').modal('show');
        }
	});
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
            //alert(codigoDocumento);

            $('#label_entrada_salida').show();
            $('#input_entrada_salida').show();

            $('#numero_entrada_salida').val(codigoDocumento);

        }
	});

}

function cargarSalida(){

    var numero_salida = $("#numero_salida").val();
    const tbody = $('#divDevolucionDetalle');

    tbody.empty();

    $.ajax({
        url: "/devolucion/cargar_salida/"+numero_salida,
        type: "GET",
        success: function (result) {

            let n = 1;

            var sub_total_acumulado=0;
            var igv_total_acumulado=0;
            var total_acumulado=0;
            var descuento_total_acumulado=0;

            result.devolucion.forEach(devolucion => {

                let marcaOptions = '<option value="">--Seleccionar--</option>';
                let productoOptions = '<option value="">--Seleccionar--</option>';
                let unidadMedidaOptions = '<option value="">--Seleccionar--</option>';
                //let descuentoOptions = '<option value="">--Seleccionar--</option>';

                result.marca.forEach(marca => {
                    let selected = (marca.id == devolucion.id_marca) ? 'selected' : '';
                    marcaOptions += `<option value="${marca.id}" ${selected}>${marca.denominiacion}</option>`;
                });

                result.producto.forEach(producto => {
                    let selected = (producto.id == devolucion.id_producto) ? 'selected' : '';
                    productoOptions += `<option value="${producto.id}" ${selected}>${producto.codigo} - ${producto.denominacion}</option>`;
                });

                result.unidad_medida.forEach(unidad_medida => {
                    let selected = (unidad_medida.codigo == devolucion.id_um) ? 'selected' : '';
                    unidadMedidaOptions += `<option value="${unidad_medida.codigo}" ${selected}>${unidad_medida.denominacion}</option>`;
                });

                /*result.descuento.forEach(descuento => {
                    let selected = (descuento.codigo == orden_compra.id_descuento) ? 'selected' : '';
                    descuentoOptions += `<option value="${descuento.codigo}" ${selected}>${descuento.denominacion}</option>`;
                });*/

                if (devolucion.id_producto) {
                    productosSeleccionados.push(devolucion.id_producto);
                }

                const row = `
                    <tr>
                        <td>${n}</td>
                        <td style="width: 450px !important;display:block"><input name="id_devolucion_detalle[]" id="id_devolucion_detalle${n}" class="form-control form-control-sm" value="${devolucion.id}" type="hidden"><select name="descripcion[]" id="descripcion${n}" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ${n});">${productoOptions}</select></td>
                        
                        <td><select name="marca[]" id="marca${n}" class="form-control form-control-sm">${marcaOptions}</select></td>
                        <td><input name="cod_interno[]" id="cod_interno${n}" class="form-control form-control-sm" value="${devolucion.codigo}" type="text"></td>
                        <td><select name="unidad[]" id="unidad${n}" class="form-control form-control-sm">${unidadMedidaOptions}</select></td>
                        <td><input name="cantidad_ingreso[]" id="cantidad_ingreso${n}" class="cantidad_ingreso form-control form-control-sm" value="${devolucion.cantidad}" type="text" oninput="calcularCantidadPendiente(this);calcularSubTotal(this);calcularPrecioUnitario(this)"></td>
                        <td><input name="precio_unitario[]" id="precio_unitario${n}" class="precio_unitario form-control form-control-sm" value="${parseFloat(devolucion.precio_venta || 0).toFixed(2)}" type="text" oninput="calcularSubTotal(this);calcularPrecioUnitario(this)"></td>
                        <td><input name="precio_unitario_[]" id="precio_unitario_${n}" class="precio_unitario_ form-control form-control-sm" value="${parseFloat(devolucion.costo || 0).toFixed(2)}" type="text" oninput="calcularPrecioUnitario(this)"></td>
                        <td><input name="valor_venta_bruto[]" id="valor_venta_bruto${n}" class="valor_venta_bruto form-control form-control-sm" value="${parseFloat(devolucion.valor_venta_bruto || 0).toFixed(2)}" type="text" oninput="calcularSubTotal(this)"></td>
                        <td><input name="valor_venta[]" id="valor_venta${n}" class="valor_venta form-control form-control-sm" value="${parseFloat(devolucion.valor_venta || 0).toFixed(2)}" type="text" oninput="calcularSubTotal(this)"></td>

                        <td><input name="descuento[]" id="descuento${n}" class="descuento form-control form-control-sm" placeholder="S/ Descuento" value="${parseFloat((devolucion.descuento ?? 0) || 0).toFixed(2)}" type="text" oninput="aplicaDescuentoEnSoles(this);calcularPrecioUnitario(this)" style="display:'block'"><input name="id_descuento[]" id="id_descuento${n}" type="hidden" value="${devolucion.id_descuento ?? 1}"></div></td>
                        <td><input name="sub_total[]" id="sub_total${n}" class="sub_total form-control form-control-sm" value="${parseFloat(devolucion.sub_total || 0).toFixed(2) }" type="text" readonly="readonly"></td>
                        <td><input name="igv[]" id="igv${n}" class="igv form-control form-control-sm" value="${parseFloat(devolucion.igv || 0).toFixed(2)}" type="text" readonly="readonly"></td>
                        <td><input name="total[]" id="total${n}" class="total form-control form-control-sm" value="${parseFloat(devolucion.total || 0).toFixed(2)}" type="text" readonly="readonly"></td>
                        <td><button type="button" class="btn btn-sm btn-clasico btn-eliminar" onclick="eliminarFila(this)"><i class="fas fa-trash" style="font-size:18px;"></i></button></td>

                    </tr>
                `;
                //alert(orden_compra.id_descuento);
                tbody.append(row);
                $('#descripcion' + n).select2({ 
                    width: '100%', 
                    dropdownCssClass: 'custom-select2-dropdown'
                });

                $('#marca' + n).select2({
                    width: '100%',
                });

                n++;
                sub_total_acumulado += parseFloat(devolucion.sub_total || 0);
                igv_total_acumulado += parseFloat(devolucion.igv || 0);
                descuento_total_acumulado += parseFloat(devolucion.descuento || 0);
                descuento_total_acumulado += parseFloat(devolucion.porcentaje || 0);
                total_acumulado += parseFloat(devolucion.total || 0);
                });
                $('#sub_total_general').val(sub_total_acumulado.toFixed(2) || '0.00');
                $('#igv_general').val(igv_total_acumulado.toFixed(2) || '0.00');
                $('#descuento_general').val(descuento_total_acumulado.toFixed(2) || '0.00');
                $('#total_general').val(total_acumulado.toFixed(2) || '0.00');

                var devolucion_cabecera = result.devolucion[0];

                //alert(devolucion_cabecera.id_empresa_compra);

                $('#empresa').val(devolucion_cabecera.id_empresa_compra);
                $('#id_salida').val(devolucion_cabecera.id_salida);
                $('#almacen').val(devolucion_cabecera.id_almacen_salida);
                $('#moneda').val(devolucion_cabecera.id_moneda);
                $('#igv_compra').val(devolucion_cabecera.igv_compra);
                $('#numero_orden_compra_cliente').val(devolucion_cabecera.numero_orden_compra_cliente);

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
                    <b>Devoluci&oacute;n</b>
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmDevolucion" name="frmDevolucion">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                    
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                    <input type="hidden" name="id_tipo_documento" id="id_tipo_documento" value="<?php echo $id_tipo_documento?>">
                    
                    <div class="row" style="padding-left:10px">
                        <div class="col-lg-2">
                            N&uacute;mero Salida
                        </div>
                        <div class="col-lg-2">
                            <input id="numero_salida" name="numero_salida" on class="form-control form-control-sm"  value="<?php if($id>0){echo $salida->codigo;}?>" onchange="cargarSalida()" <?php if($id>0) {?> readonly="readonly" <?php } ?>  type="text" >
                            <input id="id_salida" name="id_salida" on class="form-control form-control-sm"  value="<?php if($id>0){echo $salida->id;}?>" onchange="" type="hidden">
                        </div>
                        <div class="col-lg-2">
                            Empresa
                        </div>
                        <div class="col-lg-2">
                            <select name="empresa" id="empresa" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($empresa as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php if($row->id==$salida->id_empresa_compra)echo "selected='selected'"?>><?php echo $row->razon_social ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            Fecha Devoluci&oacute;n
                        </div>
                        <div class="col-lg-2">
                            <input id="fecha_devolucion" name="fecha_devolucion" on class="form-control form-control-sm"  value="<?php echo isset($salida) && $salida->fecha_salida ? $salida->fecha_salida : date('Y-m-d'); ?>" type="text">
                        </div>
                        <!--<div class="col-lg-2">
                            N&uacute;mero Devoluci&oacute;n
                        </div>
                        <div class="col-lg-2">
                            <input id="numero_devolucion" name="numero_devolucion" on class="form-control form-control-sm"  value="<?php //if($id>0){echo $salida->numero_devolucion;}?>" type="text" readonly="readonly">
                        </div>-->
                        <div class="col-lg-2" id="almacen_" style="color:red; font-weight:bold">
                            Almacen Destino
                        </div>
                        <div class="col-lg-2" id="almacen_select">
                            <select name="almacen" id="almacen" class="form-control form-control-sm" onchange="//actualizarSecciones(this)">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($almacen_destino as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php if($row->id==$salida->id_almacen_salida)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <!--<div class="col-lg-2">
                            Aplica IGV
                        </div>
                        <div class="col-lg-2">
                            <select name="igv_compra" id="igv_compra" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php
                                //foreach ($igv_compra as $row){?>
                                    <option value="<?php //echo $row->codigo ?>" <?php //if($row->codigo==$devolucion->igv_compra)echo "selected='selected'"?>><?php //echo $row->denominacion ?></option>
                                    <?php 
                                //}
                                ?>
                            </select>
                        </div>-->
                        <div class="col-lg-2">
                            Moneda
                        </div>
                        <div class="col-lg-2">
                            <select name="moneda" id="moneda" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($moneda as $row){?>
                                    <option value="<?php echo $row->codigo; ?>" <?php echo ($id > 0 && $row->codigo == $salida->id_moneda) ? "selected='selected'" : (($row->codigo == 1) ? "selected='selected'" : ""); ?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                            <input name="moneda_descripcion" id="moneda_descripcion" type="hidden">
                        </div>
                        <div class="col-lg-2" id="label_entrada_salida">
                            N&uacute;mero Orden Compra Cliente
                        </div>
                        <div class="col-lg-2" id="input_entrada_salida">
                            <input id="numero_orden_compra_cliente" name="numero_orden_compra_cliente" style="color:red; font-weight:bold" on class="form-control form-control-sm"  value="<?php echo $orden_compra->numero_orden_compra_cliente;?>" type="text">
                        </div>
                        <div class="col-lg-2">
                            Motivo Devoluci&oacute;n
                        </div>
                        <div class="col-lg-2">
                            <select name="motivo_devolucion" id="motivo_devolucion" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($motivo_devolucion as $row){?>
                                    <option value="<?php echo $row->codigo ?>" <?php //if($row->codigo==$devolucion->motivo_devolucion)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                        <div class="card-body">	
					<div class="table-responsive" style="overflow-y: auto; max-height: 400px;">
						<table id="tblDevolucionDetalle" class="table table-hover table-sm">
							<thead>
							<tr style="font-size:13px">
								<th>#</th>
								<th>Descripci&oacute;n</th>
								<th>Marca</th>
                                <th>COD. INT.</th>
                                <th>Unidad</th>
                                <th>Cantidad</th>
                                <th>Precio Venta</th>
                                <th>Precio Unitario</th>
                                <th>Valor Venta Bruto</th>
                                <th>Valor Venta</th>
                                <th>Descuento</th>
                                <th>Sub Total</th>
                                <th>IGV</th>
                                <th>Total</th>
							</tr>
							</thead>
							<tbody id="divDevolucionDetalle">
							</tbody>
						</table>
					</div>
                    <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; width: 100%; margin: 0 auto; font-size:12px">
                        <tbody>
                            <tr>
                                <td class="td" style ="text-align: left; width: 5%; font-size:13px"><b>Sub-Total:</b></td>
                                <td id="subTotalGeneral" class="td" style="text-align: left; width: 5%; font-size:13px">
                                    <input type="text" name="sub_total_general" id="sub_total_general" class="form-control" value="0.00" readonly style="border: none; background: transparent; text-align: left; pointer-events: none;">
                                </td>
                                <td class="td" style ="text-align: left; width: 20%; font-size:13px"></td>
                                <td class="td" style ="text-align: left; width: 5%; font-size:13px"><b>IGV Total:</b></td>
                                <td id="igvGeneral" class="td" style="text-align: left; width: 5%; font-size:13px">
                                    <input type="text" name="igv_general" id="igv_general" class="form-control" value="0.00" readonly style="border: none; background: transparent; text-align: left; pointer-events: none;">
                                </td>
                                <td class="td" style ="text-align: left; width: 20%; font-size:13px"></td>
                                <td class="td" style ="text-align: left; width: 5%; font-size:13px"><b>Descuento Total:</b></td>
                                <td id="descuentoGeneral" class="td" style="text-align: left; width: 5%; font-size:13px">
                                    <input type="text" name="descuento_general" id="descuento_general" class="form-control" value="0.00" readonly style="border: none; background: transparent; text-align: left; pointer-events: none;">
                                </td>
                                <td class="td" style ="text-align: left; width: 20%; font-size:13px"></td>
                                <td class="td" style ="text-align: left; width: 5%; font-size:13px"><b>Total:</b></td>
                                <td id="totalGeneral" class="td" style="text-align: left; width: 5%; font-size:13px">
                                    <input type="text" name="total_general" id="total_general" class="form-control" value="0.00" readonly style="border: none; background: transparent; text-align: left; pointer-events: none;">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="margin-top:15px" class="form-group">
                        <div class="col-sm-12 controls">
                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                <?php if($id_user==$salida->id_usuario_inserta and $id==0){?>
                                    <!--<a href="javascript:void(0)" onClick="fn_save_devolucion()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>-->
                                    <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-nuevo" data-toggle="modal" onclick="fn_save_devolucion()">
                                        <i class="fas fa-save" style="font-size:18px;"></i> Guardar
                                    </button>
                                <?php }?>
                                <?php if($id==0){?>
                                    <!--<a href="javascript:void(0)" onClick="fn_save_devolucion()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>-->
                                    <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-nuevo" data-toggle="modal" onclick="fn_save_devolucion()">
                                        <i class="fas fa-save" style="font-size:18px;"></i> Guardar
                                    </button>
                                <?php }?>
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

