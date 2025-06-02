$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#empresa_compra_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#fecha_inicio_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#fecha_fin_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#numero_orden_compra_cliente_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#situacion_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#fecha_inicio_bus').datepicker({
        autoclose: true,
		format: 'dd-mm-yyyy',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

	$('#fecha_fin_bus').datepicker({
        autoclose: true,
		format: 'dd-mm-yyyy',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

	$('#empresa_compra_bus').select2({ width : '100%' })

	$('#producto_bus').select2({ width : '100%' })

	datatablenew();

	$('#btnDescargar').on('click', function () {
		DescargarArchivosExcel()

	});

});

function datatablenew(){
                      
    var oTable1 = $('#tblReporteComercializacion').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/orden_compra/listar_reporte_comercializacion_ajax",
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
			
			var empresa_compra = $('#empresa_compra_bus').val();
			var fecha_inicio = $('#fecha_inicio_bus').val();
			var fecha_fin = $('#fecha_fin_bus').val();
			var numero_orden_compra_cliente = $('#numero_orden_compra_cliente_bus').val();
			var situacion = $('#situacion_bus').val();
			var codigo_producto = $('#codigo_producto_bus').val();
			var producto = $('#producto_bus').val();
			var vendedor = $('#vendedor_bus').val();
			var estado_pedido = $('#estado_pedido_bus').val();

			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						empresa_compra:empresa_compra, fecha_inicio:fecha_inicio, fecha_fin:fecha_fin, numero_orden_compra_cliente:numero_orden_compra_cliente, 
						situacion:situacion,codigo_producto:codigo_producto,producto:producto,vendedor:vendedor,estado_pedido:estado_pedido,
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
		"fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
           
		},

        "aoColumnDefs":
            [			
                {
                "mRender": function (data, type, row) {
                	var cliente = "";
					if(row.cliente!= null)cliente = row.cliente;
					return cliente;
                },
                "bSortable": true,
                "aTargets": [0]
                },
				
				{
				"mRender": function (data, type, row) {
					var numero_orden_compra_cliente = "";
					if(row.numero_orden_compra_cliente!= null)numero_orden_compra_cliente = row.numero_orden_compra_cliente;
					return numero_orden_compra_cliente;
				},
				"bSortable": true,
				"aTargets": [1]
				},
				{
				"mRender": function (data, type, row) {
					var pedido = "";
					if(row.pedido!= null)pedido = row.pedido;
					return pedido;
				},
				"bSortable": true,
				"aTargets": [2]
				},
				{
				"mRender": function (data, type, row) {
					var fecha_orden_compra = "";
					if(row.fecha_orden_compra!= null)fecha_orden_compra = row.fecha_orden_compra;
					return fecha_orden_compra;
				},
				"bSortable": true,
				"aTargets": [3]
				},
				{
				"mRender": function (data, type, row) {
					var fecha_vencimiento = "";
					if(row.fecha_vencimiento!= null)fecha_vencimiento = row.fecha_vencimiento;
					return fecha_vencimiento;
				},
				"bSortable": true,
				"aTargets": [4]
				},
				{
				"mRender": function (data, type, row) {
					var fecha_salida = "";
					if(row.fecha_salida!= null)fecha_salida = row.fecha_salida;
					return fecha_salida;
				},
				"bSortable": true,
				"aTargets": [5]
				},
				{
				"mRender": function (data, type, row) {
					var codigo = "";
					if(row.codigo!= null)codigo = row.codigo;
					return codigo;
				},
				"bSortable": true,
				"aTargets": [6]
				},
				{
				"mRender": function (data, type, row) {
					var codigo_empresa = "";
					if(row.codigo_empresa!= null)codigo_empresa = row.codigo_empresa;
					return codigo_empresa;
				},
				"bSortable": true,
				"aTargets": [7]
				},
				{
				"mRender": function (data, type, row) {
					var producto = "";
					if(row.producto!= null)producto = row.producto;
					return producto;
				},
				"bSortable": true,
				"aTargets": [8]
				},
				{
				"mRender": function (data, type, row) {
					var precio = "";
					if(row.precio!= null)precio = row.precio;
					return precio;
				},
				"bSortable": true,
				"aTargets": [9]
				},
				{
				"mRender": function (data, type, row) {
					var cantidad_requerida = "";
					if(row.cantidad_requerida!= null)cantidad_requerida = row.cantidad_requerida;
					return cantidad_requerida;
				},
				"bSortable": true,
				"aTargets": [10]
				},
				{
				"mRender": function (data, type, row) {
					var cantidad_despacho = "";
					if(row.cantidad_despacho!= null)cantidad_despacho = row.cantidad_despacho;
					return cantidad_despacho;
				},
				"bSortable": true,
				"aTargets": [11]
				},
				{
				"mRender": function (data, type, row) {
					var cantidad_cancelada = "";
					if(row.cantidad_cancelada!= null)cantidad_cancelada = row.cantidad_cancelada;
					return cantidad_cancelada;
				},
				"bSortable": true,
				"aTargets": [12]
				},
				{
				"mRender": function (data, type, row) {
					var cerrado = "";
						if(row.cerrado == 1){
							cerrado = "SI";
						}
						if(row.cerrado == 2){
							cerrado = "NO";
						}
						return cerrado;
				},
				"bSortable": true,
				"aTargets": [13]
				},
				{
				"mRender": function (data, type, row) {
					var vendedor = "";
					if(row.vendedor!= null)vendedor = row.vendedor;
					return vendedor;
				},
				"bSortable": true,
				"aTargets": [14]
				},
				{
				"mRender": function (data, type, row) {
					var estado_pedido = "";
					if(row.estado_pedido!= null)estado_pedido = row.estado_pedido;
					return estado_pedido;
				},
				"bSortable": true,
				"aTargets": [15]
				},
            ]

    });

}

fn_util_LineaDatatable("#tblReporteComercializacion");

$('#tblReporteComercializacion tbody').on('click', 'tr', function () {
	
});

function fn_ListarBusqueda() {
    datatablenew();
};

function DescargarArchivosExcel(){
	
	var empresa_compra = $('#empresa_compra_bus').val();
	var fecha_inicio = $('#fecha_inicio_bus').val();
	var fecha_fin = $('#fecha_fin_bus').val();
	var numero_orden_compra_cliente = $('#numero_orden_compra_cliente_bus').val();
	var situacion = $('#situacion_bus').val();
	var codigo_producto = $('#codigo_producto_bus').val();
	var producto = $('#producto_bus').val();
	var vendedor = $('#vendedor_bus').val();
	var estado_pedido = $('#estado_pedido_bus').val();

	if (empresa_compra == "")empresa_compra = 0;
	if (fecha_inicio == "")fecha_inicio = "0";
	if (fecha_fin == "")fecha_fin = "0";
	if (numero_orden_compra_cliente == "")numero_orden_compra_cliente = "0";
	if (situacion == "")situacion = 0;
	if (codigo_producto == "")codigo_producto = "0";
	if (producto == "")producto = 0;
	if (vendedor == "")vendedor = 0;
	if (estado_pedido == "")estado_pedido = 0;
	
	location.href = '/orden_compra/exportar_reporte_comercializacion/'+empresa_compra+'/'+fecha_inicio+'/'+fecha_fin+'/'+numero_orden_compra_cliente+'/'+situacion+'/'+codigo_producto+'/'+producto+'/'+vendedor+'/'+estado_pedido;
}