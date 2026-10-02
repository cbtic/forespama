$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	/*$('#btnNuevo').click(function () {
		modalRetiroComision(0);
	});*/
	
	$('#numero_documento_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#estado_pago_bus').keypress(function(e){
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

	/*$('#example-select-all').on('click', function () {
		if ($(this).is(':checked')) {
			$('.mov').prop('checked', true);
		} else {
			$('.mov').prop('checked', false);
		}
	});*/

});

function datatablenew(){
                      
    var oTable1 = $('#tblAliadoPamaSolicitudComision').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/aliados_pama_comisiones/listar_aliados_pama_solicitud_comisiones_ajax",
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

		"fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
			$(nRow).attr('data-id', aData.id_persona);
		},
		
        "fnDrawCallback": function(json) {
            $('[data-toggle="tooltip"]').tooltip();
        },

        "fnServerData": function (sSource, aoData, fnCallback, oSettings) {

            var sEcho           = aoData[0].value;
            var iNroPagina 	= parseFloat(fn_util_obtieneNroPagina(aoData[3].value, aoData[4].value)).toFixed();
            var iCantMostrar 	= aoData[4].value;

            var numero_documento = $('#numero_documento_bus').val();
            var estado_pago = $('#estado_pago_bus').val();
            
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						numero_documento:numero_documento,estado_pago:estado_pago,
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
				/*{
					"mRender": function (data, type, row) {
						var html = '';
						html += '<input type="checkbox" class="mov" name="mov[]" value="' + row.id + '" />';
						return html;
					},
					"bSortable": false,
					"aTargets": [0],
					"className": "dt-center",
				},*/
				
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
					var numero_documento = "";
					if(row.numero_documento!= null)numero_documento = row.numero_documento;
					return numero_documento;
				},
				"bSortable": true,
				"aTargets": [1]
				},

				{
				"mRender": function (data, type, row) {
					var nombres = "";
					if(row.nombres!= null)nombres = row.nombres;
					return nombres;
				},
				"bSortable": true,
				"aTargets": [2]
				},

				{
				"mRender": function (data, type, row) {
					var monto = "";
					if(row.monto!= null)monto = row.monto;
					return monto;
				},
				"bSortable": true,
				"aTargets": [3]
				},

				{
				"mRender": function (data, type, row) {
					var estado_solicitud = "";
					if(row.estado_solicitud!= null)estado_solicitud = row.estado_solicitud;
					return estado_solicitud;
				},
				"bSortable": true,
				"aTargets": [4]
				},

				{
				"mRender": function (data, type, row) {
					var usuario_aprueba = "";
					if(row.usuario_aprueba!= null)usuario_aprueba = row.usuario_aprueba;
					return usuario_aprueba;
				},
				"bSortable": true,
				"aTargets": [5]
				},

				{
				"mRender": function (data, type, row) {
					var estado = "";
					var clase = "";
					
					var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
					
					if(row.id_estado_solicitud == 2){
						html += '<button style="font-size:12px;margin-left:10px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="aprobarSolicitud('+row.id+')" ><i class="fas fa-check-circle"></i> Aprobar</button>';
						html += '<button style="font-size:12px;margin-left:10px" type="button" class="btn btn-sm btn-danger" data-toggle="modal" onclick="rechazaraSolicitud('+row.id+')" ><i class="fas fa-undo"></i> Rechazar</button>';
					}
					if(row.id_estado_solicitud == 3){
						html += '<button style="font-size:12px;margin-left:10px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="aprobarPago('+row.id+')" ><i class="fas fa-money-bill-alt"></i> Pagar</button>';
					}
					//html += '<a href="javascript:void(0)" onclick=eliminarCentroCosto('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px"><i class="fa fa-eraser" style="font-size:18px;"></i> '+estado+'</a>';
					
					//html += '<a href="javascript:void(0)" onclick=modalResponsable('+row.id+') class="btn btn-sm btn-info" style="font-size:12px;margin-left:10px">Detalle Responsable</a>';
					
					html += '</div>';
					return html;
				},
				"bSortable": false,
				"aTargets": [6],
				},
            ]
    });
}

//fn_util_LineaDatatable("#tblAliadoPamaComision");

