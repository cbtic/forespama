<title>Sistema de Forespama</title>

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
	max-width:45%!important
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


<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
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

$(document).ready(function() {
		
});

$(document).ready(function() {
    $(".upload").on('click', function() {
        var formData = new FormData();
        var files = $('#image')[0].files[0];
        formData.append('file',files);
        $.ajax({
			headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/orden_compra/upload_pago",
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response != 0) {
                    $("#img_ruta").attr("src", "/img/tmp_pago_orden_compra/"+response);
					$("#img_foto").val(response);
                } else {
                    alert('Formato de imagen incorrecto.');
                }
            }
        });
        return false;
    });

	checkBoxDetraccion();
	
});

</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
     $('#fecha').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
     });

	 $('#fecha_factura').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
     });

	 $('#fecha_tc').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
     });	 
});

$(document).ready(function() {
	 
});

function validacion(){
    
    var msg = "";
    var cobservaciones=$("#frmComentar #cobservaciones").val();
    
    if(cobservaciones==""){msg+="Debe ingresar una Observacion <br>";}
    
    if(msg!=""){
        bootbox.alert(msg); 
        return false;
    }
}

function validar_tipo(){

	var id_tipodesembolso = $("#id_tipodesembolso").val();
	$("#divCheque").hide();
	$("#divNumeroOperacion").hide();
	if(id_tipodesembolso==2){
		$("#divCheque").show();
	}
	if(id_tipodesembolso==3){
		$("#divNumeroOperacion").show();
	}
}

function fn_save(){
    
	var _token = $('#_token').val();
	var id_modal = $('#id_modal').val();
	var id_orden_compra_modal = $('#id_orden_compra_modal').val();
	var importe = $('#importe').val();
	var fecha = $('#fecha').val();
	var observacion = $('#observacion').val();
	var id_tipodesembolso = $('#id_tipodesembolso').val();
	var nro_guia = $('#nro_guia').val();
    var nro_factura = $('#nro_factura').val();
	var nro_cheque = $('#nro_cheque').val();
	var img_foto = $('#img_foto').val();
	var id_banco = $('#id_banco').val();
	var nro_operacion = $('#nro_operacion').val();
	var tipo_documento = $('#tipo_documento').val();
	var serie_factura = $('#serie_factura').val();
	var nro_factura = $('#nro_factura').val();
	var fecha_factura = $('#fecha_factura').val();
	var glosa_comprobante = $('#glosa_comprobante').val();
	var glosa_movimiento = $('#glosa_movimiento').val();
	var conversion = $('#conversion').val();
	var tasa_cambio_especial = $('#tasa_cambio_especial').val();
	var fecha_tc = $('#fecha_tc').val();
	var tasa_cambio = $('#tasa_cambio').val();

	var msg = "";
    if(id_orden_compra_modal == "")msg += "Debe ingresar el numero de documento <br>";
    if(importe==""){msg+="Debe ingresar un Importe<br>";}
    if(fecha==""){msg+="Debe ingresar una Fecha<br>";}
    
	if(msg!=""){
        bootbox.alert(msg); 
        return false;
    }
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

	$("#btnGuardar").prop('disabled', true);
	
    $.ajax({
		url: "/orden_compra/send_pago",
		type: "POST",
		data : {_token:_token,
				id:id_modal, id_orden_compra:id_orden_compra_modal, importe:importe, fecha:fecha,observacion:observacion, id_tipodesembolso:id_tipodesembolso,
				nro_guia:nro_guia, nro_factura:nro_factura, nro_cheque:nro_cheque, img_foto:img_foto, id_banco:id_banco, nro_operacion:nro_operacion,
				tipo_documento:tipo_documento, serie_factura:serie_factura, nro_factura:nro_factura, fecha_factura:fecha_factura, glosa_comprobante:glosa_comprobante,
				glosa_movimiento:glosa_movimiento, conversion:conversion, tasa_cambio_especial:tasa_cambio_especial, fecha_tc:fecha_tc, tasa_cambio:tasa_cambio},
		success: function (result) {
			
			location.href="/orden_compra/create_pago_orden_compra";
			
		}
    });
}

