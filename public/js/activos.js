$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
		
	$('#btnNuevo').click(function () {
		modalActivo(0);
	});

	$('#denominacion_bus').keypress(function(e){
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

	$('#placa_bus').mask('AAA-000');

});

$(function() {
    $('.mayusculas').keyup(function() {
        this.value = this.value.toUpperCase();
    });
});

function datatablenew(){
                      
    var oTable1 = $('#tblActivos').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/activos/listar_activos_ajax",
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

            var tipo_activo = $('#tipo_activo_bus').val();
            var descripcion = $('#descripcion_bus').val();
            var placa = $('#placa_bus').val();
			var estado = $('#estado_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						tipo_activo:tipo_activo,descripcion:descripcion,placa:placa,estado:estado,
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
					var ubigeo = "";
					if(row.ubigeo!= null)ubigeo = row.ubigeo;
					return ubigeo;
				},
				"bSortable": true,
				"aTargets": [1]
				},

				{
				"mRender": function (data, type, row) {
					var direccion = "";
					if(row.direccion!= null)direccion = row.direccion;
					return direccion;
				},
				"bSortable": true,
				"aTargets": [2]
				},

				{
				"mRender": function (data, type, row) {
					var tipo_activo = "";
					if(row.tipo_activo!= null)tipo_activo = row.tipo_activo;
					return tipo_activo;
				},
				"bSortable": true,
				"aTargets": [3]
				},

				{
				"mRender": function (data, type, row) {
					var descripcion = "";
					if(row.descripcion!= null)descripcion = row.descripcion;
					return descripcion;
				},
				"bSortable": true,
				"aTargets": [4]
				},

				{
				"mRender": function (data, type, row) {
					var placa = "";
					if(row.placa!= null)placa = row.placa;
					return placa;
				},
				"bSortable": true,
				"aTargets": [5]
				},

				{
				"mRender": function (data, type, row) {
					var modelo = "";
					if(row.modelo!= null)modelo = row.modelo;
					return modelo;
				},
				"bSortable": true,
				"aTargets": [6]
				},

				{
				"mRender": function (data, type, row) {
					var serie = "";
					if(row.serie!= null)serie = row.serie;
					return serie;
				},
				"bSortable": true,
				"aTargets": [7]
				},

				{
				"mRender": function (data, type, row) {
					var marca = "";
					if(row.marca!= null)marca = row.marca;
					return marca;
				},
				"bSortable": true,
				"aTargets": [8]
				},

				{
				"mRender": function (data, type, row) {
					var color = "";
					if(row.color!= null)color = row.color;
					return color;
				},
				"bSortable": true,
				"aTargets": [9]
				},

				{
				"mRender": function (data, type, row) {
					var titulo = "";
					if(row.titulo!= null)titulo = row.titulo;
					return titulo;
				},
				"bSortable": true,
				"aTargets": [10]
				},

				{
				"mRender": function (data, type, row) {
					var partida_registral = "";
					if(row.partida_registral!= null)partida_registral = row.partida_registral;
					return partida_registral;
				},
				"bSortable": true,
				"aTargets": [11]
				},

				{
				"mRender": function (data, type, row) {
					var partida_circulacion = "";
					if(row.partida_circulacion!= null)partida_circulacion = row.partida_circulacion;
					return partida_circulacion;
				},
				"bSortable": true,
				"aTargets": [12]
				},

				{
				"mRender": function (data, type, row) {
					var vigencia_circulacion = "";
					if(row.vigencia_circulacion!= null)vigencia_circulacion = row.vigencia_circulacion;
					return vigencia_circulacion;
				},
				"bSortable": true,
				"aTargets": [13]
				},

				{
				"mRender": function (data, type, row) {
					var fecha_vencimiento_soat = "";
					if(row.fecha_vencimiento_soat!= null)fecha_vencimiento_soat = row.fecha_vencimiento_soat;
					return fecha_vencimiento_soat;
				},
				"bSortable": true,
				"aTargets": [14]
				},

				{
				"mRender": function (data, type, row) {
					var fecha_vencimiento_revision_tecnica = "";
					if(row.fecha_vencimiento_revision_tecnica!= null)fecha_vencimiento_revision_tecnica = row.fecha_vencimiento_revision_tecnica;
					return fecha_vencimiento_revision_tecnica;
				},
				"bSortable": true,
				"aTargets": [15]
				},
				
				{
				"mRender": function (data, type, row) {
					var valor_libros = "";
					if(row.valor_libros!= null)valor_libros = parseFloat(row.valor_libros).toFixed(2);
					return valor_libros;
				},
				"bSortable": true,
				"aTargets": [16]
				},

				{
				"mRender": function (data, type, row) {
					var valor_comercial = "";
					if(row.valor_comercial!= null)valor_comercial = parseFloat(row.valor_comercial).toFixed(2);
					return valor_comercial;
				},
				"bSortable": true,
				"aTargets": [17]
				},

				{
				"mRender": function (data, type, row) {
					var tipo_combustible = "";
					if(row.tipo_combustible!= null)tipo_combustible = row.tipo_combustible;
					return tipo_combustible;
				},
				"bSortable": true,
				"aTargets": [18]
				},

				{
				"mRender": function (data, type, row) {
					var dimensiones = "";
					if(row.dimensiones!= null)dimensiones = row.dimensiones;
					return dimensiones;
				},
				"bSortable": true,
				"aTargets": [19]
				},

				{
				"mRender": function (data, type, row) {
					var estado_activo = "";
					if(row.estado_activo!= null)estado_activo = row.estado_activo;
					return estado_activo;
				},
				"bSortable": true,
				"aTargets": [20]
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
				"aTargets": [21]
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
						
						html += '<button style="font-size:11px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalActivo('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>'; 
						html += '<a href="javascript:void(0)" onclick=eliminarActivo('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:11px;margin-left:5px">'+estado+'</a>';
						
						//html += '<a href="javascript:void(0)" onclick=modalResponsable('+row.id+') class="btn btn-sm btn-info" style="font-size:12px;margin-left:10px">Detalle Responsable</a>';
						
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [22],
				},

            ]


    });

}

function fn_ListarBusqueda() {
    datatablenew();
};

function modalActivo(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/activos/modal_activos_horno/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});
}

function eliminarActivo(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" el Activo?", 
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
            url: "/activos/eliminar_activo/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
				datatablenew();
            }
    });
}
