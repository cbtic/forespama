//alert("ok");
//jQuery.noConflict(true);

$(document).ready(function () {
/*
	$('#producto01').autocomplete({
		appendTo: "#producto01_list",
		source: function (request, response) {
			$.ajax({
				url: '/comprobante/forma_pago/' + $('#producto01').val(),
				dataType: "json",
				success: function (data) {
					//alert("fddf");					
					 //alert(JSON.stringify(data));
					var resp = $.map(data, function (obj) {
						console.log(obj);
						//return obj.denominacion;
						var hash = { key: obj.codigo, value: obj.denominacion };
						return hash;
					});
					//alert(JSON.stringify(resp));
					response(resp);
					
				},
				error: function () {
					//alert("cc");
				}
			});
		},
		select: function (event, ui) {
			alert(ui.item.key);
			flag_select = true;
			$('#producto01').attr("readonly", true);
		},
		minLength: 2,
		delay: 100
	}).blur(function () {
		if (typeof flag_select == "undefined") {
			$('#producto01').val("");
		}
	});

	*/

	$('#fechaF').datepicker({
		autoclose: true,
		dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true,
	});

	$('#f_venci_01').datepicker({
		autoclose: true,
		dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true,
	});

/*
	$(function() {
		$('#producto01').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
*/

	$('#addRow').on('click', function () {
		AddFila();
	});

	$('#tblMedioPago tbody').on('click', 'button.deleteFila', function () {
		var obj = $(this);
		obj.parent().parent().remove();
		
		var val_total = 0;
		var total = 0;
		$(".importe_especie").each(function (){
			val_total = $(this).val();
			if(val_total>0)total += Number(val_total);
		});
		
		$("#precio_peso").val(total);
		//simulaPesarCarreta();
		
	});

	$('#numero_documento2').keypress(function (e) {
		if (e.keyCode == 13) {
			obtenerRepresentante();
		}
	});

	$('#id_tipooperacion_').keypress(function (e) {
		//if (e.keyCode == 13) {
			calculoDetraccion();
		//}
	});

	$('#id_tipooperacion_').click(function () {
		calculoDetraccion();
	});


	$('#descuento_global').keypress(function (e) {
		if (e.keyCode == 13) {
			calcular_descuento();
		}
	});	


	$('#porcentaje_detraccion').keypress(function (e) {
		if (e.keyCode == 13) {
			calculoDetraccion();
		}
	});


	//calculoDetraccion();

	calculaPorcentaje(1);

	
});

function calcular_descuento(){

	//alert("ok");

	var PrecioVenta_ = $('#total_fac_').val();
	//alert(PrecioVenta_);
	var Descuento_ = $('#descuento_global').val();
	var Cantidad_ = 1;
	var tasa_igv_ = 18;

	$('#descuentos').val(Descuento_);

	//PrecioVenta_ = $("#total_pagar").val();
	//alert(PrecioVenta_);

	ValorUnitario_ = PrecioVenta_ /(1+tasa_igv_);
	//alert(ValorUnitario_);
	
	ValorVB_ = ValorUnitario_ * Cantidad_;
	//alert(ValorVB_);
	
	ValorVenta_ = ValorVB_ - Descuento_;
	//alert(ValorVenta_);

	Igv_ = ValorVenta_ * tasa_igv_;
	//alert(Igv_);
	//Igv_ = Number(Igv_.toFixed(2));
	Total_ = ValorVenta_ + Igv_;
	//alert(Total_);
	//Total_ =Number(Total_.toFixed(2));

	//alert(Total_);



	ValorUnitario_ = Number(ValorUnitario_ .toFixed(2));
	//$('#txtValorUnitario').val(ValorUnitario_);
	
	ValorVB_ = Number(ValorVB_ .toFixed(2));
	//$('#txtValorVB').val(ValorVB_);
	
	ValorVenta_ = Number(ValorVenta_ .toFixed(2));
	//$('#txtValorVenta').val(ValorVenta_);
	$('#gravadas').val(ValorVenta_);

	Igv_ = Number(Igv_ .toFixed(2));
	//$('#txtIgv').val(Igv_);
	$('#igv').val(Igv_);
	
	Total_ = Number(Total_ .toFixed(2));
	//$('#txtTotal').val(Total_);
	$('#total').val(Total_);
	
	$('#total_fac_').val(Total_);
	
}

