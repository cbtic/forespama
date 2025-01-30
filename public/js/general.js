
function datatablenew(options) {
    // Valores predeterminados
    var defaults = {
        sAjaxSource: "/comision/listar_comision_ajax", // URL predeterminada
        bFilter: false,
        bSort: false,
        info: true,
        language: {"url": "/js/Spanish.json"},
        autoWidth: false,
        bLengthChange: true,
        destroy: true,
        lengthMenu: [[10, 50, 100, 200, 60000], [10, 50, 100, 200, "Todos"]],
        dom: '<"top">rt<"bottom"flpi><"clear">',
        extraData: {}, // Datos extra para la petición
        columns: [] // Solo los nombres de las propiedades que se desean mostrar
    };

    // Combina las configuraciones personalizadas con los valores predeterminados
    var config = $.extend(true, {}, defaults, options);

    // Llenar `columns` dinámicamente
    var columns = [];
	for (let i = 0; i < config.columns.length; i++) {
		let field = config.columns[i]; // Usamos `let` para que `field` tenga un ámbito local a cada iteración
		
		columns.push({
			"mRender": function(data, type, row) {
				return row[field] !== null ? row[field] : ''; // Devuelve el valor de la propiedad de cada fila
			},
			"bSortable": false, // Predeterminado en false
			"className": "", // Predeterminado en vacío
			"aTargets": [i] // Índice de la columna
		});
	}

    // Agregar la columna con los botones de "Editar" y "Activar/Eliminar"
    columns.push({
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
            html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="fn_modal('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
            html += '<a href="javascript:void(0)" onclick="fn_eliminar('+row.id+','+row.estado+')" class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
            html += '</div>';
            return html;
        },
        "bSortable": false,
        "aTargets": [config.columns.length], // Añadir la columna de botones al final
    });

	//console.log(columns);
    // Llenar `extraData` dinámicamente, si existe en las opciones
    var extraData = {};
    for (var key in config.extraData) {
        if (config.extraData.hasOwnProperty(key)) {
            extraData[key] = config.extraData[key];
        }
    }
    
    var oTable1 = $('#'+config.tabla).dataTable({
        "bServerSide": true,
        "sAjaxSource": config.sAjaxSource,
        "bProcessing": true,
        "sPaginationType": "full_numbers",
        "bFilter": config.bFilter,
        "bSort": config.bSort,
        "info": config.info,
        "language": config.language,
        "autoWidth": config.autoWidth,
        "bLengthChange": config.bLengthChange,
        "destroy": config.destroy,
        "lengthMenu": config.lengthMenu,
        "dom": config.dom,
        "fnDrawCallback": function(json) {
            $('[data-toggle="tooltip"]').tooltip();
        },

        "fnServerData": function(sSource, aoData, fnCallback, oSettings) {
            // Construir datos dinámicamente
            var data = {
                NumeroPagina: parseFloat(fn_util_obtieneNroPagina(aoData[3].value, aoData[4].value)).toFixed(),
                NumeroRegistros: aoData[4].value,
                _token: $('#_token').val()
            };

            // Agregar los parámetros adicionales si existen
            data = $.extend(data, extraData);

            oSettings.jqXHR = $.ajax({
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": data,
                "success": function(result) {
                    fnCallback(result);
                },
                "error": function(msg, textStatus, errorThrown) {
                    console.error("Error en la solicitud AJAX:", msg, textStatus, errorThrown);
                }
            });
        },

        "aoColumnDefs": columns // Usar las columnas configuradas
    });
}

function modal(options){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: options.sAjaxSource,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function save_modal(options){
    
    var extraData = {};
    // Agregar el token CSRF correctamente
    extraData["_token"] = $('#_token').val();

    // Verificar si existen datos extra y agregarlos
    if (options.extraData) {
        for (var key in options.extraData) {
            if (options.extraData.hasOwnProperty(key)) {
                extraData[key] = options.extraData[key];
            }
        }
    }

    // Enviar datos por AJAX
	$.ajax({
			url: options.sAjaxSource,
			type: "POST",
            data : extraData,
			success: function (result) {  
                $('#openOverlayOpc').modal('hide');
                fn_ListarBusqueda();
			}
	});

}

function eliminar(options){
	var act_estado = "";
	if(options.estado==1)act_estado = "Eliminar";
	if(options.estado==0)act_estado = "Activar";
    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Deseas "+act_estado+" el registro?", 
        callback: function(result){
            if (result==true) {
                eliminar_confirmado(options);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function eliminar_confirmado(options){
	
    $.ajax({
            url: options.sAjaxSource,
            type: "GET",
            success: function (result) {
				fn_ListarBusqueda();
            }
    });
}
