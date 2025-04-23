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
    <li class="breadcrumb-item active">Consulta de Comprobantes</li>
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
                        Consultar Facturas<!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div><!--col-->
            </div>

            <div class="row justify-content-center">

                <div class="col col-sm-12 align-self-center">

                    <div class="card">
                        <div class="card-header">
                            <strong>
                                <!--@lang('labels.frontend.lista_afiliacion.box_title')-->
                                Lista de Facturaci&oacute;n
                            </strong>
                        </div><!--card-header-->

                        <form class="form-horizontal" method="post" action="{{ route('frontend.comprobante.send')}}" id="frmAfiliacion" autocomplete="off">


                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                            <div class="row" style="padding:20px 20px 0px 20px;">

                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-control-sm">Fecha inicio</label>
                                        <input class="form-control form-control-sm" id="fecha_ini" name="fecha_ini" value="<?php echo date("d-m-Y") ?>" placeholder="Fecha Inicio">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-control-sm">Fecha Fin</label>
                                        <input class="form-control form-control-sm" id="fecha_fin" name="fecha_fin" value="" placeholder="Fecha fin">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-control-sm">Tipo Documento</label>
                                        <select name="tipo_documento" id="tipo_documento" class="form-control form-control-sm" onchange="validaTipoDocumento()">
                                            <option value="FT">
                                                <?php echo "Factura" ?></option>
                                            <option value="BV">
                                                <?php echo "Boleta" ?></option>
                                            <option value="NC">
                                                <?php echo "Nota de Credito" ?></option>
                                            <option value="ND">
                                                <?php echo "Nota de Debito" ?></option>
                                            <option value="TK">
                                                <?php echo "Ticket" ?></option>
                                            <option selected="selected" value="">
                                                <?php echo "Todos" ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-control-sm">Serie</label>
                                        <input type="text" name="serie" id="serie" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-control-sm">Numero</label>
                                        <input type="text" name="numero" id="numero" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-control-sm">Razon Social</label>
                                        <input type="text" name="razon_social" id="razon_social" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-control-sm">Estado de Pago</label>
                                        <select name="estado_pago" id="estado_pago" class="form-control form-control-sm" onchange="validaTipoDocumento()">
                                            <option value="C">
                                                <?php echo "Cancelado" ?></option>
                                            <option value="P">
                                                <?php echo "Pendiente" ?></option>
                                            <option selected="selected" value="">
                                                <?php echo "Todos" ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-control-sm">Anulado</label>
                                        <select name="anulado" id="anulado" class="form-control form-control-sm" onchange="validaTipoDocumento()">
                                            <option value="S">
                                                <?php echo "Si" ?></option>
                                            <option value="N">
                                                <?php echo "No" ?></option>
                                            <option selected="selected" value="">
                                                <?php echo "Todos" ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <label class="form-group">Caja</label>
                                    <select name="id_caja" id="id_caja" class="form-control form-control-sm" onChange="">
                                        <option value="">--Selecionar--</option>
                                        <?php
                                        foreach ($caja as $row) { ?>
                                            <option value="<?php echo $row->codigo ?>"><?php echo $row->denominacion ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <label class="form-group">Usuario</label>
                                    <select name="id_usuario" id="id_usuario" class="form-control form-control-sm" onChange="">
                                        <option value="">--Selecionar--</option>
                                        <?php
                                        foreach ($usuario_caja as $row) { ?>
                                            <option value="<?php echo $row->id ?>"><?php echo $row->denominacion ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    <label class="form-group">Forma de pago</label>
                                    <select name="id_formapago" id="id_formapago" class="form-control form-control-sm" onChange="">
                                        <option value="">--Selecionar--</option>
                                        <?php
                                        foreach ($formapago as $row) { ?>
                                            <option value="<?php echo $row->codigo ?>"><?php echo $row->denominacion ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    <label class="form-group">Medio de pago</label>
                                    <select name="id_mediopago" id="id_mediopago" class="form-control form-control-sm" onChange="">
                                        <option value="">--Selecionar--</option>
                                        <?php
                                        foreach ($medio_pago as $row) { ?>
                                            <option value="<?php echo $row->codigo ?>"><?php echo $row->denominacion ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>


                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-control-sm">Total</label>
                                        <input type="text" name="total_b" id="total_b" value="" oninput="validarDecimal(this)" placeholder="" class="form-control form-control-sm">
                                    </div>
                                </div>
 

                                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12" style="padding-top:30px">
                                    <input class="btn btn-warning pull-rigth" value="Buscar" type="button" id="btnBuscar" />
                                </div>
<!--
                                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12" style="padding-top:30px">
                                    <input class="btn btn-success pull-rigth" value="Nuevo" type="button" id="btnNuevo1" data-toggle="modal" data-target="#exampleModal2" style="margin-left:15px" />

                                </div>
                                    -->
                                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12" style="padding-top:30px">
                                    <input class="btn btn-success pull-rigth" value="Excel" type="button" id="btnExcel" onclick="reporteFactura()" />
                                </div>
                                <!--
					@hasanyrole('contabilidad')
					@else
					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12" style="padding-top:30px">
						<input class="btn btn-success pull-rigth" value="Excel" type="button" id="btnExcel" onclick="reporteFactura()"/>
					</div>
                    @endhasanyrole
-->
                            </div>

                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="tblFactura" class="table table-hover table-sm">
                                        <thead>
                                            <tr style="font-size:13px">
                                                <th>Serie</th>
                                                <th>Nro.</th>
                                                <th>Tipo</th>
                                                <th>Fecha</th>
                                                <th>Ruc</th>
                                                <th>Razón Social</th>
                                                <th class="text-right">SubTotal</th>
                                                <th class="text-right">IGV</th>
                                                <th class="text-right">Total</th>
                                                <th>Estado</th>
                                                <th>Anulado</th>
                                                <th>Caja</th>
                                                <th>Usuario</th>
                                                <th>Forma Pago</th>
                                                <th class="text-right">Credito</th>
                                                <th>Sunat</th>
                                                <th class="text-left">Credito</th>
                                                <th class="text-left">Factura</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size:13px">

                                        </tbody>
                                    </table>
                                </div>
                            </div>



                            <!--card-body-->
                    </div><!--card-->
                    <!--</div>--><!--col-->
                    <!--</div>--><!--row-->

                    <!-- Modal -->
<!--                     
                    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel2">Seleccione Tipo de Documento</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="card-body">
                                            <div id="" class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                                    -->
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

                    <script src="{{ asset('js/FacturaLista.js') }}"></script>
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