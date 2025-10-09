$(document).ready(function () {
	
	$(".upload").on('click', function() {

		var msgLoader = "";
        msgLoader = "Procesando, espere un momento por favor";
        var heightBrowser = $(window).width()/2;
        $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
        $('.loader').show();
		
        var formData = new FormData();
        var files = $('#image')[0].files[0];
        formData.append('file',files);
        $.ajax({
			headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/orden_compra/upload_informe_b2b_compra",
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
			dataType: 'json', 
            success: function(response) {
				
				console.log(response); 

				if(response.cantidad>0){
					$('.loader').hide();
					bootbox.alert("El informe de venta del B2B ya existe. Por favor ingrese otro.");
					return false;
				}else{
					datatablenew();
					$('.loader').hide();
				}
            }
        });
		return false;
    });

	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#fecha_bus').keypress(function(e){
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

});

function datatablenew(){
                      
    var oTable1 = $('#tblInformeB2B').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/orden_compra/listar_informe_b2b_ajax",
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
        "lengthMenu": [[/*10,*/ 50, 100, 200, 60000], [/*10,*/ 50, 100, 200, "Todos"]],
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
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						fecha:fecha,
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
                	var cliente = "";
					if(row.cliente!= null)cliente = row.cliente;
					return cliente;
                },
                "bSortable": true,
                "aTargets": [2]
                },

				{
				"mRender": function (data, type, row) {
					var numero_orden_compra_cliente = "";
					if(row.numero_orden_compra_cliente!= null)numero_orden_compra_cliente = row.numero_orden_compra_cliente;
					return numero_orden_compra_cliente;
				},
				"bSortable": true,
				"aTargets": [3]
				},
				
				{
                "mRender": function (data, type, row) {
                	var empresa_vende = "";
					if(row.empresa_vende!= null)empresa_vende = row.empresa_vende;
					return empresa_vende;
                },
                "bSortable": true,
                "aTargets": [4]
                },

				{
				"mRender": function (data, type, row) {
					var fecha_orden_compra = "";
					if(row.fecha_orden_compra!= null)fecha_orden_compra = row.fecha_orden_compra;
					return fecha_orden_compra;
				},
				"bSortable": true,
				"aTargets": [5]
				},
				{
				"mRender": function (data, type, row) {
					var numero_orden_compra = "";
					if(row.numero_orden_compra!= null)numero_orden_compra = row.numero_orden_compra;
					return numero_orden_compra;
				},
				"bSortable": true,
				"aTargets": [6]
				},
				{
				"mRender": function (data, type, row) {
					var almacen_origen = "";
					if(row.almacen_origen!= null)almacen_origen = row.almacen_origen;
					return almacen_origen;
				},
				"bSortable": true,
				"aTargets": [7]
				},
				{
				"mRender": function (data, type, row) {
					var almacen_destino = "";
					if(row.almacen_destino!= null)almacen_destino = row.almacen_destino;
					return almacen_destino;
				},
				"bSortable": true,
				"aTargets": [8]
				},
				{
				"mRender": function (data, type, row) {
					var cerrado = "";
					if(row.cerrado!= null)cerrado = row.cerrado;
					return cerrado;
				},
				"bSortable": true,
				"aTargets": [9]
				},
            ]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};
