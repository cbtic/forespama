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

    /*if($('#id').val()>0){
        obtenerUnidadTrabajo();
    }*/

    $("#item").select2({ width: '100%' });
    //$("#persona_recibe").select2({ width: '100%' });

});

</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
	 
});

$(document).ready(function() {

    if($('#id').val()>0){
        cargarDetalle();
        obtenerCentroCosto();
    }

});

function obtenerCodigo(){

    var tipo_documento = $('#tipo_documento').val();

    $.ajax({
        url: "/dispensacion/obtener_codigo_dispensacion/"+tipo_documento,
        dataType: "json",
        success: function (result) {

        }
    });
}

/*function obtenerUnidadTrabajo(){
    
    var area_trabajo = $('#area_trabajo').val();
    var selectedUnidad = "<?php echo isset($requerimiento_dispensacion->id_unidad_trabajo) ? $requerimiento_dispensacion->id_unidad_trabajo : ''; ?>";
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
        }
    });
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

var productosSeleccionados = [];

function cargarDetalle(){

var id = $("#id").val();
const tbody = $('#divRequerimientoDispensacionDetalle');

tbody.empty();

$.ajax({
    url: "/requerimiento_dispensacion/cargar_detalle/"+id,
    type: "GET",
    success: function (result) {

        let n = 1;

        result.requerimiento_dispensacion.forEach(requerimiento_dispensacion => {

            let marcaOptions = '<option value="">--Seleccionar--</option>';
            let productoOptions = '<option value="">--Seleccionar--</option>';
            let unidadMedidaOptions = '<option value="">--Seleccionar--</option>';

            var producto_stock = result.producto_stock[requerimiento_dispensacion.id_producto];

            result.marca.forEach(marca => {
                let selected = (marca.id == requerimiento_dispensacion.id_marca) ? 'selected' : '';
                marcaOptions += `<option value="${marca.id}" ${selected}>${marca.denominiacion}</option>`;
            });

            result.producto.forEach(producto => {
                let selected = (producto.id == requerimiento_dispensacion.id_producto) ? 'selected' : '';
                productoOptions += `<option value="${producto.id}" ${selected}>${producto.codigo} - ${producto.denominacion}</option>`;
            });

            result.unidad_medida.forEach(unidad_medida => {
                let selected = (unidad_medida.codigo == requerimiento_dispensacion.id_unidad_medida) ? 'selected' : '';
                unidadMedidaOptions += `<option value="${unidad_medida.codigo}" ${selected}>${unidad_medida.denominacion}</option>`;
            });

            if (requerimiento_dispensacion.id_producto) {
                productosSeleccionados.push(requerimiento_dispensacion.id_producto);
            }

            const row = `
                <tr>
                    <td>${n}</td>
                    <td style="width: 550px !important;display:block"><input name="id_requerimiento_dispensacion_detalle[]" id="id_requerimiento_dispensacion_detalle${n}" class="form-control form-control-sm" value="${requerimiento_dispensacion.id}" type="hidden"><select name="descripcion_[]" id="descripcion_${n}" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ${n});" disabled>${productoOptions}</select><input name="descripcion[]" id="descripcion${n}" class="form-control form-control-sm" value="${requerimiento_dispensacion.id_producto}" type="hidden"></td>
                    <td><select name="marca_[]" id="marca_${n}" class="form-control form-control-sm" disabled>${marcaOptions}</select><input name="marca[]" id="marca${n}" class="form-control form-control-sm" value="${requerimiento_dispensacion.id_marca}" type="hidden"></td>
                    <td><input name="cod_interno[]" id="cod_interno${n}" class="form-control form-control-sm" value="${requerimiento_dispensacion.codigo}" type="text" readonly></td>
                    <td><select name="unidad_[]" id="unidad_${n}" class="form-control form-control-sm" disabled>${unidadMedidaOptions}</select><input name="unidad[]" id="unidad${n}" class="form-control form-control-sm" value="${requerimiento_dispensacion.id_unidad_medida}" type="hidden"></td>
                    <td><input name="cantidad[]" id="cantidad${n}" class="cantidad form-control form-control-sm" value="${requerimiento_dispensacion.cantidad}" type="text" oninput="calcularCantidadPendiente(this);calcularSubTotal(this)" readonly></td>
                    <td><input name="stock_actual[]" id="stock_actual${n}" class="form-control form-control-sm" value="${producto_stock.saldos_cantidad}" type="text" readonly></td>
                </tr>
            `;
            
            tbody.append(row);
            $('#descripcion_' + n).select2({ 
                width: '100%',
                dropdownParent: $('#openOverlayOpc'),
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
            echo '<option value="' . htmlspecialchars($row->id, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($row->codigo. ' - ' .$row->denominacion, ENT_QUOTES, 'UTF-8') . '</option>';
        }
    ?>`;

    var cantidad = 1;
    var newRow = "";
    for (var i = 0; i < cantidad; i++) { 

        var n = $('#tblRequerimientoDispensacionDetalle tbody tr').length + 1;
        var descripcion = '<input name="id_requerimiento_dispensacion_detalle[]" id="id_requerimiento_dispensacion_detalle' + n + '" class="form-control form-control-sm" value="0" type="hidden"><select name="descripcion[]" id="descripcion' + n + '" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ' + n + ')"> '+ opcionesDescripcion +' </select>';
        var descripcion_ant = '<input type="hidden" name="descripcion_ant[]" id="descripcion_ant' + n + '" class="form-control form-control-sm" />';
        var cod_interno = '<input name="cod_interno[]" id="cod_interno' + n + '" class="form-control form-control-sm" value="" type="text">';
        var marca = '<select name="marca[]" id="marca' + n + '" class="form-control form-control-sm" onchange=""> <option value="">--Seleccionar--</option><?php foreach ($marca as $row){?><option value="<?php echo htmlspecialchars($row->id); ?>"><?php echo htmlspecialchars(addslashes($row->denominiacion)); ?></option><?php }?></select>';
        var unidad = '<select name="unidad[]" id="unidad' + n + '" class="form-control form-control-sm" onChange=""> <option value="">--Seleccionar--</option> <?php foreach ($unidad as $row) {?> <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option> <?php } ?> </select>';
        var cantidad_ingreso = '<input name="cantidad[]" id="cantidad' + n + '" class="cantidad form-control form-control-sm" value="" type="text" oninput="">';
        var stock_actual = '<input name="stock_actual[]" id="stock_actual' + n + '" class="form-control form-control-sm" value="" type="text" readonly>';
        
        var btnEliminar = '<button type="button" class="btn btn-sm btn-clasico btn-eliminar" onclick="eliminarFila(this)"><i class="fas fa-trash" style="font-size:18px;"></i></button>';

        newRow += '<tr>';
        newRow += '<td>' + n + '</td>';
        newRow += '<td style="width: 550px!important; display:block!important">' + descripcion_ant + descripcion + '</td>';
        newRow += '<td>' + marca + '</td>';
        newRow += '<td>' + cod_interno + '</td>';
        newRow += '<td>' + unidad + '</td>';
        newRow += '<td>' + cantidad_ingreso + '</td>';
        newRow += '<td>' + stock_actual + '</td>';
        newRow += '<td>' + btnEliminar + '</td>';
        newRow += '</tr>';

        $('#tblRequerimientoDispensacionDetalle tbody').append(newRow);

        $('#descripcion' + n).select2({
            width: '100%',
            dropdownParent: $('#openOverlayOpc'),
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

function eliminarFila(button){
    $(button).closest('tr').remove();
    actualizarTotalGeneral();
}

function fn_save_requerimiento_dispensacion(){
	
    var msg = "";

    var tipo_documento = $('#tipo_documento').val();
    var almacen = $('#almacen').val();
    var area_trabajo = $('#area_trabajo').val();
    var unidad_trabajo = $('#unidad_trabajo').val();

    if(tipo_documento==""){msg+="Ingrese el Tipo de Documento <br>";}
    if(almacen==""){msg+="Ingrese el Almacen <br>";}
    if(area_trabajo==""){msg+="Ingrese el Area de Trabajo <br>";}
    if(unidad_trabajo==""){msg+="Ingrese la Unidad de Trabajo <br>";}

    $('#tblRequerimientoDispensacionDetalle tbody tr').each(function(index, row) {

        const id_dispensacion_detalle_producto = parseInt($(row).find('input[name="id_dispensacion_detalle[]"]').val());
        const cantidad_ingreso_producto = parseInt($(row).find('input[name="cantidad[]"]').val());
        const stockActual = parseInt($(row).find('input[name="stock_actual[]"]').val());
        const stock = isNaN(stockActual) ? 0 : stockActual;
        const descripcion_producto = $(row).find('select[name="descripcion[]"] option:selected').text();
        
        if(stock < cantidad_ingreso_producto && id_dispensacion_detalle_producto==0){
            msg+="No hay stock para el producto "+descripcion_producto+" <br>";
        }
    });
    
    if ($('#tblRequerimientoDispensacionDetalle tbody tr').length == 0) {
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
            url: "/requerimiento_dispensacion/send_requerimiento_dispensacion",
            type: "POST",
            data : $("#frmRequerimientoDispensacion").serialize(),
            success: function (result) {
                //alert(result.id)
                $('#openOverlayOpc').modal('hide');
                datatablenew();
                $('.loader').hide();
                bootbox.alert("Se guard&oacute; satisfactoriamente"); 
            }
        });
    }
}

function pdf_documento_dispensacion(){

    var id = $('#id').val();

    var href = '/dispensacion/movimiento_pdf_dispensacion/'+id;
    window.open(href, '_blank');

}

function obtenerCentroCosto(){

    var sede = $('#sede').val();
    var selectedUnidad = "<?php echo isset($requerimiento_dispensacion->id_centro_costo) ? $requerimiento_dispensacion->id_centro_costo : ''; ?>";

    $.ajax({
        url: "/centro_costo/obtener_centro_costo/"+sede,
        dataType: "json",
        success: function(result){
            var option = "<option value='' selected='selected'>--Seleccionar--</option>";
            var option;
            $('#centro_costo').html("");
            $(result).each(function (ii, oo) {
                if (oo.id == selectedUnidad) {
                    option += "<option value='" + oo.id + "' selected='selected'>" + oo.codigo +" - "+oo.denominacion + "</option>";
                }else {
                    option += "<option value='"+oo.id+"'>"+oo.codigo +" - "+oo.denominacion+"</option>";
                }
                
            });
            $('#centro_costo').html(option);
            $('#centro_costo').select2({
                width: '100%'
            });
        }
    });
}

function aprobarRequerimientoDispensacion(){

    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Est&aacute; seguro de Aprobar el Requerimiento?", 
        callback: function(result){
            if (result==true) {
                guardarAprobacionRequerimientoDispensacion();
            }
        }
    });
}

function guardarAprobacionRequerimientoDispensacion(){

    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

    $.ajax({
        url: "/requerimiento_dispensacion/send_aprobar_requerimiento_dispensacion",
        type: "POST",
        data : $("#frmRequerimientoDispensacion").serialize(),
        success: function (result) {
            datatablenew();
            $('.loader').hide();
            bootbox.alert("Se aprob&oacute; satisfactoriamente");
            $('#openOverlayOpc').modal('hide');
        
        }
    });
}

function pdf_documento_requerimiento_dispensacion(){

    var id = $('#id').val();

    var href = '/requerimiento_dispensacion/movimiento_pdf_requerimiento_dispensacion/'+id;
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
                    <b>Requerimiento de Insumos</b>
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmRequerimientoDispensacion" name="frmRequerimientoDispensacion">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                    
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="id" value="<?php echo $id?>">

                    <div class="row" style="padding-left:10px">
                        <div class="col-lg-2">
                            Tipo Documento
                        </div>
                        <div class="col-lg-2">
                            <select name="tipo_documento" id="tipo_documento" class="form-control form-control-sm" onchange="obtenerCodigo()" disabled>
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($tipo_documento as $row){?>
                                    <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$requerimiento_dispensacion->id_tipo_documento)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            N° Requerimiento de Insumo
                        </div>
                        <div class="col-lg-2">
                            <input id="numero_requerimiento_insumo" name="numero_requerimiento_insumo" on class="form-control form-control-sm"  value="<?php if($id>0){echo $requerimiento_dispensacion->codigo;}?>" type="text" readonly ="readonly">
                        </div>
                        <div class="col-lg-2">
                            Fecha
                        </div>
                        <div class="col-lg-2">
                            <input id="fecha" name="fecha" on class="form-control form-control-sm"  value="<?php echo isset($requerimiento_dispensacion) && $requerimiento_dispensacion->fecha ? $requerimiento_dispensacion->fecha : date('Y-m-d'); ?>" type="text" disabled>
                        </div>
                        <div class="col-lg-2" style="color:green; font-weight:bold">
                            Almacen
                        </div>
                        <div class="col-lg-2">
                            <select name="almacen" id="almacen" class="form-control form-control-sm" onchange="//actualizarSecciones(this)" disabled>
                                <option value="">--Seleccionar--</option>
                                <?php 
                                foreach ($almacen as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php if($row->id==$requerimiento_dispensacion->id_almacen)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            Sede
                        </div>
                        <div class="col-lg-2">
                            <select name="sede" id="sede" class="form-control form-control-sm" onchange="obtenerCentroCosto()" disabled>
                                <option value="">--Seleccionar--</option>
                                <?php 
                                foreach ($sede as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php if($row->id==$requerimiento_dispensacion->id_sede)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            Centro Costo
                        </div>
                        <div class="col-lg-2">
                            <select name="centro_costo" id="centro_costo" class="form-control form-control-sm" onchange="//actualizarSecciones(this)" disabled>
                                <option value="">--Seleccionar--</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            Persona Recibe
                        </div>
                        <div class="col-lg-4">
                            <select name="persona_recibe" id="persona_recibe" class="form-control form-control-sm" onchange="" disabled>
                                <option value="">--Seleccionar--</option>
                                <?php
                                foreach ($persona as $row){?>
                                    <option value="<?php echo $row->id ?>" <?php if($row->id==$requerimiento_dispensacion->id_persona)echo "selected='selected'"?>><?php echo $row->nombres." ".$row->apellido_paterno." ".$row->apellido_materno ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                        <div style="margin-top:15px" class="form-group">
                            <div class="col-sm-12 controls">
                                <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                <?php /*if($id_user==$requerimiento_dispensacion->id_usuario_inserta && $id>0){?>
                                    <button type="button" class="btn btn-sm btn-clasico-blanco btn-agregar" data-toggle="modal" onclick="agregarProducto()">
                                        <i class="fas fa-plus-circle" style="font-size:18px;"></i> Agregar
                                    </button>
                                <?php }?>
                                <?php if($id==0){?>
                                    <button type="button" class="btn btn-sm btn-clasico-blanco btn-agregar" data-toggle="modal" onclick="agregarProducto()">
                                        <i class="fas fa-plus-circle" style="font-size:18px;"></i> Agregar
                                    </button>
                                <?php }*/?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
					<div class="table-responsive" style="overflow-y: auto; max-height: 400px;">
						<table id="tblRequerimientoDispensacionDetalle" class="table table-hover table-sm">
							<thead>
							<tr style="font-size:13px">
								<th>#</th>
								<th>Descripci&oacute;n</th>
								<th>Marca</th>
                                <th>COD. INT.</th>
                                <th>Unidad</th>
                                <th>Cantidad</th>
                                <th>Stock</th>
							</tr>
							</thead>
							<tbody id="divRequerimientoDispensacionDetalle">
							</tbody>
						</table>
					</div>
                    <div style="margin-top:15px" class="form-group">
                        <div class="col-sm-12 controls">
                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                @hasanyrole('Administrator|Aprobar Requerimiento Dispensacion')
                                    <?php 
                                    /*if($id>0 && $requerimiento_dispensacion->aprobado == 0){
                                    ?>
                                        <button type="button" class="btn btn-success btn-sm" onclick="aprobarRequerimientoDispensacion()" style="margin-right:10px">Aprobar</button>
                                    <?php 
                                        }*/
                                    ?>
                                @endhasanyrole
                                <?php //if($id==0){?>
                                <?php 
                                    if($id>0){
                                ?>
                                <button style="font-size:12px;margin-left:10px; margin-right:10px" type="button" class="btn btn-sm btn-clasico btn-enviar" data-toggle="modal" onclick="pdf_documento_requerimiento_dispensacion()">
                                    <i class="far fa-file-pdf" style="font-size:18px;"></i>Imprimir
                                </button>
                                <!--<button style="font-size:12px;margin-left:10px; margin-right:100px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="pdf_guia()" ><i class="fa fa-edit"></i>Imprimir Gu&iacute;a Remisi&oacute;n Electronica</button>
                                <a href="javascript:void(0)" onClick="fn_pdf_documento()" class="btn btn-sm btn-primary" style="margin-right:100px">Imprimir</a>-->
                                <?php 
                                    }
                                ?>
                                    <!--<button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-nuevo" data-toggle="modal" onclick="fn_save_requerimiento_dispensacion()">
                                        <i class="fas fa-save" style="font-size:18px;"></i> Guardar
                                    </button>-->
                                <?php //}?>
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

<script type="text/javascript">
$(document).ready(function() {
	
});

</script>
