$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#btnNuevoIngreso').click(function () {
		modalIngresoAcerradoMadera(0);
	});

	$('#btnNuevoSalida').click(function () {
		modalSalidaAcerradoMadera(0);
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
	datatablenew2();

	$('#fecha_bus').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

});

function datatablenew(){
                      
    var oTable1 = $('#tblAcerradoMaderaCreate').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/acerrado_madera/listar_ingreso_produccion_acerrado_madera_ajax",
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
						var fecha_ingreso = "";
						if(row.fecha_ingreso!= null)fecha_ingreso = row.fecha_ingreso;
						return fecha_ingreso;
					},
					"bSortable": true,
					"aTargets": [1]
				},

				{
					"mRender": function (data, type, row) {
						var ruc = "";
						if(row.ruc!= null)ruc = row.ruc;
						return ruc;
					},
					"bSortable": true,
					"aTargets": [2]
				},

				{
					"mRender": function (data, type, row) {
						var razon_social = "";
						if(row.razon_social!= null)razon_social = row.razon_social;
						return razon_social;
					},
					"bSortable": true,
					"aTargets": [3]
				},

				{
					"mRender": function (data, type, row) {
						var placa = "";
						if(row.placa!= null)placa = row.placa;
						return placa;
					},
					"bSortable": true,
					"aTargets": [4]
				},

				{
					"mRender": function (data, type, row) {
						var tipo_madera = "";
						if(row.tipo_madera!= null)tipo_madera = row.tipo_madera;
						return tipo_madera;
					},
					"bSortable": true,
					"aTargets": [5]
				},

				{
					"mRender": function (data, type, row) {
						var cantidad_ingreso_tronco = "";
						if(row.cantidad_ingreso_tronco!= null)cantidad_ingreso_tronco = row.cantidad_ingreso_tronco;
						return cantidad_ingreso_tronco;
					},
					"bSortable": true,
					"aTargets": [6]
				},
				
				/*{
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
					"aTargets": [7]
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
						
						html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalAcerradoMadera('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>'; 
						
						//html += '<a href="javascript:void(0)" onclick=eliminarEquivalenciaProducto('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';			
						
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [4],
				},*/
            ]
    });
}

function datatablenew2(){
                      
    var oTable1 = $('#tblProduccionMaderaAcerradaCreate').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/acerrado_madera/listar_produccion_acerrado_madera_ajax",
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
						var fecha_produccion = "";
						if(row.fecha_produccion!= null)fecha_produccion = row.fecha_produccion;
						return fecha_produccion;
					},
					"bSortable": true,
					"aTargets": [1]
				},

				{
					"mRender": function (data, type, row) {
						var tipo_madera = "";
						if(row.tipo_madera!= null)tipo_madera = row.tipo_madera;
						return tipo_madera;
					},
					"bSortable": true,
					"aTargets": [2]
				},

				{
					"mRender": function (data, type, row) {
						var medida = "";
						if(row.medida!= null)medida = row.medida;
						return medida;
					},
					"bSortable": true,
					"aTargets": [3]
				},

				{
					"mRender": function (data, type, row) {
						var cantidad_paquetes = "";
						if(row.cantidad_paquetes!= null)cantidad_paquetes = row.cantidad_paquetes;
						return cantidad_paquetes;
					},
					"bSortable": true,
					"aTargets": [4]
				},

				{
					"mRender": function (data, type, row) {
						var medida1_paquete = "";
						if(row.medida1_paquete!= null)medida1_paquete = row.medida1_paquete;
						return medida1_paquete;
					},
					"bSortable": true,
					"aTargets": [5]
				},

				{
					"mRender": function (data, type, row) {
						var medida2_paquete = "";
						if(row.medida2_paquete!= null)medida2_paquete = row.medida2_paquete;
						return medida2_paquete;
					},
					"bSortable": true,
					"aTargets": [6]
				},

				{
					"mRender": function (data, type, row) {
						var total_n_piezas = "";
						if(row.total_n_piezas!= null)total_n_piezas = row.total_n_piezas;
						return total_n_piezas;
					},
					"bSortable": true,
					"aTargets": [7]
				},
				
				/*{
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
						
						html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalAcerradoMadera('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>'; 
						
						//html += '<a href="javascript:void(0)" onclick=eliminarEquivalenciaProducto('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';			
						
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [4],
				},*/
            ]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
    datatablenew2();
};

function modalIngresoAcerradoMadera(id){

	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/acerrado_madera/modal_ingreso_acerrado_madera/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});
}

function modalSalidaAcerradoMadera(id){

	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/acerrado_madera/modal_salida_acerrado_madera/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});
}
function eliminarEquivalenciaProducto(id,estado){
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
            url: "/equivalencia_producto/eliminar_equivalencia_producto/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				datatablenew();
            }
    });
}
