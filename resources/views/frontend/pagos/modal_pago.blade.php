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

$(document).ready(function() {
    $(".upload").on('click', function() {
        var formData = new FormData();
        var files = $('#image')[0].files[0];
        formData.append('file',files);
        $.ajax({
			headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/ingreso_vehiculo_tronco/upload_pago",
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response != 0) {
                    $("#img_ruta").attr("src", "/img/tmp_pago/"+response);
					$("#img_foto").val(response);
                } else {
                    alert('Formato de imagen incorrecto.');
                }
            }
        });
        return false;
    });
});

</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
     $('#fecha').datepicker({
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

function guardarCita__(){
	alert("fdssf");
}

function guardarCita(id_medico,fecha_cita){
    
    var msg = "";
    var id_ipress = $('#id_ipress').val();
    var id_consultorio = $('#id_consultorio').val();
    var fecha_atencion = $('#fecha_atencion').val();
    var dni_beneficiario = $("#dni_beneficiario").val();
	//alert(id_ipress);
	if(dni_beneficiario == "")msg += "Debe ingresar el numero de documento <br>";
    if(id_ipress==""){msg+="Debe ingresar una Ipress<br>";}
    if(id_consultorio==""){msg+="Debe ingresar un Consultorio<br>";}
    if(fecha_atencion==""){msg+="Debe ingresar una fecha de atencion<br>";}
   
    if(msg!=""){
        bootbox.alert(msg); 
        return false;
    }
    else{
        fn_save_cita(id_medico,fecha_cita);
    }
}

function fn_save(){
    
	var _token = $('#_token').val();
	var id_modal = $('#id_modal').val();
	var id_ingreso_vehiculo_tronco_tipo_maderas_modal = $('#id_ingreso_vehiculo_tronco_tipo_maderas_modal').val();
	var importe = $('#importe').val();
	var fecha = $('#fecha').val();
	var observacion = $('#observacion').val();
	var id_tipodesembolso = $('#id_tipodesembolso').val();
	var nro_guia = $('#nro_guia').val();
    var nro_factura = $('#nro_factura').val();
	var img_foto = $('#img_foto').val();

	var msg = "";
    if(id_ingreso_vehiculo_tronco_tipo_maderas_modal == "")msg += "Debe ingresar el numero de documento <br>";
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
	//$('#guardar').hide();
	$("#btnGuardar").prop('disabled', true);
	
    $.ajax({
			url: "/ingreso_vehiculo_tronco/send_pago",
            type: "POST",
            data : {_token:_token,id:id_modal,id_ingreso_vehiculo_tronco_tipo_maderas:id_ingreso_vehiculo_tronco_tipo_maderas_modal,importe:importe,fecha:fecha,observacion:observacion,id_tipodesembolso:id_tipodesembolso,nro_guia:nro_guia,nro_factura:nro_factura,img_foto:img_foto},
            success: function (result) {
				/*
				$('.loader').hide();
				$('#openOverlayOpc').modal('hide');
				obtenerBeneficiario();
				*/
				location.href="/ingreso_vehiculo_tronco/pagos";
				//location.href=location.reload();
				
            }
    });
}

function fn_liberar(id){
    
	//var id_estacionamiento = $('#id_estacionamiento').val();
	var _token = $('#_token').val();
	
    $.ajax({
			url: "/estacionamiento/liberar_asignacion_estacionamiento_vehiculo",
            type: "POST",
            data : {_token:_token,id:id},
            success: function (result) {
				$('#openOverlayOpc').modal('hide');
				cargarAsignarEstacionamiento();
            }
    });
}


function validarLiquidacion() {
	
	var msg = "";
	var sw = true;
	
	var saldo_liquidado = $('#saldo_liquidado').val();
	var estado = $('#estado').val();
	
	if(saldo_liquidado == "")msg += "Debe ingresar un saldo liquidado <br>";
	if(estado == "")msg += "Debe ingresar una observacion <br>";
	
	if(msg!=""){
		bootbox.alert(msg);
		//return false;
	} else {
		//submitFrm();
		document.frmLiquidacion.submit();
	}
	return false;
}


function obtenerVehiculo(id,obj){
	
	//$("#tblPlan tbody text-white").attr('class','bg-primary text-white');
	if(obj!=undefined){
		$("#tblSinReservaEstacionamiento tbody tr").each(function (ii, oo) {
			var clase = $(this).attr("clase");
			$(this).attr('class',clase);
		});
		
		$(obj).attr('class','bg-success text-white');
	}
	//$('#tblPlanDetalle tbody').html("");
	$('#id_empresa').val(id);
	var id_estacionamiento = $('#id_estacionamiento').val();
	$.ajax({
		url: '/estacionamiento/obtener_vehiculo/'+id+'/'+id_estacionamiento,
		dataType: "json",
		success: function(result){
			
			var newRow = "";
			$('#tblPlanDetalle').dataTable().fnDestroy(); //la destruimos
			$('#tblPlanDetalle tbody').html("");
			$(result).each(function (ii, oo) {
				newRow += "<tr class='normal'><td>"+oo.placa+"</td>";
				newRow += '<td class="text-left" style="padding:0px!important;margin:0px!important">';
				newRow += '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
				newRow += '<a href="javascript:void(0)" onClick=fn_save("'+oo.id_vehiculo+'") class="btn btn-sm btn-normal">';
				newRow += '<i class="fa fa-2x fa-check" style="color:green"></i></a></a></div></td></tr>';
			});
			$('#tblPlanDetalle tbody').html(newRow);
			
			$('#tblPlanDetalle').DataTable({
				//"sPaginationType": "full_numbers",
				"paging":false,
				"dom": '<"top">rt<"bottom"flpi><"clear">',
				"language": {"url": "/js/Spanish.json"},
			});
			
			$("#system-search2").keyup(function() {
				var dataTable = $('#tblPlanDetalle').dataTable();
			   dataTable.fnFilter(this.value);
			});
			
		}
		
	});
	
}

function obtener_cuota_(){
	
	var freecuencia_pago = $('#freecuencia_pago_ option:selected').attr("codigo");
	var tiempo_pago = $('#tiempo_pago_').val();
	var nro_cuota = freecuencia_pago * tiempo_pago;
	
	$('#nro_cuota_').val(nro_cuota);
	
}

function obtener_cuota(obj){
	var nombre = $(obj).attr('name');
	var freecuencia_pago = $('#freecuencia_pago_ option:selected').attr("codigo");
	
	if(nombre=="tiempo_pago_"){
		var tiempo_pago = $('#tiempo_pago_').val();
		var nro_cuota = freecuencia_pago * tiempo_pago;
		$('#nro_cuota_').val(nro_cuota);
	}
	
	if(nombre=="nro_cuota_"){
		var nro_cuota = $('#nro_cuota_').val();
		var tiempo_pago = nro_cuota/freecuencia_pago;
		tiempo_pago = Math.round(tiempo_pago * 100) / 100;
		$('#tiempo_pago_').val(tiempo_pago);
	}
	
	if(nombre=="freecuencia_pago_"){
		$('#tiempo_pago_').val("1");
		var tiempo_pago = $('#tiempo_pago_').val();
		var nro_cuota = freecuencia_pago * tiempo_pago;
		$('#nro_cuota_').val(nro_cuota);
	}
	
}

function obtener_interes_equivalente(obj){
	
	var atributo = $(obj).attr("id");
	if(atributo == "tna" || atributo == "freecuencia_pago_" || atributo == "tiempo_pago_"){	
		var tna = $('#tna').val();
		var nro_cuota = $('#nro_cuota_').val();
		var freecuencia_pago = $('#freecuencia_pago_ option:selected').attr("codigo");
		var tiempo_pago = $('#tiempo_pago_').val();
		var equivalencia_mensual = 1/freecuencia_pago;
		tna = tna/100; 
		
		//var interes_equivalente = Math.pow(1+Math.pow((1+(tna/nro_cuota)),nro_cuota)-1,equivalencia_mensual)-1;
		var interes_equivalente = Math.pow(1+Math.pow((1+(tna/freecuencia_pago)),freecuencia_pago)-1,equivalencia_mensual)-1;
		interes_equivalente = interes_equivalente * 100;
		interes_equivalente = interes_equivalente.toFixed(3);
		
		$('#interesEquivalente').val(interes_equivalente);
	}else{
		
		var interes_equivalente = $('#interesEquivalente').val();
		var nro_cuota = $('#nro_cuota_').val();
		var freecuencia_pago = $('#freecuencia_pago_ option:selected').attr("codigo");
		var tiempo_pago = $('#tiempo_pago_').val();
		var equivalencia_mensual = 1/freecuencia_pago;
		var tna = 0;
		//var tna = nro_cuota*(Math.sqrt(nro_cuota)(Math.sqrt(equivalencia_mensual)(interes_equivalente + 1)) - 1);
		//tna = tna/100;
		//var tna = nro_cuota* (Cuadrado nro_cuota(Cuadrado equivalencia_mensual(interes_equivalente + 1)) - 1) = tna;
		
		//var tna = nro_cuota* (raiz nro_cuota(raiz equivalencia_mensual(interes_equivalente + 1)) - 1) = tna;
		//var tna = nro_cuota * (Math.pow(1+(Math.pow((interes_equivalente + 1),(1/equivalencia_mensual))-1) - 1),(1/nro_cuota));
		//var tasa_efectiva_anual = (1 + )  
		//alert(tna);
		//tna = tna * 100;
		
		//TNA = ((1 + TEA)1/360 - 1) � 360
		$('#tna').val(tna);
		
	}
	
	//var tna = nro_cuota* (Cuadrado nro_cuota(Cuadrado equivalencia_mensual(interes_equivalente + 1)) - 1) = tna;
	
	
}

//obtener_cuota_();


/*
$('#fecha_solicitud').datepicker({
	autoclose: true,
	dateFormat: 'dd-mm-yy',
	changeMonth: true,
	changeYear: true,
	container: '#openOverlayOpc modal-body'
});
*/
/*
$('#fecha_solicitud').datepicker({
	format: "dd/mm/yyyy",
	startDate: "01-01-2015",
	endDate: "01-01-2020",
	todayBtn: "linked",
	autoclose: true,
	todayHighlight: true,
	container: '#openOverlayOpc modal-body'
});
*/

/*				
format: "dd/mm/yyyy",
startDate: "01-01-2015",
endDate: "01-01-2020",
todayBtn: "linked",
autoclose: true,
todayHighlight: true,
container: '#myModal modal-body'
*/	
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
					<input type="hidden" name="id_ingreso_vehiculo_tronco_tipo_maderas_modal" id="id_ingreso_vehiculo_tronco_tipo_maderas_modal" value="<?php echo $id_ingreso_vehiculo_tronco_tipo_maderas?>">
					<input type="hidden" name="id_modal" id="id_modal" value="<?php echo $id?>">
					<div class="row">
						
					<div class="col-lg-8">
						<div class="row">

						<div class="col-lg-3">
							<div class="form-group">
								<label class="control-label">Fecha</label>
								<input id="fecha" name="fecha" class="form-control form-control-sm"  value="<?php if($id==0){echo $fecha_actual;}else{echo date('d-m-Y',strtotime($ingresoVehiculoTroncoPago->fecha));}?>" type="text">
							</div>
						</div>

						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label">Forma de Pago</label>
								<select name="id_tipodesembolso" id="id_tipodesembolso" class="form-control form-control-sm" onChange="">
									<?php foreach($tipo_desembolso as $row){?>
									<option <?php if($row->codigo==$ingresoVehiculoTroncoPago->id_tipodesembolso)echo "selected='selected'";?> value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
									<?php }?>
								</select>
							</div>
						</div>
						
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label">Importe</label>
								<input id="importe" name="importe" class="form-control form-control-sm"  value="<?php if($id==0){echo $importe;}else{echo $ingresoVehiculoTroncoPago->importe;}?>" type="number">
							</div>
						</div>
						
					</div>

					<div class="row">
						
						<div class="col-lg-3">
							<div class="form-group">
								<label class="control-label">Guia</label>
								<input id="nro_guia" name="nro_guia" class="form-control form-control-sm"  value="<?php echo $ingresoVehiculoTroncoPago->nro_guia?>" type="text">
							</div>
						</div>

						<div class="col-lg-3">
							<div class="form-group">
								<label class="control-label">Factura</label>
								<input id="nro_factura" name="nro_factura" class="form-control form-control-sm"  value="<?php echo $ingresoVehiculoTroncoPago->nro_factura?>" type="text">
							</div>
						</div>
						
					</div>
					
					<div class="row">
						
						<div class="col-lg-12">
							<div class="form-group">
								<label class="control-label">Observaci&oacute;n</label>
								<textarea id="observacion" name="observacion" class="form-control form-control-sm"><?php echo $ingresoVehiculoTroncoPago->observacion?></textarea>
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
											$url_foto = "/img/logo_forestalpama.jpg";
											if ($ingresoVehiculoTroncoPago->foto_desembolso != "") $url_foto = "/img/pago/" . $ingresoVehiculoTroncoPago->foto_desembolso;

											$foto = "";
											if ($ingresoVehiculoTroncoPago->foto_desembolso != "") $foto = $ingresoVehiculoTroncoPago->foto_desembolso;
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
	
	
	$('#tblReservaEstacionamiento').DataTable({
		"dom": '<"top">rt<"bottom"flpi><"clear">'
		});
	$("#system-search").keyup(function() {
		var dataTable = $('#tblReservaEstacionamiento').dataTable();
		dataTable.fnFilter(this.value);
	}); 
	
	$('#tblReservaEstacionamientoPreferente').DataTable({
		"dom": '<"top">rt<"bottom"flpi><"clear">'
		});
	$("#system-searchp").keyup(function() {
		var dataTable = $('#tblReservaEstacionamientoPreferente').dataTable();
		dataTable.fnFilter(this.value);
	});
	
	$('#tblSinReservaEstacionamiento').DataTable({
		"dom": '<"top">rt<"bottom"flpi><"clear">'
		});
	$("#system-search2").keyup(function() {
		var dataTable = $('#tblSinReservaEstacionamiento').dataTable();
		dataTable.fnFilter(this.value);
	}); 
	
	
});

