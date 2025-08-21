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

	$('#pais_procedencia').select2({ width : '100%' })

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

		obtenerSubTipoActivo(function(){
			obtenerDatosSubTipoActivo();
		});

		obtenerSubFamiliaBus(function(){
			obtenerDatosSubFamilia();
		});
	}

	obtenerDatosActivo();

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
	var familia = $("#familia").val();
	var sub_familia = $("#sub_familia").val();
	var sub_tipo_activo = $("#sub_tipo_activo").val();
	var departamento = $("#departamento").val();
	var provincia = $("#provincia").val();
	var distrito = $("#distrito").val();
	
	if(tipo_activo=="")msg += "Debe seleccionar un Tipo de Activo <br>";
	
	if(tipo_activo==2){
		if(placa=="")msg += "Debe Ingresar la Placa <br>";
		if(tipo_combustible=="")msg += "Debe Seleccionar el Tipo de Combustible <br>";
	}
	if(familia=="")msg += "Debe Ingresar la Familia <br>";
	if(sub_familia=="")msg += "Debe Ingresar la Sub Familia <br>";
	if(sub_tipo_activo=="")msg += "Debe Ingresar el Sub Tipo de Activo <br>";
	if(descripcion=="")msg += "Debe Ingresar una Descripcion <br>";
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

function obtenerDatosActivo(){

	var tipo_activo = $('#tipo_activo').val();

	$('#label_tipo_combustible_maquinaria').hide();
	$('#opcion_tipo_combustible_maquinaria').hide();
	$('#label_dimension_maquinaria').hide();
	$('#opcion_dimension_maquinaria').hide();
	$('#label_placa_maquinaria').hide();
	$('#opcion_placa_maquinaria').hide();
	$('#div_titulo_maquinaria').hide();
	$('#div_partida_maquinaria').hide();
	$('#label_marca_maquinaria').hide();
	$('#select_marca_maquinaria').hide();
	$('#label_anio_fabricacion_maquinaria').hide();
	$('#opcion_anio_fabricacion_maquinaria').hide();
	$('#label_potencia_maquinaria').hide();
	$('#opcion_potencia_maquinaria').hide();
	$('#label_tipo_operacion_maquinaria_maquinaria').hide();
	$('#select_tipo_operacion_maquinaria_maquinaria').hide();

	if(tipo_activo==2){
		$('#label_tipo_combustible_maquinaria').show();
		$('#opcion_tipo_combustible_maquinaria').show();
		$('#label_dimension_maquinaria').show();
		$('#opcion_dimension_maquinaria').show();
		$('#label_placa_maquinaria').show();
		$('#opcion_placa_maquinaria').show();
		$('#div_titulo_maquinaria').show();
		$('#div_partida_maquinaria').show();
	}

	if(tipo_activo==4){
		$('#label_marca_maquinaria').show();
		$('#select_marca_maquinaria').show();
		$('#label_anio_fabricacion_maquinaria').show();
		$('#opcion_anio_fabricacion_maquinaria').show();
		$('#label_potencia_maquinaria').show();
		$('#opcion_potencia_maquinaria').show();
		$('#label_tipo_operacion_maquinaria_maquinaria').show();
		$('#select_tipo_operacion_maquinaria_maquinaria').show();
	}

}

function obtenerSubTipoActivo(callback){

	var tipo_activo = $('#tipo_activo').val();
	if(tipo_activo=="")return false;

	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/activos/obtener_sub_tipo_activo/'+tipo_activo,
		dataType: "json",
		success: function(result){
			var option = "<option value=''>--Seleccionar--</option>";
			$('#sub_tipo_activo').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.codigo+"'>"+oo.denominacion+"</option>";
			});
			$('#sub_tipo_activo').html(option);
			
			$('#sub_tipo_activo').attr("disabled",false);
			$('.loader').hide();
			if (callback) callback();
		}
	});
}

function obtenerDatosSubTipoActivo(){

    var id = $('#id_activo').val();

    $.ajax({
        url: '/activos/obtener_datos_sub_tipo_activo/'+id,
        dataType: "json",
        success: function(result){
            
            $('#sub_tipo_activo').val(result[0].id_sub_tipo_activo);
			$('#sub_tipo_activo').attr('disabled',true);
			
        }
    });
}

function obtenerSubFamiliaBus(callback){

    var familia = $('#familia').val();
    if(familia=="")return false;
    
	$('#sub_familia').attr("disabled",true);
    
    var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

    $.ajax({
        url: "/sub_familia/obtener_sub_familia/"+familia,
        dataType: "json",
        success: function (result) {

           var option = "<option value='' selected='selected'>--Seleccionar--</option>";
			$('#sub_familia').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id+"'>"+oo.denominacion+"</option>";
			});
			$('#sub_familia').html(option);
			$('#sub_familia').attr("disabled",false);
			$('.loader').hide();
			if (callback) callback();

        }
    });
}

function obtenerDatosSubFamilia(){

    var id = $('#id_activo').val();
	if(id=="")return false;

    $.ajax({
        url: '/activos/obtener_datos_sub_familia/'+id,
        dataType: "json",
        success: function(result){
            
            $('#sub_familia').val(result[0].id_sub_familia);
			$('#sub_familia').attr('disabled',true);
			
        }
    });
}

function  obtenerMarca(){

	var tipo_activo = $('#tipo_activo').val();
	if(tipo_activo=="")return false;

	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/activos/obtener_marca/'+tipo_activo,
		dataType: "json",
		success: function(result){
			var option = "<option value=''>--Seleccionar--</option>";
			$('#marca').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id+"'>"+oo.denominiacion+"</option>";
			});
			$('#marca').html(option);
			
			$('#marca').attr("disabled",false);
			$('.loader').hide();
			if (callback) callback();
		}
	});
}
