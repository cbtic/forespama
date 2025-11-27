$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
		
	$('#btnNuevo').click(function () {
		modalPersonaProceso(0);
	});

	$('#user_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#proceso_bus').keypress(function(e){
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

	$('#user_bus').select2({ width : ' 100% ' })
		
	datatablenew();

});

function datatablenew(){
                      
    var oTable1 = $('#tblPersonaProceso').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/persona_proceso/listar_persona_proceso_ajax",
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

            var user = $('#user_bus').val();
            var proceso = $('#proceso_bus').val();
			var estado = $('#estado_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						user:user,proceso:proceso,estado:estado,
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
					var proceso = "";
					if(row.proceso!= null)proceso = row.proceso;
					return proceso;
				},
				"bSortable": true,
				"aTargets": [1]
				},

				{
				"mRender": function (data, type, row) {
					var usuario = "";
					if(row.usuario!= null)usuario = row.usuario;
					return usuario;
				},
				"bSortable": true,
				"aTargets": [2]
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
				"aTargets": [3]
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
					
					html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalPersonaProceso('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>'; 
					html += '<a href="javascript:void(0)" onclick=eliminarPersonaProceso('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
					
					//html += '<a href="javascript:void(0)" onclick=modalResponsable('+row.id+') class="btn btn-sm btn-info" style="font-size:12px;margin-left:10px">Detalle Responsable</a>';
					
					html += '</div>';
					return html;
				},
				"bSortable": false,
				"aTargets": [4],
				},
            ]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};

function modalPersonaProceso(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
		url: "/persona_proceso/modal_persona_proceso/"+id,
		type: "GET",
		success: function (result) {  
			$("#diveditpregOpc").html(result);
			$('#openOverlayOpc').modal('show');
		}
	});
}

function eliminarPersonaProceso(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" el Registro?", 
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
		url: "/persona_proceso/eliminar_persona_proceso/"+id+"/"+estado,
		type: "GET",
		success: function (result) {
			//if(result="success")obtenerPlanDetalle(id_plan);
			datatablenew();
		}
    });
}