</script>

<script type="text/javascript">
$(document).ready(function() {

	/*
	$('#numero_placa').focus();
	$('#numero_placa').mask('AAA-000');
	$('#vehiculo_numero_placa').mask('AAA-000');
	
	$('#vehiculo_numero_placa').keyup(function() {
		this.value = this.value.toLocaleUpperCase();
	});
	
	$('#vehiculo_empresa').keyup(function() {
		this.value = this.value.toLocaleUpperCase();
	});
		
	$('#vehiculo_empresa').focusin(function() { $('#vehiculo_empresa').select(); });
	
	$('#vehiculo_empresa').autocomplete({
		appendTo: "#vehiculo_empresa_busqueda",
		source: function(request, response) {
			$.ajax({
			url: '/pesaje/list/'+$('#vehiculo_empresa').val(),
			dataType: "json",
			success: function(data){
			   var resp = $.map(data,function(obj){
					var hash = {key: obj.id, value: obj.razon_social, ruc: obj.ruc};
					//if(obj.razon_social=='') { actualiza_ruc("") }
					return hash;
			   }); 
			   response(resp);
			},
			error: function() {
				//actualiza_ruc("");
			}
		});
		},
		select: function (event, ui) {
			$('#vehiculo_empresa').blur();
			$('#ruc').val(ui.item.ruc);
			//if (ui.item.value != ''){
			//actualiza_ruc(ui.item.value);
			//}
			obtener_vehiculos(ui.item.key);
			$("#id_empresa").val(ui.item.key); // save selected id to hidden input
		},
			minLength: 2,
			delay: 100
	  });
	  
	
	$('#modalVehiculoSaveBtn').click(function (e) {
		e.preventDefault();
		$(this).html('Enviando datos..');
	
		$.ajax({
		  data: $('#modalVehiculoForm').serialize(),
		  url: "/vehiculo/send_ajax_asignar",
		  type: "POST",
		  dataType: 'json',
		  success: function (data) {
	
			  $('#modalVehiculoForm').trigger("reset");
			  //$('#vehiculoModal').modal('hide');
			  $('#openOverlayOpc').modal('hide');

        alert(data.msg);
        $("#nombre_empresa").val(data.vehiculo_empresa);
        $("#numero_placa").val(data.vehiculo_numero_placa);
        $("#numero_ejes").val(data.ejes);
        $("#numero_documento").val(data.ruc);
        $("#nombres_razon_social").val(data.razon_social);
        $("#empresa_direccion").val(data.direccion);

        $("#modalVehiculoSaveBtn").html("Grabar");
	
		  },
		  error: function(data) {
        mensaje = "Revisar el formulario:\n\n";
        $.each( data["responseJSON"].errors, function( key, value ) {
          mensaje += value +"\n";
        });
        $("#modalVehiculoSaveBtn").html("Grabar");
        alert(mensaje);
      }
	  });
	});	  
	*/
});

function actualiza_ruc(razon_social) {
	$.ajax({
		url: '/pesaje/obtener_ruc/'+razon_social,
		dataType: 'json',
		type: 'GET',
		success: function(result){
			//alert(result);
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
		
		/*
		var cantidad = data.cantidad;
		var cantidadEstablecimiento = data.cantidadEstablecimiento;
		var cantidadAlmacen = data.cantidadAlmacen;
		$(cmb).closest("tr").find(".limpia_text").val("");                
		$(cmb).closest("tr").find("#nro_stocks").val(cantidad);
		$(cmb).closest("tr").find("#nro_stocks_establecimiento").val(cantidadEstablecimiento);
		$(cmb).closest("tr").find("#nro_stocks_almacen").val(cantidadAlmacen);
		$(cmb).closest("tr").find("#nro_med_solictados").val("");  
		$(cmb).closest("tr").find("#nro_med_entregados").val("");
		$(cmb).closest("tr").find("#lotes_lote").val("");
		$(cmb).closest("tr").find("#lotes_cantidad").val("");
		$(cmb).closest("tr").find("#lotes_registro_sanitario").val("");
		$(cmb).closest("tr").find("#lotes_fecha_vencimiento").val("");
		*/
	});
	
		
}
</script>