function obtenerGlosaCompuesta(){

	var tipo_documento = $('#tipo_documento').val();
	var serie_factura = $('#serie_factura').val();
	var nro_factura = $('#nro_factura').val();

	var glosa_compuesta = tipo_documento + " " + serie_factura + "-" + nro_factura + " / ";
	$('#glosa_comprobante').val(glosa_compuesta);

}

function habilitarTC(){

	var conversion = $('#conversion').val();
	$('#tasa_cambio').val('');
	$('#tasa_cambio_especial').val('');
	
	if(conversion== '1' || conversion == '2'){
		$("#tasa_cambio_especial").prop('disabled', true);
		$('#tasa_cambio').prop('disabled', false);

		$.ajax({
			url: '/tipo_cambio/obtenerUltimoTipoCambio',
			dataType: 'json',
			type: 'GET',
			success: function(result){

				$('#tasa_cambio').val(result[0].valor_compra);

			},
		});
	}else{
		$("#tasa_cambio_especial").prop('disabled', false);
		$('#tasa_cambio').prop('disabled', true);
	}
}

function checkBoxDetraccion() {

    let activo = $('#detraccion').is(':checked');

    if (activo) {
        $('#bloque_detraccion').show();
    } else {
        $('#bloque_detraccion').hide();
    }
}

