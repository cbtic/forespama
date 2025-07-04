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
        url: "/requerimiento/cargar_detalle_abierto/"+id,
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
                        <td style="width: 450px !important;display:block"><input name="id_requerimiento_detalle[]" id="id_requerimiento_detalle${n}" class="form-control form-control-sm" value="${requerimiento.id}" type="hidden"><input name="descripcion[]" id="descripcion${n}" class="form-control form-control-sm" value="${requerimiento.id_producto}" type="hidden"><select name="descripcion_[]" id="descripcion_${n}" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ${n});" disabled>${productoOptions}</select></td>
                        <td><input name="marca[]" id="marca${n}" class="form-control form-control-sm" value="${requerimiento.id_marca}" type="hidden"><select name="marca_[]" id="marca_${n}" class="form-control form-control-sm" disabled>${marcaOptions}</select></td>
                        <td><input name="cod_interno[]" id="cod_interno${n}" class="form-control form-control-sm" value="${requerimiento.codigo}" type="text" readonly></td>
                        <td><input name="estado_bien[]" id="estado_bien${n}" class="form-control form-control-sm" value="${requerimiento.id_estado_producto}" type="hidden"><select name="estado_bien_[]" id="estado_bien_${n}" class="form-control form-control-sm" onChange="" disabled>${estadoBienOptions}</select></td>
                        <td><input name="unidad[]" id="unidad${n}" class="form-control form-control-sm" value="${requerimiento.id_unidad_medida}" type="hidden"><select name="unidad_[]" id="unidad_${n}" class="form-control form-control-sm" disabled>${unidadMedidaOptions}</select></td>
                        <td><input name="cantidad_ingreso[]" id="cantidad_ingreso${n}" class="cantidad_ingreso form-control form-control-sm" value="${requerimiento.cantidad}" type="text" oninput="" readonly></td>
                        <td><input name="cantidad_atendida[]" id="cantidad_atendida${n}" class="form-control form-control-sm" value="${requerimiento.cantidad-requerimiento.cantidad_atendida}" type="text"></td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button></td>
                        <td><button type="button" class="btn btn-success btn-sm" onclick="modalObservacion(${n})">Observacion</button></td>
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
        var n = $('#tblRequerimientoDetalle tbody tr').length + 1;
        var item = '<input name="id_requerimiento_detalle[]" id="id_requerimiento_detalle${n}" class="form-control form-control-sm" value="${requerimiento.id}" type="hidden"><input name="item[]" id="item' + n + '" class="form-control form-control-sm" value="" type="text">';
        //var cantidad = '<input name="cantidad[]" id="cantidad' + n + '" class="form-control form-control-sm" value="" type="text">';
        var descripcion = '<select name="descripcion[]" id="descripcion' + n + '" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ' + n + ')"> '+ opcionesDescripcion +' </select>';
        var descripcion_ant = '<input type="hidden" name="descripcion_ant[]" id="descripcion_ant' + n + '" class="form-control form-control-sm" />';
        var cod_interno = '<input name="cod_interno[]" id="cod_interno' + n + '" class="form-control form-control-sm" value="" type="text">';
        var marca = '<select name="marca[]" id="marca' + n + '" class="form-control form-control-sm" onchange=""> <option value="">--Seleccionar--</option><?php foreach ($marca as $row){?><option value="<?php echo htmlspecialchars($row->id); ?>"><?php echo htmlspecialchars(addslashes($row->denominiacion)); ?></option><?php }?></select>'
        var estado_bien =  '<select name="estado_bien[]" id="estado_bien' + n + '" class="form-control form-control-sm" onChange=""><option value="">--Seleccionar--</option> <?php foreach ($estado_bien as $row) { ?> <option value="<?php echo $row->codigo ?>" <?php echo ($row->codigo == 1) ? "selected" : ""; ?>><?php echo $row->denominacion ?></option> <?php } ?> </select>';
        var unidad = '<select name="unidad[]" id="unidad' + n + '" class="form-control form-control-sm" onChange=""> <option value="">--Seleccionar--</option> <?php foreach ($unidad as $row) {?> <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option> <?php } ?> </select>';
        var cantidad_ingreso = '<input name="cantidad_ingreso[]" id="cantidad_ingreso' + n + '" class="cantidad_ingreso form-control form-control-sm" value="" type="text" oninput="">';
        
        var btnEliminar = '<button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button>';
        var btnObservacion = '<button type="button" class="btn btn-success btn-sm" onclick="modalObservacion(' + n + ')">Observacion</button>';

        newRow += '<tr>';
        newRow += '<td>' + n + '</td>';
        newRow += '<td>' + item + '</td>';
        newRow += '<td style="width: 450px!important; display:block!important">' +descripcion_ant + descripcion + '</td>';
        newRow += '<td>' + marca + '</td>';
        newRow += '<td>' + cod_interno + '</td>';
        newRow += '<td>' + estado_bien + '</td>';
        newRow += '<td>' + unidad + '</td>';
        newRow += '<td>' + cantidad_ingreso + '</td>';
        newRow += '<td>' + btnEliminar + '</td>';
        newRow += '<td>' + btnObservacion + '</td>';
        newRow += '</tr>';

        $('#tblRequerimientoDetalle tbody').append(newRow);

        $('#descripcion' + n).select2({
            width: '100%',
            dropdownCssClass: 'custom-select2-dropdown'
            //dropdownCssClass: 'form-control form-control-sm',
            //containerCssClass: 'form-control form-control-sm'
        });

        $('#marca' + n).select2({
            width: '100%',
        });
        
    }

    //actualizarTotalGeneral();
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
    //actualizarTotalGeneral();
}

