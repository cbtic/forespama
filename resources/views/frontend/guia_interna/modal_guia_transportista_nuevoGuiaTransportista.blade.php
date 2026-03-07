<title>FORESPAMA</title>

<style>

.datepicker,
.table-condensed {
  width: 250px;
  height:250px;
}

.modal-dialog {
    width: 100%;
    max-width:100%!important
}

.modal-vehiculo .modal-dialog {
    width: 30% !important;
}

.modal-vehiculo .modal-body {
    height: auto !important;
}


.modal-conductor .modal-dialog {
    width: 40% !important;
}

.modal-conductor .modal-body {
    height: auto !important;
}

.modal-destinatario .modal-dialog {
    width: 70% !important;
}

.modal-destinatario .modal-body {
    height: auto !important;
}

.custom-select2-dropdown {
    width: 700px !important; 
}

#tablemodal{
    border-spacing: 0;
    display: flex;/*Se ajuste dinamicamente al tamano del dispositivo**/
    max-height: 80vh; /*El alto que necesitemos**/
    overflow-y: auto; /**El scroll verticalmente cuando sea necesario*/
    overflow-x: hidden;/*Sin scroll horizontal*/
    table-layout: fixed;/**Forzamos a que las filas tenga el mismo ancho**/
    width: 98vw; /*El ancho que necesitemos*/
    border:1px solid #c4c0c9;
}

#tablemodal thead{
    background-color: #e2e3e5;
    position: fixed !important;
}


#tablemodal th{
    border-bottom: 1px solid #c4c0c9;
    border-right: 1px solid #c4c0c9;
}

#tablemodal th{
    font-weight: normal;
    margin: 0;
    max-width: 9.5vw; 
    min-width: 9.5vw;
    word-wrap: break-word;
    font-size: 10px;
	font-weight:bold;
    height: 3.5vh !important;
	line-height:12px;
	vertical-align:middle;
	/*height:20px;*/
    padding: 4px;
    border-right: 1px solid #c4c0c9;
}

#tablemodal td{
    font-weight: normal;
    margin: 0;
    max-width: 9.5vw; 
    min-width: 9.5vw;
    word-wrap: break-word;
    font-size: 11px;
    height: 3.5vh !important;
    padding: 4px;
    border-right: 1px solid #c4c0c9;
}

#tablemodal tbody tr:hover td, #tablemodal tbody tr:hover th {
  font-weight:bold;
  
}

#tablemodalm{
	
}

.modal-scrollable {
    max-height: 80vh;
    overflow-y: auto;
}

#motivo_traslado {
    z-index: 1050 !important;
}

</style>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/locales/bootstrap-datepicker.es.min.js" charset="UTF-8"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker3.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>


<script type="text/javascript">

/*$(document).ready(function() {

});*/

/*$('#openOverlayOpc').on('hidden.bs.modal', function () {
    $('#motivo_traslado').select2('close'); 
});*/

$(function() {
    $('#placa_guia').keyup(function() {
        this.value = this.value.toLocaleUpperCase();
    });
});

</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
	 
});

$(document).ready(function() {

    $('#placa_guia').mask('AAA-000');
    
    if($('#id').val()>0){
        obtenerEmpresa();
    }

    $('#fecha_emision').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    $('#fecha_inicio_traslado').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    $('#empresa').select2({ width: '100%' });
    $('#conductor').select2({ width: '100%' });

    obtenerProvinciaPartida();
    obtenerProvinciaLlegada();

    if($('#id').val()>0){
		obtenerDatosUbigeoPartida();
        obtenerDatosUbigeoLlegada();
        actualizarDescripciones();
	}

    if($('#placa_guia').val()!=""){
        btnEmpTrans
        btnConductor
    }

    $('#ruc_destinatario_label').hide();
    $('#ruc_destinatario_input').hide();
    $('#dni_destinatario_label').hide();
    $('#dni_destinatario_input').hide();
    $('#empresa_destinatario_label').hide();
    $('#empresa_destinatario_input').hide();
    $('#nombre_destinatario_label').hide();
    $('#nombre_destinatario_input').hide();

});

