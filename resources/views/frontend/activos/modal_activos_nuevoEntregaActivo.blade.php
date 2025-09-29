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

.scrolls {
	height: 100px;
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

    
});
</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
     $('#fecha_entrega').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });
    
    $('#fecha_devolucion').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });


	 
});

$(document).ready(function() {

    $('#persona').select2({ width : '100%' })

});

function fn_save_entrega_activos(){

    var msg = "";

    var persona = $('#persona').val();
    var activo = $('#activo').val();
    var fecha_entrega = $('#fecha_entrega').val();

    if(persona==""){msg+="Seleccione la Persona <br>";}
    if(activo==""){msg+="Seleccione el Activo <br>";}
    if(fecha_entrega==""){msg+="Ingrese la Fecha de Entrega <br>";}
	
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
            url: "/activos/send_entrega_activo",
            type: "POST",
            data : $("#frmEntregaActivos").serialize(),
            success: function (result) {
                
                if (result.success) {
                    $('.loader').hide();
                    bootbox.alert(result.success, function() {
                        
                        $('#openOverlayOpc').modal('hide');
                        datatablenew();
                    });
                } else if (result.error) {
                    bootbox.alert(result.error);
                }
            },
        });
    }
}

</script>

<body class="hold-transition skin-blue sidebar-mini">

    <div>
		<div class="justify-content-center">		

            <div class="card">
                
                
                <div class="" style="padding-top:20px!important;padding-left:20px!important;padding-right:20px; text-align: center">
                    <b style="font-size : 15px">Registrar Entrega Activos</b>
                    <!--<img src="/img/logo_forestalpama.jpg" align="right" style="width: 120px; height: 50px">-->
                </div>

                <div class="card-body">
                <form method="post" action="#" id="frmEntregaActivos" name="frmEntregaActivos">

                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;">
                                
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                            
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label class="control-label form-control-sm">Persona</label>
                                        <select name="persona" id="persona" class="form-control form-control-sm">
                                            <option value="">--Seleccionar--</option>
                                            <?php 
                                            foreach ($persona as $row){?>
                                                <option value="<?php echo $row->id ?>" <?php if($row->id==$activo_usuario->id_usuario)echo "selected='selected'"?>><?php echo $row->nombres." ".$row->apellido_paterno." ".$row->apellido_materno ?></option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label class="control-label form-control-sm">Activo</label>
                                        <select name="activo" id="activo" class="form-control form-control-sm">
                                            <option value="">--Seleccionar--</option>
                                            <?php 
                                            foreach ($activo as $row){?>
                                                <option value="<?php echo $row->id ?>" <?php if($row->id==$activo_usuario->id_activo)echo "selected='selected'"?>><?php echo $row->descripcion ?></option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label form-control-sm">Fecha Entrega</label>
                                        <input id="fecha_entrega" name="fecha_entrega" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo_usuario->fecha_entrega?>" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label form-control-sm">Fecha Devolucion</label>
                                        <input id="fecha_devolucion" name="fecha_devolucion" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo_usuario->fecha_devolucion?>" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div style="margin-top:15px" class="form-group">
                        <div class="col-sm-12 controls">
                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                <a href="javascript:void(0)" onClick="fn_save_entrega_activos()" class="btn btn-sm btn-success">Guardar</a>
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
	
});


</script>
