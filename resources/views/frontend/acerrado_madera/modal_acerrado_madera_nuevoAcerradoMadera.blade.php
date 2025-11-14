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
    max-width:75%!important
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

    cargarDetalleIngreso();

    $('#fecha').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

});

</script>

<script type="text/javascript">

function fn_save_madera_acerrado(){
	
    var msg = "";
    var _token = $('#_token').val();
	var id = $('#id').val();

    var fecha = $('#fecha').val();

    if(fecha==""){msg+="Ingrese una Fecha <br>";}

    var filas = $('#divAcerradoMadera tr');
    var tieneCantidades = false;

    filas.each(function(index) {
        var cantidad = parseInt($(this).find('input[name="cantidad_ingreso_produccion[]"]').val());
        if (cantidad || cantidad >= 0) {
            tieneCantidades = true;
        }
    });

    if(tieneCantidades==false){
        msg+="Ingrese una cantidad como minimo <br>";
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
            url: "/acerrado_madera/send_ingreso_produccion_acerrado_madera",
            type: "POST",
            data : $("#frmIngresoAcerradoMadera").serialize(),
            success: function (result) {
                $('#openOverlayOpc').modal('hide');
                $('.loader').hide();
                bootbox.alert("Se guard&oacute; satisfactoriamente");
                datatablenew();
                
            }
        });
    }
}

function cargarDetalleIngreso(){

    var id = $("#id").val();
    const tbody = $('#divAcerradoMadera');

    tbody.empty();

    $.ajax({
        url: "/acerrado_madera/cargar_detalle_ingreso_vehiculo_acerrado",
        dataType: "json",
        success: function(result){

            let n = 1;

            var total_acumulado=0;

            result.detalle_ingreso_acerrado.forEach(detalle_ingreso_acerrado => {

                const row = `
                    <tr>
                        <td>${n}</td>
                        <td><input name="id_ingreso_acerrado_detalle[]" id="id_ingreso_acerrado_detalle${n}" class="form-control form-control-sm" value="${detalle_ingreso_acerrado.id}" type="hidden"><input name="ruc[]" id="ruc${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${detalle_ingreso_acerrado.ruc}" type="text" readonly></td>
                        <td><input name="razon_social[]" id="razon_social${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${detalle_ingreso_acerrado.razon_social}" type="text" readonly></td>
                        <td><input name="letra[]" id="letra${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${detalle_ingreso_acerrado.letra}" type="text" readonly></td>
                        <td><input name="placa[]" id="placa${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${detalle_ingreso_acerrado.placa}" type="text" readonly></td>
                        <td><input name="id_tipo_madera[]" id="id_tipo_madera${n}" class="form-control form-control-sm" value="${detalle_ingreso_acerrado.id_tipo_maderas}" type="hidden"><input name="tipo_madera[]" id="tipo_madera${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${detalle_ingreso_acerrado.tipo_madera}" type="text" readonly></td>
                        <td><input name="cantidad_ingreso[]" id="cantidad_ingreso${n}" class="cantidad_ingreso form-control form-control-sm" style="border: none; background-color: transparent;" value="${detalle_ingreso_acerrado.cantidad_pendiente}" type="text" readonly></td>
                        <td><input name="cantidad_ingreso_produccion[]" id="cantidad_ingreso_produccion${n}" class="cantidad_ingreso_produccion form-control form-control-sm" value="" type="text" oninput="calcularPorcentaje(this)"></td>
                        <td><input name="porcentaje[]" id="porcentaje${n}" class="porcentaje form-control form-control-sm" value="" type="text"></td>
                    </tr>
                `;
                tbody.append(row);
                
                n++;
            });
        }
    })
}

