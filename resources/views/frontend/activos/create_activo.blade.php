<!--<link rel="stylesheet" href="<?php //echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">-->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<style type="text/css">

#tblProductos tbody tr{
		font-size:13px
	}

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
    <li class="breadcrumb-item active">Registro de Activos</li>
    </li>
</ol>

@endsection

<div class="loader"></div>

@section('content')

     <div class="justify-content-center">
        
        <div class="card">

        <div class="card-body">

            <form class="form-horizontal" method="post" action="" id="frmNuevoActivo" autocomplete="off">

            <div class="row justify-content-center" style="margin-top:15px">

                <input type="hidden" name="flag_ocultar" id="flag_ocultar" value="0">
					
				<div class="col col-sm-12 align-self-center">

                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="id_activo" id="id_activo" value="<?php echo $id?>">
				
                <div class="row" id="divNuevoActivo">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div id="" class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <strong>
                                                    Datos Activo
                                                </strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body" style="margin-top:15px;margin-bottom:15px">

                                        <div style="clear:both"></div>
                                            <div class="row">
                                                <div class="col-lg-11 col-md-12 col-sm-12 col-xs-12">
													<div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="row">
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    Tipo <span style="color:red;">*</span>
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                                    <select name="tipo_activo" id="tipo_activo" class="form-control form-control-sm" onchange="obtenerDatosActivo();obtenerSubTipoActivo();obtenerMarca()">
                                                                        <option value="">--Seleccionar--</option>
                                                                        <?php 
                                                                        foreach ($tipo_activo as $row){?>
                                                                            <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$activo->id_tipo_activo)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                                                            <?php 
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    Familia <span style="color:red;">*</span>
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                                    <select name="familia" id="familia" class="form-control form-control-sm" onchange="obtenerSubFamiliaBus()">
                                                                        <option value="">--Seleccionar--</option>
                                                                        <?php 
                                                                        foreach ($familia as $row){?>
                                                                            <option value="<?php echo $row->id ?>" <?php if($row->id==$activo->id_familia)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                                                            <?php 
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    Sub Familia <span style="color:red;">*</span>
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                                    <select name="sub_familia" id="sub_familia" class="form-control form-control-sm">
                                                                        <option value="">--Seleccionar--</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    C&oacute;digo
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                                    <input id="codigo" name="codigo" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->codigo_activo?>" type="text" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    SubTipo Activo <span style="color:red;">*</span>
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                                    <select name="sub_tipo_activo" id="sub_tipo_activo" class="form-control form-control-sm">
                                                                        <option value="">--Seleccionar--</option>
                                                                        <?php 
                                                                        /*foreach ($sub_tipo_activo as $row){?>
                                                                            <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$activo->id_sub_tipo_activo)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                                                            <?php 
                                                                        }*/
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    Descripci&oacute;n <span style="color:red;">*</span>
                                                                </div>
                                                                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                                                                    <input id="descripcion" name="descripcion" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->descripcion?>" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12" id="label_placa_maquinaria">
                                                                    Placa <span style="color:red;">*</span>
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12" id="opcion_placa_maquinaria">
                                                                    <input id="placa" name="placa" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->placa?>" type="text" placeholder="ABC-123">
                                                                </div>
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    Modelo
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                                    <input id="modelo" name="modelo" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->modelo?>" type="text">
                                                                </div>
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    Serie
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                                    <input id="serie" name="serie" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->serie?>" type="text">
                                                                </div>
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    Marca
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                                    <select name="marca" id="marca" class="form-control form-control-sm">
                                                                        <option value="">--Seleccionar--</option>
                                                                        <?php 
                                                                        foreach ($marca as $row){?>
                                                                            <option value="<?php echo $row->id ?>" <?php if($row->id==$activo->id_marca)echo "selected='selected'"?>><?php echo $row->denominiacion ?></option>
                                                                            <?php 
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12" id="label_tipo_combustible_maquinaria">
                                                                    Tipo Combustible <span style="color:red;">*</span>
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12" id="opcion_tipo_combustible_maquinaria">
                                                                    <select name="tipo_combustible" id="tipo_combustible" class="form-control form-control-sm">
                                                                        <option value="">--Seleccionar--</option>
                                                                        <?php 
                                                                        foreach ($tipo_combustible as $row){?>
                                                                            <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$activo->id_tipo_combustible)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                                                            <?php 
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12" id="label_dimension_maquinaria">
                                                                    Dimesiones
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12" id="opcion_dimension_maquinaria">
                                                                    <input id="dimension" name="dimension" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->dimensiones?>" type="text">
                                                                </div>
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    Valor Libros
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                                    <input id="valor_libros" name="valor_libros" on class="form-control form-control-sm solo-decimal" <?= ($activo->valor_libros !== null && $activo->valor_libros !== '') ? 'value="' . number_format($activo->valor_libros, 2) . '"' : '' ?> type="text" placeholder="0.00">
                                                                </div>
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    Valor Comercial
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                                    <input id="valor_comercial" name="valor_comercial" on class="form-control form-control-sm solo-decimal" <?= ($activo->valor_comercial !== null && $activo->valor_comercial !== '') ? 'value="' . number_format($activo->valor_comercial, 2) . '"' : '' ?> type="text" placeholder="0.00">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    Color
                                                                </div>
                                                                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                                                                    <input id="color" name="color" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->color?>" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    Departamento <span style="color:red;">*</span>
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                                    <select name="departamento" id="departamento" onchange="obtenerProvincia()" class="form-control form-control-sm">
                                                                        <?php if($id>0){ ?> 
                                                                        <option value="">--Seleccionar--</option>
                                                                        <?php
                                                                        foreach ($departamento as $row) {?>
                                                                        <option value="<?php echo $row->id_departamento?>" <?php if($row->id_departamento==substr($activo->id_ubigeo,0,2))echo "selected='selected'"?>><?php echo $row->desc_ubigeo ?></option>
                                                                        <?php 
                                                                        }
                                                                        }else{?>
                                                                        <option value="">--Seleccionar--</option>
                                                                            <?php
                                                                            foreach ($departamento as $row) {
                                                                            ?>
                                                                            <option value="<?php echo $row->id_departamento?>"><?php echo $row->desc_ubigeo ?></option>
                                                                            <?php 
                                                                                
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    Provincia <span style="color:red;">*</span>
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                                    <select name="provincia" id="provincia" class="form-control form-control-sm" onchange="obtenerDistrito()">
                                                                        <option value="">--Seleccionar--</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    Distrito <span style="color:red;">*</span>
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                                    <select name="distrito" id="distrito" class="form-control form-control-sm" onchange="">
                                                                        <option value="">--Seleccionar--</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    Direcci&oacute;n
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                                    <input id="direccion" name="direccion" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->direccion?>" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="row" id="div_titulo_maquinaria">
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    Titulo
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                                    <input id="titulo" name="titulo" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->titulo?>" type="text">
                                                                </div>
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    Partida Registral
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                                    <input id="partida_registral" name="partida_registral" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->partida_registral?>" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="row" id="div_partida_maquinaria">
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    Partida Circulaci&oacute;n
                                                                </div>
                                                                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                                                                    <input id="partida_circulacion" name="partida_circulacion" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->partida_circulacion?>" type="text">
                                                                </div>
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    Vigencia Circulaci&oacute;n
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                                    <input id="vigencia_circulacion" name="vigencia_circulacion" on class="form-control form-control-sm mayusculas"  value="<?php echo $activo->vigencia_circulacion?>" type="text" placeholder="YYYY-MM-DD">
                                                                </div>
                                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                                    Estado de Activo
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                                    <select name="estado_activo" id="estado_activo" class="form-control form-control-sm">
                                                                        <option value="">--Seleccionar--</option>
                                                                        <?php 
                                                                        foreach ($estado_activos as $row){?>
                                                                            <option value="<?php echo $row->codigo ?>" <?php if($row->codigo==$activo->id_estado_activo)echo "selected='selected'"?>><?php echo $row->denominacion ?></option>
                                                                            <?php 
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                
                                                            </div>
                                                            <span style="color:red;">* Datos Obligatorios</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <span class="btn btn-sm btn-warning btn-file">
                                                                Examinar <input id="image" name="image" type="file" />
                                                            </span>
                                                            <input type="button" class="btn btn-sm btn-primary upload" value="Subir" style="margin-left:10px">
                                                            
                                                            <?php
                                                                $url_foto = "/img/logo_forestalpama.jpg";
                                                                if ($activo->ruta_imagen != "") $url_foto = "/img/activos/" . $id . "/" . $activo->ruta_imagen;

                                                                $foto = "";
                                                                if ($activo->ruta_imagen != "") $foto = $activo->ruta_imagen;
                                                            ?>
                                                            <!--<img src="<?php //echo $url_foto ?>" id="img_ruta" width="240px" height="150px" alt="" style="margin-top:10px" />-->
                                                            <a href="<?php echo "/img/activos/".$activo->id."/".$activo->ruta_imagen ?>" target="_blank" class="btn btn-sm btn-secondary"><img src="<?php echo $url_foto?>" id="img_ruta" width="80" height="50" alt="" style="margin-top:10px" /></a>
                                                            <input type="hidden" id="img_foto" name="img_foto" value="" />
                                                        </div>
                                                        <input class="btn btn-sm btn-success float-rigth" value="GUARDAR" name="guardar" type="button" id="btnGuardar" style="padding-left:25px;padding-right:25px;margin-left:10px;margin-top:15px" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if($id>0 && $activo->id_tipo_activo !=3){?>

                    <div style="clear:both;padding-top:15px"></div>
                        <div class="card">
                            <nav>
                                <div class="nav nav-pills" id="nav-tab" role="tablist">
                                    <a
                                        class="nav-link active"
                                        id="soat-tab"
                                        data-toggle="pill"
                                        href="#soat"
                                        role="tab"
                                        aria-controls="soat"
                                        aria-selected="true">SOAT</a>
                                    
                                    <a
                                        class="nav-link"
                                        id="revision_tecnica-tab"
                                        data-toggle="pill"
                                        href="#revision_tecnica"
                                        role="tab"
                                        aria-controls="revision_tecnica"
                                        aria-selected="false">Revisi&oacute;n T&eacute;cnica</a>
                                    
                                    <a
                                        class="nav-link"
                                        id="control_mantenimiento-tab"
                                        data-toggle="pill"
                                        href="#control_mantenimiento"
                                        role="tab"
                                        aria-controls="control_mantenimiento"
                                        aria-selected="false">Control de Mantenimientos</a>
                                
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabsContent">

                                <div class="tab-pane fade pt-3 show active" id="soat" role="tabpanel" aria-labelledby="soat-tab" style="padding-top:0px!important">
                            
                                    <div class="row" style="padding-top:0px">

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        
                                            <div class="card">
                                                <div class="card-header">
                                                    <div id="" class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <strong>
                                                                Datos del SOAT
                                                            </strong>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-body" style="margin-top:15px;margin-bottom:15px">
                                                    
                                                    <input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoSOAT" style="width:120px;margin-right:15px"/>
                                                    
                                                    <div style="clear:both"></div>
                                            
                                                    <div class="table-responsive">
                                                        <table id="tblDatosSoat" class="table table-hover table-sm">
                                                            <thead>
                                                                <tr style="font-size:13px">
                                                                    <th>N&uacute;mero de Poliza</th>
                                                                    <th>Fecha Emisi&oacute;n</th>
                                                                    <th>Fecha Vencimiento</th>
                                                                    <th>Estado SOAT</th>
                                                                    <th>Opciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody style="font-size:13px">
                                                                <?php foreach($soat_activo as $row){?>
                                                                <tr>
                                                                    <th><?php echo $row->numero_poliza?></th>
                                                                    <th><?php echo $row->fecha_emision?></th>
                                                                    <th><?php echo $row->fecha_vencimiento?></th>
                                                                    <th><?php echo $row->estado_soat?></th>
                                                                    <th>
                                                                        <div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
                                                                            <button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalSoat(<?php echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
                                                                            <a href="javascript:void(0)" onclick="eliminarSoat(<?php echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
                                                                        </div>
                                                                    </th>
                                                                </tr>						
                                                                <?php }?>
                                                            </tbody>							
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade pt-3" id="revision_tecnica" role="tabpanel" aria-labelledby="revision_tecnica-tab">
                                        
                                    <div class="row" style="padding-top:0px">

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            
                                            <div class="card">
                                                <div class="card-header">
                                                    <div id="" class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <strong>
                                                                Datos de Revisi&oacute;n T&eacute;cnica
                                                            </strong>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-body" style="margin-top:15px;margin-bottom:15px">
                                                    
                                                    <input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoRevisionTecnica" style="width:120px;margin-right:15px"/>
                                                    
                                                    <div style="clear:both"></div>
                                            
                                                    <div class="table-responsive">
                                                        <table id="tblRevisionTecnica" class="table table-hover table-sm">
                                                            <thead>
                                                                <tr style="font-size:13px">
                                                                    <th>N&uacute;mero Certificado</th>
                                                                    <th>Fecha Emisi&oacute;n</th>
                                                                    <th>Fecha Vencimiento</th>
                                                                    <th>Resultado Revisi&oacute;n</th>
                                                                    <th>Estado Revisi&oacute;n</th>
                                                                    <th>Opciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody style="font-size:13px">
                                                                <?php foreach($revision_tecnica_activo as $row){?>
                                                                <tr>
                                                                    <th><?php echo $row->numero_certificado?></th>
                                                                    <th><?php echo $row->fecha_emision?></th>
                                                                    <th><?php echo $row->fecha_vencimiento?></th>
                                                                    <th><?php echo $row->resultado_revision?></th>
                                                                    <th><?php echo $row->estado_revision?></th>
                                                                    <th>
                                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
                                                                    <button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalRevisionTecnica(<?php echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
                                                                    <a href="javascript:void(0)" onclick="eliminarRevisionTecnica(<?php echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
                                                                    </div>
                                                                    </th>
                                                                </tr>														
                                                                <?php }?>
                                                            </tbody>							
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade pt-3" id="control_mantenimiento" role="tabpanel" aria-labelledby="control_mantenimiento-tab">
                                        
                                        <div class="row" style="padding-top:0px">

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div id="" class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <strong>
                                                                    Datos de Mantenimientos
                                                                </strong>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card-body" style="margin-top:15px;margin-bottom:15px">
                                                        
                                                        <input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoMantenimiento" style="width:120px;margin-right:15px"/>
                                                        
                                                        <div style="clear:both"></div>
                                                        <div class="table-responsive">
                                                            <table id="tblMantenimiento" class="table table-hover table-sm">
                                                                <thead>
                                                                    <tr style="font-size:13px">
                                                                        <th>Fecha Mantenimiento</th>
                                                                        <th>Kilometraje</th>
                                                                        <th>Pr&oacute;ximo Kilometraje</th>
                                                                        <th>Tipo Mantenimiento</th>
                                                                        <th>Costo</th>
                                                                        <th>Fecha Pr&oacute;ximo Mantenimiento</th>
                                                                        <th>Observaci&oacute;n</th>
                                                                        <th>Opciones</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody style="font-size:13px">
                                                                    <?php foreach($control_mantenimiento_activo as $row){?>
                                                                    <tr>
                                                                        <th><?php echo $row->fecha_mantenimiento?></th>
                                                                        <th><?php echo $row->kilometraje?></th>
                                                                        <th><?php echo $row->proximo_kilometraje?></th>
                                                                        <th><?php echo $row->tipo_mantenimiento?></th>
                                                                        <th><?php echo $row->costo?></th>
                                                                        <th><?php echo $row->fecha_proximo_mantenimiento?></th>
                                                                        <th><?php echo $row->observacion?></th>
                                                                        <th>
                                                                        <div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
                                                                        <button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalMantenimiento(<?php echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
                                                                        <a href="javascript:void(0)" onclick="eliminarMantenimiento(<?php echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
                                                                        </div>
                                                                        </th>
                                                                    </tr>														
                                                                    <?php }?>
                                                                </tbody>							
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </form>
                </div><!--card-body-->
            </div><!--card-->
        <!--</div>--><!--col-->
    <!--</div>--><!--row-->

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

	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
	<script src="{{ asset('js/create_activos.js') }}"></script>

	@endpush
