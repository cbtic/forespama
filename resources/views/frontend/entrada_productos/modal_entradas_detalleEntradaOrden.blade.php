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
  
#tablemodal{
    border-spacing: 0;
    display: flex;/*Se ajuste dinamicamente al tamano del dispositivo**/
    /*max-height: 80vh;*/ /*El alto que necesitemos**/
    /*overflow-y: auto;*/ /**El scroll verticalmente cuando sea necesario*/
    /*overflow-x: hidden;*//*Sin scroll horizontal*/
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

.custom-select2-dropdown {
    width: 700px !important; 
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

    $('#fecha_entrada').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    $('#fecha_comprobante').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    $("#item").select2({ width: '100%' });
    $("#persona_recibe").select2({ width: '100%' });

    cambiarOrigen();
    
    //$("#ubicacion_fisica_seccion").select2({ width: '100%' });
    //$("#ubicacion_fisica_anaquel").select2({ width: '100%' });

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
        cambiarTipoCambio();
        cambiarOrigen();
        cambiarDocumento();
        cargarDetalle();
        cambiarTipoDocumento();
    }

    if($('#id').val()>0){
        cargarDetalle();
        cambiarDocumento();
        cambiarOrigen();
        //cambiarTipoDocumento();
    }

    cambiarCliente();
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

var productosSeleccionados = [];

function cargarDetalle(){

var id = <?php echo $orden_compra->id?>;
//var tipo_movimiento = $("#tipo_movimiento").val();

//$("#divDetalle tbody").html("");
const tbody = $('#divDetalle');

tbody.empty();

$.ajax({
        url: "/orden_compra/cargar_detalle_abierto/"+id,
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
                //console.log('producto_stock:', result.producto_stock);
                var producto_stock = result.producto_stock[orden_compra.id_producto];
                /*if (producto_stock) {
                    console.log('saldos_cantidad:', producto_stock.saldos_cantidad);
                } else {
                    console.log('No se encontró stock para el producto:', orden_compra.id_producto);
                }*/

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
                
                //calcularCantidadPendiente(this)
                const row = `
                    <tr>
                        <td>${n}</td>
                        <td><input name="item[]" id="item${n}" class="form-control form-control-sm" value="${orden_compra.item}" type="text"></td>
                        <td style="width: 450px !important;display:block"><select name="descripcion[]" id="descripcion${n}" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ${n});">${productoOptions}</select></td>
                        <td><select name="marca[]" id="marca${n}" class="form-control form-control-sm">${marcaOptions}</select></td>
                        <td><input name="cod_interno[]" id="cod_interno${n}" class="form-control form-control-sm" value="${orden_compra.codigo}" type="text"></td>
                        <td><select name="estado_bien[]" id="estado_bien${n}" class="form-control form-control-sm" onChange="">${estadoBienOptions}</select></td>
                        <td><select name="unidad[]" id="unidad${n}" class="form-control form-control-sm">${unidadMedidaOptions}</select><input type="hidden" class="cantidad_ingresada" name="cantidad_ingresada[]" id="cantidad_ingresada${n}" value="${orden_compra.cantidad_ingresada}"></td>
                        <td><input name="cantidad_ingreso[]" id="cantidad_ingreso${n}" class="cantidad_ingreso form-control form-control-sm" value="${orden_compra.cantidad_ingresada}" type="text" oninput="calcularCantidadPendiente(this);calcularSubTotal(this);calcularPrecioUnitario(this)"></td>
                        <td><input name="cantidad_compra[]" id="cantidad_compra${n}" class="cantidad_compra form-control form-control-sm" value="${orden_compra.cantidad_requerida}" type="text" oninput="calcularCantidadPendiente(this)" readonly="readonly"></td>
                        <td><input name="cantidad_pendiente[]" id="cantidad_pendiente${n}" class="cantidad_pendiente form-control form-control-sm" value="" type="text" readonly="readonly"></td>
                        <td><input name="stock_actual[]" id="stock_actual${n}" class="form-control form-control-sm" value="${producto_stock.saldos_cantidad}" type="text" readonly="readonly"></td>
                        <td><input name="precio_unitario[]" id="precio_unitario${n}" class="precio_unitario form-control form-control-sm" value="${parseFloat(orden_compra.precio_venta || 0).toFixed(2)}" type="text" oninput="calcularSubTotal(this);calcularPrecioUnitario(this)"></td>
                        <td><input name="precio_unitario_[]" id="precio_unitario_${n}" class="precio_unitario_ form-control form-control-sm" value="${parseFloat(orden_compra.precio || 0).toFixed(2)}" type="text" oninput="calcularPrecioUnitario(this)"></td>
                        <td><input name="valor_venta_bruto[]" id="valor_venta_bruto${n}" class="valor_venta_bruto form-control form-control-sm" value="${parseFloat(orden_compra.valor_venta_bruto || 0).toFixed(2)}" type="text" oninput="calcularSubTotal(this)"></td>
                        <td><input name="valor_venta[]" id="valor_venta${n}" class="valor_venta form-control form-control-sm" value="${parseFloat(orden_compra.valor_venta || 0).toFixed(2)}" type="text" oninput="calcularSubTotal(this)"></td>

                        <td><div style="display: flex; align-items: center; gap: 5px;"> <button type="button" class="btn-custom" onclick="cambiarDescuento(this)"><i class="${orden_compra.id_descuento == 2 ? 'fas fa-percentage' : 'fas fa-paint-brush'}"></i></button> <input name="descuento[]" id="descuento${n}" class="descuento form-control form-control-sm" placeholder="S/ Descuento" value="${parseFloat((orden_compra.descuento ?? 0) || 0).toFixed(2)}" type="text" oninput="aplicaDescuentoEnSoles(this);calcularPrecioUnitario(this)" style="display: ${(!orden_compra.id_descuento || orden_compra.id_descuento == 1 || orden_compra.descuento == null || orden_compra.descuento === "") ? 'block' : 'none'};"> <input name="porcentaje[]" id="porcentaje${n}" class="porcentaje form-control form-control-sm" placeholder="% Descuento" value="${parseFloat(orden_compra.id_descuento == 2 ? (orden_compra.descuento ?? 0) : 0).toFixed(2)}" type="text" oninput="aplicaDescuentoEnPorcentaje(this);calcularPrecioUnitario(this)" style="display: ${orden_compra.id_descuento == 2 ? 'block' : 'none'};"><input name="id_descuento[]" id="id_descuento${n}" type="hidden" value="${orden_compra.id_descuento ?? 1}"></div></td>
                        <td><input name="sub_total[]" id="sub_total${n}" class="sub_total form-control form-control-sm" value="${parseFloat(orden_compra.sub_total) || 0}" type="text" readonly="readonly"></td>
                        <td><input name="igv[]" id="igv${n}" class="igv form-control form-control-sm" value="${parseFloat(orden_compra.igv) || 0}" type="text" readonly="readonly"></td>
                        <td><input name="total[]" id="total${n}" class="total form-control form-control-sm" value="${parseFloat(orden_compra.total) || 0}" type="text" readonly="readonly"></td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button></td>

                    </tr>
                `;
                //alert(orden_compra.id_descuento);
                tbody.append(row);

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
                
                calcularCantidadPendiente($('#cantidad_ingreso' + n));
                n++;
                sub_total_acumulado += parseFloat(orden_compra.sub_total || 0);
                igv_total_acumulado += parseFloat(orden_compra.igv || 0);
                descuento_total_acumulado += parseFloat(orden_compra.descuento || 0);
                descuento_total_acumulado += parseFloat(orden_compra.porcentaje || 0);
                total_acumulado += parseFloat(orden_compra.total || 0);
                
                });
                //alert(total_acumulado);
                $('#sub_total_general').val(sub_total_acumulado.toFixed(2) || '0.00');
                $('#igv_general').val(igv_total_acumulado.toFixed(2) || '0.00');
                $('#descuento_general').val(descuento_total_acumulado.toFixed(2) || '0.00');
                $('#total_general').val(total_acumulado.toFixed(2 || '0.00'));
            }
            
    });

}

