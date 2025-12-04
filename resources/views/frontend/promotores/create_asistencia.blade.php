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

#camera-container, #preview-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

#camera {
  display: block;
  margin: 0 auto;
}

#btnTomarFoto {
  margin-top: 10px;
}

#camera-container_salida, #preview-container_salida {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

#camera_salida {
  display: block;
  margin: 0 auto;
}

#btnTomarFoto_salida {
  margin-top: 10px;
}

</style>


@stack('before-scripts')
@stack('after-scripts')

@extends('frontend.layouts.app')

@section('title', ' | ' . __('labels.frontend.afiliacion.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
    <li class="breadcrumb-item text-primary">Inicio</li>
    <li class="breadcrumb-item active">Registro de Asistencia Promotores</li>
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

	<a href="javascript:void(0)" onclick=""><i class="fa fa-bars fa-lg" style="position:absolute;right:50%;top:-24px;color:#FFFFFF"></i></a>

    <div class="card">

        <div class="card-body">

            <form class="form-horizontal" method="post" action="" id="frmAsistenciaPromotores" autocomplete="off" enctype="multipart/form-data">
				<div class="container-fluid py-3">
                <div class="row mb-3">
                    <div class="col-5 col-md-5" style="margin-top:15px">
                        <h4 class="card-title mb-0 text-primary" style="font-size:22px">
                            Asistencia Promotores
                        </h4>
                    </div>
                    <!--<div class="col-7 col-md-7 d-flex justify-content-end" style="margin-top:15px">
                      <div class="form-group">
                          <label><b>Tiempo Trabajado Diario</b></label>
                          <input type="text" id="tiempo_trabajado" class="form-control form-control-sm" readonly>
                      </div>
                  </div>

                  <input type="hidden" id="hora_ingreso" value="{{ $hora_ingreso }}">-->
                </div>
                <div class="row justify-content-center" style="margin-top:15px">

                  <input type="hidden" name="flag_ocultar" id="flag_ocultar" value="0">
                  <div class="col col-sm-12 align-self-center">
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
				            <div class="row" style="padding:20px 20px 0px 20px;">

                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                      <select name="empresa_retail_bus" id="empresa_retail_bus" class="form-control form-control-sm filtro-select">
                        <option value="">--Seleccionar Empresa--</option>
                        <?php
                        foreach ($empresa_retail as $row){?>
                          <option value="<?php echo $row->codigo ?>"><?php echo $row->denominacion ?></option>
                          <?php 
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                      <input id="fecha_inicio_bus" name="fecha_inicio_bus" on class="form-control form-control-sm filtro-input"  placeholder="Fecha">
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                      <input id="fecha_fin_bus" name="fecha_fin_bus" on class="form-control form-control-sm filtro-input"  placeholder="Fecha">
                    </div>
                      <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                      <select name="estado_bus" id="estado_bus" class="form-control form-control-sm filtro-select">
                        <option value="">Todos</option>
                        <option value="1" selected="selected">Activo</option>
                        <option value="0">Eliminado</option>
                      </select>
                    </div>
                              
                    <div class="col-12 col-md-5 d-flex justify-content-start justify-content-md-end gap-2" style="padding-right:0px">
                      <input class="btn btn-warning pull-rigth" value="Buscar" type="button" id="btnBuscar" />
                      <button type="button" class="btn btn-success" onclick="modalAsistencia()" style="margin-left:15px" >Marcar Ingreso</button>
                      <buttom class="btn btn-sm btn-secondary pull-rigth icono-botones2" type="button" id="btnDescargar" style="margin-left:10px" />
                        <i class="fas fa-download" style="font-size:18px;"></i> Descargar
                      </buttom>
                      <!--<button type="button" class="btn btn-info" onclick="modalAsistenciaSalida()" style="margin-left:15px" >Marcar Salida</button>-->
                      
                    </div>
                  </div>
				
                  <div class="card-body">
                    <div class="card-body p-2">
                      <div class="table-responsive">
                      <table id="tblAsistenciaPromotores" class="table table-hover table-sm">
                        <thead>
                        <tr style="font-size:13px">
                          <th>Id</th>
                          <th>Promotor</th>
                          <th>Tienda</th>
                          <th>Fecha</th>
                          <th>Hora Ingreso</th>
                          <th>Hora Salida</th>
                          <th>Ver Ubicaci&oacute;n Ingreso</th>
                          <th>Ver Ubicaci&oacute;n Salida</th>
                          <th>Imagen Ingreso</th>
                          <th>Imagen Salida</th>
                          <th>Salida</th>
                          <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
					
                      </div>
                    </div>
                  </div><!--table-responsive-->
                  </form>
                </div><!--card-body-->
            </div><!--card-->
        <!--</div>--><!--col-->
    <!--</div>--><!--row-->

@endsection

<div class="modal fade" id="openOverlayOpc" tabindex="-1" role="dialog" aria-labelledby="asistenciaModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="asistenciaModalLabel">Registrar Ingreso</h5>
      </div>

      <div class="modal-body">
        <form id="frmAsistenciaPromotor" method="post" action="#">
          <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="d" id="id" value="<?php echo $id?>">

          <div class="form-group">
            <label><b>Tienda</b></label>
            <select name="id_tienda" id="id_tienda" class="form-control form-control-sm">
              <option value="">--Seleccionar--</option>
              <?php foreach ($tiendas as $row){ ?>
                <option value="<?php echo $row->id ?>"><?php echo $row->denominacion ?></option>
              <?php } ?>
            </select>
          </div>
		      <div id="camera-container" style="display:none; text-align:center; margin-top:10px;">
            <video id="camera" width="250" height="250" autoplay style="border:1px solid #ccc; border-radius:5px"></video>
            <button id="btnTomarFoto" type="button" class="btn btn-primary btn-sm" onclick="capturarFoto()">📸 Tomar Foto</button>
            <!--<canvas id="canvas" width="320" height="240" style="display:none;"></canvas>

            <div style="margin-top:10px;">
              <button type="button" class="btn btn-primary btn-sm" onclick="capturarFoto()">📸 Tomar foto</button>
          </div>-->
          </div>
          <div id="preview-container" style="display:none; text-align:center; margin-top:10px;">
            <img id="preview" width="250" height="250" style="border:1px solid #ccc; border-radius:5px; object-fit:cover;"><br>
            <div class="mt-2">
                <button type="button" class="btn btn-success btn-sm" onclick="aceptarFoto()">✅ Aceptar</button>
                <button type="button" class="btn btn-warning btn-sm" onclick="retomarFoto()">↩️ Retomar</button>
            </div>
          </div>
          <canvas id="canvas" width="250" height="250" style="display:none;"></canvas>
          <input type="hidden" id="foto_base64" name="foto_base64">
          </form>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-success" onclick="fn_save_asistencia_promotor()">Guardar</button>
        <button type="button" class="btn btn-sm btn-info" data-dismiss="modal">
          <i class="fas fa-times-circle" style="font-size:18px;"></i> Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="openOverlayOpc2" tabindex="-1" role="dialog" aria-labelledby="asistenciaModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="asistenciaModalLabel">Registrar Salida</h5>
      </div>

      <div class="modal-body">
        <form id="frmAsistenciaPromotorSalida" method="post" action="#">
          <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
          
          <div class="form-group">
            <label><b>Tienda</b></label>
            <select name="id_tienda_salida" id="id_tienda_salida" class="form-control form-control-sm">
              <option value="">--Seleccionar--</option>
              <?php foreach ($tiendas as $row){ ?>
                <option value="<?php echo $row->id ?>"><?php echo $row->denominacion ?></option>
              <?php } ?>
            </select>
          </div>
		      <div id="camera-container_salida" style="display:none; text-align:center; margin-top:10px;">
            <video id="camera_salida" width="250" height="250" autoplay style="border:1px solid #ccc; border-radius:5px"></video>
            <button id="btnTomarFoto_salida" type="button" class="btn btn-primary btn-sm" onclick="capturarFotoSalida()">📸 Tomar Foto</button>
            <!--<canvas id="canvas" width="320" height="240" style="display:none;"></canvas>

            <div style="margin-top:10px;">
              <button type="button" class="btn btn-primary btn-sm" onclick="capturarFoto()">📸 Tomar foto</button>
          </div>-->
          </div>
          <div id="preview-container_salida" style="display:none; text-align:center; margin-top:10px;">
            <img id="preview_salida" width="250" height="250" style="border:1px solid #ccc; border-radius:5px; object-fit:cover;"><br>
            <div class="mt-2">
                <button type="button" class="btn btn-success btn-sm" onclick="aceptarFotoSalida()">✅ Aceptar</button>
                <button type="button" class="btn btn-warning btn-sm" onclick="retomarFotoSalida()">↩️ Retomar</button>
            </div>
          </div>
          <canvas id="canvas_salida" width="250" height="250" style="display:none;"></canvas>
          <input type="hidden" id="foto_base64_salida" name="foto_base64_salida">
          </form>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-success" onclick="fn_save_asistencia_promotor_salida()">Guardar</button>
        <button type="button" class="btn btn-sm btn-info" data-dismiss="modal">
          <i class="fas fa-times-circle" style="font-size:18px;"></i> Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

    @push('after-scripts')

	<script type="text/javascript">

	</script>

	<script src="{{ asset('js/asistencia_promotor.js') }}"></script>

	@endpush
