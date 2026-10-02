$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
	
	$('#btnNuevo').click(function () {
		modalMarca(0);
	});

	$('#serie_bus').keypress(function(e){
		if(e.which == 13) {
			fn_ListarBusqueda();
			return false;
		}
	});

	$('#numero_comprobante_bus').keypress(function(e){
		if(e.which == 13) {
			fn_ListarBusqueda();
			return false;
		}
	});

	$('#estado_bus').keypress(function(e){
		if(e.which == 13) {
			fn_ListarBusqueda();
			return false;
		}
	});
});

function fn_ListarBusqueda(){
    obtenerComprobante();
};

/*function obtenerComprobante(){
	
	var serie = $("#serie_bus").val();
	var numero_comprobante = $("#numero_comprobante_bus").val();
	var msg = "";
	
	if(serie == "")msg += "Debe ingresar la Serie <br>";
	if(numero_comprobante == "")msg += "Debe ingresar el Numero de Comprobante <br>";
	
	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/comprobante/obtener_datos_comprobante/' + numero_comprobante + '/' + serie,
		dataType: "json",
		success: function(result){
			//$('#frmRevisorUrbano #codigo_itf')=="";
			var agremiado = result.agremiado;
			var sw1 = result.sw;
			
			if(agremiado!="0")
			{

				if(agremiado.situacion==73)
				{
					//var tipo_documento = parseInt(agremiado.tipo_documento);
					//var nombre = persona.apellido_paterno+" "+persona.apellido_materno+", "+persona.nombres;
					$('#id_tipo_documento').val(agremiado.tipo_documento);
					$('#numero_documento').val(agremiado.numero_documento);
					$('#apellido_paterno').val(agremiado.apellido_paterno);
					$('#apellido_materno').val(agremiado.apellido_materno);
					$('#nombres').val(agremiado.nombres);
					$('#numero_regional').val(agremiado.numero_regional);
					$('#id_regional').val(agremiado.regional);
					$('#fecha_colegiado').val(agremiado.fecha_colegiado);
					$('#id_ubicacion').val(agremiado.ubicacion);
					$('#id_situacion').val(agremiado.situacion);
					$('#frmRevisorUrbano #codigo_itf').val("");
					//$('#telefono').val(persona.telefono);
					//$('#email').val(persona.email);
					
					$('.loader').hide();
				}else
				{
					if(agremiado.situacion==74){
						msg += "El Agremiado esta INHABILITADO <br>";
					}else if(agremiado.situacion==83){
						msg += "El Agremiado esta FALLECIDO <br>";
					}else if(agremiado.situacion==265){
						msg += "El Agremiado pertenece a otra REGIONAL <br>";
					}else if(agremiado.situacion==266){
						msg += "El Agremiado esta en otra PROVINCIA <br>";
					}else if(agremiado.situacion==267){
						msg += "El Agremiado esta en el EXTRANJERO <br>";
					}
					
					$('.loader').hide();
					$('#id_tipo_documento').val(agremiado.tipo_documento);
					$('#numero_documento').val(agremiado.numero_documento);
					$('#apellido_paterno').val(agremiado.apellido_paterno);
					$('#apellido_materno').val(agremiado.apellido_materno);
					$('#nombres').val(agremiado.nombres);
					$('#numero_regional').val(agremiado.numero_regional);
					$('#id_regional').val(agremiado.regional);
					$('#fecha_colegiado').val(agremiado.fecha_colegiado);
					$('#id_ubicacion').val(agremiado.ubicacion);
					$('#id_situacion').val(agremiado.situacion);
					$('#frmRevisorUrbano #codigo_itf').val("");
				}
			}else{
				msg += "El Agremiado no existe <br>";
				$('.loader').hide();
				
			}

			if (msg != "") {
				bootbox.alert(msg);
				$('#frmRevisorUrbano #codigo_itf').val("");
				return false;
			}
		}
	});
}*/

