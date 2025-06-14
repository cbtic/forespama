
$(document).ready(function () {
	
	datatablenew();
		
	$('#addRow').on('click', function () {
		AddFila();
	});
	
	$('#tblProductos tbody').on('click', 'button.deleteFila', function () {
		var obj = $(this);
		obj.parent().parent().remove();
	});
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
        cargarPagoOrdenCompra(0);
        cargarGuiaOrdenCompra(0);
	});
	
    $('#fecha_inicio_bus').datepicker({
        autoclose: true,
		format: 'dd/mm/yyyy',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    $('#fecha_fin_bus').datepicker({
        autoclose: true,
		format: 'dd/mm/yyyy',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    $('#btnDescargar').on('click', function () {
		DescargarArchivosPagos();
	});
    
    $('#btnBuscar').click(function() {
        fn_ListarBusqueda();
    });

    $('#empresa_bus').select2({ widht : '100 %', })

    $('#persona_bus').select2({ widht : '100 %', })

    /*
	$('#fecha_hasta').datepicker({
        autoclose: true,
		format: 'dd/mm/yyyy',
		changeMonth: true,
		changeYear: true,
    });
	*/

});

function datatablenew() {
    var oTable = $('#tblPagoOrdenCompra').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/orden_compra/listar_orden_compra_pagos_ajax",
        "bProcessing": true,
        "sPaginationType": "full_numbers",
        "bFilter": false,
        "bSort": false,
        "info": false,
        "language": { "url": "/js/Spanish.json" },
        "autoWidth": false,
        "bLengthChange": true,
        "destroy": true,
        "lengthMenu": [
            [10, 50, 100, 200, 60000],
            [10, 50, 100, 200, "Todos"]
        ],
        "aoColumns": [
            {},
        ],
        "dom": '<"top">rt<"bottom"flpi><"clear">',
        "fnDrawCallback": function(settings) {

            let totalImporte = 0;
            let totalAbono = 0;

			settings.aoData.forEach(function(row) {
				let importe = row._aData.total;
				let importe_abono_pago = row._aData.abono_pago;
				if (importe) {
					totalImporte += parseFloat(importe);
				}
                if (importe_abono_pago) {
					totalAbono += parseFloat(importe_abono_pago);
				}
			});

			let footerHtml = '';
            for (let i = 0; i < 13; i++) {
                if (i === 10) {
                    footerHtml += `<td><b>${totalImporte.toFixed(2)}</b></td>`;
                } else if (i === 11) {
                    footerHtml += `<td><b>${totalAbono.toFixed(2)}</b></td>`;
                } else if (i === 0) {
                    footerHtml += `<td><b>Total</b></td>`;
                } else {
                    footerHtml += `<td></td>`;
                }
            }

            $('#tblPagoOrdenCompra tfoot tr').html(footerHtml);

            //$('#tblOrdenCompra tfoot th.text-right').text(totalImporte.toFixed(2));

            $('[data-toggle="tooltip"]').tooltip();
        },

        "fnServerData": function(sSource, aoData, fnCallback, oSettings) {

            var sEcho = aoData[0].value;
            var iNroPagina = parseFloat(fn_util_obtieneNroPagina(aoData[3].value, aoData[4].value)).toFixed();
            var iCantMostrar = aoData[4].value;

            var ruc = $('#ruc_bus').val();
            var empresa = $('#empresa_bus').val();
            var persona = $('#persona_bus').val();
            var placa = $('#placa_bus').val();
            var tipo_madera = $('#tipo_madera_bus').val();
            var fecha_inicio = $('#fecha_inicio_bus').val();
            var fecha_fin = $('#fecha_fin_bus').val();
            var estado_pago = $('#estado_pago_bus').val();

            var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": {
                    NumeroPagina: iNroPagina,
                    NumeroRegistros: iCantMostrar,
                    ruc: ruc, empresa: empresa, placa: placa, tipo_madera: tipo_madera, fecha_inicio:fecha_inicio,
                    fecha_fin:fecha_fin,estado_pago:estado_pago,persona:persona,
                    _token: _token
                },
                "success": function(result) {
                    fnCallback(result);

                    //var moneda = result.aaData[0].moneda;
                    //alert(moneda);


                },
                "error": function(msg, textStatus, errorThrown) {}
            });
        },
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            if (aData.moneda == "DOLARES") {
                $('td', nRow).addClass('verde');
            }
        },
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
			if (aData.moneda == "DOLARES") {
				$('td', nRow).addClass('verde');
			} 
		},
        "aoColumnDefs": [

            {
                "mRender": function(data, type, row, meta) {
                    return meta.row+1;
                },
                "bSortable": false,
                "aTargets": [0]
            },

            /*{
                "mRender": function(data, type, row, meta) {
                    var id = "";
                    if (row.id != null) id = row.id;
                    return id;
                },
                "bSortable": false,
                "aTargets": [0]
            },*/
            {
                "mRender": function(data, type, row) {
                    var fecha_orden_compra = "";
                    if (row.fecha_orden_compra != null) fecha_orden_compra = row.fecha_orden_compra;
                    return fecha_orden_compra;
                },
                "bSortable": false,
                "aTargets": [1],
            },
            {
                "mRender": function(data, type, row) {
                    var cliente = "";
                    if (row.cliente != null) cliente = row.cliente;
                    return cliente;
                },
                "bSortable": false,
                "aTargets": [2]
            },
            {
                "mRender": function(data, type, row) {
                    var vendedor = "";
                    if (row.vendedor != null) vendedor = row.vendedor;
                    return vendedor;
                },
                "bSortable": false,
                "aTargets": [3]
            },
            {
                "mRender": function(data, type, row) {
                    var bien_servicio = "";
                    if (row.bien_servicio != null) bien_servicio = row.bien_servicio;
                    return bien_servicio;
                },
                "bSortable": false,
                "aTargets": [4],
            },
            {
                "mRender": function(data, type, row) {
                    var numero_orden_compra = "";
                    if (row.numero_orden_compra != null) numero_orden_compra = row.numero_orden_compra;
                    return numero_orden_compra;
                },
                "bSortable": false,
                "aTargets": [5]
            },
            {
                "mRender": function(data, type, row) {
                    var fecha_factura = "";
                    if (row.fecha_factura != null) fecha_factura = row.fecha_factura;
                    return fecha_factura;
                },
                "bSortable": false,
                "aTargets": [6],
            },
            {
                "mRender": function(data, type, row) {
                    var numero_factura = "";
                    if (row.numero_factura != null) numero_factura = row.numero_factura;
                    return numero_factura;
                },
                "bSortable": false,
                "aTargets": [7],
            },
            {
                "mRender": function(data, type, row) {
                    var sub_total = "";
                    if (row.sub_total != null) sub_total = row.sub_total;
                    return parseFloat(sub_total).toFixed(2);
                },
                "bSortable": false,
                "aTargets": [8],
            },
            {
                "mRender": function(data, type, row) {
                    var igv = "";
                    if (row.igv != null) igv = row.igv;
                    return parseFloat(igv).toFixed(2);
                },
                "bSortable": false,
                "aTargets": [9],
            },
            {
                "mRender": function(data, type, row) {
                    var total = "";
                    if (row.total != null) total = row.total;
                    return parseFloat(total).toFixed(2);
                },
                "bSortable": false,
                "aTargets": [10],
            },
            {
                "mRender": function(data, type, row) {
                    var abono_pago = "";
                    if (row.abono_pago != null) abono_pago = row.abono_pago;
                    return abono_pago;
                },
                "bSortable": false,
                "aTargets": [11]
            },
            /*{
                "mRender": function(data, type, row) {
                    var banco = "";
                    if (row.banco != null) banco = row.banco;
                    return banco;
                },
                "bSortable": false,
                "aTargets": [12]
            },*/
            {
                "mRender": function(data, type, row) {
                    var forma_pago = "";
                    if (row.forma_pago != null) forma_pago = row.forma_pago;
                    return forma_pago;
                },
                "bSortable": false,
                "aTargets": [12]
            },
            {
                "mRender": function(data, type, row) {
                    var fecha_vencimiento = "";
                    if (row.fecha_vencimiento != null) fecha_vencimiento = row.fecha_vencimiento;
                    return fecha_vencimiento;
                },
                "bSortable": false,
                "aTargets": [13]
            },
            {
                "mRender": function(data, type, row) {
                    var guia = "";
                    if (row.guia != null) guia = row.guia;
                    return guia;
                },
                "bSortable": false,
                "aTargets": [14]
            },{
                "mRender": function(data, type, row) {
                    var estado_pago = "";
                    if (row.estado_pago != null) estado_pago = row.estado_pago;
                    return estado_pago;
                },
                "bSortable": false,
                "aTargets": [15]
            },
                /*
				{
                "mRender": function (data, type, row) {
                	var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';		
					html += '<button style="font-size:12px;color:#FFFFFF;margin-left:10px" type="button" class="btn btn-sm btn-info" data-toggle="modal" onclick="cargarCubicaje('+row.id_ingreso_vehiculo_tronco_tipo_maderas+')"><i class="fa fa-edit" style="font-size:9px!important"></i> Cubicar</button>';
					html += '<button style="font-size:12px;color:#FFFFFF;margin-left:10px" type="button" class="btn btn-sm btn-danger" data-toggle="modal" onclick="cargarReporteCubicaje('+row.id_ingreso_vehiculo_tronco_tipo_maderas+')"><i class="fa fa-edit" style="font-size:9px!important"></i> Reporte</button>';
					html += '</div>';
					return html;
                },
                "bSortable": false,
                "aTargets": [7],
				"sClass" : "cubicaje"
                },
				*/
				
            ]


    });


    fn_util_LineaDatatable("#tblPagoOrdenCompra");

    $('#tblPagoOrdenCompra tbody').on('click', 'tr', function () {
        var anSelected = fn_util_ObtenerNumeroFila(oTable);
        if (anSelected.length != 0) {
			var odtable = $("#tblPagoOrdenCompra").DataTable();
			var idPagoOrdenCompra = odtable.row(this).data().id;
            $("#id_orden_compra").val(idPagoOrdenCompra);
            //alert(idSolicitud);
			var id_estado = odtable.row(this).data().id_estado;
			$('#estado').val(id_estado);
			
            cargarPagoOrdenCompra(idPagoOrdenCompra);
            
            cargarGuiaOrdenCompra(idPagoOrdenCompra);

        }
    });

}

