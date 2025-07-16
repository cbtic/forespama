$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#btnNuevoIngreso').click(function () {
		modalIngresoHorno(0);
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

	$('#fecha_bus').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

});

function datatablenew(){
    
    var oTable1 = $('#tblIngresoHornoCreate').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/horno/listar_ingreso_horno_ajax",
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

function fn_ListarBusqueda() {
    datatablenew();
};

function modalIngresoHorno(id){

	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/horno/modal_ingreso_horno/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});
}