function calculoDetraccion(){
	
	var porcentaje_detraccion = $('#porcentaje_detraccion').val();
	if (porcentaje_detraccion==""){
		$('#porcentaje_detraccion').val("4");
		porcentaje_detraccion = $('#porcentaje_detraccion').val();
	}
		
	var total_fac = $('#total_fac_').val();
	var total_detraccion =total_fac*(porcentaje_detraccion)/100;
	var nc_detraccion = "00061142797";
	var tipo_detraccion = "004";
	var afecta_a = "022";
	var medio_pago = "001";
	//var tipo_operacion = "2";
	var tipo_operacion =$('#id_tipooperacion_').val();
	//var d = new Date();

	//alert(Math.round(total_fac));
	//alert(Math.round(total_fac));
	var tipo= $('#TipoF').val()

	//if (Math.round(total_fac) > 700 && tipo=='FT' ){
	//	alert(tipo_operacion);
	if (tipo_operacion=='1001' ){

		$('#porcentaje_detraccion').val(porcentaje_detraccion);		
		$('#monto_detraccion').val(total_detraccion.toFixed(2));
		$('#nc_detraccion').val(nc_detraccion);
		$('#tipo_detraccion').val(tipo_detraccion);
		$('#afecta_a').val(afecta_a);
		$('#medio_pago').val(medio_pago);
		$('#id_tipooperacion_').val(tipo_operacion);

		var total = $("#total_pagar").val();
		if (total === "0") {
			total = $("#total_fac_").val();
		}

		//var id_tipooperacion = $('#id_tipooperacion_').val();
		var monto_detraccion = $('#monto_detraccion').val();                
	

		total = total - Number(monto_detraccion);

		if ($('#id_formapago_').val() == 2) {
			//total = total - Number(reten);

			$('#numcuota_').val("1");
			$('#totalcredito_').val(total.toFixed(2).toString().replace(',', ''));
			$('#plazo_').val("30");

			generarCuotasF();
		}

	}else{
		$('#porcentaje_detraccion').val("");
		$('#monto_detraccion').val("");
		$('#nc_detraccion').val("");
		$('#tipo_detraccion').val("");
		$('#afecta_a').val("");
		$('#id_tipooperacion_').val(tipo_operacion);


		var total = $("#total_pagar").val();
		if (total === "0") {
			total = $("#total_fac_").val();
		}

		var id_tipooperacion = $('#id_tipooperacion_').val();
		var monto_detraccion = 0;                
	

		total = total - Number(monto_detraccion);

		if ($('#id_formapago_').val() == 2) {
			//total = total - Number(reten);

			$('#numcuota_').val("1");
			$('#totalcredito_').val(total.toFixed(2).toString().replace(',', ''));
			$('#plazo_').val("30");

			generarCuotasF();
		}

		
		//$('#medio_pago').value("");
	}
}

function obtenerNotaCreditoComprobante(id_orden_compra){

	//var id_orden_compra = $("#id_orden_compra").val();

	//alert(tipo_comprobante);

	$.ajax({
		url: '/comprobante/obtiene_orden_compra/' + id_orden_compra,
		dataType: "json",
		success: function (result) {

			if (result) {
				alert('SI');
				return ('Si');

				
			}
			else {
				alert('NO');						
				return ('No');
			}

		},
		"error": function (msg, textStatus, errorThrown) {

			Swal.fire("Numero de documento no fue registrado!");
			return ('No');

		}
		
		
	});
	
}

function guardarFactura(){

    var msg = "";
    var smodulo_guia = $('#smodulo_guia').val();
	var tipo_cambio = $('#tipo_cambio').val();
	
	var forma_pago = $('#forma_pago').val();

	var valorizad = $('#valorizad').val();


	var ind = $('#tblMedioPago tbody tr').length;
	
	if(ind==0)msg+="Debe adicionar el Medio de Pago <br>";
	
	var totalMedioPago = $('#totalMedioPago').val();
	var total_fac_ = $('#total_fac_').val();

	var id_formapago_ = $('#id_formapago_').val();

	var total_ = 0;
	total_ = Number(totalMedioPago);

	total_fac_ = Number(total_fac_);

	//alert(total_);
	//alert(total_fac_);

	//exit();

	if(total_!=total_fac_ && id_formapago_==1){

		$total_pagar_abono = $("#total_pagar_abono").val();

		//alert($total_pagar_abono);

		if($total_pagar_abono=="0"){
			msg+="El total de medio de pago no coincide al total del comprobante..<br>";
		}
		
	}


	var direccion = $('#direccion').val();
	var email = $('#email').val();
	var direccion2 = $('#direccion2').val();
	var email2 = $('#email2').val();
	var razon_social2 = $('#razon_social2').val();

	if(razon_social2!=''){
		direccion = direccion2;
		email= email2;
	}

	if(direccion=='')msg+="Debe ingresar la direcci&oacute;n del comprobante<br>";
	if(email=='')msg+="Debe ingresar el Email del comprobante<br>";


	//if (id_formapago_==2)


	//

	
	var ruc_e = $('#numero_documento').val();
	var ruc_p = $('#numero_documento2').val();
	                
	var tipo=$('#TipoF').val();

	//alert(ruc_p); exit();

	if(tipo == "FT" && ruc_p=="" && ruc_e==""){
		msg+="Se Requiere el Número de RUC para generar una Factura!";	
		
	}

	if(tipo == "BV" && ruc_p=="" && ruc_e=="" ){
		msg+="Se Requiere el Número de RUC o DNI para generar una Boleta!";	
		
	}


    if(smodulo_guia=="32"){
		var guia_llegada_direccion = $('#guia_llegada_direccion').val();
		if(guia_llegada_direccion=="")msg+="Debe ingresar un direcci&oacute;n de punto de llegada<br>";	
	}
	
	if (tipo_cambio==""&& forma_pago=="EFECTIVO DOLARES"){msg+="Debe ingresar el tipo de cambio<br>";	}

	var id_orden_compra = $("#id_orden_compra").val();
	var esiste_oc = obtenerNotaCreditoComprobante(id_orden_compra);
	esiste_oc="Si";

	if (esiste_oc=="Si"){msg+="La Orden de Compra ya fue Facturado...<br>";	}




    if(msg!=""){
		
		bootbox.alert(msg);
        return false;
    }
    else{
        fn_save();
	}
	

}

