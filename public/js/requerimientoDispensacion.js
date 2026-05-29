$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#btnNuevo').click(function () {
		modalRequerimientoDispensacion(0);
	});

	$('#tipo_documento_bus').keypress(function(e){
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

	$("#persona_recibe_bus").select2({ width: '100%' });

	$('#numero_dispensacion_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#almacen_bus').keypress(function(e){
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
		
	datatablenew();

	$('#btnDescargar').on('click', function () {
		descargarArchivosReporte();

	});

});

function datatablenew(){
                      
    var oTable1 = $('#tblRequerimientoDispensacion').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/requerimiento_dispensacion/listar_requerimiento_dispensacion_ajax",
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
			var fecha_inicio = $('#fecha_inicio_bus').val();
			var fecha_fin = $('#fecha_fin_bus').val();
			var numero_requerimiento_dispensacion = $('#numero_requerimiento_dispensacion_bus').val();
			var almacen = $('#almacen_bus').val();
			var sede = $('#sede_bus').val();
			var centro_costo = $('#centro_costo_bus').val();
			var persona_recibe = $('#persona_recibe_bus').val();
			var situacion = $('#situacion_bus').val();
			var estado = $('#estado_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						tipo_documento:tipo_documento,fecha_inicio:fecha_inicio,fecha_fin:fecha_fin,numero_requerimiento_dispensacion:numero_requerimiento_dispensacion,
						almacen:almacen,sede:sede,centro_costo:centro_costo,persona_recibe:persona_recibe,situacion:situacion,estado:estado,
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
				
				/*{
                "mRender": function (data, type, row) {
                	var ingreso = "";
					if(row.ingreso!= null)ingreso = row.ingreso;
					return ingreso;
                },
                "bSortable": true,
                "aTargets": [2]
                },*/
				
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
					var sede = "";
					if(row.sede!= null)sede = row.sede;
					return sede;
				},
				"bSortable": true,
				"aTargets": [5]
				},
				{
				"mRender": function (data, type, row) {
					var centro_costo = "";
					if(row.centro_costo!= null)centro_costo = row.centro_costo;
					return centro_costo;
				},
				"bSortable": true,
				"aTargets": [6]
				},
				{
				"mRender": function (data, type, row) {
					var persona = "";
					if(row.persona!= null)persona = row.persona;
					return persona;
				},
				"bSortable": true,
				"aTargets": [7]
				},
				{
				"mRender": function (data, type, row) {
					var persona_genera = "";
					if(row.persona_genera!= null)persona_genera = row.persona_genera;
					return persona_genera;
				},
				"bSortable": true,
				"aTargets": [8]
				},
				{
				"mRender": function (data, type, row) {
					var persona_aprueba = "";
					if(row.persona_aprueba!= null)persona_aprueba = row.persona_aprueba;
					return persona_aprueba;
				},
				"bSortable": true,
				"aTargets": [9]
				},
				{
				"mRender": function (data, type, row) {
					var codigo_requerimiento = "";
					if(row.codigo_requerimiento!= null)codigo_requerimiento = row.codigo_requerimiento;
					return codigo_requerimiento;
				},
				"bSortable": true,
				"aTargets": [10]
				},
				/*{
				"mRender": function (data, type, row) {
					var cerrado = "";
					if(row.cerrado!= null)cerrado = row.cerrado;
					return cerrado;
				},
				"bSortable": true,
				"aTargets": [8]
				},*/
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
					"aTargets": [11]
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
						
						html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalRequerimientoDispensacion('+row.id+')" ><i class="fa fa-edit"></i> Visualizar</button>'; 
						
						if(row.aprobado == 1 && row.cerrado == 1){
							html += '<button style="font-size:12px;margin-left:10px" type="button" class="btn btn-sm btn-info" data-toggle="modal" onclick="modalAtenderRequerimientoDispensacion('+row.id+')" ><i class="fa fa-edit"></i> Atender</button>';
						}else{
							html += '<button style="font-size:12px;margin-left:10px" type="button" class="btn btn-sm btn-info" data-toggle="modal" onclick="modalAtenderRequerimientoDispensacion('+row.id+')" disabled><i class="fa fa-edit"></i> Atender</button>';
						}
						//html += '<a href="javascript:void(0)" onclick=eliminarDispensacion('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';			
						
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [12],
				},
            ]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};