function cargarPagoOrdenCompra(id){

	//$("#tblCubicaje tbody").html("");
	$("#divOrdenCompra").html("");
	
	$.ajax({
        url: "/orden_compra/cargar_pago_orden_compra/"+id,
        type: "GET",
        success: function (result) {  
                //$("#tblCubicaje tbody").html(result);
                $("#divOrdenCompra").html(result);
                $("#id_orden_compra").val(id);
                $('[data-toggle="tooltip"]').tooltip();
        }
	});
	
}

function cargarGuiaOrdenCompra(id){

	//$("#tblCubicaje tbody").html("");
	$("#divOrdenCompraGuia").html("");
	
	$.ajax({
        url: "/orden_compra/cargar_guia_orden_compra/"+id,
        type: "GET",
        success: function (result) {  
                //$("#tblCubicaje tbody").html(result);
                $("#divOrdenCompraGuia").html(result);
                $("#id_orden_compra").val(id);
                $('[data-toggle="tooltip"]').tooltip();
        }
	});
	
}

function modalSolicitud(idSolicitud){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

    $(".modal-dialog").css("width", "85%");
    $('#openOverlayOpc .modal-body').css('height', 'auto');

    $.ajax({
        url: "/solicitud/modal_solicitud/" + idSolicitud,
        type: "GET",
        success: function(result) {
            $("#diveditpregOpc").html(result);
            $('#openOverlayOpc').modal('show');
        }
    });

}


