$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
		
	$('#btnGenerarAsientos').click(function () {
		generar_asientos_ventas();
	});

	$('#btnMigrar').click(function () {
		generar_token_starsoft();
	});

	$('#numero_comprobante_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#numero_documento_bus').keypress(function(e){
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

	$('#migrado_bus').keypress(function(e){
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
		DescargarArchivosExcel()

	});

});

function datatablenew(){
                      
    var oTable1 = $('#tblAsientoContableVenta').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/asiento_contable_venta/listar_asiento_contable_venta_ajax",
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

            var numero_comprobante = $('#numero_comprobante_bus').val();
            var numero_documento = $('#numero_documento_bus').val();
            var fecha_inicio = $('#fecha_inicio_bus').val();
            var fecha_fin = $('#fecha_fin_bus').val();
            var migrado = $('#migrado_bus').val();
			var estado = $('#estado_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						numero_comprobante:numero_comprobante,numero_documento:numero_documento,fecha_inicio:fecha_inicio,fecha_fin:fecha_fin,
						migrado:migrado,estado:estado,
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
					var numero_cuenta = "";
					if(row.numero_cuenta!= null)numero_cuenta = row.numero_cuenta;
					return numero_cuenta;
				},
				"bSortable": true,
				"aTargets": [1]
				},

				{
				"mRender": function (data, type, row) {
					var annomes = "";
					if(row.annomes!= null)annomes = row.annomes;
					return annomes;
				},
				"bSortable": true,
				"aTargets": [2]
				},

				{
				"mRender": function (data, type, row) {
					var subdiario = "";
					if(row.subdiario!= null)subdiario = row.subdiario;
					return subdiario;
				},
				"bSortable": true,
				"aTargets": [3]
				},

				{
				"mRender": function (data, type, row) {
					var comprobante = "";
					if(row.comprobante!= null)comprobante = row.comprobante;
					return comprobante;
				},
				"bSortable": true,
				"aTargets": [4]
				},

				{
				"mRender": function (data, type, row) {
					var fecha_registro = "";
					if(row.fecha_registro!= null)fecha_registro = row.fecha_registro;
					return fecha_registro;
				},
				"bSortable": true,
				"aTargets": [5]
				},

				{
				"mRender": function (data, type, row) {
					var tipo_anexo = "";
					if(row.tipo_anexo!= null)tipo_anexo = row.tipo_anexo;
					return tipo_anexo;
				},
				"bSortable": true,
				"aTargets": [6]
				},

				{
				"mRender": function (data, type, row) {
					var codigo_cliente = "";
					if(row.codigo_cliente!= null)codigo_cliente = row.codigo_cliente;
					return codigo_cliente;
				},
				"bSortable": true,
				"aTargets": [7]
				},

				{
				"mRender": function (data, type, row) {
					var tipo_documento = "";
					if(row.tipo_documento!= null)tipo_documento = row.tipo_documento;
					return tipo_documento;
				},
				"bSortable": true,
				"aTargets": [8]
				},

				{
				"mRender": function (data, type, row) {
					var numero_documento = "";
					if(row.numero_documento!= null)numero_documento = row.numero_documento;
					return numero_documento;
				},
				"bSortable": true,
				"aTargets": [9]
				},

				{
				"mRender": function (data, type, row) {
					var fecha_documento = "";
					if(row.fecha_documento!= null)fecha_documento = row.fecha_documento;
					return fecha_documento;
				},
				"bSortable": true,
				"aTargets": [10]
				},

				{
				"mRender": function (data, type, row) {
					var igv = "";
					if(row.igv!= null)igv = row.igv;
					return igv;
				},
				"bSortable": true,
				"aTargets": [11]
				},

				{
				"mRender": function (data, type, row) {
					var importe = "";
					if(row.importe!= null)importe = row.importe;
					return importe;
				},
				"bSortable": true,
				"aTargets": [12]
				},

				{
				"mRender": function (data, type, row) {
					var glosa = "";
					if(row.glosa!= null)glosa = row.glosa;
					return glosa;
				},
				"bSortable": true,
				"aTargets": [13]
				},

				{
				"mRender": function (data, type, row) {
					var glosa_movimiento = "";
					if(row.glosa_movimiento!= null)glosa_movimiento = row.glosa_movimiento;
					return glosa_movimiento;
				},
				"bSortable": true,
				"aTargets": [14]
				},

				{
				"mRender": function (data, type, row) {
					var debe_haber = "";
					if(row.debe_haber!= null)debe_haber = row.debe_haber;
					return debe_haber;
				},
				"bSortable": true,
				"aTargets": [15]
				},

				{
				"mRender": function (data, type, row) {
					var ruc_cliente = "";
					if(row.ruc_cliente!= null)ruc_cliente = row.ruc_cliente;
					return ruc_cliente;
				},
				"bSortable": true,
				"aTargets": [16]
				},

				{
				"mRender": function (data, type, row) {
					var razon_social = "";
					if(row.razon_social!= null)razon_social = row.razon_social;
					return razon_social;
				},
				"bSortable": true,
				"aTargets": [17]
				},

				{
				"mRender": function (data, type, row) {
					var fecha_vencimiento = "";
					if(row.fecha_vencimiento!= null)fecha_vencimiento = row.fecha_vencimiento;
					return fecha_vencimiento;
				},
				"bSortable": true,
				"aTargets": [18]
				},

				{
				"mRender": function (data, type, row) {
					var anulado = "";
					if(row.anulado == 1){
						anulado = "S";
					}
					if(row.anulado == 0){
						anulado = "N";
					}
					return anulado;
				},
				"bSortable": false,
				"aTargets": [19]
				},

				{
				"mRender": function (data, type, row) {
					var flag_migrado = "";
					if(row.flag_migrado == 1){
						flag_migrado = "Migrado";
					}
					if(row.flag_migrado == 0){
						flag_migrado = "No Migrado";
					}
					return flag_migrado;
				},
				"bSortable": false,
				"aTargets": [20]
				},
				
				{
				"mRender": function (data, type, row) {
					var fecha_migrado = "";
					if(row.fecha_migrado!= null)fecha_migrado = row.fecha_migrado;
					return fecha_migrado;
				},
				"bSortable": true,
				"aTargets": [21]
				},

            ]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};

