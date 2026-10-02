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
	max-width:65%!important
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

    cargarDetalle();

});
</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
     $('#fecha_inicio').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });
});

function limpiar(){
	$('#id').val("0");
	$('#id_tipo_documento').val("");
	$('#denominacion').val("");
	$('#img_foto').val("");
}

function cargarDetalle(){

    var id = $("#id").val();
    const tbody = $('#divComisionAliadoDetalle');

    tbody.empty();
    
    $.ajax({
        url: "/aliados_pama_comisiones/cargar_detalle/"+id,
        type: "GET",
        success: function (result) {

            let n = 1;

            let html = "";
            result.detalle_comision_aliado_pama.forEach(detalle_comision_aliado_pama => {

                let total = parseFloat(detalle_comision_aliado_pama.total || 0);
                let total_pendiente_comision = parseFloat(detalle_comision_aliado_pama.total_pendiente_comision || 0);
                let monto_pagado_comision = parseFloat(detalle_comision_aliado_pama.monto_pagado_comision || 0);
                let porcentaje = parseFloat(detalle_comision_aliado_pama.porcentaje_comision || 0);

                let total_comision = total * porcentaje / 100;

                html +=`
                <tr>
                    <td>${n}</td>
                    <td><label id="id_comprobante${n}" class="id_comprobante"> ${detalle_comision_aliado_pama.id} </label></td>
                    <td><label id="comprobante${n}" class="comprobante">${detalle_comision_aliado_pama.serie +'-'+detalle_comision_aliado_pama.numero} </label></td>
                    
                    <td><label id="fecha_comprobante${n}" class="fecha_comprobante"> ${detalle_comision_aliado_pama.fecha} </label></td>
                    <td><label id="destinatario${n}" class="destinatario"> ${detalle_comision_aliado_pama.destinatario} </label></td>
                    <td><label id="numero_documento${n}" class="numero_documento"> ${detalle_comision_aliado_pama.cod_tributario} </label></td>
                    <td><label id="total${n}" class="total"> ${total.toFixed(2)} </label></td>
                    <td><label id="porcentaje_comision${n}" class="porcentaje_comision"> ${porcentaje.toFixed(2)} </label></td>
                    <td><label id="total_comision${n}" class="total_comision"> ${total_comision.toFixed(2)} </label></td>
                    <td><label id="monto_pagado_comision${n}" class="monto_pagado_comision"> ${monto_pagado_comision.toFixed(2)} </label></td>
                    <td><label id="total_pendiente_comision${n}" class="total_pendiente_comision"> ${total_pendiente_comision.toFixed(2)} </label></td>
                    <td><label id="estado_pago_comision${n}" class="estado_pago_comision"> ${detalle_comision_aliado_pama.estado_solicitud || ''} </label></td>
                </tr>
                `;

            });
            
            tbody.append(html);
            
        }
    });
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
                
                <div class="card-header" style="padding:5px!important;padding-left:20px!important">
                    Detalle Comisiones
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmDetalleComisionAliadoPama" name="frmDetalleComisionAliadoPama">

                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                            
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                        </div>
                        <div class="card-body" style="padding-right: 0px !important; padding-left: 0px !important;">
                            <div class="table-responsive" style="overflow-y: auto; max-height: 350px;">
                                <table id="tblComisionAliadoDetalle" class="table table-hover table-sm">
                                    <thead>
                                    <tr style="font-size:12px">
                                        <th>#</th>
                                        <th>Id Comprobante</th>
                                        <th>Comprobante</th>
                                        <th>Fecha Comprobante</th>
                                        <th>Destinatario</th>
                                        <th>DNI/RUC</th>
                                        <th>Total</th>
                                        <th>Porcentaje Comisi&oacute;n</th>
                                        <th>Total Comisi&oacute;n</th>
                                        <th>Comisi&oacute;n Pagada</th>
                                        <th>Comisi&oacute;n Pendiente</th>
                                        <th>Estado Solicitud</th>
                                    </tr>
                                    </thead>
                                    <tbody id="divComisionAliadoDetalle" style="font-size:13px">
                                    </tbody>
                                </table>
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
