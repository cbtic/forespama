<!--<link rel="stylesheet" href="<?php //echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">-->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<style type="text/css">

.table td.verde{
	background:#CAE983  !important
}

body {
    background-color: #bdc3c7;
}

.table-fixed {
    width: 100%;
    background-color: #f3f3f3;
}

.table-fixed tbody {
    height: 200px;
    overflow-y: auto;
    width: 100%;
}

.table-fixed thead,
.table-fixed tbody,
.table-fixed tr,
.table-fixed td,
.table-fixed th {
    display: block;
}

.table-fixed tbody td {
    float: left;
}

.table-fixed thead tr th {
    float: left;
    background-color: #f39c12;
    border-color: #e67e22;
}

/* Begin - Overriding styles for this page */
.card-body {
    padding: 0 1.25rem !important;
}

.form-control-sm {
    line-height: 1.1 !important;
    margin: 0 !important;
}

.form-group {
    margin-bottom: 0.5rem !important;
}

.breadcrumb {
    padding: 0.2rem 2rem !important;
    margin-bottom: 0 !important;
}

.card-header {
    padding: 0.2rem 1.25rem !important;
}

.pesajeIngreso {
    line-height: 2.8;
}

.fecha_ingreso_salida {
    color: blue;
    font-size: 14px;
    font-style: italic;
	float:left
}

br {
    line-height: 30px;
}

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type=number] {
    -moz-appearance: textfield;
}

ul.ui-autocomplete {
    z-index: 1100;
}

.btn-xsm {
    font-size: 11px !important;
}

/* End - Overriding styles for this page */
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
  background-color: #ccc;
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
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
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

.no {padding-right:3px;padding-left:0px;display:block;width:20px;float:left;font-size:11px;text-align:right;padding-top:5px}
.si {padding-right:0px;padding-left:3px;display:block;width:20px;float:left;font-size:11px;text-align:left;padding-top:5px}

.flotante {
    display:inline;
        position:fixed;
        bottom:0px;
        right:0px;
		z-index:1000
}
.flotanteC {
    display:inline;
        position:fixed;
        bottom:65px;
        right:0px;
}

label.form-control-sm{
	padding-left:0px!important;
	padding-right:0px;
	padding-top:5px!important;
	height:25px!important;
	/*line-height:10px!important*/
}

.loader {
	width: 100%;
	height: 100%;
	/*height: 1500px;*/
	overflow: hidden; 
	top: 0px;
	left: 0px;
	z-index: 10000;
	text-align: center;
	position:absolute; 
	background-color: #000;
	opacity:0.6;
	filter:alpha(opacity=40);
	display:none;
}

.dataTables_processing {
	position: absolute;
	top: 50%;
	left: 50%;
	width: 500px!important;
	font-size: 1.7em;
	border: 0px;
	margin-left: -17%!important;
	text-align: center;
	background: #3c8dbc;
	color: #FFFFFF;
}

.btn-file {
  position: relative;
  overflow: hidden;
}
.btn-file input[type=file] {
  position: absolute;
  top: 0;
  right: 0;
  min-width: 100%;
  min-height: 100%;
  font-size: 100px;
  text-align: right;
  filter: alpha(opacity=0);
  opacity: 0;
  outline: none;
  background: white;
  cursor: inherit;
  display: block;
}

.wrapper { 
	/*background:#EFEFEF; */
	/*box-shadow: 1px 1px 10px #999; */
	margin: auto; 
	text-align: center; 
	position: relative;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	margin-bottom: 20px !important;
	width: 800px;
	padding-top: 5px;
}
.scrolls { 
	overflow-x: scroll;
	overflow-y: hidden;
	height: 200px;
	white-space:nowrap
} 
.imageDiv img { 
	box-shadow: 1px 1px 10px #999; 
	margin: 2px;
	max-height: 50px;
	cursor: pointer;
	display:inline-block;
	*display:inline;
	*zoom:1;
	vertical-align:top;
}


.img_ruta{
	position:relative;
	float:left
}

