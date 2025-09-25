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

    cargarDetalleAcerrado();

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

function fn_save_ingreso_horno(){
	
    var msg = "";
    var _token = $('#_token').val();
	var id = $('#id').val();

    var fecha = $('#fecha').val();

    if(fecha==""){msg+="Ingrese una Fecha <br>";}

    var filas = $('#divIngresoHorno tr');
    var tieneCantidades = false;

    filas.each(function(index) {
        var cantidad = parseInt($(this).find('input[name="cantidad_paquete_ingreso[]"]').val());
        if (cantidad || cantidad >= 0) {
            tieneCantidades = true;
        }
    });

    if(tieneCantidades==false){
        msg+="Ingrese una cantidad de paquete como minimo <br>";
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
            url: "/horno/send_ingreso_horno",
            type: "POST",
            data : $("#frmIngresoHorno").serialize(),
            success: function (result) {
                $('#openOverlayOpc').modal('hide');
                $('.loader').hide();
                bootbox.alert("Se guard&oacute; satisfactoriamente");
                datatablenew();
                
            }
        });
    }
}

function cargarDetalleAcerrado(){

    var id = $("#id").val();
    const tbody = $('#divIngresoHorno');

    tbody.empty();

    $.ajax({
        url: "/horno/cargar_detalle_acerrado",
        dataType: "json",
        success: function(result){

            let n = 1;

            var total_acumulado=0;

            result.detalle_acerrado.forEach(detalle_acerrado => {

                const row = `
                    <tr>
                        <td>${n}</td>
                        <td><input name="id_acerrado_detalle[]" id="id_acerrado_detalle${n}" class="form-control form-control-sm" value="${detalle_acerrado.id}" type="hidden"><input name="fecha_produccion[]" id="fecha_produccion${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${detalle_acerrado.fecha_produccion}" type="text" readonly></td>
                        <td><input name="tipo_madera[]" id="tipo_madera${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${detalle_acerrado.tipo_madera}" type="text" readonly></td>
                        <td><input name="medida[]" id="medida${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${detalle_acerrado.medida}" type="text" readonly></td>
                        <td><input name="cantidad_paquete[]" id="cantidad_paquete${n}" class="cantidad_paquete form-control form-control-sm" style="border: none; background-color: transparent;" value="${detalle_acerrado.cantidad_paquetes}" type="text" readonly></td>
                        <td><input name="medida1[]" id="medida1${n}" class="medida1 form-control form-control-sm" style="border: none; background-color: transparent;" value="${detalle_acerrado.medida1_paquete}" type="text" readonly></td>
                        <td><input name="medida2[]" id="medida2${n}" class="medida2 form-control form-control-sm" style="border: none; background-color: transparent;" value="${detalle_acerrado.medida2_paquete}" type="text" readonly></td>
                        <td><input name="total_n_piezas[]" id="total_n_piezas${n}" class="total_n_piezas form-control form-control-sm" style="border: none; background-color: transparent;" value="${detalle_acerrado.total_n_piezas}" type="text" readonly></td>
                        <td><input name="cantidad_paquete_ingreso[]" id="cantidad_paquete_ingreso${n}" class="cantidad_paquete_ingreso form-control form-control-sm" value="" type="text" oninput="calcularTotalPiezasIngreso(this)"></td>
                        <td><input name="ingreso_horno[]" id="ingreso_horno${n}" class="ingreso_horno form-control form-control-sm" value="" type="text" oninput="calcularIngresoHorno(this)" readonly></td>
                    </tr>
                `;
                tbody.append(row);
                
                n++;
            });
        }
    })
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

function calcularTotalPiezasIngreso(input){
    var fila = $(input).closest('tr');

    var cantidad_paquete = parseFloat(fila.find('.cantidad_paquete').val()) || 0;
    var medida1 = parseFloat(fila.find('.medida1').val()) || 0;
    var medida2 = parseFloat(fila.find('.medida2').val()) || 0;
    var cantidad_paquete_ingreso = parseFloat(fila.find('.cantidad_paquete_ingreso').val()) || 0;

    // Verificación antes de continuar
    if (cantidad_paquete_ingreso > cantidad_paquete) {
        bootbox.alert("La cantidad de Paquetes de Ingreso al Horno no puede ser mayor al total de Paquetes");
        fila.find('.cantidad_paquete_ingreso').val("");
        fila.find('.ingreso_horno').val("");
        return;
    }

    // Si todo está bien, calcula normalmente
    var total_ingreso_horno = cantidad_paquete_ingreso * medida1 * medida2;

    fila.find('.ingreso_horno').val(total_ingreso_horno);

    calcularIngresoHorno(input); // solo llamas si todo es válido
}

</script>

<body class="hold-transition skin-blue sidebar-mini">
    
    <div>
		<div class="justify-content-center">

            <div class="card">

                <div class="card-header" style="text-align: center; font-size:16px; margin-top: 20px">
                    <b>Ingreso Horno</b>
                </div>
                
                <div class="card-body">
                    <form method="post" action="#" id="frmIngresoHorno" name="frmIngresoHorno">
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
                                            <option value="<?php echo $row->codigo ?>" <?php echo ($id > 0 && $row->codigo == $ingreso_horno->id_numero_horno) ? "selected='selected'" : ""; ?>><?php echo $row->denominacion ?></option>
                                            <?php 
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-2">
                                    Fecha Encendido
                                </div>
                                <div class="col-lg-2">
                                    <input id="fecha" name="fecha" on class="form-control form-control-sm"  value="<?php echo isset($ingreso_horno) && $ingreso_horno->fecha_encendido ? $ingreso_horno->fecha_encendido : date('Y-m-d'); ?>" type="text">
                                </div>

                                <div class="col-lg-2">
                                    Hora Encendido
                                </div>
                                <div class="col-lg-2">
                                    <input id="hora_encendido" name="hora_encendido" on class="form-control form-control-sm"  value="<?php echo isset($ingreso_horno) && $ingreso_horno->hora_encendido ? $ingreso_horno->hora_encendido : "" ?>" type="time">
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-2">
                                    Temperatura Inicio
                                </div>
                                <div class="col-lg-2">
                                    <input id="temperatura_inicio" name="temperatura_inicio" class="form-control form-control-sm"  value="<?php echo isset($ingreso_horno) && $ingreso_horno->temperatura_inicio ? $ingreso_horno->temperatura_inicio : "" ?>" placeholder="&#176;C" type="number">
                                </div>
                            
                                <div class="col-lg-2">
                                    Humedad Inicio
                                </div>
                                <div class="col-lg-2">
                                    <input id="humedad_inicio" name="humedad_inicio" on class="form-control form-control-sm"  value="<?php echo isset($ingreso_horno) && $ingreso_horno->humedad_inicio ? $ingreso_horno->humedad_inicio : "" ?>" placeholder="&#37;" type="text">
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
                                            <option value="<?php echo $row->id ?>" <?php echo ($id > 0 && $row->id == $ingreso_horno->id_operador_inicio) ? "selected='selected'" : ""; ?>><?php echo $row->nombres . ' ' . $row->apellido_paterno . ' ' . $row->apellido_materno ?></option>
                                            <?php 
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="card-body">

                                <div class="table-responsive" style="overflow-y: auto; max-height: 400px; overflow-x: auto; ">
                                    <table id="tblIngresoHorno" class="table table-hover table-sm">
                                        <thead>
                                        <tr style="font-size:13px">
                                            <th style="width : 5%">#</th>
                                            <th style="width : 10%">Fecha Acerrado</th>
                                            <th style="width : 10%">Tipo Madera</th>
                                            <th style="width : 15%">Medida</th>
                                            <th style="width : 10%">Cantidad Paquetes</th>
                                            <th style="width : 10%">Medida 1</th>
                                            <th style="width : 10%">Medida 2</th>
                                            <th style="width : 10%">Total Piezas</th>
                                            <th style="width : 10%">Ingreso Paquetes</th>
                                            <th style="width : 10%">Ingreso Horno</th>
                                        </tr>
                                        </thead>
                                        <tbody id="divIngresoHorno">
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="9" style="text-align:right;"><strong>Total:</strong></td>
                                                <td><input type="text" id="total_ingreso_horno" class="form-control form-control-sm" readonly></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div style="margin-top:15px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                    
                                        <a href="javascript:void(0)" onClick="fn_save_ingreso_horno()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>
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



