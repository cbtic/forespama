$(document).ready(function () {

	//activarBotonExcel();
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
	
	$('#denominacion').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
	});

	$("#producto_bus").select2({ width: '100%' });

	$("#consulta_tipo_producto_bus").select2({ width: '100%' });

	$("#consulta_existencia_producto_bus").select2({ width: '100%' });
		
	datatablenew();

	datatablenew_consulta_producto();

	$('#btnBuscarConsulta').click(function () {
		var consulta_producto =$('#consulta_producto_bus').val();
		//alert(consulta_producto);
		if(consulta_producto==""){
			fn_ListarBusqueda_Consulta();
		}
		if(consulta_producto!=""){
			fn_ListarBusqueda_Consulta_Producto();
		}
		
	});

	$('#consulta_producto_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew_existencia();
		}
	});
		
	$('#consulta_almacen_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew_existencia();
		}
	});
	
	$("#consulta_producto_bus").select2({ width: '100%' });

	$('#btnDescargar').on('click', function () {
		DescargarArchivosExcel()

	});

	$('#btnDescargarConsultaProductos').on('click', function () {
		DescargarConsultaProductoArchivosExcel()

	});

	$('#btnBuscarConsultaProducto').click(function () {
		fn_ListarBusqueda_Existencia_Producto();
	});

	$('#btnDescargarKardex').on('click', function () {
		DescargarKardexExcel()

	});

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

	activarBotonExcel();

});

function datatablenew(){
                      
    var oTable1 = $('#tblKardex').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/kardex/listar_kardex_ajax",
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
			
            var producto = $('#producto_bus').val();
			var almacen = $('#almacen_bus').val();
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
					var entrada = "";
					if(row.entrada!= null)entrada = row.entrada;
					return entrada;
				},
				"bSortable": true,
				"aTargets": [3]
				},
				
                {
                "mRender": function (data, type, row) {
                	var costo_entrada = "";
					if(row.costo_entrada!= null)costo_entrada = row.costo_entrada;
					return costo_entrada;
                },
                "bSortable": true,
                "aTargets": [4]
                },

				{
				"mRender": function (data, type, row) {
					var total_entrada = "";
					if(row.total_entrada!= null)total_entrada = row.total_entrada;
					return total_entrada;
				},
				"bSortable": true,
				"aTargets": [5]
				},
				{
				"mRender": function (data, type, row) {
					var salida = "";
					if(row.salida!= null)salida = row.salida;
					return salida;
				},
				"bSortable": true,
				"aTargets": [6]
				},
				{
				"mRender": function (data, type, row) {
					var costo_salida = "";
					if(row.costo_salida!= null)costo_salida = row.costo_salida;
					return costo_salida;
				},
				"bSortable": true,
				"aTargets": [7]
				},
				{
				"mRender": function (data, type, row) {
					var total_salida = "";
					if(row.total_salida!= null)total_salida = row.total_salida;
					return total_salida;
				},
				"bSortable": true,
				"aTargets": [8]
				},
				{
				"mRender": function (data, type, row) {
					var saldos = "";
					if(row.saldos!= null)saldos = row.saldos;
					return saldos;
				},
				"bSortable": true,
				"aTargets": [9]
				},
				{
				"mRender": function (data, type, row) {
					var costo_saldos = "";
					if(row.costo_saldos!= null)costo_saldos = row.costo_saldos;
					return costo_saldos;
				},
				"bSortable": true,
				"aTargets": [10]
				},
				{
				"mRender": function (data, type, row) {
					var total_saldos = "";
					if(row.total_saldos!= null)total_saldos = row.total_saldos;
					return total_saldos;
				},
				"bSortable": true,
				"aTargets": [11]
				},
				{
				"mRender": function (data, type, row) {
					var almacen_destino = "";
					if(row.almacen_destino!= null)almacen_destino = row.almacen_destino;
					return almacen_destino;
				},
				"bSortable": true,
				"aTargets": [12]
				},
				{
				"mRender": function (data, type, row) {
					var fecha_kardex = "";
					if(row.fecha_kardex!= null)fecha_kardex = row.fecha_kardex;
					return fecha_kardex;
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
					var codigo_movimiento = "";
					if(row.codigo_movimiento!= null)codigo_movimiento = row.codigo_movimiento;
					return codigo_movimiento;
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

function datatablenew_existencia(){
    
    var oTable1 = $('#tblKardexConsulta').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/kardex/listar_kardex_existencia_ajax",
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
			$('#tblKardexConsulta tbody tr').removeClass('fila-par');
    		$('#tblKardexConsulta tbody tr:even').addClass('fila-par');
        },

        "fnServerData": function (sSource, aoData, fnCallback, oSettings) {

            var sEcho           = aoData[0].value;
            var iNroPagina 	= parseFloat(fn_util_obtieneNroPagina(aoData[3].value, aoData[4].value)).toFixed();
            var iCantMostrar 	= aoData[4].value;
			
            var producto_existencia = $('#consulta_producto_bus').val();
			var almacen_existencia = $('#consulta_almacen_bus').val();
			var cantidad_producto = $('#cantidad_producto_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,producto_existencia:producto_existencia,
						almacen_existencia:almacen_existencia,cantidad_producto:cantidad_producto,
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
                	var denominacion = "";
					if(row.denominacion!= null)denominacion = row.denominacion;
					return denominacion;
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
					var unidad_medida = "";
					if(row.unidad_medida!= null)unidad_medida = row.unidad_medida;
					return unidad_medida;
				},
				"bSortable": true,
				"aTargets": [4]
				},
				
                {
                "mRender": function (data, type, row) {
                	var almacen_kardex = "";
					if(row.almacen_kardex!= null)almacen_kardex = row.almacen_kardex;
					return almacen_kardex;
                },
                "bSortable": true,
                "aTargets": [5]
                },
            ]
    });
}

