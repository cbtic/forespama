<title>FORESPAMA</title>

<style>
/*
.datepicker {
  z-index: 1600 !important; 
}
*/
/*.datepicker{ z-index:99999 !important; }*/

.datepicker,
.table-condensed {
    width: 250px;
    height:250px;
}

.modal-dialog {
    width: 100%;
    max-width:85%!important
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
  /*background-color: red!important;*/
  font-weight:bold;
  /*mix-blend-mode: difference;*/
  
}

#tablemodalm{
	
}

.scrolls {
	overflow-x: scroll;
	overflow-y: hidden;
	height: 300px;
	white-space:nowrap;
    width: 350px;
}

.delete_ruta{
	background-image:url(/img/delete.png);
	top:0px;
	left:110px;
	background-size: 100%;
	position:absolute;
	display:block;
	width:30px;
	height:30px;
	cursor:pointer
}

.img_ruta img {
  border-radius: 6px;
  box-shadow: 0 2px 6px rgba(0,0,0,.15);
  transition: transform .2s;
}

.img_ruta img:hover {
  transform: scale(1.05);
}

input[readonly] {
  background-color: #f8f9fa;
  cursor: not-allowed;
}

.fieldset {
  background-color: #f8f9fb;   /* gris suave */
  border: 1px solid #e2e6ea;
  border-radius: 10px;
  padding: 16px;
  margin-bottom: 25px;
}

</style>

<!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>-->
<!--<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>-->
<!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>-->


<!--<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>-->


<!--Se quito estas dos lineas de datepicker y se puso las 3 de abajo -->
<!--<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />-->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/locales/bootstrap-datepicker.es.min.js" charset="UTF-8"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker3.css" />


<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>-->

<!--
<script src="resources/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<link rel="stylesheet" href="resources/plugins/timepicker/bootstrap-timepicker.min.css">
-->

<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.css">
-->

<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/js/bootstrap-datetimepicker.min.js" integrity="sha512-r/mHP22LKVhxWFlvCpzqMUT4dWScZc6WRhBMVUQh+SdofvvM1BS1Hdcy94XVOod7QqQMRjLQn5w/AQOfXTPvVA==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/css/bootstrap-datetimepicker.css" integrity="sha512-HWqapTcU+yOMgBe4kFnMcJGbvFPbgk39bm0ExFn0ks6/n97BBHzhDuzVkvMVVHTJSK5mtrXGX4oVwoQsNcsYvg==" crossorigin="anonymous" />
-->

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>-->
<script type="text/javascript">
/*
jQuery(function($){
$.mask.definitions['H'] = "[0-1]";
$.mask.definitions['h'] = "[0-9]";
$.mask.definitions['M'] = "[0-5]";
$.mask.definitions['m'] = "[0-9]";
$.mask.definitions['P'] = "[AaPp]";
$.mask.definitions['p'] = "[Mm]";
});
*/
$(document).ready(function() {

    $('#fecha_vencimiento').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    $("#unidad_producto, #unidad_medida, #marca, #modelo, #medida, #tipo_producto").select2({ width: '100%' });

    $("#sub_familia").select2({ width: '100%' });
    
    $("#familia_contable").select2({ width: '100%' });

    if($('#id').val() > 0){
        //mostrarOpcionesPorSubFamilia();
        /*setTimeout(() => {
            obtenerCategoria($('#sub_familia').val());
            setTimeout(() => {
                obtenerSubCategoria();
                obtenerModelo();
                obtenerPacket();
                obtenerMedida()
            }, 500);
        }, 500);*/
    }
});

$('#sub_familia').on('change', function () {
    mostrarOpcionesPorSubFamilia();
});
</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
     $('#fecha_solicitud').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		//container: '#openOverlayOpc modal-body'
		container: '#openOverlayOpc modal-body'
     });
	 /*
	 $('#hora_solicitud').timepicker({
		showInputs: false,
		container: '#openOverlayOpc modal-body'
	});
	*/
});

