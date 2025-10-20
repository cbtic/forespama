$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
		
	$('#btnNuevo').click(function () {
		modalChopeoProducto(0);
	});

	$('#tienda_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#producto_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#producto_bus').select2({
		width : "100%"
	})

	$('#tienda_bus').select2({
		width : "100%"
	})

	$('#btnDescargar').on('click', function () {
		DescargarArchivosExcel()

	});
		
	datatablenew();

});

function datatablenew(){
    
    var oTable1 = $('#tblChopeoProductos').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/productos/listar_chopeo_producto_ajax",
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
			
            var tienda = $('#tienda_bus').val();
            var producto = $('#producto_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						tienda:tienda,producto:producto,
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
				var id_producto = "";
				if(row.id_producto!= null)id_producto = row.id_producto;
				return id_producto;
			},
			"bSortable": false,
			"aTargets": [0],
			"className": "dt-center",
			//"className": 'control'
			},

			{
			"mRender": function (data, type, row) {
				var producto = "";
				if(row.producto!= null)producto = row.producto;
				return producto;
			},
			"bSortable": true,
			"aTargets": [1]
			},

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
				var sku = "";
				if(row.sku!= null)sku = row.sku;
				return sku;
			},
			"bSortable": true,
			"aTargets": [3]
			},

			{
			"mRender": function (data, type, row) {
				var costo_unitario = "";
				if(row.costo_unitario!= null)costo_unitario = parseFloat(row.costo_unitario).toFixed(2);
				return costo_unitario;
			},
			"bSortable": true,
			"aTargets": [4]
			},
			
			{
			"mRender": function (data, type, row) {
				var precio_dimfer = "";
				if(row.precio_dimfer!= null)precio_dimfer = parseFloat(row.precio_dimfer).toFixed(2);
				return precio_dimfer;
			},
			"bSortable": true,
			"aTargets": [5]
			},

			{
			"mRender": function (data, type, row) {
				var precio_ares = "";
				if(row.precio_ares!= null)precio_ares = parseFloat(row.precio_ares).toFixed(2);
				return precio_ares;
			},
			"bSortable": true,
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
					
					html += '<button style="font-size:12px; margin-right:10px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalChopeoProducto('+row.id+',1'+')" ><i class="fa fa-edit"></i> Precio Dimfer</button>';
					
					html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalChopeoProducto('+row.id+',2'+')" ><i class="fa fa-edit"></i> Precio Ares</button>'; 
					
					//html += '<a href="javascript:void(0)" onclick=modalResponsable('+row.id+') class="btn btn-sm btn-info" style="font-size:12px;margin-left:10px">Detalle Responsable</a>';
					
					html += '</div>';
					return html;
				},
				"bSortable": false,
				"aTargets": [7],
			},
		]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};

function modalChopeoProducto(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
		url: "/productos/modal_chopeo_producto/"+id,
		type: "GET",
		success: function (result) {
			$("#diveditpregOpc").html(result);
			$('#openOverlayOpc').modal('show');
		}
	});
}

function DescargarArchivosExcel(){
	
	var tipo_origen_producto = $('#tipo_origen_producto_bus').val();
	var serie = $('#serie_bus').val();
	var codigo = $('#codigo_bus').val();
	var denominacion = $('#denominacion_bus').val();
	var estado_bien = $('#estado_bien_bus').val();
	var tipo_producto = $('#tipo_producto_bus').val();
	var tiene_imagen = $('#tiene_imagen_bus').val();
	var estado = $('#estado_bus').val();
	var familia = $('#familia_bus').val();
	var sub_familia = $('#sub_familia_bus').val();

	if (tipo_origen_producto == "")tipo_origen_producto = 0;
	if (serie == "")serie = "0";
	if (codigo == "")codigo = "0";
	if (denominacion == "")denominacion = "0";
	if (estado_bien == "")estado_bien = 0;
	if (tipo_producto == "")tipo_producto = 0;
	if (tiene_imagen == "")tiene_imagen = 0;
	if (estado == "")estado = 0;
	if (familia == "")familia = 0;
	if (sub_familia == "")sub_familia = 0;
	
	location.href = '/productos/exportar_listar_productos/'+tipo_origen_producto+'/'+serie+'/'+codigo+'/'+denominacion+'/'+estado_bien+'/'+tipo_producto+'/'+tiene_imagen+'/'+estado+'/'+familia+'/'+sub_familia;
}
