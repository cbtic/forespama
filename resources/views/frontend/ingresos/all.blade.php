<!--<script src="<?php echo URL::to('/') ?>/js/manifest.js"></script>
<script src="<?php echo URL::to('/') ?>/js/vendor.js"></script>
<script src="<?php echo URL::to('/') ?>/js/frontend.js"></script>-->


<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!--<link rel="stylesheet" type="text/css" href="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.css">-->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<!--<script src="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>-->

<style>
	#tblAfiliado tbody tr{
		font-size:13px
	}
    .table-sortable tbody tr {
        cursor: move;
    }
	/*
    #global {        
        width: 95%;        
        margin: 15px 15px 15px 15px;     
        height: 380px !important;        
        border: 1px solid #ddd;
        overflow-y: scroll !important;
    }
	*/
	#global {
        height: 650px !important;
        width: auto;
        border: 1px solid #ddd;
		margin:15px
       /* background: #f1f1f1;*/
        /*overflow-y: scroll !important;*/
    }
	
    .margin{

        margin-bottom: 20px;
    }
    .margin-buscar{
        margin-bottom: 5px;
        margin-top: 5px;
    }

    /*.row{
        margin-top:10px;
        padding: 0 10px;
    }*/
    .clickable{
        cursor: pointer;   
    }

    /*.panel-heading div {
        margin-top: -18px;
        font-size: 15px;        
    }
    .panel-heading div span{
        margin-left:5px;
    }*/
    .panel-body{
        display: block;
    }
	
	.dataTables_filter {
	   display: none;
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

</style>

@extends('frontend.layouts.app1')

@section('title', app_name() . ' | ' . __('labels.frontend.contact.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
        <li class="breadcrumb-item text-primary">Inicio</li>
            <li class="breadcrumb-item active">Consulta de Estado de Cuenta</li>
        </li>
    </ol>
@endsection

<div class="loader"></div>

@section('content')

    <!--<ol class="breadcrumb" style="padding-left:120px;margin-top:0px">
        <li class="breadcrumb-item text-primary">Inicio</li>
            <li class="breadcrumb-item active">Consulta de Afiliados</li>
        </li>
    </ol>
    -->
    <div class="justify-content-center">
        
        <div class="card">

        <div class="card-body">

            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0 text-primary">
                        Consultar Estado de Cuenta <!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div><!--col-->
            </div>

        <div class="row justify-content-center">
        
        <div class="col col-sm-12 align-self-center">

            <div class="card">
                <div class="card-header">
                    <strong>
                        Lista de Estado de Cuenta
                    </strong>
                </div><!--card-header-->
				
				<form class="form-horizontal" method="post" action="{{ route('frontend.contact.send')}}" id="frmAfiliacion" autocomplete="off">
				<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
				
				<input type="hidden" name="order" id="order" value="">
				<input type="hidden" name="sort" id="sort" value="Asc">
				
				<div class="row" style="padding:20px 20px 0px 20px;">
					
					<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
						<select name="pago" id="pago" class="form-control form-control-sm">
							<option value="N">PENDIENTE</option>
							<option value="S">PAGADO</option>
						</select>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
						<select name="tipo" id="tipo" class="form-control form-control-sm">
							<!--
							<option value="">Todos los Planes</option>
							<option value="LINEA BLANCA">LINEA BLANCA</option>
							<option value="MARISCOS">MARISCOS</option>
							-->
							<option value="">Todas las Areas Planes</option>
							<option value="">Sin Plan</option>
							<?php foreach($area as $row):?>
							<option value="<?php echo $row->id?>"><?php echo $row->denominacion?></option>
							<?php  endforeach;?>
						</select>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
						<!--<input class="form-control form-control-sm" id="periodo" name="periodo" placeholder="Periodo">-->
						<select name="periodo" id="periodo" class="form-control form-control-sm">
							<option value="">Todos periodos</option>
							<option value="MENSUAL">MENSUAL</option>
							<option value="SEMANAL">SEMANAL</option>
							<option value="DIA">DIA</option>
						</select>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
						<select name="flag_tarjeta" id="flag_tarjeta" class="form-control form-control-sm">
							<option value="">T. Tarjeta</option>
							<option value="1">Con Tarjeta</option>
							<option value="2">Sin Tarjeta</option>
						</select>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
						<input class="form-control form-control-sm" id="numero_documento" name="numero_documento" placeholder="Doc. Identidad">
					</div>
					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<input class="form-control form-control-sm" id="afiliado" name="afiliado" placeholder="Afiliado">
					</div>
				</div>
				
				<div class="row" style="padding:20px 20px 0px 20px;">
					<!--
					<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
						<input class="form-control form-control-sm" id="tipo" name="tipo" placeholder="Tipo">
					</div>
					-->
					
					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
						<input class="form-control form-control-sm" id="fecha_inicio" name="fecha_inicio" placeholder="Fecha Inicio">
					</div>
					
					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
						<input class="form-control form-control-sm" id="fecha_fin" name="fecha_fin" placeholder="Fecha Fin">
					</div>
					
					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
						<input class="form-control form-control-sm" id="fecha_proceso" name="fecha_proceso" placeholder="Fecha Proceso">
					</div>
					
					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
						<input class="btn btn-warning pull-rigth" value="Buscar" type="button" id="btnBuscar" />
					</div>
					
					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
						<input class="btn btn-success pull-rigth" value="Excel" type="button" id="btnExcel" onclick="reporteEstadoCuenta()"/>
					</div>
					@hasanyrole('administrator')
					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
						<input class="btn btn-info pull-rigth" value="Procesar" type="button" id="btnProcesar" onclick="estadoCuentaAutomatico()" />
					</div>
					
					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
						<input class="btn btn-danger pull-rigth" value="Elim. Bloque" type="button" id="btnEliminarBloque"/>
					</div>
					
					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
						<input class="btn btn-danger pull-rigth" value="Inact. Tarjeta Bloque" type="button" id="btnInactivarTarjetaBloque" style="margin-left:20px;margin-right:0px" />
					</div>
					
					@endhasanyrole
				</div>
				
                <div class="card-body">				

                    <div class="table-responsive">
                    <table id="tblAfiliado" class="table table-hover table-sm">
                        <thead>
                        <tr style="font-size:13px">
							<th style="text-align: center; padding-bottom:0px;padding-right:5px;margin-bottom: 0px; vertical-align: middle" class="text-left">
								<input type="checkbox" name="select_all" value="1" id="example-select-all" <?php //echo $seleccionar_todos ?> >
							</th>
                            <th>Fecha</th>
							<th>Tipo Doc.</th>
							<th>Documento</th>
                            <th>Nombres Y Apellidos</th>
							<th>N&uacute;mero de Tarjeta</th>
							<th>Plan</th>
							<th>Per&iacute;odo</th>
                            <th>Concepto Corto</th>
							<th>Concepto Largo</th>
							<th>Dscto</th>
                            <th onclick="fn_ordenar('t3.vsm_precio')">Monto</th>
							<th>Fecha Fac</th>
							<th>Tipo</th>
							<th>Serie</th>
							<th>Numero</th>
							<th onclick="fn_ordenar('t4.fac_total')">Importe</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div><!--table-responsive-->
                </form>



                </div><!--card-body-->
            </div><!--card-->
        <!--</div>--><!--col-->
    <!--</div>--><!--row-->

@endsection

@push('after-scripts')
{!! script(asset('js/ingresoLista.js')) !!}
<script type="text/javascript">
$(document).ready(function () {
	
	/*
	$('#tblAfiliado').DataTable({
		"dom": '<"top">rt<"bottom"flpi><"clear">'
		});
	$("#system-search").keyup(function() {
			var dataTable = $('#tblAfiliado').dataTable();
		   dataTable.fnFilter(this.value);
		}); 
	*/
	
	
	
});
</script>
@endpush
