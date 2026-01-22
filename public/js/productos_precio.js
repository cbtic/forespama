$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#codigo_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#denominacion_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#btnDescargar').on('click', function () {
		DescargarArchivosExcel()
	});
	
	datatablenew();

});

function datatablenew(){
                      
    var oTable1 = $('#tblPrecioProductos').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/productos/listar_precio_producto_ajax",
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
			
            var codigo = $('#codigo_bus').val();
            var denominacion = $('#denominacion_bus').val();
			var estado = $('#estado_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						denominacion:denominacion,codigo:codigo,
						estado:estado,
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
                	var unidad_producto = "";
					if(row.unidad_producto!= null)unidad_producto = row.unidad_producto;
					return unidad_producto;
                },
                "bSortable": true,
                "aTargets": [3]
                },

				{
				"mRender": function (data, type, row) {
					var marca = "";
					if(row.marca!= null)marca = row.marca;
					return marca;
				},
				"bSortable": true,
				"aTargets": [4]
				},
				
                {
                "mRender": function (data, type, row) {
                	var precio = "";
					if(row.precio!= null)precio = row.precio;
					return precio;
                },
                "bSortable": true,
                "aTargets": [5]
                },

				{
				"mRender": function (data, type, row) {
					var fecha = "";
					if(row.fecha!= null)fecha = row.fecha;
					return fecha;
				},
				"bSortable": true,
				"aTargets": [6]
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
					"aTargets": [7]
				},
				{
					"mRender": function (data, type, row) {
						
						var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
						
						html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalHistorialPrecioProducto('+row.id_producto+')" ><i class="fas fa-clipboard-list" style="font-size:18px;"></i>  Historial</button>';
						
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [8],
				},
            ]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};

function modalHistorialPrecioProducto(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
		url: "/productos/modal_historial_precio_producto/"+id,
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
