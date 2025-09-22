$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#btnNuevoIngreso').click(function () {
		modalIngresoHorno(0);
	});
	
	$('#btnNuevoSalida').click(function () {
		modalSalidaHorno(0);
	});

	$('#fecha_bus').keypress(function(e){
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

	$('#fecha_bus').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

});

function datatablenew(){
    
    var oTable1 = $('#tblIngresoHornoCreate').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/horno/listar_ingreso_horno_ajax",
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
			
            var fecha = $('#fecha_bus').val();
            var estado = $('#estado_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						fecha:fecha,estado:estado,_token:_token
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
						var horno = "";
						if(row.horno!= null)horno = row.horno;
						return horno;
					},
					"bSortable": true,
					"aTargets": [1]
				},

				{
					"mRender": function (data, type, row) {
						var fecha_encendido = "";
						if(row.fecha_encendido!= null)fecha_encendido = row.fecha_encendido;
						return fecha_encendido;
					},
					"bSortable": true,
					"aTargets": [2]
				},

				{
					"mRender": function (data, type, row) {
						var hora_encendido = "";
						if(row.hora_encendido!= null)hora_encendido = row.hora_encendido;
						return hora_encendido;
					},
					"bSortable": true,
					"aTargets": [3]
				},

				{
					"mRender": function (data, type, row) {
						var temperatura_inicio = "";
						if(row.temperatura_inicio!= null)temperatura_inicio = row.temperatura_inicio;
						return temperatura_inicio;
					},
					"bSortable": true,
					"aTargets": [4]
				},

				{
					"mRender": function (data, type, row) {
						var humedad_inicio = "";
						if(row.humedad_inicio!= null)humedad_inicio = row.humedad_inicio;
						return humedad_inicio;
					},
					"bSortable": true,
					"aTargets": [5]
				},

				{
					"mRender": function (data, type, row) {
						var operador_encendido = "";
						if(row.operador_encendido!= null)operador_encendido = row.operador_encendido;
						return operador_encendido;
					},
					"bSortable": true,
					"aTargets": [6]
				},

				{
					"mRender": function (data, type, row) {
						var fecha_apagado = "";
						if(row.fecha_apagado!= null)fecha_apagado = row.fecha_apagado;
						return fecha_apagado;
					},
					"bSortable": true,
					"aTargets": [7]
				},

				{
					"mRender": function (data, type, row) {
						var hora_apagado = "";
						if(row.hora_apagado!= null)hora_apagado = row.hora_apagado;
						return hora_apagado;
					},
					"bSortable": true,
					"aTargets": [8]
				},

				{
					"mRender": function (data, type, row) {
						var humedad_apagado = "";
						if(row.humedad_apagado!= null)humedad_apagado = row.humedad_apagado;
						return humedad_apagado;
					},
					"bSortable": true,
					"aTargets": [9]
				},

				{
					"mRender": function (data, type, row) {
						var operador_apagado = "";
						if(row.operador_apagado!= null)operador_apagado = row.operador_apagado;
						return operador_apagado;
					},
					"bSortable": true,
					"aTargets": [10]
				},

				{
					"mRender": function (data, type, row) {
						var observacion = "";
						if(row.observacion!= null)observacion = row.observacion;
						return observacion;
					},
					"bSortable": true,
					"aTargets": [11]
				},

				{
					"mRender": function (data, type, row) {
						var total_ingreso = "";
						if(row.total_ingreso!= null)total_ingreso = row.total_ingreso;
						return total_ingreso;
					},
					"bSortable": true,
					"aTargets": [12]
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
					"aTargets": [13]
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
						
						html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalIngresoHorno('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>'; 
						html += '<button style="font-size:12px; margin-left:10px" type="button" class="btn btn-sm btn-info" data-toggle="modal" onclick="modalSalidaHorno('+row.id+')" ><i class="fa fa-edit"></i> Agregar Salida</button>'; 
						
						//html += '<a href="javascript:void(0)" onclick=eliminarEquivalenciaProducto('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';			
						
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [14],
				},
            ]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};

function modalIngresoHorno(id){

	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/horno/modal_ingreso_horno/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});
}

function modalSalidaHorno(id){

	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/horno/modal_salida_horno/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});
}