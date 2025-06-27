$(document).ready(function () {

	//activarBotonExcel();
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
	
	$('#consulta_oc_existencia_producto_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
	});

	$('#consulta_oc_almacen_producto_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
	});

	$('#consulta_oc_existencia_producto_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
	});

	$("#consulta_oc_existencia_producto_bus").select2({ width: '100%' });

	$("#consulta_oc_empresa_bus").select2({ width: '100%' });
		
	datatablenew();

	$('#btnBuscarConsultaProductoOC').click(function () {
		fn_ListarBusqueda();
	});

	$('#btnDescargar').on('click', function () {
		DescargarArchivosExcel()
	});

});

function datatablenew(){
                      
    var oTable1 = $('#tblKardexConsultaProductosOC').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/kardex/listar_kardex_consulta_producto_orden_compra_ajax",
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
			
            var consulta_oc_existencia_producto = $('#consulta_oc_existencia_producto_bus').val();
			var consulta_oc_almacen_producto = $('#consulta_oc_almacen_producto_bus').val();
			var consulta_oc_empresa = $('#consulta_oc_empresa_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						consulta_oc_existencia_producto:consulta_oc_existencia_producto,consulta_oc_almacen_producto:consulta_oc_almacen_producto,
						consulta_oc_empresa:consulta_oc_empresa,
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
					var codigo = "";
					if(row.codigo!= null)codigo = row.codigo;
					return codigo;
				},
				"bSortable": true,
				"aTargets": [1]
				},
				
				{
                "mRender": function (data, type, row) {
                	var producto = "";
					if(row.producto!= null)producto = row.producto;
					return producto;
                },
                "bSortable": true,
                "aTargets": [2]
                },

				{
				"mRender": function (data, type, row) {
					var saldos_cantidad = "";
					if(row.saldos_cantidad!= null)saldos_cantidad = row.saldos_cantidad;
					return saldos_cantidad;
				},
				"bSortable": true,
				"aTargets": [3]
				},
				
                {
                "mRender": function (data, type, row) {
                	var cantidad_orden_compra = "";
					if(row.cantidad_orden_compra!= null)cantidad_orden_compra = row.cantidad_orden_compra;
					return cantidad_orden_compra;
                },
                "bSortable": true,
                "aTargets": [4]
                },

				{
				"mRender": function (data, type, row) {
					var saldo_final = "";
					if(row.saldo_final!= null)saldo_final = row.saldo_final;
					return saldo_final;
				},
				"bSortable": true,
				"aTargets": [5]
				},
				{
				"mRender": function (data, type, row) {
					var almacen_kardex = "";
					if(row.almacen_kardex!= null)almacen_kardex = row.almacen_kardex;
					return almacen_kardex;
				},
				"bSortable": true,
				"aTargets": [6]
				},
            ]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};

function DescargarArchivosExcel(){
	
	var consulta_almacen = $('#consulta_almacen_bus').val();
	if (consulta_almacen == "")consulta_almacen = 0;
	
	location.href = '/kardex/exportar_listar_existencia/'+consulta_almacen;
}