function modalRequerimientoDispensacion(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
		url: "/requerimiento_dispensacion/modal_requerimiento_dispensacion/"+id,
		type: "GET",
		success: function (result) {  
			$("#diveditpregOpc").html(result);
			$('#openOverlayOpc').modal('show');
		}
	});
}

function eliminarDispensacion(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" la Dispensacion?", 
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
            url: "/dispensacion/eliminar_dispensacion/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				datatablenew();
            }
    });
}

function obtenerUnidadTrabajo(){
    
    var area_trabajo = $('#area_trabajo_bus').val();
   
	$.ajax({
        url: "/dispensacion/obtener_unidad_trabajo/"+area_trabajo,
        dataType: "json",
        success: function(result){
            var option = "<option value='' selected='selected'>--Seleccionar Unidad Trabajo--</option>";
            $('#unidad_trabajo_bus').html("");
            $(result).each(function (ii, oo) {
              	option += "<option value='" + oo.id + "'>" + oo.denominacion + "</option>"; 
            });
            $('#unidad_trabajo_bus').html(option);
        }
    });
}

function descargarArchivosReporte(){
	
	var tipo_documento = $('#tipo_documento_bus').val();
	var fecha_inicio = $('#fecha_inicio_bus').val();
	var fecha_fin = $('#fecha_fin_bus').val();
	var numero_rq_dispensacion = $('#numero_requerimiento_dispensacion_bus').val();
	var almacen = $('#almacen_bus').val();
	var sede = $('#sede_bus').val();
	var centro_costo = $('#centro_costo_bus').val();
	var persona_recibe = $('#persona_recibe_bus').val();
	var situacion = $('#situacion_bus').val();
	var estado = $('#estado_bus').val();

	if (tipo_documento == "")tipo_documento = 0;
	if (fecha_inicio == "")fecha_inicio = "0";
	if (fecha_fin == "")fecha_fin = "0";
	if (numero_rq_dispensacion == "")numero_rq_dispensacion = "0";
	if (almacen == "")almacen = 0;
	if (sede == "")sede = 0;
	if (centro_costo == "")centro_costo = 0;
	if (persona_recibe == "")persona_recibe = 0;
	if (situacion == "")situacion = 0;
	if (estado == "")estado = 0;
	
	location.href = '/requerimiento_dispensacion/exportar_listar_requerimiento_dispensacion_reporte/'+tipo_documento+'/'+fecha_inicio+'/'+fecha_fin+'/'+numero_rq_dispensacion+'/'+almacen+'/'+sede+'/'+centro_costo+'/'+persona_recibe+'/'+situacion+'/'+estado;
}

function modalAtenderRequerimientoDispensacion(id){
	
	$(".modal-dialog").css("width","95%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
		url: "/requerimiento_dispensacion/modal_atender_requerimiento_dispensacion/"+id,
		type: "GET",
		success: function (result) {
			$("#diveditpregOpc").html(result);
			$('#openOverlayOpc').modal('show');
		}
	});
}

function obtenerCentroCosto(){

    var sede = $('#sede_bus').val();
    //var selectedUnidad = "<?php echo isset($requerimiento_dispensacion->id_centro_costo) ? $requerimiento_dispensacion->id_centro_costo : ''; ?>";

    $.ajax({
        url: "/centro_costo/obtener_centro_costo/"+sede,
        dataType: "json",
        success: function(result){
            var option = "<option value='' selected='selected'>--Seleccionar--</option>";
            var option;
            $('#centro_costo_bus').html("");
            $(result).each(function (ii, oo) {
                
                option += "<option value='"+oo.id+"'>"+oo.codigo +" - "+oo.denominacion+"</option>";
                
            });
            $('#centro_costo_bus').html(option);
            $('#centro_costo_bus').select2({ width: '100%' });
        }
    });
}
