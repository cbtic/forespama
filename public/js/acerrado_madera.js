$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#btnNuevo').click(function () {
		modalAcerradoMadera(0);
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

});

function datatablenew(){
                      
    var oTable1 = $('#tblAcerradoMadera').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/acerrado_madera/listar_acerrado_madera_ajax",
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
			
            var producto = $('#producto_bus').val();
			var codigo_producto = $('#codigo_producto_bus').val();
			var descripcion_producto = $('#descripcion_producto_bus').val();
			var empresa = $('#empresa_bus').val();
			var codigo_empresa = $('#codigo_empresa_bus').val();
			var descripcion_empresa = $('#descripcion_empresa_bus').val();
			var estado = $('#estado_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						producto:producto,codigo_producto:codigo_producto,descripcion_producto:descripcion_producto,
						empresa:empresa,codigo_empresa:codigo_empresa,descripcion_empresa:descripcion_empresa,
						estado:estado,_token:_token
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
						var producto = "";
						if(row.producto!= null)producto = row.producto;
						return producto;
					},
					"bSortable": true,
					"aTargets": [1]
				},

				{
					"mRender": function (data, type, row) {
						var codigo_producto = "";
						if(row.codigo_producto!= null)codigo_producto = row.codigo_producto;
						return codigo_producto;
					},
					"bSortable": true,
					"aTargets": [2]
				},
				{
					"mRender": function (data, type, row) {
						var empresa = "";
						if(row.empresa!= null)empresa = row.empresa;
						return empresa;
					},
					"bSortable": true,
					"aTargets": [3]
				},

				{
					"mRender": function (data, type, row) {
						var codigo_empresa = "";
						if(row.codigo_empresa!= null)codigo_empresa = row.codigo_empresa;
						return codigo_empresa;
					},
					"bSortable": true,
					"aTargets": [4]
				},

				{
					"mRender": function (data, type, row) {
						var descripcion_empresa = "";
						if(row.descripcion_empresa!= null)descripcion_empresa = row.descripcion_empresa;
						return descripcion_empresa;
					},
					"bSortable": true,
					"aTargets": [5]
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
					"aTargets": [6]
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
					"aTargets": [7],
				},
            ]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};

function modalAcerradoMadera(id){
	
	/*var tipo_mov="";
	if(tipo=='INGRESO'){tipo_mov=1};
	if(tipo=='SALIDA'){tipo_mov=2};*/

	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/acerrado_madera/modal_acerrado_madera/"+id,
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