$(document).ready(function() {
	 
    $(".upload").on('click', function() {
        var formData = new FormData();
        var files = $('#image')[0].files[0];
        formData.append('file',files);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/productos/upload_producto",
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                
                var ind_img = $("#ind_img").val();
                
                if (response != 0) {
                    $("#img_ruta_"+ind_img).attr("src", "/img/productos/tmp/"+response).show();
                    $(".delete_ruta").show();
                    $("#img_foto_"+ind_img).val(response);

                    ind_img++;

                    var newRow = "";
                    newRow += '<div class="img_ruta">';
                    newRow += '<img src="" id="img_ruta_'+ind_img+'" width="130px" height="165px" alt="" style="text-align:center;margin-top:8px;display:none;margin-left:10px" />';
                    newRow += '<span class="delete_ruta" style="display:none" onclick="DeleteImagen(this)"></span>';
                    newRow += '<input type="hidden" id="img_foto_'+ind_img+'" name="img_foto[]" value="" />';
                    newRow += '</div>';

                    $("#divImagenes").append(newRow);
                    $("#ind_img").val(ind_img);

                } else {
                    alert('Formato de imagen incorrecto.');
                }
            }
        });
        return false;
    });

    $(".delete").on('click', function() {
        $("#img_ruta0").attr("src", "/img/sin_fondo.png");
        $("#img_foto0").val("");
    });

    if($("#id").val()>0){
        cargarImagenes();
        obtenerSubFamilia();
    }
});

function AddFila(){
    // Crear un nuevo div para el grupo de usuario
    var newDiv = document.createElement('div');
    newDiv.className = 'col-lg-3 anaqueles-grupo';
    
    // Crear el HTML interno del nuevo div
    newDiv.innerHTML = `
        <div class="form-group">
            <label class="control-label form-control-sm">Anaqueles</label>
            <select name="anaquel[]" id="anaquel" class="form-control form-control-sm">
                <option value="">--Seleccionar--</option>
            </select>
        </div>`;
    
    // Agregar el nuevo div al contenedor
    document.getElementById('contenedor-anaqueles').appendChild(newDiv);

    $(newDiv).find('select[name="anaquel[]"]').select2({ width: '100%' });
    
    obtenerAnaquel();
}

function obtenerAnaquel(){

    var id_almacen = $('#almacen').val();

    $.ajax({
		url: '/anaqueles/obtener_anaquel/'+id_almacen,
		dataType: "json",
		success: function(result){
			
            var option = "<option value=''>--Seleccionar--</option>";
			//$('#anaquel').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id+"'>"+oo.denominacion+"</option>";
			});
			$('select[name="anaquel[]"]').each(function() {
                if ($(this).children().length <= 1){
                    $(this).html(option);
                    $(this).attr("disabled", false);
                }
            });
			//$('#anaquel').attr("disabled",false);
			//$('.loader').hide();
		}
	});
}

function limpiar(){
	$('#id').val("0");
	$('#id_tipo_documento').val("");
	$('#denominacion').val("");
	$('#img_foto').val("");
}

