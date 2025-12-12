<title>FORESPAMA</title>

<style>
/*
.datepicker {
  z-index: 1600 !important; 
}
*/
/*.datepicker{ z-index:99999 !important; }*/

/*.modal-dialog {
  max-height: 100vh;
  display: flex;
  flex-direction: column;
}*/

.modal-content {
  flex: 1 1 auto;
  overflow: hidden;
}

.modal-body {
  overflow-y: auto;
}

.datepicker,
.table-condensed {
  width: 250px;
  height:250px;
}

.modal-dialog {
    width: 90%;
    max-width:100%!important
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

});

</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
     $('#fecha_solicitud').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
     });
});

$(document).ready(function() {

    /*if($('#id').val()>0){
        //cargarDetalle();
        cambiarOrigen();
    }*/

    $("#empresa_vende").select2 ({ width : '100%'})

    $('#fecha_cotizacion').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    cargarDetalleCotizacion();

});

function cargarDetalleCotizacion(){

    var id_requerimiento = $("#id_requerimiento").val();
    const tbody = $('#divCotizacionDetalle');

    tbody.empty();

    $.ajax({
        url: "/requerimiento/cargar_detalle_requerimiento_cotizacion/"+id_requerimiento,
        type: "GET",
        success: function (result) {

            let n = 1;

            var total_acumulado=0;

            result.requerimiento.forEach(requerimiento => {

                let marcaOptions = '<option value="">--Seleccionar--</option>';
                let unidadMedidaOptions = '<option value="">--Seleccionar--</option>';

                let id_marca = requerimiento.id_marca ?? '';
                let marca = requerimiento.marca ?? '';
            
                result.marca.forEach(marca => {
                    let selected = (marca.id == requerimiento.id_marca) ? 'selected' : '';
                    marcaOptions += `<option value="${marca.id}" ${selected}>${marca.denominiacion}</option>`;
                });

                result.unidad_medida.forEach(unidad_medida => {
                    let selected = (unidad_medida.codigo == requerimiento.id_unidad_medida) ? 'selected' : '';
                    unidadMedidaOptions += `<option value="${unidad_medida.codigo}" ${selected}>${unidad_medida.denominacion}</option>`;
                });

                const row = `
                    <tr>
                        <td>${n}</td>
                        <td style="width: 450px !important;display:block"><input name="id_producto[]" id="id_producto${n}" class="form-control form-control-sm" value="${requerimiento.id_producto}" type="hidden"><input name="descripcion[]" id="descripcion${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${requerimiento.nombre_producto}" type="text" disabled></td>
                        
                        <td><input name="marca[]" id="marca${n}" class="form-control form-control-sm" value="${id_marca}" type="hidden"><input name="marca_descripcion[]" id="marca_descripcion${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${marca}" type="text" disabled></td>
                        <td><input name="cod_interno[]" id="cod_interno${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${requerimiento.codigo}" type="text" disabled></td>
                        <td><input name="unidad[]" id="unidad${n}" class="form-control form-control-sm" value="${requerimiento.id_unidad_medida}" type="hidden"><input name="unidad[]" id="unidad${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${requerimiento.unidad_medida}" disabled></td>
                        <td><input name="cantidad_ingreso[]" id="cantidad_ingreso${n}" class="cantidad_ingreso form-control form-control-sm" value="${requerimiento.cantidad}" type="text" oninput=""></td>
                        <td><input name="precio_venta[]" id="precio_venta${n}" class="precio_venta form-control form-control-sm" value="" type="text" oninput="calcularPrecioUnitario(this)"></td>
                        <td><input name="precio_unitario[]" id="precio_unitario${n}" class="precio_unitario form-control form-control-sm" style="border: none; background-color: transparent;" value="" type="text" disabled></td>
                        <td><input name="valor_venta_bruto[]" id="valor_venta_bruto${n}" class="valor_venta_bruto form-control form-control-sm" style="border: none; background-color: transparent;" value="" type="text" disabled></td>
                        <td><input name="valor_venta[]" id="valor_venta${n}" class="valor_venta form-control form-control-sm" style="border: none; background-color: transparent;" value="" type="text" disabled></td>
                        <td><input name="sub_total[]" id="sub_total${n}" class="sub_total form-control form-control-sm" style="border: none; background-color: transparent;" value="" type="text" disabled></td>
                        <td><input name="igv[]" id="igv${n}" class="igv form-control form-control-sm" value="" style="border: none; background-color: transparent;" type="text" disabled></td>
                        <td><input name="total[]" id="total${n}" class="total form-control form-control-sm" style="border: none; background-color: transparent;" value="" type="text" disabled></td>
                        <td><button type="button" class="btn btn-sm btn-clasico btn-eliminar" onclick="eliminarFila(this)"><i class="fas fa-trash" style="font-size:18px;"></i></button></td>

                    </tr>
                `;
                tbody.append(row);

                n++;
            });
        }
    });
}

