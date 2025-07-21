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
    max-width:55%!important
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
  /*background-color: red!important;*/
  font-weight:bold;
  /*mix-blend-mode: difference;*/
  
}

#tablemodalm{
	
}

.bloque-horno {
    width: 210px;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 5px;
    margin: 5px;
    text-align: center;
}

.fila-horno {
    display: flex;
    flex-wrap: wrap;
    justify-content: start;
}

.fila-label {
    font-weight: bold;
    margin-bottom: 5px;
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>


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

    //cargarDetalleHorno();

    $('#fecha').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    $('#operador').select2 ({  width : '100%' })

});

</script>

<script type="text/javascript">

function fn_save_salida_horno(){
	
    var msg = "";
    var _token = $('#_token').val();
	var id = $('#id').val();

    var fecha = $('#fecha').val();

    if(fecha==""){msg+="Ingrese una Fecha <br>";}

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
            url: "/horno/send_ingreso_horno",
            type: "POST",
            data : $("#frmSalidaHorno").serialize(),
            success: function (result) {
                $('#openOverlayOpc').modal('hide');
                $('.loader').hide();
                bootbox.alert("Se guard&oacute; satisfactoriamente");
                datatablenew();
                
            }
        });
    }
}

function cargarDetalleHorno() {
    const container = $('#divIngresoHorno');
    container.empty();

    const filas = ["3", "2", "1"];
    const letras = ["A", "B", "C", "D"];
    const niveles = ["3", "2", "1"];

    let contador = 1;

    filas.forEach(filaNum => {
        let filaHtml = `<div class="fila-label mt-3"><strong>FILA N° ${filaNum}</strong></div>`;

        niveles.forEach(nivel => {
            filaHtml += `<div class="fila-horno d-flex mb-3">`;

            letras.forEach(letra => {
                const ubicacion = `${filaNum}${letra}-${nivel}`;

                filaHtml += `<div class="text-center mx-2 bloque-horno" style="display: flex; flex-direction: column; align-items: center;">
                        <div><strong>Ubicación: ${ubicacion}</strong></div>
                        <div class="mt-1">
                            <label for="humedad${contador}">Humedad:</label>
                            <input id="humedad${contador}" name="humedad[]" class="form-control form-control-sm text-center" style="width: 60px; display: inline-block;" type="text" placeholder="%">
                        </div>
                    </div>`;

                contador++;
            });

            filaHtml += `</div>`;
        });

        container.append(filaHtml);
    });
}

function calcularIngresoHorno(input) {

    var fila = $(input).closest('tr');
    var total_n_piezas = parseFloat(fila.find('.total_n_piezas').val()) || 0;
    var cantidad_ingreso = parseFloat(fila.find('.ingreso_horno').val()) || 0;
    var sumaTotalProduccion = 0;
    //alert(total_n_piezas +"-"+cantidad_ingreso)
    if(cantidad_ingreso > total_n_piezas){
        bootbox.alert("La cantidad de Ingreso al Horno no puede ser mayor al total de piezas");
        fila.find('.ingreso_horno').val("");
        calcularIngresoHorno(input);
        return;
    }
    
    $('.ingreso_horno').each(function() {
        var val = parseFloat($(this).val()) || 0;
        sumaTotalProduccion += val;
    });

    $('#total_ingreso_horno').val(sumaTotalProduccion);

}

</script>

<body class="hold-transition skin-blue sidebar-mini">
    
    <div>
		<div class="justify-content-center">

            <div class="card">

                <div class="card-header" style="text-align: center; font-size:16px; margin-top: 20px">
                    <b>Salida Horno</b>
                </div>
                
                <div class="card-body">
                    <form method="post" action="#" id="frmSalidaHorno" name="frmSalidaHorno">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            
                            <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                            
                            <div class="row" style="padding-left:10px">

                                <div class="col-lg-2">
                                    Horno
                                </div>
                                <div class="col-lg-2">
                                    <select name="horno" id="horno" class="form-control form-control-sm" onchange="">
                                        <option value="">--Seleccionar--</option>
                                        <?php
                                        foreach ($horno as $row){?>
                                            <option value="<?php echo $row->codigo ?>" <?php //echo ($id > 0 && $row->codigo == $orden_compra->id_moneda) ? "selected='selected'" : (($row->codigo == 1) ? "selected='selected'" : ""); ?>><?php echo $row->denominacion ?></option>
                                            <?php 
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-2">
                                    Fecha Apagado
                                </div>
                                <div class="col-lg-2">
                                    <input id="fecha" name="fecha" on class="form-control form-control-sm"  value="<?php echo /*isset($acerrado_madera) && $acerrado_madera->fecha_orden_compra ? $acerrado_madera->fecha_orden_compra :*/ date('Y-m-d'); ?>" type="text">
                                </div>

                                <div class="col-lg-2">
                                    Hora Apagado
                                </div>
                                <div class="col-lg-2">
                                    <input id="hora_encendido" name="hora_encendido" on class="form-control form-control-sm"  value="<?php /*echo isset($acerrado_madera) && $acerrado_madera->fecha_orden_compra ? $acerrado_madera->fecha_orden_compra :*/ ?>" type="time">
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-2">
                                    Humedad Apagado
                                </div>
                                <div class="col-lg-2">
                                    <input id="humedad_inicio" name="humedad_inicio" on class="form-control form-control-sm"  value="<?php /*echo isset($acerrado_madera) && $acerrado_madera->fecha_orden_compra ? $acerrado_madera->fecha_orden_compra :*/ ?>" placeholder="&#37;" type="text">
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-2">
                                    Operador
                                </div>
                                <div class="col-lg-6">
                                    <select name="operador" id="operador" class="form-control form-control-sm" onchange="">
                                        <option value="">--Seleccionar--</option>
                                        <?php
                                        foreach ($operador as $row){?>
                                            <option value="<?php echo $row->id ?>" <?php //echo ($id > 0 && $row->codigo == $orden_compra->id_moneda) ? "selected='selected'" : (($row->codigo == 1) ? "selected='selected'" : ""); ?>><?php echo $row->nombres . ' ' . $row->apellido_paterno . ' ' . $row->apellido_materno ?></option>
                                            <?php 
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-2">
                                    Observaci&oacute;n
                                </div>
                                <div class="col-lg-10">
                                    <textarea id="observacion" name="observacion" on class="form-control form-control-sm"></textarea>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                <div id="divIngresoHorno" class="container-fluid">
                                    <!-- Aquí se cargará la estructura dinámica -->
                                </div>
                            </div>
                            <div style="margin-top:15px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                    
                                        <a href="javascript:void(0)" onClick="fn_save_salida_horno()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>
                                        <a href="javascript:void(0)" onClick="$('#openOverlayOpc').modal('hide');" class="btn btn-sm btn-info" style="">Cerrar</a>
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
        </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

    
<script type="text/javascript">
$(document).ready(function () {
	
});


</script>