function calcularPorcentaje(input) {

    var filas = $('.cantidad_ingreso_produccion');
    var totalFilas = 0;

    filas.each(function () {
        var fila = $(this).closest('tr');
        var cantidad_ingreso = parseFloat(fila.find('.cantidad_ingreso_produccion').val()) || 0;
        if (cantidad_ingreso > 0) {
            totalFilas++;
        }
    });

    var sumaTotalProduccion = 0;
    var error = false;

    filas.each(function () {
        var fila = $(this).closest('tr');
        var cantidad_ingreso = parseFloat(fila.find('.cantidad_ingreso').val()) || 0;
        var cantidad_produccion = parseFloat($(this).val()) || 0;

        if (cantidad_produccion > cantidad_ingreso) {
            bootbox.alert("La cantidad de ingreso a producción no puede ser mayor que la cantidad de ingreso.");
            fila.find('.porcentaje').val("0.00");
            fila.find('.cantidad_ingreso_produccion').val("");
            error = true;
            return false;
        }

        sumaTotalProduccion += cantidad_produccion;
    });

    if (error) {
        $('#total_produccion').val("0.00");
        $('#total_produccion_porcentaje').val("0.00");
        calcularPorcentaje(input);
        return;
    }

    $('#total_produccion').val(sumaTotalProduccion.toFixed(2));

    if (sumaTotalProduccion === 0) {
        $('.porcentaje').val("0.00");
        $('#total_produccion_porcentaje').val("0.00");
        return;
    }

    var sumaPorcentaje = 0;

    filas.each(function () {
        var fila = $(this).closest('tr');
        var cantidad_ingreso = parseFloat(fila.find('.cantidad_ingreso').val()) || 0;
        var cantidad_produccion = parseFloat($(this).val()) || 0;
        var porcentaje = 0;

        if (totalFilas === 1) {
            porcentaje = (cantidad_produccion / cantidad_ingreso) * 100;
        } else {
            porcentaje = (cantidad_produccion / sumaTotalProduccion) * 100;
        }

        fila.find('.porcentaje').val(porcentaje.toFixed(2));
        sumaPorcentaje += porcentaje;
    });

    $('#total_produccion_porcentaje').val(sumaPorcentaje.toFixed(2));
}

</script>

<body class="hold-transition skin-blue sidebar-mini">
    
    <div>
		<div class="justify-content-center">

            <div class="card">

                <div class="card-header" style="text-align: center; font-size:16px; margin-top: 20px">
                    <b>Ingreso de Troncos a Acerrio</b>
                </div>
                
                <div class="card-body">
                    <form method="post" action="#" id="frmIngresoAcerradoMadera" name="frmIngresoAcerradoMadera">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                            
                            <div class="row" style="padding-left:10px">

                                <div class="col-lg-2">
                                    Fecha
                                </div>
                                <div class="col-lg-2">
                                    <input id="fecha" name="fecha" on class="form-control form-control-sm"  value="<?php echo /*isset($acerrado_madera) && $acerrado_madera->fecha_orden_compra ? $acerrado_madera->fecha_orden_compra :*/ date('Y-m-d'); ?>" type="text">
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive" style="overflow-y: auto; max-height: 400px; overflow-x: auto; ">
                                    <table id="tblAcerradoMadera" class="table table-hover table-sm">
                                        <thead>
                                        <tr style="font-size:13px">
                                            <th style="width : 3%">#</th>
                                            <th style="width : 10%">Ruc</th>
                                            <th style="width : 30%">Razon Social</th>
                                            <th style="width : 7%">Letra</th>
                                            <th style="width : 10%">Placa</th>
                                            <th style="width : 10%">Tipo Madera</th>
                                            <th style="width : 10%">Cantidad</th>
                                            <th style="width : 10%">Ingreso Producci&oacute;n</th>
                                            <th style="width : 10%">%</th>
                                        </tr>
                                        </thead>
                                        <tbody id="divAcerradoMadera">
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="7" style="text-align:right;"><strong>Total:</strong></td>
                                                <td><input type="text" id="total_produccion" class="form-control form-control-sm" readonly></td>
                                                <td><input type="text" id="total_produccion_porcentaje" class="form-control form-control-sm" readonly></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div style="margin-top:15px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                    
                                        <!--<a href="javascript:void(0)" onClick="fn_save_madera_acerrado()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>-->
                                        <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-nuevo" data-toggle="modal" onclick="fn_save_madera_acerrado()">
                                            <i class="fas fa-save" style="font-size:18px;"></i> Guardar
                                        </button>
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
        </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
    
<script type="text/javascript">
$(document).ready(function () {
	
});


</script>



