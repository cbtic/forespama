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
	 
});

$(document).ready(function() {

    if($('#id').val()>0){
        cargarDetalle();
        //cambiarOrigen();
    }
});

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

var productosSeleccionados = [];

function cargarDetalle(){

    var id = $("#id").val();
    const tbody = $('#divOrdenCompraTienda');

    tbody.empty();

    $.ajax({
        url: "/orden_compra/cargar_detalle_tienda/"+id,
        type: "GET",
        success: function (result) {

            let n = 1;

            result.tienda_orden_compra.forEach(tienda_orden_compra => {
                
                const rowTienda  = `
                    <tr>
                        <td style="width: 20px">${n}</td>
                        
                        <td colspan="5"><label style="border:none; background: none; font-weight: bold;" name="tienda[]" id="tienda${n}" class="form-control form-control-sm">${tienda_orden_compra.tienda}</td>
                    </tr>
                `;

                /*const rowTienda  = `
                    <tr>
                        <td style="width: 20px">${n}</td>
                        
                        <td colspan="5"><input name="tienda[]" id="tienda${n}" class="cantidad_ingreso form-control form-control-sm" style="font-weight: bold;" value="${tienda_orden_compra.tienda}" type="text" readonly></td>
                    </tr>
                `;*/

                tbody.append(rowTienda);

                /*const rowTiendaNombre= `
                    <tr style="font-size:13px">
                        <th>#</th>
                        <th>Producto</th>
                        <th>Unidad</th>
                        <th>Cantidad</th>
                    </tr>
                `;
                
                tbody.append(rowTiendaNombre);*/

                result.tienda_detalle_orden_compra.forEach(tienda_detalle_orden_compra => {
                    if(tienda_orden_compra.id_tienda==tienda_detalle_orden_compra.id_tienda){
                        const rowProducto  = `
                            <tr>
                                <td></td> 
                                <td><label style="border:none; background: none;" name="producto[]" id="producto${n}" class="form-control form-control-sm"> ${tienda_detalle_orden_compra.producto}</td>
                                <td style="width: 200px"><label style="border:none; background: none;" name="unidad_medida[]" id="unidad_medida${n}" class="form-control form-control-sm">${tienda_detalle_orden_compra.unidad_medida}</td>
                                <td style="width: 100px"><label style="border:none; background: none;" name="cantidad[]" id="cantidad${n}" class="form-control form-control-sm">${tienda_detalle_orden_compra.cantidad}</td>
                            </tr>
                        `;
                        /*const rowProducto  = `
                            <tr>
                                <td></td> 
                                <td><input name="producto[]" id="producto${n}" class="cantidad_ingreso form-control form-control-sm" value="${tienda_detalle_orden_compra.producto}" type="text" readonly></td>
                                <td style="width: 200px"><input name="unidad_medida[]" id="unidad_medida${n}" class="cantidad_ingreso form-control form-control-sm" value="${tienda_detalle_orden_compra.unidad_medida}" type="text" readonly></td>
                                <td style="width: 100px"><input name="cantidad[]" id="cantidad${n}" class="cantidad form-control form-control-sm" value="${tienda_detalle_orden_compra.cantidad}" type="text" readonly></td>
                            </tr>
                        `;*/
                        tbody.append(rowProducto);
                    }
                    
                });
                n++;
            });
        }
    });
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

function limpiar(){
	$('#id').val("0");
	$('#id_tipo_documento').val("");
	$('#denominacion').val("");
	$('#img_foto').val("");
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
                    
                    <!--<div class="row" style="padding-left:10px">

                        <div class="col-lg-2">
                            Tipo Documento
                        </div>
                        <div class="col-lg-2">
                            <select name="tipo_documento" id="tipo_documento" class="form-control form-control-sm" onchange="obtenerCodigo()">
                                <option value="">--Seleccionar--</option>
                                <?php
                                //foreach ($tipo_documento as $row){?>
                                    <option value="<?php //echo $row->codigo ?>" <?php //if($row->codigo==$orden_compra->id_tipo_documento)echo "selected='selected'"?>><?php //echo $row->denominacion ?></option>
                                    <?php 
                                //}
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            N&uacute;mero Orden Compra
                        </div>
                        <div class="col-lg-2">
                            <input id="numero_orden_compra" name="numero_orden_compra" on class="form-control form-control-sm"  value="<?php if($id>0){echo $orden_compra->numero_orden_compra;}?>" type="text" readonly ="readonly">
                        </div>
                        <div class="col-lg-2">
                            Empresa Compra
                        </div>
                        <div class="col-lg-2">
                            <select name="empresa_compra" id="empresa_compra" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php
                                //foreach ($proveedor as $row){?>
                                    <option value="<?php //echo $row->id ?>" <?php //if($row->id==$orden_compra->id_empresa_compra)echo "selected='selected'"?>><?php //echo $row->razon_social ?></option>
                                    <?php 
                                //}
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            Empresa Vende
                        </div>
                        <div class="col-lg-2">
                            <select name="empresa_vende" id="empresa_vende" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php
                                //foreach ($proveedor as $row){?>
                                    <option value="<?php //echo $row->id ?>" <?php //if($row->id==$orden_compra->id_empresa_vende)echo "selected='selected'"?>><?php //echo $row->razon_social ?></option>
                                    <?php 
                                //}
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            Fecha Orden Compra
                        </div>
                        <div class="col-lg-2">
                            <input id="fecha_orden_compra" name="fecha_orden_compra" on class="form-control form-control-sm"  value="<?php //echo isset($orden_compra) && $orden_compra->fecha_orden_compra ? $orden_compra->fecha_orden_compra : date('Y-m-d'); ?>" type="text">
                        </div>
                        <div class="col-lg-2">
                            Aplica IGV
                        </div>
                        <div class="col-lg-2">
                            <select name="igv_compra" id="igv_compra" class="form-control form-control-sm" onchange="">
                                <option value="">--Seleccionar--</option>
                                <?php
                                //foreach ($igv_compra as $row){?>
                                    <option value="<?php //echo $row->codigo ?>" <?php //if($row->codigo==$orden_compra->igv_compra)echo "selected='selected'"?>><?php //echo $row->denominacion ?></option>
                                    <?php 
                                //}
                                ?>
                            </select>
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
                                //foreach ($unidad_origen as $row){?>
                                    <option value="<?php //echo $row->codigo ?>" <?php //if($row->codigo==$orden_compra->id_unidad_origen)echo "selected='selected'"?>><?php //echo $row->denominacion ?></option>
                                    <?php 
                                //}
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
                                //foreach ($almacen as $row){?>
                                    <option value="<?php //echo $row->id ?>" <?php //if($row->id==$orden_compra->id_almacen_salida)echo "selected='selected'"?>><?php //echo $row->denominacion ?></option>
                                    <?php 
                                //}
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
                                //foreach ($almacen as $row){?>
                                    <option value="<?php //echo $row->id ?>" <?php //if($row->id==$orden_compra->id_almacen_destino)echo "selected='selected'"?>><?php //echo $row->denominacion ?></option>
                                    <?php 
                                //}
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
                        </div> -->

                        <div class="card-body">	

					<div class="table-responsive">
						<table id="tblOrdenCompraDetalle" class="table table-hover table-sm">
							<thead>
							<tr style="font-size:13px">
								<th>#</th>
								<!--<th>Item</th>-->
								<th>Tienda</th>
								<!--<th>Marca</th>
                                <th>COD. INT.</th>
                                <th>F. Fabricaci&oacute;n</th>
                                <th>F. Vencimiento</th>
                                <th>Estado Bien</th>
                                <th>Unidad</th>
                                <th>Cantidad</th>-->
                                <!--<th>Precio Unitario</th>
                                <th>Descuento</th>
                                <th>Sub Total</th>
                                <th>IGV</th>
                                <th>Total</th>-->
							</tr>
							</thead>
							<tbody id="divOrdenCompraTienda">
							</tbody>
						</table>
					</div>
                    <div style="margin-top:15px" class="form-group">
                        <div class="col-sm-12 controls">
                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                <?php 
                                    if($id>0){
                                ?>
                                <button style="font-size:12px;margin-left:10px" type="button" class="btn btn-sm btn-primary" data-toggle="modal" onclick="pdf_documento()" ><i class="fa fa-edit"></i>Imprimir</button>
                                <!--<button style="font-size:12px;margin-left:10px; margin-right:100px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="pdf_guia()" ><i class="fa fa-edit"></i>Imprimir Gu&iacute;a Remisi&oacute;n Electronica</button>
                                <a href="javascript:void(0)" onClick="fn_pdf_documento()" class="btn btn-sm btn-primary" style="margin-right:100px">Imprimir</a>-->
                                <?php 
                                    }
                                ?>
                                <!--<a href="javascript:void(0)" onClick="fn_save_orden_compra()" class="btn btn-sm btn-success" style="margin-right:10px;margin-left:10px">Guardar</a>-->
                                <a href="javascript:void(0)" onClick="$('#openOverlayOpc').modal('hide');" class="btn btn-sm btn-info" style="margin-left:10px">Cerrar</a>
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