function guardarnc(){

	
    var msg = "";
    var tiponota = $('#tiponota_').val();
	var motivo = $('#motivo_').val();
	

		if(tiponota=="")msg+="Debe ingresar un el tipo de nota<br>";	
		if(motivo=="")msg+="Debe ingresar el motivo<br>";	
		

    if(msg!=""){
		
        Swal.fire(msg);
        return false;
    }
    else{
		
        fn_save_nc();
	}
	

}
 

function fn_save(){

    //var fecha_atencion_original = $('#fecha_atencion').val();
	//var id_user = $('#id_user').val();
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	$('#guardar').hide();
	
    $.ajax({
			url: "/comprobante/send",
            type: "POST",

			//data : $("#frmCita").serialize()+"&id_medico="+id_medico+"&fecha_cita="+fecha_cita,
            data : $("#frmFacturacion").serialize(),
			dataType: 'json',
            success: function (result) {
				/*
				if(result.sw==false){
					bootbox.alert(result.msg);
					return false;
				}
				*/
				
				//$('#numerof').val(result);
				//$('#divNumeroF').show();
				//location.href=urlApp+"/factura/"+result;
				$('.loader').hide();
				
				$('#numerof').val(result.id_factura);
				$('#divNumeroF').show();

				location.href=urlApp+"/comprobante/"+result.id_factura;

				enviar_comprobante(result.id_factura);


            }
    });
}

function fn_save_nc(){

    /*
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	$('#guardar').hide();
	*/
    $.ajax({
			url: "/comprobante/send_nc",
            type: "POST",

			//data : $("#frmCita").serialize()+"&id_medico="+id_medico+"&fecha_cita="+fecha_cita,
            data : $("#frmNC").serialize(),
			dataType: 'json',
            success: function (result) {
				
			//	$('.loader').hide();
				
				$('#numerof').val(result.id_factura);
				$('#divNumeroF').show();
				location.href=urlApp+"/comprobante/"+result.id_factura;

            }
    });
}

function validaTipoDocumento(){
	var tipo_documento = $("#tipo_documento").val();
	$('#nombre_afiliado').val("");
	$('#empresa_afiliado').val("");
	$('#empresa_direccion').val("");
	$('#empresa_representante').val("");
	$('#codigo_afiliado').val("");
	$('#fecha_afiliado').val("");

	if(tipo_documento == "1"){
		$('#divNombreApellido').hide();
		$('#divCodigoAfliado').hide();
		$('#divFechaAfliado').hide();
		$('#divDireccionEmpresa').show();
		$('#divRepresentanteEmpresa').show();
	}else{
		$('#divNombreApellido').show();
		$('#divCodigoAfliado').show();
		$('#divFechaAfliado').show();
		$('#divDireccionEmpresa').hide();
		$('#divRepresentanteEmpresa').hide();
	}
}

function validaNumeroComprobante(){
	var trans = $('#trans').val();
    alert(trans);
       // $('#numerof').val("2343");
        //$('#divNumeroF').show();
}

