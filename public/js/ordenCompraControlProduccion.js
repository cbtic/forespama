$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#btnNuevo').click(function () {
		modalOrdenCompra(0);
	});

	$('#empresa_compra_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#persona_compra_bus').keypress(function(e){
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

	$('#persona_compra_bus').select2({ width : '100%' })
	
	$('#almacen_origen_bus').select2({ width : '100%' })
	
	datatablenew();

	/*$('#btnDescargar').on('click', function () {
		DescargarArchivosExcel()

	});*/

});

function datatablenew(){
    
    var oTable1 = $('#tblOrdenCompraControlProduccion').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/orden_compra/listar_orden_compra_control_produccion_ajax",
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
			
			var empresa_compra = $('#empresa_compra_bus').val();
			var persona_compra = $('#persona_compra_bus').val();
			var fecha_inicio = $('#fecha_inicio_bus').val();
			var fecha_fin = $('#fecha_fin_bus').val();
			var numero_orden_compra = $('#numero_orden_compra_bus').val();
			var situacion = $('#situacion_bus').val();
			var almacen_origen = $('#almacen_origen_bus').val();
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
						empresa_compra:empresa_compra,persona_compra:persona_compra,fecha_inicio:fecha_inicio,fecha_fin:fecha_fin,numero_orden_compra:numero_orden_compra,
						almacen_origen:almacen_origen,situacion:situacion,estado:estado,numero_orden_compra_cliente:numero_orden_compra_cliente,
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
				var cliente = "";
				if(row.cliente!= null)cliente = row.cliente;
				return cliente;
			},
			"bSortable": true,
			"aTargets": [1]
			},
		
			{
			"mRender": function (data, type, row) {
				var numero_orden_compra = "";
				if(row.numero_orden_compra!= null)numero_orden_compra = row.numero_orden_compra;
				return numero_orden_compra;
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
				var almacen = "";
				if(row.almacen!= null)almacen = row.almacen;
				return almacen;
			},
			"bSortable": true,
			"aTargets": [4]
			},
			{
			"mRender": function (data, type, row) {
				var fecha_orden_compra = "";
				if(row.fecha_orden_compra!= null)fecha_orden_compra = row.fecha_orden_compra;
				return fecha_orden_compra;
			},
			"bSortable": true,
			"aTargets": [5]
			},

			{
			"mRender": function (data, type, row) {
				var fecha_vencimiento = "";
				if(row.fecha_vencimiento!= null)fecha_vencimiento = row.fecha_vencimiento;
				return fecha_vencimiento;
			},
			"bSortable": true,
			"aTargets": [6]
			},
			{
			"mRender": function (data, type, row) {
				var fecha_produccion = "";
				if(row.fecha_produccion!= null)fecha_produccion = row.fecha_produccion;
				return fecha_produccion;
			},
			"bSortable": true,
			"aTargets": [7]
			},
			{
			"mRender": function (data, type, row) {
				var cerrado = "";
				if(row.cerrado!= null)cerrado = row.cerrado;
				return cerrado;
			},
			"bSortable": true,
			"aTargets": [8]
			},
			{
			"mRender": function (data, type, row) {
				var vendedor = "";
				if(row.vendedor!= null)vendedor = row.vendedor;
				return vendedor;
			},
			"bSortable": true,
			"aTargets": [9]
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
			"aTargets": [10]
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
					
				html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalOrdenCompraControlProduccion('+row.id+')" ><i class="fa fa-edit"></i> Agregar Fecha</button>'; 
				
				html += '</div>';
				return html;
			},
			"bSortable": false,
			"aTargets": [11],
			},

		]
    });

}

fn_util_LineaDatatable("#tblOrdenCompraControlProduccion");

$('#tblOrdenCompraControlProduccion tbody').on('click', 'tr', function () {
	
});

function fn_ListarBusqueda() {
    datatablenew();
};

function modalOrdenCompraControlProduccion(id){

	$(".modal-dialog").css("width","95%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
		url: "/orden_compra/modal_orden_compra_control_produccion/"+id,
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
