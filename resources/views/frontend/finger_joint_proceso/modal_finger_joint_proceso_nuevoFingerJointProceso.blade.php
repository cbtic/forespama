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
	max-width:65%!important
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
$(document).ready(function(){
    
});
</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function(){
     $('#fecha_solicitud').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		//container: '#openOverlayOpc modal-body'
		container: '#openOverlayOpc modal-body'
     });
});

$(document).ready(function(){

    $('#producto').select2 ({ width : '100%' })
    $('#operador').select2 ({ width : '100%' })

    if($('#id').val() > 0){
        cargarDetalle();
    }

});

function limpiar(){
	$('#id').val("0");
	$('#id_tipo_documento').val("");
	$('#denominacion').val("");
	$('#img_foto').val("");
}

function fn_save_finger_joint(){
	
    var msg = "";

    var producto = $('#producto').val();
    var cantidad_producto = $('#cantidad_producto').val();
    var almacen_destino = $('#almacen_destino').val();
    var operador = $('#operador').val();
    var stock = Number($('#stock').val());
    var cantidad_producto = Number($('#cantidad_producto').val());
    const descripcion_producto = $('#producto option:selected').text();
    var producto_repetido = false;

    if(producto==""){msg+="Ingrese el Producto <br>";}
    if(cantidad_producto==""){msg+="Ingrese la Cantidad <br>";}
    if(almacen_destino==""){msg+="Ingrese el Almacen Destino <br>";}
    if(operador==""){msg+="Ingrese el Operador <br>";}
    if(cantidad_producto <= 0){msg+="La cantidad debe ser mayor a cero <br>";}
    if(cantidad_producto > stock){msg+="No hay stock para el producto " + descripcion_producto + " <br>";}

    $('#tblFingerJointDetalle tbody tr').each(function(index, row) {

        var id_producto_tabla = $(row).find('select[name="descripcion[]"]').val();

        if (producto == id_producto_tabla) {
            producto_repetido = true;
            return false;
        }
    });

    if (producto_repetido) {
        msg += "El producto ya se encuentra agregado <br>";
    }

    /*$('#tblFingerJointDetalle tbody tr').each(function(index, row) {

        const id_finger_joint_detalle = parseInt($(row).find('input[name="id_finger_joint_proceso_detalle[]"]').val());
        const cantidad_ingreso = parseInt($(row).find('input[name="cantidad_ingreso[]"]').val());
        const stock_actual = parseInt($(row).find('input[name="stock_actual[]"]').val());
        const stock = isNaN(stock_actual) ? 0 : stock_actual;
        const descripcion_producto = $(row).find('select[name="descripcion[]"] option:selected').text();
        
        if(stock < cantidad_ingreso && id_finger_joint_detalle==0){
            msg+="No hay stock para el producto "+descripcion_producto+" <br>";
        }
    });*/

    if ($('#tblFingerJointDetalle tbody tr').length == 0) {
        msg += "No se ha agregado ning&uacute;n producto <br>";
    }

    if(msg!=""){
        bootbox.alert(msg);
        return false;
    }else{

        $.ajax({
            url: "/finger_joint_proceso/send_finger_joint_proceso",
            type: "POST",
            data : $("#frmFingerJointProceso").serialize(),
            success: function (result){

                if(result.success){
                    bootbox.alert(result.success, function(){
                        $('#openOverlayOpc').modal('hide');
                        datatablenew();
                    });
                }else if(result.error){
                    bootbox.alert(result.error);
                }
            },
        });
    }
}

