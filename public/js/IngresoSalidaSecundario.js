$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#btnNuevo').click(function () {
		modalIngresoSalidaSecundario(0);
	});

	$('#tipo_documento_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#empresa_bus').keypress(function(e){
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

	$('#numero_ingreso_salida_bus').keypress(function(e){
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
	
	$('#empresa_bus').select2({ width : '100%' })
	
	$('#persona_bus').select2({ width : '100%' })

	datatablenew();

	/*$('#btnDescargarDetalle').on('click', function () {
		DescargarArchivoDetalleExcel()

	});*/

});

function datatablenew(){
                      
    var oTable1 = $('#tblIngresoSalidaB').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/ingreso_salida_secundarios/listar_ingreso_salida_secundarios_ajax",
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
			
            var tipo_documento = $('#tipo_documento_bus').val();
            var empresa = $('#empresa_bus').val();
            var persona = $('#persona_bus').val();
			var fecha_inicio = $('#fecha_inicio_bus').val();
			var fecha_fin = $('#fecha_fin_bus').val();
			var numero_ingreso_salida = $('#numero_ingreso_salida_bus').val();
			var estado = $('#estado_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						tipo_documento:tipo_documento,empresa:empresa,persona:persona,fecha_inicio:fecha_inicio,fecha_fin:fecha_fin,
						numero_ingreso_salida:numero_ingreso_salida,estado:estado,
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
						var tipo_documento = "";
						if(row.tipo_documento!= null)tipo_documento = row.tipo_documento;
						return tipo_documento;
					},
					"bSortable": true,
					"aTargets": [1]
				},
				
				{
					"mRender": function (data, type, row) {
						var proveedor = "";
						if(row.proveedor!= null)proveedor = row.proveedor;
						return proveedor;
					},
					"bSortable": true,
					"aTargets": [2]
				},
				{
					"mRender": function (data, type, row) {
						var fecha_ingreso_salida = "";
						if(row.fecha_ingreso_salida!= null)fecha_ingreso_salida = row.fecha_ingreso_salida;
						return fecha_ingreso_salida;
					},
					"bSortable": true,
					"aTargets": [3]
				},
				{
					"mRender": function (data, type, row) {
						var numero_ingreso_salida = "";
						if(row.numero_ingreso_salida!= null)numero_ingreso_salida = row.numero_ingreso_salida;
						return numero_ingreso_salida;
					},
					"bSortable": true,
					"aTargets": [4]
				},
				{
					"mRender": function (data, type, row) {
						var almacen = "";
						if(row.almacen!= null)almacen = row.almacen;
						return almacen;
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
						
						html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalIngresoSalidaSecundario('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>'; 
						
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

function modalIngresoSalidaSecundario(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
		url: "/ingreso_salida_secundarios/modal_ingreso_salida_secundario/"+id,
		type: "GET",
		success: function (result) {
			$("#diveditpregOpc").html(result);
			$('#openOverlayOpc').modal('show');
		}
	});
}

/*function DescargarArchivoDetalleExcel(){
	
	var tipo_documento = $('#tipo_documento_bus').val();
	var fecha_inicio = $('#fecha_inicio_bus').val();
	var fecha_fin = $('#fecha_fin_bus').val();
	var numero_ajuste = $('#numero_ajuste_bus').val();
	var almacen = $('#almacen_bus').val();
	var estado = $('#estado_bus').val();

	if (tipo_documento == "")tipo_documento = 0;
	if (fecha_inicio == "")fecha_inicio = "0";
	if (fecha_fin == "")fecha_fin = "0";
	if (numero_ajuste == "")numero_ajuste = "0";
	if (almacen == "")almacen = 0;
	if (estado == "")estado = 0;

	location.href = '/entrada_productos/exportar_listar_ajuste_detalle/'+tipo_documento+'/'+fecha_inicio+'/'+fecha_fin+'/'+numero_ajuste+'/'+almacen+'/'+estado;
}*/