function calcularPrecioUnitario(input) {

    var fila = $(input).closest('tr');
    var igvPorcentaje = $('#igv_compra').val() == 2 ? 1.18 : 0;
    var precio_unitario_ = 0;
    var valor_venta_bruto = 0;
    var valor_venta = 0;
    var igv = 0;
    var total = 0;

    var precio_venta = parseFloat(fila.find('.precio_venta').val()) || 0;
    //var precio_venta = parseFloat(fila.find('.precio_unitario').val()) || 0;
    var cantidad_ingreso = parseFloat(fila.find('.cantidad_ingreso').val()) || 0;

    //alert(precio_venta);
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
    
    valor_venta = valor_venta_bruto;
    
    if(igvPorcentaje==1.18){
        igv = valor_venta * 0.18;
    }

    total = valor_venta + igv;

    fila.find('.precio_unitario').val(precio_unitario_.toFixed(2));
    fila.find('.valor_venta_bruto').val(valor_venta_bruto.toFixed(2));
    fila.find('.valor_venta').val(valor_venta.toFixed(2));
    fila.find('.igv').val(igv.toFixed(2));
    fila.find('.sub_total').val(valor_venta.toFixed(2));
    fila.find('.total').val(total.toFixed(2));

    //actualizarTotalGeneral();
}

function agregarCotizacion(){

    $("#colDetalle").show();

    $("#numero_cotizacion").val('');
    $("#empresa_vende").val('');
    $("#fecha_cotizacion").val('');
    $("#telefono").val('');
    $("#moneda").val('');
    $("#tipo_cambio").val('');
    $("#igv_compra").val('');

    $('#divCotizacionDetalle').empty();

    cargarDetalleCotizacion();

}

function eliminarFila(button){
    $(button).closest('tr').remove();
    //actualizarTotalGeneral();
}

function fn_save_cotizacion(){
	
    var msg = "";

    var empresa_vende = $('#empresa_vende').val();
    var fecha_cotizacion = $('#fecha_cotizacion').val();
    var telefono = $('#telefono').val();
    var moneda = $('#moneda').val();
    var tipo_cambio = $('#tipo_cambio').val();
    var igv_compra = $('#igv_compra').val();

    if(empresa_vende==""){msg+="Seleccione la Empresa <br>";}
    if(fecha_cotizacion==""){msg+="Ingrese la Fecha <br>";}
    if(telefono==""){msg+="Ingrese el Telefono <br>";}
    if(moneda==""){msg+="Ingrese la Moneda <br>";}
    if(moneda==2){
        if(tipo_cambio==""){msg+="Ingrese el Tipo de Cambio <br>";}
    }
    if(igv_compra==""){msg+="Seleccione Aplica IGV <br>";}

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
            url: "/requerimiento/send_cotizacion_requerimiento",
            type: "POST",
            data : $("#frmCotizacion").serialize(),
            success: function (result) {
                datatablenew();
                $('.loader').hide();
                bootbox.alert("Se guard&oacute; satisfactoriamente"); 
                $('#openOverlayOpc').modal('hide');
            }
        });
    }
}