/*$('#tblAliadoPamaComision tbody').off('click.aliadoPama');

$('#tblAliadoPamaComision tbody').on('click.aliadoPama', 'tr', function(e) {
	
	if ($(e.target).closest('button').length > 0) {
        return;
    }

    $(this).toggleClass('row_selected');

    var cantidadSeleccionadas = $('#tblAliadoPamaComision tbody tr.row_selected').length;

    console.log('ID persona:', $(this).attr('data-id'));
    console.log('Cantidad seleccionadas:', cantidadSeleccionadas);

    $('#btnRetiroComision').prop('disabled', cantidadSeleccionadas === 0);
});*/

$('#tblAliadoPamaSolicitudComision').off('click.aliadoPama').on('click.aliadoPama', 'tbody tr', function(e) {

    if ($(e.target).closest('button').length > 0) {
        return;
    }

    $('#tblAliadoPamaSolicitudComision tbody tr').removeClass('row_selected');

    $(this).addClass('row_selected');

    var cantidadSeleccionadas = $('#tblAliadoPamaSolicitudComision tbody tr.row_selected').length;

    console.log('ID persona:', $(this).attr('data-id'));
    console.log('Cantidad seleccionadas:', cantidadSeleccionadas);

    $('#btnRetiroComision').prop('disabled', cantidadSeleccionadas === 0);
});

function fn_ListarBusqueda() {
    datatablenew();
};

function anularAliadoPamaComision(id,estado){
	var act_estado = "";
	if(estado==1){
		act_estado = "Anular";
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
		url: "/aliados_pama_comisiones/eliminar_aliados_pama_comisiones/"+id+"/"+estado,
		type: "GET",
		success: function (result) {
			//if(result="success")obtenerPlanDetalle(id_plan);
			datatablenew();
		}
    });
}

function aprobarSolicitud(id){

	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
	$('.loader').show();

	$.ajax({
		url: "/aliados_pama_comisiones/aprobar_aliados_pama_solicitud_comisiones/"+id,
		type: "GET",
		success: function (result) {
			$('.loader').hide();
			//if(result="success")obtenerPlanDetalle(id_plan);
			datatablenew();
		}
    });
}

function rechazaraSolicitud(id){

	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
	$('.loader').show();

	$.ajax({
		url: "/aliados_pama_comisiones/rechazar_aliados_pama_solicitud_comisiones/"+id,
		type: "GET",
		success: function (result) {
			$('.loader').hide();
			//if(result="success")obtenerPlanDetalle(id_plan);
			datatablenew();
		}
    });
}

function aprobarPago(id){

	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
	$('.loader').show();

	$.ajax({
		url: "/aliados_pama_comisiones/aprobar_aliados_pama_solicitud_pago/"+id,
		type: "GET",
		success: function (result) {
			$('.loader').hide();
			//if(result="success")obtenerPlanDetalle(id_plan);
			datatablenew();
		}
    });
}

function solicitarRetiroComision(){
    
	var mov = [];

    $('#tblAliadoPamaComision tbody tr.row_selected').each(function () {

        var id = $(this).data('id');

        if (id) {
            mov.push(id);
        }
    });

	console.log('Personas seleccionadas:', mov);

    if (mov.length === 0) {

        bootbox.alert({
            message: 'Debe seleccionar al menos una comisión.'
        });

        return;
    }

	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
	$('.loader').show();

	$.ajax({
		url: "/aliados_pama_comisiones/solicitar_retiro_comision_aliado_pama",
		data: {_token: $('#_token').val(),mov: mov},
		type: "POST",
		success: function (result) {
			$('.loader').hide();

            if(result.success){

                bootbox.alert({

                    message: result.message,

                    callback: function () {

                        $('#tblAliadoPamaComision tbody tr').removeClass('row_selected');
						
                        $('#btnRetiroComision').prop('disabled', true);

                        datatablenew();

                    }
                });
            }else{
                bootbox.alert({message: result.message});
            }
		}
	});
}

function modalDetalleComprobantes(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
		url: "/aliados_pama_comisiones/modal_detalle_comision_aliado_pama/"+id,
		type: "GET",
		success: function (result) {
			$("#diveditpregOpc").html(result);
			$('#openOverlayOpc').modal('show');
		}
	});
}
