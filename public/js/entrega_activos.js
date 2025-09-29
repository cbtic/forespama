$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
	
	$('#btnNuevo').click(function () {
		modalEntregaActivo(0);
	});

	$('#descripcion_bus').keypress(function(e){
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
    
    var oTable1 = $('#tblEntregaActivos').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/activos/listar_entrega_activos_ajax",
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

            var persona = $('#persona_bus').val();
            var descripcion = $('#descripcion_bus').val();
			var estado = $('#estado_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						persona:persona,descripcion:descripcion,estado:estado,
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
					var persona = "";
					if(row.persona!= null)persona = row.persona;
					return persona;
				},
				"bSortable": true,
				"aTargets": [1]
				},

				{
				"mRender": function (data, type, row) {
					var numero_documento = "";
					if(row.numero_documento!= null)numero_documento = row.numero_documento;
					return numero_documento;
				},
				"bSortable": true,
				"aTargets": [2]
				},

				{
				"mRender": function (data, type, row) {
					var descripcion = "";
					if(row.descripcion!= null)descripcion = row.descripcion;
					return descripcion;
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
					var modelo = "";
					if(row.modelo!= null)modelo = row.modelo;
					return modelo;
				},
				"bSortable": true,
				"aTargets": [5]
				},

				{
				"mRender": function (data, type, row) {
					var fecha_entrega = "";
					if(row.fecha_entrega!= null)fecha_entrega = row.fecha_entrega;
					return fecha_entrega;
				},
				"bSortable": true,
				"aTargets": [6]
				},

				{
				"mRender": function (data, type, row) {
					var fecha_devolucion = "";
					if(row.fecha_devolucion!= null)fecha_devolucion = row.fecha_devolucion;
					return fecha_devolucion;
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
						
						html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalEntregaActivo('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>'; 
						html += '<a href="javascript:void(0)" onclick=eliminarEntregaActivo('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:11px;margin-left:5px">'+estado+'</a>';
						
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

function modalEntregaActivo(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
		url: "/activos/modal_entrega_activos/"+id,
		type: "GET",
		success: function (result) {
			$("#diveditpregOpc").html(result);
			$('#openOverlayOpc').modal('show');
		}
	});
}

function eliminarEntregaActivo(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" la Entrega de Activo?",
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
            url: "/activos/eliminar_entrega_activo/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
				datatablenew();
            }
    });
}