function obtenerComprobante(){

    var serie = $("#serie_bus").val();
    var numero_comprobante = $("#numero_comprobante_bus").val();

	msg="";

	if(serie == ""){
		msg="Debe ingresar la Serie. <br>"
	}
	if(numero_comprobante == ""){
		msg="Debe ingresar la Numero de Comprobante. <br>"
	}

	if(msg !=""){
		bootbox.alert(msg);
	}else{

		const tbody = $('#divComprobanteDetalle');

		tbody.empty();
		
		$.ajax({
			url: "/comprobante/obtener_datos_comprobante/"+numero_comprobante+'/'+serie,
			type: "GET",
			success: function (result) {

				let n = 1;

				var sub_total_acumulado=0;
				var igv_total_acumulado=0;
				var total_acumulado=0;
				var descuento_total_acumulado=0;

				let html = "";
				var resultado = result.comprobante;
				$("#id_comprobante").val(resultado[0].id);
				$("#fecha").val(resultado[0].fecha);
				$("#destinatario").val(resultado[0].destinatario);
				$("#ruc").val(resultado[0].ruc);
				
				result.comprobante.forEach(comprobante => {

					html +=`
					<tr>
						<td style="width: 400px !important;display:block"><input name="afect_igv[]" id="afect_igv${n}" class="afect_igv form-control form-control-sm" value="${comprobante.afect_igv}" type="hidden"><input name="id_comprobante_detalle[]" id="id_comprobante_detalle${n}" class="form-control form-control-sm" value="${comprobante.id_comprobante_detalle}" type="hidden"><input name="descripcion[]" id="descripcion${n}" class="form-control form-control-sm" value="${comprobante.producto}" readonly></td>
						
						<td><input name="cantidad[]" id="cantidad${n}" class="cantidad form-control form-control-sm" value="${comprobante.cantidad}" oninput="calcularPrecioUnitario(this);calcularSubTotal(this);calcularDescuentoProducto(this);" readonly></td>
						<td><input name="precio_venta[]" id="precio_venta${n}" class="precio_venta form-control form-control-sm" value="${parseFloat(comprobante.precio_venta || 0)}" oninput="calcularPrecioUnitario(this);calcularSubTotal(this);calcularDescuentoProducto(this);"></td>
						<td><input name="valor_unitario[]" id="valor_unitario${n}" class="valor_unitario form-control form-control-sm" value="${parseFloat(comprobante.valor_unitario || 0)}" oninput="calcularPrecioUnitario(this)" readonly></td>
						<td><input name="valor_venta_bruto[]" id="valor_venta_bruto${n}" class="valor_venta_bruto form-control form-control-sm" value="${parseFloat(comprobante.valor_venta_bruto || 0)}" oninput="calcularSubTotal(this)" readonly></td>
						<td><input name="valor_venta[]" id="valor_venta${n}" class="valor_venta form-control form-control-sm" value="${parseFloat(comprobante.valor_venta || 0)}" oninput="calcularSubTotal(this)" readonly="readonly"></td>
						<td><input name="descuento_unitario[]" id="descuento_unitario${n}" class="descuento_unitario form-control form-control-sm" value="${parseFloat((comprobante.descuento ?? 0) || 0)/comprobante.cantidad}" oninput="calcularDescuentoProducto(this);"></td>
						<td><input name="valor_descuento[]" id="valor_descuento${n}" class="valor_descuento form-control form-control-sm" value="${parseFloat((comprobante.descuento ?? 0) || 0)}" oninput="calcularPrecioUnitario(this);" readonly></td>
						<td><input name="sub_total[]" id="sub_total${n}" class="sub_total form-control form-control-sm" value="${parseFloat(comprobante.valor_venta || 0)}" readonly></td>
						<td><input name="igv[]" id="igv${n}" class="igv form-control form-control-sm" value="${parseFloat(comprobante.igv_total || 0)}" readonly></td>
						<td><input name="total[]" id="total${n}" class="total form-control form-control-sm" value="${parseFloat(comprobante.importe || 0)}" type="text" readonly></td>
					</tr>
					`;
					
					n++;
					sub_total_acumulado += parseFloat(comprobante.valor_venta || 0);
					igv_total_acumulado += parseFloat(comprobante.igv_total || 0);
					descuento_total_acumulado += parseFloat(comprobante.descuento || 0);
					total_acumulado += parseFloat(comprobante.importe || 0);

				});
				
				tbody.append(html);
				
				$('#sub_total_general').val(sub_total_acumulado.toFixed(4) || '0.00');
				$('#igv_general').val(igv_total_acumulado.toFixed(4) || '0.00');
				$('#descuento_general').val(descuento_total_acumulado.toFixed(4) || '0.00');
				$('#total_general').val(total_acumulado.toFixed(4) || '0.00');
			}
		});
	}
}

function calcularSubTotal(input) {
    var fila = $(input).closest('tr');

    var cantidad_ingreso = parseFloat(fila.find('.cantidad').val()) || 0;
    var precio_unitario = parseFloat(fila.find('.precio_venta').val()) || 0;
    var valor_venta = parseFloat(fila.find('.valor_venta').val()) || 0;

    var sub_total = valor_venta;

    var igvInputId = fila.find('.igv').attr('id');
    var totalInputId = fila.find('.total').attr('id');

}

