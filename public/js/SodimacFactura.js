//alert("ok");
//jQuery.noConflict(true);

$(document).ready(function () {

	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
    
	datatablenew();

	$('#fecha_ini').datepicker({
        autoclose: true,
		format: 'dd-mm-yyyy',
		changeMonth: true,
		changeYear: true,
    });

	$('#fecha_fin').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
		changeMonth: true,
		changeYear: true,
    });

	$('#fecha_inicio_desde').datepicker({
        autoclose: true,
		format: 'dd-mm-yyyy',
		changeMonth: true,
		changeYear: true,
    });

	$('#fecha_inicio_hasta').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
		changeMonth: true,
		changeYear: true,
    });

	/*
    $('#tblAlquiler').dataTable({
    	"language": {
    	"emptyTable": "No se encontraron resultados"
    	}
	});
	*/
	/*
	$('#tblAlquiler').dataTable( {
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningun dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "ultimo",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                },
                "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        } );
	*/


	$(function() {
		$('#modalPersonaForm #apellido_paterno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalPersonaForm #apellido_materno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalPersonaForm #nombres').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});


	$(function() {
		$('#modalPersonaTitularForm #apellido_paterno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalPersonaTitularForm #apellido_materno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalPersonaTitularForm #nombres').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
});


function datatablenew(){

    var oTable1 = $('#tblFacturacionSodimac').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/comprobante/listar_factura_sodimac_ajax",
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

			var fecha_ini = $('#fecha_ini').val();
            var fecha_fin = $('#fecha_fin').val();
			var tipo_documento = $('#tipo_documento').val();
            var serie = $('#serie').val();
            var numero = $('#numero').val();
            var estado = 1;
            
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						fecha_ini:fecha_ini,fecha_fin:fecha_fin,tipo_documento:tipo_documento, estado:estado,
                        serie:serie, numero:numero, _token:_token
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
                    var empresa = "";
					if(row.empresa!= null)empresa = row.empresa;
					return empresa;
                },
                "bSortable": false,
                "aTargets": [1]
                },
                {
                "mRender": function (data, type, row) {
					var medio_pago = "";
					if(row.medio_pago!= null)medio_pago = row.medio_pago;
					return medio_pago;
                },
                "bSortable": false,
                //"className": "dt-center",
                "aTargets": [2],
                },
                {
                "mRender": function (data, type, row) {
                    var banco = "";
                    if(row.banco!= null)banco = row.banco;
                    return banco;
                },
                "bSortable": false,
                //"className": "dt-center",
                "aTargets": [3],
                },
				{
                "mRender": function (data, type, row) {
                    var fecha_pago = "";
					if(row.fecha_pago!= null)fecha_pago = row.fecha_pago;
					return fecha_pago;
                },
                "bSortable": false,
                "aTargets": [4],
				"className": 'control'
                },
				{
                "mRender": function (data, type, row) {
                    var total_pagado = "";
                    if(row.total_pagado!= null)total_pagado = parseFloat(row.total_pagado).toFixed(2);
                    return total_pagado;
                },
                "bSortable": false,
                "aTargets": [5],
                "className": "text-right"
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
							
                        html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalOrdenCompra('+row.id+')" ><i class="fa fa-edit"></i>Detalle</button>'; 
                        
                        html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [6],
				},
				   		          
            ]

    });

}

function fn_ListarBusqueda() {
    datatablenew();
};



function modalCreditoPago(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/comprobante/credito_pago/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function modalFactura(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/factura/modal_factura/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function reporteFacturaSodimac(){

    var fecha_ini = $('#fecha_ini').val();
    var fecha_fin = $('#fecha_fin').val();
    var tipo_documento = $('#tipo_documento').val();
    var serie = $('#serie').val();
    var numero = $('#numero').val();

	if (fecha_ini == "")fecha_ini = "0";
    if (fecha_fin == "")fecha_fin = "0";
    if (tipo_documento == "") tipo_documento= 0;
    if (serie == "")serie = 0;
    if (numero == "")numero = 0;

	location.href = '/comprobante/exportar_factura_sodimac/'  + fecha_ini + '/' + fecha_fin + '/' + tipo_documento + '/'+ serie + '/'+ numero;

}


function modalLiquidacion(id){

	$(".modal-dialog").css("width","80%");
	$('#openOverlayOpc').modal('show');
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/ingreso/modal_liquidacion/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
			}
	});

}



