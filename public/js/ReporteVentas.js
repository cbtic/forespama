//alert("ok");
//jQuery.noConflict(true);

$(document).ready(function () {

	$('#btnBuscar').click(function () {
		datatableVentasAnio();
        datatablePagosAnio();
	});
    
	datatablenew();

	$('#fecha_ini_bus').datepicker({
        autoclose: true,
		format: 'dd-mm-yyyy',
		changeMonth: true,
		changeYear: true,
    });

	$('#fecha_fin_bus').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
		changeMonth: true,
		changeYear: true,
    });

    $('#btnNuevo').click(function () {
		modalFacturaHistorico(0);
	});

    $('#anio_bus').select2({ width : '100%', })

    $('#empresa_bus').select2({ width : '100%', })

});

function reporteFacturaSodimac(){

    var fecha_ini = $('#fecha_ini').val();
    var fecha_fin = $('#fecha_fin').val();
    var tipo_documento = $('#tipo_documento').val();
    var serie = $('#serie').val();
    var numero = $('#numero').val();

	if (fecha_ini == "")fecha_ini = "0";
    if (fecha_fin == "")fecha_fin = "0";
    if (tipo_documento == "") tipo_documento= 0;
    if (serie == "")serie = 0;
    if (numero == "")numero = 0;

	location.href = '/comprobante/exportar_factura_sodimac/'  + fecha_ini + '/' + fecha_fin + '/' + tipo_documento + '/'+ serie + '/'+ numero;

}



function datatableVentasAnio(){
	
	var anio =  $('#anio_bus').val();
	var empresa =  $('#empresa_bus').val();
	
    $("#tblVentasFacturado tbody").html("");
	$.ajax({
			url: "/comprobante/lista_ventas_anio/"+anio+"/"+empresa,
			type: "GET",
			success: function (result) {
					$("#tblVentasFacturado tbody").html(result);
			}
	});
}

function datatablePagosAnio(){
	
	var anio =  $('#anio_bus').val();
	var empresa =  $('#empresa_bus').val();
	
    $("#tblVentasPagado tbody").html("");
	$.ajax({
			url: "/comprobante/lista_pagos_anio/"+anio+"/"+empresa,
			type: "GET",
			success: function (result) {
					$("#tblVentasPagado tbody").html(result);
			}
	});
}

