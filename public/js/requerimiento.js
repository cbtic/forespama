$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#btnNuevo').click(function () {
		modalRequerimiento(0);
	});

	$('#tipo_documento_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#empresa_compra_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#empresa_vende_bus').keypress(function(e){
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

	$('#numero_orden_compra_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#situacion_bus').keypress(function(e){
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

	$('#denominacion_producto_bus').keypress(function(e){
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
		descargarArchivosRequerimiento();

	});

	$('#btnDescargarReporte').on('click', function () {
		descargarArchivosRequerimientoReporte();

	});

	$('#producto_bus').select2({ width :'100%'})

});

$(function() {
    $('.mayusculas').keyup(function() {
        this.value = this.value.toUpperCase();
    });
});

function datatablenew(){
                      
    var oTable1 = $('#tblRequerimiento').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/requerimiento/listar_requerimiento_ajax",
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

		"fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

            const fechaRequerimiento = aData.fecha;
            if (fechaRequerimiento) {
                const fechaActual = new Date();
                const fechaItem = new Date(fechaRequerimiento);
                const diferenciaDias = (fechaActual - fechaItem) / (1000 * 60 * 60 * 24);

                if (diferenciaDias > 5) {
                    $(nRow).addClass('fila-roja');
                }
            }
            return nRow;
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
			var tipo_requerimiento = $('#tipo_requerimiento_bus').val();
			var estado = $('#estado_bus').val();
			var producto = $('#producto_bus').val();
			var denominacion_producto = $('#denominacion_producto_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						tipo_documento:tipo_documento,fecha:fecha,numero_requerimiento:numero_requerimiento,almacen:almacen,
						situacion:situacion,estado:estado,responsable_atencion:responsable_atencion,estado_atencion:estado_atencion,
						tipo_requerimiento:tipo_requerimiento,producto:producto,denominacion_producto:denominacion_producto,
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
						var tipo_requerimiento = "";
						if(row.tipo_requerimiento!= null)tipo_requerimiento = row.tipo_requerimiento;
						return tipo_requerimiento;
					},
					"bSortable": true,
					"aTargets": [8]
				},

				{
					"mRender": function (data, type, row) {
						var usuario_inserta = "";
						if(row.usuario_inserta!= null)usuario_inserta = row.usuario_inserta;
						return usuario_inserta;
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
						
						//if(row.estado_solicitud == 1){
						html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalRequerimiento('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>'; 
						//}else{
						//	html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalRequerimiento('+row.id+')" disabled><i class="fa fa-edit"></i> Editar</button>'; 	
						//}

						if(usuario == row.id_responsable){	
							html += '<button style="font-size:12px;margin-left:10px" type="button" class="btn btn-sm btn-info" data-toggle="modal" onclick="modalAtenderRequerimiento('+row.id+')" ><i class="fa fa-edit"></i> Atender</button>'; 
						}else{
							html += '<button style="font-size:12px;margin-left:10px" type="button" class="btn btn-sm btn-info" data-toggle="modal" onclick="modalAtenderRequerimiento('+row.id+')" disabled><i class="fa fa-edit"></i> Atender</button>'; 	
						}

						html += '<button style="font-size:12px; margin-left:10px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalControlProductos('+row.id+')">Control Productos</button>';  
						
						if((row.id_estado_atencion == 1 || row.id_estado_atencion == 2) && (usuario == 1 || usuario == 38)){
							html += '<a href="javascript:void(0)" onclick=eliminarRequerimiento('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>'; 
						}else{
							html += '<a href="javascript:void(0)" onclick=eliminarRequerimiento('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px; pointer-events: none; opacity: 0.6; cursor: not-allowed;">'+estado+'</a>'; 	
						}

						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [11],
				},
            ]
    });
}

fn_util_LineaDatatable("#tblRequerimiento");

$('#tblRequerimiento tbody').on('click', 'tr', function () {
	
});

function fn_ListarBusqueda() {
    datatablenew();
};

function modalRequerimiento(id){
	
	/*var tipo_mov="";
	if(tipo=='INGRESO'){tipo_mov=1};
	if(tipo=='SALIDA'){tipo_mov=2};*/

	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/requerimiento/modal_requerimiento/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});
}