function cargarDetalle(){

    var id = $("#id").val();

    const tbody = $('#divFingerJointDetalle');

    tbody.empty();

    $.ajax({
        url: "/finger_joint_proceso/cargar_detalle/"+id,
        type: "GET",
        success: function (result){
            let n = 1;

            result.finger_joint_proceso.forEach(finger_joint_proceso => {

                let productoOptions = '<option value="">--Seleccionar--</option>';
                let unidadMedidaOptions = '<option value="">--Seleccionar--</option>';

                result.producto.forEach(producto => {
                    let selected = (producto.id == finger_joint_proceso.id_producto) ? 'selected' : '';
                    productoOptions += `<option value="${producto.id}" ${selected}>${producto.codigo} - ${producto.denominacion}</option>`;
                });

                result.unidad_medida.forEach(unidad_medida => {
                    let selected = (unidad_medida.codigo == finger_joint_proceso.id_unidad_medida) ? 'selected' : '';
                    unidadMedidaOptions += `<option value="${unidad_medida.codigo}" ${selected}>${unidad_medida.denominacion}</option>`;
                });

                if (finger_joint_proceso.id_producto) {
                    productosSeleccionados.push(finger_joint_proceso.id_producto);
                }
               
                const row = `
                    <tr>
                        <td>${n}</td>
                        <td style="width: 800px !important;display:block"><input name="id_finger_joint_proceso_detalle[]" id="id_finger_joint_proceso_detalle${n}" class="form-control form-control-sm" value="0" type="hidden"><select name="descripcion_[]" id="descripcion_${n}" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ${n});">${productoOptions}</select><input name="descripcion[]" id="descripcion${n}" class="form-control form-control-sm" value="${finger_joint_proceso.id_producto}" type="hidden"></td>
                        <td><input name="cod_interno[]" id="cod_interno${n}" class="form-control form-control-sm" value="${finger_joint_proceso.codigo}" type="text"></td>
                        <td><select name="unidad_[]" id="unidad_${n}" class="form-control form-control-sm">${unidadMedidaOptions}</select><input name="unidad[]" id="unidad${n}" class="form-control form-control-sm" value="${finger_joint_proceso.id_unidad_medida}" type="hidden"></td>
                        <td><input name="cantidad_ingreso[]" id="cantidad_ingreso${n}" class="form-control form-control-sm" value="${finger_joint_proceso.cantidad}" type="text" data-cantidad-base="${finger_joint_proceso.cantidad}" readonly="readonly"></td>
                        <td><button type="button" class="btn btn-sm btn-clasico btn-eliminar" onclick="eliminarFila(this)"><i class="fas fa-trash" style="font-size:18px;"></i></button></td>
                    </tr>
                `;
                tbody.append(row);
                $('#descripcion_' + n).select2({ 
                    width: '100%',
                    dropdownCssClass: 'custom-select2-dropdown'
                });

                n++;
            });
        }
    })
}

var productosSeleccionados = [];

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
        var n = $('#tblFingerJointDetalle tbody tr').length + 1;
        var descripcion = '<input name="id_finger_joint_proceso_detalle[]" id="id_finger_joint_proceso_detalle${n}" class="form-control form-control-sm" value="0" type="hidden"><select name="descripcion[]" id="descripcion' + n + '" class="form-control form-control-sm" onChange="verificarProductoSeleccionado(this, ' + n + '); obtenerCodInterno(this, ' + n + ')"> '+ opcionesDescripcion +' </select>';
        var descripcion_ant = '<input type="hidden" name="descripcion_ant[]" id="descripcion_ant' + n + '" class="form-control form-control-sm" />';
        var unidad = '<select name="unidad[]" id="unidad' + n + '" class="form-control form-control-sm" onchange=""> <option value="">--Seleccionar--</option> <?php foreach ($unidad as $row) {?> <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option> <?php } ?> </select>';
        var cantidad_ingreso = '<input name="cantidad_ingreso[]" id="cantidad_ingreso' + n + '" class="cantidad_ingreso form-control form-control-sm" value="" type="text" oninput="">';
        
        var btnEliminar = '<button type="button" class="btn btn-sm btn-clasico btn-eliminar" onclick="eliminarFila(this)"><i class="fas fa-trash" style="font-size:18px;"></i></button>';

        newRow += '<tr>';
        newRow += '<td>' + n + '</td>';
        newRow += '<td style="width: 650px!important; display:block!important">' +descripcion_ant + descripcion + '</td>';
        newRow += '<td>' + unidad + '</td>';
        newRow += '<td>' + cantidad_ingreso + '</td>';
        newRow += '<td>' + btnEliminar + '</td>';
        newRow += '</tr>';

        $('#tblFingerJointDetalle tbody').append(newRow);

        $('#descripcion' + n).select2({
            width: '100%',
            dropdownParent: $('#openOverlayOpc'),
            dropdownCssClass: 'custom-select2-dropdown',
        });
    }
}