function cambiarOrigen(){

    var unidad_origen = $('#unidad_origen').val();
    //alert(moneda);
    if(unidad_origen==1){
        //$('#proveedor_select, #proveedor_').hide();
        $('#almacen_select, #almacen_nombre').show();
        $('#almacen_salida_select, #almacen_salida_').show();
    }else if(unidad_origen==2){
        //$('#proveedor_select, #proveedor_').show();
        $('#almacen_select, #almacen_nombre').show();
        $('#almacen_salida_select, #almacen_salida_').hide();
        //$('#proveedor').val("");
    }else if(unidad_origen==3){
        //$('#proveedor_select, #proveedor_').show();
        $('#almacen_select, #almacen_nombre').show();
        $('#almacen_salida_select, #almacen_salida_').show();
        //$('#proveedor').val(30);
    }else if(unidad_origen==4){
        //$('#proveedor_select, #proveedor_').show();
        $('#almacen_select, #almacen_nombre').hide();
        $('#almacen_salida_select, #almacen_salida_').show();
        //$('#proveedor').val(30);
    }else{
        //$('#proveedor_select, #proveedor_').hide();
        $('#almacen_select, #almacen_nombre').show();
        $('#almacen_salida_select, #almacen_salida_').show();
    }
}

function eliminarFila(button){
    $(button).closest('tr').remove();
    actualizarTotalGeneral();
}

