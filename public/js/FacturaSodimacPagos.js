//alert("ok");
//jQuery.noConflict(true);

$(document).ready(function () {

	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
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

});

function datatablenew(){

    var oTable1 = $('#tblFacturaSodimacPagos').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/comprobante/listar_factura_sodimac_pagos_ajax",
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

			var fecha_ini = $('#fecha_ini_bus').val();
            var fecha_fin = $('#fecha_fin_bus').val();
			var tipo_documento = $('#tipo_documento_bus').val();
            var serie = $('#serie_bus').val();
            var numero = $('#numero_bus').val();
            
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						fecha_ini:fecha_ini,fecha_fin:fecha_fin,tipo_documento:tipo_documento, 
                        serie:serie, numero:numero, _token:_token
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
                    var ruc = "";
					if(row.ruc!= null)ruc = row.ruc;
					return ruc;
                },
                "bSortable": false,
                "aTargets": [1]
                },
                {
                "mRender": function (data, type, row) {
					var numero_orden_compra_cliente = "";
					if(row.numero_orden_compra_cliente!= null)numero_orden_compra_cliente = row.numero_orden_compra_cliente;
					return numero_orden_compra_cliente;
                },
                "bSortable": false,
                //"className": "dt-center",
                "aTargets": [2],
                },
                {
                    "mRender": function (data, type, row) {
                        var serie = "";
                        if(row.serie!= null)serie = row.serie;
                        return serie;
                    },
                    "bSortable": false,
                    //"className": "dt-center",
                    "aTargets": [3],
                },
				{
                "mRender": function (data, type, row) {
                    var numero = "";
					if(row.numero!= null)numero = row.numero;
					return numero;
                },
                "bSortable": false,
                "aTargets": [4],
				"className": 'control'
                },
				{
                "mRender": function (data, type, row) {
                    var tipo = "";
					if(row.tipo == "FT"){
                        tipo = "FACTURA";
                    }
                    if(row.tipo == "BV"){
                        tipo = "BOELTA";
                    }
                    if(row.tipo == "NC"){
                        tipo = "NOTA DE CREDITO";
                    }
                    if(row.tipo == "ND"){
                        tipo = "NOTA DE DEBITO";
                    }
                    if(row.tipo == "TK"){
                        tipo = "TICKET";
                    }
					return tipo;
                    
                },
                "bSortable": false,
                "aTargets": [5]
                },
/*
				{
                "mRender": function (data, type, row) {
                    var plan_denominacion = "";
					if(row.plan_denominacion!= null)plan_denominacion = row.plan_denominacion;
					return plan_denominacion;
                },
                "bSortable": false,
                "aTargets": [6]
                },
                */
				{
                "mRender": function (data, type, row) {
                    var fecha = "";
					if(row.fecha!= null)fecha = row.fecha;
					return fecha;
                },
                "bSortable": false,
                "aTargets": [6]
                },
				{
                "mRender": function (data, type, row) {
                    var moneda = "";
					if(row.moneda!= null)moneda = row.moneda;
					return moneda;
                },
                "bSortable": false,
                "aTargets": [7]
                },
				{
                "mRender": function (data, type, row) {
                    var subtotal = "";
					if(row.subtotal!= null)subtotal = parseFloat(row.subtotal).toFixed(2);
					return subtotal;
                },
                "bSortable": false,
                "className": "text-right",
                "aTargets": [8]
                },
				{
                "mRender": function (data, type, row) {
                    var impuesto = "";
					if(row.impuesto!= null)impuesto = parseFloat(row.impuesto).toFixed(2);
					return impuesto;
                },
                "bSortable": false,
                "className": "text-right",
                "aTargets": [9]
                },
				{
                "mRender": function (data, type, row) {
                    var total = "";
					if(row.total!= null)total = parseFloat(row.total).toFixed(2);
					return total;
                },
                "bSortable": false,
                "className": "text-right",
                "aTargets": [10]
                },
                {
                "mRender": function (data, type, row) {
                    var numero_documento_sodimac = "";
                    if(row.numero_documento_sodimac!= null)numero_documento_sodimac = row.numero_documento_sodimac;
                    return numero_documento_sodimac;
                },
                "bSortable": false,
                "aTargets": [11]
                },
				   		          
            ]

    });

}

function fn_ListarBusqueda() {
    datatablenew();
};



function modalCreditoPago(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/comprobante/credito_pago/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function modalFactura(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/factura/modal_factura/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

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


function modalLiquidacion(id){

	$(".modal-dialog").css("width","80%");
	$('#openOverlayOpc').modal('show');
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/ingreso/modal_liquidacion/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
			}
	});

}

function modalFacturaHistorico(id){

    $(".modal-dialog").css("width","80%");
	$('#openOverlayOpc').modal('show');
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/comprobante/modal_factura_historico/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
			}
	});

}