$('#detraccion').on('change', function() {
    checkBoxDetraccion();
});

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
					Lista de Pagos
				</div>
				
				<div class="card-body">

					<div class="row">

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:10px">
								
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="id_orden_compra_modal" id="id_orden_compra_modal" value="<?php echo $id_orden_compra?>">
							<input type="hidden" name="id_modal" id="id_modal" value="<?php echo $id?>">

							<div class="row">
								<div class="col-lg-8">
									<div class="row">

										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label">Fecha Pago</label>
												<input id="fecha" name="fecha" class="form-control form-control-sm"  value="<?php if($id==0){echo $fecha_actual;}else{echo date('d-m-Y',strtotime($orden_compra_pago->fecha));}?>" type="text">
											</div>
										</div>

										<div class="col-lg-4">
											<div class="form-group">
												<label class="control-label">Forma de Pago</label>
												<select name="id_tipodesembolso" id="id_tipodesembolso" onchange="validar_tipo()" class="form-control form-control-sm" onChange="">
													<?php foreach($tipo_desembolso as $row){?>
													<option <?php if($row->codigo==$orden_compra_pago->id_tipo_desembolso)echo "selected='selected'";?> value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
													<?php }?>
												</select>
											</div>
										</div>
									
										<div class="col-lg-4" id="divCheque" <?php if($orden_compra_pago->id_tipodesembolso!=2 || $id==0)echo "style='display:none'"?>>
											<div class="form-group">
												<label class="control-label">Cheque</label>
												<input id="nro_cheque" name="nro_cheque" class="form-control form-control-sm"  value="<?php echo $orden_compra_pago->nro_cheque?>" type="number">
											</div>
										</div>

										<div class="col-lg-4" id="divNumeroOperacion" <?php if($orden_compra_pago->id_tipodesembolso!=3 || $id==0)echo "style='display:none'"?>>
											<div class="form-group">
												<label class="control-label">N&uacute;mero Operaci&oacute;n</label>
												<input id="nro_operacion" name="nro_operacion" class="form-control form-control-sm"  value="<?php echo $orden_compra_pago->nro_operacion?>" type="number">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-4">
											<div class="form-group">
												<label class="control-label">Importe</label>
												<input id="importe" name="importe" class="form-control form-control-sm"  value="<?php if($id==0){echo $importe;}else{echo $orden_compra_pago->importe;}?>" type="number">
											</div>
										</div>

										<div class="col-lg-4">
											<div class="form-group">
												<label class="control-label">Banco</label>
												<select name="id_banco" id="id_banco" onchange="" class="form-control form-control-sm" onChange="">
													<option value="">--Seleccionar--</option>
													<?php foreach($banco as $row){?>
													<option <?php if($row->codigo==$orden_compra_pago->id_banco)echo "selected='selected'";?> value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
													<?php }?>
												</select>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label">Tipo Documento</label>
												<select name="tipo_documento" id="tipo_documento" class="form-control form-control-sm filtro-select" onchange="obtenerGlosaCompuesta()">
													<option selected="selected" value="FT">
														<?php echo "Factura" ?></option>
													<option value="BV">
														<?php echo "Boleta" ?></option>
													<option value="NC">
														<?php echo "Nota de Credito" ?></option>
													<option value="ND">
														<?php echo "Nota de Debito" ?></option>
													<option value="TK">
														<?php echo "Ticket" ?></option>
												</select>
											</div>
										</div>

										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label">Serie</label>
												<input id="serie_factura" name="serie_factura" class="form-control form-control-sm"  value="<?php //echo $orden_compra_pago->nro_factura?>" type="text" oninput="obtenerGlosaCompuesta()">
											</div>
										</div>

										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label">N° Documento</label>
												<input id="nro_factura" name="nro_factura" class="form-control form-control-sm"  value="<?php //echo $orden_compra_pago->nro_factura?>" type="text" oninput="obtenerGlosaCompuesta()">
											</div>
										</div>

										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label">Fecha Factura</label>
												<input id="fecha_factura" name="fecha_factura" class="form-control form-control-sm"  value="<?php //if($id==0){echo $fecha_actual;}else{echo date('d-m-Y',strtotime($orden_compra_pago->fecha));}?>" type="text">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label">Glosa Comprobante</label>
												<input id="glosa_comprobante" name="glosa_comprobante" class="form-control form-control-sm"  value="<?php //echo $orden_compra_pago->nro_factura?>" type="text" readonly>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label">Glosa Movimiento</label>
												<input id="glosa_movimiento" name="glosa_movimiento" class="form-control form-control-sm"  value="<?php //echo $orden_compra_pago->nro_factura?>" type="text">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label">Conversi&oacute;n</label>
												<select name="conversion" id="conversion" class="form-control form-control-sm" onchange="habilitarTC()">
													<option value="">--Seleccionar--</option>
													<?php foreach($conversion as $row){?>
													<option <?php //if($row->codigo==$orden_compra_pago->id_banco)echo "selected='selected'";?> value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
													<?php }?>
												</select>
											</div>
										</div>

										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label">T/C Especial</label>
												<input id="tasa_cambio_especial" name="tasa_cambio_especial" class="form-control form-control-sm"  value="<?php //echo $orden_compra_pago->nro_factura?>" type="text">
											</div>
										</div>

										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label">Fecha T/C</label>
												<input id="fecha_tc" name="fecha_tc" class="form-control form-control-sm"  value="<?php echo date('d-m-Y')?>" type="text">
											</div>
										</div>

										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label">Tasa de Cambio</label>
												<input id="tasa_cambio" name="tasa_cambio" class="form-control form-control-sm"  value="<?php //echo $orden_compra_pago->nro_factura?>" type="text">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-4">
											<div class="form-group">
												<label class="control-label">Destino</label>
												<select name="destino" id="destino" onchange="" class="form-control form-control-sm" onChange="">
													<option value="">--Seleccionar--</option>
													<?php foreach($destino_operaciones as $row){?>
													<option <?php if($row->id==$orden_compra_pago->id_destino)echo "selected='selected'";?> value="<?php echo $row->id?>"><?php echo $row->descripcion?></option>
													<?php }?>
												</select>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-4">
											<div class="form-check">
												<input class="form-check-input" type="checkbox" name="detraccion" value="1" id="detraccion" <?php //if($orden_compra_pago->detraccion == 1) echo 'checked'; ?>>
												<label class="form-check-label" for="cliente">Detracci&oacute;n</label>
											</div>
										</div>
									</div>
									<div id="bloque_detraccion">
										<div class="row">
											<div class="col-lg-4">
												<div class="form-group">
													<label class="control-label">Tipo Operaci&oacute;n</label>
													<select name="tipo_operacion" id="tipo_operacion" onchange="" class="form-control form-control-sm" onChange="">
														<option value="">--Seleccionar--</option>
														<?php //foreach($tipo_operacion as $row){?>
														<option <?php //if($row->id==$orden_compra_pago->id_tipo_operacion)echo "selected='selected'";?> value="<?php //echo $row->id?>"><?php //echo $row->denominacion?></option>
														<?php //}?>
													</select>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label class="control-label">C&oacute;digo Detraci&oacute;n</label>
													<select name="codigo_detraccion" id="codigo_detraccion" onchange="" class="form-control form-control-sm" onChange="">
														<option value="">--Seleccionar--</option>
														<?php //foreach($codigo_detraccion as $row){?>
														<option <?php //if($row->id==$orden_compra_pago->id_tipo_operacion)echo "selected='selected'";?> value="<?php //echo $row->id?>"><?php //echo $row->denominacion?></option>
														<?php //}?>
													</select>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label class="control-label">Documento</label>
													<input id="documento_detraccion" name="documento_detraccion" class="form-control form-control-sm"  value="<?php //echo $orden_compra_pago->nro_factura?>" type="text">
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label class="control-label">Fecha Detracci&oacute;n</label>
													<input id="fecha_detraccion" name="fecha_detraccion" class="form-control form-control-sm"  value="<?php echo date('d-m-Y')?>" type="text">
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label class="control-label">Importe Referencial</label>
													<input id="importe_referencial" name="importe_referencial" class="form-control form-control-sm"  value="<?php //echo $orden_compra_pago->nro_factura?>" type="text">
												</div>
											</div>
										</div>
									</div>
								
									<div class="row">
										<div class="col-lg-12">
											<div class="form-group">
												<label class="control-label">Observaci&oacute;n</label>
												<textarea id="observacion" name="observacion" class="form-control form-control-sm"><?php echo $orden_compra_pago->observacion?></textarea>
											</div>
										</div>
									</div>
								</div>

								<div class="col-lg-4">
									<div class="row">
										<div class="col-lg-12">
											<div class="form-group">
												<span class="btn btn-sm btn-warning btn-file">
													Examinar <input id="image" name="image" type="file" />
												</span>
												<input type="button" class="btn btn-sm btn-primary upload" value="Subir" style="margin-left:10px">
												
												<?php
													$url_foto = "/img/logo_forestalpama5.jpeg";
													if ($orden_compra_pago->foto_desembolso != "") $url_foto = "/img/pago_orden_compra/" . $id_orden_compra . "/" . $orden_compra_pago->foto_desembolso;

													$foto = "";
													if ($orden_compra_pago->foto_desembolso != "") $foto = $orden_compra_pago->foto_desembolso;
												?>

												<img src="<?php echo $url_foto ?>" id="img_ruta" width="240px" height="150px" alt="" style="margin-top:10px" />
												<input type="hidden" id="img_foto" name="img_foto" value="<?php echo $foto ?>" />
											</div>
										</div>
									</div>
								</div>
							</div>

							<div style="margin-top:10px" class="row form-group">
								<div class="col-sm-12 controls">
									<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions" style="float:right">
										<!--<a href="javascript:void(0)" id="btnGuardar" onClick="fn_save()" class="btn btn-sm btn-success">Guardar</a>-->
										<input class="btn btn-sm btn-success" value="Guardar" type="button" id="btnGuardar" onClick="fn_save()">
									</div>
								</div>
							</div>
						</div> 
					<!-- /.box -->
					</div>
				<!--/.col (left) -->
				</div>
			<!-- /.row -->
			</section>
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

function actualiza_ruc(razon_social) {
	$.ajax({
		url: '/pesaje/obtener_ruc/'+razon_social,
		dataType: 'json',
		type: 'GET',
		success: function(result){

			$('#ruc').val(result);
		},
		error: function(){
			$('#ruc').val('');
		}

	});
}


function obtener_vehiculos(id){
	
	option = {
		url: '/pesaje/obtener_vehiculo_empresa/' + id,
		type: 'GET',
		dataType: 'json',
		data: {}
	};
	$.ajax(option).done(function (data) {
		
		var option = "<option value='0'>Seleccionar</option>";
		$("#id_vehiculo").html("");
		$(data).each(function (ii, oo) {
			option += "<option value='"+oo.id+"'>"+oo.placa+"</option>";
		});
		$("#id_vehiculo").html(option);
		$("#id_vehiculo").val(id).select2();
		
	});
}

</script>