function generar_asientos_ventas(id){
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
	$('.loader').show();
	
	$.ajax({
		url: "/asiento_contable_venta/generar_asiento_contable_venta",
		type: "POST",
		data : $("#frmAsientoContableVenta").serialize(),
		success: function (result) {
			
            $('.loader').hide();
			/*if (result.success) {
				datatablenew();
			} else if (result.error) {
				bootbox.alert(result.error);
			}*/
			datatablenew();
			bootbox.alert({
				title: "Correcto",
				message: result.mensaje
			});
		},

		error: function (xhr) {
			
			$('.loader').hide();

			bootbox.alert({
				title: "Error",
				message: xhr.responseJSON.mensaje
			});
		}
    });
}

function generar_token_starsoft(){

	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
	$('.loader').show();

	$.ajax({
        url: '/asiento_contable_anexo/generar_token_starsoft',
        type: 'POST',
		data: {
            _token: $('#_token').val()
        },
        success: function(response){
			$('.loader').hide();
            console.log(response);
			migrar_ventas_starsoft(response.data.datos.access_token);
        },
        error: function(xhr){
			$('.loader').hide();
            console.log(xhr.responseText);
        }
    });
}

function migrar_ventas_starsoft(token){

	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
	$('.loader').show();

	$.ajax({
        url: '/asiento_contable_venta/migrar_ventas_starsoft',
        type: 'POST',
		data: {
            _token: $('#_token').val(),
            token: token
        },
        success: function(response){
			datatablenew();
			$('.loader').hide();
            console.log(response);
        },
        error: function(xhr){
			$('.loader').hide();
            console.log(xhr.responseText);
        }
    });
}

function eliminarMarca(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" la Marca?", 
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
		url: "/marcas/eliminar_marca/"+id+"/"+estado,
		type: "GET",
		success: function (result) {
			//if(result="success")obtenerPlanDetalle(id_plan);
			datatablenew();
		}
    });
}

function DescargarArchivosExcel(){
	
	var numero_comprobante = $('#numero_comprobante_bus').val();
	var numero_documento = $('#numero_documento_bus').val();
	var fecha_inicio = $('#fecha_inicio_bus').val();
	var fecha_fin = $('#fecha_fin_bus').val();
	var migrado = $('#migrado_bus').val();
	var estado = $('#estado_bus').val();

	if (numero_comprobante == "")numero_comprobante = "0";
	if (numero_documento == "")numero_documento = "0";
	if (fecha_inicio == "")fecha_inicio = "0";
	if (fecha_fin == "")fecha_fin = "0";
	if (migrado == "")migrado = "0";
	if (estado == "")estado = "0";
	
	location.href = '/asiento_contable_venta/exportar_listar_asiento_contable_venta/'+numero_comprobante+'/'+numero_documento+'/'+fecha_inicio+'/'+fecha_fin+'/'+migrado+'/'+estado;
}