function modalAtenderRequerimiento(id){
	
	/*var tipo_mov="";
	if(tipo=='INGRESO'){tipo_mov=1};
	if(tipo=='SALIDA'){tipo_mov=2};*/

	$(".modal-dialog").css("width","95%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/requerimiento/modal_atender_requerimiento/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});
}

function eliminarRequerimiento(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" el Requerimiento?", 
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
            url: "/requerimiento/eliminar_requerimiento/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				datatablenew();
            }
    });
}

function descargarArchivosRequerimiento(){
		
	var tipo_documento = $('#tipo_documento_bus').val();
	var fecha = $('#fecha_bus').val();
	var numero_requerimiento = $('#numero_requerimiento_bus').val();
	var almacen = $('#almacen_bus').val();
	var situacion = $('#situacion_bus').val();
	var responsable_atencion = $('#responsable_atencion_bus').val();
	var estado_atencion = $('#estado_atencion_bus').val();
	var tipo_requerimiento = $('#tipo_requerimiento_bus').val();
	var estado = $('#estado_bus').val();
	var producto = $('#producto_bus').val();
	var denominacion_producto = $('#denominacion_producto_bus').val();
	//var id_agremiado = 0;
	//var id_regional = 0;
	if (tipo_documento == "")tipo_documento = 0;
	if (fecha == "")fecha = "0";
	if (numero_requerimiento == "")numero_requerimiento = "0";
	if (almacen == "")almacen = 0;
	if (situacion == "")situacion = 0;
	if (responsable_atencion == "")responsable_atencion = 0;
	if (estado_atencion == "")estado_atencion = 0;
	if (tipo_requerimiento == "")tipo_requerimiento = 0;
	if (estado == "")estado = 0;
	if (producto == "")producto = 0;
	if (denominacion_producto == "")denominacion_producto = "0";

	//if (campo == "")campo = 0;
	//if (orden == "")orden = 0;
	
	location.href = '/requerimiento/exportar_listar_requerimiento/'+tipo_documento+'/'+fecha+'/'+numero_requerimiento+'/'+almacen+'/'+situacion+'/'+responsable_atencion+'/'+estado_atencion+'/'+tipo_requerimiento+'/'+estado+'/'+producto+'/'+denominacion_producto;
}

function descargarArchivosRequerimientoReporte(){
		
	var tipo_documento = $('#tipo_documento_bus').val();
	var fecha = $('#fecha_bus').val();
	var numero_requerimiento = $('#numero_requerimiento_bus').val();
	var almacen = $('#almacen_bus').val();
	var situacion = $('#situacion_bus').val();
	var responsable_atencion = $('#responsable_atencion_bus').val();
	var estado_atencion = $('#estado_atencion_bus').val();
	var tipo_requerimiento = $('#tipo_requerimiento_bus').val();
	var estado = $('#estado_bus').val();
	var producto = $('#producto_bus').val();
	var denominacion_producto = $('#denominacion_producto_bus').val();

	if (tipo_documento == "")tipo_documento = 0;
	if (fecha == "")fecha = "0";
	if (numero_requerimiento == "")numero_requerimiento = "0";
	if (almacen == "")almacen = 0;
	if (situacion == "")situacion = 0;
	if (responsable_atencion == "")responsable_atencion = 0;
	if (estado_atencion == "")estado_atencion = 0;
	if (tipo_requerimiento == "")tipo_requerimiento = 0;
	if (estado == "")estado = 0;
	if (producto == "")producto = 0;
	if (denominacion_producto == "")denominacion_producto = "0";
	
	location.href = '/requerimiento/exportar_listar_requerimiento_reporte/'+tipo_documento+'/'+fecha+'/'+numero_requerimiento+'/'+almacen+'/'+situacion+'/'+responsable_atencion+'/'+estado_atencion+'/'+tipo_requerimiento+'/'+estado+'/'+producto+'/'+denominacion_producto;
}

function modalControlProductos(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/requerimiento/modal_control_requerimiento/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});
}