function fn_save_guia_interna(){
	
    var msg = "";

    var fecha_emision = $('#fecha_emision').val();
    var punto_partida = $('#punto_partida').val();
    var fecha_inicio_traslado = $('#fecha_inicio_traslado').val();
    var marca_placa = $('#marca_placa').val();
    var numero_licencia = $('#numero_licencia').val();
    var motivo_traslado = $('#motivo_traslado').val();
    var tipo_documento = $('#tipo_documento').val();
    var numero_documento = $('#numero_documento').val();
    var departamento_partida = $('#departamento_partida').val();
    var provincia_partida = $('#provincia_partida').val();
    var distrito_partida = $('#distrito_partida').val();
    var departamento_llegada = $('#departamento_llegada').val();
    var provincia_llegada = $('#provincia_llegada').val();
    var distrito_llegada = $('#distrito_llegada').val();
    var peso = $('#peso').val();
    var descripcion_motivo = $('#descripcion_motivo').val();

    if(fecha_emision==""){msg+="Ingrese la Fecha de Emision <br>";}
    //alert(motivo_traslado!==06);
    if(motivo_traslado!=='06' && motivo_traslado!=='07'){
        if(punto_partida==""){msg+="Ingrese el Punto de Partida <br>";}
    }
    if(fecha_inicio_traslado==""){msg+="Ingrese la Fecha de traslado <br>";}
    if(marca_placa==""){msg+="Ingrese la Marca y Placa <br>";}
    if(numero_licencia==""){msg+="Ingrese el Numero de Licencia <br>";}
    if(motivo_traslado==""){msg+="Ingrese el Motivo de Traslado <br>";}
    if(tipo_documento==""){msg+="Ingrese el Tipo de Documento <br>";}
    if(numero_documento==""){msg+="Ingrese el Numero de Documento <br>";}
    if(departamento_partida==""){msg+="Ingrese el Departamento de Partida <br>";}   
    if(provincia_partida==""){msg+="Ingrese la Provincia de Partida <br>";}   
    if(distrito_partida==""){msg+="Ingrese el Distrito de Partida <br>";}   
    if(departamento_llegada==""){msg+="Ingrese el Departamento de Llegada <br>";}   
    if(provincia_llegada==""){msg+="Ingrese la Provincia de Llegada <br>";}   
    if(distrito_llegada==""){msg+="Ingrese el Distrito de Llegada <br>";}   
    if(peso==""){msg+="Ingrese el Peso <br>";}

    if(motivo_traslado==13 && descripcion_motivo==""){
        msg+="Ingrese la Descripcion del Traslado <br>";
    }

    if ($('#tblGuiaInternaDetalle tbody tr').length == 0) {
        msg += "No se ha agregado ningún producto <br>";
    }

    if(msg!=""){
        bootbox.alert(msg);
        return false;
    }else{
        var msgLoader = "";
        msgLoader = "Procesando, espere un momento por favor";
        var heightBrowser = $(window).width()/2;
        $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
        $('.loader').show();

        $.ajax({
            url: "/guia_interna/send_guia_interna",
            type: "POST",
            data : $("#frmDatosGuia").serialize(),
            success: function (result) {

                $('#openOverlayOpc').modal('hide');
                datatablenew();
                $('.loader').hide();
                bootbox.alert("Se guard&oacute; satisfactoriamente"); 
                
            }
        });
    }
}

function pdf_guia_interna(){

    var id = $('#id').val();

    var href = '/guia_interna/guia_interna_pdf/'+id;
    window.open(href, '_blank');

}

function obtener_ruc(){

    destinatario = $('#destinatario').val();

    $.ajax({
        url: "/empresa/obtener_empresa_id/"+destinatario,
        dataType: "json",
        success: function (result) {

            $('#ruc').val(result.empresa[0].ruc);

        }
    });
}

function obtenerProvinciaContacto(ubigeo){
	
	var id = ubigeo.substring(0, 2);
    $('#departamento_llegada').val(id);
	if(id=="")return false;
	$('#provincia_llegada').attr("disabled",true);
	$('#distrito_llegada').attr("disabled",true);
	
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
			$('#provincia_llegada').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_provincia+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#provincia_llegada').html(option);
			
			var option2 = "<option value=''>--Seleccionar--</option>";
			$('#distrito_llegada').html(option2);
			
			$('#provincia_llegada').attr("disabled",false);
			$('#distrito_llegada').attr("disabled",false);
			
			$('.loader').hide();
            
            obtenerDatosUbigeoContacto(ubigeo);
		}
	});
}

function obtenerDatosUbigeoContacto(ubigeo){

    var provincia = ubigeo.substring(2, 4);

    $('#provincia_llegada').val(provincia);

    obtenerDistritoContacto_(function(){

        $('#distrito_llegada').val(ubigeo);

    });
}

function obtenerDistritoContacto_(callback){

    var departamento = $('#departamento_llegada').val();
    var id = $('#provincia_llegada').val();
    if(id=="")return false;
    $('#distrito_llegada').attr("disabled",true);

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
            $('#distrito_llegada').html("");
            $(result).each(function (ii, oo) {
                option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
            });
            $('#distrito_llegada').html(option);
            
            $('#distrito_llegada').attr("disabled",false);
            $('.loader').hide();

            callback();
        
        }
    });
}

function agregarVehiculo(){
	
	$.ajax({
        url: "/vehiculo/modal_vehiculo_guia/"+0,
        type: "GET",
        success: function (result) {
            $("#diveditpregOpc2").html(result);
            $('#openOverlayOpc2').modal('show');

            $.fn.modal.Constructor.prototype.enforceFocus = function() {};
            
            setTimeout(() => {
                $('#empresa').select2({
                    width: '100%',
                    dropdownParent: $('#openOverlayOpc2')
                });

                $('#conductor').select2({
                    width: '100%',
                    dropdownParent: $('#openOverlayOpc2')
                });
            }, 100);

            $('#motivo_traslado').select2('close');
        }
	});
}

function agregarConductor(){
	
    var id_empresa_conductor_vehiculo = $('#id_empresa_conductor_vehiculo').val();

	$.ajax({
        url: "/conductores/modal_conductor_guia/"+0+"/"+id_empresa_conductor_vehiculo,
        type: "GET",
        success: function (result) {
            $("#diveditpregOpc3").html(result);
            $('#openOverlayOpc3').modal('show');
        }
	});
}

function agregarEmpresaTransporte(){
	
    var placa = $('#placa_guia').val();
    var id_empresa_conductor_vehiculo = $('#id_empresa_conductor_vehiculo').val();

	$.ajax({
        url: "/empresa/modal_empresa_guia/"+0+"/"+placa+"/"+id_empresa_conductor_vehiculo,
        type: "GET",
        success: function (result) {
            $("#diveditpregOpc4").html(result);
            $('#openOverlayOpc4').modal('show');
        }
	});
}

function agregarDestinatario(){
	
	$.ajax({
        url: "/empresa/modal_empresa_guia/"+0,
        type: "GET",
        success: function (result) {  
            $("#diveditpregOpc4").html(result);
            $('#openOverlayOpc4').modal('show');
        }
	});
}

