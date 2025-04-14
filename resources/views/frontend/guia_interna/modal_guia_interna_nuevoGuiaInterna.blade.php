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

.modal-vehiculo .modal-dialog {
    width: 30% !important;
}

.modal-vehiculo .modal-body {
    height: auto !important;
}


.modal-conductor .modal-dialog {
    width: 40% !important;
}

.modal-conductor .modal-body {
    height: auto !important;
}

.modal-destinatario .modal-dialog {
    width: 70% !important;
}

.modal-destinatario .modal-body {
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

.modal-scrollable {
    max-height: 80vh;
    overflow-y: auto;
}

#motivo_traslado {
    z-index: 1050 !important;  /* Asegúrate de que sea compatible con el z-index del modal */
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

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

    $('#placa_guia').mask('AAA-000');

    //$('#peso').mask('0000000000.00', { reverse: true });

    $('#fecha').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    if($('#id').val()==0){
        //obtenerCodigo();
    }

    if($('#id').val()>0){
        obtenerIdDocumento();
        obtenerEmpresa();
        cambiarPuntoLlegada();
    }

    $("#item").select2({ width: '100%' });
    $("#persona_recibe").select2({ width: '100%' });
    $("#motivo_traslado").select2({ width: '100%' });
    $("#numero_documento").select2({ width: '100%' });
    $("#empresa").select2({ width: '100%' });
	$("#conductor").select2({ width: '100%' });
	$("#marca").select2({ width: '100%' });
    $("#unidad_medida_peso").select2({ width: '100%' });

});

$('#openOverlayOpc').on('hidden.bs.modal', function () {
    $('#motivo_traslado').select2('close'); 
});

$(function() {
    $('#placa_guia').keyup(function() {
        this.value = this.value.toLocaleUpperCase();
    });
});

</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
	 
});

$(document).ready(function() {

    /*if($('#id').val()>0){
        cargarDetalle();
    }*/

    /*if ($('#id').val()==0){
        $('#tblDispensacionDetalle tbody').append(`
            <tr>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button></td>
            </tr>
        `)
    }*/

    $('#fecha_emision').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    $('#fecha_inicio_traslado').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    $('#empresa').select2({ width: '100%' });
    $('#conductor').select2({ width: '100%' });

    obtenerProvinciaPartida();
    obtenerProvinciaLlegada();
    obtenerMotivo();

    if($('#id').val()>0){
		obtenerDatosUbigeoPartida();
        obtenerDatosUbigeoLlegada();
	}
    if($('#id').val()==0){
        $('#select_punto_llegada').hide();
    }

    if($('#placa_guia').val()!=""){
        btnEmpTrans
        btnConductor
    }

    $('#ruc_destinatario_label').hide();
    $('#ruc_destinatario_input').hide();
    $('#dni_destinatario_label').hide();
    $('#dni_destinatario_input').hide();
    $('#empresa_destinatario_label').hide();
    $('#empresa_destinatario_input').hide();
    $('#nombre_destinatario_label').hide();
    $('#nombre_destinatario_input').hide();
    $('#div_descripcion_motivo').hide()

});

function obtenerCodigo(){

    var tipo_documento = $('#tipo_documento').val();

    $.ajax({
        url: "/ingreso_produccion/obtener_codigo_ingreso_produccion/"+tipo_documento,
        dataType: "json",
        success: function (result) {

            //alert(result[0].codigo);
            //console.log(result);
            $('#numero_ingreso_produccion').val(result[0].codigo);

        }
    });

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
            }
        });
}

function obtenerStock(selectElement, n){

    var id_producto = $(selectElement).val();
    var almacen = $('#almacen').val();

    $.ajax({
        url: "/productos/obtener_stock_producto/"+almacen+"/"+id_producto,
        dataType: "json",
        success: function(result){

            var producto_stock = result.producto_stock[id_producto];
            
            $('#stock_actual' + n).val(producto_stock.saldos_cantidad);
        }
    });
}

var productosSeleccionados = [];