function datatablenew_existencia_producto(){
                      
    var oTable1 = $('#tblKardexConsulta').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/kardex/listar_kardex_existencia_producto_ajax",
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
			$('#tblKardexConsulta tbody tr').removeClass('fila-par');
    		$('#tblKardexConsulta tbody tr:even').addClass('fila-par');
			
        },

        "fnServerData": function (sSource, aoData, fnCallback, oSettings) {

            var sEcho           = aoData[0].value;
            var iNroPagina 	= parseFloat(fn_util_obtieneNroPagina(aoData[3].value, aoData[4].value)).toFixed();
            var iCantMostrar 	= aoData[4].value;
			
            var producto_existencia = $('#consulta_producto_bus').val();
			var almacen_existencia = $('#consulta_almacen_bus').val();
			var cantidad_producto = $('#cantidad_producto_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,producto_existencia:producto_existencia,
						almacen_existencia:almacen_existencia,cantidad_producto:cantidad_producto,
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
                	var denominacion = "";
					if(row.denominacion!= null)denominacion = row.denominacion;
					return denominacion;
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
					var unidad_medida = "";
					if(row.unidad_medida!= null)unidad_medida = row.unidad_medida;
					return unidad_medida;
				},
				"bSortable": true,
				"aTargets": [4]
				},

                {
                "mRender": function (data, type, row) {
                	var almacen_kardex = "";
					if(row.almacen_kardex!= null)almacen_kardex = row.almacen_kardex;
					return almacen_kardex;
                },
                "bSortable": true,
                "aTargets": [5]
                },
				
            ]
    });
}

