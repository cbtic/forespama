$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#numero_orden_compra_bus').keypress(function(e){
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

	$('#vendedor_bus').keypress(function(e){
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
    
    var oTable1 = $('#tblAutorizacion').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/orden_compra/listar_orden_compra_autorizacion_ajax",
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
			
            var numero_orden_compra = $('#numero_orden_compra_bus').val();
			var numero_orden_compra_cliente = $('#numero_orden_compra_cliente_bus').val();
			var vendedor = $('#vendedor_bus').val();
			var estado_autorizacion = $('#estado_autorizacion_bus').val();
			var estado = $('#estado_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						numero_orden_compra:numero_orden_compra,numero_orden_compra_cliente:numero_orden_compra_cliente,
						vendedor:vendedor,estado_autorizacion:estado_autorizacion,estado:estado,
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
				var fecha_orden_compra = "";
				if(row.fecha_orden_compra!= null)fecha_orden_compra = row.fecha_orden_compra;
				return fecha_orden_compra;
			},
			"bSortable": true,
			"aTargets": [4]
			},

			{
			"mRender": function (data, type, row) {
				var numero_orden_compra = "";
				if(row.numero_orden_compra!= null)numero_orden_compra = row.numero_orden_compra;
				return numero_orden_compra;
			},
			"bSortable": true,
			"aTargets": [5]
			},

			{
			"mRender": function (data, type, row) {
				var almacen_origen = "";
				if(row.almacen_origen!= null)almacen_origen = row.almacen_origen;
				return almacen_origen;
			},
			"bSortable": true,
			"aTargets": [6]
			},

			{
			"mRender": function (data, type, row) {
				var cerrado = "";
				if(row.cerrado!= null)cerrado = row.cerrado;
				return cerrado;
			},
			"bSortable": true,
			"aTargets": [7]
			},

			{
			"mRender": function (data, type, row) {
				var vendedor = "";
				if(row.vendedor!= null)vendedor = row.vendedor;
				return vendedor;
			},
			"bSortable": true,
			"aTargets": [8]
			},

			{
			"mRender": function (data, type, row) {
				var total = "";
				if(row.total!= null)total = parseFloat(row.total).toFixed(2);
				return total;
				
			},
			"bSortable": true,
			"aTargets": [9],
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
						
					html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalOrdenCompraAutorizacion('+row.id+')" ><i class="fa fa-edit"></i> Visualizar</button>'; 
					
					html += '</div>';
					return html;
				},
				"bSortable": false,
				"aTargets": [10],
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

function modalOrdenCompraAutorizacion(id){
	
	$(".modal-dialog").css("width","95%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
		url: "/orden_compra/modal_orden_compra_autorizacion/"+id,
		type: "GET",
		success: function (result) {
			$("#diveditpregOpc").html(result);
			$('#openOverlayOpc').modal('show');
		}
	});
}
