
$(document).ready(function () {
	
	datatablenew();

	datatablenew2();
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

    /*$('#fecha_inicio_bus').datepicker({
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
    });*/

    $('#btnDescargarCubicaje').on('click', function () {
		DescargarReporteCubicaje();
	});

    $('#btnDescargarPagos').on('click', function () {
		DescargarReportePagos();
	});

    function getLastMonday() {
        let today = new Date();
        let dayOfWeek = today.getDay();
        let daysToSubtract = dayOfWeek === 1 ? 7 : (dayOfWeek === 0 ? 6 : dayOfWeek - 1);
        let lastMonday = new Date();
        lastMonday.setDate(today.getDate() - daysToSubtract);
        return lastMonday.toLocaleDateString('es-ES');
    }

    function getToday() {
        return new Date().toLocaleDateString('es-ES');
    }

    $('#fecha_inicio_bus').val(getLastMonday());
    $('#fecha_fin_bus').val(getToday());

    $('#fecha_inicio_bus, #fecha_fin_bus').datepicker({
       
        autoclose: true,
		format: 'dd/mm/yyyy',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

});

function formato_miles(numero) {

    return parseFloat(numero).toFixed(2).replace(/\D/g, "").replace(/([0-9])([0-9]{2})$/, '$1.$2').replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
}



function cargarPagos() {


    //var numero_documento = $("#numero_documento").val();
    var tipo_documento = $("#tipo_documento").val();
    var persona_id = 0;
    if (tipo_documento == "RUC") persona_id = $('#empresa_id').val();
    else persona_id = $('#persona_id').val();

    $("#tblPago tbody").html("");
    $.ajax({
        //url: "/ingreso/obtener_pago/"+numero_documento,
        url: "/ingreso/obtener_pago/" + tipo_documento + "/" + persona_id,
        type: "GET",
        success: function(result) {
            $("#tblPago tbody").html(result);
        }
    });

}

// Padding Zeros
function pad(str, max) {
    str = str.toString();
    return str.length < max ? pad("0" + str, max) : str;
}

function datatablenew() {
    var oTable = $('#tblReporteCubicaje').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/ingreso_vehiculo_tronco/listar_ingreso_vehiculo_tronco_reporte_ajax",
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
            let totalCantidad = 0;
            let totalM3 = 0;
            let totalPies = 0;
            let totalPrecioFinal = 0;
            let totalTabulacion = 0;
            let totalPromedio = 0;
            let contadorPromedios = 0;
            
            settings.aoData.forEach(function(row) {
                const razon_social = row._aData.razon_social;

                // Solo sumar si es una fila de TOTAL del día
                if (razon_social && razon_social.includes("Total")) {
                    totalCantidad += parseFloat(row._aData.cantidad || 0);
                    totalM3 += parseFloat(row._aData.volumen_total_m3 || 0);
                    totalPies += parseFloat(row._aData.volumen_total_pies || 0);
                    totalPrecioFinal += parseFloat(row._aData.precio_total || 0);
                    
                    // Solo promediar si hay valor válido
                    const promedio = parseFloat(row._aData.promedio);
                    if (!isNaN(promedio)) {
                        totalPromedio += promedio;
                        contadorPromedios++;
                    }
                }
            });

            totalTabulacion = totalPrecioFinal;

            totalPromedio = totalPies > 0 ? totalPrecioFinal / totalPies : 0;

            $('#tblReporteCubicaje tfoot').html('');

            $('#tblReporteCubicaje tfoot').append(`
                <tr>
                    <td style="font-size:13px" colspan="2"><b>Total</b></td>
                    <td style="text-align : right; font-size:13px"><b>${totalCantidad}</b></td>
                    <td style="text-align : right; font-size:13px"><b>${formato_miles(totalM3)}</b></td>
                    <td style="text-align : right; font-size:13px"><b>${formato_miles(totalPies)}</b></td>
                    <td style="text-align : right; font-size:13px"><b>${formato_miles(totalTabulacion)}</b></td>
                    <td style="text-align : right; font-size:13px"><b>${formato_miles(totalPromedio)}</b></td>
                    <td style="text-align : right; font-size:13px"><b>${formato_miles(totalPrecioFinal)}</b></td>
                </tr>
            `);
            $('[data-toggle="tooltip"]').tooltip();
            $('#tfoot tbody tr').removeClass('fila-par');
    		$('#tfoot tbody tr:even').addClass('fila-par');
                
        },

        "fnServerData": function(sSource, aoData, fnCallback, oSettings) {

            var sEcho = aoData[0].value;
            var iNroPagina = parseFloat(fn_util_obtieneNroPagina(aoData[3].value, aoData[4].value)).toFixed();
            var iCantMostrar = aoData[4].value;

            /*var ruc = $('#ruc_bus').val();
            var empresa = $('#empresa_bus').val();
            var placa = $('#placa_bus').val();
            var tipo_madera = $('#tipo_madera_bus').val();*/
            var fecha_inicio = $('#fecha_inicio_bus').val();
            var fecha_fin = $('#fecha_fin_bus').val();

            var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": {
                    NumeroPagina: iNroPagina,
                    NumeroRegistros: iCantMostrar,
                    fecha_inicio:fecha_inicio,
                    fecha_fin:fecha_fin,
                    _token: _token
                },
                "success": function(result) {
                    var groupedData = {};
                    result.aaData.forEach(function(item) {
                        if (!groupedData[item.fecha_ingreso]) {
                            groupedData[item.fecha_ingreso] = [];
                        }
                        groupedData[item.fecha_ingreso].push(item);
                    });

                    // Crear un nuevo array con datos agrupados y totales
                    var finalData = [];
                    Object.keys(groupedData).sort().forEach(function(fecha) {
                        var totalCantidad = 0, totalM3 = 0, totalPies = 0, totalTabulacion = 0, totalPromedio = 0, totalPrecioFinal = 0;
                        var count = 0; // Para calcular el promedio

                        groupedData[fecha].forEach(item => {
                            totalCantidad += parseFloat(item.cantidad) || 0;
                            totalM3 += parseFloat(item.volumen_total_m3) || 0;
                            totalPies += parseFloat(item.volumen_total_pies) || 0;
                            totalTabulacion += parseFloat(item.precio_total) || 0;
                            totalPrecioFinal += parseFloat(item.precio_total) || 0;
                            if (!isNaN(parseFloat(item.promedio))) {
                                totalPromedio += parseFloat(item.promedio);
                                count++;
                            }
                        });

                        // Calcular promedio si hay valores válidos
                        totalPromedio = (totalPrecioFinal / totalPies).toFixed(2);

                        finalData = finalData.concat(groupedData[fecha]); // Agregar los datos del grupo

                        // Convertir la fecha a día de la semana
                        var partes = fecha.split('-'); // Separar en [DD, MM, YYYY]
                        var fechaObj = new Date(partes[2], partes[1] - 1, partes[0]); // Crear fecha (mes en base 0)

                        if (!isNaN(fechaObj.getTime())) {
                            var diaSemana = fechaObj.toLocaleDateString('es-ES', { weekday: 'long' });
                            diaSemana = diaSemana.charAt(0).toUpperCase() + diaSemana.slice(1); // Capitaliza la primera letra

                            // Agregar la fila de total al final del grupo
                            finalData.push({ 
                                fecha_ingreso: "", 
                                razon_social: `<strong>Total ${diaSemana}</strong>`, 
                                cantidad: totalCantidad, 
                                volumen_total_m3: totalM3.toFixed(2), 
                                volumen_total_pies: totalPies.toFixed(2), 
                                precio_total: totalTabulacion.toFixed(2), 
                                promedio: totalPromedio, 
                                precio_total: totalPrecioFinal.toFixed(2) 
                            });
                        } else {
                            console.error("Fecha inválida:", fecha);
                        }
                    });

                    // Pasar los datos agrupados a DataTable
                    result.aaData = finalData;


                    fnCallback(result);

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

            /*{
                "mRender": function(data, type, row, meta) {
                    return meta.row+1;
                },
                "bSortable": false,
                "aTargets": [0]
            },

            {
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
                    var fecha_ingreso = "";
                    if (row.fecha_ingreso != null) fecha_ingreso = row.fecha_ingreso;
                    return fecha_ingreso;
                },
                "bSortable": false,
                "aTargets": [0],
            },
            {
                "mRender": function(data, type, row) {
                    var razon_social = "";
                    if (row.razon_social != null) razon_social = row.razon_social;
                    return razon_social;
                },
                "bSortable": false,
                "aTargets": [1]
            },
            {
                "mRender": function(data, type, row) {
                    var cantidad = "";
                    if (row.cantidad != null) cantidad = row.cantidad;
                    return cantidad;
                },
                "bSortable": false,
                "aTargets": [2],
                "className": "text-right",
            },
            {
                "mRender": function(data, type, row) {
                    var volumen_total_m3 = "";
                    if (row.volumen_total_m3 != null) volumen_total_m3 = row.volumen_total_m3;
                    return formato_miles(volumen_total_m3);
                },
                "bSortable": false,
                "aTargets": [3],
                "className": "text-right",
            },
            {
                "mRender": function(data, type, row) {
                    var volumen_total_pies = "";
                    if (row.volumen_total_pies != null) volumen_total_pies = row.volumen_total_pies;
                    return formato_miles(volumen_total_pies);
                },
                "bSortable": false,
                "aTargets": [4],
                "className": "text-right",
            },
            {
                "mRender": function(data, type, row) {
                    var precio_total = "";
                    if (row.precio_total != null) precio_total = row.precio_total;
                    return formato_miles(precio_total);
                },
                "bSortable": false,
                "aTargets": [5],
                "className": "text-right",
            },
            {
                "mRender": function(data, type, row) {
                    var promedio = "";
                    if (row.promedio != null) promedio = row.promedio;
                    return formato_miles(promedio);
                },
                "bSortable": false,
                "aTargets": [6],
                "className": "text-right",
            },
            {
                "mRender": function(data, type, row) {
                    var precio_total = "";
                    if (row.precio_total != null) precio_total = row.precio_total;
                    return formato_miles(precio_total);
                },
                "bSortable": false,
                "aTargets": [7],
                "className": "text-right",
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
}

    function datatablenew2() {
        var oTable = $('#tblReportePagos').dataTable({
            "bServerSide": true,
            "sAjaxSource": "/ingreso_vehiculo_tronco/listar_ingreso_vehiculo_tronco_reporte_pago_ajax",
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
                let totalSaldo = 0;
                let totalEfectivo = 0;
                let totalCheque = 0;
                let totalTransferencia = 0;

                settings.aoData.forEach(function(row) {
                    let saldos = row._aData.total_general;
                    let total_efec = row._aData.total_efectivo;
                    let total_cheq = row._aData.total_cheque;
                    let total_trans = row._aData.total_transferencia;
                    //let tipoPago = row._aData.tipo_pago;
                    if (saldos) {
                        totalSaldo = parseFloat(saldos);
                    }
                    if (total_efec) {
                        totalEfectivo = parseFloat(total_efec);
                    }
                    if (total_cheq) {
                        totalCheque = parseFloat(total_cheq);
                    }
                    if (total_trans) {
                        totalTransferencia = parseFloat(total_trans);
                    }
                });

                $('#tblReportePagos tfoot').html('');
    
                $('#tblReportePagos tfoot').append(`
                    <tr>
                        <td style="font-size:13px" colspan="1"><b>Total</b></td>
                        <td style="font-size:13px"><b>${formato_miles(totalSaldo)}</b></td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td style="font-size:13px" colspan="1"><b>Resumen</b></td>
                        <td></td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td style="font-size:13px" colspan="1">Efectivo</td>
                        <td style="font-size:13px">${formato_miles(totalEfectivo)}</td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td style="font-size:13px" colspan="1">Cheque</td>
                        <td style="font-size:13px">${formato_miles(totalCheque)}</td>
                        <td colspan="2"></td>
                    </tr>
                     <tr>
                        <td style="font-size:13px" colspan="1">Transferencia</td>
                        <td style="font-size:13px">${formato_miles(totalTransferencia)}</td>
                        <td colspan="2"></td>
                    </tr>
                `);
                $('[data-toggle="tooltip"]').tooltip();
                $('#tfoot tbody tr').removeClass('fila-par');
    		    $('#tfoot tbody tr:even').addClass('fila-par');
            },
    
            "fnServerData": function(sSource, aoData, fnCallback, oSettings) {


    
                var sEcho = aoData[0].value;
                var iNroPagina = parseFloat(fn_util_obtieneNroPagina(aoData[3].value, aoData[4].value)).toFixed();
                var iCantMostrar = aoData[4].value;
    
                /*var ruc = $('#ruc_bus').val();
                var empresa = $('#empresa_bus').val();
                var placa = $('#placa_bus').val();
                var tipo_madera = $('#tipo_madera_bus').val();*/
                var fecha_inicio = $('#fecha_inicio_bus').val();
                var fecha_fin = $('#fecha_fin_bus').val();
    
                var _token = $('#_token').val();
                oSettings.jqXHR = $.ajax({
                    "dataType": 'json',
                    "type": "POST",
                    "url": sSource,
                    "data": {
                        NumeroPagina: iNroPagina,
                        NumeroRegistros: iCantMostrar,
                        fecha_inicio:fecha_inicio,
                        fecha_fin:fecha_fin,
                        _token: _token
                    },
                    "success": function(result) {    
    
                        fnCallback(result);
    
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
    
                /*{
                    "mRender": function(data, type, row, meta) {
                        return meta.row+1;
                    },
                    "bSortable": false,
                    "aTargets": [0]
                },
    
                {
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
                        var razon_social = "";
                        if (row.razon_social != null) razon_social = row.razon_social;
                        return razon_social;
                    },
                    "bSortable": false,
                    "aTargets": [0],
                },
                {
                    "mRender": function(data, type, row) {
                        var importe_total = "";
                        if (row.importe_total != null) importe_total = row.importe_total;
                        return formato_miles(importe_total);
                    },
                    "bSortable": false,
                    "aTargets": [1],
                },
                {
                    "mRender": function(data, type, row) {
                        var tipo_pago = "";
                        if (row.tipo_pago != null) tipo_pago = row.tipo_pago;
                        return tipo_pago;
                    },
                    "bSortable": false,
                    "aTargets": [2]
                },
                {
                    "mRender": function(data, type, row) {
                        var fecha_pago = "";
                        if (row.fecha_pago != null) fecha_pago = row.fecha_pago;
                        return fecha_pago;
                    },
                    "bSortable": false,
                    "aTargets": [3]
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
    


    fn_util_LineaDatatable("#tblSolicitud");

    
    $('#tblSolicitud tbody').on('click', 'tr', function () {
        var anSelected = fn_util_ObtenerNumeroFila(oTable);
        if (anSelected.length != 0) {
			var odtable = $("#tblSolicitud").DataTable();
			var idSolicitud = odtable.row(this).data().id_ingreso_vehiculo_tronco_tipo_maderas;
            $("#id_ingreso_vehiculo_tronco_tipo_maderas").val(idSolicitud);
            //alert(idSolicitud);
			var id_estado = odtable.row(this).data().id_estado;
			$('#estado').val(id_estado);
						
            cargarPagoCubicaje(idSolicitud);

		}
    });
}

function fn_ListarBusqueda() {
    datatablenew();
    datatablenew2();
};

function fn_AbrirDetalle(pValor, piIdMovimientoCompra) {
    //fn_util_bloquearPantalla("Buscando");
    setTimeout(function() { fn_CargaSuGrilla(pValor, piIdMovimientoCompra) }, 500);
}

function fn_CargaSuGrilla(pValor, piIdMovimientoCompra) {

    var iRow = pValor;


    var tr = $("#ima_1_" + iRow).closest('tr');
    var row = $("#tblSolicitud").DataTable().row(tr);

    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');


        $("#ima_1_" + iRow).attr("src", "/img/details_open.png");
    } else {
        $("#ima_1_" + iRow).attr("src", "/img/details_close.png");

        var iNumeroLinea = $("#lbl_0_" + pValor).text();
        var iCodigoOficina = $("#lbl_1_" + pValor).text();

        var vNombreSubGrilla = "SubGrd" + iRow;
        fn_DevuelveSubGrilla(piIdMovimientoCompra, vNombreSubGrilla, row, tr);

    }
}


function DescargarArchivosPagos(){
		
	var ruc = $('#ruc_bus').val();
	var empresa = $('#empresa_bus').val();
	var placa = $('#placa_bus').val();
	var tipo_madera = $('#tipo_madera_bus').val();
	var fecha_inicio = $('#fecha_inicio_bus').val();
	var fecha_fin = $('#fecha_fin_bus').val();
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
	//if (campo == "")campo = 0;
	//if (orden == "")orden = 0;
	
	
	location.href = '/ingreso_vehiculo_tronco/exportar_listar_pagos/'+ruc+'/'+empresa+'/'+placa+'/'+tipo_madera+'/'+fecha_inicio+'/'+fecha_fin;
}

function convertirFecha(fecha){

    var partes = fecha.split('/');

    if(partes.length == 3){
        return partes[2] + '-' + partes[1] + '-' + partes[0] 
    }

    return fecha;

}

function DescargarReporteCubicaje(){

    var fecha_inicio = $('#fecha_inicio_bus').val();
	var fecha_fin = $('#fecha_fin_bus').val();

	if (fecha_inicio == "")fecha_inicio = "0";
    else fecha_inicio = fecha_inicio.replace(/\//g, "-");

	if (fecha_fin == "")fecha_fin = "0";
    else fecha_fin = fecha_fin.replace(/\//g, "-");

	
	location.href = '/ingreso_vehiculo_tronco/exportar_reporte_cubicaje/'+fecha_inicio+'/'+fecha_fin;

}

function DescargarReportePagos(){

    var fecha_inicio = $('#fecha_inicio_bus').val();
	var fecha_fin = $('#fecha_fin_bus').val();

	if (fecha_inicio == "")fecha_inicio = "0";
    else fecha_inicio = fecha_inicio.replace(/\//g, "-");

	if (fecha_fin == "")fecha_fin = "0";
    else fecha_fin = fecha_fin.replace(/\//g, "-");

	
	location.href = '/ingreso_vehiculo_tronco/exportar_reporte_pago/'+fecha_inicio+'/'+fecha_fin;

}

