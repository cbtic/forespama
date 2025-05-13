$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#btnNuevo').click(function () {
		modalOrdenCompra(0);
	});

	$('#tipo_documento_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#empresa_compra_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#empresa_vende_bus').keypress(function(e){
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

	$('#numero_orden_compra_bus').keypress(function(e){
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

	$('#estado_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
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

	$('#empresa_compra_bus').select2({ width : '100%' })

	$('#empresa_vende_bus').select2({ width : '100%' })
	
	datatablenew();

	$('#btnDescargar').on('click', function () {
		DescargarArchivosExcel()

	});

});

function datatablenew(){
                      
    var oTable1 = $('#tblOrdenCompra').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/orden_compra/listar_orden_compra_ajax",
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
        "lengthMenu": [[50, 100, 200, 60000], [50, 100, 200, "Todos"]],
        "aoColumns": [
                        {},
        ],
		"dom": '<"top">rt<"bottom"flpi><"clear">',
        "fnDrawCallback": function(settings) {

			let totalImporte = 0;

			settings.aoData.forEach(function(row) {
				let importe = row._aData.total;
				if (importe) {
					totalImporte += parseFloat(importe);
				}
			});

			$('#tblOrdenCompra tfoot tr').html('<td colspan="13"><b>Total</b></td><td><b>' + totalImporte.toFixed(2) + '</b></td><td colspan="2"></td>');

            //$('#tblOrdenCompra tfoot th.text-right').text(totalImporte.toFixed(2));

            $('[data-toggle="tooltip"]').tooltip();
        },

        "fnServerData": function (sSource, aoData, fnCallback, oSettings) {

            var sEcho           = aoData[0].value;
            var iNroPagina 	= parseFloat(fn_util_obtieneNroPagina(aoData[3].value, aoData[4].value)).toFixed();
            var iCantMostrar 	= aoData[4].value;
			
            var tipo_documento = $('#tipo_documento_bus').val();
			var empresa_compra = $('#empresa_compra_bus').val();
			var empresa_vende = $('#empresa_vende_bus').val();
			var fecha_inicio = $('#fecha_inicio_bus').val();
			var fecha_fin = $('#fecha_fin_bus').val();
			var numero_orden_compra = $('#numero_orden_compra_bus').val();
			var situacion = $('#situacion_bus').val();
			var almacen_origen = $('#almacen_origen_bus').val();
			var almacen_destino = $('#almacen_destino_bus').val();
			var estado = $('#estado_bus').val();
			var numero_orden_compra_cliente = $('#numero_orden_compra_cliente_bus').val();
			var vendedor = $('#vendedor_bus').val();
			var estado_pedido = $('#estado_pedido_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						tipo_documento:tipo_documento,empresa_compra:empresa_compra,empresa_vende:empresa_vende,
						fecha_inicio:fecha_inicio,fecha_fin:fecha_fin,numero_orden_compra:numero_orden_compra,almacen_origen:almacen_origen,
						almacen_destino:almacen_destino,situacion:situacion,estado:estado,numero_orden_compra_cliente:numero_orden_compra_cliente,
						vendedor:vendedor,estado_pedido:estado_pedido,
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
						var tipo_documento = "";
						if(row.tipo_documento!= null)tipo_documento = row.tipo_documento;
						return tipo_documento;
					},
					"bSortable": true,
					"aTargets": [1]
					},
				
				/*{
                "mRender": function (data, type, row) {
                	var ingreso = "";
					if(row.ingreso!= null)ingreso = row.ingreso;
					return ingreso;
                },
                "bSortable": true,
                "aTargets": [2]
                },*/
				
                {
                "mRender": function (data, type, row) {
                	var cliente = "";
					if(row.cliente!= null)cliente = row.cliente;
					return cliente;
                },
                "bSortable": true,
                "aTargets": [2]
                },
				
				{
				"mRender": function (data, type, row) {
					var numero_orden_compra_cliente = "";
					if(row.numero_orden_compra_cliente!= null)numero_orden_compra_cliente = row.numero_orden_compra_cliente;
					return numero_orden_compra_cliente;
				},
				"bSortable": true,
				"aTargets": [3]
				},
				{
				"mRender": function (data, type, row) {
					var codigo_requerimiento = "";
					if(row.codigo_requerimiento!= null)codigo_requerimiento = row.codigo_requerimiento;
					return codigo_requerimiento;
				},
				"bSortable": true,
				"aTargets": [4]
				},
				{
                "mRender": function (data, type, row) {
                	var empresa_vende = "";
					if(row.empresa_vende!= null)empresa_vende = row.empresa_vende;
					return empresa_vende;
                },
                "bSortable": true,
                "aTargets": [5]
                },

				{
				"mRender": function (data, type, row) {
					var fecha_orden_compra = "";
					if(row.fecha_orden_compra!= null)fecha_orden_compra = row.fecha_orden_compra;
					return fecha_orden_compra;
				},
				"bSortable": true,
				"aTargets": [6]
				},
				{
				"mRender": function (data, type, row) {
					var numero_orden_compra = "";
					if(row.numero_orden_compra!= null)numero_orden_compra = row.numero_orden_compra;
					return numero_orden_compra;
				},
				"bSortable": true,
				"aTargets": [7]
				},
				{
				"mRender": function (data, type, row) {
					var almacen_origen = "";
					if(row.almacen_origen!= null)almacen_origen = row.almacen_origen;
					return almacen_origen;
				},
				"bSortable": true,
				"aTargets": [8]
				},
				{
				"mRender": function (data, type, row) {
					var almacen_destino = "";
					if(row.almacen_destino!= null)almacen_destino = row.almacen_destino;
					return almacen_destino;
				},
				"bSortable": true,
				"aTargets": [9]
				},
				{
				"mRender": function (data, type, row) {
					var cerrado = "";
					if(row.cerrado!= null)cerrado = row.cerrado;
					return cerrado;
				},
				"bSortable": true,
				"aTargets": [10]
				},
				{
				"mRender": function (data, type, row) {
					var vendedor = "";
					if(row.vendedor!= null)vendedor = row.vendedor;
					return vendedor;
				},
				"bSortable": true,
				"aTargets": [11]
				},
				{
					"mRender": function (data, type, row) {
						var tiene_direccion = "";
						if(row.tiene_direccion == 1){
							tiene_direccion = "SI";
						}
						if(row.tiene_direccion == 0){
							tiene_direccion = "NO";
						}
						return tiene_direccion;
					},
					"bSortable": false,
					"aTargets": [12]
				},
				{
				"mRender": function (data, type, row) {
					var total = "";
					if(row.total!= null)total = parseFloat(row.total).toFixed(2);
					return total;
					
				},
				"bSortable": true,
				"aTargets": [13],
				"className": "text-right",
				},
				{
					"mRender": function (data, type, row) {
						var estado = "";
						var clase = "";
						if(row.estado == 1){
							estado = "Eliminar";
							clase = "btn-danger";
						}
						if(row.estado == 0){
							estado = "Activar";
							clase = "btn-success";
						}
						
						var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
						//alert(almacenUsuario.id_user);
						//if(almacenUsuario.some(almacen => almacen.id_user == row.id_usuario) && row.id_cerrado==1){
							
							html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalOrdenCompra('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>'; 
						/*}else{
							html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalOrdenCompra('+row.id+')" disabled><i class="fa fa-edit"></i> Editar</button>'; 
						}*/
						if (esAdministrador) {
							if(row.id_cerrado==1){
								html += '<a href="javascript:void(0)" onclick=eliminarOrdenCompra('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
							}else{
								html += '<a href="javascript:void(0)" onclick=eliminarOrdenCompra('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px; pointer-events: none; opacity: 0.6; cursor: not-allowed;">'+estado+'</a>';
							}
						}
						if(almacenUsuario.some(almacen => almacen.id_almacen == row.id_almacen_destino) && row.id_cerrado==1){
							html += '<button style="font-size:12px; margin-left:10px" type="button" class="btn btn-sm btn-info" data-toggle="modal" onclick="modalEntradaProductoOrdenCompra('+row.id+','+row.id_tipo_documento+')">Atender</button>';
						}else if(almacenUsuario.some(almacen => almacen.id_almacen == row.id_almacen_salida) && row.id_cerrado==1 && row.id_unidad_origen==4){
							html += '<button style="font-size:12px; margin-left:10px" type="button" class="btn btn-sm btn-info" data-toggle="modal" onclick="modalEntradaProductoOrdenCompra('+row.id+','+row.id_tipo_documento+')">Atender</button>';
						}else{
							html += '<button style="font-size:12px; margin-left:10px" type="button" class="btn btn-sm btn-info" data-toggle="modal" onclick="modalEntradaProductoOrdenCompra('+row.id+','+row.id_tipo_documento+')" disabled>Atender</button>';
						}

						if(row.tienda_asignada==1){
							
							html += '<button style="font-size:12px; margin-left:10px" type="button" class="btn btn-sm btn-primary" data-toggle="modal" onclick="modalTiendaOrdenCompra('+row.id+')" > Punto Entrega</button>'; 
						}else{
							
							html += '<button style="font-size:12px; margin-left:10px" type="button" class="btn btn-sm btn-primary" data-toggle="modal" onclick="modalTiendaOrdenCompra('+row.id+')" disabled> Punto Entrega</button>'; 
						}
						//else{
						//	html += '<button style="font-size:12px; margin-left:10px" type="button" class="btn btn-sm btn-primary" data-toggle="modal" onclick="modalTiendaOrdenCompra('+row.id+')" disabled> Punto Entrega</button>'; 
						//}
						
						html += '<button style="font-size:12px; margin-left:10px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalHistorialEntradaProducto('+row.id+','+row.id_tipo_documento+')">Historial</button>';  
						//html += '<a href="javascript:void(0)" onclick=modalResponsable('+row.id+') class="btn btn-sm btn-info" style="font-size:12px;margin-left:10px">Detalle Responsable</a>';
						if (esAdministrador) {
							html += '<a href="javascript:void(0)" onclick=anularOrdenCompra('+row.id+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">Anular</a>';
						}
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [14],
				},

            ]
    });

}

fn_util_LineaDatatable("#tblOrdenCompra");

$('#tblOrdenCompra tbody').on('click', 'tr', function () {
	
});

function fn_ListarBusqueda() {
    datatablenew();
};

function modalOrdenCompra(id){
	
	/*var tipo_mov="";
	if(tipo=='INGRESO'){tipo_mov=1};
	if(tipo=='SALIDA'){tipo_mov=2};*/

	$(".modal-dialog").css("width","95%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/orden_compra/modal_orden_compra/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});
}

function eliminarOrdenCompra(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" la Orden de Compra?", 
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
            url: "/orden_compra/eliminar_orden_compra/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				datatablenew();
            }
    });
}

