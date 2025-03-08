$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#btnNuevo').click(function () {
		modalDevolucion(0);
	});

	$('#empresa_bus').keypress(function(e){
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

	$('#numero_devolucion_bus').keypress(function(e){
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

	$('#empresa_bus').select2({ width : '100%' })

	datatablenew();

	$('#btnDescargar').on('click', function () {
		DescargarArchivosExcel()

	});

});

function datatablenew(){
                      
    var oTable1 = $('#tblDevolucion').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/devolucion/listar_devolucion_ajax",
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
        "fnDrawCallback": function(json) {
            $('[data-toggle="tooltip"]').tooltip();
        },

        "fnServerData": function (sSource, aoData, fnCallback, oSettings) {

            var sEcho           = aoData[0].value;
            var iNroPagina 	= parseFloat(fn_util_obtieneNroPagina(aoData[3].value, aoData[4].value)).toFixed();
            var iCantMostrar 	= aoData[4].value;
			
            var empresa = $('#empresa_bus').val();
			var fecha = $('#fecha_bus').val();
			var numero_devolucion = $('#numero_devolucion_bus').val();
			var numero_orden_compra_cliente = $('#numero_orden_compra_cliente_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						empresa:empresa, fecha:fecha,numero_orden_compra_cliente:numero_orden_compra_cliente,
						numero_devolucion:numero_devolucion,
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
                	var codigo = "";
					if(row.codigo!= null)codigo = row.codigo;
					return codigo;
                },
                "bSortable": true,
                "aTargets": [2]
                },
				
				{
				"mRender": function (data, type, row) {
					var empresa = "";
					if(row.empresa!= null)empresa = row.empresa;
					return empresa;
				},
				"bSortable": true,
				"aTargets": [3]
				},
				{
                "mRender": function (data, type, row) {
                	var numero_orden_compra_cliente = "";
					if(row.numero_orden_compra_cliente!= null)numero_orden_compra_cliente = row.numero_orden_compra_cliente;
					return numero_orden_compra_cliente;
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
				/*{
				"mRender": function (data, type, row) {
					var numero_devolucion = "";
					if(row.numero_devolucion!= null)numero_devolucion = row.numero_devolucion;
					return numero_devolucion;
				},
				"bSortable": true,
				"aTargets": [6]
				},*/
				{
					"mRender": function (data, type, row) {
						/*var estado = "";
						var clase = "";
						if(row.estado == 1){
							estado = "Eliminar";
							clase = "btn-danger";
						}
						if(row.estado == 0){
							estado = "Activar";
							clase = "btn-success";
						}*/
						
						var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
						//alert(almacenUsuario.id_user);
						//if(almacenUsuario.some(almacen => almacen.id_user == row.id_usuario) && row.id_cerrado==1){
							
							html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalDevolucion('+row.id+')" ><i class="fa fa-edit"></i> Visualizar</button>'; 
						/*}else{
							html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalOrdenCompra('+row.id+')" disabled><i class="fa fa-edit"></i> Editar</button>'; 
						}*/
						//else{
						//	html += '<button style="font-size:12px; margin-left:10px" type="button" class="btn btn-sm btn-primary" data-toggle="modal" onclick="modalTiendaOrdenCompra('+row.id+')" disabled> Punto Entrega</button>'; 
						//}
						
						//html += '<a href="javascript:void(0)" onclick=modalResponsable('+row.id+') class="btn btn-sm btn-info" style="font-size:12px;margin-left:10px">Detalle Responsable</a>';
						
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [6],
				},

            ]


    });

}

fn_util_LineaDatatable("#tblDevolucion");

$('#tblDevolucion tbody').on('click', 'tr', function () {
	
});

function fn_ListarBusqueda() {
    datatablenew();
};

function modalDevolucion(id){
	
	/*var tipo_mov="";
	if(tipo=='INGRESO'){tipo_mov=1};
	if(tipo=='SALIDA'){tipo_mov=2};*/

	$(".modal-dialog").css("width","95%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
		url: "/devolucion/modal_devolucion/"+id,
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

function modalEntradaProductoOrdenCompra(id,id_tipo_documento){

	//var tipo = $('#tipo_documento').val();
	
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
	var fecha = $('#fecha_bus').val();
	var numero_orden_compra = $('#numero_orden_compra_bus').val();
	var numero_orden_compra_cliente = $('#numero_orden_compra_cliente_bus').val();
	var almacen_origen = $('#almacen_origen_bus').val();
	var almacen_destino = $('#almacen_destino_bus').val();
	var situacion = $('#situacion_bus').val();
	var estado = $('#estado_bus').val();

	if (tipo_documento == "")tipo_documento = 0;
	if (empresa_compra == "")empresa_compra = 0;
	if (empresa_vende == "")empresa_vende = 0;
	if (fecha == "")fecha = "0";
	if (numero_orden_compra == "")numero_orden_compra = "0";
	if (numero_orden_compra_cliente == "")numero_orden_compra_cliente = "0";
	if (almacen_origen == "")almacen_origen = 0;
	if (almacen_destino == "")almacen_destino = 0;
	if (situacion == "")situacion = 0;
	if (estado == "")estado = 0;
	
	location.href = '/orden_compra/exportar_listar_orden_compra/'+tipo_documento+'/'+empresa_compra+'/'+empresa_vende+'/'+fecha+'/'+numero_orden_compra+'/'+numero_orden_compra_cliente+'/'+almacen_origen+'/'+almacen_destino+'/'+situacion+'/'+estado;
}