function obtenerEmpresa(){
		
    var placa = $("#placa_guia").val();
    var msg = "";
    
    if (msg != "") {
        bootbox.alert(msg);
        return false;
    }
    
    $('#marca_vehiculo').val("");
    //$('#ruc_transporte').val("");
    //$('#transporte_razon_social').val("");
    $('#conductor_guia').val("");
    $('#id_empresa_conductor_vehiculo').val("");
    
    $("#placa_guia").attr("readonly",false);
    $("#marca_vehiculo").attr("readonly",false);
    //$("#transporte_razon_social").attr("readonly",false);
    
    $.ajax({
        url: '/ingreso_vehiculo_tronco/obtener_datos_vehiculo_guia/' + placa,
        dataType: "json",
        success: function(result){
            
            if(result.sw==false){
                bootbox.alert(result.msg);
            }else{
                var vehiculo = result.vehiculo;
                //$('#ruc_transporte').val(vehiculo.ruc);
                $('#marca_vehiculo').val(vehiculo.marca);
                $('#id_marca_vehiculo').val(vehiculo.id_marca);
                //$('#id_transporte_razon_social').val(vehiculo.id_empresas);
                //$('#transporte_razon_social').val(vehiculo.razon_social);
                $('#id_empresa_conductor_vehiculo').val(vehiculo.id);
                $('#numero_inscripcion').val(vehiculo.constancia_inscripcion);
                $("#marca_vehiculo").attr("readonly",true);
                $("#ruc_transporte").attr("readonly",true);
                //$("#transporte_razon_social").attr("readonly",true);
                var conductores = result.conductores;
                var option = "<option value=''>Seleccionar</option>";
                $('#conductor_guia').html("");
                var id_conductor = <?php echo json_encode($guia_transportista->id_conductor); ?>;

                $(conductores).each(function (ii, oo) {
                    
                    var selected = (oo.id_conductores == id_conductor) ? "selected='selected'" : "";

                    option += "<option value='" + oo.id_conductores + "' " + selected + ">" + oo.conductor + "</option>";
                });
                $('#conductor_guia').html(option);
                                
            }
        }
    });
}

function obtenerProvinciaPartida(){
	
	var id = $('#departamento_partida').val();
	if(id=="")return false;
	$('#provincia_partida').attr("disabled",true);
	$('#distrito_partida').attr("disabled",true);
	
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
			$('#provincia_partida').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_provincia+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#provincia_partida').html(option);
			
			var option2 = "<option value=''>--Seleccionar--</option>";
			$('#distrito_partida').html(option2);
			
			$('#provincia_partida').attr("disabled",false);
			$('#distrito_partida').attr("disabled",false);
			
			$('.loader').hide();
		}
	});
}

function obtenerDistritoPartida(){
	
	var id_departamento = $('#departamento_partida').val();
	var id = $('#provincia_partida').val();
	if(id=="")return false;
	$('#distrito_partida').attr("disabled",true);
	
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
			$('#distrito_partida').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#distrito_partida').html(option);
			
			$('#distrito_partida').attr("disabled",false);
			$('.loader').hide();
		}
	});
}

function obtenerProvinciaLlegada(){
	
	var id = $('#departamento_llegada').val();
	if(id=="")return false;
	$('#provincia_llegada').attr("disabled",true);
	$('#distrito_llegada').attr("disabled",true);
	
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
			$('#provincia_llegada').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_provincia+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#provincia_llegada').html(option);
			
			var option2 = "<option value=''>--Seleccionar--</option>";
			$('#distrito_llegada').html(option2);
			
			$('#provincia_llegada').attr("disabled",false);
			$('#distrito_llegada').attr("disabled",false);
			
			$('.loader').hide();
		}
	});
}

function obtenerDistritoLlegada(){
	
	var id_departamento = $('#departamento_llegada').val();
	var id = $('#provincia_llegada').val();
	if(id=="")return false;
	$('#distrito_llegada').attr("disabled",true);
	
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
			$('#distrito_llegada').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#distrito_llegada').html(option);
			
			$('#distrito_llegada').attr("disabled",false);
			$('.loader').hide();
		}
	});
}

function obtenerDatosUbigeoPartida(){

    var id = $('#id').val();

    $.ajax({
        url: '/guia_interna/obtener_provincia_distrito/'+id,
        dataType: "json",
        success: function(result){
            
            $('#provincia_partida').val(result[0].provincia_partida);

            obtenerDistritoPartida_(function(){

                $('#distrito_partida').val(result[0].distrito_partida);

            });
        }
    });
}

function obtenerDistritoPartida_(callback){
    
    var departamento = $('#departamento_partida').val();
    var id = $('#provincia_partida').val();
    if(id=="")return false;
    $('#distrito_partida').attr("disabled",true);

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
            $('#distrito_partida').html("");
            $(result).each(function (ii, oo) {
                option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
            });
            $('#distrito_partida').html(option);
            
            $('#distrito_partida').attr("disabled",false);
            $('.loader').hide();

            callback();
        
        }
    });
}

function obtenerDatosUbigeoLlegada(){

    var id = $('#id').val();

    $.ajax({
        url: '/guia_interna/obtener_provincia_distrito/'+id,
        dataType: "json",
        success: function(result){
            
            $('#provincia_llegada').val(result[0].provincia_llegada);

            obtenerDistritoLlegada_(function(){

                $('#distrito_llegada').val(result[0].distrito_llegada);

            });
        }
    });
}

function obtenerDistritoLlegada_(callback){

    var departamento = $('#departamento_llegada').val();
    var id = $('#provincia_llegada').val();
    if(id=="")return false;
    $('#distrito_llegada').attr("disabled",true);

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
            $('#distrito_llegada').html("");
            $(result).each(function (ii, oo) {
                option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
            });
            $('#distrito_llegada').html(option);
            
            $('#distrito_llegada').attr("disabled",false);
            $('.loader').hide();

            callback();
        
        }
    });
}