function fn_save_producto(){

    var msg = "";

    var tipo_origen_producto = $('#tipo_origen_producto').val();
    var bien_servicio = $('#bien_servicio').val();
    var denominacion = $('#denominacion').val();
    //var codigo = $('#codigo').val();
    var peso = $('#peso').val();
    var familia = $('#familia').val();
    var sub_familia = $('#sub_familia').val();
	
    if(tipo_origen_producto==""){msg+="Ingrese el Tipo de Origen del Producto <br>";}
    if(bien_servicio==""){msg+="Ingrese el Bien o Servicio del Producto <br>";}
    if(denominacion==""){msg+="Ingrese la Denominacion del Producto <br>";}
    //if(codigo==""){msg+="Ingrese el Codigo del Producto <br>";}
    if(peso==""){msg+="Ingrese el Peso del Producto <br>";}
    //if(familia==""){msg+="Ingrese la Familia <br>";}
    //if(sub_familia==""){msg+="Ingrese la Sub Familia <br>";}

    if(msg!=""){

        bootbox.alert(msg);
        return false;

    }else{

        var msgLoader = "";
        msgLoader = "Procesando, espere un momento por favor";
        var heightBrowser = $(window).width()/2;
        $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
        $('.loader').show();
        let form = document.getElementById('frmProducto');
	    let formData = new FormData(form);

        $.ajax({
            url: "/productos/send_producto",
            type: "POST",
            data : formData,
            contentType: false,
            processData: false, 
            success: function (result) {
                //alert(result);
                if (result.success) {
                    $('.loader').hide();
                    bootbox.alert(result.success, function() {
                        $('#openOverlayOpc').modal('hide');
                        //bootbox.alert("Se guard&oacute; satisfactoriamente");
                        //window.location.reload();
                        datatablenew();
                    });
                } else if (result.error) {
                    $('.loader').hide();
                    bootbox.alert(result.error);
                }
            },
        });
    }
}

function DeleteImagen(obj) {

var obj = $(obj).parent().remove();

}

function cargarImagenes() {
    $("#divImagenes .img_ruta").each(function (index) {
        const img = $(this).find("img");
        const botonEliminar = $(this).find(".delete_ruta");

        if (img.attr("src")) {
            img.show();
            botonEliminar.show();
        } else {
            console.warn(`La imagen ${index + 1} no tiene un src válido.`);
            img.hide();
            botonEliminar.hide();
        }
    });
}

var subFamiliaSeleccionada = "<?php echo isset($producto->id_sub_familia) ? $producto->id_sub_familia : ''; ?>";

function obtenerSubFamilia(){

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
				var selected = (oo.id == subFamiliaSeleccionada) ? "selected='selected'" : "";
                option += "<option value='" + oo.id + "' " + selected + ">" + oo.denominacion + "</option>";
			});
			$('#sub_familia').html(option);
			
			$('#sub_familia').attr("disabled",false);
			
            if (subFamiliaSeleccionada) {
                $('#sub_familia').trigger('change');
            }

			$('.loader').hide();
        }
    });
}

/*function obtenerCodigo(){

    var familia = $('#familia').val();
    var sub_familia = $('#sub_familia').val();
    var codigo = $('#codigo').val();

    if(familia=="")return false;
    if(sub_familia=="")return false;

    var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

    $.ajax({
        url: "/sub_familia/obtener_codigo/"+sub_familia,
        dataType: "json",
        success: function (result) {

            var codigo = result[0].nuevo_codigo;
            $('#codigo').val(codigo);
            $('.loader').hide();

        }
    });
}*/

function mostrarOpcionesPorSubFamilia() {

    var sub_familia = $('#sub_familia').val();

    limpiarCombosDependientes();

    if ([1,2,3,4,5,6,7,8,9].includes(parseInt(sub_familia))) {
        $('.combo_producto_terminado').show();
        $('.bloque_producto_terminado').show();
        obtenerCategoria(sub_familia);
    } else {
        $('.combo_producto_terminado').hide();
        $('.bloque_producto_terminado').hide();
        //$('.combo_producto_terminado select').val('');
    }
}

var categoriaSeleccionada = "<?php echo isset($producto->id_categoria) ? $producto->id_categoria : ''; ?>";