function eliminarFila(button){
    $(button).closest('tr').remove();
}

function verificarProductoSeleccionado(selectElement, rowIndex, valor){
    var selectedValue = $(selectElement).val();

    if(selectedValue){
        var selectedValueAnt = $("#descripcion_ant"+rowIndex).val();
        if(selectedValueAnt != ""){
            const index_ant = productosSeleccionados.indexOf(Number(selectedValueAnt));
            console.log(index_ant);
            productosSeleccionados.splice(index_ant, 1);
            $("#descripcion_ant"+rowIndex).val("");
        }

        if(!productosSeleccionados.includes(Number(selectedValue))){
            productosSeleccionados.push(Number(selectedValue));
            $("#descripcion_ant"+rowIndex).val(selectedValue);

            obtenerStock(selectElement, rowIndex);
        }else{
            bootbox.alert("Este producto ya ha sido seleccionado. Por favor elige otro.");
            $(selectElement).val('').trigger('change');
        }
    }else{
        
        const index = productosSeleccionados.indexOf(Number(selectedValue));
        if(index > -1){
            productosSeleccionados.splice(index, 1);
        }
    }

    console.log(productosSeleccionados);
}

function obtenerStock(selectElement, n){

    var id_producto = $(selectElement).val();
    var almacen = $('#almacen_destino').val();
    
    $.ajax({
        url: "/productos/obtener_stock_producto/"+almacen+"/"+id_producto,
        dataType: "json",
        success: function(result){

            var producto_stock = result.producto_stock[id_producto];
            
            $('#stock_actual' + n).val(producto_stock.saldos_cantidad);
            
        }
    });
}

function obtenerStock(){

    var producto = $('#producto').val();
    var almacen_destino = $('#almacen_destino').val();

    $.ajax({
        url: "/productos/obtener_stock_producto/"+almacen_destino+"/"+producto,
        dataType: "json",
        success: function(result){

            var producto_stock = result.producto_stock[producto];
            
            $('#stock').val(producto_stock.saldos_cantidad);
        }
    });
}

