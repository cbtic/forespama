$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#btnNuevo').click(function () {
		modalOrdenProduccion(0);
	});

	$('#btnNuevoPlaneamiento').click(function () {
		modalOrdenProduccionPlaneamiento(0);
	});

	$('#producto_bus').keypress(function(e){
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

	$('#numero_orden_produccion_bus').keypress(function(e){
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

	$('#producto_bus').select2({ width : '100%' })

	datatablenew();

});

function datatablenew(){
    
    var oTable1 = $('#tblOrdenProduccion').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/orden_produccion/listar_orden_produccion_ajax",
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
			
            $('[data-toggle="tooltip"]').tooltip();
        },

        "fnServerData": function (sSource, aoData, fnCallback, oSettings) {

            var sEcho           = aoData[0].value;
            var iNroPagina 	= parseFloat(fn_util_obtieneNroPagina(aoData[3].value, aoData[4].value)).toFixed();
            var iCantMostrar 	= aoData[4].value;
			
			var fecha_inicio = $('#fecha_inicio_bus').val();
			var numero_orden_produccion = $('#numero_orden_produccion_bus').val();
			var area= $('#area_bus').val();
			var situacion = $('#situacion_bus').val();
			var estado = $('#estado_bus').val();
			var producto = $('#producto_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						fecha_inicio:fecha_inicio,numero_orden_produccion:numero_orden_produccion,area:area,situacion:situacion,producto:producto,
						estado:estado,_token:_token
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
				var codigo = "";
				if(row.codigo!= null)codigo = row.codigo;
				return codigo;
			},
			"bSortable": true,
			"aTargets": [1]
			},
		
			{
			"mRender": function (data, type, row) {
				var fecha_orden_produccion = "";
				if(row.fecha_orden_produccion!= null)fecha_orden_produccion = row.fecha_orden_produccion;
				return fecha_orden_produccion;
			},
			"bSortable": true,
			"aTargets": [2]
			},

			{
			"mRender": function (data, type, row) {
				var area = "";
				if(row.area!= null)area = row.area;
				return area;
			},
			"bSortable": true,
			"aTargets": [3]
			},
			
			{
			"mRender": function (data, type, row) {
				var fecha_produccion = "";
				if(row.fecha_produccion!= null)fecha_produccion = row.fecha_produccion;
				return fecha_produccion;
			},
			"bSortable": true,
			"aTargets": [4]
			},
			
			{
			"mRender": function (data, type, row) {
				var situacion = "";
				if(row.situacion!= null)situacion = row.situacion;
				return situacion;
			},
			"bSortable": true,
			"aTargets": [5]
			},

			{
			"mRender": function (data, type, row) {
				var estado = "";
				if(row.estado == 1){
					estado = "Activo";
				}
				if(row.estado == 0){
					estado = "Inactivo";
				}
				return estado;
			},
			"bSortable": false,
			"aTargets": [6]
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
					
				html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalOrdenProduccion('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>'; 

				html += '<button style="font-size:12px;margin-left:10px" type="button" class="btn btn-sm btn-info" data-toggle="modal" onclick="modalAtenderOrdenProduccion('+row.id+')" ><i class="fa fa-edit"></i> Atender</button>'; 
				
				html += '</div>';
				return html;
			},
			"bSortable": false,
			"aTargets": [7],
			},
		]
    });
}

fn_util_LineaDatatable("#tblOrdenProduccion");

$('#tblOrdenProduccion tbody').on('click', 'tr', function () {
	
});

function fn_ListarBusqueda() {
    datatablenew();
};

function modalOrdenProduccion(id){

	$(".modal-dialog").css("width","95%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
		url: "/orden_produccion/modal_orden_produccion/"+id,
		type: "GET",
		success: function (result) {
			$("#diveditpregOpc").html(result);
			$('#openOverlayOpc').modal('show');
		}
	});
}

function modalOrdenProduccionPlaneamiento(id){

	$(".modal-dialog").css("width","95%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
		url: "/orden_produccion/modal_orden_produccion_planeamiento/"+id,
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

function modalAtenderOrdenProduccion(id){
	
	$(".modal-dialog").css("width","95%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
		url: "/orden_produccion/modal_atender_orden_produccion/"+id,
		type: "GET",
		success: function (result) {
			$("#diveditpregOpc").html(result);
			$('#openOverlayOpc').modal('show');
		}
	});
}