function cambiarLlegadaPartida(){
    
    var departamento_llegada = $('#departamento_llegada').val();
    var provincia_llegada = $('#provincia_llegada').val();
    var distrito_llegada = $('#distrito_llegada').val();

}        

function actualizarDescripciones() {
    var descripcion_partida = $('#punto_partida option:selected').text();
    $('#punto_partida_descripcion').val(descripcion_partida);

    var descripcion_llegada = $('#punto_llegada_select option:selected').text();
    $('#punto_llegada_descripcion').val(descripcion_llegada);
    //alert(descripcion_llegada);
}

$('#punto_partida').on('change', function(){

    var descripcion = $('#punto_partida option:selected').text();

    $('#punto_partida_descripcion').val(descripcion);

});

$('#punto_llegada_select').on('change', function(){

    var descripcion = $('#punto_llegada_select option:selected').text();

    $('#punto_llegada_descripcion').val(descripcion);

});

function generarGuia(){

    var numero_guia = $('#id').val();

    numero_guia = parseInt(numero_guia,10);

    $.ajax({
        url: "/comprobante/guia_json/"+numero_guia,
        dataType: "json",
        success: function(result){
            console.log(result);
            if (result.notes == "FIRMADO") {
                bootbox.alert("El documento ha sido firmado correctamente.");
            } else {
                bootbox.alert(result.notes);
            }
        }
    });
}

function obtenerLicencia(){

    var conductor_guia = $('#conductor_guia').val();

    $('#numero_licencia').val("");
    $("#numero_licencia").attr("readonly",false);

    if(conductor_guia==0){
        $('#numero_licencia').val("");
        $("#numero_licencia").attr("readonly",false);
    }else{

    $.ajax({
        url: "/conductores/obtener_licencia/"+conductor_guia,
        dataType: "json",
        success: function(result){
            //bootBox.alert("Se envió a la Sunat la Guia");

            var conductores = result.conductores;
            $('#numero_licencia').val(conductores[0].licencia);
            $("#numero_licencia").attr("readonly",false);
        }
    });
    }
}

function obtenerUbigeo() {
    if ($('#punto_partida').val() == "0001"){
        $('#departamento_partida').val(15);
        obtenerProvinciaPartida_edit(function () {
            $('#provincia_partida').val("01");
            obtenerDistritoPartida_edit(function () {
                $('#distrito_partida').val("150142");
            });
        });
    }else if($('#punto_partida').val() == "0003"){
        $('#departamento_partida').val(19);
        obtenerProvinciaPartida_edit(function () {
            $('#provincia_partida').val("03");
            obtenerDistritoPartida_edit(function () {
                $('#distrito_partida').val("190301");
            });
        });
    }
}

function obtenerProvinciaPartida_edit(callback){
	
	var id = $('#departamento_partida').val();
	if(id=="")return false;
	$('#provincia_partida').attr("disabled",true);
	$('#distrito_partida').attr("disabled",true);
	
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
			$('#provincia_partida').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_provincia+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#provincia_partida').html(option);
			
			var option2 = "<option value=''>--Seleccionar--</option>";
			$('#distrito_partida').html(option2);
			
			$('#provincia_partida').attr("disabled",false);
			$('#distrito_partida').attr("disabled",false);
			
			$('.loader').hide();

            if (callback) callback(); 
		}
	});
}

function obtenerDistritoPartida_edit(callback){
	
	var id_departamento = $('#departamento_partida').val();
	var id = $('#provincia_partida').val();
	if(id=="")return false;
	$('#distrito_partida').attr("disabled",true);
	
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
			$('#distrito_partida').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#distrito_partida').html(option);
			
			$('#distrito_partida').attr("disabled",false);
			$('.loader').hide();

            if (callback) callback(); 

		}
	});
}

function obtenerUbigeoLlegada() {
    if ($('#punto_llegada_select').val() == "0001"){
        $('#departamento_llegada').val(15);
        obtenerProvinciaLlegada_edit(function () {
            $('#provincia_llegada').val("01");
            obtenerDistritoLlegada_edit(function () {
                $('#distrito_llegada').val("150142");
            });
        });
    }else if($('#punto_llegada_select').val() == "0003"){
        $('#departamento_llegada').val(19);
        obtenerProvinciaLlegada_edit(function () {
            $('#provincia_llegada').val("03");
            obtenerDistritoLlegada_edit(function () {
                $('#distrito_llegada').val("190301");
            });
        });
    }
}

function obtenerProvinciaLlegada_edit(callback){
	
	var id = $('#departamento_llegada').val();
	if(id=="")return false;
	$('#provincia_llegada').attr("disabled",true);
	$('#distrito_llegada').attr("disabled",true);
	
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
			$('#provincia_llegada').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_provincia+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#provincia_llegada').html(option);
			
			var option2 = "<option value=''>--Seleccionar--</option>";
			$('#distrito_llegada').html(option2);
			
			$('#provincia_llegada').attr("disabled",false);
			$('#distrito_llegada').attr("disabled",false);
			
			$('.loader').hide();

            if (callback) callback(); 
		}
	});
}

function obtenerDistritoLlegada_edit(callback){
	
	var id_departamento = $('#departamento_llegada').val();
	var id = $('#provincia_llegada').val();
	if(id=="")return false;
	$('#distrito_llegada').attr("disabled",true);
	
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
			$('#distrito_llegada').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#distrito_llegada').html(option);
			
			$('#distrito_llegada').attr("disabled",false);
			$('.loader').hide();

            if (callback) callback(); 

		}
	});
}

