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
                      
    var oTable1 = $('#tblReporteComercializacionGeneral').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/orden_compra/listar_reporte_comercializacion_general_ajax",
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
			
			var canal = $('#canal_bus').val();
			var empresa_compra = $('#empresa_compra_bus').val();
			var fecha_inicio = $('#fecha_inicio_bus').val();
			var fecha_fin = $('#fecha_fin_bus').val();
			var vendedor = $('#vendedor_bus').val();

			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						empresa_compra:empresa_compra, fecha_inicio:fecha_inicio, fecha_fin:fecha_fin, 
						vendedor:vendedor,canal:canal,
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
					var canal = "";
					if(row.canal!= null)canal = row.canal;
					return canal;
				},
				"bSortable": true,
				"aTargets": [1]
				},
				{
				"mRender": function (data, type, row) {
					var vendedor = "";
					if(row.vendedor!= null)vendedor = row.vendedor;
					return vendedor;
				},
				"bSortable": true,
				"aTargets": [2]
				},
				{
				"mRender": function (data, type, row) {
					var total_despacho = "";
					if(row.total_despacho!= null)total_despacho = row.total_despacho;
					return total_despacho;
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
					var pedido = "";
					if(row.pedido!= null)pedido = row.pedido;
					return pedido;
				},
				"bSortable": true,
				"aTargets": [5]
				},
            ]
    });
}

fn_util_LineaDatatable("#tblReporteComercializacionGeneral");

$('#tblReporteComercializacionGeneral tbody').on('click', 'tr', function () {
	
});

function fn_ListarBusqueda() {
    datatablenew();
};

function DescargarArchivosExcel(){
	
	var empresa_compra = $('#empresa_compra_bus').val();
	var fecha_inicio = $('#fecha_inicio_bus').val();
	var fecha_fin = $('#fecha_fin_bus').val();
	var vendedor = $('#vendedor_bus').val();
	var canal = $('#canal_bus').val();

	if (empresa_compra == "")empresa_compra = 0;
	if (fecha_inicio == "")fecha_inicio = "0";
	if (fecha_fin == "")fecha_fin = "0";
	if (vendedor == "")vendedor = 0;
	if (canal == "")canal = 0;
	
	location.href = '/orden_compra/exportar_reporte_comercializacion_general/'+empresa_compra+'/'+fecha_inicio+'/'+fecha_fin+'/'+vendedor+'/'+canal;
}
