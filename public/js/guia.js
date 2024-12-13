$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#btnNuevo').click(function () {
		modalGuia(0);
	});

	$('#numero_guia_bus').keypress(function(e){
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

	$('#tipo_documento_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#numero_documento_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#placa_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#empresa_transporte_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#origen_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#destino_bus').keypress(function(e){
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

	$('#fecha_bus').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });
		
	datatablenew();

});

function datatablenew(){
    
    var oTable1 = $('#tblGuia').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/guia/listar_guia_ajax",
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
			var fecha = $('#fecha_bus').val();
			var numero_requerimiento = $('#numero_requerimiento_bus').val();
			var almacen = $('#almacen_bus').val();
			var situacion = $('#situacion_bus').val();
			var responsable_atencion = $('#responsable_atencion_bus').val();
			var estado_atencion = $('#estado_atencion_bus').val();
			var estado = $('#estado_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						tipo_documento:tipo_documento,fecha:fecha,numero_requerimiento:numero_requerimiento,
						almacen:almacen,situacion:situacion,estado:estado,
						responsable_atencion:responsable_atencion,estado_atencion:estado_atencion,
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
						var fecha = "";
						if(row.fecha!= null)fecha = row.fecha;
						return fecha;
					},
					"bSortable": true,
					"aTargets": [2]
				},
				{
					"mRender": function (data, type, row) {
						var codigo = "";
						if(row.codigo!= null)codigo = row.codigo;
						return codigo;
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
						var cerrado_situacion = "";
						if(row.cerrado_situacion!= null)cerrado_situacion = row.cerrado_situacion;
						return cerrado_situacion;
					},
					"bSortable": true,
					"aTargets": [5]
				},

				{
					"mRender": function (data, type, row) {
						var responsable_atencion = "";
						if(row.responsable_atencion!= null)responsable_atencion = row.responsable_atencion;
						return responsable_atencion;
					},
					"bSortable": true,
					"aTargets": [6]
				},

				{
					"mRender": function (data, type, row) {
						var estado_atencion = "";
						if(row.estado_atencion!= null)estado_atencion = row.estado_atencion;
						return estado_atencion;
					},
					"bSortable": true,
					"aTargets": [7]
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
					"aTargets": [8]
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
						
						html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalGuia('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>'; 
						
						html += '<a href="javascript:void(0)" onclick=eliminarGuia('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>'; 
						
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [9],
				},
            ]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};

function modalGuia(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/guia/modal_guia/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});
}

function eliminarGuia(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" la Guia?", 
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
            url: "/guia/eliminar_guia/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				datatablenew();
            }
    });
}
