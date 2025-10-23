$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#btnNuevo').click(function () {
		modalPromotorRuta(0);
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

	$('#fecha_bus').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });
	
	datatablenew();

	$('#id_tienda').select2({ 
		width: '100%',
		placeholder: '--Seleccionar--',
		allowClear: true,
		minimumResultsForSearch: 0,
		dropdownParent: $('#openOverlayOpc') 
	})

});

function datatablenew(){
                      
    var oTable1 = $('#tblAsistenciaPromotores').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/promotores/listar_asistencia_promotores_ajax",
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
						fecha:fecha,estado:estado,
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
				var promotor = "";
				if(row.promotor!= null)promotor = row.promotor;
				return promotor;
			},
			"bSortable": true,
			"aTargets": [1]
			},
			
			{
			"mRender": function (data, type, row) {
				var tienda = "";
				if(row.tienda!= null)tienda = row.tienda;
				return tienda;
			},
			"bSortable": true,
			"aTargets": [2]
			},
			{
			"mRender": function (data, type, row) {
				var fecha = "";
				if(row.fecha!= null)fecha = row.fecha;
				return fecha;
			},
			"bSortable": true,
			"aTargets": [3]
			},
			{
			"mRender": function (data, type, row) {
				var hora_entrada = "";
				if(row.hora_entrada!= null)hora_entrada = row.hora_entrada;
				return hora_entrada;
			},
			"bSortable": true,
			"aTargets": [4]
			},
			{
			"mRender": function (data, type, row) {
				var hora_salida = "";
				if(row.hora_salida!= null)hora_salida = row.hora_salida;
				return hora_salida;
			},
			"bSortable": true,
			"aTargets": [5]
			},
			{
				"mRender": function (data, type, row) {
									
					var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
					
					//html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalPromotorRuta('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>'; 
					
					html += '<a href="https://www.google.com/maps?q= '+row.latitud +', '+row.longitud +'" target="_blank"> Ver ubicación </a>'

					html += '</div>';
					return html;
				},
				"bSortable": false,
				"aTargets": [6],
			},
			{
				"mRender": function (data, type, row) {
					if (row.ruta_imagen_ingreso) {
						return '<img src="/' + row.ruta_imagen_ingreso + '" alt="Foto asistencia" width="60" height="60" style="border-radius:8px; object-fit:cover;">';
					} else {
						return '<span class="text-muted">Sin foto</span>';
					}
				},
				"bSortable": false,
				"aTargets": [7], // 👈 índice de columna (ajusta según orden)
				"className": "dt-center"
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
				"aTargets": [8]
			},
		]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};

function modalAsistencia(){
	
	//$(".modal-dialog").css("width","40%");
	//$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
		url: "/promotores/modal_asistencia_promotor",
		type: "GET",
		success: function (result) {
			$("#diveditpregOpc").html(result);
			$('#openOverlayOpc').modal('show');
		}
	});
}

function marcarAsistencia() {

	$('#btnAsistencia').attr('disabled',true);

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {

			var msgLoader = "Marcando asistencia, espere un momento...";
            var heightBrowser = $(window).width() / 2;
            $('.loader').css("opacity", "0.8").css("height", heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>" + msgLoader + "</div></div>");
            $('.loader').show();

            $.ajax({
                url: "/promotores/marcar_asistencia",
                type: "POST",
                dataType: "json",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    latitud: position.coords.latitude,
                    longitud: position.coords.longitude,
					foto_base64: $('#foto_base64').val()
                },
                success: function (response) {
                    $('.loader').hide();
                    bootbox.alert(response.message);
                    $('#btnAsistencia').attr('disabled', false);
                },
                error: function (xhr, status, error) {
                    $('.loader').hide();
                    bootbox.alert("Ocurrió un error al marcar la asistencia: " + error);
                    $('#btnAsistencia').attr('disabled', false);
                }
            });

        }, function (error) {

            if (error.code === error.PERMISSION_DENIED) {
                bootbox.alert("Debes permitir el acceso a la ubicación para marcar asistencia.");
            } else if (error.code === error.POSITION_UNAVAILABLE) {
                bootbox.alert("No se pudo determinar la ubicación.");
            } else if (error.code === error.TIMEOUT) {
                bootbox.alert("Tiempo de espera agotado al obtener la ubicación.");
            } else {
                bootbox.alert("Error desconocido al obtener la ubicación.");
            }
            $('#btnAsistencia').attr('disabled', false);
        },
		{ enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
	);

    } else {
        bootbox.alert("Tu navegador no soporta geolocalización.");
        $('#btnAsistencia').attr('disabled', false);
    }
}

function fn_save_asistencia_promotor(){
	
    var msg = "";

    var id_tienda = $('#id_tienda').val();

    if(id_tienda==""){msg+="Debe seleccionar una tienda antes de marcar asistencia. <br>";}
    
    if(msg!=""){
        bootbox.alert(msg);
        return false;
    }else{
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {

                const latitud = position.coords.latitude;
                const longitud = position.coords.longitude;

                var msgLoader = "Marcando asistencia, espere un momento...";
                var heightBrowser = $(window).width() / 2;
                $('.loader').css("opacity", "0.8").css("height", heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>" + msgLoader + "</div></div>");
                $('.loader').show();

                $.ajax({
                    url: "/promotores/marcar_asistencia",
                    type: "POST",
                    dataType: "json",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id_tienda: id_tienda,
                        latitud: latitud,
                        longitud: longitud,
						foto_base64: $('#foto_base64').val()
                    },
                    success: function (response) {
                        $('.loader').hide();
                        bootbox.alert(response.message);
                        $('#btnAsistencia').attr('disabled', false);
                        $('#openOverlayOpc').modal('hide');
                        datatablenew();
                    },
                    error: function (xhr, status, error) {
                        $('.loader').hide();
                        bootbox.alert("Ocurrió un error al marcar la asistencia: " + error);
                        $('#btnAsistencia').attr('disabled', false);
                    }
                });

            }, function (error) {

                if (error.code === error.PERMISSION_DENIED) {
                    bootbox.alert("Debes permitir el acceso a la ubicación para marcar asistencia.");
                } else if (error.code === error.POSITION_UNAVAILABLE) {
                    bootbox.alert("No se pudo determinar la ubicación.");
                } else if (error.code === error.TIMEOUT) {
                    bootbox.alert("Tiempo de espera agotado al obtener la ubicación.");
                } else {
                    bootbox.alert("Error desconocido al obtener la ubicación.");
                }
                $('#btnAsistencia').attr('disabled', false);
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );

        } else {
            bootbox.alert("Tu navegador no soporta geolocalización.");
            $('#btnAsistencia').attr('disabled', false);
        }
    }
}

$('#openOverlayOpc').on('shown.bs.modal', function () {
    iniciarCamara();
});

function iniciarCamara() {
    const video = document.getElementById('camera');
    const container = document.getElementById('camera-container');

    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        container.style.display = 'block';
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(err => {
                bootbox.alert('No se pudo acceder a la cámara: ' + err.message);
            });
    } else {
        bootbox.alert('Tu navegador no soporta acceso a la cámara.');
    }
}

function capturarFoto() {
    const video = document.getElementById('camera');
    const canvas = document.getElementById('canvas');
    const foto = document.getElementById('foto_base64');

    const contexto = canvas.getContext('2d');
    contexto.drawImage(video, 0, 0, canvas.width, canvas.height);

    const dataURL = canvas.toDataURL('image/jpeg');
    foto.value = dataURL;

    bootbox.alert("📷 Foto capturada correctamente.");
}