function cargarDetalle(){

    var id = $("#id").val();
    const tbody = $('#divIngresoProduccionDetalle');

    tbody.empty();

    $.ajax({
        url: "/ingreso_produccion/cargar_detalle/"+id,
        type: "GET",
        success: function (result) {

            let n = 1;

            //var total_acumulado=0;

            result.ingreso_produccion.forEach(ingreso_produccion => {

                let marcaOptions = '<option value="">--Seleccionar--</option>';
                let productoOptions = '<option value="">--Seleccionar--</option>';
                let estadoBienOptions = '<option value="">--Seleccionar--</option>';
                let unidadMedidaOptions = '<option value="">--Seleccionar--</option>';

                //alert(result.dispensacion[1]);
                
                result.marca.forEach(marca => {
                    let selected = (marca.id == ingreso_produccion.id_marca) ? 'selected' : '';
                    marcaOptions += `<option value="${marca.id}" ${selected}>${marca.denominiacion}</option>`;
                });

                result.producto.forEach(producto => {
                    let selected = (producto.id == ingreso_produccion.id_producto) ? 'selected' : '';
                    productoOptions += `<option value="${producto.id}" ${selected}>${producto.codigo} - ${producto.denominacion}</option>`;
                });

                result.estado_bien.forEach(estado_bien => {
                    let selected = (estado_bien.codigo == ingreso_produccion.id_estado_producto) ? 'selected' : '';
                    estadoBienOptions += `<option value="${estado_bien.codigo}" ${selected}>${estado_bien.denominacion}</option>`;
                });

                result.unidad_medida.forEach(unidad_medida => {
                    let selected = (unidad_medida.codigo == ingreso_produccion.id_unidad_medida) ? 'selected' : '';
                    unidadMedidaOptions += `<option value="${unidad_medida.codigo}" ${selected}>${unidad_medida.denominacion}</option>`;
                });

                //alert(dispensacion.id_producto);

                if (ingreso_produccion.id_producto) {
                    productosSeleccionados.push(ingreso_produccion.id_producto);
                }
                //alert(productosSeleccionados);
               
                const row = `
                    <tr>
                        <td>${n}</td>
                        <td><input name="id_ingreso_produccion_detalle[]" id="id_ingreso_produccion_detalle${n}" class="form-control form-control-sm" value="${ingreso_produccion.id}" type="hidden"><input name="item[]" id="item${n}" class="form-control form-control-sm" value="${ingreso_produccion.item}" type="text" readonly></td>
                        <td style="width: 450px !important;display:block"><select name="descripcion_[]" id="descripcion_${n}" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ${n});" disabled>${productoOptions}</select><input name="descripcion[]" id="descripcion${n}" class="form-control form-control-sm" value="${ingreso_produccion.id_producto}" type="hidden"></td>
                        <td><input name="cod_interno[]" id="cod_interno${n}" class="form-control form-control-sm" value="${ingreso_produccion.codigo}" type="text" readonly></td>
                        <td><select name="marca_[]" id="marca_${n}" class="form-control form-control-sm" disabled>${marcaOptions}</select><input name="marca[]" id="marca${n}" class="form-control form-control-sm" value="${ingreso_produccion.id_marca}" type="hidden"></td>
                        <td><select name="estado_bien_[]" id="estado_bien_${n}" class="form-control form-control-sm" onChange="" disabled>${estadoBienOptions}</select><input name="estado_bien[]" id="estado_bien${n}" class="form-control form-control-sm" value="${ingreso_produccion.id_estado_producto}" type="hidden"></td>
                        <td><select name="unidad_[]" id="unidad_${n}" class="form-control form-control-sm" disabled>${unidadMedidaOptions}</select><input name="unidad[]" id="unidad${n}" class="form-control form-control-sm" value="${ingreso_produccion.id_unidad_medida}" type="hidden"></td>
                        <td><input name="cantidad[]" id="cantidad${n}" class="cantidad form-control form-control-sm" value="${ingreso_produccion.cantidad}" type="text" oninput="calcularCantidadPendiente(this);calcularSubTotal(this)" readonly></td>
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
                //total_acumulado += parseFloat(orden_compra.total);
                });
                //$('#totalGeneral').text(total_acumulado.toFixed(2));
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

    var cantidad = 1;
    var newRow = "";
    for (var i = 0; i < cantidad; i++) { 

        var n = $('#tblIngresoProduccionDetalle tbody tr').length + 1;
        var item = '<input name="id_ingreso_produccion_detalle[]" id="id_ingreso_produccion_detalle' + n + '" class="form-control form-control-sm" value="0" type="hidden"><input name="item[]" id="item' + n + '" class="form-control form-control-sm" value="" type="text">';
        var descripcion = '<select name="descripcion[]" id="descripcion' + n + '" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ' + n + ')"> '+ opcionesDescripcion +' </select>';
        var descripcion_ant = '<input type="hidden" name="descripcion_ant[]" id="descripcion_ant' + n + '" class="form-control form-control-sm" />';
        var cod_interno = '<input name="cod_interno[]" id="cod_interno' + n + '" class="form-control form-control-sm" value="" type="text">';
        var marca = '<select name="marca[]" id="marca' + n + '" class="form-control form-control-sm" onchange=""> <option value="">--Seleccionar--</option><?php foreach ($marca as $row){?><option value="<?php echo htmlspecialchars($row->id); ?>"><?php echo htmlspecialchars(addslashes($row->denominiacion)); ?></option><?php }?></select>';
        var estado_bien =  '<select name="estado_bien[]" id="estado_bien' + n + '" class="form-control form-control-sm" onChange=""><option value="">--Seleccionar--</option> <?php foreach ($estado_bien as $row) { ?> <option value="<?php echo $row->codigo ?>" <?php echo ($row->codigo == 1) ? "selected" : ""; ?>><?php echo $row->denominacion; ?></option> <?php } ?> </select>';
        var unidad = '<select name="unidad[]" id="unidad' + n + '" class="form-control form-control-sm" onChange=""> <option value="">--Seleccionar--</option> <?php foreach ($unidad as $row) {?> <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option> <?php } ?> </select>';
        var cantidad_ingreso = '<input name="cantidad[]" id="cantidad' + n + '" class="cantidad form-control form-control-sm" value="" type="text" oninput="">';
        //var stock_actual = '<input name="stock_actual[]" id="stock_actual' + n + '" class="form-control form-control-sm" value="" type="text">';
        
        var btnEliminar = '<button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button>';

        newRow += '<tr>';
        newRow += '<td>' + n + '</td>';
        newRow += '<td>' + item + '</td>';
        newRow += '<td style="width: 450px!important; display:block!important">' + descripcion_ant + descripcion + '</td>';
        newRow += '<td>' + cod_interno + '</td>';
        newRow += '<td>' + marca + '</td>';
        newRow += '<td>' + estado_bien + '</td>';
        newRow += '<td>' + unidad + '</td>';
        newRow += '<td>' + cantidad_ingreso + '</td>';
        //newRow += '<td>' + stock_actual + '</td>';
        newRow += '<td>' + btnEliminar + '</td>';
        newRow += '</tr>';

        $('#tblIngresoProduccionDetalle tbody').append(newRow);

        $('#descripcion' + n).select2({
            width: '100%',
            dropdownCssClass: 'custom-select2-dropdown'
        });

        $('#marca' + n).select2({
            width: '100%',
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
            //obtenerStock(selectElement, rowIndex);
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

    //actualizarTotalGeneral();

    console.log(productosSeleccionados);
    //$(button).closest('tr').remove();
}

function fn_save_guia_interna(){
	
    var msg = "";

    var fecha_emision = $('#fecha_emision').val();
    var punto_partida = $('#punto_partida').val();
    //var punto_llegada = $('#punto_llegada').val();
    var fecha_inicio_traslado = $('#fecha_inicio_traslado').val();
    //var destinatario = $('#destinatario').val();
    //var ruc = $('#ruc').val();
    var marca_placa = $('#marca_placa').val();
    //var numero_inscripcion = $('#numero_inscripcion').val();
    var numero_licencia = $('#numero_licencia').val();
    //var transporte_razon_social = $('#transporte_razon_social').val();
    //var ruc_transporte = $('#ruc_transporte').val();
    var motivo_traslado = $('#motivo_traslado').val();
    var tipo_documento = $('#tipo_documento').val();
    var numero_documento = $('#numero_documento').val();
    var departamento_partida = $('#departamento_partida').val();
    var provincia_partida = $('#provincia_partida').val();
    var distrito_partida = $('#distrito_partida').val();
    var departamento_llegada = $('#departamento_llegada').val();
    var provincia_llegada = $('#provincia_llegada').val();
    var distrito_llegada = $('#distrito_llegada').val();
    var peso = $('#peso').val();
    var descripcion_motivo = $('#descripcion_motivo').val();

    if(fecha_emision==""){msg+="Ingrese la Fecha de Emision <br>";}
    if(punto_partida==""){msg+="Ingrese el Punto de Partida <br>";}
    //if(punto_llegada==""){msg+="Ingrese el Punto de Llegada <br>";}
    if(fecha_inicio_traslado==""){msg+="Ingrese la Fecha de traslado <br>";}
    //if(destinatario==""){msg+="Ingrese el Destinatario <br>";}
    //if(ruc==""){msg+="Ingrese el RUC de Destinatario <br>";}
    if(marca_placa==""){msg+="Ingrese la Marca y Placa <br>";}
    //if(numero_inscripcion==""){msg+="Ingrese el Numero de Inscripcion <br>";}
    if(numero_licencia==""){msg+="Ingrese el Numero de Licencia <br>";}
    //if(transporte_razon_social==""){msg+="Ingrese el Transporte <br>";}
    //if(ruc_transporte==""){msg+="Ingrese el RUC del Transporte <br>";}
    if(motivo_traslado==""){msg+="Ingrese el Motivo de Traslado <br>";}
    if(tipo_documento==""){msg+="Ingrese el Tipo de Documento <br>";}
    if(numero_documento==""){msg+="Ingrese el Numero de Documento <br>";}
    if(departamento_partida==""){msg+="Ingrese el Departamento de Partida <br>";}   
    if(provincia_partida==""){msg+="Ingrese la Provincia de Partida <br>";}   
    if(distrito_partida==""){msg+="Ingrese el Distrito de Partida <br>";}   
    if(departamento_llegada==""){msg+="Ingrese el Departamento de Llegada <br>";}   
    if(provincia_llegada==""){msg+="Ingrese la Provincia de Llegada <br>";}   
    if(distrito_llegada==""){msg+="Ingrese el Distrito de Llegada <br>";}   
    if(peso==""){msg+="Ingrese el Peso <br>";}

    if(motivo_traslado==13 && descripcion_motivo==""){
        msg+="Ingrese la Descripcion del Traslado <br>";
    }

    if ($('#tblGuiaInternaDetalle tbody tr').length == 0) {
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
            url: "/guia_interna/send_guia_interna",
            type: "POST",
            data : $("#frmDatosGuia").serialize(),
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
}

function pdf_guia_interna(){

    var id = $('#id').val();
    //var tipo_movimiento = $('#tipo_movimiento').val();

    var href = '/guia_interna/guia_interna_pdf/'+id;
    window.open(href, '_blank');

}

function obtener_ruc(){

    destinatario = $('#destinatario').val();

    $.ajax({
        url: "/empresa/obtener_empresa_id/"+destinatario,
        dataType: "json",
        success: function (result) {

            $('#ruc').val(result.empresa[0].ruc);

        }
    });
}

function obtener_ruc_transporte(){

    transporte_razon_social = $('#transporte_razon_social').val();

    $.ajax({
        url: "/empresa/obtener_empresa_id/"+transporte_razon_social,
        dataType: "json",
        success: function (result) {

            $('#ruc_transporte').val(result.empresa[0].ruc);

        }
    });
}

function obtenerIdDocumento(){

    var guia_interna = @json($guia_interna);

    //alert(guia_interna.numero_documento);

    var tipo_documento =  $('#tipo_documento').val();

    $.ajax({
        url: "/entrada_productos/obtener_documentos/"+tipo_documento,
        dataType: "json",
        success: function (result) {

            var option = "<option value=''>--Seleccionar--</option>";

            var numero_documento = $('#numero_documento');

            var seleccionActual = numero_documento.val();
            
            numero_documento.html("");

            var seleccionado = null; 

            $(result).each(function (ii, oo) {
                if (guia_interna && guia_interna.numero_documento == oo.id) {
                    option += "<option value='" + oo.id + "' selected>" + oo.tipo_documento + " - " + oo.codigo + "</option>";
                    seleccionado = oo.id;
                } else {
                    option += "<option value='" + oo.id + "'>" + oo.tipo_documento + " - " + oo.codigo + "</option>";
                }
            });

            numero_documento.html(option);

            numero_documento.select2({ width: '100%' });

            if (seleccionado) {
                numero_documento.val(seleccionado).trigger('change');
                cargar_detalle_documento(seleccionado);
            }

            numero_documento.off("change");
            numero_documento.on("change", function () {
                var valorSeleccionado = $(this).val();

                if (valorSeleccionado) {

                    $(this).val(valorSeleccionado).trigger('change.select2');
                    cargar_detalle_documento(valorSeleccionado);

                }
            });

            numero_documento.select2({ width: '100%' });

        }
    });
}

function cargar_detalle_documento(id_documento){

    var tipo_documento =  $('#tipo_documento').val();

    const tbody = $('#divGuiInternaDetalle');

    tbody.empty();

    $.ajax({
        url: "/entrada_productos/cargar_detalle_documento/"+tipo_documento+"/"+id_documento,
        type: "GET",
        success: function (result) {

            let entrada = result.entrada_producto[0];
            let n = 1;
            let peso_total = 0;
            let peso_producto = 0;

            result.entrada_producto.forEach(entrada_producto => {

                let marcaOptions = '<option value="">--Seleccionar--</option>';
                let productoOptions = '<option value="">--Seleccionar--</option>';
                let estadoBienOptions = '<option value="">--Seleccionar--</option>';
                let unidadMedidaOptions = '<option value="">--Seleccionar--</option>';

                //alert(result.dispensacion[1]);
                
                result.marca.forEach(marca => {
                    let selected = (marca.id == entrada_producto.id_marca) ? 'selected' : '';
                    marcaOptions += `<option value="${marca.id}" ${selected}>${marca.denominiacion}</option>`;
                });

                result.producto.forEach(producto => {
                    let selected = (producto.id == entrada_producto.id_producto) ? 'selected' : '';
                    productoOptions += `<option value="${producto.id}" ${selected}>${producto.codigo} - ${producto.denominacion}</option>`;
                });

                result.estado_bien.forEach(estado_bien => {
                    let selected = (estado_bien.codigo == entrada_producto.id_estado_bien) ? 'selected' : '';
                    estadoBienOptions += `<option value="${estado_bien.codigo}" ${selected}>${estado_bien.denominacion}</option>`;
                });

                result.unidad_medida.forEach(unidad_medida => {
                    let selected = (unidad_medida.codigo == entrada_producto.id_unidad_medida) ? 'selected' : '';
                    unidadMedidaOptions += `<option value="${unidad_medida.codigo}" ${selected}>${unidad_medida.denominacion}</option>`;
                });

                if (entrada_producto.id_producto) {
                    productosSeleccionados.push(entrada_producto.id_producto);
                }
               
                const row = `
                    <tr>
                        <td>${n}</td>
                        <td><input name="id_guia_interna_detalle[]" id="id_guia_interna_detalle${n}" class="form-control form-control-sm" value="${entrada_producto.id}" type="hidden"><input name="item[]" id="item${n}" style="border: none; background-color: transparent; " class="form-control form-control-sm" value="${entrada_producto.item ? entrada_producto.item : ''}" type="text" readonly></td>
                        <td style="width: 450px !important;display:block"><input name="descripcion_[]" id="descripcion_${n}" class="cantidad_ingreso form-control form-control-sm" style="border: none; background-color: transparent; " value="${entrada_producto.nombre_producto}" readonly><input name="descripcion[]" id="descripcion${n}" class="form-control form-control-sm" value="${entrada_producto.id_producto}" type="hidden"></td>
                        <td><input name="cod_interno[]" id="cod_interno${n}" class="form-control form-control-sm" style="border: none; background-color: transparent; " value="${entrada_producto.codigo}" type="text" readonly></td>
                        <td><input name="marca_[]" id="marca_${n}" class="cantidad_ingreso form-control form-control-sm" style="border: none; background-color: transparent; " value="${entrada_producto.nombre_marca ? entrada_producto.nombre_marca : ''}" readonly><input name="marca[]" id="marca${n}" class="form-control form-control-sm" value="${entrada_producto.id_marca ? entrada_producto.id_marca : ''}" type="hidden"></td>
                        <td><input name="estado_bien_[]" id="estado_bien_${n}" class="cantidad_ingreso form-control form-control-sm" style="border: none; background-color: transparent; " value="${entrada_producto.nombre_estado_bien ? entrada_producto.nombre_estado_bien : ''}" readonly><input name="estado_bien[]" id="estado_bien${n}" class="form-control form-control-sm" value="${entrada_producto.id_estado_bien}" type="hidden"></td>
                        <td><input name="unidad_[]" id="unidad_${n}" class="cantidad_ingreso form-control form-control-sm" style="border: none; background-color: transparent; " value="${entrada_producto.nombre_unidad_medida ? entrada_producto.nombre_unidad_medida : ''}" readonly><input name="unidad[]" id="unidad${n}" class="form-control form-control-sm" value="${entrada_producto.id_um}" type="hidden"></td>
                        <td><input name="cantidad[]" id="cantidad${n}" class="cantidad form-control form-control-sm" style="border: none; background-color: transparent; " value="${entrada_producto.cantidad}" type="text" oninput="calcularCantidadPendiente(this);calcularSubTotal(this)" readonly></td>
                    </tr>
                `;
                tbody.append(row);
                /*$('#descripcion_' + n).select2({ 
                    width: '100%',
                    dropdownCssClass: 'custom-select2-dropdown'
                });

                $('#marca_' + n).select2({
                    width: '100%',
                });*/

                n++;

                peso_producto = entrada_producto.peso * entrada_producto.cantidad;

                peso_total += parseFloat(peso_producto) || 0;
                
                //total_acumulado += parseFloat(orden_compra.total);
                });
                //$('#totalGeneral').text(total_acumulado.toFixed(2));
                //alert(peso_total);
                $('#ruc').val("");
                $('#destinatario_nombre').val("");
                $('#destinatario').val("");
                $('#orden_compra_cliente').val("");
                $('#tiendas_orden_compra').val("");
                $('#peso').val("");
                $('#punto_llegada_input').val("");
                $('#tipo_documento_cliente').val("");
                $('#ruc_destinatario_label').val("");
                $('#ruc_destinatario_input').val("");
                $('#dni_destinatario_label').val("");
                $('#dni_destinatario_input').val("");
                $('#empresa_destinatario_label').val("");
                $('#empresa_destinatario_input').val("");
                $('#nombre_destinatario_label').val("");
                $('#nombre_destinatario_input').val("");

                $("#ruc").attr("readonly",false);
                $("#destinatario_nombre").attr("readonly",false);
                $("#orden_compra_cliente").attr("readonly",false);
                $("#tiendas_orden_compra").attr("readonly",false);
                $("#peso").attr("readonly",false);
                $("#punto_llegada_input").attr("readonly",false);
                
                //alert(entrada);

                $('#orden_compra_cliente').val(entrada.numero_orden_compra_cliente);
                $('#tiendas_orden_compra').val(entrada.tiendas);
                $('#peso').val(peso_total.toFixed(2));
                $('#punto_llegada_input').val(entrada.direccion);
                $('#tipo_documento_cliente').val(entrada.id_tipo_cliente);

                if(entrada.id_tipo_cliente=='1'){
                    
                    
                    $('#div_persona').show();
                    $('#div_empresa').hide();
                    $('#div_dni').show();
                    $('#div_ruc').hide();
                    $('#dni_destinatario_label').show();
                    $('#dni_destinatario_input').show();
                    $('#nombre_destinatario_label').show();
                    $('#nombre_destinatario_input').show();

                    $('#dni_destinatario').val(entrada.documento_cliente);
                    $('#persona_destinatario_nombre').val(entrada.cliente);
                    $('#persona_destinatario').val(entrada.id_empresa_compra);

                }else if(entrada.id_tipo_cliente=='5'){

                    $('#div_persona').hide();
                    $('#div_empresa').show();
                    $('#div_dni').hide();
                    $('#div_ruc').show();
                    $('#ruc_destinatario_label').show();
                    $('#ruc_destinatario_input').show();
                    $('#empresa_destinatario_label').show();
                    $('#empresa_destinatario_input').show();

                    $('#ruc').val(entrada.documento_cliente);
                    $('#destinatario_nombre').val(entrada.cliente);
                    $('#destinatario').val(entrada.id_empresa_compra);

                }

                $("#ruc").attr("readonly",true);
                $("#dni_destinatario").attr("readonly",true);
                $("#destinatario_nombre").attr("readonly",true);
                $("#persona_destinatario_nombre").attr("readonly",true);
                $("#orden_compra_cliente").attr("readonly",true);
                $("#tiendas_orden_compra").attr("readonly",true);
                $("#peso").attr("readonly",true);

                
                //$("#punto_llegada_input").attr("readonly",true);

                //$("#destinatario").select2({ width: '100%' });

                if(entrada.ubigeo){
                    obtenerProvinciaContacto(entrada.ubigeo);
                }
                
            }
    });
}

function obtenerProvinciaContacto(ubigeo){
	
	var id = ubigeo.substring(0, 2);
    $('#departamento_llegada').val(id);
	if(id=="")return false;
	$('#provincia_llegada').attr("disabled",true);
	$('#distrito_llegada').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/almacenes/obtener_provincia/'+id,
		dataType: "json",
		success: function(result){
			var option = "<option value='' selected='selected'>--Seleccionar--</option>";
			$('#provincia_llegada').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_provincia+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#provincia_llegada').html(option);
			
			var option2 = "<option value=''>--Seleccionar--</option>";
			$('#distrito_llegada').html(option2);
			
			$('#provincia_llegada').attr("disabled",false);
			$('#distrito_llegada').attr("disabled",false);
			
			$('.loader').hide();
            
            obtenerDatosUbigeoContacto(ubigeo);
		}
	});
    
}

function obtenerDatosUbigeoContacto(ubigeo){

    var provincia = ubigeo.substring(2, 4);

    $('#provincia_llegada').val(provincia);

    obtenerDistritoContacto_(function(){

        $('#distrito_llegada').val(ubigeo);

    });
       
}

function obtenerDistritoContacto_(callback){

    var departamento = $('#departamento_llegada').val();
    var id = $('#provincia_llegada').val();
    if(id=="")return false;
    $('#distrito_llegada').attr("disabled",true);

    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

    $.ajax({
        url: '/almacenes/obtener_distrito/'+departamento+'/'+id,
        dataType: "json",
        success: function(result){
            var option = "<option value=''>Seleccionar</option>";
            $('#distrito_llegada').html("");
            $(result).each(function (ii, oo) {
                option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
            });
            $('#distrito_llegada').html(option);
            
            $('#distrito_llegada').attr("disabled",false);
            $('.loader').hide();

            callback();
        
        }
    });
}

function agregarVehiculo(){
	
	//$(".modal-dialog").css("width","85%");
	//$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/vehiculo/modal_vehiculo_guia/"+0,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc2").html(result);
					$('#openOverlayOpc2').modal('show');

                    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
                    
                    setTimeout(() => {
                        $('#empresa').select2({
                            width: '100%',
                            dropdownParent: $('#openOverlayOpc2')
                        });

                        $('#conductor').select2({
                            width: '100%',
                            dropdownParent: $('#openOverlayOpc2')
                        });
                    }, 100);

                    $('#motivo_traslado').select2('close');
                    //$('.select2-container').remove();
			}
	});
}

function agregarConductor(){
	
	//$(".modal-dialog").css("width","85%");
	//$('#openOverlayOpc .modal-body').css('height', 'auto');
    var id_empresa_conductor_vehiculo = $('#id_empresa_conductor_vehiculo').val();

	$.ajax({
			url: "/conductores/modal_conductor_guia/"+0+"/"+id_empresa_conductor_vehiculo,
			type: "GET",
			success: function (result) {
                $("#diveditpregOpc3").html(result);
                $('#openOverlayOpc3').modal('show');
			}
	});
}

function agregarEmpresaTransporte(){
	
	//$(".modal-dialog").css("width","85%");
	//$('#openOverlayOpc2 .modal-body').css('height', 'auto');
    var placa = $('#placa_guia').val();
    var id_empresa_conductor_vehiculo = $('#id_empresa_conductor_vehiculo').val();

	$.ajax({
			url: "/empresa/modal_empresa_guia/"+0+"/"+placa+"/"+id_empresa_conductor_vehiculo,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc4").html(result);
					$('#openOverlayOpc4').modal('show');
			}
	});
}

function agregarDestinatario(){
	
	//$(".modal-dialog").css("width","85%");
	//$('#openOverlayOpc2 .modal-body').css('height', 'auto');

	$.ajax({
			url: "/empresa/modal_empresa_guia/"+0,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc4").html(result);
					$('#openOverlayOpc4').modal('show');
			}
	});
}

function obtenerEmpresa(){
		
    var placa = $("#placa_guia").val();
    var msg = "";
    
    if (msg != "") {
        bootbox.alert(msg);
        return false;
    }
    
    $('#marca_vehiculo').val("");
    $('#ruc_transporte').val("");
    $('#transporte_razon_social').val("");
    $('#conductor_guia').val("");
    $('#id_empresa_conductor_vehiculo').val("");
    
    $("#placa_guia").attr("readonly",false);
    $("#marca_vehiculo").attr("readonly",false);
    $("#transporte_razon_social").attr("readonly",false);
    //$("#numero_licencia").attr("readonly",false);
    
    $.ajax({
        url: '/ingreso_vehiculo_tronco/obtener_datos_vehiculo_guia/' + placa,
        dataType: "json",
        success: function(result){
            
            if(result.sw==false){
                bootbox.alert(result.msg);
            }else{
                var vehiculo = result.vehiculo;
                $('#ruc_transporte').val(vehiculo.ruc);
                $('#marca_vehiculo').val(vehiculo.marca);
                $('#id_marca_vehiculo').val(vehiculo.id_marca);
                $('#id_transporte_razon_social').val(vehiculo.id_empresas);
                //$('#id_conductor_guia').val(vehiculo.id_conductores);
                $('#transporte_razon_social').val(vehiculo.razon_social);
                $('#id_empresa_conductor_vehiculo').val(vehiculo.id);
                $('#numero_inscripcion').val(vehiculo.constancia_inscripcion);
                //$('#conductor_guia').val(vehiculo.conductor);
                //$('#numero_licencia').val(vehiculo.licencia);
                $("#marca_vehiculo").attr("readonly",true);
                $("#ruc_transporte").attr("readonly",true);
                $("#transporte_razon_social").attr("readonly",true);
                //$("#numero_licencia").attr("readonly",true);
                
                //bootbox.alert("El Vehiculo ingresado ya esta registrado !!!");
                
                //$("#tipo_documento_bus").attr("disabled",true);
                var conductores = result.conductores;
                var option = "<option value=''>Seleccionar</option>";
                $('#conductor_guia').html("");
                var id_conductor = <?php echo json_encode($guia_interna->id_conductor); ?>;

                $(conductores).each(function (ii, oo) {
                    
                    var selected = (oo.id_conductores == id_conductor) ? "selected='selected'" : "";

                    option += "<option value='" + oo.id_conductores + "' " + selected + ">" + oo.conductor + "</option>";
                });
                $('#conductor_guia').html(option);
                
                //$('#conductor_guia').attr("disabled",true);
                //$('.loader').hide();
                
            }
            
        }
        
    });
    
}

function obtenerProvinciaPartida(){
	
	var id = $('#departamento_partida').val();
	if(id=="")return false;
	$('#provincia_partida').attr("disabled",true);
	$('#distrito_partida').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/almacenes/obtener_provincia/'+id,
		dataType: "json",
		success: function(result){
			var option = "<option value='' selected='selected'>--Seleccionar--</option>";
			$('#provincia_partida').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_provincia+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#provincia_partida').html(option);
			
			var option2 = "<option value=''>--Seleccionar--</option>";
			$('#distrito_partida').html(option2);
			
			$('#provincia_partida').attr("disabled",false);
			$('#distrito_partida').attr("disabled",false);
			
			$('.loader').hide();
		}
	});
}

function obtenerDistritoPartida(){
	
	var id_departamento = $('#departamento_partida').val();
	var id = $('#provincia_partida').val();
	if(id=="")return false;
	$('#distrito_partida').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/almacenes/obtener_distrito/'+id_departamento+'/'+id,
		dataType: "json",
		success: function(result){
			var option = "<option value=''>Seleccionar</option>";
			$('#distrito_partida').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#distrito_partida').html(option);
			
			$('#distrito_partida').attr("disabled",false);
			$('.loader').hide();
		}
	});
}

function obtenerProvinciaLlegada(){
	
	var id = $('#departamento_llegada').val();
	if(id=="")return false;
	$('#provincia_llegada').attr("disabled",true);
	$('#distrito_llegada').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/almacenes/obtener_provincia/'+id,
		dataType: "json",
		success: function(result){
			var option = "<option value='' selected='selected'>--Seleccionar--</option>";
			$('#provincia_llegada').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_provincia+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#provincia_llegada').html(option);
			
			var option2 = "<option value=''>--Seleccionar--</option>";
			$('#distrito_llegada').html(option2);
			
			$('#provincia_llegada').attr("disabled",false);
			$('#distrito_llegada').attr("disabled",false);
			
			$('.loader').hide();
		}
	});
}

function obtenerDistritoLlegada(){
	
	var id_departamento = $('#departamento_llegada').val();
	var id = $('#provincia_llegada').val();
	if(id=="")return false;
	$('#distrito_llegada').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/almacenes/obtener_distrito/'+id_departamento+'/'+id,
		dataType: "json",
		success: function(result){
			var option = "<option value=''>Seleccionar</option>";
			$('#distrito_llegada').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#distrito_llegada').html(option);
			
			$('#distrito_llegada').attr("disabled",false);
			$('.loader').hide();
		}
	});
}

function obtenerDatosUbigeoPartida(){

    var id = $('#id').val();

    $.ajax({
        url: '/guia_interna/obtener_provincia_distrito/'+id,
        dataType: "json",
        success: function(result){
            
            //alert(result[0].distrito_partida);

            $('#provincia_partida').val(result[0].provincia_partida);

            obtenerDistritoPartida_(function(){

                $('#distrito_partida').val(result[0].distrito_partida);

            });
        }
    });
}

function obtenerDistritoPartida_(callback){
    
    var departamento = $('#departamento_partida').val();
    var id = $('#provincia_partida').val();
    if(id=="")return false;
    $('#distrito_partida').attr("disabled",true);

    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

    $.ajax({
        url: '/almacenes/obtener_distrito/'+departamento+'/'+id,
        dataType: "json",
        success: function(result){
            var option = "<option value=''>Seleccionar</option>";
            $('#distrito_partida').html("");
            $(result).each(function (ii, oo) {
                option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
            });
            $('#distrito_partida').html(option);
            
            $('#distrito_partida').attr("disabled",false);
            $('.loader').hide();

            callback();
        
        }
    });
}

function obtenerDatosUbigeoLlegada(){

    var id = $('#id').val();

    $.ajax({
        url: '/guia_interna/obtener_provincia_distrito/'+id,
        dataType: "json",
        success: function(result){
            
            //alert(result[0].provincia);

            $('#provincia_llegada').val(result[0].provincia_llegada);

            obtenerDistritoLlegada_(function(){

                $('#distrito_llegada').val(result[0].distrito_llegada);

            });
        }
    });
}

function obtenerDistritoLlegada_(callback){

    var departamento = $('#departamento_llegada').val();
    var id = $('#provincia_llegada').val();
    if(id=="")return false;
    $('#distrito_llegada').attr("disabled",true);

    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

    $.ajax({
        url: '/almacenes/obtener_distrito/'+departamento+'/'+id,
        dataType: "json",
        success: function(result){
            var option = "<option value=''>Seleccionar</option>";
            $('#distrito_llegada').html("");
            $(result).each(function (ii, oo) {
                option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
            });
            $('#distrito_llegada').html(option);
            
            $('#distrito_llegada').attr("disabled",false);
            $('.loader').hide();

            callback();
        
        }
    });
}

function obtenerNumeroGuia(){

    var serie_guia = $('#serie_guia').val();

    $.ajax({
        url: "/guia_interna/obtener_numero_guia/"+serie_guia,
        dataType: "json",
        success: function(result){
            //alert(result[0].codigo);
            $('#numero_guia').val(result[0].codigo);
        }
    });
}

function cambiarPuntoLlegada(){

    var motivo_traslado = $('#motivo_traslado').val();

    if(motivo_traslado=='04'){
        $('#select_punto_llegada').show();
        $('#input_punto_llegada').hide();
    }else{
        $('#select_punto_llegada').hide();
        $('#input_punto_llegada').show();
    }

}

$('#punto_partida').on('change', function(){

    var descripcion = $('#punto_partida option:selected').text();

    $('#punto_partida_descripcion').val(descripcion);

});

$('#punto_llegada_select').on('change', function(){

    var descripcion = $('#punto_llegada_select option:selected').text();

    $('#punto_llegada_descripcion').val(descripcion);

});

function generarGuia(){

    var numero_guia = $('#id').val();

    numero_guia = parseInt(numero_guia,10);

    $.ajax({
        url: "/comprobante/guia_json/"+numero_guia,
        dataType: "json",
        success: function(result){
            console.log(result);
            if (result.notes == "FIRMADO") {
                bootbox.alert("El documento ha sido firmado correctamente.");
            } else {
                bootbox.alert(result.notes);
            }
        }
    });
}

function obtenerLicencia(){

    var conductor_guia = $('#conductor_guia').val();

    $('#numero_licencia').val("");
    $("#numero_licencia").attr("readonly",false);

    if(conductor_guia==0){
        $('#numero_licencia').val("");
        $("#numero_licencia").attr("readonly",false);
    }else{

    $.ajax({
        url: "/conductores/obtener_licencia/"+conductor_guia,
        dataType: "json",
        success: function(result){
            //bootBox.alert("Se envió a la Sunat la Guia");

            var conductores = result.conductores;
            $('#numero_licencia').val(conductores[0].licencia);
            $("#numero_licencia").attr("readonly",false);
        }
    });
    }
}

function obtenerUbigeo() {
    if ($('#punto_partida').val() == "0001"){
        $('#departamento_partida').val(15);
        obtenerProvinciaPartida_edit(function () {
            $('#provincia_partida').val("01");
            obtenerDistritoPartida_edit(function () {
                $('#distrito_partida').val("150142");
            });
        });
    }else if($('#punto_partida').val() == "0003"){
        $('#departamento_partida').val(19);
        obtenerProvinciaPartida_edit(function () {
            $('#provincia_partida').val("03");
            obtenerDistritoPartida_edit(function () {
                $('#distrito_partida').val("190301");
            });
        });
    }
}

function obtenerProvinciaPartida_edit(callback){
	
	var id = $('#departamento_partida').val();
	if(id=="")return false;
	$('#provincia_partida').attr("disabled",true);
	$('#distrito_partida').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/almacenes/obtener_provincia/'+id,
		dataType: "json",
		success: function(result){
			var option = "<option value='' selected='selected'>--Seleccionar--</option>";
			$('#provincia_partida').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_provincia+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#provincia_partida').html(option);
			
			var option2 = "<option value=''>--Seleccionar--</option>";
			$('#distrito_partida').html(option2);
			
			$('#provincia_partida').attr("disabled",false);
			$('#distrito_partida').attr("disabled",false);
			
			$('.loader').hide();

            if (callback) callback(); 
		}
	});
}

function obtenerDistritoPartida_edit(callback){
	
	var id_departamento = $('#departamento_partida').val();
	var id = $('#provincia_partida').val();
	if(id=="")return false;
	$('#distrito_partida').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/almacenes/obtener_distrito/'+id_departamento+'/'+id,
		dataType: "json",
		success: function(result){
			var option = "<option value=''>Seleccionar</option>";
			$('#distrito_partida').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#distrito_partida').html(option);
			
			$('#distrito_partida').attr("disabled",false);
			$('.loader').hide();

            if (callback) callback(); 

		}
	});
}

function obtenerMotivo(){

    var motivo_traslado = $('#motivo_traslado').val();

    if(motivo_traslado==13){
        $('#div_descripcion_motivo').show();
    }else{
        $('#descripcion_motivo').val('');
        $('#div_descripcion_motivo').hide();
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

            <div class="card modal-scrollable">
                <!--<div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <img width="200px" height="80px" style="top:-30px" src="/img/logo_forestalpama.jpg">
                    </div>
                </div>-->
                <div style="text-align: center; font-size:16px; margin-top: 20px">
                    <b>Datos de Guia</b>
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmDatosGuia" name="frmDatosGuia">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                    
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                    
                <div class="row" style="padding-left:10px; padding-bottom:10px;">
                    <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    Serie
                                </div>
                                <div class="col-lg-5">
                                    <select name="serie_guia" id="serie_guia" class="form-control form-control-sm" onchange="//obtenerNumeroGuia()">
                                        <option value="">--Seleccionar--</option>
                                        <?php 
                                        foreach ($serie_guia as $row){?>
                                            <option value="<?php echo $row->denominacion ?>" <?php echo ($id > 0 && $row->denominacion==$guia_interna->guia_serie) ? "selected='selected'" : (($row->denominacion == "T001")  ? "selected='selected'" : "");?>><?php echo $row->denominacion ?></option>
                                            <?php 
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    N&uacute;mero
                                </div>
                                <div class="col-lg-5">
                                    <input id="numero_guia" name="numero_guia" on class="form-control form-control-sm"  value="<?php echo ($id>0) ? str_pad($guia_interna->guia_numero, 4, '0', STR_PAD_LEFT) :''; ?> " type="text" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding-left:10px; padding-bottom:10px;">

                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    Fecha de Emisi&oacute;n
                                </div>
                                <div class="col-lg-5">
                                    <input id="fecha_emision_" name="fecha_emision_" on class="form-control form-control-sm"  value="<?php echo isset($guia_interna) && $guia_interna->fecha_emision ? $guia_interna->fecha_emision : date('Y-m-d'); ?>" type="text" disabled="disabled">
                                    <input type="hidden" name="fecha_emision" id="fecha_emision" value="<?php echo isset($guia_interna) && $guia_interna->fecha_emision ? $guia_interna->fecha_emision : date('Y-m-d'); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    Tipo Documento
                                </div>
                                <div class="col-lg-5">
                                    <select name="tipo_documento" id="tipo_documento" class="form-control form-control-sm" onchange="obtenerIdDocumento()">
                                        <option value="" <?= empty($guia_interna->id_tipo_documento) ? "selected='selected'" : "" ?>>--Seleccionar--</option>
                                        <option value="1" <?= $guia_interna->id_tipo_documento == 1 ? "selected='selected'" : "" ?>>NOTA DE RECEPCION</option>
                                        <option value="2" <?= $guia_interna->id_tipo_documento == 2 ? "selected='selected'" : "" ?>>NOTA DE SALIDA</option>
                                        <option value="3" <?= $guia_interna->id_tipo_documento == 3 ? "selected='selected'" : "" ?>>DEVOLUCI&Oacute;N</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    N° Documento
                                </div>
                                <div class="col-lg-5">
                                    <select name="numero_documento" id="numero_documento" class="form-control form-control-sm">
                                        <option value="">--Seleccionar--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding-left:10px; padding-bottom:10px;">
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    N° de Placa
                                </div>
                                <div class="col-lg-5">
                                    <input id="placa_guia" name="placa_guia" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_interna->placa;} ?>" type="text" onchange="obtenerEmpresa()">
                                    <input name="id_empresa_conductor_vehiculo" id="id_empresa_conductor_vehiculo" class="form-control form-control-sm" value="" type="hidden">
                                </div>
                                <div class="col-lg-3">
                                    <button id="btnPlaca" type="button" class="btn btn-warning btn-sm" data-toggle="modal" onclick="agregarVehiculo()">
                                        <i class="fas fa-plus-circle"></i>Vehiculo
                                        <!--<img src="/img/icono_carro.png" alt="Carro" style="width: 16px; height: 16px; margin-left: 5px;">-->
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    Marca Vehiculo
                                </div>
                                <div class="col-lg-5">
                                    <input id="marca_vehiculo" name="marca_vehiculo" on class="form-control form-control-sm"  value="<?php //if($id>0){echo $guia_interna->placa;} ?>" type="text">
                                    <input name="id_marca_vehiculo" id="id_marca_vehiculo" class="form-control form-control-sm" value="" type="hidden">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    RUC Transporte
                                </div>
                                <div class="col-lg-5">
                                    <input id="ruc_transporte" name="ruc_transporte" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_interna->ruc_empresa_transporte;} ?>" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding-left:10px; padding-bottom:10px;">
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    Raz&oacute;n Social Transporte
                                </div>
                                <div class="col-lg-5">
                                    <input id="transporte_razon_social" name="transporte_razon_social" on class="form-control form-control-sm"  value="<?php //if($id>0){echo $guia_interna->placa;} ?>" type="text">
                                    <input name="id_transporte_razon_social" id="id_transporte_razon_social" class="form-control form-control-sm" value="" type="hidden">
                                </div>
                                <div class="col-lg-3">
                                    <button id="btnEmpTrans" type="button" class="btn btn-warning btn-sm" data-toggle="modal" onclick="agregarEmpresaTransporte()">
                                        <i class="fas fa-plus-circle"></i>Emp. Transp.
                                        <!--<img src="/img/icono_empresa_trasnporte.png" alt="Carro" style="width: 20px; height: 20px; margin-left: 3px;">-->
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    Conductor
                                </div>
                                <div class="col-lg-5">
                                    <select name="conductor_guia" id="conductor_guia" class="form-control form-control-sm" onchange="obtenerLicencia()">
                                        <option value="">--Seleccionar--</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <button id="btnConductor" type="button" class="btn btn-warning btn-sm" data-toggle="modal" onclick="agregarConductor()">
                                        <i class="fas fa-plus-circle"></i>Conductor
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!--<div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    Conductor
                                </div>
                                <div class="col-lg-5">
                                    <input id="conductor_guia" name="conductor_guia" on class="form-control form-control-sm"  value="<?php //if($id>0){echo $guia_interna->licencia_conducir;} ?>" type="text">
                                    <input name="id_conductor_guia" id="id_conductor_guia" class="form-control form-control-sm" value="" type="hidden">
                                </div>
                                <div class="col-lg-3">
                                    <button id="btnPlaca" type="button" class="btn btn-warning btn-sm" data-toggle="modal" onclick="agregarConductor()">
                                        <i class="fas fa-plus-circle"></i>Conductor
                                    </button>
                                </div>
                            </div>
                        </div>-->
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    N° de Licencia de Conducir
                                </div>
                                <div class="col-lg-5">
                                    <input id="numero_licencia" name="numero_licencia" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_interna->licencia_conducir;} ?>" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding-left:10px; padding-bottom:10px;">
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    N° Constancia Inscripci&oacute;n
                                </div>
                                <div class="col-lg-5">
                                    <input id="numero_inscripcion" name="numero_inscripcion" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_interna->constancia_inscripcion;} ?>" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    Motivo Traslado
                                </div>
                                <div class="col-lg-5">
                                    <select name="motivo_traslado" id="motivo_traslado" class="form-control form-control-sm" onchange="cambiarPuntoLlegada(); obtenerMotivo();">
                                        <option value="">--Seleccionar--</option>
                                        <?php 
                                        foreach ($motivo_traslado as $row){?>
                                            <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$guia_interna->id_motivo_traslado)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                            <?php 
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" id="div_descripcion_motivo">
                            <div class="row">
                                <div class="col-lg-4">
                                    Descripci&oacute;n Motivo
                                </div>
                                <div class="col-lg-5">
                                    <input id="descripcion_motivo" name="descripcion_motivo" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_interna->descripcion_motivo;}?>" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    Costo M&iacute;nimo
                                </div>
                                <div class="col-lg-5">
                                    <input id="costo_minimo" name="costo_minimo" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_interna->costo_minimo;}?>" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding-left:10px; padding-bottom:10px;">
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    Fecha de Inicio Traslado
                                </div>
                                <div class="col-lg-5">
                                    <input id="fecha_inicio_traslado" name="fecha_inicio_traslado" on class="form-control form-control-sm"  value="<?php echo isset($guia_interna) && $guia_interna->fecha_traslado ? $guia_interna->fecha_traslado : date('Y-m-d'); ?>" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    Tipo Documento Cliente
                                </div>
                                <div class="col-lg-5">
                                    <select name="tipo_documento_cliente" id="tipo_documento_cliente" class="form-control form-control-sm" onchange="cambiarCliente()">
                                        <option value="">--Seleccionar--</option>
                                        <?php
                                        foreach ($tipo_documento_cliente as $row){?>
                                            <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$guia_interna->id_tipo_cliente)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                            <?php 
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" id="div_ruc">
                            <div class="row">
                                <div class="col-lg-4" id="ruc_destinatario_label">
                                    RUC Destinatario
                                </div>
                                <div class="col-lg-5" id="ruc_destinatario_input">
                                    <input id="ruc" name="ruc" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_interna->ruc_destinatario;} ?>" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" id="div_dni">
                            <div class="row">
                                <div class="col-lg-4" id="dni_destinatario_label">
                                    DNI Destinatario
                                </div>
                                <div class="col-lg-5" id="dni_destinatario_input">
                                    <input id="dni_destinatario" name="dni_destinatario" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_interna->dni_destinatario;} ?>" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" id="div_empresa">
                            <div class="row">
                                <div class="col-lg-4" id="empresa_destinatario_label">
                                    Nombre Destinatario
                                </div>
                                <div class="col-lg-5" id="empresa_destinatario_input">
                                    <input id="destinatario_nombre" name="destinatario_nombre" on class="form-control form-control-sm"  value="<?php //if($id>0){echo $guia_interna->licencia_conducir;} ?>" type="text">
                                    <input name="destinatario" id="destinatario" class="form-control form-control-sm" value="" type="hidden">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" id="div_persona">
                            <div class="row">
                                <div class="col-lg-4" id="nombre_destinatario_label">
                                    Nombre Destinatario
                                </div>
                                <div class="col-lg-5" id="nombre_destinatario_input">
                                    <input id="persona_destinatario_nombre" name="persona_destinatario_nombre" on class="form-control form-control-sm"  value="<?php //if($id>0){echo $guia_interna->licencia_conducir;} ?>" type="text">
                                    <input name="persona_destinatario" id="persona_destinatario" class="form-control form-control-sm" value="" type="hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding-left:10px; padding-bottom:10px;">
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    N° Orden Compra Cliente
                                </div>
                                <div class="col-lg-5">
                                    <input id="orden_compra_cliente" name="orden_compra_cliente" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_interna->numero_orden_compra_cliente;} ?>" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    Tiendas
                                </div>
                                <div class="col-lg-5">
                                    <input id="tiendas_orden_compra" name="tiendas_orden_compra" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_interna->tiendas;} ?>" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    Observaci&oacute;n
                                </div>
                                <div class="col-lg-8">
                                    <input id="observacion_guia" name="observacion_guia" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_interna->observacion;} ?>" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding-left:10px; padding-bottom:10px;">
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    Unidad Medida Peso
                                </div>
                                <div class="col-lg-5">
                                    <select name="unidad_medida_peso" id="unidad_medida_peso" class="form-control form-control-sm" onchange="">
                                        <option value="">--Seleccionar--</option>
                                        <?php 
                                        foreach ($unidad_peso as $row){?>
                                            <option value="<?php echo $row->codigo ?>" <?php //if($row->codigo==$guia_interna->id_motivo_traslado)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                            <?php 
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    Peso
                                </div>
                                <div class="col-lg-5">
                                    <input id="peso" name="peso" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_interna->peso;} ?>" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <fieldset name="punto_partida_name" style="border:1px solid #A4A4A4; padding: 10px">
                        <legend class="control-label form-control-sm">Punto de Partida</legend>
                        <div class="row" style="padding-left:10px; padding-bottom:10px;">
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-4">
                                        Departamento
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <select name="departamento_partida" id="departamento_partida" onChange="obtenerProvinciaPartida()" class="form-control form-control-sm">
                                                <?php if($id>0){ ?> 
                                                <option value="">--Seleccionar--</option>
                                                <?php
                                                foreach ($departamento as $row) {?>
                                                <option value="<?php echo $row->id_departamento?>" <?php if($row->id_departamento==substr($guia_interna->id_ubigeo_partida,0,2))echo "selected='selected'"?>><?php echo $row->desc_ubigeo ?></option>
                                                <?php 
                                                }
                                                }else{?>
                                                <option value="">--Seleccionar--</option>
                                                    <?php
                                                    foreach ($departamento as $row) {
                                                    ?>
                                                    <option value="<?php echo $row->id_departamento?>"><?php echo $row->desc_ubigeo ?></option>
                                                    <?php 
                                                        
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-4">
                                        Provincia
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <select name="provincia_partida" id="provincia_partida" class="form-control form-control-sm" onchange="obtenerDistritoPartida()">
                                                <option value="">--Seleccionar--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-4">
                                        Distrito
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <select name="distrito_partida" id="distrito_partida" class="form-control form-control-sm" onchange="">
                                                <option value="">--Seleccionar--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-3">
                                        Punto de Partida
                                    </div>
                                    <div class="col-lg-9">
                                        <select name="punto_partida" id="punto_partida" class="form-control form-control-sm" onchange="obtenerUbigeo()">
                                            <option value="">--Seleccionar--</option>
                                            <?php 
                                            foreach ($punto_partida as $row){?>
                                                <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$guia_interna->guia_cod_estab_partida)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
                                        <input name="punto_partida_descripcion" id="punto_partida_descripcion" type="hidden">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset name="punto_llegada_name" style="border:1px solid #A4A4A4; padding: 10px">
                        <legend class="control-label form-control-sm">Punto de Llegada</legend>
                    
                        <div class="row" style="padding-left:10px; padding-bottom:10px;">
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-4">
                                        Departamento
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <select name="departamento_llegada" id="departamento_llegada" onChange="obtenerProvinciaLlegada()" class="form-control form-control-sm">
                                                <?php if($id>0){ ?> 
                                                <option value="">--Seleccionar--</option>
                                                <?php
                                                foreach ($departamento as $row) {?>
                                                <option value="<?php echo $row->id_departamento?>" <?php if($row->id_departamento==substr($guia_interna->id_ubigeo_llegada,0,2))echo "selected='selected'"?>><?php echo $row->desc_ubigeo ?></option>
                                                <?php 
                                                }
                                                }else{?>
                                                <option value="">--Seleccionar--</option>
                                                    <?php
                                                    foreach ($departamento as $row) {
                                                    ?>
                                                    <option value="<?php echo $row->id_departamento?>"><?php echo $row->desc_ubigeo ?></option>
                                                    <?php 
                                                        
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-4">
                                        Provincia
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <select name="provincia_llegada" id="provincia_llegada" class="form-control form-control-sm" onchange="obtenerDistritoLlegada()">
                                                <option value="">--Seleccionar--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-4">
                                        Distrito
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <select name="distrito_llegada" id="distrito_llegada" class="form-control form-control-sm" onchange="">
                                                <option value="">--Seleccionar--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3" id="select_punto_llegada">
                                <div class="row">
                                    <div class="col-lg-3">
                                        Punto de Llegada
                                    </div>
                                    <div class="col-lg-9">
                                        <select name="punto_llegada_select" id="punto_llegada_select" class="form-control form-control-sm">
                                            <option value="">--Seleccionar--</option>
                                            <?php 
                                            foreach ($punto_partida as $row){?>
                                                <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$guia_interna->guia_cod_estab_llegada)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
                                        <input name="punto_llegada_descripcion" id="punto_llegada_descripcion" type="hidden">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3" id="input_punto_llegada">
                                <div class="row">
                                    <div class="col-lg-3">
                                        Punto de Llegada
                                    </div>
                                    <div class="col-lg-9">
                                        <input id="punto_llegada_input" name="punto_llegada_input" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_interna->punto_llegada;}?>" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="card-body">	

					<div class="table-responsive" style="overflow-y: auto; max-height: 300px;">
						<table id="tblGuiaInternaDetalle" class="table table-hover table-sm">
							<thead>
							<tr style="font-size:13px">
								<th>#</th>
								<th>Item</th>
								<th>Descripci&oacute;n</th>
                                <th>COD. INT.</th>
                                <th>Marca</th>
                                <th>Estado Bien</th>
                                <th>Unidad</th>
                                <th>Cantidad</th>
							</tr>
							</thead>
							<tbody id="divGuiInternaDetalle">
							</tbody>
						</table>
					</div>
                    <!--<table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; width: 100%; margin: 0 auto; font-size:12px">
                        <tbody>
                            <tr>
                                <td class="td" style ="text-align: left; width: 90%; font-size:13px"></td>
                                <td class="td" style ="text-align: left; width: 5%; font-size:13px"><b>Total:</b></td>
                                <td id="totalGeneral" class="td" style="text-align: left; width: 5%; font-size:13px">0.00</td>
                            </tr>
                        </tbody>
                    </table>-->
                    <div style="margin-top:15px" class="form-group">
                        <div class="col-sm-12 controls">
                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                <?php 
                                    if($id>0){
                                ?>
                                <!--<button style="font-size:12px;margin-left:10px; margin-right:10px" type="button" class="btn btn-sm btn-primary" data-toggle="modal" onclick="pdf_guia_interna()"><i class="fa fa-print" ></i>Imprimir</button>
                                <button style="font-size:12px;margin-left:10px; margin-right:100px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="pdf_guia()" ><i class="fa fa-edit"></i>Imprimir Gu&iacute;a Remisi&oacute;n Electronica</button>
                                <a href="javascript:void(0)" onClick="fn_pdf_documento()" class="btn btn-sm btn-primary" style="margin-right:100px">Imprimir</a>-->
                                <?php 
                                    }
                                ?>
                                <?php if($id_user==$guia_interna->id_usuario_inserta && $id>0 && $guia->guia_estado_sunat !='FIRMADO'){?>
                                    <a href="javascript:void(0)" onClick="fn_save_guia_interna()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>
                                <?php }?>
                                <?php if($id==0){?>
                                    <a href="javascript:void(0)" onClick="fn_save_guia_interna()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>
                                <?php }?>

                                <?php 
                                    if($id>0 && $guia->guia_estado_sunat !='FIRMADO'){
                                ?>
                                    <a href="javascript:void(0)" onClick="generarGuia()" class="btn btn-sm btn-danger" style="margin-right:10px"><i class="fa fa-paper-plane"></i>Enviar Sunat</a> 
                                <?php } if($id>0 && $guia->guia_estado_sunat =='FIRMADO'){?>
                                    <a href="javascript:void(0)" onClick="generarGuia()" class="btn btn-sm btn-danger" style="margin-right:10px; pointer-events: none; opacity: 0.6; cursor: not-allowed;"><i class="fa fa-paper-plane"></i>Enviar Sunat</a> 
                                <?php }?>

                                <?php if($id>0 && $guia->guia_estado_sunat =='FIRMADO'){?>
                                    <a href="http://forespama.felmo.pe/<?php echo $guia->guia_ruta_comprobante;?>" target="_blank" class="btn btn-sm btn-warning" style="margin-right:10px"><i class="fa fa-file-pdf"></i>Ver Gu&iacute;a</a>
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

<div id="openOverlayOpc2" class="modal fade modal-vehiculo" tabindex="-1" role="dialog">
    <div class="modal-dialog" >

    <div id="id_content_OverlayoneOpc" class="modal-content" style="padding: 0px;margin: 0px">

        <div class="modal-body" style="padding: 0px;margin: 0px">

            <div id="diveditpregOpc2"></div>

        </div>

    </div>

    </div>

</div>

<div id="openOverlayOpc3" class="modal fade modal-conductor" tabindex="-1" role="dialog">
    <div class="modal-dialog" >

    <div id="id_content_OverlayoneOpc" class="modal-content" style="padding: 0px;margin: 0px">

        <div class="modal-body" style="padding: 0px;margin: 0px">

            <div id="diveditpregOpc3"></div>

        </div>

    </div>

    </div>

</div>

<div id="openOverlayOpc4" class="modal fade modal-destinatario" tabindex="-1" role="dialog">
    <div class="modal-dialog" >

    <div id="id_content_OverlayoneOpc" class="modal-content" style="padding: 0px;margin: 0px">

        <div class="modal-body" style="padding: 0px;margin: 0px">

            <div id="diveditpregOpc4"></div>

        </div>

    </div>

    </div>

</div>
    
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