function fn_ListarBusqueda() {
    datatablenew();
};

function modalPago(id){
	
	$(".modal-dialog").css("width","55%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');
	
	var id_orden_compra = $('#id_orden_compra').val();
	
	var msg = "";

	if(msg!=""){
        bootbox.alert(msg);
        return false;
    }
	
	$.ajax({
			url: "/orden_compra/modal_pago/"+id+"/"+id_orden_compra,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function modalGuia(id){
	
	$(".modal-dialog").css("width","55%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');
	
	var id_orden_compra = $('#id_orden_compra').val();
	
	var msg = "";

	if(msg!=""){
        bootbox.alert(msg);
        return false;
    }
	
	$.ajax({
			url: "/orden_compra/modal_guia/"+id+"/"+id_orden_compra,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function DescargarArchivosPagos(){
		
	var ruc = $('#ruc_bus').val();
	var empresa = $('#empresa_bus').val();
	var placa = $('#placa_bus').val();
	var tipo_madera = $('#tipo_madera_bus').val();
	var fecha_inicio = $('#fecha_inicio_bus').val();
	var fecha_fin = $('#fecha_fin_bus').val();
	var estado_pago = $('#estado_pago_bus').val();
	//var id_agremiado = 0;
	//var id_regional = 0;
	if (ruc == "")ruc = "0";
	if (empresa == "")empresa = "0";
	if (placa == "")placa = "0";
	if (tipo_madera == "")tipo_madera = 0;
	if (fecha_inicio == ""){
        fecha_inicio = "0"
    }else{
        fecha_inicio = convertirFecha(fecha_inicio);
    };
	if (fecha_fin == ""){
        fecha_fin = "0"
    }else{
        fecha_fin = convertirFecha(fecha_fin);
    };
	if (estado_pago == "")estado_pago = "0";
	//if (campo == "")campo = 0;
	//if (orden == "")orden = 0;
	
	
	location.href = '/ingreso_vehiculo_tronco/exportar_listar_pagos/'+ruc+'/'+empresa+'/'+placa+'/'+tipo_madera+'/'+fecha_inicio+'/'+fecha_fin+'/'+estado_pago;
}

function convertirFecha(fecha){

    var partes = fecha.split('/');

    if(partes.length == 3){
        return partes[2] + '-' + partes[1] + '-' + partes[0] 
    }

    return fecha;

}

function eliminarPago(id){
	var act_estado = "";
	
	act_estado = "Eliminar";
	
    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Deseas "+act_estado+" el Pago?",
        callback: function(result){
            if (result==true) {
                fn_eliminar_pago(id);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_pago(id){
	
    $.ajax({
            url: "/orden_compra/eliminar_pago/"+id,
            type: "GET",
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				datatablenew();
                cargarPagoOrdenCompra(0);
                cargarGuiaOrdenCompra(0);
            }
    });
}
