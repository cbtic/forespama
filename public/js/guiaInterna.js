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

	$('#empresa_transporte_bus').select2({ width: '100%'})

	$('#empresa_bus').select2({ width: '100%'})
	
	$('#persona_bus').select2({ width: '100%'})

});

function datatablenew(){
    
    var oTable1 = $('#tblGuia').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/guia_interna/listar_guia_interna_ajax",
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
            var numero_guia = $('#numero_guia_bus').val();
			var numero_documento = $('#numero_documento_bus').val();
			var empresa = $('#empresa_bus').val();
			var persona = $('#persona_bus').val();
			var placa = $('#placa_bus').val();
			var empresa_transporte = $('#empresa_transporte_bus').val();
			var estado = $('#estado_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						fecha:fecha,numero_guia:numero_guia,numero_documento:numero_documento,
						empresa:empresa,persona:persona,placa:placa,empresa_transporte:empresa_transporte,estado:estado,
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
						var serie_numero = "";
						if(row.guia_serie!= null && row.guia_numero!= null)serie_numero = row.guia_serie + '-' +row.guia_numero;
						return serie_numero;
					},
					"bSortable": true,
					"aTargets": [1]
				},

				{
					"mRender": function (data, type, row) {
						var fecha_emision = "";
						if(row.fecha_emision!= null)fecha_emision = row.fecha_emision;
						return fecha_emision;
					},
					"bSortable": true,
					"aTargets": [2]
				},

				{
					"mRender": function (data, type, row) {
						var tipo_documento = "";
						if(row.tipo_documento!= null)tipo_documento = row.tipo_documento;
						return tipo_documento;
					},
					"bSortable": true,
					"aTargets": [3]
				},
				{
					"mRender": function (data, type, row) {
						var numero_documento = "";
						if(row.numero_documento!= null)numero_documento = row.numero_documento;
						return numero_documento;
					},
					"bSortable": true,
					"aTargets": [4]
				},
				{
					"mRender": function (data, type, row) {
						var destinatario = "";
						if(row.destinatario!= null)destinatario = row.destinatario;
						return destinatario;
					},
					"bSortable": true,
					"aTargets": [5]
				},
				{
					"mRender": function (data, type, row) {
						var placa = "";
						if(row.placa!= null)placa = row.placa;
						return placa;
					},
					"bSortable": true,
					"aTargets": [6]
				},

				{
					"mRender": function (data, type, row) {
						var id_transporte = "";
						if(row.id_transporte!= null)id_transporte = row.id_transporte;
						return id_transporte;
					},
					"bSortable": true,
					"aTargets": [7]
				},

				{
					"mRender": function (data, type, row) {
						var punto_partida = "";
						if(row.punto_partida!= null)punto_partida = row.punto_partida;
						return punto_partida;
					},
					"bSortable": true,
					"aTargets": [8]
				},

				{
					"mRender": function (data, type, row) {
						var punto_llegada = "";
						if(row.punto_llegada!= null)punto_llegada = row.punto_llegada;
						return punto_llegada;
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
						
						html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalGuia('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>'; 
						
						html += '<a href="javascript:void(0)" onclick=eliminarGuia('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px"><i class="fa fa-eraser"></i>'+estado+'</a>'; 
						
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [11],
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
			url: "/guia_interna/modal_guia_interna/"+id,
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
            url: "/guia_interna/eliminar_guia_interna/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				datatablenew();
            }
    });
}