function obtenerCategoria(sub_familia){

    var tipo = "";

    if([1,2,3,4].includes(parseInt(sub_familia))){tipo = 3;}
    else if(sub_familia == 6){tipo = 4;}
    else if([5,7,9].includes(parseInt(sub_familia))){tipo = 1;}
    else if(sub_familia == 8){tipo = 2;}

    //alert(categoriaSeleccionada);
    $.ajax({
        url: "/productos/obtener_categoria/"+tipo,
        dataType: "json",
        success: function (result) {

            //alert(result);
            var option = "<option value='' selected='selected'>--Seleccionar--</option>";
			$('#categoria').html("");

			$(result).each(function (ii, oo) {
				var selected = (oo.id == categoriaSeleccionada) ? "selected='selected'" : "";
                option += "<option value='" + oo.codigo + "' " + selected + ">" + oo.denominacion + "</option>";
			});
			$('#categoria').html(option);
			
			$('#categoria').attr("disabled",false);

            $('#categoria').val(categoriaSeleccionada).trigger('change');
        }
    });
}

var subCategoriaSeleccionada = "<?php echo isset($producto->id_sub_categoria) ? $producto->id_sub_categoria : ''; ?>";

function obtenerSubCategoria(){

    var categoria = $('#categoria').val();
    var tipo = "";

    if(categoria == 1){ tipo = 1;}
    else if(categoria == 2){tipo = 2;}
    else if(categoria == 3 || categoria == 4){tipo = 3;}
    //else{tipo = 4;}

    $.ajax({
        url: "/productos/obtener_sub_categoria/"+tipo,
        dataType: "json",
        success: function (result) {

            var option = "<option value='' selected='selected'>--Seleccionar--</option>";
			$('#sub_categoria').html("");

			$(result).each(function (ii, oo) {
				var selected = (oo.id == subCategoriaSeleccionada) ? "selected='selected'" : "";
                option += "<option value='" + oo.codigo + "' " + selected + ">" + oo.denominacion + "</option>";
			});
			$('#sub_categoria').html(option);
			
			$('#sub_categoria').attr("disabled",false);
            
			$('#sub_categoria').val(subCategoriaSeleccionada).trigger('change');
        }
    });
}

var modeloSeleccionada = "<?php echo isset($producto->id_modelo) ? $producto->id_modelo : ''; ?>";

function obtenerModelo(){

    var categoria = $('#categoria').val();
    var tipo = "";

    if(categoria == 1){ tipo = 1;}
    else if(categoria == 2){tipo = 2;}
    else if(categoria == 3){tipo = 3;}
    else if(categoria == 4){tipo = 4;}

    $.ajax({
        url: "/productos/obtener_modelo/"+tipo,
        dataType: "json",
        success: function (result) {

            var option = "<option value='' selected='selected'>--Seleccionar--</option>";
			$('#modelo').html("");

			$(result).each(function (ii, oo) {
				var selected = (oo.id == modeloSeleccionada) ? "selected='selected'" : "";
                option += "<option value='" + oo.codigo + "' " + selected + ">" + oo.denominacion + "</option>";
			});
			$('#modelo').html(option);
			
			$('#modelo').attr("disabled",false);

            $('#modelo').val(modeloSeleccionada).trigger('change');
        }
    });
}

var packetSeleccionada = "<?php echo isset($producto->id_packet) ? $producto->id_packet : ''; ?>";

function obtenerPacket(){

    var categoria = $('#categoria').val();
    var tipo = "";

    if(categoria == 1){ tipo = 1;}
    else if(categoria == 2){tipo = 2;}
    else if(categoria == 3 || categoria == 4){tipo = 3;}

    $.ajax({
        url: "/productos/obtener_packet/"+tipo,
        dataType: "json",
        success: function (result) {

            var option = "<option value='' selected='selected'>--Seleccionar--</option>";
			$('#packet').html("");

			$(result).each(function (ii, oo) {
				var selected = (oo.id == packetSeleccionada) ? "selected='selected'" : "";
                option += "<option value='" + oo.codigo + "' " + selected + ">" + oo.denominacion + "</option>";
			});
			$('#packet').html(option);
			
			$('#packet').attr("disabled",false);

            $('#packet').val(packetSeleccionada).trigger('change');
        }
    });
}

var medidaSeleccionada = "<?php echo isset($producto->id_medida) ? $producto->id_medida : ''; ?>";