function cambiarCliente(){

    var tipo_documento_cliente = $('#tipo_documento_cliente').val();
    
    var ruc = $('#ruc').val("");
    var destinatario_nombre = $('#destinatario_nombre').val("");
    var dni_destinatario = $('#dni_destinatario').val("");
    var persona_destinatario_nombre = $('#persona_destinatario_nombre').val("");

    if(tipo_documento_cliente == 1){
        $('#div_persona').show();
        $('#div_empresa').hide();
        $('#div_dni').show();
        $('#div_ruc').hide();
        $('#dni_destinatario_label').show();
        $('#dni_destinatario_input').show();
        $('#nombre_destinatario_label').show();
        $('#nombre_destinatario_input').show();
    }else if(tipo_documento_cliente == 5){
        $('#div_persona').hide();
        $('#div_empresa').show();
        $('#div_dni').hide();
        $('#div_ruc').show();
        $('#ruc_destinatario_label').show();
        $('#ruc_destinatario_input').show();
        $('#empresa_destinatario_label').show();
        $('#empresa_destinatario_input').show();
    }
}

function obtenerEmpresaDestinatario(){
	
    var ruc = $("#ruc").val();
    var msg = "";
    
    if (msg != "") {
        bootbox.alert(msg);
        return false;
    }
    
    $('#destinatario_nombre').val("");
    $("#destinatario_nombre").attr("readonly",false);
    
    $.ajax({
        url: '/empresa/obtener_empresa/' + ruc,
        dataType: "json",
        success: function(result){
            
            if(result.sw==false){
                bootbox.alert(result.msg);
            }else{
                var empresa = result.empresa;
                $('#destinatario_nombre').val(empresa.razon_social);
                $("#destinatario_nombre").attr("readonly",true);
                $('#destinatario').val(empresa.id);
            }
        }
    });
}

function obtenerPersonaDestinatario(){
	
    var dni_destinatario = $("#dni_destinatario").val();
    var tipo_documento_cliente = $("#tipo_documento_cliente").val();
    var msg = "";
    
    if (msg != "") {
        bootbox.alert(msg);
        return false;
    }
    
    $('#persona_destinatario_nombre').val("");
    $("#persona_destinatario_nombre").attr("readonly",false);
    
    $.ajax({
        url: '/persona/obtener_persona/' + tipo_documento_cliente +'/'+dni_destinatario,
        dataType: "json",
        success: function(result){
            
            if(result.sw==false){
                bootbox.alert(result.msg);
            }else{
                var persona = result.persona;
                $('#persona_destinatario_nombre').val(persona.apellido_paterno + " " + persona.apellido_materno + " " + persona.nombres);
                $("#persona_destinatario_nombre").attr("readonly",true);
                $('#destinatario').val(persona.id);
            }
        }
    });
}

function agregarProducto(){

    var opcionesDescripcion = `<?php
        echo '<option value="">--Seleccionar--</option>';
        foreach ($producto as $row) {
            echo '<option value="' . htmlspecialchars($row->id, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($row->codigo . ' - ' . $row->denominacion, ENT_QUOTES, 'UTF-8') . '</option>';
        }
    ?>`;

    var cantidad = 1;
    var newRow = "";
    for (var i = 0; i < cantidad; i++) { 
        var n = $('#tblGuiaTransportistaDetalle tbody tr').length + 1;
        var descripcion = '<input name="id_guia_transportista_detalle[]" id="id_guia_transportista_detalle${n}" class="form-control form-control-sm" value="${guia_transportista.id}" type="hidden"><select name="descripcion[]" id="descripcion' + n + '" class="form-control form-control-sm" onChange="obtenerCodInterno(this, ' + n + ')"> ' + opcionesDescripcion +' </select>';
        var descripcion_ant = '<input type="hidden" name="descripcion_ant[]" id="descripcion_ant' + n + '" class="form-control form-control-sm" />';
        var codigo = '<input name="cod_interno[]" id="cod_interno' + n + '" class="form-control form-control-sm" value="" type="text">';
        var unidad = '<select name="unidad[]" id="unidad' + n + '" class="form-control form-control-sm" onChange=""> <option value="">--Seleccionar--</option> <?php foreach ($unidad as $row) {?> <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option> <?php } ?> </select>';
        var cantidad = '<input name="cantidad[]" id="cantidad' + n + '" class="cantidad form-control form-control-sm" value="" type="text">';
        
        var btnEliminar = '<button type="button" class="btn btn-sm btn-clasico btn-eliminar" onclick="eliminarFila(this)"><i class="fas fa-trash" style="font-size:18px;"></i></button>';

        newRow += '<tr>';
        newRow += '<td>' + n + '</td>';
        newRow += '<td style="width: 900px!important; display:block!important">' +descripcion_ant + descripcion + '</td>';
        newRow += '<td>' + codigo + '</td>';
        newRow += '<td>' + unidad + '</td>';
        newRow += '<td>' + cantidad + '</td>';
        newRow += '<td>' + btnEliminar + '</td>';
        newRow += '</tr>';

        $('#tblGuiaTransportistaDetalle tbody').append(newRow);

        $('#descripcion' + n).select2({
            width: '100%',
            dropdownParent: $('#openOverlayOpc'),
            dropdownCssClass: 'custom-select2-dropdown',
        });
    }
}

function obtenerCodInterno(selectElement, n){

    var id_producto = $(selectElement).val();

    $.ajax({
        url: "/productos/obtener_producto/"+id_producto,
        dataType: "json",
        success: function(result){

            $('#cod_interno' + n).val(result[0].codigo);
            $('#marca' + n).val(result[0].id_marca).trigger('change');
            $('#unidad' + n).val(result[0].id_unidad_producto);
            
        }
    });
}

