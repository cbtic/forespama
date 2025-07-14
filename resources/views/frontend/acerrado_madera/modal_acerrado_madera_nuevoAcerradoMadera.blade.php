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
    max-width:70%!important
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

$('#openOverlayOpc').on('shown.bs.modal', function() {
	 
});


function fn_save_madera_acerrado(){
	
    var msg = "";
    var _token = $('#_token').val();
	var id = $('#id').val();

    var producto = $('#producto').val();
    var codigo_producto = $('#codigo_producto').val();
    var empresa = $('#empresa').val();
    var codigo_producto_empresa = $('#codigo_producto_empresa').val();
    var denominacion_producto_empresa = $('#denominacion_producto_empresa').val();

    if(producto==""){msg+="Ingrese el Producto <br>";}
    if(codigo_producto==""){msg+="Ingrese el Codigo de Producto <br>";}
    if(empresa==""){msg+="Ingrese la Empresa <br>";}
    if(codigo_producto_empresa==""){msg+="Ingrese el Codigo de Producto de la Empresa <br>";}
    if(denominacion_producto_empresa==""){msg+="Ingrese la Denominacion del Producto de la Empresa <br>";}

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
                url: "/equivalencia_producto/send_equivalencia_producto",
                type: "POST",
                data : $("#frmEquivalenciaProducto").serialize(),
                success: function (result) {
                    //alert(result.id)
                    $('#openOverlayOpc').modal('hide');
                    datatablenew();
                    $('.loader').hide();
                    bootbox.alert("Se guard&oacute; satisfactoriamente"); 
                    /*if (result.id>0) {
                        modalOrdenCompra(result.id);
                    }*/
                   
                }
        });
    }
}

function cargarDetalleIngreso(){

    var id = $("#id").val();
    const tbody = $('#divAcerradoMadera');

    tbody.empty();

    $.ajax({
        url: "/acerrado_madera/cargar_detalle_ingreso_vehiculo_acerrado/",
        dataType: "GET",
        success: function(result){
            
            alert(result);

            let n = 1;

            var total_acumulado=0;

            result.detalle_ingreso_acerrado.forEach(detalle_ingreso_acerrado => {

                const row = `
                    <tr>
                        <td>${n}</td>
                        <td style="width: 450px !important;display:block"><input name="id_ingreso_acerrado_detalle[]" id="id_ingreso_acerrado_detalle${n}" class="form-control form-control-sm" value="${detalle_ingreso_acerrado.id}" type="hidden"><input name="ruc[]" id="ruc${n}" class="form-control form-control-sm" value="${detalle_ingreso_acerrado.ruc}" type="text"></td>
                        <td><input name="razon_social[]" id="razon_social${n}" class="form-control form-control-sm" value="${detalle_ingreso_acerrado.razon_social}" type="text"></td>
                        <td><input name="placa[]" id="placa${n}" class="form-control form-control-sm" value="${detalle_ingreso_acerrado.placa}" type="text"></td>
                        <td><input name="tipo_madera[]" id="tipo_madera${n}" class="form-control form-control-sm" value="${detalle_ingreso_acerrado.tipo_maderea}" type="text"></td>
                        <td><input name="cantidad_ingreso[]" id="cantidad_ingreso${n}" class="form-control form-control-sm" value="${detalle_ingreso_acerrado.cantidad}" type="text"></td>
                        <td><input name="cantidad_ingreso_produccion[]" id="cantidad_ingreso_produccion${n}" class="form-control form-control-sm" value="" type="text"></td>
                        <td><input name="procentaje[]" id="procentaje${n}" class="form-control form-control-sm" value="" type="text"></td>
                    </tr>
                `;
                tbody.append(row);
                
                n++;
            });
        }
    });
}

</script>

<body class="hold-transition skin-blue sidebar-mini">
    
    <div>
		<div class="justify-content-center">

            <div class="card">

                <div class="card-header" style="text-align: center; font-size:16px; margin-top: 20px">
                    <b>Ingreso Diario Producci&oacute;n de Madera Acerrada</b>
                </div>
                
                <div class="card-body">
                    <form method="post" action="#" id="frmAcerradoMadera" name="frmAcerradoMadera">
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
                                            <th style="width : 5%">#</th>
                                            <th style="width : 20%">Ruc</th>
                                            <th style="width : 20%">Razon Social</th>
                                            <th style="width : 5%">Letra</th>
                                            <th style="width : 10%">Placa</th>
                                            <th style="width : 10%">Tipo Madera</th>
                                            <th style="width : 10%">Cantidad</th>
                                            <th style="width : 10%">Ingreso Producci&oacute;n</th>
                                            <th style="width : 10%">%</th>
                                        </tr>
                                        </thead>
                                        <tbody id="divAcerradoMadera">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div style="margin-top:15px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                    
                                        <a href="javascript:void(0)" onClick="fn_save_madera_acerrado()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>
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

<script type="text/javascript">
$(document).ready(function() {
	
	
});

</script>

