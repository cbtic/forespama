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

	$('#estado_bus').keypress(function(e){
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
                      
    var oTable1 = $('#tblReporteProductos').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/productos/listar_reporte_productos_ajax",
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

			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						denominacion:denominacion,codigo:codigo,
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
					var denominacion = "";
					if(row.denominacion!= null)denominacion = row.denominacion;
					return denominacion;
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
                	var unidad = "";
					if(row.unidad!= null)unidad = row.unidad;
					return unidad;
                },
                "bSortable": true,
                "aTargets": [3]
                },

				{
				"mRender": function (data, type, row) {
					var categoria = "";
					if(row.categoria!= null)categoria = row.categoria;
					return categoria;
				},
				"bSortable": true,
				"aTargets": [4]
				},
				
                {
                "mRender": function (data, type, row) {
                	var sub_categoria = "";
					if(row.sub_categoria!= null)sub_categoria = row.sub_categoria;
					return sub_categoria;
                },
                "bSortable": true,
                "aTargets": [5]
                },

				{
				"mRender": function (data, type, row) {
					var modelo = "";
					if(row.modelo!= null)modelo = row.modelo;
					return modelo;
				},
				"bSortable": true,
				"aTargets": [6]
				},
				{
				"mRender": function (data, type, row) {
					var packet = "";
					if(row.packet!= null)packet = row.packet;
					return packet;
				},
				"bSortable": true,
				"aTargets": [7]
				},
				{
				"mRender": function (data, type, row) {
					var medida = "";
					if(row.medida!= null)medida = row.medida;
					return medida;
				},
				"bSortable": true,
				"aTargets": [8]
				},
				{
				"mRender": function (data, type, row) {
					var peso = "";
					if(row.peso!= null)peso = row.peso;
					return peso;
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
            ]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};

function DescargarArchivosExcel(){
	
	var codigo = $('#codigo_bus').val();
	var denominacion = $('#denominacion_bus').val();

	if (codigo == "")codigo = "0";
	if (denominacion == "")denominacion = "0";
	
	location.href = '/productos/exportar_reporte_productos/'+codigo+'/'+denominacion;
}
