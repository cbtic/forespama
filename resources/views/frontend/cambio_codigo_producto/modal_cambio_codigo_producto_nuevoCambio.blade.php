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
	max-width:40%!important
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

$(document).ready(function() {
    
});
</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
     $('#fecha_solicitud').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
     });

     $('#producto_principal').select2({ width:'100%' })
     
     $('#producto_secundario').select2({ width:'100%' })
	 
});

$(document).ready(function() {
	 
});

function limpiar(){
	$('#id').val("0");
	$('#id_tipo_documento').val("");
	$('#denominacion').val("");
	$('#img_foto').val("");
}

function fn_save_cambio_codigo(){

    var msg = "";

    var almacen = $('#almacen').val();
    var producto_principal = $('#producto_principal').val();
    var producto_secundario = $('#producto_secundario').val();
    var stock_principal = parseFloat($('#stock_principal').val()) || 0;
    var cantidad_principal = parseFloat($('#cantidad_principal').val()) || 0;

    if(almacen==""){msg+="Seleccione el Almacen <br>";}
    if(producto_principal==""){msg+="Seleccione el Producto de Salida <br>";}
    if(producto_secundario==""){msg+="Seleccione el Producto de Ingreso <br>";}
    if(cantidad_principal==""){msg+="Ingrese la Cantidad <br>";}
    
    if(cantidad_principal > stock_principal){
        msg+="No hay Stock para realizar la transaccion <br>";
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
            url: "/cambio_codigo_producto/send_cambio_codigo_producto",
            type: "POST",
            data : $("#frmCambioCodigo").serialize(),
            success: function (result) {
                if (result.success) {
                    ('.loader').hide();
                    bootbox.alert(result.success, function() {
                        datatablenew();
                        $('#openOverlayOpc').modal('hide');
                    });
                } else if (result.error) {
                    $('.loader').hide();
                    bootbox.alert(result.error);
                }
            },
        });
    }
}

function obtenerStockPrincipal(){

    var producto_principal = $('#producto_principal').val();
    var almacen = $('#almacen').val();

    $.ajax({
        url: "/productos/obtener_stock_producto/"+almacen+"/"+producto_principal,
        dataType: "json",
        success: function(result){

            var producto_stock = result.producto_stock[producto_principal];
            
            $('#stock_principal').val(producto_stock.saldos_cantidad);
        }
    });
}

function obtenerStockSecundario(){

    var producto_secundario = $('#producto_secundario').val();
    var almacen = $('#almacen').val();

    $.ajax({
        url: "/productos/obtener_stock_producto/"+almacen+"/"+producto_secundario,
        dataType: "json",
        success: function(result){

            var producto_stock = result.producto_stock[producto_secundario];
            
            $('#stock_secundario').val(producto_stock.saldos_cantidad);
        }
    });
}

</script>

<body class="hold-transition skin-blue sidebar-mini">

    <div>
		<div class="justify-content-center">		

            <div class="card">
                
                <div class="card-header" style="padding:5px!important;padding-left:20px!important">
                    Registrar Cambio de C&oacute;digo
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmCambioCodigo" name="frmCambioCodigo">

                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                                
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                            
                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label form-control-sm">Almacen</label>
                                        <select name="almacen" id="almacen" class="form-control form-control-sm">
                                            <option value="">--Seleccionar--</option>
                                            <?php 
                                            foreach ($almacen as $row){?>
                                                <option value="<?php echo $row->id ?>" <?php if($row->id==$cambio_codigo_producto->id_almacen)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label class="control-label form-control-sm">Producto Salida</label>
                                        <select name="producto_principal" id="producto_principal" class="form-control form-control-sm" onchange="obtenerStockPrincipal()">
                                            <option value="">--Seleccionar--</option>
                                            <?php 
                                            foreach ($productos as $row){?>
                                                <option value="<?php echo $row->id ?>" <?php if($row->id==$cambio_codigo_producto->id_producto)echo "selected='selected'"?>><?php echo $row->codigo . '-' . $row->denominacion ?></option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label class="control-label form-control-sm">Stock</label>
                                    <input id="stock_principal" name="stock_principal" on class="form-control form-control-sm"  value="<?php //echo $cambio_codigo_producto->cantidad;?>" type="text" readonly>
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label class="control-label form-control-sm">Producto Ingreso</label>
                                        <select name="producto_secundario" id="producto_secundario" class="form-control form-control-sm" onchange="obtenerStockSecundario()">
                                            <option value="">--Seleccionar--</option>
                                            <?php 
                                            foreach ($productos as $row){?>
                                                <option value="<?php echo $row->id ?>" <?php if($row->id==$cambio_codigo_producto->id_producto_secundario)echo "selected='selected'"?>><?php echo $row->codigo . '-' . $row->denominacion ?></option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label class="control-label form-control-sm">Stock</label>
                                    <input id="stock_secundario" name="stock_secundario" on class="form-control form-control-sm"  value="<?php //echo $cambio_codigo_producto->cantidad;?>" type="text" readonly>
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-3">
                                    <label class="control-label form-control-sm">Cantidad</label>
                                    <input id="cantidad_principal" name="cantidad_principal" on class="form-control form-control-sm"  value="<?php echo $cambio_codigo_producto->cantidad;?>" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if($id ==0){?>
                    <div style="margin-top:15px" class="form-group">
                        <div class="col-sm-12 controls">
                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                <!--<a href="javascript:void(0)" onClick="fn_save_marca()" class="btn btn-sm btn-success">Guardar</a>-->
                                <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-nuevo" data-toggle="modal" onclick="fn_save_cambio_codigo()">
                                    <i class="fas fa-save" style="font-size:18px;"></i> Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php }?>

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