function anularOrdenCompra(id){

	$(".modal-dialog").css("width","95%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/orden_compra/modal_anular_orden_compra/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function modalEntradaProductoOrdenCompra(id,id_tipo_documento){

	//var tipo = $('#tipo_documento').val();
	
	//alert(id);

	$(".modal-dialog").css("width","95%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/entrada_productos/modal_detalle_producto_orden_compra/"+id+"/"+id_tipo_documento,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});
}

function modalHistorialEntradaProducto(id, id_tipo_documento){

	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
		url: "/entrada_productos/modal_historial_entrada_producto/"+id+"/"+id_tipo_documento,
		type: "GET",
		success: function (result) {
				$("#diveditpregOpc").html(result);
				$('#openOverlayOpc').modal('show');
		}
	});
}

function modalTiendaOrdenCompra(id){
	
	/*var tipo_mov="";
	if(tipo=='INGRESO'){tipo_mov=1};
	if(tipo=='SALIDA'){tipo_mov=2};*/

	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/orden_compra/modal_orden_compra_tienda/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});
}

function DescargarArchivosExcel(){
	
	var tipo_documento = $('#tipo_documento_bus').val();
	var empresa_compra = $('#empresa_compra_bus').val();
	var empresa_vende = $('#empresa_vende_bus').val();
	var fecha_inicio = $('#fecha_inicio_bus').val();
	var fecha_fin = $('#fecha_fin_bus').val();
	var numero_orden_compra = $('#numero_orden_compra_bus').val();
	var numero_orden_compra_cliente = $('#numero_orden_compra_cliente_bus').val();
	var almacen_origen = $('#almacen_origen_bus').val();
	var almacen_destino = $('#almacen_destino_bus').val();
	var situacion = $('#situacion_bus').val();
	var estado = $('#estado_bus').val();
	var vendedor = $('#vendedor_bus').val();
	var estado_pedido = $('#estado_pedido_bus').val();

	if (tipo_documento == "")tipo_documento = 0;
	if (empresa_compra == "")empresa_compra = 0;
	if (empresa_vende == "")empresa_vende = 0;
	if (fecha_inicio == "")fecha_inicio = "0";
	if (fecha_fin == "")fecha_fin = "0";
	if (numero_orden_compra == "")numero_orden_compra = "0";
	if (numero_orden_compra_cliente == "")numero_orden_compra_cliente = "0";
	if (almacen_origen == "")almacen_origen = 0;
	if (almacen_destino == "")almacen_destino = 0;
	if (situacion == "")situacion = 0;
	if (estado == "")estado = 0;
	if (vendedor == "")vendedor = 0;
	if (estado_pedido == "")estado_pedido = 0;
	
	location.href = '/orden_compra/exportar_listar_orden_compra/'+tipo_documento+'/'+empresa_compra+'/'+empresa_vende+'/'+fecha_inicio+'/'+fecha_fin+'/'+numero_orden_compra+'/'+numero_orden_compra_cliente+'/'+almacen_origen+'/'+almacen_destino+'/'+situacion+'/'+estado+'/'+vendedor+'/'+estado_pedido;
}

function generarLPN(){

	var id_orden_compra = $('#id').val();

	$.ajax({
		url: "/orden_compra/generar_lpn/"+id_orden_compra,
		type: "GET",
		success: function (result) {
				//$("#diveditpregOpc").html(result);
				//$('#openOverlayOpc').modal('show');
				bootbox.alert("Generado Exitosamente");
		}
	});
}
