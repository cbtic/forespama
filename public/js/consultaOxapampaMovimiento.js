$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
		
	$('#btnNuevo').click(function () {
		modalMarca(0);
	});

	$('#denominacion_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#estado_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});
		
	datatablenew();

});

function datatablenew(){
                      
    var oTable1 = $('#tblMovimientosOxapampa').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/consulta_oxapampa_movimiento/listar_oxapampa_movimiento_ajax",
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
        "lengthMenu": [[20, 50, 100, 200, 60000], [20, 50, 100, 200, "Todos"]],
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
			var estado = $('#estado_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						almacen:almacen,producto:producto,fecha_inicio:fecha_inicio,fecha_fin:fecha_fin,estado:estado,
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
					var entradas = "";
					if(row.entradas!= null)entradas = row.entradas;
					return entradas;
				},
				"bSortable": true,
				"aTargets": [3]
				},

				{
				"mRender": function (data, type, row) {
					var costo_entradas = "";
					if(row.costo_entradas!= null)costo_entradas = row.costo_entradas;
					return costo_entradas;
				},
				"bSortable": true,
				"aTargets": [4]
				},

				{
				"mRender": function (data, type, row) {
					var total_entradas = "";
					if(row.total_entradas!= null)total_entradas = row.total_entradas;
					return total_entradas;
				},
				"bSortable": true,
				"aTargets": [5]
				},

				{
				"mRender": function (data, type, row) {
					var salidas = "";
					if(row.salidas!= null)salidas = row.salidas;
					return salidas;
				},
				"bSortable": true,
				"aTargets": [6]
				},

				{
				"mRender": function (data, type, row) {
					var costo_salidas = "";
					if(row.costo_salidas!= null)costo_salidas = row.costo_salidas;
					return costo_salidas;
				},
				"bSortable": true,
				"aTargets": [7]
				},

				{
				"mRender": function (data, type, row) {
					var total_salidas = "";
					if(row.total_salidas!= null)total_salidas = row.total_salidas;
					return total_salidas;
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
					var usuario = "";
					if(row.usuario!= null)usuario = row.usuario;
					return usuario;
				},
				"bSortable": true,
				"aTargets": [15]
				},

				{
				"mRender": function (data, type, row) {
					var fecha_creacion = "";
					if(row.fecha_creacion!= null)fecha_creacion = row.fecha_creacion;
					return fecha_creacion;
				},
				"bSortable": true,
				"aTargets": [16]
				},
            ]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};

function modalMarca(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
		url: "/marcas/modal_marca/"+id,
		type: "GET",
		success: function (result) {  
			$("#diveditpregOpc").html(result);
			$('#openOverlayOpc').modal('show');
		}
	});
}

function eliminarMarca(id,estado){
	var act_estado = "";
	if(estado==1){
		act_estado = "Eliminar";
		estado_=0;
	}
	if(estado==0){
		act_estado = "Activar";
		estado_=1;
	}
    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Deseas "+act_estado+" la Marca?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar(id,estado){
	
    $.ajax({
		url: "/marcas/eliminar_marca/"+id+"/"+estado,
		type: "GET",
		success: function (result) {
			//if(result="success")obtenerPlanDetalle(id_plan);
			datatablenew();
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