</script>

<body class="hold-transition skin-blue sidebar-mini">

    <div>
		<div class="justify-content-center">

            <div class="card modal-scrollable">
                <div style="text-align: center; font-size:16px; margin-top: 20px">
                    <b>Datos de Guia</b>
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmDatosGuiaTransportista" name="frmDatosGuiaTransportista">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                        
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                    
                        <div class="row" style="padding-left:10px; padding-bottom:10px;">
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-4">
                                        Serie
                                    </div>
                                    <div class="col-lg-5">
                                        <select name="serie_guia" id="serie_guia" class="form-control form-control-sm" onchange="">
                                            <?php 
                                            foreach ($serie_guia as $row){?>
                                                <option value="<?php echo $row->denominacion ?>" <?php echo ($id > 0 && $row->denominacion==$guia_transportista->guia_serie) ? "selected='selected'" : (($row->denominacion == "T001")  ? "selected='selected'" : "");?>><?php echo $row->denominacion ?></option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-4">
                                        N&uacute;mero
                                    </div>
                                    <div class="col-lg-5">
                                        <input id="numero_guia" name="numero_guia" on class="form-control form-control-sm"  value="<?php echo ($id>0) ? str_pad($guia_transportista->guia_numero, 4, '0', STR_PAD_LEFT) :''; ?> " type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="row" style="padding-left:10px; padding-bottom:10px;">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            Fecha de Emisi&oacute;n
                                        </div>
                                        <div class="col-lg-5">
                                            <input id="fecha_emision_" name="fecha_emision_" on class="form-control form-control-sm"  value="<?php echo isset($guia_transportista) && $guia_transportista->fecha_emision ? $guia_transportista->fecha_emision : date('Y-m-d'); ?>" type="text" disabled="disabled">
                                            <input type="hidden" name="fecha_emision" id="fecha_emision" value="<?php echo isset($guia_transportista) && $guia_transportista->fecha_emision ? $guia_transportista->fecha_emision : date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            Fecha de Inicio Traslado
                                        </div>
                                        <div class="col-lg-5">
                                            <input id="fecha_inicio_traslado" name="fecha_inicio_traslado" on class="form-control form-control-sm"  value="<?php echo isset($guia_transportista) && $guia_transportista->fecha_traslado ? $guia_transportista->fecha_traslado : date('Y-m-d'); ?>" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px; padding-bottom:10px;">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            Serie Relacionado
                                        </div>
                                        <div class="col-lg-5">
                                            <input id="serie_relacionado" name="serie_relacionado" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_transportista->guia_serie_relacionado;} ?>" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            N&uacute;mero Relacionado
                                        </div>
                                        <div class="col-lg-5">
                                            <input id="numero_relacionado" name="numero_relacionado" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_transportista->guia_num_relacionado;} ?>" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px; padding-bottom:10px;">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            N° de Placa
                                        </div>
                                        <div class="col-lg-5">
                                            <input id="placa_guia" name="placa_guia" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_transportista->placa;} ?>" type="text" onchange="obtenerEmpresa()">
                                            <input name="id_empresa_conductor_vehiculo" id="id_empresa_conductor_vehiculo" class="form-control form-control-sm" value="" type="hidden">
                                        </div>
                                        <!--<div class="col-lg-3">
                                            <button id="btnPlaca" type="button" class="btn btn-warning btn-sm" data-toggle="modal" onclick="agregarVehiculo()">
                                                <i class="fas fa-plus-circle"></i>Vehiculo
                                            </button>
                                        </div>-->
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            N° Placa Carreta
                                        </div>
                                        <div class="col-lg-5">
                                            <input id="segunda_placa_guia" name="segunda_placa_guia" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_transportista->guia_vehiculo_segunda_placa;} ?>" type="text" onchange="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            Marca Vehiculo
                                        </div>
                                        <div class="col-lg-5">
                                            <input id="marca_vehiculo" name="marca_vehiculo" on class="form-control form-control-sm"  value="<?php //if($id>0){echo $guia_interna->placa;} ?>" type="text">
                                            <input name="id_marca_vehiculo" id="id_marca_vehiculo" class="form-control form-control-sm" value="" type="hidden">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px; padding-bottom:10px;">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            RUC Transporte
                                        </div>
                                        <div class="col-lg-5">
                                            <input id="ruc_transporte" name="ruc_transporte" on class="form-control form-control-sm"  value="20486785994" type="text" readonly="readonly">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            Raz&oacute;n Social Transporte
                                        </div>
                                        <div class="col-lg-5">
                                            <input id="transporte_razon_social" name="transporte_razon_social" on class="form-control form-control-sm"  value="FORESTAL PAMA S.A.C." type="text" readonly="readonly">
                                            <input name="id_transporte_razon_social" id="id_transporte_razon_social" class="form-control form-control-sm" value="30" type="hidden">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            Conductor
                                        </div>
                                        <div class="col-lg-5">
                                            <select name="conductor_guia" id="conductor_guia" class="form-control form-control-sm" onchange="obtenerLicencia()">
                                                <option value="">--Seleccionar--</option>
                                            </select>
                                        </div>
                                        <!--<div class="col-lg-3">
                                            <button id="btnConductor" type="button" class="btn btn-warning btn-sm" data-toggle="modal" onclick="agregarConductor()">
                                                <i class="fas fa-plus-circle"></i>Conductor
                                            </button>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px; padding-bottom:10px;">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            N° de Licencia de Conducir
                                        </div>
                                        <div class="col-lg-5">
                                            <input id="numero_licencia" name="numero_licencia" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_transportista->licencia_conducir;} ?>" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            N° Constancia Inscripci&oacute;n
                                        </div>
                                        <div class="col-lg-5">
                                            <input id="numero_inscripcion" name="numero_inscripcion" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_transportista->constancia_inscripcion;} ?>" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px; padding-bottom:10px;">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            Tipo Documento Cliente
                                        </div>
                                        <div class="col-lg-5">
                                            <select name="tipo_documento_cliente" id="tipo_documento_cliente" class="form-control form-control-sm" onchange="cambiarCliente()">
                                                <option value="">--Seleccionar--</option>
                                                <?php
                                                foreach ($tipo_documento_cliente as $row){?>
                                                    <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$guia_transportista->id_tipo_cliente)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4" id="div_ruc">
                                    <div class="row">
                                        <div class="col-lg-4" id="ruc_destinatario_label">
                                            RUC Destinatario
                                        </div>
                                        <div class="col-lg-5" id="ruc_destinatario_input">
                                            <input id="ruc" name="ruc" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_transportista->ruc_destinatario;} ?>" type="text" onchange="obtenerEmpresaDestinatario()">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4" id="div_dni">
                                    <div class="row">
                                        <div class="col-lg-4" id="dni_destinatario_label">
                                            DNI Destinatario
                                        </div>
                                        <div class="col-lg-5" id="dni_destinatario_input">
                                            <input id="dni_destinatario" name="dni_destinatario" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_transportista->dni_destinatario;} ?>" type="text" onchange="obtenerPersonaDestinatario()">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4" id="div_empresa">
                                    <div class="row">
                                        <div class="col-lg-4" id="empresa_destinatario_label">
                                            Nombre Destinatario
                                        </div>
                                        <div class="col-lg-5" id="empresa_destinatario_input">
                                            <input id="destinatario_nombre" name="destinatario_nombre" on class="form-control form-control-sm"  value="<?php //if($id>0){echo $guia_interna->licencia_conducir;} ?>" type="text">
                                            <input name="destinatario" id="destinatario" class="form-control form-control-sm" value="" type="hidden">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4" id="div_persona">
                                    <div class="row">
                                        <div class="col-lg-4" id="nombre_destinatario_label">
                                            Nombre Destinatario
                                        </div>
                                        <div class="col-lg-5" id="nombre_destinatario_input">
                                            <input id="persona_destinatario_nombre" name="persona_destinatario_nombre" on class="form-control form-control-sm"  value="<?php //if($id>0){echo $guia_interna->licencia_conducir;} ?>" type="text">
                                            <input name="persona_destinatario" id="persona_destinatario" class="form-control form-control-sm" value="" type="hidden">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px; padding-bottom:10px;">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            Observaci&oacute;n
                                        </div>
                                        <div class="col-lg-8">
                                            <input id="observacion_guia" name="observacion_guia" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_transportista->observacion;} ?>" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            Peso
                                        </div>
                                        <div class="col-lg-5">
                                            <input id="peso" name="peso" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_transportista->peso;} ?>" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <fieldset name="punto_partida_name" style="border:1px solid #A4A4A4; padding: 10px">
                                <legend class="control-label form-control-sm">Punto de Partida</legend>
                                <div class="row" style="padding-left:10px; padding-bottom:10px;">
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                Departamento
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <select name="departamento_partida" id="departamento_partida" onChange="obtenerProvinciaPartida()" class="form-control form-control-sm">
                                                        <?php if($id>0){ ?> 
                                                        <option value="">--Seleccionar--</option>
                                                        <?php
                                                        foreach ($departamento as $row) {?>
                                                        <option value="<?php echo $row->id_departamento?>" <?php if($row->id_departamento==substr($guia_transportista->id_ubigeo_partida,0,2))echo "selected='selected'"?>><?php echo $row->desc_ubigeo ?></option>
                                                        <?php 
                                                        }
                                                        }else{?>
                                                        <option value="">--Seleccionar--</option>
                                                            <?php
                                                            foreach ($departamento as $row) {
                                                            ?>
                                                            <option value="<?php echo $row->id_departamento?>"><?php echo $row->desc_ubigeo ?></option>
                                                            <?php 
                                                                
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                Provincia
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <select name="provincia_partida" id="provincia_partida" class="form-control form-control-sm" onchange="obtenerDistritoPartida()">
                                                        <option value="">--Seleccionar--</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                Distrito
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <select name="distrito_partida" id="distrito_partida" class="form-control form-control-sm" onchange="">
                                                        <option value="">--Seleccionar--</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3" id="input_punto_partida">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                Punto de Partida
                                            </div>
                                            <div class="col-lg-9">
                                                <input name="punto_partida" id="punto_partida" on class="form-control form-control-sm" value="<?php if($id>0){echo $guia_transportista->punto_partida;}?>" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset name="punto_llegada_name" style="border:1px solid #A4A4A4; padding: 10px">
                                <legend class="control-label form-control-sm">Punto de Llegada</legend>
                                <div class="row" style="padding-left:10px; padding-bottom:10px;">
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                Departamento
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <select name="departamento_llegada" id="departamento_llegada" onChange="obtenerProvinciaLlegada()" class="form-control form-control-sm">
                                                        <?php if($id>0){ ?> 
                                                        <option value="">--Seleccionar--</option>
                                                        <?php
                                                        foreach ($departamento as $row) {?>
                                                        <option value="<?php echo $row->id_departamento?>" <?php if($row->id_departamento==substr($guia_transportista->id_ubigeo_llegada,0,2))echo "selected='selected'"?>><?php echo $row->desc_ubigeo ?></option>
                                                        <?php 
                                                        }
                                                        }else{?>
                                                        <option value="">--Seleccionar--</option>
                                                            <?php
                                                            foreach ($departamento as $row) {
                                                            ?>
                                                            <option value="<?php echo $row->id_departamento?>"><?php echo $row->desc_ubigeo ?></option>
                                                            <?php 
                                                                
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                Provincia
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <select name="provincia_llegada" id="provincia_llegada" class="form-control form-control-sm" onchange="obtenerDistritoLlegada()">
                                                        <option value="">--Seleccionar--</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                Distrito
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <select name="distrito_llegada" id="distrito_llegada" class="form-control form-control-sm" onchange="">
                                                        <option value="">--Seleccionar--</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3" id="input_punto_llegada">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                Punto de Llegada
                                            </div>
                                            <div class="col-lg-9">
                                                <input id="punto_llegada" name="punto_llegada" on class="form-control form-control-sm"  value="<?php if($id>0){echo $guia_transportista->punto_llegada;}?>" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div style="margin-top:15px;" class="form-group">
                                <div class="col-sm-12 controls">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
                                            <button type="button" class="btn btn-sm btn-clasico-blanco btn-agregar" data-toggle="modal" onclick="agregarProducto()">
                                                <i class="fas fa-plus-circle" style="font-size:18px;"></i> Agregar Producto
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">	
                            <div class="table-responsive" style="overflow-y: auto; max-height: 300px;">
                                <table id="tblGuiaTransportistaDetalle" class="table table-hover table-sm">
                                    <thead>
                                    <tr style="font-size:13px">
                                        <th>#</th>
                                        <th>Descripci&oacute;n</th>
                                        <th>C&oacute;digo</th>
                                        <th>Unidad</th>
                                        <th>Cantidad</th>
                                    </tr>
                                    </thead>
                                    <tbody id="divGuiaTransportistaDetalle">
                                    </tbody>
                                </table>
                            </div>
                            <div style="margin-top:15px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                        <?php 
                                            if($id>0){
                                        ?>
                                        <?php 
                                            }
                                        ?>
                                        <?php if($id_user==$guia_transportista->id_usuario_inserta && $id>0 && $guia->guia_estado_sunat !='FIRMADO'){?>
                                            <!--<a href="javascript:void(0)" onClick="fn_save_guia_interna()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>-->
                                            <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-nuevo" data-toggle="modal" onclick="fn_save_guia_interna()">
                                                <i class="fas fa-save" style="font-size:18px;"></i> Guardar
                                            </button>
                                        <?php }?>
                                        <?php if($id==0){?>
                                            <!--<a href="javascript:void(0)" onClick="fn_save_guia_interna()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>-->
                                            <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-nuevo" data-toggle="modal" onclick="fn_save_guia_interna()">
                                                <i class="fas fa-save" style="font-size:18px;"></i> Guardar
                                            </button>
                                        <?php }?>
                                        <?php 
                                            if($id>0 && $guia->guia_estado_sunat !='FIRMADO'){
                                        ?>
                                            <a href="javascript:void(0)" onClick="generarGuia()" class="btn btn-sm btn-danger" style="margin-right:10px"><i class="fa fa-paper-plane"></i>Enviar Sunat</a> 
                                        <?php } if($id>0 && $guia->guia_estado_sunat =='FIRMADO'){?>
                                            <a href="javascript:void(0)" onClick="generarGuia()" class="btn btn-sm btn-danger" style="margin-right:10px; pointer-events: none; opacity: 0.6; cursor: not-allowed;"><i class="fa fa-paper-plane"></i>Enviar Sunat</a> 
                                        <?php }?>
                                        <?php if($id>0 && $guia->guia_estado_sunat =='FIRMADO'){?>
                                            <a href="http://forespama.felmo.pe/<?php echo $guia->guia_ruta_comprobante;?>" target="_blank" class="btn btn-sm btn-warning" style="margin-right:10px"><i class="fa fa-file-pdf"></i>Ver Gu&iacute;a</a>
                                        <?php }?>
                                        <!--<a href="javascript:void(0)" onClick="$('#openOverlayOpc').modal('hide');" class="btn btn-sm btn-info" style="">Cerrar</a>-->
                                        <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-cerrar" data-toggle="modal" onclick="$('#openOverlayOpc').modal('hide');">
                                            <i class="fas fa-times-circle" style="font-size:18px;"></i> Cerrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
                <!-- /.box -->
            </div>
            <!--/.col (left) -->
        </div>
        <!-- /.row -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div id="openOverlayOpc2" class="modal fade modal-vehiculo" tabindex="-1" role="dialog">
    <div class="modal-dialog" >

    <div id="id_content_OverlayoneOpc" class="modal-content" style="padding: 0px;margin: 0px">

        <div class="modal-body" style="padding: 0px;margin: 0px">

            <div id="diveditpregOpc2"></div>

        </div>

    </div>

    </div>

</div>

<div id="openOverlayOpc3" class="modal fade modal-conductor" tabindex="-1" role="dialog">
    <div class="modal-dialog" >

    <div id="id_content_OverlayoneOpc" class="modal-content" style="padding: 0px;margin: 0px">

        <div class="modal-body" style="padding: 0px;margin: 0px">

            <div id="diveditpregOpc3"></div>

        </div>

    </div>

    </div>

</div>

<div id="openOverlayOpc4" class="modal fade modal-destinatario" tabindex="-1" role="dialog">
    <div class="modal-dialog" >

    <div id="id_content_OverlayoneOpc" class="modal-content" style="padding: 0px;margin: 0px">

        <div class="modal-body" style="padding: 0px;margin: 0px">

            <div id="diveditpregOpc4"></div>

        </div>

    </div>

    </div>

</div>
    
<script type="text/javascript">
$(document).ready(function () {
	
});


</script>

<script type="text/javascript">
$(document).ready(function() {

});




</script>