function obtenerMedida(){

    var categoria = $('#categoria').val();
    var tipo = "";

    if(categoria == 1){ tipo = 1;}
    else if(categoria == 2){tipo = 2;}
    else if(categoria == 3){tipo = 3;}
    else if(categoria == 4){tipo = 4;}

    $.ajax({
        url: "/productos/obtener_medida/"+tipo,
        dataType: "json",
        success: function (result) {

            var option = "<option value='' selected='selected'>--Seleccionar--</option>";
			$('#medida').html("");

			$(result).each(function (ii, oo) {
				var selected = (oo.id == medidaSeleccionada) ? "selected='selected'" : "";
                option += "<option value='" + oo.codigo + "' " + selected + ">" + oo.denominacion + "</option>";
			});
			$('#medida').html(option);
			
			$('#medida').attr("disabled",false);

            $('#medida').val(medidaSeleccionada).trigger('change');
        }
    });
}

function limpiarCombosDependientes() {

    const combos = [
        '#categoria',
        '#sub_categoria',
        '#modelo',
        '#packet',
        '#medida'
    ];

    combos.forEach(id => {
        $(id).html("<option value=''>--Seleccionar--</option>").val('');
    });

    if (!$('#id').val()) {
        categoriaSeleccionada = '';
        subCategoriaSeleccionada = '';
        modeloSeleccionada = '';
        packetSeleccionada = '';
        medidaSeleccionada = '';
    }
}

$('.combo_producto_terminado').hide();

$('#bien_servicio').on('change', function () {
  if ($(this).val() === 'PRODUCTO') {
    $('#bloque_producto_terminado').slideDown();
  } else {
    $('#bloque_producto_terminado').slideUp();
  }
});

function obtenerPrecios(){

    var costo = parseFloat($('#costo_unitario').val());
    var margen = parseFloat($('#margen').val());
    var valor = parseFloat($('#valor_venta').val());
    var precio = parseFloat($('#precio_venta').val());

    var igv = 1.18;

    if (costo && margen) {
        let valor_venta = costo * (1 + margen / 100);
        let precio_venta = valor_venta * igv;

        $('#valor_venta').val(valor_venta.toFixed(2));
        $('#precio_venta').val(precio_venta.toFixed(2));
    }else if (costo && precio) {
        let valor_venta = precio / igv;
        let margen_calculado = ((valor_venta / costo) - 1) * 100;
        
        $('#valor_venta').val(valor_venta.toFixed(2));
        $('#margen').val(margen_calculado.toFixed(2));
    }else if (costo && valor) {
        let margen_calculado = ((valor / costo) - 1) * 100;
        let precio_venta = valor * igv;

        $('#margen').val(margen_calculado.toFixed(2));
        $('#precio_venta').val(precio_venta.toFixed(2));
    }else if (margen && precio) {
        let valor_venta = precio / igv;
        let costo_calculado = valor_venta / (1 + margen / 100);

        $('#valor_venta').val(valor_venta.toFixed(2));
        $('#costo_unitario').val(costo_calculado.toFixed(2));
    }else if (margen && valor) {
        let costo_calculado = valor / (1 + margen / 100);
        let precio_venta = valor * igv;

        $('#costo_unitario').val(costo_calculado.toFixed(2));
        $('#precio_venta').val(precio_venta.toFixed(2));
    }else if (valor && precio) {
        let costo_calculado = valor / (1 + (margen || 0) / 100);
        let margen_calculado = ((valor / costo_calculado) - 1) * 100;

        $('#costo_unitario').val(costo_calculado.toFixed(2));
        $('#margen').val(margen_calculado.toFixed(2));
    }
}

</script>