function calcularDescuentoProducto(input){

    var fila = $(input).closest('tr');

    var descuento_unitario = fila.find(".descuento_unitario").val() || 0;
    var cantidad_ingreso = fila.find(".cantidad").val() || 0;
    //var precio_unitario = fila.find(".precio_unitario_").val() || 0;

    var descuento_total = descuento_unitario * cantidad_ingreso;

    fila.find('.valor_descuento').val(descuento_total.toFixed(4));

    //aplicaDescuentoEnSoles(input);
    calcularPrecioUnitario(input);

}

function actualizarTotalGeneral() {
    
    var sub_totalGeneral = 0;
    var igv_totalGeneral = 0;
    var totalGeneral = 0;
    var descuentolGeneral = 0;
    
    $('#divComprobanteDetalle tr').each(function() {
        var sub_totalFila = parseFloat($(this).find('.sub_total').val()) || 0;
        var igv_totalFila = parseFloat($(this).find('.igv').val()) || 0;
        var totalFila = parseFloat($(this).find('.total').val()) || 0;
        var precioVentaFila = parseFloat($(this).find('.precio_venta').val()) || 0;
        var descuentoFila = 0;
        var porcentajeFila = 0;
        var totalPorcentajeFila = 0;
        if($(this).find('.valor_descuento').val()!=""){
            descuentoFila = parseFloat($(this).find('.valor_descuento').val()) || 0;
        }else if($(this).find('.porcentaje').val()!=""){
            porcentajeFila = parseFloat($(this).find('.porcentaje').val()) || 0;
            totalPorcentajeFila = precioVentaFila * (porcentajeFila / 100);
        }
        
        sub_totalGeneral += sub_totalFila;
        igv_totalGeneral += igv_totalFila;
        totalGeneral += totalFila;
        descuentolGeneral += descuentoFila;
        descuentolGeneral += totalPorcentajeFila;
    });
    
    $('#sub_total_general').val(sub_totalGeneral.toFixed(4));
    $('#igv_general').val(igv_totalGeneral.toFixed(4));
    $('#total_general').val(totalGeneral.toFixed(4));
    $('#descuento_general').val(descuentolGeneral.toFixed(4));
}

/*function aplicaDescuentoEnSoles(inputElement) {
    var fila = $(inputElement).closest('tr');

    if (!fila.data('subtotal-original')) {
        fila.data('subtotal-original', parseFloat(fila.find('.sub_total').val()) || 0);
    }

    var subtotalOriginal = fila.data('subtotal-original');
    var descuentoEnSoles = parseFloat($(inputElement).val()) || 0;

    if (descuentoEnSoles >= 0 && descuentoEnSoles <= subtotalOriginal) {
        actualizarTotalGeneral();
    } else {
        fila.find('.sub_total').val(subtotalOriginal.toFixed(2));
    }
}*/

function calcularPrecioUnitario(input) {
    var fila = $(input).closest('tr');
    var igvPorcentaje = fila.find('.afect_igv').val() == "10" ? 1.18 : 0;
    var precio_unitario_ = 0;
    var valor_venta_bruto = 0;
    var valor_venta = 0;
    var igv = 0;
    var total = 0;

    var precio_venta = parseFloat(fila.find('.precio_venta').val()) || 0;
    var cantidad_ingreso = parseFloat(fila.find('.cantidad').val()) || 0;
    var descuento = parseFloat(fila.find('.valor_descuento').val()) || 0;
    /*var porcentaje = parseFloat(fila.find('.porcentaje').val()) || 0;*/

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
    if(descuento!= ""/* || porcentaje != ""*/){
        if(descuento!= ""){
            valor_venta = valor_venta_bruto - descuento;
        }/*else if(porcentaje != ""){
            valor_venta = valor_venta_bruto - (valor_venta_bruto * (porcentaje / 100));
        }*/
    }else{
        valor_venta = valor_venta_bruto;
    }

    if(igvPorcentaje==1.18){
        igv = valor_venta * 0.18;
    }

    total = valor_venta + igv;

    fila.find('.valor_unitario').val(precio_unitario_.toFixed(4));
    fila.find('.valor_venta_bruto').val(valor_venta_bruto.toFixed(4));
    fila.find('.valor_venta').val(valor_venta.toFixed(4));
    fila.find('.igv').val(igv.toFixed(4));
    fila.find('.sub_total').val(valor_venta.toFixed(4));
    fila.find('.total').val(total.toFixed(4));

    actualizarTotalGeneral();
}

function fn_save_ajuste_comprobante(){
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
	$('.loader').show();

	$.ajax({
		url: "/comprobante/send_ajuste_comprobante",
		type: "POST",
		data : $("#frmAjusteComprobante").serialize(),
		success: function (result) {
			
			$('.loader').hide();
			bootbox.alert("Se guard&oacute; satisfactoriamente", function() {
				location.reload();
			});
		}
	});
}
