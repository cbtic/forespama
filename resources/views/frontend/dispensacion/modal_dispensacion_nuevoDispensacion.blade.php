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

    $('#fecha').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    if($('#id').val()==0){
        obtenerCodigo();
    }

    if($('#id').val()>0){
        obtenerUnidadTrabajo();
    }

    $("#item").select2({ width: '100%' });
    $("#persona_recibe").select2({ width: '100%' });

});

</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
	 
});

$(document).ready(function() {

    if($('#id').val()>0){
        cargarDetalle();
    }

    /*if ($('#id').val()==0){
        $('#tblDispensacionDetalle tbody').append(`
            <tr>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button></td>
            </tr>
        `)
    }*/

});

function obtenerCodigo(){

    var tipo_documento = $('#tipo_documento').val();

    $.ajax({
        url: "/dispensacion/obtener_codigo_dispensacion/"+tipo_documento,
        dataType: "json",
        success: function (result) {

            //alert(result[0].codigo);
            //console.log(result);
            $('#numero_dispensacion').val(result[0].codigo);

        }
    });

}

function obtenerUnidadTrabajo(){
    
    var area_trabajo = $('#area_trabajo').val();
    var selectedUnidad = "<?php echo isset($dispensacion->id_unidad_trabajo) ? $dispensacion->id_unidad_trabajo : ''; ?>";
    //alert(selectedUnidad);
    $.ajax({
        url: "/dispensacion/obtener_unidad_trabajo/"+area_trabajo,
        dataType: "json",
        success: function(result){
            var option = "<option value='' selected='selected'>--Seleccionar--</option>";
            var option;
            $('#unidad_trabajo').html("");
            $(result).each(function (ii, oo) {
                if (oo.id == selectedUnidad) {
                    option += "<option value='" + oo.id + "' selected='selected'>" + oo.denominacion + "</option>";
                }else {
                    option += "<option value='"+oo.id+"'>"+oo.denominacion+"</option>";
                }
                
            });
            $('#unidad_trabajo').html(option);
            //$('#unidad_trabajo').select2();
            
            //$('.loader').hide();
        }
        
    });
}

/*function obtenerDescripcion(selectElement){

    var fila = $(selectElement).closest('tr');

    var descripcion_completo = $(selectElement).find('option:selected').text();

    var descripcion_partes = descripcion_completo.split('-');

    var descripcion = descripcion_partes.length > 1 ? descripcion_partes[1].trim() : '';

    fila.find('input[name="descripcion[]"]').val(descripcion);

}*/

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

/*function obtenerCodigo(selectElement){

    var selectedOption = selectElement.options[selectElement.selectedIndex];
    
    var codigo = selectedOption.text.split('-')[0].trim();

    selectedOption.text = codigo;

}*/

var productosSeleccionados = [];

