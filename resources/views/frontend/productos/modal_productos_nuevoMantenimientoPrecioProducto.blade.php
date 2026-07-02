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
    max-width:50%!important
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

$(document).ready(function() {

    $("#unidad_producto, #unidad_medida, #marca, #modelo, #medida, #tipo_producto").select2({ width: '100%' });

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

</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
     $('#fecha_solicitud').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		//container: '#openOverlayOpc modal-body'
		container: '#openOverlayOpc modal-body'
     });
});

$(document).ready(function() {
	
    if($("#id").val()>0){
        cargarImagenes();
        obtenerSubFamilia();
    }
});

function fn_save_precio_producto(){

    var msg = "";

    var denominacion = $('#denominacion').val();
    var moneda = $('#moneda').val();
    var costo_unitario = $('#costo_unitario').val();
    var margen = $('#margen').val();
	
    if(denominacion==""){msg+="Ingrese la Denominacion del Producto <br>";}
    if(moneda==""){msg+="Seleccione la Moneda <br>";}
    if(costo_unitario==""){msg+="Ingrese el Costo Unitario <br>";}
    if(margen==""){msg+="Ingrese el Margen <br>";}

    if(msg!=""){

        bootbox.alert(msg);
        return false;

    }else{

        var msgLoader = "";
        msgLoader = "Procesando, espere un momento por favor";
        var heightBrowser = $(window).width()/2;
        $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
        $('.loader').show();
        let form = document.getElementById('frmMantenimientoPrecioProducto');
	    let formData = new FormData(form);

        $.ajax({
            url: "/productos/send_mantenimiento_precio_producto",
            type: "POST",
            data : formData,
            contentType: false,
            processData: false, 
            success: function (result) {

                if (result.success) {
                    $('.loader').hide();
                    bootbox.alert(result.success, function() {
                        $('#openOverlayOpc').modal('hide');
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

function obtenerPrecios(campo){

    var costo = parseFloat($('#costo_unitario').val());
    var margen = parseFloat($('#margen').val());
    var valor = parseFloat($('#valor_venta').val());
    var precio = parseFloat($('#precio_venta').val());

    var igv = 1.18;

    if(campo == 'costo'){

        if(precio){
            valor = precio / igv;
            margen = (1 - (costo / valor)) * 100;

            $('#valor_venta').val(valor.toFixed(2));
            $('#margen').val(margen.toFixed(2));

        }else if(margen){

            valor = costo * (1 + margen/100);
            precio = valor * igv;

            $('#valor_venta').val(valor.toFixed(2));
            $('#precio_venta').val(precio.toFixed(2));
        }
    }

    if(campo == 'margen'){

        if(costo){

            valor = costo / (1 - margen/100);
            precio = valor * igv;

            $('#valor_venta').val(valor.toFixed(2));
            $('#precio_venta').val(precio.toFixed(2));

        }
    }

    if(campo == 'valor'){

        margen = (1 - (costo / valor)) * 100;
        precio = valor * igv;

        $('#margen').val(margen.toFixed(2));
        $('#precio_venta').val(precio.toFixed(2));

    }

    if(campo == 'precio'){

        valor = precio / igv;
        margen = (1 - (costo / valor)) * 100;

        $('#valor_venta').val(valor.toFixed(2));
        $('#margen').val(margen.toFixed(2));

    }

    /*if (costo && margen) {
        let valor_venta = costo * (1 + margen / 100);
        let precio_venta = valor_venta * igv;

        $('#valor_venta').val(valor_venta.toFixed(2));
        $('#precio_venta').val(precio_venta.toFixed(2));
    }else if (costo && precio) {
        let valor_venta = precio / igv;
        let margen_calculado = (1 - (costo / valor_venta)) * 100;
        
        $('#valor_venta').val(valor_venta.toFixed(2));
        $('#margen').val(margen_calculado.toFixed(2));
    }else if (costo && valor) {
        let margen_calculado = (1 - (costo / valor_venta)) * 100;
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
        let margen_calculado = (1 - (costo / valor_venta)) * 100;

        $('#costo_unitario').val(costo_calculado.toFixed(2));
        $('#margen').val(margen_calculado.toFixed(2));
    }*/
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
                    Registrar Precio producto
                </div>
            
                <div class="card-body">
                <form method="post" action="#" id="frmMantenimientoPrecioProducto" name="frmMantenimientoPrecioProducto">

                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:10px">
                                
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="control-label form-control-sm">C&oacute;digo</label>
                                        <input id="codigo" name="codigo" on class="form-control form-control-sm"  value="<?php echo $producto->codigo?>" type="text" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-10">
                                    <div class="form-group">
                                        <label class="control-label form-control-sm">Denominaci&oacute;n</label>
                                        <input id="denominacion" name="denominacion" on class="form-control form-control-sm"  value="<?php echo htmlspecialchars($producto->denominacion, ENT_QUOTES, 'UTF-8')?>" type="text" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="control-label form-control-sm">Unidad Producto</label>
                                        <select name="unidad_producto" id="unidad_producto" class="form-control form-control-sm" onchange="" disabled>
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
                                <div class="col-lg-2">
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
                            </div>
                            <div class="row" style="padding-left:10px">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label form-control-sm">Costo Unitario</label>
                                        <input id="costo_unitario" name="costo_unitario" on class="form-control form-control-sm" value="<?php echo $producto->costo_unitario?>" type="text" onchange="obtenerPrecios('costo')">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label form-control-sm">Margen</label>
                                        <input id="margen" name="margen" on class="form-control form-control-sm" value="<?php echo $producto->margen?>" type="text" onchange="obtenerPrecios('margen')">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label form-control-sm">Valor Venta</label>
                                        <input id="valor_venta" name="valor_venta" on class="form-control form-control-sm" value="<?php echo $producto->valor_venta?>" type="text" onchange="obtenerPrecios('valor')" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label form-control-sm">Precio Venta</label>
                                        <input id="precio_venta" name="precio_venta" on class="form-control form-control-sm" value="<?php echo $producto->precio_venta?>" type="text" onchange="obtenerPrecios('precio')" readonly>
                                    </div>
                                </div>
                            </div>
                        <!--</div>-->
                        <div style="margin-top:15px" class="form-group">
                            <div class="col-sm-12 controls">
                                <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                    <button type="button" style="font-size:12px;margin-left:10px" class="btn btn-sm btn-clasico btn-nuevo" data-toggle="modal" onclick="fn_save_precio_producto()">
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
	});
		
});

</script>

<script type="text/javascript">
$(document).ready(function() {
	
});

</script>