.delete_ruta{
	background-image:url(img/delete.png);
	top:0px;
	left:110px;
	background-size: 100%;
	position:absolute;
	display:block;
	width:30px;
	height:30px;
	cursor:pointer
}

</style>



@stack('before-scripts')
@stack('after-scripts')

@extends('frontend.layouts.app')

@section('title', ' | ' . __('labels.frontend.afiliacion.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
    <li class="breadcrumb-item text-primary">Inicio</li>
    <li class="breadcrumb-item active">Registro de Solicitud</li>
    </li>
</ol>

@endsection

<div class="loader"></div>

@section('content')
<!--
    <ol class="breadcrumb" style="padding-left:120px;margin-top:0px;background-color:#355C9D">
        <li class="breadcrumb-item text-primary">Inicio</li>
            <li class="breadcrumb-item active">Nueva Asistencia</li>
        </li>
    </ol>
    -->

<div class="justify-content-center">
    <!--<div class="container-fluid">-->
	
	<a href="javascript:void(0)" onclick="ocultar_solicitud()"><i class="fa fa-bars fa-lg" style="position:absolute;right:50%;top:-24px;color:#FFFFFF"></i></a>
	
    <div class="card">

        <div class="card-body">

            <form class="form-horizontal" method="post" action="" id="frmProyecto" autocomplete="off" enctype="multipart/form-data">
				<!--
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" style="margin-top:15px">
                        <h4 class="card-title mb-0 text-primary" style="font-size:22px">
                            Registro Solicitudes
                        </h4>
                    </div>
                </div>
				-->
                <div class="row justify-content-center" style="margin-top:15px">
					
                    <input type="hidden" name="flag_ocultar" id="flag_ocultar" value="0">
					
					<div class="col col-sm-12 align-self-center">


                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                        <!--<input type="hidden" name="estado" id="estado" value="0">-->
						
                        <div class="row" id="divSolicitud">
							
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div id="" class="row">
                                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">

                                        <div class="card">
                                            <div class="card-header">
                                                <div id="" class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <strong>
                                                            <!--@lang('labels.frontend.asistencia.box_asistencia')-->
                                                            Ingreso de Camiones
                                                        </strong>
														
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-body" style="margin-top:15px;margin-bottom:15px">
											
												<div style="clear:both"></div>
                                                <div class="row">
												
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">Id Ingreso</label>
														<input type="text" name="id_proyecto" id="id_proyecto"
															value="" readonly="readonly" placeholder="" class="form-control form-control-sm" >
													</div>
													
													<div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">Placa</label>
														<input type="text" name="nombre_py" id="nombre_py"
															value="" placeholder="" class="form-control form-control-sm" >
													</div>
																	
                                                </div>
												
												<div class="row">
												
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<div class="form-group">
															<label class="form-control-sm">Detalle</label>
															<textarea type="text" name="detalle_py" id="detalle_py" rows="2"
															placeholder="" class="form-control form-control-sm"></textarea>
														</div>
													</div>
													
												</div>
												
												<div style="clear:both"></div>
												
												<!--
												<div class="row">

													<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">Departamento</label>
														
														<?php 										
														$idDepartamento = 0;
														$idProvincia = 0;
														$idDistrito = 0;
														/*
														if($asegurado->ubigeodireccionprincipal!=""){
															$idDepartamento = substr($asegurado->ubigeodireccionprincipal, 0, 2);
															$idProvincia = substr($asegurado->ubigeodireccionprincipal, 0, 4);
															$idDistrito = $asegurado->ubigeodireccionprincipal;
														}
														*/
													?>
													<select class="form-control form-control-sm" id="txtIdUbiDepar" name="txtIdUbiDepar" onChange="obtenerProvincia();">
														<option value="">- Seleccione -</option>
														
													</select>
														
													</div>
													
													<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">Provincia</label>
														<select class="form-control form-control-sm" id="txtIdUbiProv" name="txtIdUbiProv" onChange="obtenerDistrito()">
															<option value="">- Seleccione -</option>
															<?php 
															
															?>
														</select>
													</div>
													
													<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
														<label class="form-control-sm">Distrito</label>
														<select class="form-control form-control-sm" id="ubigeodireccionprincipal" name="ubigeodireccionprincipal">
															<option value="">- Seleccione -</option>
															<?php 
																														?>
														</select>
														
														
													</div>
													
                                                </div>
												-->
												
												<div style="clear:both"></div>
												<div class="row">
												
													<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
														<label class="form-control-sm">Estado</label>
														<select name="estado_py" id="estado_py" class="form-control form-control-sm" onchange="">
															<option value="">ESTADO PROYECTO</option>
															<?php
															
															?>
														</select>
													</div>
													
													<div class="col-xl-8 text-right" style="padding-top:15px">
														
														<input class="btn btn-success btn-sm float-rigth" value="NUEVO" type="button" id="btnNuevo" style="padding-left:20px;padding-right:20px"/>
														
                                                        <input class="btn btn-sm btn-danger float-rigth" value="GUARDAR" name="guardar" type="button" id="btnGuardar" onclick="guardar_proyecto()" style="margin-left:10px" />
														
														
                                                        
                                                    </div>
													
												</div>
												

                                            </div>
                                            <!--card-body-->
                                        </div>
                                        <!--card-->
										
										
                                    </div>
									
									<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">

                                        
                                        <div class="card" style="min-height:140px">
                                            <div class="card-header">
                                                <strong>
                                                    Imagenes Referenciales
                                                </strong>
                                            </div>

                                            <div class="card-body">

												<div class="wrapper">
  													<div id="divImagenes" class="scrolls">
														
														<div class="img_ruta">
															
															<img src="" id="img_ruta_1" width="130px" height="165px" alt="" style="text-align:center;margin-top:8px;display:none;margin-left:10px" />
															<span class="delete_ruta" style="display:none" onclick="DeleteImagen(this)"></span>
														
															<input type="hidden" id="img_foto_1" name="img_foto[]" value="" />
															
														</div>
														
													</div>
												</div>
												
												<div class="row">
												
													<div class="col-lg-12">
														<div class="form-group" style="text-align:center">
															<span class="btn btn-sm btn-warning btn-file">
																Examinar <input id="image" name="image" type="file" />
															</span>
							
															<input type="hidden" id="ind_img" name="ind_img" value="1" />
															
															<input type="button" class="btn btn-sm btn-primary upload" value="Subir" style="margin-left:10px">
							
															<!--<input type="button" class="btn btn-sm btn-danger delete" value="Eliminar" style="margin-left:10px">-->
															
														</div>
													</div>
												
												</div>
												
                                                <!--table-responsive-->
												<!--
												<div class="row">
                                                    <div class="col">
                                                        <div class="form-group mb-0 float-right">
                                                            
															<input class="btn btn-danger pull-rigth" value="GUARDAR" 
                                                                name="crea" type="button" form="prestacionescrea"
                                                                id="btnGuardar" onclick="guardarCargaVehiculo()" />
                                                        </div>
                                                    </div>
                                                </div>
												
												<a class='flotante' name="guardar" id="guardar" onclick="guardarSolicitud()" href='#' ><img src='/img/btn_save.png' border="0"/></a>
												
												-->
												
												


                                            </div>
                                            <!--card-body-->
                                        </div>
                                        <!--card-->
										
										
                                    </div>
                                    <!--card-->
									
									
                                </div>


                            </div>
                        </div>

						
					<div class="row" style="padding-top:15px">

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

						<div class="card">
						
						<div class="card-header">
							<strong>Lista de Ingreso de Camiones</strong>
						</div>
						
						<div class="row col align-self-center" style="padding:10px 20px 10px 20px;">
					
							<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
								<input class="form-control form-control-sm" id="nombre_py_bus" name="nombre_py_bus" placeholder="Nombre del Proyecto">
							</div>
							
							<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
								<input class="form-control form-control-sm" id="detalle_py_bus" name="detalle_py_bus" placeholder="Detalle del Proyecto">
							</div>
							
							<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
								<select name="estado_py_bus" id="estado_py_bus" class="form-control form-control-sm" onchange="">
									<option value="">ESTADO PROYECTO</option>
									<?php
									
									?>
								</select>
							</div>
							
							<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
								<select name="estado" id="estado" class="form-control form-control-sm" onchange="">
									<option value="">ESTADO</option>
									<option value="1">ACTIVO</option>
									<option value="0">INACTIVO</option>
								</select>
							</div>
							
							<!--
							<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
								<select name="id_estado" id="id_estado" class="form-control form-control-sm" onchange="">
									<option value="0">Todos</option>
									<option value="1">PENDIENTE</option>
									<option value="2">VALORIZADO</option>
									<option value="3">APROBADO</option>
									<option value="4">RECHAZADO</option>
									<option value="5">DESEMBOLSADO</option>
								</select>
							</div>
							-->
							<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
								<input class="btn btn-warning btn-sm pull-rigth" value="Buscar" type="button" id="btnBuscar" />
							</div>
							
						</div>
						
						<div class="card-body">
							
							<div class="table-responsive">
							<!--table-hover-grid-->
							<table id="tblSolicitud" class="table table-hover table-sm">
							<thead>
							<tr style="font-size:13px">
								<th>Id</th>
								<th>Nombre Proyecto</th>
								<th>Detalle Proyecto</th>
								<th>Departamento</th>
								<th>Provincia</th>
								<th>Distrito</th>
								<th>Estado Proyecto</th>
								<th>Estado</th>
							</tr>
							</thead>
							<tbody style="font-size:13px">
							</tbody>
							</table>
							
							</div>
						</div>
						
						
						<!--
                        <div id="" class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">


                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                <br>

                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>

                        </div>
						-->
                    </div>

                </div>



        </div>
        <!--col-->

        </form>

        

    </div>
    <!--row-->
    @endsection

	<div id="openOverlayOpc" class="modal fade" role="dialog">
	  <div class="modal-dialog" >
	
		<div id="id_content_OverlayoneOpc" class="modal-content" style="padding: 0px;margin: 0px">
		
		  <div class="modal-body" style="padding: 0px;margin: 0px">
	
				<div id="diveditpregOpc"></div>
	
		  </div>
		
		</div>
	
	  </div>
		
	</div>

    @push('after-scripts')
    
	<script type="text/javascript">
	
	$(document).ready(function() {
		$(".upload").on('click', function() {
			var formData = new FormData();
			var files = $('#image')[0].files[0];
			formData.append('file',files);
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: "/proyecto/upload",
				type: 'post',
				data: formData,
				contentType: false,
				processData: false,
				success: function(response) {
				
					var ind_img = $("#ind_img").val();
					
					if (response != 0) {
						$("#img_ruta_"+ind_img).attr("src", "/img/proyecto/tmp/"+response).show();
						$(".delete_ruta").show();
						$("#img_foto_"+ind_img).val(response);
						
						ind_img++;
						
						var newRow = "";
						newRow += '<div class="img_ruta">';
						newRow += '<img src="" id="img_ruta_'+ind_img+'" width="130px" height="165px" alt="" style="text-align:center;margin-top:8px;display:none;margin-left:10px" />';
						newRow += '<span class="delete_ruta" style="display:none" onclick="DeleteImagen(this)"></span>';
						newRow += '<input type="hidden" id="img_foto_'+ind_img+'" name="img_foto[]" value="" />';
						newRow += '</div>';
						
						$("#divImagenes").append(newRow);
						$("#ind_img").val(ind_img);
						
					} else {
						alert('Formato de imagen incorrecto.');
					}
				}
			});
			return false;
		});
	
		$(".delete").on('click', function() {
			$("#img_ruta0").attr("src", "/dist/img/profile-icon.png");
			$("#img_foto0").val("");
		});
	
	});
	
	</script>
	
	<script src="{{ asset('js/proyecto/create.js') }}"></script>
	
	@endpush