function datatablenew_consulta_producto(){

	//var suma_saldos = 0; 

    var oTable1 = $('#tblKardexConsultaProductos').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/kardex/listar_kardex_consulta_producto_ajax",
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
        "fnDrawCallback": function(settings) {
			
			let totalSaldo = 0;

			settings.aoData.forEach(function(row) {
				let saldos = row._aData.total_saldos2;
				if (saldos) {
					totalSaldo = parseFloat(saldos);
				}
				/*if (cantidad_orden_compra) {
					totalCantidadOrdenCompra = parseFloat(cantidad_orden_compra);
				}*/
				/*if (saldo_final) {
					totalSaldoFinal = parseFloat(saldo_final);
				}*/
			});

			$('#tblKardexConsultaProductos tfoot tr').html('<td colspan="3"><b>Total</b></td><td><b>' + totalSaldo + '</b></td><td colspan="2"></td>');
			//$('#tblKardexConsultaProductos tfoot tr').html('<td colspan="5"><b>Total</b></td><td><b>' + totalCantidadOrdenCompra + '</b></td><td colspan="2"></td>');
			//$('#tblKardexConsultaProductos tfoot tr').html('<td colspan="7"><b>Total</b></td><td><b>' + totalSaldoFinal + '</b></td><td colspan="2"></td>');
			//console.log("Total Saldos:", totalSaldo);
            $('[data-toggle="tooltip"]').tooltip();
			$('#tblKardexConsultaProductos tbody tr').removeClass('fila-par');
    		$('#tblKardexConsultaProductos tbody tr:even').addClass('fila-par');
        },

        "fnServerData": function (sSource, aoData, fnCallback, oSettings) {

            var sEcho           = aoData[0].value;
            var iNroPagina 	= parseFloat(fn_util_obtieneNroPagina(aoData[3].value, aoData[4].value)).toFixed();
            var iCantMostrar 	= aoData[4].value;
			
            var consulta_existencia_producto = $('#consulta_existencia_producto_bus').val();
			var consulta_almacen_producto = $('#consulta_almacen_producto_bus').val();
			var cantidad_existencia_producto = $('#cantidad_existencia_producto_bus').val();
			var consulta_tipo_producto = $('#consulta_tipo_producto_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						consulta_existencia_producto:consulta_existencia_producto,
						consulta_almacen_producto:consulta_almacen_producto,
						cantidad_existencia_producto:cantidad_existencia_producto,
						consulta_tipo_producto:consulta_tipo_producto,
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
                	var denominacion = "";
					if(row.denominacion!= null)denominacion = row.denominacion;
					return denominacion;
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
					var unidad_medida = "";
					if(row.unidad_medida!= null)unidad_medida = row.unidad_medida;
					return unidad_medida;
				},
				"bSortable": true,
				"aTargets": [6]
				},

				{
				"mRender": function (data, type, row) {
					var tipo_producto = "";
					if(row.tipo_producto!= null)tipo_producto = row.tipo_producto;
					return tipo_producto;
				},
				"bSortable": true,
				"aTargets": [7]
				},

                {
                "mRender": function (data, type, row) {
                	var almacen_kardex = "";
					if(row.almacen_kardex!= null)almacen_kardex = row.almacen_kardex;
					return almacen_kardex;
                },
                "bSortable": true,
                "aTargets": [8]
                },
				
				{
					"mRender": function (data, type, row) {
						
						var html = '<td class="text-left" style="vertical-align:middle">\
									<button style="font-size:11px;" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalVerProducto('+row.id+')"><i class="fa fa-edit" style="font-size:9px!important"></i>Imagen Producto</button>';
						html += '</div>';
						return html;
					},
					"bSortable": true,
					"aTargets": [9]
				},
				
            ]
			
    });
}

function activarBotonExcel(){

    var consulta_producto = $('#consulta_producto_bus').val().trim();
	var consulta_almacen = $('#consulta_almacen_bus').val().trim();
	//alert(consulta_producto);
	if (consulta_producto == "" && consulta_almacen != "") {
        $('#btnDescargar').prop('disabled', false);
    } else {
        $('#btnDescargar').prop('disabled', true);
    }
}

