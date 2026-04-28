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

/*.modal-body {
  overflow-y: auto;
}*/

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

</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
	 
});

$(document).ready(function() {

    if($('#id').val()>0){
        cargarDetalle();
    }

    $("#empresa").select2({ width: '100%' });
    $("#persona").select2({ width: '100%' });

    cambiarCliente();
    habilitarTipoCambio();
    validarMoneda();

    $('#fecha').datepicker({
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

    $('#fecha_comprobante').on('change', function () {
        cargarTipoCambioDelDia();
    });

});

function obtenerCodInterno(selectElement, n){

    var id_producto = $(selectElement).val();

    $.ajax({
        url: "/productos/obtener_producto/"+id_producto,
        dataType: "json",
        success: function(result){
            $('#codigo' + n).val(result[0].codigo);
            $('#marca' + n).val(result[0].id_marca).trigger('change');
            $('#unidad' + n).val(result[0].id_unidad_producto);
        }
    });
}

var productosSeleccionados = [];

function cargarDetalle(){

    var id = $("#id").val();
    var tipo_documento = $("#tipo_documento").val();
    let bloqueado = (tipo_documento == 2);

    const tbody = $('#divIngresoSalidaBDetalle');

    tbody.empty();

    $.ajax({
        url: "/ingreso_salida_secundarios/cargar_detalle/"+id,
        type: "GET",
        success: function (result) {

            let n = 1;

            result.ingreso_salida_secundario.forEach(ingreso_salida_secundario => {

                let marcaOptions = '<option value="">--Seleccionar--</option>';
                let productoOptions = '<option value="">--Seleccionar--</option>';
                let unidadMedidaOptions = '<option value="">--Seleccionar--</option>';
                
                result.marca.forEach(marca => {
                    let selected = (marca.id == ingreso_salida_secundario.id_marca) ? 'selected' : '';
                    marcaOptions += `<option value="${marca.id}" ${selected}>${marca.denominiacion}</option>`;
                });

                result.producto.forEach(producto => {
                    let selected = (producto.id == ingreso_salida_secundario.id_producto) ? 'selected' : '';
                    productoOptions += `<option value="${producto.id}" ${selected}>${producto.codigo} - ${producto.denominacion}</option>`;
                });

                result.unidad_medida.forEach(unidad_medida => {
                    let selected = (unidad_medida.codigo == ingreso_salida_secundario.id_unidad_medida) ? 'selected' : '';
                    unidadMedidaOptions += `<option value="${unidad_medida.codigo}" ${selected}>${unidad_medida.denominacion}</option>`;
                });

                if (ingreso_salida_secundario.id_producto) {
                    productosSeleccionados.push(ingreso_salida_secundario.id_producto);
                }

                let precio_unitario = `<input name="precio_unitario[]" id="precio_unitario${n}" class="precio_unitario form-control form-control-sm"
                                        ${bloqueado ? 'readonly' : ''}
                                        value="${ingreso_salida_secundario.precio ?? ''}" type="text"oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\\..*?)\\..*/g, '$1').replace(/(\\d+\\.\\d{0,2}).*/, '$1');calcularSubTotal(this)">`;

                    const row = `
                    <tr>
                        <td>${n}</td>
                        <td style="width: 450px !important;display:block"><input name="id_ingreso_salida_secundario_detalle[]" id="id_ingreso_salida_secundario_detalle${n}" class="form-control form-control-sm" value="${ingreso_salida_secundario.id}" type="hidden"><select name="descripcion_[]" id="descripcion_${n}" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ${n});" disabled>${productoOptions}</select><input name="descripcion[]" id="descripcion${n}" class="form-control form-control-sm" value="${ingreso_salida_secundario.id_producto}" type="hidden"></td>
                        <td><input name="codigo[]" id="codigo${n}" class="form-control form-control-sm" value="${ingreso_salida_secundario.codigo}" type="text" readonly></td>
                        <td><select name="marca_[]" id="marca_${n}" class="form-control form-control-sm" disabled>${marcaOptions}</select><input name="marca[]" id="marca${n}" class="form-control form-control-sm" value="${ingreso_salida_secundario.id_marca}" type="hidden"></td>
                        <td><select name="unidad_[]" id="unidad_${n}" class="form-control form-control-sm" disabled>${unidadMedidaOptions}</select><input name="unidad[]" id="unidad${n}" class="form-control form-control-sm" value="${ingreso_salida_secundario.id_unidad_medida}" type="hidden"></td>
                        <td><input name="cantidad[]" id="cantidad${n}" class="cantidad form-control form-control-sm" value="${ingreso_salida_secundario.cantidad}" type="text" oninput="calcularCantidadPendiente(this);calcularSubTotal(this)" readonly></td>
                        <td class="td_contable"><input name="precio_dolar[]" id="precio_dolar${n}" class="precio_dolar form-control form-control-sm" value="${ingreso_salida_secundario.precio_dolar ?? ''}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\\..*?)\\..*/g, '$1').replace(/(\\d+\\.\\d{0,2}).*/, '$1');calcularSoles(this)"></td>
                        <td>${precio_unitario}</td>
                        <td><input name="sub_total[]" id="sub_total${n}" class="sub_total form-control form-control-sm" value="${ingreso_salida_secundario.sub_total ?? ''}" readonly></td>
                        <td><input name="igv[]" id="igv${n}" class="igv form-control form-control-sm" value="${ingreso_salida_secundario.igv ?? ''}" readonly></td>
                        <td><input name="total[]" id="total${n}" class="total form-control form-control-sm" value="${ingreso_salida_secundario.total ?? ''}" readonly></td>
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
            validarMoneda();
            actualizarTotalGeneral();
        }
    });
}

function agregarProducto(){

    var opcionesDescripcion = `<?php
        echo '<option value="">--Seleccionar--</option>';
        foreach ($producto as $row) {
            echo '<option value="' . htmlspecialchars($row->id, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($row->codigo. ' - ' .$row->denominacion, ENT_QUOTES, 'UTF-8') . '</option>';
        }
    ?>`;

    var tipo_documento = $('#tipo_documento').val();
    let bloqueado = (tipo_documento == 2);

    var cantidad = 1;
    var newRow = "";
    for (var i = 0; i < cantidad; i++) { 

        var n = $('#tblIngresoSalidaBDetalle tbody tr').length + 1;
        var descripcion = '<input name="id_ingreso_salida_b_detalle[]" id="id_ingreso_salida_b_detalle${n}" class="form-control form-control-sm" value="${ingreso_salida_secundario.id}" type="hidden"><select name="descripcion[]" id="descripcion' + n + '" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ' + n + ')"> '+ opcionesDescripcion +' </select>';
        var descripcion_ant = '<input type="hidden" name="descripcion_ant[]" id="descripcion_ant' + n + '" class="form-control form-control-sm" />';
        var codigo = '<input name="codigo[]" id="codigo' + n + '" class="form-control form-control-sm" value="" type="text" readonly>';
        var marca = '<select name="marca[]" id="marca' + n + '" class="form-control form-control-sm" onchange=""> <option value="">--Seleccionar--</option><?php foreach ($marca as $row){?><option value="<?php echo htmlspecialchars($row->id); ?>"><?php echo htmlspecialchars(addslashes($row->denominiacion)); ?></option><?php }?></select>';
        var unidad = '<select name="unidad[]" id="unidad' + n + '" class="form-control form-control-sm" onChange=""> <option value="">--Seleccionar--</option> <?php foreach ($unidad as $row) {?> <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option> <?php } ?> </select>';
        var cantidad_producto = '<input name="cantidad[]" id="cantidad' + n + '" class="cantidad form-control form-control-sm" value="" type="text" oninput="calcularSubTotal(this)">';
        var precio_dolar = '<input name="precio_dolar[]" id="precio_dolar' + n + '" class="precio_dolar form-control form-control-sm" value="" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, \'\').replace(/(\\..*?)\\..*/g, \'$1\').replace(/(\\d+\\.\\d{0,2}).*/, \'$1\');calcularSoles(this)">';
        var precio_unitario = '<input name="precio_unitario[]" id="precio_unitario' + n + '" class="precio_unitario form-control form-control-sm"'
                              + (bloqueado ? 'readonly' : '') + 
                              ' value="" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, \'\').replace(/(\\..*?)\\..*/g, \'$1\').replace(/(\\d+\\.\\d{0,2}).*/, \'$1\'); calcularSubTotal(this)">';
        var sub_total = '<input name="sub_total[]" id="sub_total' + n + '" class="sub_total form-control form-control-sm" value="" type="text" readonly="readonly">';
        var igv = '<input name="igv[]" id="igv' + n + '" class="igv form-control form-control-sm" value="" type="text" readonly="readonly">';
        var total = '<input name="total[]" id="total' + n + '" class="total form-control form-control-sm" value="" type="text" readonly="readonly">';
        
        var btnEliminar = '<button type="button" class="btn btn-sm btn-clasico btn-eliminar" onclick="eliminarFila(this)"><i class="fas fa-trash" style="font-size:18px;"></i></button>';

        newRow += '<tr>';
        newRow += '<td>' + n + '</td>';
        newRow += '<td style="width: 450px!important; display:block!important">' + descripcion_ant + descripcion + '</td>';
        newRow += '<td>' + codigo + '</td>';
        newRow += '<td>' + marca + '</td>';
        newRow += '<td>' + unidad + '</td>';
        newRow += '<td>' + cantidad_producto + '</td>';
        newRow += '<td class="td_contable">' + precio_dolar + '</td>';
        newRow += '<td>' + precio_unitario + '</td>';
        newRow += '<td>' + sub_total + '</td>';
        newRow += '<td>' + igv + '</td>';
        newRow += '<td>' + total + '</td>';
        newRow += '<td>' + btnEliminar + '</td>';
        newRow += '</tr>';

        $('#tblIngresoSalidaBDetalle tbody').append(newRow);

        $('#descripcion' + n).select2({
            width: '100%',
            dropdownParent: $('#openOverlayOpc'),
            dropdownCssClass: 'custom-select2-dropdown'
        });

        $('#marca' + n).select2({
            width: '100%',
        });

        validarMoneda();
    }
}

function cargarTipoCambioDelDia() {

    var fecha_comprobante = $('#fecha_comprobante').val();

    $.ajax({
        url: "/tipo_cambio/obtenerTipoCambioByFecha/"+fecha_comprobante,
        method: 'GET',
        success: function(response) {
            if (response.length > 0) {
                const tipoCambio = parseFloat(response[0].valor_venta || 0).toFixed(3);
                $('#tipo_cambio_sunat').val(tipoCambio);
            } else {
                bootbox.alert('No se encontró el tipo de cambio del día: ' + fecha_comprobante);
            }
        },
        error: function() {
            bootbox.alert('Error al obtener el tipo de cambio del día: ' + fecha_comprobante);
        }
    });
}

function calcularSubTotal(input) {
    var fila = $(input).closest('tr');

    var igvPorcentaje = $('#igv_compra').val() == 2 ? 1.18 : 0;
    var cantidad = parseFloat(fila.find('.cantidad').val()) || 0;
    var precio_unitario = parseFloat(fila.find('.precio_unitario').val()) || 0;
    var sub_total = 0;
    var igv = 0;
    var total = 0;

    if(igvPorcentaje==1.18){
        sub_total = (cantidad * precio_unitario) / igvPorcentaje;
    }else{
        sub_total = cantidad * precio_unitario;
    }

    if(igvPorcentaje==1.18){
        igv = sub_total * 0.18;
    }

    total = sub_total + igv;

    fila.find('.igv').val(igv.toFixed(2));
    fila.find('.sub_total').val(sub_total.toFixed(2));
    fila.find('.total').val(total.toFixed(2));

    actualizarTotalGeneral();
}

function actualizarTotalGeneral() {
    
    var moneda = $('#moneda').val();
    var tipo_cambio_sunat = $('#tipo_cambio_sunat').val();

    var sub_totalGeneral = 0;
    var igv_totalGeneral = 0;
    var totalGeneral = 0;
    var totalContableGeneral = 0;
    
    $('#tblIngresoSalidaBDetalle tbody tr').each(function() {
        var sub_totalFila = parseFloat($(this).find('.sub_total').val()) || 0;
        var igv_totalFila = parseFloat($(this).find('.igv').val()) || 0;
        var totalFila = parseFloat($(this).find('.total').val()) || 0;
        
        sub_totalGeneral += sub_totalFila;
        igv_totalGeneral += igv_totalFila;
        totalGeneral += totalFila;

        if(moneda == 2){
            var precioDolarFila = parseFloat($(this).find('.precio_dolar').val()) || 0;
            var cantidadFila = parseFloat($(this).find('.cantidad').val()) || 0;
            var totalContable = tipo_cambio_sunat * precioDolarFila * cantidadFila;
            totalContableGeneral += totalContable;
        }
    });
    
    $('#sub_total_general').val(sub_totalGeneral.toFixed(2));
    $('#igv_general').val(igv_totalGeneral.toFixed(2));
    $('#total_general').val(totalGeneral.toFixed(2));
    $('#total_contable_general').val(totalContableGeneral.toFixed(2));
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

    var row = $(button).closest('tr');

    var selectedValue = row.find('select[name="descripcion[]"]').val();

    if (selectedValue) {
        const index = productosSeleccionados.indexOf(Number(selectedValue));
        if (index > -1) {
            productosSeleccionados.splice(index, 1);
        }
    }

    row.remove();

    console.log(productosSeleccionados);
}

function fn_save_ingreso_salida_b(){
	
    var msg = "";

    var tipo_documento = $('#tipo_documento').val();
    var tipo_documento_cliente = $('#tipo_documento_cliente').val();
    var almacen = $('#almacen').val();
    var igv_compra = $('#igv_compra').val();

    if(tipo_documento==""){msg+="Ingrese el Tipo de Documento <br>";}
    if(tipo_documento_cliente==""){msg+="Ingrese el Tipo de Documento Cliente<br>";}
    if(almacen==""){msg+="Ingrese el Almacen <br>";}
    if(igv_compra==""){msg+="Ingrese si Aplica IGV <br>";}
        
    /*if(tipo_documento == 2){
        $('#tblIngresoSalidaBDetalle tbody tr').each(function(index, row) {

            const id_entrada_productos_detalle = parseInt($(row).find('input[name="id_entrada_productos_detalle[]"]').val());
            const cantidad_ingreso_producto = parseInt($(row).find('input[name="cantidad[]"]').val());
            const stockActual = parseInt($(row).find('input[name="stock_actual[]"]').val());
            const descripcion_producto = $(row).find('select[name="descripcion[]"] option:selected').text();

            if(stockActual<cantidad_ingreso_producto && id_entrada_productos_detalle==0){
                msg+="No hay stock para el producto "+descripcion_producto+" <br>";
            }
        });
    }*/

    if ($('#tblIngresoSalidaBDetalle tbody tr').length == 0) {
        msg += "No se ha agregado ningún producto <br>";
    }

    if(msg!=""){
        bootbox.alert(msg);
        return false;
    }else{
        bootbox.confirm({ 
            size: "small",
            message: "&iquest;Est&aacute; seguro que son las cantidades correctas? Porque no se podr&aacute; editar.", 
            callback: function(result){
                if (result==true) {
                    save_ingreso_salida_b();
                }
            }
        });
    }
}

function save_ingreso_salida_b(){

    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

    $.ajax({
        url: "/ingreso_salida_secundarios/send_ingreso_salida_secundario",
        type: "POST",
        data : $("#frmIngresoSalidasB").serialize(),
        success: function (result) {
            $('#openOverlayOpc').modal('hide');
            datatablenew();
            $('.loader').hide();
            bootbox.alert("Se guard&oacute; satisfactoriamente"); 
        }
    });
}

function cambiarCliente(){

    var tipo_documento_cliente = $('#tipo_documento_cliente').val();

    $('#label_empresa').hide();
    $('#select_empresa').hide();
    $('#label_persona').hide();
    $('#select_persona').hide();

    if(tipo_documento_cliente==1){

        $('#label_empresa').hide();
        $('#select_empresa').hide();
        $('#label_persona').show();
        $('#select_persona').show();
        
    }else if(tipo_documento_cliente==5){

        $('#label_empresa').show();
        $('#select_empresa').show();
        $('#label_persona').hide();
        $('#select_persona').hide();
    }else{
        $('#label_empresa').hide();
        $('#select_empresa').hide();
        $('#label_persona').hide();
        $('#select_persona').hide();
    }
}

function habilitarTipoCambio(){

    var moneda = $('#moneda').val();
    $('#fecha_comprobante_label').hide();
    $('#fecha_comprobante_input').hide();
    $('#tipo_cambio_label').hide();
    $('#tipo_cambio_input').hide();
    $('#tipo_cambio_sunat_label').hide();
    $('#tipo_cambio_sunat_input').hide();
    
    
    if(moneda == 1){
        $('#fecha_comprobante_label').hide();
        $('#fecha_comprobante_input').hide();
        $('#tipo_cambio_label').hide();
        $('#tipo_cambio_input').hide();
        $('#tipo_cambio_sunat_label').hide();
        $('#tipo_cambio_sunat_input').hide();
    }else if(moneda == 2){
        $('#fecha_comprobante_label').show();
        $('#fecha_comprobante_input').show();
        $('#tipo_cambio_label').show();
        $('#tipo_cambio_input').show();
        $('#tipo_cambio_sunat_label').show();
        $('#tipo_cambio_sunat_input').show();
    }
}

function validarMoneda() {

    var moneda = $('#moneda').val();

    if (moneda == 2) {
        $('.th_contable, .td_contable').show();
        $('.total-contable-label, .total-contable-input').show();
    } else {
        $('.th_contable, .td_contable').hide();
        $('.total-contable-label, .total-contable-input').hide();
    }
}

function calcularSoles(input){

    var fila = $(input).closest('tr');

    var igvPorcentaje = $('#igv_compra').val() == 2 ? 1.18 : 0;
    var tipo_cambio = $('#tipo_cambio').val();
    var cantidad = parseFloat(fila.find('.cantidad').val()) || 0;
    var precio_dolar = parseFloat(fila.find('.precio_dolar').val()) || 0;
    //var precio_unitario = parseFloat(fila.find('.precio_unitario').val()) || 0;
    var sub_total = 0;
    var igv = 0;
    var total = 0;

    var precio_unitario = precio_dolar * tipo_cambio;

    if(igvPorcentaje==1.18){
        sub_total = (cantidad * precio_unitario) / igvPorcentaje;
    }else{
        sub_total = cantidad * precio_unitario;
    }

    if(igvPorcentaje==1.18){
        igv = sub_total * 0.18;
    }

    total = sub_total + igv;

    fila.find('.precio_unitario').val(precio_unitario.toFixed(2));
    fila.find('.igv').val(igv.toFixed(2));
    fila.find('.sub_total').val(sub_total.toFixed(2));
    fila.find('.total').val(total.toFixed(2));

    actualizarTotalGeneral();

}

</script>

<body class="hold-transition skin-blue sidebar-mini">
    
    <div>
		<div class="justify-content-center">

            <div class="card">
                <div style="text-align: center; font-size:16px; margin-top: 20px">
                    <b>Ingresos y Salidas B</b>
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmIngresoSalidasB" name="frmIngresoSalidasB">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                    
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                    
                    <div class="row" style="padding-left:10px">

                        <div class="col-lg-2">
                            Tipo Documento
                        </div>
                        <div class="col-lg-2">
                            <select name="tipo_documento" id="tipo_documento" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php
                                $selectedDocumento = isset($ingreso_salida_secundario->id_tipo_documento) ? $ingreso_salida_secundario->id_tipo_documento : 1;
                                foreach ($tipo_documento as $row){?>
                                    <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$selectedDocumento)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
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
                                    <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$ingreso_salida_secundario->id_tipo_cliente)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2" id="label_persona">
                            Persona
                        </div>
                        <div class="col-lg-2" id="select_persona">
                            <select name="persona" id="persona" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($personas as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php if($row->id==$ingreso_salida_secundario->id_persona)echo "selected='selected'"?>><?php echo $row->nombres .' '. $row->apellido_paterno .' '. $row->apellido_materno  ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2" id="label_empresa">
                            Empresa
                        </div>
                        <div class="col-lg-2" id="select_empresa">
                            <select name="empresa" id="empresa" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($empresas as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php if($row->id==$ingreso_salida_secundario->id_empresa)echo "selected='selected'"?>><?php echo $row->razon_social ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            Almacen
                        </div>
                        <div class="col-lg-2">
                            <select name="almacen" id="almacen" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php 
                                foreach ($almacen as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php if($row->id==$ingreso_salida_secundario->id_almacen)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            Fecha
                        </div>
                        <div class="col-lg-2">
                            <input id="fecha" name="fecha" on class="form-control form-control-sm"  value="<?php echo isset($ingreso_salida_secundario) && $ingreso_salida_secundario->fecha_ingreso_salida ? $ingreso_salida_secundario->fecha_ingreso_salida : date('Y-m-d'); ?>" type="text">
                        </div>
                        <div class="col-lg-2">
                            N&uacute;mero de Movimiento
                        </div>
                        <div class="col-lg-2">
                            <input id="numero_ingreso_salida" name="numero_ingreso_salida" on class="form-control form-control-sm"  value="<?php if($id>0){echo $ingreso_salida_secundario->numero_ingreso_salida;}?>" type="text" readonly ="readonly">
                        </div>
                        <div class="col-lg-2">
                            Aplica IGV
                        </div>
                        <div class="col-lg-2">
                            <select name="igv_compra" id="igv_compra" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($igv_compra as $row){?>
                                    <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$ingreso_salida_secundario->igv_compra)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            Moneda
                        </div>
                        <div class="col-lg-2">
                            <select name="moneda" id="moneda" class="form-control form-control-sm" onchange="habilitarTipoCambio();validarMoneda()">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($moneda as $row){?>
                                    <option value="<?php echo $row->codigo; ?>" <?php echo ($id > 0 && $row->codigo == $ingreso_salida_secundario->id_moneda) ? "selected='selected'" : (($row->codigo == 1) ? "selected='selected'" : ""); ?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2" id="fecha_comprobante_label">
                            Fecha Comprobante
                        </div>
                        <div class="col-lg-2" id="fecha_comprobante_input">
                            <input id="fecha_comprobante" name="fecha_comprobante" on class="form-control form-control-sm"  value="<?php echo isset($ingreso_salida_secundario) && $ingreso_salida_secundario->fecha_comprobante ? $ingreso_salida_secundario->fecha_comprobante : ''; ?>" type="text" onchange="">
                        </div>
                        <div class="col-lg-2" id="tipo_cambio_label">
                            Tipo de Cambio
                        </div>
                        <div class="col-lg-2" id="tipo_cambio_input">
                            <input id="tipo_cambio" name="tipo_cambio" on class="form-control form-control-sm"  value="<?php if($id>0){echo $ingreso_salida_secundario->tipo_cambio;}?>" type="text">
                        </div>
                        <div class="col-lg-2" id="tipo_cambio_sunat_label">
                            Tipo de Cambio Sunat
                        </div>
                        <div class="col-lg-2" id="tipo_cambio_sunat_input">
                            <input id="tipo_cambio_sunat" name="tipo_cambio_sunat" on class="form-control form-control-sm"  value="<?php if($id>0){echo $ingreso_salida_secundario->tipo_cambio_sunat;}?>" type="text" readonly ="readonly">
                        </div>
                        <div class="col-lg-2" id="observacion_label">
                            Observaci&oacute;n
                        </div>
                        <div class="col-lg-2" id="observacion_input">
                            <input id="observacion" name="observacion" on class="form-control form-control-sm"  value="<?php if($id>0){echo $ingreso_salida_secundario->observacion;}?>" type="text">
                        </div>
                    </div>
                    <div style="margin-top:15px" class="form-group">
                        <div class="col-sm-12 controls">
                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                <?php if($id == 0) {?>
                                    <button type="button" class="btn btn-sm btn-clasico-blanco btn-agregar" data-toggle="modal" onclick="agregarProducto()">
                                        <i class="fas fa-plus-circle" style="font-size:18px;"></i> Agregar
                                    </button>
                                <?php }; ?>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">	

					<div class="table-responsive" style="overflow-y: auto; max-height: 400px;">
						<table id="tblIngresoSalidaBDetalle" class="table table-hover table-sm">
							<thead>
							<tr style="font-size:13px">
								<th>#</th>
								<th>Descripci&oacute;n</th>
                                <th>C&oacute;digo</th>
                                <th>Marca</th>
                                <th>Unidad</th>
                                <th>Cantidad</th>
                                <th class="th_contable">Precio Dolar</th>
                                <th>Precio Venta</th>
                                <th>Sub Total</th>
                                <th>IGV</th>
                                <th>Total</th>
							</tr>
							</thead>
							<tbody id="divIngresoSalidaBDetalle">
							</tbody>
						</table>
					</div>
                    <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; width: 100%; margin: 0 auto; font-size:12px">
                        <tbody>
                            <tr>
                                <td class="td" style ="text-align: left; width: 10%; font-size:13px"><b>Sub-Total:</b></td>
                                <td id="subTotalGeneral" class="td" style="text-align: left; width: 15%; font-size:13px">
                                    <input type="text" name="sub_total_general" id="sub_total_general" class="form-control" value="0.00" readonly style="border: none; background: transparent; text-align: left; pointer-events: none;">
                                </td>
                                <!--<td class="td" style ="text-align: left; width: 10%; font-size:13px"></td>-->
                                <td class="td" style ="text-align: left; width: 10%; font-size:13px"><b>IGV Total:</b></td>
                                <td id="igvGeneral" class="td" style="text-align: left; width: 15%; font-size:13px">
                                    <input type="text" name="igv_general" id="igv_general" class="form-control" value="0.00" readonly style="border: none; background: transparent; text-align: left; pointer-events: none;">
                                </td>
                                <!--<td class="td" style ="text-align: left; width: 10%; font-size:13px"></td>-->
                                <td class="td" style ="text-align: left; width: 10%; font-size:13px"><b>Total:</b></td>
                                <td id="totalGeneral" class="td" style="text-align: left; width: 15%; font-size:13px">
                                    <input type="text" name="total_general" id="total_general" class="form-control" value="0.00" readonly style="border: none; background: transparent; text-align: left; pointer-events: none;">
                                </td>
                                <!--<td class="td" style ="text-align: left; width: 10%; font-size:13px"></td>-->
                                <td class="td total-contable-label" style ="text-align: left; width: 10%; font-size:13px"><b>Total Contable:</b></td>
                                <td id="totalContableGeneral" class="td total-contable-input" style="text-align: left; width: 15%; font-size:13px">
                                    <input type="text" name="total_contable_general" id="total_contable_general" class="form-control" value="0.00" readonly style="border: none; background: transparent; text-align: left; pointer-events: none;">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="margin-top:15px" class="form-group">
                        <div class="col-sm-12 controls">
                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                <?php if($id == 0) {?>
                                <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-nuevo" data-toggle="modal" onclick="fn_save_ingreso_salida_b()">
									<i class="fas fa-save" style="font-size:18px;"></i> Guardar
								</button>
                                <?php }; ?>
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