function cargarDetalle(){

var id = $("#id").val();
const tbody = $('#divDispensacionDetalle');

tbody.empty();

$.ajax({
        url: "/dispensacion/cargar_detalle/"+id,
        type: "GET",
        success: function (result) {

            let n = 1;

            //var total_acumulado=0;

            result.dispensacion.forEach(dispensacion => {

                let marcaOptions = '<option value="">--Seleccionar--</option>';
                let productoOptions = '<option value="">--Seleccionar--</option>';
                let estadoBienOptions = '<option value="">--Seleccionar--</option>';
                let unidadMedidaOptions = '<option value="">--Seleccionar--</option>';

                //alert(result.dispensacion[1]);
                var producto_stock = result.producto_stock[dispensacion.id_producto];

                result.marca.forEach(marca => {
                    let selected = (marca.id == dispensacion.id_marca) ? 'selected' : '';
                    marcaOptions += `<option value="${marca.id}" ${selected}>${marca.denominiacion}</option>`;
                });

                result.producto.forEach(producto => {
                    let selected = (producto.id == dispensacion.id_producto) ? 'selected' : '';
                    productoOptions += `<option value="${producto.id}" ${selected}>${producto.denominacion}</option>`;
                });

                result.estado_bien.forEach(estado_bien => {
                    let selected = (estado_bien.codigo == dispensacion.id_estado_producto) ? 'selected' : '';
                    estadoBienOptions += `<option value="${estado_bien.codigo}" ${selected}>${estado_bien.denominacion}</option>`;
                });

                result.unidad_medida.forEach(unidad_medida => {
                    let selected = (unidad_medida.codigo == dispensacion.id_unidad_medida) ? 'selected' : '';
                    unidadMedidaOptions += `<option value="${unidad_medida.codigo}" ${selected}>${unidad_medida.denominacion}</option>`;
                });

                //alert(dispensacion.id_producto);

                if (dispensacion.id_producto) {
                    productosSeleccionados.push(dispensacion.id_producto);
                }
                //alert(productosSeleccionados);
               
                const row = `
                    <tr>
                        <td>${n}</td>
                        <td><input name="id_dispensacion_detalle[]" id="id_dispensacion_detalle${n}" class="form-control form-control-sm" value="${dispensacion.id}" type="hidden"><input name="item[]" id="item${n}" class="form-control form-control-sm" value="${dispensacion.item}" type="text" readonly></td>
                        <td style="width: 450px !important;display:block"><select name="descripcion_[]" id="descripcion_${n}" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ${n});" disabled>${productoOptions}</select><input name="descripcion[]" id="descripcion${n}" class="form-control form-control-sm" value="${dispensacion.id_producto}" type="hidden"></td>
                        <td><select name="marca_[]" id="marca_${n}" class="form-control form-control-sm" disabled>${marcaOptions}</select><input name="marca[]" id="marca${n}" class="form-control form-control-sm" value="${dispensacion.id_marca}" type="hidden"></td>
                        <td><input name="cod_interno[]" id="cod_interno${n}" class="form-control form-control-sm" value="${dispensacion.codigo}" type="text" readonly></td>
                        <td><select name="estado_bien_[]" id="estado_bien_${n}" class="form-control form-control-sm" onChange="" disabled>${estadoBienOptions}</select><input name="estado_bien[]" id="estado_bien${n}" class="form-control form-control-sm" value="${dispensacion.id_estado_producto}" type="hidden"></td>
                        <td><select name="unidad_[]" id="unidad_${n}" class="form-control form-control-sm" disabled>${unidadMedidaOptions}</select><input name="unidad[]" id="unidad${n}" class="form-control form-control-sm" value="${dispensacion.id_unidad_medida}" type="hidden"></td>
                        <td><input name="cantidad[]" id="cantidad${n}" class="cantidad form-control form-control-sm" value="${dispensacion.cantidad}" type="text" oninput="calcularCantidadPendiente(this);calcularSubTotal(this)" readonly></td>
                        <td><input name="stock_actual[]" id="stock_actual${n}" class="form-control form-control-sm" value="${producto_stock.saldos_cantidad}" type="text" readonly></td>
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
            echo '<option value="' . htmlspecialchars($row->id, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($row->denominacion, ENT_QUOTES, 'UTF-8') . '</option>';
        }
    ?>`;

    var cantidad = 1;
    var newRow = "";
    for (var i = 0; i < cantidad; i++) { 

        var n = $('#tblDispensacionDetalle tbody tr').length + 1;
        var item = '<input name="id_dispensacion_detalle[]" id="id_dispensacion_detalle' + n + '" class="form-control form-control-sm" value="0" type="hidden"><input name="item[]" id="item' + n + '" class="form-control form-control-sm" value="" type="text">';
        var descripcion = '<select name="descripcion[]" id="descripcion' + n + '" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ' + n + ')"> '+ opcionesDescripcion +' </select>';
        var descripcion_ant = '<input type="hidden" name="descripcion_ant[]" id="descripcion_ant' + n + '" class="form-control form-control-sm" />';
        var cod_interno = '<input name="cod_interno[]" id="cod_interno' + n + '" class="form-control form-control-sm" value="" type="text">';
        var marca = '<select name="marca[]" id="marca' + n + '" class="form-control form-control-sm" onchange=""> <option value="">--Seleccionar--</option><?php foreach ($marca as $row){?><option value="<?php echo htmlspecialchars($row->id); ?>"><?php echo htmlspecialchars(addslashes($row->denominiacion)); ?></option><?php }?></select>';
        var estado_bien =  '<select name="estado_bien[]" id="estado_bien' + n + '" class="form-control form-control-sm" onChange=""><option value="">--Seleccionar--</option> <?php foreach ($estado_bien as $row) { ?> <option value="<?php echo $row->codigo ?>" <?php echo ($row->codigo == 1) ? "selected" : ""; ?>><?php echo $row->denominacion; ?></option> <?php } ?> </select>';
        var unidad = '<select name="unidad[]" id="unidad' + n + '" class="form-control form-control-sm" onChange=""> <option value="">--Seleccionar--</option> <?php foreach ($unidad as $row) {?> <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option> <?php } ?> </select>';
        var cantidad_ingreso = '<input name="cantidad[]" id="cantidad' + n + '" class="cantidad form-control form-control-sm" value="" type="text" oninput="">';
        var stock_actual = '<input name="stock_actual[]" id="stock_actual' + n + '" class="form-control form-control-sm" value="" type="text">';
        
        var btnEliminar = '<button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button>';

        newRow += '<tr>';
        newRow += '<td>' + n + '</td>';
        newRow += '<td>' + item + '</td>';
        newRow += '<td style="width: 450px!important; display:block!important">' + descripcion_ant + descripcion + '</td>';
        newRow += '<td>' + marca + '</td>';
        newRow += '<td>' + cod_interno + '</td>';
        newRow += '<td>' + estado_bien + '</td>';
        newRow += '<td>' + unidad + '</td>';
        newRow += '<td>' + cantidad_ingreso + '</td>';
        newRow += '<td>' + stock_actual + '</td>';
        newRow += '<td>' + btnEliminar + '</td>';
        newRow += '</tr>';

        $('#tblDispensacionDetalle tbody').append(newRow);

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

/*function verificarProductoSeleccionado(selectElement, rowIndex) {
    var selectedValue = $(selectElement).val();

    if (selectedValue) {
        if (productosSeleccionados.includes(selectedValue)) {
            bootbox.alert("Este producto ya ha sido seleccionado.", function() {
                $(selectElement).val('').trigger('change'); 
            });
        } else {
            productosSeleccionados.push(selectedValue);
            obtenerCodInterno(selectElement, rowIndex);
        }
    }
}*/

function eliminarFila(button){
    $(button).closest('tr').remove();
    actualizarTotalGeneral();
}

function fn_save_dispensacion(){
	
    var msg = "";

    var tipo_documento = $('#tipo_documento').val();
    var almacen = $('#almacen').val();
    var area_trabajo = $('#area_trabajo').val();
    var unidad_trabajo = $('#unidad_trabajo').val();

    if(tipo_documento==""){msg+="Ingrese el Tipo de Documento <br>";}
    if(almacen==""){msg+="Ingrese el Almacen <br>";}
    if(area_trabajo==""){msg+="Ingrese el Area de Trabajo <br>";}
    if(unidad_trabajo==""){msg+="Ingrese la Unidad de Trabajo <br>";}

    $('#tblDispensacionDetalle tbody tr').each(function(index, row) {

        const id_dispensacion_detalle_producto = parseInt($(row).find('input[name="id_dispensacion_detalle[]"]').val());
        const cantidad_ingreso_producto = parseInt($(row).find('input[name="cantidad[]"]').val());
        const stockActual = parseInt($(row).find('input[name="stock_actual[]"]').val());
        const descripcion_producto = $(row).find('select[name="descripcion[]"] option:selected').text();
        
        if(stockActual<cantidad_ingreso_producto && id_dispensacion_detalle_producto==0){
            msg+="No hay stock para el producto "+descripcion_producto+" <br>";
        }
    });
        

    if ($('#tblDispensacionDetalle tbody tr').length == 0) {
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
                url: "/dispensacion/send_dispensacion",
                type: "POST",
                data : $("#frmDispensacion").serialize(),
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



function pdf_documento_dispensacion(){

    var id = $('#id').val();
    //var tipo_movimiento = $('#tipo_movimiento').val();

    var href = '/dispensacion/movimiento_pdf_dispensacion/'+id;
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
                    <b>Dispensaci&oacute;n</b>
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmDispensacion" name="frmDispensacion">

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
                                $selectedDocumento = isset($dispensacion->id_tipo_documento) ? $dispensacion->id_tipo_documento : 2;
                                foreach ($tipo_documento as $row){?>
                                    <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$selectedDocumento)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            N&uacute;mero de Dispensaci&oacute;n
                        </div>
                        <div class="col-lg-2">
                            <input id="numero_dispensacion" name="numero_dispensacion" on class="form-control form-control-sm"  value="<?php if($id>0){echo $dispensacion->codigo;}?>" type="text" readonly ="readonly">
                        </div>
                        <div class="col-lg-2">
                            Fecha
                        </div>
                        <div class="col-lg-2">
                            <input id="fecha" name="fecha" on class="form-control form-control-sm"  value="<?php echo isset($dispensacion) && $dispensacion->fecha ? $dispensacion->fecha : date('Y-m-d'); ?>" type="text">
                        </div>
                        <div class="col-lg-2" style="color:green; font-weight:bold">
                            Almacen
                        </div>
                        <div class="col-lg-2" id="almacen_salida_select">
                            <select name="almacen" id="almacen" class="form-control form-control-sm" onchange="//actualizarSecciones(this)">
                                <option value="">--Seleccionar--</option>
                                <?php 
                                foreach ($almacen as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php if($row->id==$dispensacion->id_almacen)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            &Aacute;rea de Trabajo
                        </div>
                        <div class="col-lg-2" id="almacen_salida_select">
                            <select name="area_trabajo" id="area_trabajo" class="form-control form-control-sm" onchange="obtenerUnidadTrabajo()">
                                <option value="">--Seleccionar--</option>
                                <?php 
                                foreach ($area_trabajo as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php if($row->id==$dispensacion->id_area_trabajo)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            Unidad de Trabajo
                        </div>
                        <div class="col-lg-2" id="almacen_salida_select">
                            <select name="unidad_trabajo" id="unidad_trabajo" class="form-control form-control-sm" onchange="//actualizarSecciones(this)">
                                <option value="">--Seleccionar--</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            Persona Recibe
                        </div>
                        <div class="col-lg-2">
                            <select name="persona_recibe" id="persona_recibe" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($persona as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php if($row->id==$dispensacion->id_usuario_recibe)echo "selected='selected'"?>><?php echo $row->nombres." ".$row->apellido_paterno." ".$row->apellido_materno ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
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
						<table id="tblDispensacionDetalle" class="table table-hover table-sm">
							<thead>
							<tr style="font-size:13px">
								<th>#</th>
								<th>Item</th>
								<th>Descripci&oacute;n</th>
								<th>Marca</th>
                                <th>COD. INT.</th>
                                <!--<th>F. Fabricaci&oacute;n</th>
                                <th>F. Vencimiento</th>-->
                                <th>Estado Bien</th>
                                <th>Unidad</th>
                                <th>Cantidad</th>
                                <th>Stock</th>
                                <!--<th>Sub Total</th>
                                <th>IGV</th>
                                <th>Total</th>-->
							</tr>
							</thead>
							<tbody id="divDispensacionDetalle">
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
                                <button style="font-size:12px;margin-left:10px; margin-right:10px" type="button" class="btn btn-sm btn-primary" data-toggle="modal" onclick="pdf_documento_dispensacion()"><i class="fa fa-edit" ></i>Imprimir</button>
                                <!--<button style="font-size:12px;margin-left:10px; margin-right:100px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="pdf_guia()" ><i class="fa fa-edit"></i>Imprimir Gu&iacute;a Remisi&oacute;n Electronica</button>
                                <a href="javascript:void(0)" onClick="fn_pdf_documento()" class="btn btn-sm btn-primary" style="margin-right:100px">Imprimir</a>-->
                                <?php 
                                    }
                                ?>
                                <a href="javascript:void(0)" onClick="fn_save_dispensacion()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>
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