$('#consulta_producto_bus, #consulta_almacen_bus').on('change', function() {
    activarBotonExcel();
});

function fn_ListarBusqueda() {
    datatablenew();
};

function fn_ListarBusqueda_Consulta() {
    datatablenew_existencia();
};

function fn_ListarBusqueda_Consulta_Producto() {
    datatablenew_existencia_producto();
};

function fn_ListarBusqueda_Existencia_Producto() {
    datatablenew_consulta_producto();
};

function DescargarArchivosExcel(){
	
	var consulta_almacen = $('#consulta_almacen_bus').val();
	var cantidad_producto = $('#cantidad_producto_bus').val();

	if (consulta_almacen == "")consulta_almacen = 0;
	if (cantidad_producto == "")cantidad_producto = 0;
	
	location.href = '/kardex/exportar_listar_existencia/'+consulta_almacen+'/'+cantidad_producto;
}

function DescargarConsultaProductoArchivosExcel(){
	
	var consulta_existencia_producto = $('#consulta_existencia_producto_bus').val();
	var consulta_almacen_producto = $('#consulta_almacen_producto_bus').val();
	var consulta_tipo_producto = $('#consulta_tipo_producto_bus').val();
	var cantidad_existencia_producto = $('#cantidad_existencia_producto_bus').val();

	if (consulta_existencia_producto == "")consulta_existencia_producto = 0;
	if (consulta_almacen_producto == "")consulta_almacen_producto = 0;
	if (consulta_tipo_producto == "")consulta_tipo_producto = 0;
	
	location.href = '/kardex/exportar_listar_existencia_consulta_producto/'+consulta_existencia_producto+'/'+consulta_almacen_producto+'/'+consulta_tipo_producto+'/'+cantidad_existencia_producto;
}

function obtenerProductosAlmacen(){

    var id_almacen = $('#consulta_almacen_bus').val();

    $.ajax({
		url: "/productos/obtener_producto_almacen/"+id_almacen,
		dataType: "json",
		success: function(result){
			
			$('#consulta_producto_bus').empty().append('<option value="">--Seleccionar Producto--</option>');
			
			if(result.length > 0) {
				$.each(result, function(ii, oo) {
					$('#consulta_producto_bus').append(
						$('<option>', {
							value: oo.id,
							text: oo.codigo+' - '+oo.denominacion
						})
					);
				});

				$('#consulta_producto_bus').select2();
			} else {
				bootbox.alert("No se encontraron productos en este almacén.");
			}
		}
	});
}

function obtenerProductosAlmacenKardex(){

    var id_almacen = $('#almacen_bus').val();

    $.ajax({
		url: "/productos/obtener_producto_almacen/"+id_almacen,
		dataType: "json",
		success: function(result){
			
			$('#producto_bus').empty().append('<option value="">--Seleccionar Producto--</option>');
			
			if(result.length > 0) {
				$.each(result, function(ii, oo) {
					$('#producto_bus').append(
						$('<option>', {
							value: oo.id,
							text: oo.codigo+' - '+oo.denominacion
						})
					);
				});

				$('#producto_bus').select2();
			} else {
				bootbox.alert("No se encontraron productos en este almacén.");
			}
		}
	});
}

function modalVerProducto(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/productos/modal_ver_productos/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function DescargarKardexExcel(){
	
	var almacen = $('#almacen_bus').val();
	var producto = $('#producto_bus').val();
	var fecha_inicio = $('#fecha_inicio_bus').val();
	var fecha_fin = $('#fecha_fin_bus').val();

	if (almacen == "")almacen = 0;
	if (producto == "")producto = 0;
	if (fecha_inicio == "")fecha_inicio = "0";
	if (fecha_fin == "")fecha_fin = "0";
	
	location.href = '/kardex/exportar_listar_consulta_kardex/'+almacen+'/'+producto+'/'+fecha_inicio+'/'+fecha_fin;
}