function cambiarTipoDocumento(){

    var tipoMovimiento = document.getElementById('tipo_movimiento_').value;
    var tipoDocumento = document.getElementById('tipo_documento');
    //alert(tipoMovimiento);
    if (tipoMovimiento == "1") {
        $('#tipo_documento').val(1).trigger('change');
        //obtenerCodigo();
    } else if (tipoMovimiento == "2") {
        $('#tipo_documento').val(2).trigger('change');
        //obtenerCodigo();
    } else {
        $('#tipo_documento').val("").trigger('change');
    }
}

/*function obtenerAnaquel(selectElement){

    var fila = $(selectElement).closest('tr');
    var id =  $(selectElement).val();

    $.ajax({
            url: "/lotes/obtener_anaquel_seccion/"+id,
            dataType: "json",
            success: function (result) {

                var option = "<option value=''>- Seleccione -</option>";
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

}*/

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
    var cantidad_ingresada = parseFloat(fila.find('.cantidad_ingresada').val()) || 0;
    //alert(cantidad_ingresada);
    var cantidad_pendiente = cantidad_compra - cantidad_ingresada - cantidad_ingreso;

    cantidad_pendiente = cantidad_pendiente <= 0 ? 0 : cantidad_pendiente;

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
   
    $('#tblDetalleEntrada tbody tr').each(function() {
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

/*$('#almacen').change(function() {
    
    var almacenElement = this;
    
    $('#tblDetalleEntrada tbody tr').each(function(index, row) {
        var n = index + 1;
        actualizarSecciones(almacenElement, n);
    });
});*/

/*function actualizarSecciones(selectElement, n) {
    //var id_almacen = $('#almacen').val();
    var id_almacen = $(selectElement).val();

    //alert(id_almacen);

    if (!id_almacen) {
        bootbox.alert('Debe seleccionar un almacén.');
        $('#ubicacion_fisica_seccion' + n).html('<option value="">- Seleccione -</option>');
        return;
    }

    $.ajax({
        url: "/lotes/obtener_seccion_almacen/"+id_almacen,
        dataType: "json",
        success: function (result) {

            var option = "<option value=''>- Seleccione -</option>";

            var ubicacionFisicaSeccion = $('#ubicacion_fisica_seccion' + n);
            //console.log(ubicacionFisicaSeccion);
            ubicacionFisicaSeccion.html("");

            $(result).each(function (ii, oo) {
                option += "<option value='" + oo.id + "'>" + oo.codigo_seccion + "-" + oo.seccion + "</option>";
            });

            ubicacionFisicaSeccion.html(option);
        }
    });
}*/

function cambiarDocumento(){

    var tipo_movimiento = $('#tipo_movimiento').val();

    if(tipo_movimiento==1){

        $.ajax({
            url: "/entrada_productos/obtener_documento_entrada",
            dataType: "json",
            success: function(result){
                var option = "<option value=''>--Seleccionar--</option>";
                var entradaProductoIdTipoDocumento = "{{ $entrada_producto->id_tipo_documento }}";

                var selectedValue = entradaProductoIdTipoDocumento;

                $('#tipo_documento').html("");
                $(result).each(function (ii, oo) {
                    var selected = (oo.codigo == selectedValue) ? "selected" : "";
                    option += "<option value='"+oo.codigo+"' "+selected+">"+oo.denominacion+"</option>";
                });
                $('#tipo_documento').html(option);
                
                $('#tipo_documento').attr("disabled",false);
                $('.loader').hide();
                cambiarTipoDocumento();
                
            }
        });
        //$('#almacen_nombre').show();
        //$('#almacen_select').show();
        //$('#almacen_salida_').show();
        //$('#almacen_salida_select').show();
       

    }else if(tipo_movimiento==2){

        $.ajax({
            url: "/entrada_productos/obtener_documento_salida",
            dataType: "json",
            success: function(result){
                var option = "<option value=''>--Seleccionar--</option>";
                var salidaProductoIdTipoDocumento = "{{ $entrada_producto->id_tipo_documento }}";

                var selectedValue = salidaProductoIdTipoDocumento;

                $('#tipo_documento').html("");
                $(result).each(function (ii, oo) {
                    var selected = (oo.codigo == selectedValue) ? "selected" : "";
                    option += "<option value='"+oo.codigo+"' "+selected+">"+oo.denominacion+"</option>";
                });
                $('#tipo_documento').html(option);
                
                $('#tipo_documento').attr("disabled",false);
                $('.loader').hide();
                cambiarTipoDocumento();
                
            }
        });

        //$('#almacen_nombre').hide();
        //$('#almacen_select').hide();
        //$('#almacen_salida_').show();
        //$('#almacen_salida_select').show();
        

    }
}

function obtenerOrdenCompra(){

    var tipo_movimiento = $('#tipo_movimiento').val();

    if(tipo_movimiento==1){
        
        $.ajax({
            url: "/entrada_productos/obtener_orden_compra_entrada",
            dataType: "json",
            success: function(result){
                var option = "<option value=''>--Seleccionar--</option>";
                var entradaProductoIdTipoDocumento = "{{ $entrada_producto->id_tipo_documento }}";

                var selectedValue = entradaProductoIdTipoDocumento;

                $('#tipo_documento').html("");
                $(result).each(function (ii, oo) {
                    var selected = (oo.codigo == selectedValue) ? "selected" : "";
                    option += "<option value='"+oo.codigo+"' "+selected+">"+oo.denominacion+"</option>";
                });
                $('#tipo_documento').html(option);
                
                $('#tipo_documento').attr("disabled",false);
                $('.loader').hide();
                
            }
        });

    }else if(tipo_movimiento==2){

    }
}

function agregarProducto(){

    var opcionesDescripcion = `<?php
        echo '<option value="">--Seleccionar--</option>';
        foreach ($producto as $row) {
            echo '<option value="' . htmlspecialchars($row->id, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($row->denominacion, ENT_QUOTES, 'UTF-8') . '</option>';
        }
    ?>`;

    var cantidad = 1;
    var newRow = "";
    for (var i = 0; i < cantidad; i++) { 
        var n = $('#tblDetalleEntrada tbody tr').length + 1;
        var item = '<input name="item[]" id="item' + n + '" class="form-control form-control-sm" value="" type="text">';
        var descripcion = '<select name="descripcion[]" id="descripcion' + n + '" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ' + n + ')"> '+ opcionesDescripcion +' </select>';
        
        var cod_interno = '<input name="cod_interno[]" id="cod_interno' + n + '" class="form-control form-control-sm" value="" type="text">';
        var marca = '<select name="marca[]" id="marca' + n + '" class="form-control form-control-sm" onchange=""> <option value="">--Seleccionar--</option><?php foreach ($marca as $row){?><option value="<?php echo htmlspecialchars($row->id); ?>"><?php echo htmlspecialchars(addslashes($row->denominiacion)); ?></option> <?php } ?></select>';
        var estado_bien =  '<select name="estado_bien[]" id="estado_bien' + n + '" class="form-control form-control-sm" onChange=""><option value="">--Seleccionar--</option> <?php foreach ($estado_bien as $row) { ?> <option value="<?php echo $row->codigo ?>" <?php echo ($row->codigo == 1) ? "selected" : ""; ?>><?php echo $row->denominacion ?></option> <?php } ?> </select>';
        var unidad = '<select name="unidad[]" id="unidad' + n + '" class="form-control form-control-sm" onChange=""> <option value="">--Seleccionar--</option> <?php foreach ($unidad as $row) {?> <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option> <?php } ?> </select>';
        var cantidad_ingreso = '<input name="cantidad_ingreso[]" id="cantidad_ingreso' + n + '" class="cantidad_ingreso form-control form-control-sm" value="" type="text" oninput="calcularCantidadPendiente(this);calcularSubTotal(this)">';
        var cantidad_compra = '<input name="cantidad_compra[]" id="cantidad_compra' + n + '" class="cantidad_compra form-control form-control-sm" value="" type="text" oninput="calcularCantidadPendiente(this)">';
        var cantidad_pendiente = '<input name="cantidad_pendiente[]" id="cantidad_pendiente' + n + '" class="cantidad_pendiente form-control form-control-sm" value="" type="text" readonly="readonly">';
        var stock_actual = '<input name="stock_actual[]" id="stock_actual' + n + '" class="form-control form-control-sm" value="" type="text">';
        var precio_unitario = '<input name="precio_unitario[]" id="precio_unitario' + n + '" class="precio_unitario form-control form-control-sm" value="" type="text" oninput="calcularSubTotal(this);calcularPrecioUnitario(this)">';
        var precio_unitario_ = '<input name="precio_unitario_[]" id="precio_unitario_' + n + '" class="precio_unitario_ form-control form-control-sm" value="" type="text" oninput="calcularPrecioUnitario(this)">';
        var valor_venta_bruto = '<input name="valor_venta_bruto[]" id="valor_venta_bruto' + n + '" class="valor_venta_bruto form-control form-control-sm" value="" type="text" oninput="calcularSubTotal(this)">';
        var valor_venta = '<input name="valor_venta[]" id="valor_venta' + n + '" class="valor_venta form-control form-control-sm" value="" type="text" oninput="calcularSubTotal(this)">';
        var descuento = '<div style="display: flex; align-items: center; gap: 5px;"><button type="button" class="btn-custom" onclick="cambiarDescuento(this);calcularPrecioUnitario(this)"><i class="fas fa-paint-brush"></i></button><input name="descuento[]" id="descuento' + n + '" class="descuento form-control form-control-sm" placeholder="S/ Descuento" value="" type="text" oninput="aplicaDescuentoEnSoles(this);calcularPrecioUnitario(this)"><input name="porcentaje[]" id="porcentaje' + n + '" class="porcentaje form-control form-control-sm" placeholder="% Descuento" type="text" oninput="aplicaDescuentoEnPorcentaje(this);calcularPrecioUnitario(this)" style="display: none;"> <input name="id_descuento[]" id="id_descuento${n}" type="hidden" value="1"></div>';
        var sub_total = '<input name="sub_total[]" id="sub_total' + n + '" class="sub_total form-control form-control-sm" value="" type="text" readonly="readonly">';
        var igv = '<input name="igv[]" id="igv' + n + '" class="igv form-control form-control-sm" value="" type="text" readonly="readonly">';
        var total = '<input name="total[]" id="total' + n + '" class="total form-control form-control-sm" value="" type="text" readonly="readonly">';
        var btnEliminar = '<button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button>';

        newRow += '<tr>';
        newRow += '<td>' + n + '</td>';
        newRow += '<td>' + item + '</td>';
        //newRow += '<td>' + cantidad + '</td>';
        newRow += '<td style="width: 450px!important; display:block!important">' + descripcion + '</td>';
        //newRow += '<td>' + ubicacion_fisica_seccion + '</td>';
        newRow += '<td>' + marca + '</td>';
        newRow += '<td>' + cod_interno + '</td>';
        newRow += '<td>' + estado_bien + '</td>';
        newRow += '<td>' + unidad + '</td>';
        newRow += '<td>' + cantidad_ingreso + '</td>';
        newRow += '<td>' + cantidad_compra + '</td>';
        newRow += '<td>' + cantidad_pendiente + '</td>';
        newRow += '<td>' + stock_actual + '</td>';
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

        $('#tblDetalleEntrada tbody').append(newRow);

        
        $('#fecha_fabricacion_' + n).datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            changeMonth: true,
            changeYear: true,
            language: 'es',
        });

        $('#fecha_vencimiento_' + n).datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            changeMonth: true,
            changeYear: true,
            language: 'es',
        });

        //var almacenElement = document.getElementById('almacen');
        //actualizarSecciones(almacenElement, n);

    }

    actualizarTotalGeneral();
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

    //var igvInputId = fila.find('.igv').attr('id');
    //var totalInputId = fila.find('.total').attr('id');

    //console.log('IGV ID:', igvInputId);
    //console.log('Total ID:', totalInputId);

    //calcularIGV(sub_total, igvInputId, totalInputId);

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

