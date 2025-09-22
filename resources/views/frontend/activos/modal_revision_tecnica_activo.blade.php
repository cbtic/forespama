<title>Sistema Forespama</title>

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

/*********************************************************/
.switch {
  position: relative;
  display: inline-block;
  width: 42px;
  height: 24px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #337ab7;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 0px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #4cae4c;
}

input:focus + .slider {
  box-shadow: 0 0 1px #4cae4c;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.no {padding-right:3px;padding-left:0px;display:block;width:100px;float:left;font-size:14px;text-align:right;padding-top:5px}
.si {padding-right:0px;padding-left:3px;display:block;width:100px;float:left;font-size:14px;text-align:left;padding-top:5px}

</style>

<!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>-->
<!--<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>-->
<!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>-->


<!--<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>-->


<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
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
<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
-->

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
	
	$('#fecha_emision').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

	$('#fecha_vencimiento').datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
        language: 'es'
    });

});
</script>

<script type="text/javascript">

function fn_save_revision_tecnica(){
    
	var msg = "";
	var _token = $('#_token').val();
	var id = $('#id').val();
	var id_activo = $('#id_activo').val();
	var numero_certificado = $('#numero_certificado').val();
	var fecha_emision = $('#fecha_emision').val();
	var fecha_vencimiento = $('#fecha_vencimiento').val();
	var resultado_revision_tecnica = $('#resultado_revision_tecnica').val();
	var estado_revision_tecnica = $('#estado_revision_tecnica').val();
		
	if(numero_certificado == "")msg+="Debe Ingresar el Numero de Certificado <br>";
	if(fecha_emision == "")msg += "Debe Ingresar la Fecha de Emision <br>";
	if(fecha_vencimiento == "")msg+="Debe Ingresar la Fecha de Vencimiento <br>";
	if(resultado_revision_tecnica == "")msg+="Debe Seleccionar el Resultado de la Revision Tecnica <br>";
	if(estado_revision_tecnica == "")msg+="Debe Seleccionar el Estado de la Revision Tecnica <br>";
	
    if(msg!=""){
        bootbox.alert(msg); 
        return false;
    }
	
    $.ajax({
		url: "/activos/send_revision_tecnica_activo",
		type: "POST",
		data : {_token:_token,id:id,
			id_activo:id_activo,numero_certificado:numero_certificado,fecha_emision:fecha_emision,fecha_vencimiento:fecha_vencimiento,
			resultado_revision_tecnica:resultado_revision_tecnica,estado_revision_tecnica:estado_revision_tecnica},
		success: function (result) {
			
			$('#openOverlayOpc').modal('hide');
			window.location.reload();
			
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
				Registro Revisi&oacute;n T&eacute;cnica
			</div>
			
            <div class="card-body">

			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
					
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
					
					<div class="row" style="padding-left:10px">
						
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label form-control-sm">N&uacute;mero Certificado</label>
								<input id="numero_certificado" name="numero_certificado" on class="form-control form-control-sm mayusculas"  value="<?php echo $revision_tecnica_activo->numero_certificado?>" type="text">
							</div>
						</div>
					</div>

					<div class="row" style="padding-left:10px">
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label form-control-sm">Fecha Revisi&oacute;n</label>
								<input id="fecha_emision" name="fecha_emision" on class="form-control form-control-sm mayusculas"  value="<?php echo $revision_tecnica_activo->fecha_emision?>" type="text" placeholder="YYYY-MM-DD">
							</div>
						</div>

						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label form-control-sm">Fecha Pr&oacute;xima Revisi&oacute;n</label>
								<input id="fecha_vencimiento" name="fecha_vencimiento" on class="form-control form-control-sm mayusculas"  value="<?php echo $revision_tecnica_activo->fecha_vencimiento?>" type="text" placeholder="YYYY-MM-DD">
							</div>
						</div>						

						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label form-control-sm">Resultado Revisi&oacute;n T&eacute;cnica</label>
								<select name="resultado_revision_tecnica" id="resultado_revision_tecnica" class="form-control form-control-sm">
									<option value="">--Seleccionar--</option>
									<?php 
									foreach ($resultado_revision_tecnica as $row){?>
										<option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$revision_tecnica_activo->id_resultado_revision)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
										<?php 
									}
									?>
								</select>
							</div>
						</div>

						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label form-control-sm">Estado Revisi&oacute;n T&eacute;cnica</label>
								<select name="estado_revision_tecnica" id="estado_revision_tecnica" class="form-control form-control-sm">
									<option value="">--Seleccionar--</option>
									<?php 
									foreach ($estado_revision_tecnica as $row){?>
										<option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$revision_tecnica_activo->estado_revision)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
										<?php 
									}
									?>
								</select>
							</div>
						</div>
					</div>
										
					<div style="margin-top:15px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
								<a href="javascript:void(0)" onClick="fn_save_revision_tecnica()" class="btn btn-sm btn-success">Guardar</a>
							</div>
												
						</div>
					</div> 
              </div>
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

