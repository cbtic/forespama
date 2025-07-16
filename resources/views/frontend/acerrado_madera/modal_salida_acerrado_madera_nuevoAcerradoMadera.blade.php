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

    //cargarDetalleIngreso();

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

$('#openOverlayOpc').on('shown.bs.modal', function() {
	 
});

function fn_save_produccion_madera_acerrado(){
	
     var msg = "";
    var _token = $('#_token').val();
	var id = $('#id').val();

    var fecha = $('#fecha').val();

    if(fecha==""){msg+="Ingrese una Fecha <br>";}

    if ($('#tblSalidaAcerradoMadera tbody tr').length == 0) {
        msg += "No se ha agregado ningún registro <br>";
    }

    if(msg!=""){
        bootbox.alert(msg);
        return false;
    }else{
        bootbox.confirm({ 
            size: "small",
            message: "&iquest;Est&aacute; seguro de Guardar el ingreso?", 
            callback: function(result){
                if (result==true) {
                    save_produccion();
                }
            }
        });
        
    }
}


function save_produccion(){
	
    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

    $.ajax({
        url: "/acerrado_madera/send_produccion_acerrado_madera",
        type: "POST",
        data : $("#frmSalidaAcerradoMadera").serialize(),
        success: function (result) {
            
            $('#openOverlayOpc').modal('hide');
            $('.loader').hide();
            bootbox.alert("Se guard&oacute; satisfactoriamente"); 
            datatablenew2();
        }
    });
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
                        <td><input name="tipo_madera[]" id="tipo_madera${n}" class="form-control form-control-sm" style="border: none; background-color: transparent;" value="${detalle_ingreso_acerrado.tipo_madera}" type="text" readonly></td>
                        <td><input name="cantidad_ingreso[]" id="cantidad_ingreso${n}" class="cantidad_ingreso form-control form-control-sm" style="border: none; background-color: transparent;" value="${detalle_ingreso_acerrado.cantidad}" type="text" readonly></td>
                        <td><input name="cantidad_ingreso_produccion[]" id="cantidad_ingreso_produccion${n}" class="cantidad_ingreso_produccion form-control form-control-sm" value="" type="text" onchange="calcularPorcentaje(this)"></td>
                        <td><input name="porcentaje[]" id="porcentaje${n}" class="porcentaje form-control form-control-sm" value="" type="text"></td>
                    </tr>
                `;
                tbody.append(row);
                
                n++;
            });
        }
    })
}

function calcularPorcentaje(input){

    var fila = $(input).closest('tr');
    
    var cantidad_ingreso = parseFloat(fila.find('.cantidad_ingreso').val()) || 0;
    var cantidad_ingreso_produccion = parseFloat(fila.find('.cantidad_ingreso_produccion').val()) || 0;
    var porcentaje = 0;
    //alert(cantidad_ingreso+'-'+cantidad_ingreso_produccion);

    if(cantidad_ingreso_produccion > cantidad_ingreso){

        bootbox.alert("La cantidad de ingreso a produccion no puede ser mayor que la cantidad de ingreso");
        fila.find('.porcentaje').val("0.00");
    }else{

        porcentaje = (cantidad_ingreso_produccion / cantidad_ingreso)*100;
        fila.find('.porcentaje').val(porcentaje.toFixed(2));

    }
}

function agregarSalidaAcerrado(){

    var cantidad = 1;
    var newRow = "";
    for (var i = 0; i < cantidad; i++) { 
        var n = $('#tblSalidaAcerradoMadera tbody tr').length + 1;
        var tipo_madera = '<select name="tipo_madera[]" id="tipo_madera' + n + '" class="form-control form-control-sm" onchange=""> <option value="">--Seleccionar--</option><?php foreach ($tipo_madera as $row){?><option value="<?php echo $row->codigo; ?>"><?php echo $row->denominacion; ?></option><?php }?></select>';
        var medida = '<input name="id_salida_acerrado_madera[]" id="id_salida_acerrado_madera${n}" class="form-control form-control-sm" value="1" type="hidden"><select name="medida[]" id="medida' + n + '" class="form-control form-control-sm" onchange=""> <option value="">--Seleccionar--</option><?php foreach ($medida_acerrado as $row){?><option value="<?php echo $row->codigo; ?>"><?php echo $row->denominacion; ?></option><?php }?></select>';
        var paquete = '<input name="paquete[]" id="paquete' + n + '" class="paquete form-control form-control-sm" value="" type="text" oninput="calcularNPiezas(this)">';
        var medida_paquete1 = '<input name="medida_paquete1[]" id="medida_paquete1' + n + '" class="medida_paquete1 form-control form-control-sm" value="" type="text" oninput="calcularNPiezas(this)">';
        var medida_paquete2 = '<input name="medida_paquete2[]" id="medida_paquete2' + n + '" class="medida_paquete2 form-control form-control-sm" value="" type="text" oninput="calcularNPiezas(this)">';
        var n_piezas = '<input name="n_piezas[]" id="n_piezas' + n + '" class="n_piezas form-control form-control-sm" value="" type="text" readonly>';
        
        var btnEliminar = '<button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button>';

        newRow += '<tr>';
        newRow += '<td>' + n + '</td>';
        newRow += '<td>' + tipo_madera + '</td>';
        newRow += '<td>' + medida + '</td>';
        newRow += '<td>' + paquete + '</td>';
        newRow += '<td>' + medida_paquete1 + '</td>';
        newRow += '<td>' + medida_paquete2 + '</td>';
        newRow += '<td>' + n_piezas + '</td>';
        newRow += '<td>' + btnEliminar + '</td>';
        newRow += '</tr>';

        $('#tblSalidaAcerradoMadera tbody').append(newRow);
        
    }
}

function calcularNPiezas(input){

    var fila = $(input).closest('tr');

    var paquete = parseFloat(fila.find('.paquete').val()) || 0;
    var medida_paquete1 = parseFloat(fila.find('.medida_paquete1').val()) || 0;
    var medida_paquete2 = parseFloat(fila.find('.medida_paquete2').val()) || 0;
    var n_piezas = parseFloat(fila.find('.n_piezas').val()) || 0;

    n_piezas = paquete * medida_paquete1 * medida_paquete2;

    fila.find('.n_piezas').val(n_piezas);   

}

function eliminarFila(button){

    $(button).closest('tr').remove();

}

</script>

<body class="hold-transition skin-blue sidebar-mini">
    
    <div>
		<div class="justify-content-center">

            <div class="card">

                <div class="card-header" style="text-align: center; font-size:16px; margin-top: 20px">
                    <b>Producci&oacute;n Acerrio</b>
                </div>
                
                <div class="card-body">
                    <form method="post" action="#" id="frmSalidaAcerradoMadera" name="frmSalidaAcerradoMadera">
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
                            <div style="margin-top:15px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                        <a href="javascript:void(0)" onClick="agregarSalidaAcerrado()" class="btn btn-sm btn-success">Agregar</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive" style="overflow-y: auto; max-height: 400px; overflow-x: auto; ">
                                    <table id="tblSalidaAcerradoMadera" class="table table-hover table-sm">
                                        <thead>
                                        <tr style="font-size:13px">
                                            <th style="width : 5%">#</th>
                                            <th style="width : 20%">Tipo Madera</th>
                                            <th style="width : 20%">Medida</th>
                                            <th style="width : 10%">Paquetes</th>
                                            <th style="width : 10%">Cantidad 1</th>
                                            <th style="width : 10%">Cantidad 2</th>
                                            <th style="width : 10%">N° Piezas</th>
                                            <th style="width : 10%"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="divSalidaAcerradoMadera">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div style="margin-top:15px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                    
                                        <a href="javascript:void(0)" onClick="fn_save_produccion_madera_acerrado()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>
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



