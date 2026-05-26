$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
		
	$('#btnGenerarAsientos').click(function () {
		generar_asientos_anexos();
	});

	$('#btnMigrar').click(function () {
		generar_token_starsoft();
	});

	$('#ruc_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#razon_social_bus').keypress(function(e){
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
		
	datatablenew();

});

function datatablenew(){
                      
    var oTable1 = $('#tblAsientoContableAnexo').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/asiento_contable_anexo/listar_asiento_contable_anexo_ajax",
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

            var numero_documento = $('#numero_documento_bus').val();
            var razon_social = $('#razon_social_bus').val();
            var tipo_anexo = $('#tipo_anexo_bus').val();
            var migrado = $('#migrado_bus').val();
			var estado = $('#estado_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						numero_documento:numero_documento,razon_social:razon_social,tipo_anexo:tipo_anexo,migrado:migrado,estado:estado,
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
					var tipo_anexo = "";
					if(row.tipo_anexo!= null)tipo_anexo = row.tipo_anexo;
					return tipo_anexo;
				},
				"bSortable": true,
				"aTargets": [1]
				},

				{
				"mRender": function (data, type, row) {
					var codigo_anexo = "";
					if(row.codigo_anexo!= null)codigo_anexo = row.codigo_anexo;
					return codigo_anexo;
				},
				"bSortable": true,
				"aTargets": [2]
				},

				{
				"mRender": function (data, type, row) {
					var ruc = "";
					if(row.ruc!= null)ruc = row.ruc;
					return ruc;
				},
				"bSortable": true,
				"aTargets": [3]
				},

				{
				"mRender": function (data, type, row) {
					var razon_social = "";
					if(row.razon_social!= null)razon_social = row.razon_social;
					return razon_social;
				},
				"bSortable": true,
				"aTargets": [4]
				},

				{
				"mRender": function (data, type, row) {
					var direccion = "";
					if(row.direccion!= null)direccion = row.direccion;
					return direccion;
				},
				"bSortable": true,
				"aTargets": [5]
				},

				{
				"mRender": function (data, type, row) {
					var tipo_documento = "";
					if(row.tipo_documento!= null)tipo_documento = row.tipo_documento;
					return tipo_documento;
				},
				"bSortable": true,
				"aTargets": [6]
				},

				{
				"mRender": function (data, type, row) {
					var nro_documento = "";
					if(row.nro_documento!= null)nro_documento = row.nro_documento;
					return nro_documento;
				},
				"bSortable": true,
				"aTargets": [7]
				},

				{
				"mRender": function (data, type, row) {
					var apellido_paterno = "";
					if(row.apellido_paterno!= null)apellido_paterno = row.apellido_paterno;
					return apellido_paterno;
				},
				"bSortable": true,
				"aTargets": [8]
				},

				{
				"mRender": function (data, type, row) {
					var apellido_materno = "";
					if(row.apellido_materno!= null)apellido_materno = row.apellido_materno;
					return apellido_materno;
				},
				"bSortable": true,
				"aTargets": [9]
				},

				{
				"mRender": function (data, type, row) {
					var primer_nombre = "";
					if(row.primer_nombre!= null)primer_nombre = row.primer_nombre;
					return primer_nombre;
				},
				"bSortable": true,
				"aTargets": [10]
				},

				{
				"mRender": function (data, type, row) {
					var segundo_nombre = "";
					if(row.segundo_nombre!= null)segundo_nombre = row.segundo_nombre;
					return segundo_nombre;
				},
				"bSortable": true,
				"aTargets": [11]
				},

				{
				"mRender": function (data, type, row) {
					var nacionalidad = "";
					if(row.nacionalidad!= null)nacionalidad = row.nacionalidad;
					return nacionalidad;
				},
				"bSortable": true,
				"aTargets": [12]
				},

				{
				"mRender": function (data, type, row) {
					var sexo = "";
					if(row.sexo!= null)sexo = row.sexo;
					return sexo;
				},
				"bSortable": true,
				"aTargets": [13]
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
				"aTargets": [14]
				},
				
				{
				"mRender": function (data, type, row) {
					var fecha_migrado = "";
					if(row.fecha_migrado!= null)fecha_migrado = row.fecha_migrado;
					return fecha_migrado;
				},
				"bSortable": true,
				"aTargets": [15]
				},

            ]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};

function generar_asientos_anexos(id){
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
	$('.loader').show();
	
	$.ajax({
		url: "/asiento_contable_anexo/generar_asiento_contable_anexo",
		type: "POST",
		data : $("#frmAsientoContableAnexo").serialize(),
		success: function (result) {
			
            $('.loader').hide();
			if (result.success) {
				datatablenew();
			} else if (result.error) {
				bootbox.alert(result.error);
			}
		},
    });
}

function generar_token_starsoft(){

	$.ajax({
        url: '/asiento_contable_anexo/generar_token_starsoft',
        type: 'POST',
		data: {
            _token: $('#_token').val()
        },
        success: function(response){
            console.log(response);
			migrar_anexos_starsoft(response.data.datos.access_token);
        },
        error: function(xhr){
            console.log(xhr.responseText);
        }
    });
}

function migrar_anexos_starsoft(token){

	$.ajax({
        url: '/asiento_contable_anexo/migrar_anexos_starsoft',
        type: 'POST',
		data: {
            _token: $('#_token').val(),
            token: token
        },
        success: function(response){
			datatablenew();
            console.log(response);
        },
        error: function(xhr){
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
