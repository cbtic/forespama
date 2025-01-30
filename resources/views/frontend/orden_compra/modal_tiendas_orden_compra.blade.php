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

.hidden-select {
    display: none;
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
        //cargarDetalle();
        cambiarOrigen();
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
                
                $('#fecha_vencimiento_' + n).datepicker('setDate', result[0].fecha_vencimiento);
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

    var sub_total = cantidad_ingreso * precio_unitario;

    fila.find('.sub_total').val(sub_total.toFixed(2));

    var igvInputId = fila.find('.igv').attr('id');
    var totalInputId = fila.find('.total').attr('id');

    //console.log('IGV ID:', igvInputId);
    //console.log('Total ID:', totalInputId);

    calcularIGV(sub_total, igvInputId, totalInputId);

    actualizarTotalGeneral();
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
    var totalGeneral = 0;
    $('#tblOrdenCompraDetalle tbody tr').each(function() {
        var totalFila = parseFloat($(this).find('.total').val()) || 0;
        totalGeneral += totalFila;
    });
    
    $('#totalGeneral').text(totalGeneral.toFixed(2));
}

function aplicaDescuento(selectElement) {
    
    var fila = $(selectElement).closest('tr');
    var subtotalInput = fila.find('.sub_total');

    var selectedOption = selectElement.options[selectElement.selectedIndex];
    //alert(selectedOption.value);

    if(selectedOption.value!=''){

        var porcentaje = parseFloat(selectedOption.text)/100;
        var subtotal = parseFloat(subtotalInput.val()) || 0;

        
        var descuento = subtotal * porcentaje;

        var nuevo_sub_total = subtotal - descuento;

        fila.find('.sub_total').val(nuevo_sub_total.toFixed(2));

        var igvInputId = fila.find('.igv').attr('id');
        var totalInputId = fila.find('.total').attr('id');

        calcularIGV(nuevo_sub_total, igvInputId, totalInputId);

        actualizarTotalGeneral();
    }else {
        calcularSubTotal(subtotalInput);
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

function cargarDetalle(id, cantidad_tiendas) {

    const tbody = $('#divOrdenCompraTienda');

    $.ajax({
        url: `/orden_compra/cargar_detalle/` + id,
        type: "GET",
        success: function (result) {

            for (let tienda = 1; tienda <= cantidad_tiendas; tienda++) {

                let productoContador = 1;

                result.orden_compra.forEach(orden_compra => {
                    let productoOptions = '<option value="">--Seleccionar--</option>';
                    let unidadMedidaOptions = '<option value="">--Seleccionar--</option>';

                    result.producto.forEach(producto => {
                        const selected = (producto.id == orden_compra.id_producto) ? 'selected' : '';
                        productoOptions += `<option value="${producto.id}" ${selected}>${producto.denominacion}</option>`;
                    });

                    result.unidad_medida.forEach(unidad_medida => {
                        const selected = (unidad_medida.codigo == orden_compra.id_unidad_medida) ? 'selected' : '';
                        unidadMedidaOptions += `<option value="${unidad_medida.codigo}" ${selected}>${unidad_medida.denominacion}</option>`;
                    });
                    
                    const productoRow = `
                        <tr>
                            <td></td>
                            <td style="width: 690px !important;display:block">
                                <input type="hidden" name="id_orden_compra_detalle[${tienda}][]" id="id_orden_compra_detalle${tienda}_${productoContador}" value="${orden_compra.id}">
                                <input type="hidden" name="descripcion[${tienda}][]" id="descripcion${tienda}_${productoContador}" class="cantidad_ingreso form-control form-control-sm" value="${orden_compra.id_producto}" oninput="">
                                <input type="text" name="nombre_producto[${tienda}][]" id="nombre_producto${tienda}_${productoContador}" class="cantidad_ingreso form-control form-control-sm" value="${orden_compra.nombre_producto}" readonly="readonly">
                            </td>
                            <td>
                                <select name="unidad[${tienda}]" id="unidad${tienda}_${productoContador}" class="form-control form-control-sm" disabled>
                                    ${unidadMedidaOptions}
                                </select>
                            </td>
                            <td data-toggle="tooltip" data-placement="top" title="El total es: ${orden_compra.cantidad_requerida}">
                                <input type="text" name="cantidad_ingreso[${tienda}][]" id="cantidad_ingreso${tienda}_${productoContador}" class="cantidad_ingreso form-control form-control-sm" value="" oninput="">
                                <input type="hidden" name="cantidad_ingreso_total[${tienda}][]" id="cantidad_ingreso_total${tienda}_${productoContador}" class="cantidad_ingreso form-control form-control-sm" value="${orden_compra.cantidad_requerida}" oninput="">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button>
                            </td>
                        </tr>
                    `;

                    $(`#productosTienda${tienda}_tabla`).append(productoRow);
                    
                    //$(`#tiendas${tienda}`).select2({ width: '100%' });
                    

                    productoContador++;
                });
            }

            /*$('.tiendas-select').select2({
                width: '100%',
                allowClear: true,
                placeholder: '--Seleccionar--'
            });*/
                    
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
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
        var n = $('#tblOrdenCompraDetalle tbody tr').length + 1;
        var item = '<input name="id_orden_compra_detalle[]" id="id_orden_compra_detalle${n}" class="form-control form-control-sm" value="${orden_compra.id}" type="hidden"><input name="item[]" id="item' + n + '" class="form-control form-control-sm" value="" type="text">';
        //var cantidad = '<input name="cantidad[]" id="cantidad' + n + '" class="form-control form-control-sm" value="" type="text">';
        var descripcion = '<select name="descripcion[]" id="descripcion' + n + '" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ' + n + ')"> '+ opcionesDescripcion +' </select>';
        
        var descripcion_ant = '<input type="hidden" name="descripcion_ant[]" id="descripcion_ant' + n + '" class="form-control form-control-sm" />';
        
        //var ubicacion_fisica_seccion = '<select name="ubicacion_fisica_seccion[]" id="ubicacion_fisica_seccion' + n + '" class="form-control form-control-sm" onChange="obtenerAnaquel(this)"> <option value="">- Selecione -</option> <?php //foreach ($almacen_seccion as $row) {?> <option value="<?php //echo $row->id?>"><?php //echo $row->codigo_seccion."-".$row->seccion?></option> <?php //} ?> </select>';
        //var ubicacion_fisica_anaquel = '<select name="ubicacion_fisica_anaquel[]" id="ubicacion_fisica_anaquel' + n + '" class="form-control form-control-sm" onChange=""> <option value="">- Selecione -</option>} ?> </select>';
        var cod_interno = '<input name="cod_interno[]" id="cod_interno' + n + '" class="form-control form-control-sm" value="" type="text">';
        var marca = '<select name="marca[]" id="marca' + n + '" class="form-control form-control-sm" onchange=""> <option value="">--Seleccionar--</option><?php foreach ($marca as $row){?><option value="<?php echo htmlspecialchars($row->id); ?>"><?php echo htmlspecialchars(addslashes($row->denominiacion)); ?></option><?php }?></select>'
        var fecha_fabricacion = '<input id="fecha_fabricacion_' + n + '" name="fecha_fabricacion[]"  on class="form-control form-control-sm"  value="" type="text">'
        var fecha_vencimiento = '<input id="fecha_vencimiento_' + n + '" name="fecha_vencimiento[]"  on class="form-control form-control-sm"  value="" type="text">'
        var estado_bien =  '<select name="estado_bien[]" id="estado_bien' + n + '" class="form-control form-control-sm" onChange=""><option value="">--Seleccionar--</option> <?php foreach ($estado_bien as $row) { ?> <option value="<?php echo $row->codigo ?>" <?php echo ($row->codigo == 1) ? "selected" : ""; ?>><?php echo $row->denominacion ?></option> <?php } ?> </select>';
        var unidad = '<select name="unidad[]" id="unidad' + n + '" class="form-control form-control-sm" onChange=""> <option value="">--Seleccionar--</option> <?php foreach ($unidad as $row) {?> <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option> <?php } ?> </select>';
        var cantidad_ingreso = '<input name="cantidad_ingreso[]" id="cantidad_ingreso' + n + '" class="cantidad_ingreso form-control form-control-sm" value="" type="text" oninput="calcularSubTotal(this)">';
        var precio_unitario = '<input name="precio_unitario[]" id="precio_unitario' + n + '" class="precio_unitario form-control form-control-sm" value="" type="text" oninput="calcularSubTotal(this)">';
        var descuento = '<select name="descuento[]" id="descuento' + n + '" class="form-control form-control-sm" onChange="aplicaDescuento(this);"> <option value="">--Seleccionar--</option> <?php foreach ($descuento as $row) {?> <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option> <?php } ?> </select>';
        var sub_total = '<input name="sub_total[]" id="sub_total' + n + '" class="sub_total form-control form-control-sm" value="" type="text" readonly="readonly">';
        var igv = '<input name="igv[]" id="igv' + n + '" class="igv form-control form-control-sm" value="" type="text" readonly="readonly">';
        var total = '<input name="total[]" id="total' + n + '" class="total form-control form-control-sm" value="" type="text" readonly="readonly">';
        
        var btnEliminar = '<button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button>';

        newRow += '<tr>';
        newRow += '<td>' + n + '</td>';
        newRow += '<td>' + item + '</td>';
        //newRow += '<td>' + cantidad + '</td>';
        newRow += '<td style="width: 450px!important; display:block!important">' +descripcion_ant + descripcion + '</td>';
        //newRow += '<td>' + ubicacion_fisica_seccion + '</td>';
        newRow += '<td>' + marca + '</td>';
        newRow += '<td>' + cod_interno + '</td>';
        newRow += '<td>' + fecha_fabricacion + '</td>';
        newRow += '<td>' + fecha_vencimiento + '</td>';
        newRow += '<td>' + estado_bien + '</td>';
        newRow += '<td>' + unidad + '</td>';
        newRow += '<td>' + cantidad_ingreso + '</td>';
        newRow += '<td>' + precio_unitario + '</td>';
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

function fn_save_tienda_orden_compra(){
	
    var msg = "";
    const productos = {};
    let validacionExitosa = true;
    
    $('[id^="productosTienda"][id$="_tabla"]').each(function () {
        //console.log("Procesando tabla con ID:", $(this).attr('id'));
        const tablaId = $(this).attr('id');
        const filas = $(`#${tablaId} tr`); 

        filas.each(function (index, row) {

            const cantidad_ingreso_producto = parseInt($(row).find('input[name="cantidad_ingreso[]"]').val()) || 0;
            const cantidad_ingreso_total_producto = parseInt($(row).find('input[name="cantidad_ingreso_total[]"]').val()) || 0;
            const descripcion_producto = $(row).find('input[name="nombre_producto[]"]').val() || '';
            const id_producto = $(row).find('input[name="descripcion[]"]').val() || '';
            //const tienda = $(row).find('select[name="tiendas[]"]').val() || '';
            //console.log(`Procesando producto: ${id_producto}`);
            if (!productos[id_producto]) {
                productos[id_producto] = {
                    descripcion: descripcion_producto,
                    suma_ingreso: 0,
                    total_requerido: cantidad_ingreso_total_producto
                };
            }
            //console.log("Productos procesados:",productos);
            productos[id_producto].suma_ingreso += cantidad_ingreso_producto;

        });
    });

    for (const id_producto in productos) {
        const producto = productos[id_producto];

        if (producto.suma_ingreso != producto.total_requerido) {
            validacionExitosa = false;
            msg += `No coincide el producto "${producto.descripcion}" (Ingresado: ${producto.suma_ingreso}, Total: ${producto.total_requerido})<br>`;
        }
    }

    $('#tblTiendaOrdenCompra tbody tr:has(select[name="tiendas[]"])').each(function(index, row) {
        
        const tienda = $(row).find('select[name="tiendas[]"]').val() || '';
        var numero_tienda = parseInt(index)+1;

        if (tienda == '') {
            validacionExitosa = false;
            msg += `Falta seleccionar la Tienda `+numero_tienda+`.<br>`;
            return false;
        }
    });

    if(validacionExitosa==false){
        bootbox.alert(msg);
        return false;
    }else{
        var msgLoader = "";
        msgLoader = "Procesando, espere un momento por favor";
        var heightBrowser = $(window).width()/2;
        $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
        $('.loader').show();

        $.ajax({
            url: "/orden_compra/send_tiendas_orden_compra",
            type: "POST",
            data : $("#frmOrdenCompraTienda").serialize(),
            success: function (result) {
                //alert(result.id)
                $('#openOverlayOpc2').modal('hide');
                //datatablenew();
                $('.loader').hide();
                bootbox.alert("Se guard&oacute; satisfactoriamente"); 
                
            }
        });
    }
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

    $.ajax({
        url: "/orden_compra/obtener_codigo_orden_compra/"+tipo_documento,
        dataType: "json",
        success: function (result) {

            //alert(result[0].codigo);
            //console.log(result);
            $('#numero_orden_compra').val(result[0].codigo);

        }
    });

}

function agregarTiendas() {

    const cantidad_tiendas = parseInt($('#cantidad_tiendas').val());
    const id = $("#id").val();
    const tbody = $('#divOrdenCompraTienda');

    tbody.empty();

    for (let n = 1; n <= cantidad_tiendas; n++) {
        const row = `
            <tr>
                <td style="width: 20px;">${n}</td>
                <td>
                    <select name="tiendas[]" id="tiendas${n}" class="form-control form-control-sm tiendas-select">
                        <option value="">--Seleccionar--</option>
                        <?php foreach ($tiendas as $row) { ?>
                            <option value="<?php echo $row->id ?>"><?php echo $row->denominacion ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr id="productosTienda${n}">
                <td colspan="2" style="padding-left: 10px;">
                    <table id="productosTienda${n}_tabla" style="width: 100%;"></table>
                </td>
            </tr>
        `;

        tbody.append(row);

    }
    $('.tiendas-select').select2({
        width: '100%',
        allowClear: true,
        placeholder: '--Seleccionar--'
    });

    cargarDetalle(id, cantidad_tiendas);
}

function pdf_documento(){

    var id = $('#id').val();
    //var tipo_movimiento = $('#tipo_movimiento').val();

    var href = '/orden_compra/movimiento_pdf/'+id;
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
                    <b>Puntos de Entrega</b>
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmOrdenCompraTienda" name="frmOrdenCompraTienda">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                    
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                    
                    <div class="row" style="padding-left:10px">

                        <div class="col-lg-2">
                            Cantidad de Tiendas
                        </div>
                        <div class="col-lg-2">
                            <input id="cantidad_tiendas" name="cantidad_tiendas" on class="form-control form-control-sm"  value="" type="text" onchange="agregarTiendas()">
                        </div>
                    </div>
                    
                    <div class="card-body" style="margin-top:20px">	

					<div class="table-responsive">
						<table id="tblTiendaOrdenCompra" class="table table-hover table-sm">
							<thead>
							<tr style="font-size:13px">
								<th>#</th>
								<th>Tienda</th>
							</tr>
							</thead>
							<tbody id="divOrdenCompraTienda">
							</tbody>
						</table>
					</div>
                    <div style="margin-top:15px" class="form-group">
                        <div class="col-sm-12 controls">
                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                
                                <a href="javascript:void(0)" onClick="fn_save_tienda_orden_compra()" class="btn btn-sm btn-success" style="margin-right:10px">Registrar</a>
                                <a href="javascript:void(0)" onClick="$('#openOverlayOpc2').modal('hide');" class="btn btn-sm btn-info" style="">Cerrar</a>
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

