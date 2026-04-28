$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
	
	$('#almacen_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
	});

	$('#producto_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
	});

	$('#fecha_inicio_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
	});

	$('#fecha_fin_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
	});

	$("#producto_bus").select2({ width: '100%' });
	
	datatablenew();
	
	/*$('#btnDescargar').on('click', function () {
		DescargarArchivosExcel()

	});*/

	$('#fecha_inicio_bus').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

	$('#fecha_fin_bus').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

});

function datatablenew(){
                      
    var oTable1 = $('#tblKardexSecundario').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/kardex_secundarios/listar_kardex_secundario_ajax",
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
			
			var almacen = $('#almacen_bus').val();
            var producto = $('#producto_bus').val();
			var fecha_inicio = $('#fecha_inicio_bus').val();
			var fecha_fin = $('#fecha_fin_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						producto:producto,almacen:almacen,fecha_inicio:fecha_inicio,fecha_fin:fecha_fin,
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
					var entradas_cantidad = "";
					if(row.entradas_cantidad!= null)entradas_cantidad = row.entradas_cantidad;
					return entradas_cantidad;
				},
				"bSortable": true,
				"aTargets": [3]
				},
				
                {
                "mRender": function (data, type, row) {
                	var costo_entradas_cantidad = "";
					if(row.costo_entradas_cantidad!= null)costo_entradas_cantidad = row.costo_entradas_cantidad;
					return costo_entradas_cantidad;
                },
                "bSortable": true,
                "aTargets": [4]
                },

				{
				"mRender": function (data, type, row) {
					var total_entradas_cantidad = "";
					if(row.total_entradas_cantidad!= null)total_entradas_cantidad = row.total_entradas_cantidad;
					return total_entradas_cantidad;
				},
				"bSortable": true,
				"aTargets": [5]
				},
				{
				"mRender": function (data, type, row) {
					var salidas_cantidad = "";
					if(row.salidas_cantidad!= null)salidas_cantidad = row.salidas_cantidad;
					return salidas_cantidad;
				},
				"bSortable": true,
				"aTargets": [6]
				},
				{
				"mRender": function (data, type, row) {
					var costo_salidas_cantidad = "";
					if(row.costo_salidas_cantidad!= null)costo_salidas_cantidad = row.costo_salidas_cantidad;
					return costo_salidas_cantidad;
				},
				"bSortable": true,
				"aTargets": [7]
				},
				{
				"mRender": function (data, type, row) {
					var total_salidas_cantidad = "";
					if(row.total_salidas_cantidad!= null)total_salidas_cantidad = row.total_salidas_cantidad;
					return total_salidas_cantidad;
				},
				"bSortable": true,
				"aTargets": [8]
				},
				{
				"mRender": function (data, type, row) {
					var saldos_cantidad = "";
					if(row.saldos_cantidad!= null)saldos_cantidad = row.saldos_cantidad;
					return saldos_cantidad;
				},
				"bSortable": true,
				"aTargets": [9]
				},
				{
				"mRender": function (data, type, row) {
					var costo_saldos_cantidad = "";
					if(row.costo_saldos_cantidad!= null)costo_saldos_cantidad = row.costo_saldos_cantidad;
					return costo_saldos_cantidad;
				},
				"bSortable": true,
				"aTargets": [10]
				},
				{
				"mRender": function (data, type, row) {
					var total_saldos_cantidad = "";
					if(row.total_saldos_cantidad!= null)total_saldos_cantidad = row.total_saldos_cantidad;
					return total_saldos_cantidad;
				},
				"bSortable": true,
				"aTargets": [11]
				},
				{
				"mRender": function (data, type, row) {
					var almacen = "";
					if(row.almacen!= null)almacen = row.almacen;
					return almacen;
				},
				"bSortable": true,
				"aTargets": [12]
				},
				{
				"mRender": function (data, type, row) {
					var fecha = "";
					if(row.fecha!= null)fecha = row.fecha;
					return fecha;
				},
				"bSortable": true,
				"aTargets": [13]
				},
				{
				"mRender": function (data, type, row) {
					var tipo_movimiento = "";
					if(row.tipo_movimiento!= null)tipo_movimiento = row.tipo_movimiento;
					return tipo_movimiento;
				},
				"bSortable": true,
				"aTargets": [14]
				},
				{
				"mRender": function (data, type, row) {
					var numero_ingreso_salida = "";
					if(row.numero_ingreso_salida!= null)numero_ingreso_salida = row.numero_ingreso_salida;
					return numero_ingreso_salida;
				},
				"bSortable": true,
				"aTargets": [15]
				},
				/*{
				"mRender": function (data, type, row) {
					var almacen_salida = "";
					if(row.almacen_salida!= null)almacen_salida = row.almacen_salida;
					return almacen_salida;
				},
				"bSortable": true,
				"aTargets": [13]
				},*/
            ]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};

/*function DescargarArchivosExcel(){
	
	var consulta_almacen = $('#consulta_almacen_bus').val();
	var cantidad_producto = $('#cantidad_producto_bus').val();
	var fecha = $('#fecha_bus').val();

	if (consulta_almacen == "")consulta_almacen = 0;
	if (cantidad_producto == "")cantidad_producto = 0;
	if (fecha == "")fecha = "0";
	
	location.href = '/kardex/exportar_listar_existencia/'+consulta_almacen+'/'+cantidad_producto+'/'+fecha;
}*/