function modalObservacion(n){

    //alert(n);

    const idDetalle = $('#id_requerimiento_detalle' + n).val();

    $.ajax({
			url: "/requerimiento/modal_observacion/"+idDetalle,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc2").html(result);
					$('#openOverlayOpc2').modal('show');
                    
			}
	});
}

function limpiar(){
	$('#id').val("0");
	$('#id_tipo_documento').val("");
	$('#denominacion').val("");
	$('#img_foto').val("");
}

function fn_save_requerimiento(){
	
    var msg = "";

    var tipo_documento = $('#tipo_documento').val();
    var numero_requerimiento = $('#numero_requerimiento').val();
    var fecha_requerimiento = $('#fecha_requerimiento').val();
    var responsable = $('#responsable').val();
    var estado_atencion = $('#estado_atencion').val();
    var almacen = $('#almacen').val();
    var cerrado = $('#cerrado').val();
    var sustento_requerimiento = $('#sustento_requerimiento').val();

    if(tipo_documento==""){msg+="Ingrese el Tipo de Documento <br>";}
    if(numero_requerimiento==""){msg+="Ingrese el Numero de Requerimiento <br>";}
    if(responsable==""){msg+="Ingrese el Responsable de Atencion <br>";}
    if(estado_atencion==""){msg+="Ingrese el Estado de Atencion <br>";}
    if(fecha_requerimiento==""){msg+="Ingrese la Fecha <br>";}
    if(almacen==""){msg+="Ingrese el Almacen <br>";}
    if(cerrado==""){msg+="Ingrese el campo Cerrado <br>";}
    if(sustento_requerimiento==""){msg+="Ingrese el Sustento de Requerimiento <br>";}

    if ($('#tblRequerimientoDetalle tbody tr').length == 0) {
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
                url: "/requerimiento/send_requerimiento",
                type: "POST",
                data : $("#frmRequerimiento").serialize(),
                success: function (result) {
                    datatablenew();
                    $('.loader').hide();
                    bootbox.alert("Se guard&oacute; satisfactoriamente"); 
                    $('#openOverlayOpc').modal('hide');
               
                }
        });
    }
}

function save_orden_compra_requerimiento(){
	
    var msg = "";

    var tipo_documento = $('#tipo_documento').val();
    var numero_requerimiento = $('#numero_requerimiento').val();
    var fecha_requerimiento = $('#fecha_requerimiento').val();
    var responsable = $('#responsable').val();
    var estado_atencion = $('#estado_atencion').val();
    var almacen = $('#almacen').val();
    var cerrado = $('#cerrado').val();
    var sustento_requerimiento = $('#sustento_requerimiento').val();
    var unidad_origen = $('#unidad_origen').val();

    if(tipo_documento==""){msg+="Ingrese el Tipo de Documento <br>";}
    if(numero_requerimiento==""){msg+="Ingrese el Numero de Requerimiento <br>";}
    if(responsable==""){msg+="Ingrese el Responsable de Atencion <br>";}
    if(estado_atencion==""){msg+="Ingrese el Estado de Atencion <br>";}
    if(fecha_requerimiento==""){msg+="Ingrese la Fecha <br>";}
    if(unidad_origen==""){msg+="Ingrese la Unidad de Origen <br>";}
    if(almacen==""){msg+="Ingrese el Almacen <br>";}
    if(cerrado==""){msg+="Ingrese el campo Cerrado <br>";}
    if(sustento_requerimiento==""){msg+="Ingrese el Sustento de Requerimiento <br>";}

    if ($('#tblRequerimientoDetalle tbody tr').length == 0) {
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
                url: "/requerimiento/send_requerimiento_orden_compra",
                type: "POST",
                data : $("#frmRequerimiento").serialize(),
                success: function (result) {
                    datatablenew();
                    $('.loader').hide();
                    bootbox.alert("Se guard&oacute; satisfactoriamente"); 
                    $('#openOverlayOpc').modal('hide');
                }
        });
    }
}

