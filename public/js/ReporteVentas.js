//alert("ok");
//jQuery.noConflict(true);

$(document).ready(function () {

	$('#btnBuscar').click(function () {
		datatableVentasAnio();
        datatablePagosAnio();
        datatableRetencionAnio();
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

//var ventasChart;

/*function datatableVentasAnio(){
	
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

function datatableRetencionAnio(){
	
	var anio =  $('#anio_bus').val();
	var empresa =  $('#empresa_bus').val();
	
    $("#tblVentasCobros tbody").html("");
	$.ajax({
			url: "/comprobante/lista_retencion_anio/"+anio+"/"+empresa,
			type: "GET",
			success: function (result) {
					$("#tblVentasCobros tbody").html(result);
			}
	});
}
*/
var ventasChart = null;

function obtenerValoresDeTabla(idTabla) {
	let valores = [];
	$(`${idTabla} tbody tr`).first().find("td").each(function () {
		let val = parseFloat($(this).text().replace(/,/g, ''));
		valores.push(isNaN(val) ? 0 : val);
	});
	return valores;
}

function generarGraficoVentas() {
	const facturado = obtenerValoresDeTabla("#tblVentasFacturado");
	const pagado = obtenerValoresDeTabla("#tblVentasPagado");
	const retencion = obtenerValoresDeTabla("#tblVentasRetencion");
	const cobros = obtenerValoresDeTabla("#tblVentasCobros");

	const ctx = document.getElementById('ventasChart').getContext('2d');

	if (ventasChart) {
		ventasChart.destroy();
	}

	ventasChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Dic'],
			datasets: [
				{
					label: 'Facturado',
					data: facturado,
					borderColor: 'rgb(11, 41, 211)',
					backgroundColor: 'rgba(75, 192, 192, 0.2)',
					tension: 0.4
				},
				{
					label: 'Pagado',
					borderColor: 'rgb(14, 216, 7)',
					backgroundColor: 'rgba(86, 255, 86, 0.2)',
					data: pagado,
					tension: 0.4
				},
				{
					label: 'Retenciones',
					data: retencion,
					borderColor: 'rgb(237, 241, 0)',
					backgroundColor: 'rgba(224, 228, 8, 0.21)',
					tension: 0.4
				},
				{
					label: 'Cobros',
					data: cobros,
					borderColor: 'rgb(223, 5, 5)',
					backgroundColor: 'rgba(216, 41, 41, 0.36)',
					tension: 0.4
				}
			]
		},
		options: {
			responsive: true,
			plugins: {
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: 'Reporte Anual de Ventas'
				}
			},
			scales: {
				y: {
					beginAtZero: true
				}
			}
		}
	});
}

function cargarDatosYGraficar() {
	const anio = $('#anio_bus').val();
	const empresa = $('#empresa_bus').val();

	const promesas = [
		$.ajax({
			url: "/comprobante/lista_ventas_anio/" + anio + "/" + empresa,
			type: "GET",
			success: function (result) {
				$("#tblVentasFacturado tbody").html(result);
			}
		}),
		$.ajax({
			url: "/comprobante/lista_pagos_anio/" + anio + "/" + empresa,
			type: "GET",
			success: function (result) {
				$("#tblVentasPagado tbody").html(result);
			}
		}),
		$.ajax({
			url: "/comprobante/lista_retencion_anio/" + anio + "/" + empresa,
			type: "GET",
			success: function (result) {
				$("#tblVentasRetencion tbody").html(result);
			}
		}),
		$.ajax({
			url: "/comprobante/lista_cobros_anio/" + anio + "/" + empresa,
			type: "GET",
			success: function (result) {
				$("#tblVentasCobros tbody").html(result);
			}
		})
	];

	$.when(...promesas).done(function () {
		generarGraficoVentas();

		const totalFacturado = obtenerValoresDeTabla("#tblVentasFacturado")
			.reduce((a, b) => a + b, 0);
		const totalPagado = obtenerValoresDeTabla("#tblVentasPagado")
			.reduce((a, b) => a + b, 0);
		const totalRetencion = obtenerValoresDeTabla("#tblVentasRetencion")
			.reduce((a, b) => a + b, 0);
		const totalCobros = obtenerValoresDeTabla("#tblVentasCobros")
			.reduce((a, b) => a + b, 0);

		generarGraficoPastelVentas(totalFacturado, totalPagado, totalRetencion, totalCobros);

	});
}

$('#anio_bus, #empresa_bus').on('change', function () {
	cargarDatosYGraficar();
});

$(document).ready(function () {
	cargarDatosYGraficar();
});

function obtenerTotalDeTabla(idTabla) {
	let total = 0;
	$(`${idTabla} tbody tr`).first().find("td").each(function () {
		let val = parseFloat($(this).text().replace(/,/g, ''));
		total += isNaN(val) ? 0 : val;
	});
	return total;
}

/*let ventasPieChart = null;

function generarGraficoPieVentas() {
	const totalFacturado = obtenerTotalDeTabla("#tblVentasFacturado");
	const totalPagado = obtenerTotalDeTabla("#tblVentasPagado");
	const totalRetencion = obtenerTotalDeTabla("#tblVentasRetencion");
	const totalCobros = obtenerTotalDeTabla("#tblVentasCobros");

	const ctx = document.getElementById('ventasPieChart').getContext('2d');

	if (ventasPieChart) {
		ventasPieChart.destroy();
	}

	ventasPieChart = new Chart(ctx, {
		type: 'pie',
		data: {
			labels: ['Facturado', 'Pagado', 'Retencion', 'Cobros'],
			datasets: [{
				data: [totalFacturado, totalPagado, totalRetencion, totalCobros],
				backgroundColor: [
					'rgba(75, 93, 192, 0.48)',
					'rgba(86, 255, 86, 0.6)',
					'rgba(224, 228, 8, 0.6)',
					'rgba(216, 41, 41, 0.6)'
				],
				borderColor: [
					'rgba(11, 41, 211, 1)',
					'rgba(14, 216, 7, 1)',
					'rgba(237, 241, 0, 1)',
					'rgba(223, 5, 5, 1)'
				],
				borderWidth: 1
			}]
		},
		options: {
			plugins: {
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: 'Reporte Anual de Ventas'
				}
			}
		}
	});
}*/

function generarGraficoPastelVentas(facturado, pagado, retencion, cobros) {
    Highcharts.chart('ventasPieChart', {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'Reporte Anual de Ventas'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y:,.2f})'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 45,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'Porcentaje',
            data: [
                ['Facturado', facturado],
                ['Pagado', pagado],
                ['Retencion', retencion],
                ['Cobros', cobros]
            ]
        }]
    });
}