function pdf_documento(){

    var id = $('#id').val();
    //var tipo_movimiento = $('#tipo_movimiento').val();

    var href = '/requerimiento/movimiento_pdf_requerimiento/'+id;
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
                <div style="text-align: center; font-size:16px; margin-top: 20px">
                    <b>Cotizaci&oacute;n</b>
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmCotizacion" name="frmCotizacion">

                    <div class="row" style="padding-left:10px">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px; border-right:1px solid;">
                        
                            <div class="row" style="padding-left:10px">
                                <button type="button" class="btn btn-sm btn-clasico-blanco btn-agregar" data-toggle="modal" onclick="agregarCotizacion()">
                                    <i class="fas fa-plus-circle" style="font-size:18px;"></i> Agregar Cotizaci&oacute;n
                                </button>
                            </div>

                            <div class="card-body">

                                <div class="table-responsive" style="overflow-y: auto; max-height: 400px; overflow-x: auto;">
                                    <table id="tblCotizacion" class="table table-hover table-sm">
                                        <thead>
                                        <tr style="font-size:13px">
                                            <th>#</th>
                                            <th>Cotizaci&oacute;n</th>
                                            <th>Empresa</th>
                                        </tr>
                                        </thead>
                                        <tbody id="divCotizacion">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div id="colDetalle" class="col-lg-9 col-md-9 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px; display:none;">
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id_requerimiento" id="id_requerimiento" value="<?php echo $id?>">
                            <input type="hidden" name="id_cotizacion" id="id_cotizacion" value="0">

                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-2">
                                    N&uacute;mero Cotizaci&oacute;n
                                </div>
                                <div class="col-lg-2">
                                    <input id="numero_cotizacion" name="numero_cotizacion" on class="form-control form-control-sm"  value="<?php //if($id>0){echo $orden_compra->numero_orden_compra;}?>" type="text" readonly ="readonly">
                                </div>
                                <div class="col-lg-2">
                                    Empresa Vende
                                </div>
                                <div class="col-lg-6">
                                    <select name="empresa_vende" id="empresa_vende" class="form-control form-control-sm" onchange="">
                                        <option value="">--Seleccionar--</option>
                                        <?php
                                        foreach ($proveedor as $row){?>
                                            <option value="<?php echo $row->id ?>" <?php //if($row->id==$orden_compra->id_empresa_vende)echo "selected='selected'"?>><?php echo $row->razon_social ?></option>
                                            <?php 
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-2">
                                    Fecha Cotizaci&oacute;n
                                </div>
                                <div class="col-lg-2">
                                    <input id="fecha_cotizacion" name="fecha_cotizacion" on class="form-control form-control-sm"  value="<?php //echo isset($orden_compra) && $orden_compra->fecha_orden_compra ? $orden_compra->fecha_orden_compra : date('Y-m-d'); ?>" type="text">
                                </div>
                            
                                <div class="col-lg-2">
                                    Telefono
                                </div>
                                <div class="col-lg-2">
                                    <input id="telefono" name="telefono" on class="form-control form-control-sm"  value="<?php //if($id>0){echo $orden_compra->numero_orden_compra;}?>" type="text">
                                </div>
                                <div class="col-lg-2">
                                    Moneda
                                </div>
                                <div class="col-lg-2">
                                    <select name="moneda" id="moneda" class="form-control form-control-sm" onchange="">
                                        <option value="">--Seleccionar--</option>
                                        <?php
                                        foreach ($moneda as $row){?>
                                            <option value="<?php echo $row->codigo; ?>" <?php //echo ($id > 0 && $row->codigo == $orden_compra->id_moneda) ? "selected='selected'" : (($row->codigo == 1) ? "selected='selected'" : ""); ?>><?php echo $row->denominacion ?></option>
                                            <?php 
                                        }
                                        ?>
                                    </select>
                                    <input name="moneda_descripcion" id="moneda_descripcion" type="hidden">
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-2">
                                    Tipo de Cambio
                                </div>
                                <div class="col-lg-2">
                                    <input id="tipo_cambio" name="tipo_cambio" on class="form-control form-control-sm"  value="<?php //if($id>0){echo $orden_compra->numero_orden_compra;}?>" type="text">
                                </div>
                                <div class="col-lg-2">
                                    Aplica IGV
                                </div>
                                <div class="col-lg-2">
                                    <select name="igv_compra" id="igv_compra" class="form-control form-control-sm" onchange="">
                                        <option value="">--Seleccionar--</option>
                                        <?php
                                        foreach ($igv_compra as $row){?>
                                            <option value="<?php echo $row->codigo ?>" <?php //if($row->codigo==$orden_compra->igv_compra)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                            <?php 
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            
                            <!--<div class="row" style="padding-left:10px">
                                <div class="col-lg-12">
                                    <div class="form-group" style="text-align:center">
                                        <span class="btn btn-sm btn-warning btn-file">
                                            Examinar <input id="image" name="image" type="file" />
                                        </span>

                                        <?php 
                                        //$ind_img = count($imagenes)+1;
                                        ?>

                                        <input type="hidden" id="ind_img" name="ind_img" value="<?php //echo $ind_img?>" />

                                        <input type="button" class="btn btn-sm btn-primary upload" value="Subir" style="margin-left:10px">
                                    </div>
                                </div>
                            </div>-->
                                <div class="card-body" style="padding-right: 0px !important; padding-left: 0px !important;">
                                    <div class="table-responsive" style="overflow-y: auto; max-height: 350px;">
                                        <table id="tblCotizacionDetalle" class="table table-hover table-sm">
                                            <thead>
                                            <tr style="font-size:12px">
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
                                                <th>Sub Total</th>
                                                <th>IGV</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody id="divCotizacionDetalle" style="font-size:14px">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div style="margin-top:15px" class="form-group">
                                    <div class="col-sm-12 controls">
                                        <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">

                                            <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-nuevo" data-toggle="modal" onclick="fn_save_cotizacion()">
                                                <i class="fas fa-save" style="font-size:18px;"></i> Guardar
                                            </button>
                                            
                                            <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-cerrar" data-toggle="modal" onclick="$('#openOverlayOpc').modal('hide');">
                                                <i class="fas fa-times-circle" style="font-size:18px;"></i> Cerrar
                                            </button>
                                        </div>       
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

<div id="openOverlayOpc2" class="modal fade modal-antiguedad" tabindex="-1" role="dialog">
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