function generar_requerimiento(){

    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

    $.ajax({
            url: "/requerimiento/send_genera_requerimiento",
            type: "POST",
            data : $("#frmRequerimiento").serialize(),
            success: function (result) {
                datatablenew();
                $('.loader').hide();
                bootbox.alert("Se gener&oacute; requerimiento satisfactoriamente");
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

            //alert(result[0].codigo);
            //console.log(result);
            $('#numero_requerimiento').val(result[0].codigo);

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

function cambiarOrigen(){

    var unidad_origen = $('#unidad_origen').val();
    //alert(moneda);
    if(unidad_origen==1){
        $('#proveedor_select, #proveedor_').hide();
        $('#almacen_select, #almacen_').show();
        $('#almacen_salida_select, #almacen_salida_').show();
    }else if(unidad_origen==2){
        $('#proveedor_select, #proveedor_').show();
        $('#almacen_select, #almacen_').hide();
        $('#almacen_salida_select, #almacen_salida_').show();
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

</script>

<body class="hold-transition skin-blue sidebar-mini">
    
    <div>
		<div class="justify-content-center">

            <div class="card">
                <div style="text-align: center; font-size:16px; margin-top: 20px">
                    <b>Requerimiento</b>
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmRequerimiento" name="frmRequerimiento">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                        
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                        
                        <div class="row" style="padding-left:10px">

                            <div class="col-lg-2">
                                Tipo Documento
                            </div>
                            <div class="col-lg-2">
                                <select name="tipo_documento" id="tipo_documento" class="form-control form-control-sm" onchange="obtenerCodigo()">
                                    <option value="">--Seleccionar--</option>
                                    <?php
                                    foreach ($tipo_documento as $row){
                                        $selected = ($row->codigo == ($requerimiento->id_tipo_documento ?? 1)) ? "selected='selected'" : "";
                                    ?>
                                        <option value="<?php echo $row->codigo ?>" <?php echo $selected;?>><?php echo $row->denominacion ?></option>
                                        <?php 
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                N&uacute;mero Requerimiento
                            </div>
                            <div class="col-lg-2">
                                <input id="numero_requerimiento" name="numero_requerimiento" on class="form-control form-control-sm"  value="<?php if($id>0){echo $requerimiento->codigo;}?>" type="text" readonly ="readonly">
                            </div>
                            <div class="col-lg-2">
                                Fecha Requerimiento
                            </div>
                            <div class="col-lg-2">
                                <input id="fecha_requerimiento" name="fecha_requerimiento" on class="form-control form-control-sm"  value="<?php echo isset($requerimiento) && $requerimiento->fecha ? $requerimiento->fecha : date('Y-m-d'); ?>" type="text">
                            </div>
                            <div class="col-lg-2">
                                Unidad Origen
                            </div>
                            <div class="col-lg-2">
                                <select name="unidad_origen" id="unidad_origen" class="form-control form-control-sm" onchange="cambiarOrigen()">
                                    <option value="">--Seleccionar--</option>
                                    <?php
                                    foreach ($unidad_origen as $row){?>
                                        <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$requerimiento->id_unidad_origen)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                        <?php 
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2" id="almacen_" style="color:green; font-weight:bold">
                                Almacen Origen
                            </div>
                            <div class="col-lg-2" id="almacen_select">
                                <select name="almacen_salida" id="almacen_salida" class="form-control form-control-sm" onchange="//actualizarSecciones(this)">
                                    <option value="">--Seleccionar--</option>
                                    <?php 
                                    foreach ($almacen as $row){?>
                                        <option value="<?php echo $row->id ?>" <?php if($row->id==$requerimiento->id_almacen_salida)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                        <?php 
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2" id="almacen_salida_" style="color:green; font-weight:bold">
                                Almacen Solicitante
                            </div>
                            <div class="col-lg-2" id="almacen_salida_select">
                                <select name="almacen" id="almacen" class="form-control form-control-sm" onchange="//actualizarSecciones(this)">
                                    <option value="">--Seleccionar--</option>
                                    <?php 
                                    foreach ($almacen as $row){?>
                                        <option value="<?php echo $row->id ?>" <?php if($row->id==$requerimiento->id_almacen_destino)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                        <?php 
                                    }
                                    ?>
                                </select>
                            </div><div class="col-lg-2" id="almacen_salida_">
                                Responsable de Atenci&oacute;n
                            </div>
                            <div class="col-lg-2" id="almacen_salida_select">
                                <select name="responsable" id="responsable" class="form-control form-control-sm" onchange="//actualizarSecciones(this)">
                                    <option value="">--Seleccionar--</option>
                                    <?php 
                                    foreach ($responsable_atencion as $row){?>
                                        <option value="<?php echo $row->id ?>" <?php if($row->id==$requerimiento->responsable_atencion)echo "selected='selected'"?>><?php echo $row->name ?></option>
                                        <?php 
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                Estado Atenci&oacute;n
                            </div>
                            <div class="col-lg-2">
                                <select name="estado_atencion" id="estado_atencion" class="form-control form-control-sm" onchange="">
                                    <option value="">--Seleccionar--</option>
                                    <?php
                                    foreach ($estado_atencion as $row){
                                        $selected = ($row->codigo == ($requerimiento->estado_atencion ?? 1)) ? "selected='selected'" : "";
                                    ?>
                                        <option value="<?php echo $row->codigo ?>" <?php echo $selected?>><?php echo $row->denominacion ?></option>
                                        <?php 
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                Cerrado
                            </div>
                            <div class="col-lg-2">
                                <select name="cerrado" id="cerrado" class="form-control form-control-sm" onchange="">
                                    <option value="">--Seleccionar--</option>
                                    <?php
                                    foreach ($cerrado_requerimiento as $row){?>
                                        <option value="<?php echo $row->codigo ?>" <?php if($row->codigo=='1')echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                        <?php 
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="padding-left:10px">
                            <div class="col-lg-2">
                                Sustento Requerimiento
                            </div>
                            <div class="col-lg-10">
                                <textarea id="sustento_requerimiento" name="sustento_requerimiento" class="form-control form-control-sm" rows="2"><?php echo $requerimiento->sustento_requerimiento?></textarea>
                            </div>
                        </div>
                            <div style="margin-top:15px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                        <a href="javascript:void(0)" onClick="agregarProducto()" class="btn btn-sm btn-success">Agregar</a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">

                        <div class="table-responsive">
                            <table id="tblRequerimientoDetalle" class="table table-hover table-sm">
                                <thead>
                                <tr style="font-size:13px">
                                    <th>#</th>
                                    <th>Descripci&oacute;n</th>
                                    <th>Marca</th>
                                    <th style="width : 10%">COD. INT.</th>
                                    <th style="width : 10%">Estado Bien</th>
                                    <th style="width : 10%">Unidad</th>
                                    <th style="width : 8%">Cantidad</th>
                                    <th style="width : 8%">Cantidad Pendiente</th>
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
                                        if($id>0){
                                    ?>
                                    <button style="font-size:12px;margin-left:10px;margin-right:20px" type="button" class="btn btn-sm btn-primary" data-toggle="modal" onclick="pdf_documento()" ><i class="fa fa-edit"></i> Imprimir</button>
                                    <button style="font-size:12px;margin-right:20px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="save_orden_compra_requerimiento()" ><i class="fa fa-edit"></i> Generar Orden Compra</button>
                                    <button style="font-size:12px;margin-right:20px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="generar_requerimiento()" ><i class="fa fa-edit"></i> Generar Requerimiento Pedientes</button>
                                    <?php 
                                        }
                                    ?>
                                    <!--<a href="javascript:void(0)" onClick="fn_save_requerimiento()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>-->
                                    <a href="javascript:void(0)" onClick="cerrarModalRequerimiento()" class="btn btn-sm btn-info" style="">Cerrar</a>
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

