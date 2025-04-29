<!--<link rel="stylesheet" href="<?php //echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">-->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

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
    <li class="breadcrumb-item active">Reporte Ventas</li>
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

    <div class="card">

        <div class="card-body">

            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0 text-primary">
                        Reporte Ventas<!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div><!--col-->
            </div>

            <div class="row justify-content-center">

                <div class="col col-sm-12 align-self-center">

                    <div class="card">
                        <div class="card-header">
                            <strong>
                                <!--@lang('labels.frontend.lista_afiliacion.box_title')-->
                                Reporte Ventas por Año
                            </strong>
                        </div><!--card-header-->

                        <form class="form-horizontal" method="post" action="" id="frmReporteVentas" autocomplete="off">


                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                            <div class="row" style="padding:20px 20px 0px 20px;">

                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <select name="anio_bus" id="anio_bus" class="form-control form-control-sm" onChange="">
                                        <option value="0">--Selecionar Año--</option>
                                        <?php
                                        foreach ($anios as $anios) { ?>
                                            <option value="<?php echo $anios ?>"><?php echo $anios ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <select name="empresa_bus" id="empresa_bus" class="form-control form-control-sm" onChange="">
                                        <option value="0">--Selecionar Empresa--</option>
                                        <?php
                                        foreach ($empresas as $row) { ?>
                                            <option value="<?php echo $row->id ?>"><?php echo $row->razon_social ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>   

                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px">
                                    <input class="btn btn-warning pull-rigth" value="Buscar" type="button" id="btnBuscar" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">

                                    <div class="card-body">
                                        <div>
                                            <strong>
                                                Facturado
                                            </strong>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="tblVentasFacturado" class="table table-hover table-sm">
                                                <thead>
                                                    <tr style="font-size:13px">
                                                        <th>Enero</th>
                                                        <th>Febrero</th>
                                                        <th>Marzo</th>
                                                        <th>Abril</th>
                                                        <th>Mayo</th>
                                                        <th>Junio</th>
                                                        <th>Julio</th>
                                                        <th>Agosto</th>
                                                        <th>Setiembre</th>
                                                        <th>Octubre</th>
                                                        <th>Noviembre</th>
                                                        <th>Diciembre</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="font-size:13px">
                                                    <tr style="font-size:13px">
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div>
                                            <strong>
                                                Pagado
                                            </strong>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="tblVentasPagado" class="table table-hover table-sm">
                                                <thead>
                                                    <tr style="font-size:13px">
                                                        <th>Enero</th>
                                                        <th>Febrero</th>
                                                        <th>Marzo</th>
                                                        <th>Abril</th>
                                                        <th>Mayo</th>
                                                        <th>Junio</th>
                                                        <th>Julio</th>
                                                        <th>Agosto</th>
                                                        <th>Setiembre</th>
                                                        <th>Octubre</th>
                                                        <th>Noviembre</th>
                                                        <th>Diciembre</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="font-size:13px">
                                                    <tr style="font-size:13px">
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div>
                                            <strong>
                                                Retenciones
                                            </strong>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="tblVentasRetencion" class="table table-hover table-sm">
                                                <thead>
                                                    <tr style="font-size:13px">
                                                        <th>Enero</th>
                                                        <th>Febrero</th>
                                                        <th>Marzo</th>
                                                        <th>Abril</th>
                                                        <th>Mayo</th>
                                                        <th>Junio</th>
                                                        <th>Julio</th>
                                                        <th>Agosto</th>
                                                        <th>Setiembre</th>
                                                        <th>Octubre</th>
                                                        <th>Noviembre</th>
                                                        <th>Diciembre</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="font-size:13px">
                                                    <tr style="font-size:13px">
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <strong>
                                                Cobros
                                            </strong>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="tblVentasCobros" class="table table-hover table-sm">
                                                <thead>
                                                    <tr style="font-size:13px">
                                                        <th>Enero</th>
                                                        <th>Febrero</th>
                                                        <th>Marzo</th>
                                                        <th>Abril</th>
                                                        <th>Mayo</th>
                                                        <th>Junio</th>
                                                        <th>Julio</th>
                                                        <th>Agosto</th>
                                                        <th>Setiembre</th>
                                                        <th>Octubre</th>
                                                        <th>Noviembre</th>
                                                        <th>Diciembre</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="font-size:13px">
                                                    <tr style="font-size:13px">
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                        <td class="text-left">0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <canvas id="ventasChart" width="100%" height="50"></canvas><br>
                                    <div id="ventasPieChart" style="height: 400px; margin-top: 30px;"></div>
                                </div>
                            </div>
                            <!--card-body-->
                    </div><!--card-->
                    <!--</div>--><!--col-->
                    <!--</div>--><!--row-->

                    <div id="openOverlayOpc" class="modal fade" role="dialog">
                        <div class="modal-dialog" >
                            <div id="id_content_OverlayoneOpc" class="modal-content" style="padding: 0px;margin: 0px">
                                <div class="modal-body" style="padding: 0px;margin: 0px">
                                    <div id="diveditpregOpc"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endsection

                    @push('after-scripts')

                    <script src="{{ asset('js/ReporteVentas.js') }}"></script>
                    @endpush

<script>
    function validarDecimal(input) {
        // Expresión regular para permitir solo números y un punto decimal
        var regex = /^[0-9]*\.?[0-9]*$/;
        
        // Verificar si el valor ingresado coincide con la expresión regular
        if (!regex.test(input.value)) {
            // Si no coincide, eliminar el último carácter ingresado
            input.value = input.value.slice(0, -1);
        }
    }
</script>