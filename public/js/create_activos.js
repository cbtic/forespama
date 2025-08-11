$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
		
	$('#btnNuevoSOAT').on('click', function () {
		modalSoat(0);
	});

	$('#btnNuevoRevisionTecnica').on('click', function () {
		modalRevisionTecnica(0);
	});

	$('#btnNuevoMantenimiento').on('click', function () {
		modalMantenimiento(0);
	});

	$('#btnGuardar').on('click', function () {
		guardar_activo()
	});
	
	//datatablenew();

    $('#vigencia_circulacion').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

	$('#marca').select2({ width : '100%' })

	$('#placa').mask('AAA-000');

	$(".upload").on('click', function() {
        var formData = new FormData();
        var files = $('#image')[0].files[0];
        formData.append('file',files);
        $.ajax({
			headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/activos/upload_activo",
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response != 0) {
                    $("#img_ruta").attr("src", "/img/tmp_activos/"+response);
					$("#img_foto").val(response);
                } else {
                    alert('Formato de imagen incorrecto.');
                }
            }
        });
        return false;
    });

		
	if($('#id_activo').val()>0){
        obtenerProvincia(function() {
            obtenerDatosUbigeo();
        });
	}

});

$(function() {
    $('.mayusculas').keyup(function() {
        this.value = this.value.toUpperCase();
    });
});

function fn_ListarBusqueda() {
    datatablenew();
};

function guardar_activo(){

    var msg = "";
    
	var tipo_activo = $("#tipo_activo").val();
	var descripcion = $("#descripcion").val();
	var placa = $("#placa").val();
	var tipo_combustible = $("#tipo_combustible").val();
	//var valor_libros = $("#valor_libros").val();
	//var valor_comercial = $("#valor_comercial").val();
	var departamento = $("#departamento").val();
	var provincia = $("#provincia").val();
	var distrito = $("#distrito").val();
	
	if(tipo_activo=="")msg += "Debe seleccionar un Tipo de Activo <br>";
	if(descripcion=="")msg += "Debe Ingresar una Descripcion <br>";
	if(placa=="")msg += "Debe Ingresar la Placa <br>";
	if(tipo_combustible=="")msg += "Debe Seleccionar el Tipo de Combustible <br>";
	//if(valor_libros=="")msg += "Debe Ingresar el Valor Libros <br>";
	//if(valor_comercial=="")msg += "Debe Ingresar el Valor Comercial <br>";
	if(departamento=="")msg += "Debe Seleccione el Departamento <br>";
	if(provincia=="")msg += "Debe Seleccione la Provincia <br>";
	if(distrito=="")msg += "Debe Seleccione el Distrito <br>";
	
	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}
	
	fn_save();
}

function fn_save(){
    
    $.ajax({
		url: "/activos/send",
		type: "POST",
		data : $("#frmNuevoActivo").serialize(),
		success: function (result) {
			if(result==1){
				bootbox.alert("El Activo ya esta registrado");
				return false;
			}
			
			window.location.href = "/activos/editar_activo/" + result.id;
			
		}
    });
}

function modalSoat(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/activos/modal_soat_activo/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});
}

function modalRevisionTecnica(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/activos/modal_revision_tecnica_activo/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});
}

function modalMantenimiento(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/activos/modal_control_mantenimiento_activo/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});
}

function eliminarSoat(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" el Soat?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_soat(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_soat(id,estado){
	
    $.ajax({
		url: "/activos/eliminar_soat_activo/"+id+"/"+estado,
		type: "GET",
		success: function (result) {
			window.location.reload();
		}
    });
}

function eliminarRevisionTecnica(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" la Revision Tecnica?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_revision_tecnica(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_revision_tecnica(id,estado){
	
    $.ajax({
		url: "/activos/eliminar_revision_tecnica_activo/"+id+"/"+estado,
		type: "GET",
		success: function (result) {
			window.location.reload();
		}
    });
}

function eliminarMantenimiento(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" el Mantenimiento?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_control_mantenimiento(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_control_mantenimiento(id,estado){
	
    $.ajax({
		url: "/activos/eliminar_control_mantenimiento_activo/"+id+"/"+estado,
		type: "GET",
		success: function (result) {
			window.location.reload();
		}
    });
}

function obtenerDistrito(){
	
	var id_departamento = $('#departamento').val();
	var id = $('#provincia').val();
	if(id=="")return false;
	$('#distrito').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/almacenes/obtener_distrito/'+id_departamento+'/'+id,
		dataType: "json",
		success: function(result){
			var option = "<option value=''>Seleccionar</option>";
			$('#distrito').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#distrito').html(option);
			
			$('#distrito').attr("disabled",false);
			$('.loader').hide();
		}
	});
}

function obtenerProvincia(callback){
	
	var id = $('#departamento').val();
	if(id=="")return false;
	$('#provincia').attr("disabled",true);
	$('#distrito').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/almacenes/obtener_provincia/'+id,
		dataType: "json",
		success: function(result){
			var option = "<option value='' selected='selected'>--Seleccionar--</option>";
			$('#provincia').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_provincia+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#provincia').html(option);
			
			var option2 = "<option value=''>--Seleccionar--</option>";
			$('#distrito').html(option2);
			
			$('#provincia').attr("disabled",false);
			$('#distrito').attr("disabled",false);
			
			$('.loader').hide();
            if (callback) callback();
		}
	});
}

function obtenerDatosUbigeo(){

    var id = $('#id_activo').val();

    $.ajax({
        url: '/activos/obtener_provincia_distrito/'+id,
        dataType: "json",
        success: function(result){
            
            //alert(result[0].provincia_partida);

            $('#provincia').val(result[0].provincia_partida);

            obtenerDistrito_(function(){

                $('#distrito').val(result[0].distrito_partida);

            });
        }
    });
}

function obtenerDistrito_(callback){

    var departamento = $('#departamento').val();
    var id = $('#provincia').val();
    if(id=="")return false;
    $('#distrito').attr("disabled",true);

    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

    $.ajax({
        url: '/almacenes/obtener_distrito/'+departamento+'/'+id,
        dataType: "json",
        success: function(result){
            var option = "<option value=''>Seleccionar</option>";
            $('#distrito').html("");
            $(result).each(function (ii, oo) {
                option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
            });
            $('#distrito').html(option);
            
            $('#distrito').attr("disabled",false);
            $('.loader').hide();

            callback();
        
        }
    });
}

$(function() {
    $('.solo-decimal').on('input', function () {
        this.value = this.value.replace(/[^0-9.]/g, '');

        if ((this.value.match(/\./g) || []).length > 1) {
            this.value = this.value.substr(0, this.value.lastIndexOf('.'));
        }

        if (this.value.startsWith('.')) {
            this.value = '';
        }
    });
});