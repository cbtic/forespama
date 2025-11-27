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
    max-width:60%!important
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

    $("#empresa").select2({ width: '100%' });
    
    $('#fecha').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

    actualizarDenominacion();
    actualizarDenominacionMoneda();

});

</script>

<script type="text/javascript">

$(document).ready(function() {

});

function fn_save_factura_historico(){
	
    var msg = "";

    var serie = $('#serie').val();
    var numero = $('#numero').val();
    var total = $('#total').val();
    
    if(serie==""){msg+="Ingrese la Serie <br>";}
    if(numero==""){msg+="Ingrese el Numero <br>";}
    if(total==""){msg+="Ingrese el Total <br>";}

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
            url: "/comprobante/send_factura_historico",
            type: "POST",
            data : $("#frmFacturaHistorico").serialize(),
            success: function (result) {
                $('#openOverlayOpc').modal('hide');
                datatablenew();
                $('.loader').hide();
                bootbox.alert("Se guard&oacute; satisfactoriamente"); 
                
            }
        });
    }
}

function actualizarDenominacion() {

    var denominacion = $("#empresa option:selected").text();

    $('#empresa_nombre').val(denominacion);

}

function actualizarDenominacionMoneda() {

    var denominacion = $("#moneda option:selected").text();

    $('#moneda_nombre').val(denominacion);

}

</script>

<body class="hold-transition skin-blue sidebar-mini">
    <div>
		<div class="justify-content-center">

            <div class="card">
                
                <div style="text-align: center; font-size:16px; margin-top: 20px">
                    <b>Datos de Factura Forespama</b>
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmFacturaHistorico" name="frmFacturaHistorico">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                        
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="id" value="<?php echo $id?>">

                        <div class="row" style="padding-left:10px; padding-top: 15px;">
                            <div class="col-lg-2">
                                Serie
                            </div>
                            <div class="col-lg-2">
                                <input id="serie" name="serie" on class="form-control form-control-sm"  value="<?php //if($orden_compra_contacto_entrega){echo $orden_compra_contacto_entrega->telefono;}?>" type="text">
                            </div>
                            <div class="col-lg-2">
                                N&uacute;mero
                            </div>
                            <div class="col-lg-2">
                                <input id="numero" name="numero" class="form-control form-control-sm"  value="<?php //if($orden_compra_contacto_entrega){echo $orden_compra_contacto_entrega->telefono;}?>" type="text">
                            </div>
                            <div class="col-lg-2">
                                Fecha
                            </div>
                            <div class="col-lg-2">
                                <input id="fecha" name="fecha" class="form-control form-control-sm"  value="<?php //if($orden_compra_contacto_entrega){echo $orden_compra_contacto_entrega->telefono;}?>" type="text">
                            </div>
                        </div>
                        <div class="row" style="padding-left:10px; padding-top: 15px;">
                            <div class="col-lg-2">
                                Empresa
                            </div>
                            <div class="col-lg-10">
                                <select name="empresa" id="empresa" class="form-control form-control-sm" onchange="actualizarDenominacion()">
                                    <option value="">--Seleccionar--</option>
                                    <?php
                                    foreach ($empresa as $row){?>
                                        <option value="<?php echo $row->id ?>"<?php if($row->id==23)echo "selected='selected'"?>><?php echo $row->razon_social ?></option>
                                        <?php 
                                    }
                                    ?>
                                </select>
                            </div>
                            <input type="hidden" name="empresa_nombre" id="empresa_nombre" class="form-control form-control-sm">
                        </div>
                        <div class="row" style="padding-left:10px; padding-top: 15px;">
                            <div class="col-lg-2">
                                Direcci&oacute;n
                            </div>
                            <div class="col-lg-10">
                                <input id="direccion" name="direccion" class="form-control form-control-sm"  value="<?php //if($orden_compra_contacto_entrega){echo $orden_compra_contacto_entrega->telefono;}?>" type="text">
                            </div>
                        </div>
                        <div class="row" style="padding-left:10px; padding-top: 15px;">
                            <div class="col-lg-2">
                                SubTotal
                            </div>
                            <div class="col-lg-2">
                                <input id="subtotal" name="subtotal" class="form-control form-control-sm"  value="<?php //if($orden_compra_contacto_entrega){echo $orden_compra_contacto_entrega->telefono;}?>" type="text">
                            </div>
                            <div class="col-lg-2">
                                Impuesto
                            </div>
                            <div class="col-lg-2">
                                <input id="impuesto" name="impuesto" on class="form-control form-control-sm"  value="<?php //if($orden_compra_contacto_entrega){echo $orden_compra_contacto_entrega->telefono;}?>" type="text">
                            </div>
                            <div class="col-lg-2">
                                Total
                            </div>
                            <div class="col-lg-2">
                                <input id="total" name="total" on class="form-control form-control-sm"  value="<?php //if($orden_compra_contacto_entrega){echo $orden_compra_contacto_entrega->telefono;}?>" type="text">
                            </div>
                        </div>
                        <div class="row" style="padding-left:10px; padding-top: 15px;">
                            <div class="col-lg-2">
                                Retenci&oacute;n
                            </div>
                            <div class="col-lg-2">
                                <input id="retencion" name="retencion" on class="form-control form-control-sm"  value="<?php //if($orden_compra_contacto_entrega){echo $orden_compra_contacto_entrega->telefono;}?>" type="text">
                            </div>
                            <div class="col-lg-2">
                                Moneda
                            </div>
                            <div class="col-lg-2">
                                <select name="moneda" id="moneda" class="form-control form-control-sm" onchange="actualizarDenominacionMoneda()">
                                    <option value="">--Seleccionar--</option>
                                    <?php
                                    foreach ($moneda as $row){?>
                                        <option value="<?php echo $row->codigo ?>"<?php if($row->codigo==1)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                        <?php 
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="moneda_nombre" id="moneda_nombre" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div style="margin-top:15px" class="form-group">
                            <div class="col-sm-12 controls">
                                <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                
                                    <!--<a href="javascript:void(0)" onClick="fn_save_factura_historico()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>-->
                                    <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-nuevo" data-toggle="modal" onclick="fn_save_factura_historico()">
                                        <i class="fas fa-save" style="font-size:18px;"></i> Guardar
                                    </button>
                                    <!--<a href="javascript:void(0)" onClick="$('#openOverlayOpc').modal('hide');" class="btn btn-sm btn-info" style="margin-left:10px">Cerrar</a>-->
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
</body>
    
<script type="text/javascript">


</script>