function obtenerCodInterno(selectElement, n){

    var id_producto = $(selectElement).val();

    $.ajax({
        url: "/productos/obtener_producto/"+id_producto,
        dataType: "json",
        success: function(result){
            
            $('#unidad' + n).val(result[0].id_unidad_producto);
            
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
                
                <div class="card-header" style="padding:5px!important;padding-left:20px!important">
                    Registrar Finger Joint
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmFingerJointProceso" name="frmFingerJointProceso">

                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                            
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                            
                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-2">
                                    C&oacute;digo de Operaci&oacute;n
                                </div>
                                <div class="col-lg-2">
                                    <input id="codigo_finger" name="codigo_finger" on class="form-control form-control-sm"  value="<?php if($id>0){echo $finger_joint_proceso->codigo;}?>" type="text" readonly ="readonly">
                                </div>
                                <div class="col-lg-2">
                                    Producto
                                </div>
                                <div class="col-lg-6">
                                    <select name="producto" id="producto" class="producto form-control form-control-sm" onchange="obtenerStock()">
                                        <option value="">--Seleccionar--</option>
                                        <?php
                                        foreach ($producto as $row){?>
                                            <option value="<?php echo $row->id ?>" <?php if($row->id==$finger_joint_proceso->id_producto_principal)echo "selected='selected'"?>><?php echo $row->codigo .' - '. $row->denominacion ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-2">
                                    Cantidad
                                </div>
                                <div class="col-lg-2">
                                    <input id="cantidad_producto" name="cantidad_producto" on class="form-control form-control-sm"  value="<?php if($id>0){echo $finger_joint_proceso->cantidad;}?>" type="text" oninput="//calcularCantidades()">
                                </div>
                                <div class="col-lg-2">
                                    Stock
                                </div>
                                <div class="col-lg-2">
                                    <input id="stock" name="stock" on class="form-control form-control-sm"  value="<?php //if($id>0){echo $finger_joint_proceso->cantidad;}?>" type="text" oninput="//calcularCantidades()" readonly>
                                </div>
                                <div class="col-lg-2">
                                    Fecha
                                </div>
                                <div class="col-lg-2">
                                    <input id="fecha_" name="fecha_" on class="form-control form-control-sm"  value="<?php echo isset($finger_joint_proceso) && $finger_joint_proceso->fecha ? $finger_joint_proceso->fecha : date('Y-m-d'); ?>" type="text" disabled='disabled'>
                                    <input type="hidden" name="fecha" id="fecha" value="<?php echo isset($finger_joint_proceso) && $finger_joint_proceso->fecha ? $finger_joint_proceso->fecha : date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-2" style="color:red; font-weight:bold">
                                    Almacen Destino
                                </div>
                                <div class="col-lg-2" id="almacen_destino_select">
                                    <select name="almacen_destino" id="almacen_destino" class="form-control form-control-sm" onchange="//obtenerStock()">
                                        <option value="">--Seleccionar--</option>
                                        <?php 
                                        foreach ($almacen as $row){?>
                                            <option value="<?php echo $row->id ?>" <?php if($row->id==8)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                            <?php 
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    Operador
                                </div>
                                <div class="col-lg-6">
                                    <select name="operador" id="operador" class="form-control form-control-sm" onchange="//obtenerDetalle()">
                                        <option value="">--Seleccionar--</option>
                                        <?php
                                        foreach ($responsable_atencion as $row){?>
                                            <option value="<?php echo $row->id ?>" <?php if($row->id==$finger_joint_proceso->id_operador)echo "selected='selected'"?>><?php echo $row->name ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-2">
                                    Comentario
                                </div>
                                <div class="col-lg-10">
                                    <textarea id="observacion" name="observacion" class="form-control form-control-sm"><?php echo $finger_joint_proceso->observacion?></textarea>
                                </div>
                            </div>
                            <div style="margin-top:15px;" class="form-group">
                                <div class="col-sm-12 controls">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
                                        <?php //if($id_user==$orden_compra->id_usuario_inserta && $orden_compra->cerrado == 1 ){?>
                                            <!--<a href="javascript:void(0)" onClick="agregarProducto()" class="btn btn-sm btn-success">Agregar</a>-->
                                            <button type="button" class="btn btn-sm btn-clasico-blanco btn-agregar" data-toggle="modal" onclick="agregarProducto()">
                                                <i class="fas fa-plus-circle" style="font-size:18px;"></i> Agregar
                                            </button>
                                        <?php //}?>
                                        <?php /*if($id==0){?>
                                            <!--<a href="javascript:void(0)" onClick="agregarProducto()" class="btn btn-sm btn-success">Agregar</a>-->
                                            <button type="button" class="btn btn-sm btn-clasico-blanco btn-agregar" data-toggle="modal" onclick="agregarProducto()">
                                                <i class="fas fa-plus-circle" style="font-size:18px;"></i> Agregar Producto
                                            </button>
                                        <?php }*/?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tblFingerJointDetalle" class="table table-hover table-sm">
                                        <thead>
                                        <tr style="font-size:13px">
                                            <th>#</th>
                                            <th>Descripci&oacute;n</th>
                                            <th>Unidad</th>
                                            <th>Cantidad</th>
                                            <th>Acciones</th>
                                            <!--<th>Cantidad</th>-->
                                        </tr>
                                        </thead>
                                        <tbody id="divFingerJointDetalle">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top:15px" class="form-group">
                            <div class="col-sm-12 controls">
                                <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                    <!--<a href="javascript:void(0)" onClick="fn_save_marca()" class="btn btn-sm btn-success">Guardar</a>-->
                                    <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-nuevo" data-toggle="modal" onclick="fn_save_finger_joint()">
                                        <i class="fas fa-save" style="font-size:18px;"></i> Guardar
                                    </button>
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

