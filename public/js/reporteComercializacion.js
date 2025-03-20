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

	$('#fecha_bus').keypress(function(e){
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

	$('#fecha_bus').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

	$('#empresa_compra_bus').select2({ width : '100%' })

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
			var fecha = $('#fecha_bus').val();
			var numero_orden_compra_cliente = $('#numero_orden_compra_cliente_bus').val();
			var situacion = $('#situacion_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						empresa_compra:empresa_compra, fecha:fecha, numero_orden_compra_cliente:numero_orden_compra_cliente, situacion:situacion,
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
                	var razon_social = "";
					if(row.razon_social!= null)razon_social = row.razon_social;
					return razon_social;
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
					var tienda = "";
					if(row.tienda!= null)tienda = row.tienda;
					return tienda;
				},
				"bSortable": true,
				"aTargets": [2]
				},
				{
				"mRender": function (data, type, row) {
					var pedido = "";
					if(row.pedido!= null)pedido = row.pedido;
					return pedido;
				},
				"bSortable": true,
				"aTargets": [3]
				},
				{
				"mRender": function (data, type, row) {
					var fecha_orden_compra = "";
					if(row.fecha_orden_compra!= null)fecha_orden_compra = row.fecha_orden_compra;
					return fecha_orden_compra;
				},
				"bSortable": true,
				"aTargets": [4]
				},
				{
				"mRender": function (data, type, row) {
					var fecha_vencimiento = "";
					if(row.fecha_vencimiento!= null)fecha_vencimiento = row.fecha_vencimiento;
					return fecha_vencimiento;
				},
				"bSortable": true,
				"aTargets": [5]
				},
				{
				"mRender": function (data, type, row) {
					var comentarios = "";
					if(row.comentarios!= null)comentarios = row.comentarios;
					return comentarios;
				},
				"bSortable": true,
				"aTargets": [6]
				},
				{
				"mRender": function (data, type, row) {
					var codigo = "";
					if(row.codigo!= null)codigo = row.codigo;
					return codigo;
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
					var pendiente_entrega = "";
					if(row.pendiente_entrega!= null)pendiente_entrega = row.pendiente_entrega;
					return pendiente_entrega;
				},
				"bSortable": true,
				"aTargets": [13]
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
	var fecha = $('#fecha_bus').val();
	var numero_orden_compra_cliente = $('#numero_orden_compra_cliente_bus').val();
	var situacion = $('#situacion_bus').val();

	if (empresa_compra == "")empresa_compra = 0;
	if (fecha == "")fecha = "0";
	if (numero_orden_compra_cliente == "")numero_orden_compra_cliente = "0";
	if (situacion == "")situacion = 0;
	
	location.href = '/orden_compra/exportar_reporte_comercializacion/'+empresa_compra+'/'+fecha+'/'+numero_orden_compra_cliente+'/'+situacion;
}