function verificarProductoSeleccionado(selectElement, rowIndex) {
    var selectedValue = $(selectElement).val();

    if (selectedValue) {

        if (!productosSeleccionados.includes(Number(selectedValue))) {
            productosSeleccionados.push(Number(selectedValue));

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
}

function limpiar(){
	$('#id').val("0");
	$('#id_tipo_documento').val("");
	$('#denominacion').val("");
	$('#img_foto').val("");
}


$('#moneda_').on('change', function(){

    var descripcion = $('#moneda_ option:selected').text();

    $('#moneda_descripcion').val(descripcion);

});

function fn_save_detalle_producto(){

    var tipo_movimiento = $('#tipo_movimiento').val();
    var tipo_documento = $('#tipo_documento').val();
    var unidad_origen = $('#unidad_origen').val();
    var almacen = $('#almacen').val();
    var almacen_salida = $('#almacen_salida').val();
    var moneda = $('#moneda').val();

    var msg="";

    if(tipo_documento==""){msg+="Ingrese el Tipo de Documento <br>";}
    if(unidad_origen==""){msg+="Ingrese la Unidad de Origen <br>";}
    if(tipo_movimiento==1){
        //if(almacen==""){msg+="Ingrese el Almacen de Destino <br>";}
    }
    if(tipo_movimiento==2){
        //if(almacen_salida==""){msg+="Ingrese el Almacen de Salida <br>";}
    }
    if(moneda==""){msg+="Ingrese la Moneda <br>";}
	
    if(tipo_movimiento==2){

        $('#tblDetalleEntrada tbody tr').each(function(index, row) {

            const cantidad_ingreso_producto = parseInt($(row).find('input[name="cantidad_ingreso[]"]').val()) || 0;
            const stockActual = parseInt($(row).find('input[name="stock_actual[]"]').val()) || 0;
            const descripcion_producto = $(row).find('select[name="descripcion[]"] option:selected').text();

            if(stockActual<cantidad_ingreso_producto){
                msg+="No hay stock para el producto "+descripcion_producto+" <br>";
            }
        });
    }

    if(tipo_movimiento==1 && almacen_salida!=""){

        $('#tblDetalleEntrada tbody tr').each(function(index, row) {

            const cantidad_ingreso_producto = parseInt($(row).find('input[name="cantidad_ingreso[]"]').val()) || 0;
            const stockActual = parseInt($(row).find('input[name="stock_actual[]"]').val()) || 0;
            const descripcion_producto = $(row).find('select[name="descripcion[]"] option:selected').text();

            if(stockActual<cantidad_ingreso_producto){
                msg+="No hay stock del producto "+descripcion_producto+" <br>";
            }
        });
    }

    if(msg!=""){
        bootbox.alert({
            message: msg,
            //max-width: 400px;
        });
        return false;
    }else{
        var msgLoader = "";
        msgLoader = "Procesando, espere un momento por favor";
        var heightBrowser = $(window).width()/2;
        $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
        $('.loader').show();

        //$('#frmDetalleProductos select:disabled').prop('disabled', false);
        //$('#frmDetalleProductos input[type="date"]:disabled').prop('disabled', false);

        //var formData = $('#frmDetalleProductos').serialize();

        $.ajax({
                url: "/entrada_productos/send_entrada_producto",
                type: "POST",
                data :  $('#frmDetalleProductos').serialize(),
                success: function (result) {
                    //alert(result.id)
                    
                    
                    datatablenew();
                    $('#openOverlayOpc').modal('hide');
                    $('.loader').hide();
                    bootbox.alert("Se guard&oacute; satisfactoriamente"); 
                    
                    
                    //if (result.id>0) {
                    //   modalEntradaProducto(result.id,result.tipo_movimiento);
                    //}
                }
        });
    }
}

function obtenerCodigo(){

    var tipo_movimiento = $('#tipo_movimiento').val();
    var tipo_documento = $('#tipo_documento').val();

    $.ajax({
        url: "/entrada_productos/obtener_codigo_entrada_producto/"+tipo_movimiento+"/"+tipo_documento,
        dataType: "json",
        success: function (result) {

            //alert(result[0].codigo);
            //console.log(result);

            $('#codigo').val(result[0].codigo);

        }
    });

}

function pdf_documento(){

    var id = $('#id').val();
    var tipo_movimiento = $('#tipo_movimiento').val();

    var href = '/entrada_productos/movimiento_pdf/'+id+'/'+tipo_movimiento;
    window.open(href, '_blank');

}

function cambiarCliente(){

    var tipo_documento_cliente = $('#tipo_documento_cliente').val();

    $('#empresa_compra_').hide();
    $('#empresa_compra_select').hide();
    $('#label_persona_compra').hide();
    $('#select_persona_compra').hide();

    if(tipo_documento_cliente==1){

        $('#empresa_compra_').hide();
        $('#empresa_compra_select').hide();
        $('#label_persona_compra').show();
        $('#select_persona_compra').show();
        
    }else if(tipo_documento_cliente==5){

        $('#empresa_compra_').show();
        $('#empresa_compra_select').show();
        $('#label_persona_compra').hide();
        $('#select_persona_compra').hide();
        
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
                    <b>Tipo Movimiento</b>
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmDetalleProductos" name="frmDetalleProductos">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                    
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                    <input type="hidden" name="id_orden_compra" id="id_orden_compra" value="<?php echo $id_orden_compra?>">
                    
                    <div class="row" style="padding-left:10px">

                        <div class="col-lg-2">
                            Tipo Movimiento
                        </div>
                        <div class="col-lg-2">
                            <input type="hidden" name="tipo_movimiento" id="tipo_movimiento" value="<?php echo $tipo?>">
                            <select name="tipo_movimiento_" id="tipo_movimiento_" class="form-control form-control-sm" onchange="cambiarDocumento();obtenerOrdenCompra()" disabled>
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($tipo_movimiento as $row){?>
                                    <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$tipo)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            Fecha Ingreso
                        </div>
                        <div class="col-lg-2">
                            <input id="fecha_entrada" name="fecha_entrada" on class="form-control form-control-sm"  value="<?php echo isset($orden_compra) && $orden_compra->fecha_orden_compra ? $orden_compra->fecha_orden_compra : date('Y-m-d'); ?>" type="text">
                        </div>
                        <div class="col-lg-2">
                            Tipo Documento
                        </div>
                        <div class="col-lg-2">
                            <select name="tipo_documento" id="tipo_documento" class="form-control form-control-sm" onchange="//obtenerCodigo()">
                                <option value="">--Seleccionar--</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            C&oacute;digo
                        </div>
                        <div class="col-lg-2">
                            <input id="codigo" name="codigo" on class="form-control form-control-sm"  value="<?php echo ($id>0) ? str_pad($orden_compra->codigo, 6, '0', STR_PAD_LEFT) :''; ?> " type="text" readonly="readonly">
                        </div>
                        <!--<div class="col-lg-2">
                            Orden de Compra
                        </div>
                        <div class="col-lg-2">
                            <select name="orden_compra" id="orden_compra" class="form-control form-control-sm" onchange="">
                                <option value="">- Selecione -</option>
                            </select>
                        </div>-->
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
                            <input type="hidden" name="unidad_origen" id="unidad_origen" value="<?php echo $orden_compra->id_unidad_origen?>">
                            <select name="unidad_origen_" id="unidad_origen_" class="form-control form-control-sm" onchange="//cambiarOrigen()" disabled>
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($unidad_origen as $row){?>
                                    <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$orden_compra->id_unidad_origen)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2" id="proveedor_">
                            Empresa Vende
                        </div>
                        <div class="col-lg-2" id="proveedor_select">
                            <input type="hidden" name="proveedor" id="proveedor" value="<?php echo $orden_compra->id_empresa_vende?>">
                            <select name="proveedor_" id="proveedor_" class="form-control form-control-sm" onchange="" disabled>
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
                            <input type="hidden" name="tipo_documento_cliente" id="tipo_documento_cliente" value="<?php echo $orden_compra->id_tipo_cliente?>">
                            <select name="tipo_documento_cliente_" id="tipo_documento_cliente_" class="form-control form-control-sm" onchange="cambiarCliente()" disabled>
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($tipo_documento_cliente as $row){?>
                                    <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$orden_compra->id_tipo_cliente)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2" id="empresa_compra_">
                            Empresa Compra
                        </div>
                        <div class="col-lg-2" id="empresa_compra_select">
                            <input type="hidden" name="empresa_compra" id="empresa_compra" value="<?php echo $orden_compra->id_empresa_compra?>">
                            <select name="empresa_compra_" id="empresa_compra_" class="form-control form-control-sm" onchange="" disabled>
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
                            <input type="hidden" name="persona_compra" id="persona_compra" value="<?php echo $orden_compra->id_persona?>">
                            <select name="persona_compra_" id="persona_compra_" class="form-control form-control-sm" onchange="" disabled>
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
                            N&uacute;mero Orden Compra Cliente
                        </div>
                        <div class="col-lg-2">
                            <input id="numero_orden_compra_cliente" name="numero_orden_compra_cliente" on class="form-control form-control-sm"  value="<?php echo $orden_compra->numero_orden_compra_cliente;?>" type="text" readonly>
                        </div>
                        <div class="col-lg-2" id="almacen_salida_" style="color:green; font-weight:bold">
                            Almacen Origen
                        </div> 
                        <div class="col-lg-2" id="almacen_salida_select">
                            <input type="hidden" name="almacen_salida" id="almacen_salida" value="<?php echo $orden_compra->id_almacen_salida?>">
                            <select name="almacen_salida_" id="almacen_salida_" class="form-control form-control-sm" onchange="//actualizarSecciones(this)" disabled>
                                <option value="">--Seleccionar--</option>
                                <?php 
                                foreach ($almacen as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php if($row->id==$orden_compra->id_almacen_salida)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2" id="almacen_nombre" style="color:red; font-weight:bold">
                            Almacen Destino
                        </div> 
                        <div class="col-lg-2" id="almacen_select">
                            <input type="hidden" name="almacen" id="almacen" value="<?php echo $orden_compra->id_almacen_destino?>">
                            <select name="almacen_" id="almacen_" class="form-control form-control-sm" onchange="//actualizarSecciones(this)" disabled>
                                <option value="">--Seleccionar--</option>
                                <?php 
                                foreach ($almacen as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php if($row->id==$orden_compra->id_almacen_destino)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <!--<div class="col-lg-2">
                            N&uacute;mero Comprobante
                        </div>
                        <div class="col-lg-2">
                            <input id="numero_comprobante" name="numero_comprobante" on class="form-control form-control-sm"  value="<?php //echo $entrada_producto->numero_comprobante?>" type="text">
                        </div>-->
                        <div class="col-lg-2">
                            Moneda
                        </div>
                        <div class="col-lg-2">
                            
                            <select name="moneda_" id="moneda_" class="form-control form-control-sm" onchange="cambiarTipoCambio()" disabled>
                                <option value="">--Seleccionar--</option>
                                <?php
                                $valorPorDefecto = isset($entrada_producto->id_moneda) ? $entrada_producto->id_moneda : $moneda[0]->codigo;
                                foreach ($moneda as $row){?>
                                    <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$valorPorDefecto)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                            <input type="hidden" name="moneda" id="moneda" value="<?php echo $valorPorDefecto?>">
                            <input name="moneda_descripcion" id="moneda_descripcion" type="hidden">
                        </div>
                        <div class="col-lg-2" id="tipo_cambio_dolar_">
                            Tipo Cambio Dolar
                        </div>
                        <div class="col-lg-2" id="tipo_cambio_dolar_input">
                            <input id="tipo_cambio_dolar" name="tipo_cambio_dolar" on class="form-control form-control-sm"  value="<?php echo ($id > 0) ? $entrada_producto->tipo_cambio_dolar : $tipo_cambio[0]->valor_venta; ?>" type="text" readonly="readonly">
                        </div>
                        <div class="col-lg-2">
                            IGV Compra
                        </div>
                        <div class="col-lg-2">
                            <input type="hidden" name="igv_compra" id="igv_compra" value="<?php echo $orden_compra->igv_compra?>">
                            <select name="igv_compra_" id="igv_compra_" class="form-control form-control-sm" onchange="" disabled>
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
                            Cerrado
                        </div>
                        <div class="col-lg-2">
                            <input type="hidden" name="cerrado" id="cerrado" value="<?php echo $entrada_producto->cerrado?>">
                            <select name="cerrado_" id="cerrado_" class="form-control form-control-sm" onchange="" disabled>
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($cerrado_entrada as $row){?>
                                    <option value="<?php echo $row->codigo ?>" <?php echo ($id == 0 && $row->codigo == '1') || ($id > 0 && $row->codigo == $entrada_producto->cerrado) ? "selected='selected'" : ""?>><?php echo $row->denominacion  ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            Observaci&oacute;n
                        </div>
                        <div class="col-lg-2">
                            <input id="observacion" name="observacion" on class="form-control form-control-sm"  value="<?php echo $entrada_producto->observacion?>" type="text">
                        </div>
                        <?php
                            // Verifica si la opción seleccionada en los selects es igual a 30
                            $empresaCompraSeleccionada = $orden_compra->id_empresa_compra; // Obtenemos el valor seleccionado
                            $empresaVendeSeleccionada = $orden_compra->id_empresa_vende; // Obtenemos el valor seleccionado

                            if ($empresaCompraSeleccionada == 30 && $empresaVendeSeleccionada == 30) {
                        ?>
                            <div class="col-lg-2">
                                Persona Recibe
                            </div>
                            <div class="col-lg-2">
                                <select name="persona_recibe" id="persona_recibe" class="form-control form-control-sm" onchange="">
                                    <option value="">--Seleccionar--</option>
                                    <?php
                                    foreach ($persona as $row){?>
                                        <option value="<?php echo $row->id ?>" <?php if($row->id==$orden_compra->id_persona_recibe)echo "selected='selected'"?>><?php echo $row->nombres." ".$row->apellido_paterno." ".$row->apellido_materno ?></option>
                                        <?php 
                                    }
                                    ?>
                                </select>
                            </div>
                        <?php } ?>
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
						<table id="tblDetalleEntrada" class="table table-hover table-sm">
							<thead>
							<tr style="font-size:13px">
								<th>#</th>
								<th>Item</th>
								<!--<th>Cnd</th>-->
								<th>Descripci&oacute;n</th>
								<!--<th>Ub. Fisica Secci&oacute;n</th>
                                <th>Ub. Fisica Anaquel</th>-->
								<th>Marca</th>
                                <th>COD. INT.</th>
                                <th>Estado Bien</th>
                                <th>Unidad</th>
                                <th>Cantidad Ingreso</th>
                                <th>Cantidad Compra</th>
                                <th>Cantidad Pendiente</th>
                                <th>Stock Actual</th>
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
							<tbody id="divDetalle">
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
                                <?php 
                                    if($id>0){
                                ?>
                                <button style="font-size:12px;margin-left:10px" type="button" class="btn btn-sm btn-primary" data-toggle="modal" onclick="pdf_documento()" ><i class="fa fa-edit"></i>Imprimir</button>
                                <button style="font-size:12px;margin-left:10px; margin-right:100px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="pdf_guia()" ><i class="fa fa-edit"></i>Imprimir Gu&iacute;a Remisi&oacute;n Electronica</button>
                                <!--<a href="javascript:void(0)" onClick="fn_pdf_documento()" class="btn btn-sm btn-primary" style="margin-right:100px">Imprimir</a>-->
                                <?php 
                                    }
                        
                                    if($tipo == 1){
                                ?>
                                    <a href="javascript:void(0)" onClick="fn_save_detalle_producto()" class="btn btn-sm btn-danger" style="margin-right:10px">Recibir</a>
                                <?php 
                                    } elseif($tipo== 2){
                                ?>
                                    <a href="javascript:void(0)" onClick="fn_save_detalle_producto()" class="btn btn-sm btn-success" style="margin-right:10px">Entregar</a>
                                <?php 
                                    }
                                ?>
                                
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

