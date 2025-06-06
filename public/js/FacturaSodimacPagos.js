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

    $('#btnDescargarPagos').on('click', function () {
		DescargarArchivosExcel()

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
            var estado_pago = $('#estado_pago_bus').val();
            var observacion_pago = $('#observacion_pago_bus').val();
            var dias_pagado = $('#dias_pagado_bus').val();
            var color_bus = $('#color_bus').val();
            
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						fecha_ini:fecha_ini,fecha_fin:fecha_fin,tipo_documento:tipo_documento, serie:serie, numero:numero, 
                        estado_pago:estado_pago, observacion_pago:observacion_pago, dias_pagado:dias_pagado, color_bus:color_bus, _token:_token
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
                    var cod_tributario = "";
					if(row.cod_tributario!= null)cod_tributario = row.cod_tributario;
					return cod_tributario;
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
						var anulado = "";
						if(row.anulado == "N"){
							anulado = "No";
						}
						if(row.anulado == "S"){
							anulado = "Si";
						}
						return anulado;
					},
					"bSortable": false,
					"aTargets": [7]
				},
				{
                "mRender": function (data, type, row) {
                    var moneda = "";
					if(row.moneda!= null)moneda = row.moneda;
					return moneda;
                },
                "bSortable": false,
                "aTargets": [8]
                },
				{
                "mRender": function (data, type, row) {
                    var subtotal = "";
					if(row.subtotal!= null)subtotal = parseFloat(row.subtotal).toFixed(2);
					return subtotal;
                },
                "bSortable": false,
                "className": "text-right",
                "aTargets": [9]
                },
				{
                "mRender": function (data, type, row) {
                    var impuesto = "";
					if(row.impuesto!= null)impuesto = parseFloat(row.impuesto).toFixed(2);
					return impuesto;
                },
                "bSortable": false,
                "className": "text-right",
                "aTargets": [10]
                },
				{
                "mRender": function (data, type, row) {
                    var total = "";
					if(row.total!= null)total = parseFloat(row.total).toFixed(2);
					return total;
                },
                "bSortable": false,
                "className": "text-right",
                "aTargets": [11]
                },
                {
                "mRender": function (data, type, row) {
                    var numero_documento_sodimac = "";
                    if(row.numero_documento_sodimac!= null)numero_documento_sodimac = row.numero_documento_sodimac;
                    return numero_documento_sodimac;
                },
                "bSortable": false,
                "aTargets": [12]
                },
                {
                "mRender": function (data, type, row) {
                    var fecha_pago = "";
                    if(row.fecha_pago!= null)fecha_pago = row.fecha_pago;
                    return fecha_pago;
                },
                "bSortable": false,
                "aTargets": [13]
                },
                {
                "mRender": function (data, type, row) {
                    var importe_total = "";
                    if(row.importe_total!= null)importe_total = parseFloat(row.importe_total).toFixed(2);
                    return importe_total;
                },
                "bSortable": false,
                "aTargets": [14],
                "className": 'text-right'
                },
                {
                "mRender": function (data, type, row) {
                    var importe_retencion = "";
                    if(row.importe_retencion!= null)importe_retencion = parseFloat(row.importe_retencion).toFixed(2);
                    return importe_retencion;
                },
                "bSortable": false,
                "aTargets": [15],
                "className": 'text-right'
                },
                {
                "mRender": function (data, type, row) {
                    var importe_detraccion = "";
                    if(row.importe_detraccion!= null)importe_detraccion = parseFloat(row.importe_detraccion).toFixed(2);
                    return importe_detraccion;
                },
                "bSortable": false,
                "aTargets": [16],
                "className": 'text-right'
                },
                {
                "mRender": function (data, type, row) {
                    var importe_inicial = "";
                    if(row.importe_inicial!= null)importe_inicial = parseFloat(row.importe_inicial).toFixed(2);
                    return importe_inicial;
                },
                "bSortable": false,
                "aTargets": [17],
                "className": 'text-right'
                },
                {
					"mRender": function (data, type, row) {
						var estado_pago_sodimac = "";
						if(row.estado_pago_sodimac == 1){
							estado_pago_sodimac = "Pagado";
						}
						if(row.estado_pago_sodimac == 0){
							estado_pago_sodimac = "Pendiente";
						}
						return estado_pago_sodimac;
					},
					"bSortable": false,
					"aTargets": [18]
				},
                {
                "mRender": function (data, type, row) {
                    //row.estado_pago == 
                    /*var coincide_total_inicial = "";
                    if(row.estado_pago_sodimac==1 && row.coincide_total_inicial!= null){
                        coincide_total_inicial = "OK" 
                    }else if (row.estado_pago_sodimac==2){
                        coincide_total_inicial="OBSERVADO"
                    }else{
                        coincide_total_inicial=""
                    };
                    return coincide_total_inicial;*/
                    var coincide_total_inicial = "";

                    if(row.estado_pago_sodimac == 1){
                        if(row.coincide_total_inicial == 1){
                            coincide_total_inicial = "Ok";
                        }
                        if(row.coincide_total_inicial == 2){
                            coincide_total_inicial = "Observado";
                        }
                    }
                    if(row.estado_pago_sodimac == 0){
                        coincide_total_inicial = "";
                    }
                    return coincide_total_inicial;
                },
                "bSortable": false,
                "aTargets": [19],
                "className": 'text-right'
                },
                {
                "mRender": function (data, type, row) {
                    
                    var dias_diferencia_pago = "";
                    if(row.dias_diferencia_pago!= null)dias_diferencia_pago = row.dias_diferencia_pago;
                    if(parseInt(row.dias_diferencia_pago)>=60){
                        return '<span style="color: red; font-weight: bold;">'+dias_diferencia_pago+'</span>';
                    }else{
                        return '<span style="color: blue; font-weight: bold;">'+dias_diferencia_pago+'</span>';
                    }
                    
                },
                "bSortable": false,
                "aTargets": [20],
                "className": 'text-right'
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

function DescargarArchivosExcel(){
	
	var fecha_ini = $('#fecha_ini_bus').val();
	var fecha_fin = $('#fecha_fin_bus').val();
	var tipo_documento = $('#tipo_documento_bus').val();
	var serie = $('#serie_bus').val();
	var numero = $('#numero_bus').val();
	var estado_pago = $('#estado_pago_bus').val();
	var observacion_pago = $('#observacion_pago_bus').val();
	var dias_pagado = $('#dias_pagado_bus').val();

	if (fecha_ini == "")fecha_ini = "0";
	if (fecha_fin == "")fecha_fin = "0";
	if (tipo_documento == "")tipo_documento = 0;
	if (serie == "")serie = 0;
	if (numero == "")numero = 0;
	if (estado_pago == "")estado_pago = 0;
	if (observacion_pago == "")observacion_pago = 0;
	if (dias_pagado == "")dias_pagado = 0;
	
	location.href = '/comprobante/exportar_listar_pagos_sodimac/'+fecha_ini+'/'+fecha_fin+'/'+tipo_documento+'/'+serie+'/'+numero+'/'+estado_pago+'/'+observacion_pago+'/'+dias_pagado;
}
