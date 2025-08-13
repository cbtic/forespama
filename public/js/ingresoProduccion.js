$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#btnNuevo').click(function () {
		modalIngresoProduccion(0);
	});

	$('#tipo_documento_bus').keypress(function(e){
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

	$('#numero_ingreso_produccion_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#almacen_destino_bus').keypress(function(e){
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

	$('#btnDescargar').on('click', function () {
		descargarArchivosIngresoProduccion();
	});

});

function datatablenew(){
                      
    var oTable1 = $('#tblIngresoProduccion').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/ingreso_produccion/listar_ingreso_produccion_ajax",
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
			var numero_ingreso_produccion = $('#numero_ingreso_produccion_bus').val();
			var almacen_destino = $('#almacen_destino_bus').val();
			var area = $('#area_bus').val();
			var estado = $('#estado_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina, NumeroRegistros:iCantMostrar,
						tipo_documento:tipo_documento, fecha:fecha, numero_ingreso_produccion:numero_ingreso_produccion,
						almacen_destino:almacen_destino, area:area, estado:estado,
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
						var numero_ingreso_produccion = "";
						if(row.numero_ingreso_produccion!= null)numero_ingreso_produccion = row.numero_ingreso_produccion;
						return numero_ingreso_produccion;
					},
					"bSortable": true,
					"aTargets": [3]
				},
				{
					"mRender": function (data, type, row) {
						var almacen_destino = "";
						if(row.almacen_destino!= null)almacen_destino = row.almacen_destino;
						return almacen_destino;
					},
					"bSortable": true,
					"aTargets": [4]
				},
				{
					"mRender": function (data, type, row) {
						var usuario_ingreso = "";
						if(row.usuario_ingreso!= null)usuario_ingreso = row.usuario_ingreso;
						return usuario_ingreso;
					},
					"bSortable": true,
					"aTargets": [5]
				},

				{
					"mRender": function (data, type, row) {
						var area = "";
						if(row.area!= null)area = row.area;
						return area;
					},
					"bSortable": true,
					"aTargets": [6]
				},

				{
					"mRender": function (data, type, row) {
						var codigo_orden_produccion = "";
						if(row.codigo_orden_produccion!= null)codigo_orden_produccion = row.codigo_orden_produccion;
						return codigo_orden_produccion;
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
						
						html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalIngresoProduccion('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>'; 
						
						//html += '<a href="javascript:void(0)" onclick=eliminarDispensacion('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';			
						
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

function modalIngresoProduccion(id){
	
	/*var tipo_mov="";
	if(tipo=='INGRESO'){tipo_mov=1};
	if(tipo=='SALIDA'){tipo_mov=2};*/

	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/ingreso_produccion/modal_ingreso_produccion/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});
}

function eliminarIngresoProduccion(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" el ingreso?", 
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
            url: "/ingreso_produccion/eliminar_ingreso_produccion/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				datatablenew();
            }
    });
}

function descargarArchivosIngresoProduccion(){
		
	var tipo_documento = $('#tipo_documento_bus').val();
	var fecha = $('#fecha_bus').val();
	var numero_ingreso_produccion = $('#numero_ingreso_produccion_bus').val();
	var almacen_destino = $('#almacen_destino_bus').val();
	var area = $('#area_bus').val();
	var estado = $('#estado_bus').val();

	if (tipo_documento == "")tipo_documento = 0;
	if (fecha == "")fecha = "0";
	if (numero_ingreso_produccion == "")numero_ingreso_produccion = "0";
	if (almacen_destino == "")almacen_destino = 0;
	if (area == "")area = 0;
	if (estado == "")estado = 0;
	
	location.href = '/ingreso_produccion/exportar_listar_ingreso_produccion/'+tipo_documento+'/'+fecha+'/'+numero_ingreso_produccion+'/'+almacen_destino+'/'+area+'/'+estado;
}