function obtenerPersona(){

	var tipo_documento = $("#tipo_documento").val();
	var numero_documento = $("#numero_documento").val();
	var msg = "";

	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}

	//$('#empresa_id').val("");
	$('#persona_id').val("");

	$.ajax({
		url: '/persona/obtener_persona/' + tipo_documento + '/' + numero_documento,
		dataType: "json",
		success: function(result){
			var nombre_persona= result.persona.apellido_paterno+" "+result.persona.apellido_materno+", "+result.persona.nombres;
			$('#nombre_persona').val(nombre_persona);
			$('#persona_id').val(result.persona.id);
		}

	});

}

function obtenerTitular(){

	var tipo_documento = $("#tipo_documento_tit").val();
	var numero_documento = $("#numero_documento_tit").val();
	var msg = "";

	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}

	//$('#empresa_id').val("");
	$('#titular_id').val("");

	$.ajax({
		url: '/persona/obtener_persona/' + tipo_documento + '/' + numero_documento,
		dataType: "json",
		success: function(result){
			var nombre_titular = result.persona.apellido_paterno+" "+result.persona.apellido_materno+", "+result.persona.nombres;
			$('#nombre_titular').val(nombre_titular);
			$('#titular_id').val(result.persona.id);
		}

	});

	$('#modalNuevoDuenoCargaCancelBtn').click(function (e) {
		$("#modalNuevoDuenoCargaSaveBtn").removeClass('btn-success').addClass('btn-primary');
		$("#modalNuevoDuenoCargaSaveBtn").html("Buscar");
		$("#numero_ruc_dni").val("");
		$("#empresa_nuevo_dueno_carga").val("");
		$("#persona_nuevo_dueno_carga").val("");
	});

	$('#modalNuevoDuenoCargaSaveBtn').click(function (e) {
        e.preventDefault();
        if ($("#modalNuevoDuenoCargaSaveBtn").html() != "Confirmar datos") {

            $(this).html('Realizando la consulta..');

            $.ajax({
              data: $('#modalNuevoDuenoCargaForm').serialize(),
              url: "/empresa/buscar_ajax",
              type: "POST",
              dataType: 'json',
              success: function (data) {

                //   $('#modalNuevoDuenoCargaForm').trigger("reset");
                //   $('#duenoCargaModal').modal('hide');

                 //alert(data.msg);

                if (typeof data.ruc != "undefined") {
                    $("#numero_ruc_dni").val(data.ruc);
                } else {
                    $("#numero_ruc_dni").val(data.numero_documento);
                }

                $("#empresa_nuevo_dueno_carga").val(data.razon_social);
                $("#persona_nuevo_dueno_carga").val(data.nombre_completo);
                $("#empresa_direccion").val(data.direccion);
                $("#email").val(data.email);
				$("#persona_id").val(data.persona_id);
				$("#id_ubicacion").val(data.ubicacion_id);

                if (typeof data.ruc !== "undefined") {
                    $("#modalNuevoDuenoCargaSaveBtn").removeClass('btn-primary').addClass('btn-success');
                    $("#modalNuevoDuenoCargaSaveBtn").html("Confirmar datos");
                } else if (typeof data.numero_documento !== "undefined") {
                    $("#modalNuevoDuenoCargaSaveBtn").removeClass('btn-primary').addClass('btn-success');
                    $("#modalNuevoDuenoCargaSaveBtn").html("Confirmar datos");
                } else {
                    alert(data.msg);
                    if (data.nueva != "") {
                        $("#modalNuevoEmpresaPersonaBtn").html("Nueva "+data.nueva);
                        $("#modalNuevoEmpresaPersonaBtn").show();
                        // $('#empresa_numero_ruc').val(data.numero_ruc_dni);
                        // $('#numero_documento_nueva_persona').val(data.numero_ruc_dni);
                    }

                    $("#modalNuevoDuenoCargaSaveBtn").removeClass('btn-success').addClass('btn-primary');
                    $("#modalNuevoDuenoCargaSaveBtn").html("Buscar");
                }

              },
              error: function(data) {
                mensaje = "Revisar el formulario:\n\n";
                $.each( data["responseJSON"].errors, function( key, value ) {
                mensaje += value +"\n";
                });
                $("#modalNuevoDuenoCargaSaveBtn").html("Buscar");
                alert(mensaje);
          }
          });
        } else {
            if ($("#persona_nuevo_dueno_carga").val() == '') {
                $("#badge_particular").removeClass("badge-success");
                $("#badge_empresa").addClass("badge-success");
                $("#btn_boleta").attr("style", "display:none");
                $("#btn_factura").attr("style", "display:");
            } else {
                $("#badge_empresa").removeClass("badge-success");
                $("#badge_particular").addClass("badge-success");
                $("#btn_boleta").attr("style", "display:");
                $("#btn_factura").attr("style", "display:none");
            }

            // Carga los datos en el formulario padre
            $("#numero_documento").val($("#numero_ruc_dni").val());
            $("#nombres_razon_social").val($("#empresa_nuevo_dueno_carga").val()+$("#persona_nuevo_dueno_carga").val());
            // Reinicia el formulario modal
            $("#empresa_nuevo_dueno_carga").attr("style", "display:block");
            $("#persona_nuevo_dueno_carga").attr("style", "display:none");
            $("#modalNuevoDuenoCargaSaveBtn").html("Buscar");
            $("#modalNuevoDuenoCargaSaveBtn").removeClass('btn-success').addClass('btn-primary');
            $('#modalNuevoDuenoCargaForm').trigger("reset");
            $('#duenoCargaModal').modal('hide');
        }
	});
}

	function datatablenew(){
                      
		var oTable1 = $('#tblFactura').dataTable({
			"bServerSide": true,
			"sAjaxSource": "/comprobante/listar_comprobante",
			"bProcessing": true,
			"sPaginationType": "full_numbers",
			//"paging":false,
			"bFilter": false,
			"bSort": false,
			"info": true,
			//"responsive": true,
			"language": {"url": "/js/Spanish.json"},
			"autoWidth": false,
			"bLengthChange": true,
			"destroy": true,
			"lengthMenu": [[10, 50, 100, 200, 60000], [10, 50, 100, 200, "Todos"]],
			"aoColumns": [
							{},
			],
			"dom": '<"top">rt<"bottom"flpi><"clear">',
			"fnDrawCallback": function(json) {
				$('[data-toggle="tooltip"]').tooltip();
			},
	
			"fnServerData": function (sSource, aoData, fnCallback, oSettings) {
	
				var sEcho           = aoData[0].value;
				var iNroPagina 	= parseFloat(fn_util_obtieneNroPagina(aoData[3].value, aoData[4].value)).toFixed();
				var iCantMostrar 	= aoData[4].value;
				
				var cap = $('#cap_').val();
				var nombre = $('#denominacion').val();
				var estado = $('#estado').val();
				
				var _token = $('#_token').val();
				oSettings.jqXHR = $.ajax({
					"dataType": 'json',
					//"contentType": "application/json; charset=utf-8",
					"type": "POST",
					"url": sSource,
					"data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
							nombre:nombre,cap:cap,estado:estado,
							_token:_token
						   },
					"success": function (result) {
						fnCallback(result);
					},
					"error": function (msg, textStatus, errorThrown) {
						//location.href="login";
					}
				});
			},
	
			"aoColumnDefs":
				[	
					{
					"mRender": function (data, type, row) {
						var id = "";
						if(row.id!= null)id = row.id;
						return id;
					},
					"bSortable": false,
					"aTargets": [0],
					"className": "dt-center",
					//"className": 'control'
					},
					
					{
					"mRender": function (data, type, row) {
						var numero_cap = "";
						if(row.numero_cap!= null)numero_cap = row.numero_cap;
						return numero_cap;
					},
					"bSortable": true,
					"aTargets": [1]
					},
					
					{
					"mRender": function (data, type, row) {
						var desc_cliente = "";
						if(row.desc_cliente!= null)desc_cliente = row.desc_cliente;
						return desc_cliente;
					},
					"bSortable": true,
					"aTargets": [2]
					},
					
					{
					"mRender": function (data, type, row) {
						var tipo_certificado = "";
						if(row.tipo_certificado!= null)tipo_certificado = row.tipo_certificado;
						return tipo_certificado;
					},
					"bSortable": true,
					"aTargets": [3]
					},
					
					{
						"mRender": function (data, type, row) {
							var estado = "";
							if(row.estado == 1){
								estado = "Activo";
							}
							if(row.estado == 0){
								estado = "Inactivo";
							}
							return estado;
						},
						"bSortable": false,
						"aTargets": [4]
					},
					{
						"mRender": function (data, type, row) {
							var estado = "";
							var clase = "";
							if(row.estado == 1){
								estado = "Eliminar";
								clase = "btn-danger";
							}
							if(row.estado == 0){
								estado = "Activar";
								clase = "btn-success";
							}
							
							var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
							
							html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalCertificado('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
							html += '<button style="font-size:12px;margin-left:10px" type="button" class="btn btn-sm btn-info" data-toggle="modal" onclick="Certificado_pdf('+row.id+')" ><i class="fa fa-edit"></i> Ver Certificado</button>';    
							html += '<a href="javascript:void(0)" onclick=eliminar('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
							
							//html += '<a href="javascript:void(0)" onclick=modalResponsable('+row.id+') class="btn btn-sm btn-info" style="font-size:12px;margin-left:10px">Detalle Responsable</a>';
							
							html += '</div>';
							return html;
						},
						"bSortable": false,
						"aTargets": [5],
					},
	
				]
	
	
		});
	
	}


	function calculaPorcentaje(fila) {		
		var total_fac=  $("#total_fac_").val();		
		var valorItem = $('#porcentajeproducto'+pad(fila, 2)).val()
		var contador = 0;
		$("input[name^='porcentajeproducto']").each(function(i, obj) {			
			contador++;
		});

		if(contador == 1) {
			$('#porcentajeproducto'+pad(fila, 2)).val(total_fac);
			$('#producto01').val('EFECTIVO');
		}
		else{

			$("input[name^='porcentajeproducto']").each(function(i, obj) {			
				contador++;
				valorItem+=  $('#porcentajeproducto'+pad(fila, 2)).val();
			});
			
			//alert(parseInt(obj.value));

		}


	}

	AddFila();
	function AddFila(){
		
		var newRow = "";
		var ind = $('#tblMedioPago tbody tr').length;
		var tabindex = 11;
		//var nuevalperiodo = "";

		//var f = new Date();
		var f = new Date();
		var fecha_ = f.getDate() + "-"+ f.getMonth()+ "-" +f.getFullYear();

	
		var item_producto 	= "";
		$('#idMedioPagoTemp option').each(function(){
			item_producto += "<option value="+$(this).val()+" ru='"+$(this).attr("ru")+"'>"+$(this).html()+"</option>"	
		});
	
		newRow +='<tr>';
		newRow +='<td><select class="form-control form-control-sm idMedio" id="idMedio'+ind+'" ind="'+ind+'" tabindex="'+tabindex+'" name="idMedio[]" >'+item_producto+'</select></td>';
		
		newRow +='<td><input onKeyPress="return soloNumerosMenosCero(event)" type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar el monto y presionar Enter para ingresar el nro operación" name="monto[]" required="" id="monto'+ind+'" class="limpia_text  monto input-sm   form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';
		
		newRow +='<td><input  type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar " name="nroOperacion[]" required="" id="nroOperacion'+ind+'" class="limpia_text nroOperacion input-sm   form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';
		
		newRow +='<td><input  type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar " name="descripcion[]" required="" id="descripcion'+ind+'" class="limpia_text  descripcion input-sm form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';

		newRow +='<td><input  type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar " name="fecha[]" required="" id="fecha'+ind+'" class="form-control form-control-sm datepicker fecha input-sm   form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';
		
		newRow +='<td><button type="button" class="btn btn-danger deleteFila btn-xs" style="margin-left:4px"><i class="fa fa-times"></i> Eliminar</button></td>';

		newRow +='</tr>';
		$('#tblMedioPago tbody').append(newRow);

		$("#idMedio"+ind).select2({max_selected_options: 4});
		
	
		$("#idMedio"+ind).on("change", function (e) {
			var flagx = 0;
			cmb = $(this);
			idMedio = $("#idMedio"+ind).val();

			//alert(idMedio);
			
			//id_user={{Auth::user()->id}};

			$("#tr_total_pagar").hide();
			$("#tr_total_pagar_abono").hide();
			$("#total_pagar").val("0");
			$("#total_pagar_abono").val("0");
			
		
			$('.idMedio').each(function(){
				var ind_tmp = $(this).val();
				if($(this).val() == idMedio)flagx++;
			});
		
			if(flagx > 1 && idMedio!='3'){
				//alert(idMedio);
				//if (idMedio!='254'){
					bootbox.alert("El Medio de Pago ya ha sido ingresado");
					$("#idMedio"+ind).val("").trigger("change");
					return false;				
				//}
			}
			else{
				
				if(ind==0){
					monto = $("#total_fac_").val();
					//$("#monto"+ind).val(monto);
					$("#totalMedioPago").val(monto);

					//alert (monto);
					//alert (idMedio);

					if(idMedio=='1'){
						//monto = $("#total_fac_").val();
						monto_r = redondeoContableAFavor(Number(monto), 1);


						$("#monto"+ind).val(monto_r.toFixed(2));

						if(Number(monto)!=Number(monto_r)){
							$("#tr_total_pagar").show();
							$("#total_pagar").val(monto_r.toFixed(2));
						}
	

					}else{

					//if(idMedio=='254' || idMedio=='545' || idMedio=='543'){

						$("#monto"+ind).val(monto);

						monto_r = Number(monto);

						
						$("#tr_total_pagar_abono").show();
						$("#total_pagar_abono").val(monto_r);

						//alert (monto.toFixed(2));
						

					}
					/*
					{

						$("#monto"+ind).val(monto);

						$("#total_pagar").val("0");
						$("#total_pagar_abono").val("0");
						$("#tr_total_pagar").hide();
					}
						*/

					//$("#tr_total_pagar_abono").show();
					//$("#total_pagar_abono").val(monto);

				}

				$("#fecha"+ind).val(fecha_);



				
			}
					
		});
		

		
		$("#monto"+ind).on("keyup", function (e) {
			monto = $("#monto"+ind).val();

			var total = 0;
			var val_total = 0;
			
			$(".monto").each(function (){
				val_total = $(this).val();
				
				if(val_total!="")total += Number(val_total);
			});

			//alert(total.toFixed(2));

			
			$("#totalMedioPago").val(total.toFixed(2));
			$("#total_pagar_abono").val(total.toFixed(2));
			
			
			//$("#precio_peso").val(total);
					
		});
		
	}

	function redondeoContableAFavor(valor, decimales = 1) {
		// Calcular el factor de redondeo según los decimales
		const factor = Math.pow(10, decimales);
		// Redondear hacia abajo al múltiplo más cercano según los decimales
		const valorRedondeado = Math.floor(valor * factor) / factor;
		// Calcular la diferencia (redondeo)
		//const redondeo = valor - valorRedondeado;
		return valorRedondeado;
	}



	function obtenerRepresentante(){

		var tipo_documento = "";
		var tipo_comprobante = $("#TipoF").val();

		//alert(tipo_comprobante);
		
		if(tipo_comprobante=="FT") tipo_documento = '5';
		if(tipo_comprobante=="BV") tipo_documento = '1';

		var numero_documento = $("#numero_documento2").val();

		$.ajax({
			url: '/comprobante/obtener_representante/' + tipo_documento + '/' + numero_documento,
			dataType: "json",
			success: function (result) {

				if (result) {
					$('#razon_social2').val(result.agremiado.representante);
					$('#direccion2').val(result.agremiado.direccion);
					$('#email2').val(result.agremiado.email);
					
					if(tipo_comprobante=="FT") $('#ubicacion2').val(result.agremiado.id);
					if(tipo_comprobante=="BV") $('#persona2').val(result.agremiado.id);

					

				}
				else {						
					Swal.fire("registro no encontrado!");
				}

			},
			"error": function (msg, textStatus, errorThrown) {

				Swal.fire("Numero de documento no fue registrado!");

			}
			
			
		});
		
	}
	
    function calcular_total(obj){
        var imported=$("#imported").val();
        var igv = imported*0.18;

		alert(igv);
		
        $(".imported").each(function (){

            alert(igv);

            $(this).parent().parent().find('.igvd').html();

        });
       
        
    }
	/*
	$("#chkRetencion").on('change', function() {
		if ($(this).is(':checked')) {

			var total=$("#total_pagar").val();
			var reten =0;
			
			//alert(total);
			if (total==="0"){
				total=$("#total_fac_").val();
			}
			alert(total);
			reten = Number(total)*0.03;

			$('#porcentaje_retencion').val("3");
			$('#monto_retencion').val(reten.toFixed(2));

			$("#divPorcRet").show();
		  	$("#divTotRet").show();

			if ($('#id_formapago_').val() == 2) {
				
				//var total = $('#total_fac').val();
                total = total- Number(reten);

				//alert(total);
				
				$('#numcuota_').val("1");				                
				$('#totalcredito_').val(total.toFixed(2).toString().replace(',',''));
                $('#plazo_ ').val("30");

				//alert(total.toString().replace(',',''));

				generarCuotasF();
			}

		}  
		if ($(this).is(':checked'==false)){

			$("#divPorcRet").hide();
			$("#divTotRet").hide();


			$('#porcentaje_retencion').val("");
			$('#monto_retencion').val("0");

			if ($('#id_formapago_').val() == 2) {

				alert("unchecked");
				
				var total = $("#total_pagar").val();
				//alert(total);
				if (total==="0"){
					total=$("#total_fac_").val();
				}
				//alert(total);
               
				$('#numcuota_').val("1");				
                $('#totalcredito_').val(total.toFixed(2).toString().replace(',',''));

                $('#plazo_ ').val("30");

				

				generarCuotasF();
			}


		}

		//alert($('#chkExonerado').val());	
	  });

	  */

	  $("#chkRetencion").on('change', function() {
		if ($(this).is(':checked')) {
			// Lógica cuando el checkbox está marcado
			var total = $("#total_pagar").val();
			var reten = 0;
	
			if (total === "0") {
				total = $("#total_fac_").val();
			}
	
			reten = Number(total) * 0.03;
	
			$('#porcentaje_retencion').val("3");
			$('#monto_retencion').val(reten.toFixed(2));
	
			$("#divPorcRet").show();
			$("#divTotRet").show();

			//alert($('#id_formapago_').val());

			var id_tipooperacion = $('#id_tipooperacion_').val();
			var monto_detraccion = $('#monto_detraccion').val();                
		

			if(id_tipooperacion=='1001') total = total - Number(monto_detraccion);

	
			if ($('#id_formapago_').val() == 2) {
				total = total - Number(reten);
	
				$('#numcuota_').val("1");
				$('#totalcredito_').val(total.toFixed(2).toString().replace(',', ''));
				$('#plazo_').val("30");
	
				generarCuotasF();
			}
		} else {
			
			// Lógica cuando el checkbox no está marcado
			$("#divPorcRet").hide();
			$("#divTotRet").hide();
	
			$('#porcentaje_retencion').val("");
			$('#monto_retencion').val("0");

			//alert($('#id_formapago_').val());

			var total = $("#total_pagar").val();
			if (total === "0") {
				total = $("#total_fac_").val();
			}

			var id_tipooperacion = $('#id_tipooperacion_').val();
			var monto_detraccion = $('#monto_detraccion').val();                
		

			if(id_tipooperacion=='1001') total = total - Number(monto_detraccion);

	
			if ($('#id_formapago_').val() == 2) {
								
	
				$('#numcuota_').val("1");
				$('#totalcredito_').val(total.toString().replace(',', ''));

				//alert($('#totalcredito_').val());

				$('#plazo_').val("30");
	
				generarCuotasF();
			}
		}
	});

	  function generarCuotasF() {
        // Limpiar la tabla si ya tiene filas
        $("#tblConceptos tbody").empty();

		//alert($('#totalcredito_').val());

        // Obtener valores de los inputs
        var nroCuotas = parseInt($('#numcuota_').val(), 10);
        var total = parseFloat($('#totalcredito_').val());
        var plazo = parseInt($('#plazo_').val(), 10);
        var fechaActual = new Date();

		//alert(nroCuotas);
		//alert(total);
		//alert(plazo);


        // Validar que los valores sean válidos
        if (isNaN(nroCuotas) || isNaN(total) || isNaN(plazo) || nroCuotas <= 0) {
            alert("Por favor, ingrese valores válidos.");
            return;
        }

        // Calcular el monto base de cada cuota
        var montoBase = (total / nroCuotas).toFixed(2);
        var montoBaseNum = parseFloat(montoBase);

        // Calcular el monto de la última cuota para ajustar el total
        var sumaCuotas = montoBaseNum * (nroCuotas - 1);
        var montoUltimaCuota = (total - sumaCuotas).toFixed(2);

        // Generar las filas de la tabla
        for (let i = 1; i <= nroCuotas; i++) {
            // Calcular la fecha de la cuota
            var fechaCuota = sumarDiasF(fechaActual, plazo );
            var fechaFormateada = FormatFechaF(fechaCuota);

            // Determinar el monto de la cuota
            var montoCuota = (i === nroCuotas) ? montoUltimaCuota : montoBase;

            // Crear la fila
            var newRow = '<tr id="fila' + padF(i, 2) + '">';
            newRow += '<td width="5%">' + i + '</td>';
            newRow += '<td><input name="credito[' + i + '][total_frac]" value="' + montoCuota + '"></td>';
            newRow += '<td><input name="credito[' + i + '][fecha_cuota]" value="' + fechaFormateada + '" class="form-control form-control-sm datepicker"></td>';
            newRow += '</tr>';

            // Agregar la fila a la tabla
            $('#tblConceptos tbody').append(newRow);
        }
    }

	function sumarDiasF(fecha, dias) {
        fecha.setDate(fecha.getDate() + dias);
        return fecha;
    }

    function FormatFechaF(fecha) {
        //let date = new Date()
        let date = new Date(fecha)
        let day = date.getDate()
        let month = date.getMonth() + 1
        let year = date.getFullYear()

        let fechaFormat
        if (month < 10) {
            fechaFormat = `${day}-0${month}-${year}`
        } else {
            fechaFormat = `${day}-${month}-${year}`
        }
        return fechaFormat;
    }

    function padF(num, size) {
        var s = num + "";
        while (s.length < size) s = "0" + s;
        return s;
    }

	function enviar_comprobante(id){

		$.ajax({
			url: '/comprobante/firmar/' + id ,
			dataType: "json",
			success: function (result) {

				if (result) {
					Swal.fire("Enviado al Facturador Electrónica!");

				}
				else {						
					Swal.fire("registro no encontrado!");
				}

			},
			"error": function (msg, textStatus, errorThrown) {

				Swal.fire("Numero de documento no fue registrado!");

			}
	
		});
		
	}