<body class="hold-transition skin-blue sidebar-mini">

    <div>
		<!--
        <section class="content-header">
          <h1>
            <small style="font-size: 20px">Programados del Medicos del dia <?php //echo $fecha_atencion?></small>
          </h1>
        </section>
		-->
		<div class="justify-content-center">		

            <div class="card mb-3">
                <div class="card-header bg-light font-weight-bold" style="padding:5px!important;padding-left:20px!important">
                    Registrar un producto / servicio
                </div>
            
                <div class="card-body">
                <form method="post" action="#" id="frmProducto" name="frmProducto">

                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:10px">
                                
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                            <div class="row" style="padding-left:10px">
                            <div class="col-lg-8">
                                <fieldset class="fieldset" name="datos_generales" style="border:1px solid #A4A4A4; padding: 5px">
                                <legend class="control-label form-control-sm">Datos generales</legend>
                                <div class="row" style="padding-left:10px">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Tipo Origen Producto</label>
                                            <select name="tipo_origen_producto" id="tipo_origen_producto" class="form-control form-control-sm" onchange="">
                                                <option value="">--Seleccionar--</option>
                                                <?php
                                                foreach ($tipo_origen_producto as $row){?>
                                                    <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$producto->id_tipo_origen_producto)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Bien / Servicio</label>
                                            <select name="bien_servicio" id="bien_servicio" class="form-control form-control-sm" onchange="">
                                                <option value="">--Seleccionar--</option>
                                                <?php
                                                foreach ($bien_servicio as $row){?>
                                                    <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$producto->bien_servicio)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">N&uacute;mero Serie</label>
                                            <input id="numero_serie" name="numero_serie" on class="form-control form-control-sm"  value="<?php echo $producto->numero_serie?>" type="text">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">C&oacute;digo</label>
                                            <input id="codigo" name="codigo" on class="form-control form-control-sm"  value="<?php echo $producto->codigo?>" type="text" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-left:10px">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Denominaci&oacute;n</label>
                                            <input id="denominacion" name="denominacion" on class="form-control form-control-sm"  value="<?php echo htmlspecialchars($producto->denominacion, ENT_QUOTES, 'UTF-8')?>" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-left:10px">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Unidad Producto</label>
                                            <select name="unidad_producto" id="unidad_producto" class="form-control form-control-sm" onchange="">
                                                <option value="">--Seleccionar--</option>
                                                <?php
                                                foreach ($unidad_producto as $row){?>
                                                    <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$producto->id_unidad_producto)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                                <?php 
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Contenido</label>
                                            <input id="contenido" name="contenido" on class="form-control form-control-sm"  value="<?php echo $producto->contenido?>" type="text">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Unidad Medida</label>
                                            <select name="unidad_medida" id="unidad_medida" class="form-control form-control-sm" onchange="">
                                                <option value="">--Seleccionar--</option>
                                                <?php
                                                foreach ($unidad_medida as $row){?>
                                                    <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$producto->id_unidad_medida)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                                <?php 
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label form-control-sm">Marca</label>
                                            <select name="marca" id="marca" class="form-control form-control-sm" onchange="">
                                                <option value="">--Seleccionar--</option>
                                                <?php
                                                foreach ($marca as $row){?>
                                                    <option value="<?php echo $row->id ?>" <?php if($row->id==$producto->id_marca)echo "selected='selected'"?>><?php echo $row->denominiacion ?></option>
                                                <?php 
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                </fieldset>
                                <fieldset class="fieldset" name="familias" style="border:1px solid #A4A4A4; padding: 5px">
                                <legend class="control-label form-control-sm">Familias</legend>
                                <!--<div class="card card-body bg-light border-0 p-3">-->
                                    <div class="row" style="padding-left:10px">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Familia</label>
                                                <select name="familia" id="familia" class="form-control form-control-sm" onchange="obtenerSubFamilia()">
                                                    <option value="">--Seleccionar--</option>
                                                    <?php
                                                    foreach ($familia as $row){?>
                                                        <option value="<?php echo $row->id ?>" <?php if($row->id==$producto->id_familia)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                                    <?php 
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Sub Familia</label>
                                                <select name="sub_familia" id="sub_familia" class="form-control form-control-sm" onchange="mostrarOpcionesPorSubFamilia()">
                                                    <option value="">--Seleccionar--</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Familia Contable</label>
                                                <select name="familia_contable" id="familia_contable" class="form-control form-control-sm" onchange="">
                                                    <option value="">--Seleccionar--</option>
                                                    <?php
                                                    foreach ($familia_contable as $row){?>
                                                        <option value="<?php echo $row->id ?>" <?php if($row->id==$producto->id_familia_contable)echo "selected='selected'"?>><?php echo $row->familia_contable ?></option>
                                                    <?php 
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                <!--</div>-->
                                </fieldset>
                                <div class="row" style="padding-left:10px" id="bloque_producto_terminado">
                                        <div class="col-lg-3 combo_producto_terminado">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Categoria</label>
                                                <select name="categoria" id="categoria" class="form-control form-control-sm" onchange="obtenerSubCategoria();obtenerModelo();obtenerPacket();obtenerMedida()">
                                                    <option value="">--Seleccionar--</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 combo_producto_terminado">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Sub Categoria</label>
                                                <select name="sub_categoria" id="sub_categoria" class="form-control form-control-sm" onchange="">
                                                    <option value="">--Seleccionar--</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 combo_producto_terminado">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Modelo</label>
                                                <select name="modelo" id="modelo" class="form-control form-control-sm" onchange="">
                                                    <option value="">--Seleccionar--</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 combo_producto_terminado">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Packet</label>
                                                <select name="packet" id="packet" class="form-control form-control-sm" onchange="">
                                                    <option value="">--Seleccionar--</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 combo_producto_terminado">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Medida</label>
                                                <select name="medida" id="medida" class="form-control form-control-sm" onchange="">
                                                    <option value="">--Seleccionar--</option>
                                                </select>
                                            </div>
                                        </div>
                                </div>
                                <fieldset class="fieldset" name="informacion_adicional" style="border:1px solid #A4A4A4; padding: 5px">
                                <legend class="control-label form-control-sm">Informaci&oacute;n Adicional</legend>
                                <!--<div class="card card-body bg-light border-0 p-3">-->
                                    <div class="row" style="padding-left:10px">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Estado Bien</label>
                                                <select name="estado_bien" id="estado_bien" class="form-control form-control-sm" onchange="">
                                                    <option value="">--Seleccionar--</option>
                                                    <?php
                                                    foreach ($estado_bien as $row){?>
                                                        <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$producto->id_estado_bien)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                                    <?php 
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Costo Unitario</label>
                                                <input id="costo_unitario" name="costo_unitario" on class="form-control form-control-sm" value="<?php echo $producto->costo_unitario?>" type="text" onchange="obtenerPrecios()">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Margen</label>
                                                <input id="margen" name="margen" on class="form-control form-control-sm" value="<?php echo $producto->margen?>" type="text" onchange="obtenerPrecios()">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Valor Venta</label>
                                                <input id="valor_venta" name="valor_venta" on class="form-control form-control-sm" value="<?php echo $producto->valor_venta?>" type="text" onchange="obtenerPrecios()">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Precio Venta</label>
                                                <input id="precio_venta" name="precio_venta" on class="form-control form-control-sm" value="<?php echo $producto->precio_venta?>" type="text" onchange="obtenerPrecios()">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Moneda</label>
                                                <select name="moneda" id="moneda" class="form-control form-control-sm" onchange="">
                                                    <option value="">--Seleccionar--</option>
                                                    <?php
                                                    foreach ($moneda as $row){?>
                                                        <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$producto->id_moneda)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                                    <?php 
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Fecha Vencimiento</label>
                                                <input id="fecha_vencimiento" name="fecha_vencimiento" on class="form-control form-control-sm"  value="<?php echo $producto->fecha_vencimiento?>" type="text">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Stock M&iacute;nimo</label>
                                                <input id="stock_minimo" name="stock_minimo" on class="form-control form-control-sm"  value="<?php echo $producto->stock_minimo?>" type="text">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Peso</label>
                                                <input id="peso" name="peso" on class="form-control form-control-sm"  value="<?php echo $producto->peso?>" type="text">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label form-control-sm">Ficha T&eacute;cnica</label>
                                                <input type="file" class="form-control-file btn btn-sm btn-success" style="background-color: #F6F6F6 !important; border: none !important; padding: 0 !important; box-shadow: none !important; color:black" id="btnFichaTecnica" name="btnFichaTecnica">
                                                <?php if (!empty($producto->ruta_ficha_tecnica)) : ?>
                                                    <div class="mt-2">
                                                        <i class="fa fa-file-pdf-o"></i>
                                                        <a href="<?php echo asset($producto->ruta_ficha_tecnica); ?>" target="_blank">Descargar ficha técnica</a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <!--</div>-->
                            </div>
                            <div class="col-lg-4">
                                <div class="card" style="min-height:140px">
                                    <div class="card-header">
                                        <strong>
                                            Imagenes Referenciales
                                        </strong>
                                    </div>

                                    <div class="card-body">

                                        <div class="wrapper">
                                            <div id="divImagenes" class="scrolls">
                                                @if(!empty($imagenes) && count($imagenes) > 0)
                                                    @foreach($imagenes as $index => $imagen)
                                                    <?php //print_r($imagen);
                                                        //$imagen=
                                                    ?>
                                                        <div class="img_ruta">

                                                            <img src="/img/productos/{{ $imagen->id_producto }}/{{ $imagen->ruta_imagen }}" id="img_ruta_{{ $index + 1 }}" width="130px" height="165px" alt="" style="text-align:center;margin-top:8px;display:none;margin-left:10px" />
                                                            <span class="delete_ruta" style="display:none" onclick="DeleteImagen(this)"></span>

                                                            <input type="hidden" id="img_foto_{{ $index + 1 }}" name="img_foto[]" value="{{ $imagen->ruta_imagen }}" />
                                                            <input type="hidden" id="id_img_foto" name="id_img_foto[]" value="{{ $imagen->id }}" />

                                                            
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <p>No hay imágenes disponibles para este producto.</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-lg-12">
                                                <div class="form-group" style="text-align:center">
                                                    <span class="btn btn-sm btn-warning btn-file">
                                                        Examinar <input id="image" name="image" type="file" />
                                                    </span>

                                                    <?php 
                                                    //echo count($imagenes); echo "dddd";
                                                    $ind_img = count($imagenes)+1;
                                                    ?>

                                                    <input type="hidden" id="ind_img" name="ind_img" value="<?php echo $ind_img?>" />

                                                    <input type="button" class="btn btn-sm btn-primary upload" value="Subir" style="margin-left:10px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top:15px" class="form-group">
                            <div class="col-sm-12 controls">
                                <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                    <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-nuevo" data-toggle="modal" onclick="fn_save_producto()">
                                        <i class="fas fa-save" style="font-size:18px;"></i> Guardar
                                    </button>
                                    <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-cerrar" data-toggle="modal" onclick="$('#openOverlayOpc').modal('hide');">
                                        <i class="fas fa-times-circle" style="font-size:18px;"></i> Cerrar
                                    </button>
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

    
<script type="text/javascript">
$(document).ready(function () {

	$('#ruc_').blur(function () {
		var id = $('#id').val();
			if(id==0) {
				validaRuc(this.value);
			}
		//validaRuc(this.value);
	});
	
	
	
	
});


</script>

<script type="text/javascript">
$(document).ready(function() {
	//$('#numero_placa').focus();
	//$('#numero_placa').mask('AAA-000');
	//$('#vehiculo_numero_placa').mask('AAA-000');
	
	
});




</script>

