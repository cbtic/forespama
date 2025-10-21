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
    max-width:80%!important
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

    $("#producto").select2({ width: '100%' });
    $("#empresa").select2({ width: '100%' });

    actualizarLegend();
});

</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
	 
});

function obtenerCodInterno(){

    var id_producto = $('#producto').val();

    $.ajax({
        url: "/productos/obtener_producto/"+id_producto,
        dataType: "json",
        success: function(result){
            //alert(result[0].codigo);
            $('#codigo_producto').val(result[0].codigo);
        }
    });
}

function fn_save_equivalencia_producto(){
	
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

$('#producto').on('change', function(){
    
    var descripcionCompleta = $('#producto option:selected').text();
    var descripcion = descripcionCompleta.split(' - ')[1];

    $('#producto_descripcion').val(descripcion);

});

function actualizarLegend(){

    var texto_empresa = $('#empresa option:selected').text();

    var legend = $('fieldset[name="equivalencia_empresa"] legend');

    if ($('#empresa').val()) {
        legend.text('Equivalencia de ' + texto_empresa);
    } else {
        legend.text('Equivalencia de Nuestro Producto');
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

            <div class="card">

                <div class="card-header" style="text-align: center; font-size:16px; margin-top: 20px">
                    <b>Ingreso Equivalencia Producto</b>
                </div>
                
                    <div class="card-body">
                        <form method="post" action="#" id="frmEquivalenciaProducto" name="frmEquivalenciaProducto">
                        <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            
                            <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                            
                            <div class="row" style="padding-left:10px">

                                <div class="col-lg-2">
                                    Producto
                                </div>
                                <div class="col-lg-6">
                                    <select name="producto" id="producto" class="form-control form-control-sm" onchange="obtenerCodInterno()">
                                        <option value="">--Seleccionar--</option>
                                        <?php
                                        foreach ($producto as $row){?>
                                            <option value="<?php echo $row->id ?>" <?php if($row->id==$equivalencia_producto->id_producto)echo "selected='selected'"?>><?php echo $row->codigo .' - '. $row->denominacion;?></option>
                                        <?php 
                                        }
                                        ?>
                                        <input id="producto_descripcion" name="producto_descripcion" on class="form-control form-control-sm"  value="<?php if($id>0){echo $equivalencia_producto->descripcion_producto;}?>" hidden="hidden">
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    C&oacute;digo Producto
                                </div>
                                <div class="col-lg-2">
                                    <input id="codigo_producto" name="codigo_producto" on class="form-control form-control-sm"  value="<?php if($id>0){echo $equivalencia_producto->codigo_producto;}?>" type="text" readonly ="readonly">
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px; padding-top : 10px">
                                <div class="col-lg-2">
                                    Empresa
                                </div>
                                <div class="col-lg-4">
                                    <select name="empresa" id="empresa" class="form-control form-control-sm" onchange="actualizarLegend()">
                                        <option value="">--Seleccionar--</option>
                                        <?php
                                        foreach ($empresa as $row){?>
                                            <option value="<?php echo $row->id ?>" <?php if($row->id==$equivalencia_producto->id_empresa)echo "selected='selected'"?>><?php echo $row->razon_social ?></option>
                                            <?php 
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <fieldset name="equivalencia_empresa" style="border:1px solid #A4A4A4; padding: 10px">
                                <legend class="control-label form-control-sm">Equivalencia de Nuestro Producto</legend>
                                <div class="row" style="padding-left:10px; padding-top : 10px">
                                    <div class="col-lg-2">
                                        C&oacute;digo Producto Empresa
                                    </div>
                                    <div class="col-lg-2">
                                        <input id="codigo_producto_empresa" name="codigo_producto_empresa" on class="form-control form-control-sm"  value="<?php if($id>0){echo $equivalencia_producto->codigo_empresa;}?>" type="text">
                                    </div>
                                    <!--<div class="col-lg-2">
                                        SKU Producto Empresa
                                    </div>
                                    <div class="col-lg-2">
                                        <input id="sku_producto_empresa" name="sku_producto_empresa" on class="form-control form-control-sm"  value="<?php //if($id>0){echo $equivalencia_producto->sku;}?>" type="text">
                                    </div>-->
                                    <div class="col-lg-2">
                                    Denominaci&oacute;n Producto Empresa
                                    </div>
                                    <div class="col-lg-4">
                                        <input id="denominacion_producto_empresa" name="denominacion_producto_empresa" on class="form-control form-control-sm"  value="<?php if($id>0){echo $equivalencia_producto->descripcion_empresa;}?>" type="text">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset name="equivalencia_dimfer" style="border:1px solid #A4A4A4; padding: 10px">
                                <legend class="control-label form-control-sm">Equivalencia Dimfer</legend>
                                <div class="row" style="padding-left:10px; padding-top : 10px">
                                    <div class="col-lg-2">
                                        C&oacute;digo
                                    </div>
                                    <div class="col-lg-2">
                                        <input id="codigo_producto_dimfer" name="codigo_producto_dimfer" on class="form-control form-control-sm"  value="<?php if($id>0){echo $equivalencia_producto->codigo_dimfer;}?>" type="text">
                                    </div>
                                    <div class="col-lg-2">
                                    Denominaci&oacute;n
                                    </div>
                                    <div class="col-lg-4">
                                        <input id="denominacion_producto_dimfer" name="denominacion_producto_dimfer" on class="form-control form-control-sm"  value="<?php if($id>0){echo $equivalencia_producto->descripcion_dimfer;}?>" type="text">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset name="equivalencia_ares" style="border:1px solid #A4A4A4; padding: 10px">
                                <legend class="control-label form-control-sm">Equivalencia Ares</legend>
                                <div class="row" style="padding-left:10px; padding-top : 10px">
                                    <div class="col-lg-2">
                                        C&oacute;digo
                                    </div>
                                    <div class="col-lg-2">
                                        <input id="codigo_producto_ares" name="codigo_producto_ares" on class="form-control form-control-sm"  value="<?php if($id>0){echo $equivalencia_producto->codigo_ares;}?>" type="text">
                                    </div>
                                    <div class="col-lg-2">
                                    Denominaci&oacute;n
                                    </div>
                                    <div class="col-lg-4">
                                        <input id="denominacion_producto_ares" name="denominacion_producto_ares" on class="form-control form-control-sm"  value="<?php if($id>0){echo $equivalencia_producto->descripcion_ares;}?>" type="text">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        </div>
                            <div style="margin-top:15px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                    
                                        <a href="javascript:void(0)" onClick="fn_save_equivalencia_producto()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>
                                        <a href="javascript:void(0)" onClick="$('#openOverlayOpc').modal('hide');" class="btn btn-sm btn-info" style="">Cerrar</a>
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
	//$('#numero_placa').focus();
	//$('#numero_placa').mask('AAA-000');
	//$('#vehiculo_numero_placa').mask('AAA-000');
	
	
});

</script>

