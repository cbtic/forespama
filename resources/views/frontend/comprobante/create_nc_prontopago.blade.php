 <!--<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>-->
<!--
<script src="<?php echo URL::to('/') ?>/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo URL::to('/') ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo URL::to('/') ?>/bower_components/fastclick/lib/fastclick.js"></script>
<script src="<?php echo URL::to('/') ?>/dist/js/adminlte.min.js"></script>
<script src="<?php echo URL::to('/') ?>/dist/js/demo.js"></script>
<script src="<?php echo URL::to('/') ?>/dist/js/js.util.grid.js"></script>
<script src="<?php echo URL::to('/') ?>/bower_components/select2/dist/js/select2.full.min.js"></script>

<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link media="all" type="text/css" rel="stylesheet" href="https://app-gsf.saludpol.gob.pe:29692/css/datatables/dataTables.bootstrap.min.css">
<script src="https://app-gsf.saludpol.gob.pe:29692/js/datatables/datatables.min.js"></script>-->

<!--<script src="<?php echo URL::to('/') ?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>-->
<!--<script src="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>-->

<!--<script src="<?php echo URL::to('/') ?>/js/manifest.js"></script>
<script src="<?php echo URL::to('/') ?>/js/vendor.js"></script>
<script src="<?php echo URL::to('/') ?>/js/frontend.js"></script>-->

<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">


<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
    var urlApp = "<?php echo URL::to('/') ?>";
    //alert(urlApp);

    if (history.forward(1)) {
        location.replace(history.forward(1));
    }

    $(document).ready(function() {

        $('#addFiltro').on('click', function() {
            var addFiltro = $('#addFiltro').attr("aria-pressed");
            $("#fsFiltro").hide();
            if (addFiltro == "false") {
                $("#fsFiltro").show();
            }
        });

        $('#id_formapago_').change(function() {
            // Tu lógica aquí
            toggleTarjeta()
            //console.log('Opción seleccionada:', $(this).val());
        });
    });

    function openCity(evt, cityName) {
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    function toggleTarjeta() {
        var tarjeta = document.getElementById('card_cuotas');
        tarjeta.style.display = (tarjeta.style.display == 'none' || tarjeta.style.display === '') ? 'block' : 'none';
    }

</script>

<style type="text/css">
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

    .btn-xsm {
        font-size: 11px !important;
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
    }

    br {
        line-height: 30px;
    }

    .flotante {
        display: inline;
        position: fixed;
        bottom: 0px;
        right: 0px;
    }

    .flotanteC {
        display: inline;
        position: fixed;
        bottom: 65px;
        right: 0px;
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
        position: absolute;
        background-color: #000;
        opacity: 0.6;
        filter: alpha(opacity=40);
        display: none;
    }

    .dataTables_processing {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 500px !important;
        font-size: 1.7em;
        border: 0px;
        margin-left: -17% !important;
        text-align: center;
        background: #3c8dbc;
        color: #FFFFFF;
    }
</style>


@stack('before-scripts')
@stack('after-scripts')

@extends('frontend.layouts.app')



@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
    <li class="breadcrumb-item text-primary">Inicio</li>
    <li class="breadcrumb-item active">Facturacion</li>
    <li class="breadcrumb-item active">Editar</li>
    </li>
</ol>
@endsection

@section('content')

<div class="loader"></div>

<div class="justify-content-center">
    <!--<div class="container-fluid">-->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0 text-primary">
                        <small class="text-muted">Nota de Credito por Pronto Pago</small>
                        <!--Edita Factura-->
                        <!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div>
                <!--col-->
            </div>
            <div class="row justify-content-center">
                <div class="col col-sm-12 align-self-center">
                    
                    <form class="form-horizontal" method="post" action="{{ route('frontend.comprobante.nc_edita')}} " id="frmNC" name="frmNC" autocomplete="off">
                        
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                        <input type="hidden" name="trans" id="trans" value="FN">
                        <input type="hidden" name="_afecta" id="_afecta" value="<?php //echo $afectacion; ?>">

                        <input type="hidden" name="tipoF" value="NC">
                        <input type="hidden" name="vestab" value="1">
                        <input type="hidden" name="totalF" value="<?php /*if ($trans == 'FA') {
                                                                        echo $total;
                                                                    }*/ ?>">
                        <input type="hidden" name="ubicacion" value="<?php /*if ($trans == 'FA') {
                                                                            echo $ubicacion;
                                                                        }*/ ?>">
                        <input type="hidden" name="persona" value="<?php /*if ($trans == 'FA') {
                                                                        echo $persona;
                                                                    }*/ ?>">
                        <input type="hidden" name="id_caja" value="<?php /*if ($trans == 'FA' or $trans == 'FN') {
                                                                        echo $id_caja;
                                                                    }*/ ?>">
                        <input type="hidden" name="MonAd" value="<?php /*if ($trans == 'FA') {
                                                                        echo $MonAd;
                                                                    }*/ ?>">
                        <input type="hidden" name="adelanto" value="<?php /*if ($trans == 'FA') {
                                                                        echo $adelanto;
                                                                    }*/ ?>">
                        <input type="hidden" name="id_factura" value="<?php /*if ($trans == 'FE') {
                                                                            echo $comprobante->id;
                                                                        }*/ ?>">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div id="" class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <div id="" class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <strong>
                                                            Datos del Cliente
                                                        </strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="fsFiltro" class="card-body">
                                                <div id="" class="row">
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Serie</label>
                                                            <select readonly name="serieF" id="serieF" class="form-control form-control-sm">
                                                                <?php foreach ($serie as $row) : ?>
                                                                    <option value="<?php echo $row->denominacion ?>"><?php echo $row->denominacion ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12" name="divNumeroF" id="divNumeroF">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Número</label>
                                                            <input type="text" name="numerof" readonly id="numerof" value="<?php /*if ($trans == 'FE') {
                                                                                                                                echo $comprobante->numero;
                                                                                                                            }*/ ?>" placeholder="" class="form-control form-control-sm text-center">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Fecha Emisión</label>
                                                                <input type="text" name="fechaF" id="fechaF" value="<?php echo date("d/m/Y") ?>" placeholder="" class="form-control form-control-sm datepicker">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-group">Tipo de Nota</label>                               
                                                            <select name="tiponota_" id="tiponota_" class="form-control form-control-sm" onChange="actualizaimportes()" >
                                                                <option value="">--Selecionar--</option>
                                                                <?php
                                                                foreach ($tipooperacion as $row) { ?>
                                                                    <option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == 4) echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">

                                                            <label class="form-group">Motivo</label>
                                                            <input type="text" name="motivo_" id="motivo_" value="DESCUENTO GLOBAL" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="" class="row">
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <label class="form-control-sm">RUC/DNI</label>
                                                        <div class="input-group">
                                                            <input type="text" name="numero_documento" readonly id="numero_documento" value="<?php //echo $comprobante->cod_tributario;?> " placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                        <button type="button" data-toggle="modal" data-target="#duenoCargaModal" id="" class="btn btn-link btn-xsm">Buscar Empresa</button>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Razón Social/Nombre</label>
                                                            <input type="text" name="razon_social" readonly id="razon_social" value="<?php //echo $comprobante->destinatario;?>" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Dirección</label>
                                                            <input type="text" name="direccion" readonly id="direccion" value="<?php /*if ($trans == 'FA') {
                                                                                                                                            echo $empresa->direccion;
                                                                                                                                        }
                                                                                                                                        if ($trans == 'FE') {
                                                                                                                                            echo $comprobante->direccion;
                                                                                                                                        }
                                                                                                                                        if ($trans == 'FN') {
                                                                                                                                            echo $direccion;
                                                                                                                                        }
                                                                                                                                        */ ?>" placeholder="" class="form-control form-control-sm">
                                                                                                                                        
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Email</label>
                                                            <input type="text" name="correo" readonly id="correo" value="<?php /*if ($trans == 'FA') {
                                                                                                                                            echo $empresa->email;
                                                                                                                                        }
                                                                                                                                        if ($trans == 'FE') {
                                                                                                                                            echo $comprobante->correo_des;
                                                                                                                                        }
                                                                                                                                        if ($trans == 'FN') {
                                                                                                                                            echo $correo;
                                                                                                                                        }*/ ?>" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                               
                                               
                                            </div>
                                            <!--card-body-->
                                        </div>
                                        <!--card-->

                                        <div class="card" id="card_Adelanto">
                                            <div class="card-header">
                                                <strong>                                            
                                                    Factura de Credito
                                                </strong>
                                            </div>

                                            <div class="card-body">
                                                <div class="table-responsive overflow-auto" style="max-height: 500px;">

                                                    <table id="tblAdelanto" class="table table-hover table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th width="40%">Pronto Pago</th>
                                                                <th width="40%">Factura Afecta</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <select multiple="multiple" class="form-control form-control-sm" id="idFacturaCredito" name="idFacturaCredito[]" tabindex="16" style="width: 500px"> 
                                                                        <option></option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control form-control-sm" id="id_comprobante_ncdc" name="id_comprobante_ncdc" tabindex="16" style="width: 200px"> 
                                                                        <option></option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                
                                            </div>
                                            <br><br>
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>
                            <br>

                            <div id="" class="row">
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <strong>
                                                Detalle Resumen
                                            </strong>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive overflow-auto" style="max-height: 500px;">
                                                <table id="tblDetalle" class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-right" width="5%">#</th>
                                                            <th class="text-center" width="5%">Cant.</th>
                                                            <th width="25%">Descripción</th>
                                                            <th width="15%">Total</th>
                                                            <th class="text-center" width="15%">%</th>
                                                            <th class="text-center" width="15%">Valor</th>
                                                            <th class="text-right" width="15%">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $n = 0;
                                                        $key = 0;
                                                        $smodulo = "";
                                                        ?>
                                                        <input type="hidden" name="facturad[<?php echo $key ?>][id]" value="<?php //echo $fac['id'] ?>" />
                                                        <input type="hidden" name="facturad[<?php echo $key ?>][fecha]" value="<?php //echo $fac['fecha'] ?>" />
                                                        <input type="hidden" name="facturad[<?php echo $key ?>][denominacion]" value="<?php //echo $fac['denominacion'] ?>" />
                                                        <input type="hidden" name="facturad[<?php echo $key ?>][descripcion]" value="<?php //echo $fac['descripcion'] ?>" />
                                                        <input type="hidden" name="facturad[<?php echo $key ?>][tipoF]" value="ND" />
                                                        
                                                        <input type="hidden" name="facturad[<?php echo $key ?>][monto]" value="<?php //echo $fac['monto'] ?>" />
                                                        <input type="hidden" name="facturad[<?php echo $key ?>][moneda]" value="<?php //echo $fac['moneda'] ?>" />
                                                        <input type="hidden" name="facturad[<?php echo $key ?>][id_moneda]" value="<?php //echo $fac['id_moneda'] ?>" />
                                                        <input type="hidden" name="facturad[<?php echo $key ?>][descuento]" value="<?php //echo $fac['descuento'] ?>" />
                                                        <input type="hidden" name="facturad[<?php echo $key ?>][cod_contable]" value="<?php //echo $fac['cod_contable'] ?>" />

                                                        <input type="hidden" id="facturad_pu" name="facturad[<?php echo $key ?>][importe]" value="<?php //echo $fac['pu'] ?>" />
                                                        <input type="hidden" id="facturad_igv" name="facturad[<?php echo $key ?>][igv]" value="<?php //echo $fac['igv_total'] ?>" />
                                                        <input type="hidden" id="facturad_total" name="facturad[<?php echo $key ?>][total]" value="<?php //echo $fac['importe'] ?>" />
                                                        <input type="hidden" name="facturad[<?php echo $key ?>][cantidad]" value="<?php //echo $fac['cantidad'] ?>" />
                                                        <input type="hidden" name="facturad[<?php echo $key ?>][codigo_producto]" value="<?php //echo $fac['codigo'] ?>" />
                                                        <input type="hidden" name="facturad[<?php echo $key ?>][abreviatura]" value="<?php //echo $fac['unidad'] ?>" />


                                                        <tr>
                                                            <td class="text-right">
                                                                <?php $n = $n + 1;
                                                                echo $n; 
                                                                ?>
                                                            </td>
                                                            <td class="text-center">1</td>
                                                            <td class="text-left">
                                                                DESCUENTO POR PRONTO PAGO
                                                            </td>
                                                            <td class="text-right">                                                                        
                                                                <input type="text" readonly name="importeantd[]"  id="importeantd<?php echo $key?>" value="<?php //echo number_format($fac['importe'], 2)?>" placeholder="" class="form-control form-control-sm text-center"  >
                                                            </td>
                                                            <td class="text-right">                                                                        
                                                                <input type="text" name="porcentajed[]" id="porcentajed<?php echo $key?>" onkeyup="calcular_porcentaje(<?php echo $key?>,1)" value="<?php //echo number_format($fac['importe'], 2)?>" placeholder="" class="form-control form-control-sm text-center"  >
                                                            </td>
                                                            <td>
                                                            <input type="text" name="valord[]" id="valord<?php echo $key?>" onkeyup="calcular_porcentaje(<?php echo $key?>,2)" value="" placeholder="" class="form-control form-control-sm text-center"  >               
                                                            </td>
                                                            <td>
                                                            <input type="text" name="totald[]"  id="totald<?php echo $key?>" onkeyup="calcular_total_2(<?php echo $key?>)" value="<?php  ?>" placeholder="" class="form-control form-control-sm text-center"  >               
                                                            </td>
                                                        </tr>
                                                        <input type="hidden" name="facturad[<?php echo $key ?>][item]" value="<?php echo $n ?>" />
                                                        <input type="hidden" name="smodulo_guia" id="smodulo_guia" value="<?php echo $smodulo ?>" />

                                                    </tbody>
                                                </table>
                                            </div>
                                            <!--table-responsive-->
                                        </div>
                                        <!--card-body-->
                                    </div>
                                    <!--card-->
                                </div>
                                <!--card-->
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <strong>
                                                <!--@lang('labels.frontend.asistencia.box_asistencia')-->
                                                Información de Pago
                                            </strong>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="tblPago" class="table table-hover">
                                                    <tbody>
                                                        <tr style="display:none">
                                                            <th></th>
                                                            <th>Anticipos</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th class="text-right"><span id="anticipos"></span> 0.00</th>
                                                        </tr>
                                                        <tr style="display:none">
                                                            <th></th>
                                                            <th>Descuentos</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th class="text-right"><span id="descuentos"></span> 0.00</th>
                                                        </tr>
                                                        <tr>
                                                            <th></th>
                                                            <th>Ope Gravadas</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th> <input type="text" name="gravadas" readonly id="gravadas" value="<?php /*if ($trans == 'FN') {
                                                                                                                                echo number_format( $comprobante->subtotal,2);
                                                                                                                            }*/ ?>" placeholder="" class="form-control form-control-sm text-center">
                                                        </th>

                                                            
                                                        </tr>
                                                        <tr style="display:none">
                                                            <th></th>
                                                            <th>Ope Inafectas</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th class="text-right"><span id="inafectas"></span> 0.00</th>
                                                        </tr>
                                                        <tr style="display:none">
                                                            <th></th>
                                                            <th>Ope Exoneradas</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th class="text-right"><span id="exoneradas"></span> 0.00</th>
                                                        </tr>
                                                        <tr>
                                                            <th></th>
                                                            <th>I.G.V.</th>
                                                            <th></th>
                                                            <th></th>

                                                            <th> <input type="text" name="igv" readonly id="igv" value="<?php /*if ($trans == 'FN') {
                                                                                                                                echo number_format( $comprobante->impuesto,2);
                                                                                                                            }*/ ?>" placeholder="" class="form-control form-control-sm text-center">
                                                        </th>

                                                            
                                                        </tr>
                                                        <tr>
                                                            <th></th>
                                                            <th>Total</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th> <input type="text" name="totalP" readonly id="totalP" value="<?php /*if ($trans == 'FN') {
                                                                                                                                echo number_format( $comprobante->total,2);
                                                                                                                            }*/ ?>" placeholder="" class="form-control form-control-sm text-center">
                                                        </th>

                        
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!--table-responsive-->
                                        </div>
                                        <!--card-body-->
                                    </div>
                                    <!--card-->



                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <div class="form-group">
                                            <button type="button" id="guardar" class="btn btn-primary btn-block" onclick="$('#guardar').prop('disabled', true); setTimeout(function(){$('#guardar').prop('disabled', false);},5000); ;guardarnc()">GUARDAR COMPROBANTE</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>

                        </div>
                </div>


                <!--   <a class='flotante' name="guardar" id="guardar" onclick="guardarFactura()" href='#' ><img src='/img/btn_save.png' border="0"/></a>--> <br>
                </form>
            </div>
        </div>
    </div>
    

    <!-- Modal -->
        <div class="modal fade" id="duenoCargaModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <form id="modalNuevoDuenoCargaForm"
                        action=""
                        method="POST"
                        autocomplete="off">

                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel3">
                                Buscar Datos del Cliente
                            </h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">

                                            <!-- EMPRESA / PARTICULAR -->
                                            <div class="form-group">

                                                <label class="control-label">EMPRESA</label>
                                                <input type="radio"
                                                    name="empresa_particular"
                                                    value="empresa"
                                                    id="empresa"
                                                    checked
                                                    onclick='$("#modalNuevoDuenoCargaSaveBtn").removeClass("btn-success").addClass("btn-primary");
                                                                $("#modalNuevoDuenoCargaSaveBtn").html("Buscar");
                                                                $("#numero_ruc_dni").val("");
                                                                $("#persona_nuevo_dueno_carga").val("");
                                                                $("#numero_ruc_dni").attr("placeholder","Escriba el RUC");
                                                                $("#empresa_nuevo_dueno_carga").show();
                                                                $("#persona_nuevo_dueno_carga").hide();
                                                                $("#modalNuevoEmpresaPersonaBtn").hide();'>

                                                <label class="control-label ml-3">PARTICULAR</label>
                                                <input type="radio"
                                                    name="empresa_particular"
                                                    value="particular"
                                                    id="particular"
                                                    onclick='$("#modalNuevoDuenoCargaSaveBtn").removeClass("btn-success").addClass("btn-primary");
                                                                $("#modalNuevoDuenoCargaSaveBtn").html("Buscar");
                                                                $("#numero_ruc_dni").val("");
                                                                $("#empresa_nuevo_dueno_carga").val("");
                                                                $("#numero_ruc_dni").attr("placeholder","Escriba el DNI/PTP/PASAPORTE/CEDULA");
                                                                $("#persona_nuevo_dueno_carga").show();
                                                                $("#empresa_nuevo_dueno_carga").hide();
                                                                $("#modalNuevoEmpresaPersonaBtn").hide();'>

                                            </div>

                                            <!-- RUC / DNI -->
                                            <div class="form-group">
                                                <input type="number"
                                                    name="numero_ruc_dni"
                                                    id="numero_ruc_dni"
                                                    maxlength="11"
                                                    value="{{ old('numero_ruc_dni') }}"
                                                    class="form-control form-control-sm"
                                                    placeholder="Escriba el RUC"
                                                    oninput="if (this.value.length > 11) this.value = this.value.slice(0, 11);">
                                            </div>

                                            <p>o ingrese</p>

                                            <!-- EMPRESA -->
                                            <div class="form-group">
                                                <input type="text"
                                                    name="empresa_nuevo_dueno_carga"
                                                    id="empresa_nuevo_dueno_carga"
                                                    value="{{ old('empresa_nuevo_dueno_carga') }}"
                                                    class="form-control form-control-sm"
                                                    placeholder="Escriba la Razón Social">

                                                <!-- PERSONA -->
                                                <input type="text"
                                                    name="persona_nuevo_dueno_carga"
                                                    id="persona_nuevo_dueno_carga"
                                                    value="{{ old('persona_nuevo_dueno_carga') }}"
                                                    class="form-control form-control-sm"
                                                    style="display:none"
                                                    placeholder="Escriba los Apellidos de la persona">
                                            </div>

                                            <div class="input-group"
                                                id="empresa_nuevo_dueno_carga_busqueda">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- FOOTER -->
                        <div class="modal-footer">
                            <button type="button"
                                    id="modalNuevoDuenoCargaCancelBtn"
                                    class="btn btn-secondary"
                                    data-dismiss="modal">
                                Cancelar
                            </button>

                            <button type="button"
                                    id="modalNuevoDuenoCargaSaveBtn"
                                    class="btn btn-primary">
                                Buscar
                            </button>

                            <button type="button"
                                    id="modalNuevoEmpresaPersonaBtn"
                                    class="btn btn-warning"
                                    style="display:none">
                                Nueva
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        <!--ModalEnd-->

</div>

<!--row-->
@endsection



@push('after-scripts')

<script src="{{ asset('js/facturaNCProntoPago.js') }}"></script>

<script>
    /*
$("#idFacturaCredito").select2({
    templateResult: function (data) {
        if (!data.id) return data.text;

        let opt = $(data.element);

        return $(`
        <div>
            <strong>${data.text}</strong><br>
            <small>
            ${opt.data('destinatario')} |
            RUC: ${opt.data('ruc')} |
            Total: S/ ${parseFloat(opt.data('total')).toFixed(2)}
            </small>
        </div>
        `);
    },
    templateSelection: function (data) {
        return data.text;
    }
});
*/

//$("#idFacturaCredito").select2();
$("#idFacturaCredito").select2({
    placeholder: "Seleccionar una Factura",
    allowClear: true,
    //width: '100%'
});

let totalGeneral = 0;

$("#idFacturaCredito").on('select2:select', function (e) {

    let data = e.params.data;
    let opt = $(data.element);
    let total = parseFloat(opt.data('total')) || 0;

    totalGeneral += total;

    actualizarTotal();
});

$("#idFacturaCredito").on('select2:unselect', function (e) {

    let data = e.params.data;
    let opt = $(data.element);
    let total = parseFloat(opt.data('total')) || 0;

    totalGeneral -= total;

    actualizarTotal();
});

function actualizarTotal() {
    $("#importeantd0").val(totalGeneral.toFixed(2));
}

function calcular_porcentaje(fila,opc){

        var imported=0;
        valord = $('#valord'+fila).val();
        porcentajed = $('#porcentajed'+fila).val();
        imported = $('#importeantd'+fila).val();

        if(opc==1){
            importe = porcentajed/100*imported;
            $('#valord'+fila).val(importe);
        }

        if(opc==2){
            porcentaje = imported/valord;
            importe = valord;
            $('#totald'+fila).val(importe);
            $('#porcentajed'+fila).val(porcentaje);
        }

        //importe = imported - descuentod*imported;
        
        //console.log(descuentod);
		var igv = importe*0.18;
		//var totald = Number(importe) + Number(igv);
        var totald = Number(importe);

		$("#igvd"+fila).val(igv.toFixed(2));
		$("#totald"+fila).val(totald.toFixed(2));
		var gravadas=0;
		//igv=0;
		var total=0;
        /*
		$("input[name^='importeantd']").each(function(i, obj) {
			gravadas = Number(obj.value) + Number(gravadas);
		});
        */
       gravadas = totald - igv;
		$("#gravadas").val(gravadas.toFixed(2));
        /*
		$("input[name^='igvd']").each(function(i, obj) {
			igv = Number(obj.value) + Number(igv);
		});
        */
		$("#igv").val(igv.toFixed(2));
		
		$("input[name^='totald']").each(function(i, obj) {
			total = Number(obj.value) + Number(total);
		});

		//$("#totalP").val(total.toFixed(2));
        $("#totalP").val(totald.toFixed(2));
    }

function calcular_descuento(fila,afectacion){

        var imported=0;
		//imported = $('#imported'+fila).val();
        descuentod = $('#descuentod'+fila).val();
        descuentod = descuentod/100;
        imported = $('#importeantd'+fila).val();
        importe = imported - descuentod*imported;
        
        console.log(descuentod);
		var igv = imported*0.18;
        
		var totald = Number(importe) + Number(igv);

		$("#igvd"+fila).val(igv.toFixed(2));
		$("#totald"+fila).val(totald.toFixed(2));
		var gravadas=0;
		igv=0;
		var total=0;

		$("input[name^='importeantd']").each(function(i, obj) {
			gravadas = Number(obj.value) + Number(gravadas);
		});

		$("#gravadas").val(gravadas.toFixed(2));

		$("input[name^='igvd']").each(function(i, obj) {
			igv = Number(obj.value) + Number(igv);
		});

		$("#igv").val(igv.toFixed(2));
		
		$("input[name^='totald']").each(function(i, obj) {
			total = Number(obj.value) + Number(total);
		});

		//$("#totalP").val(total.toFixed(2));
        $("#totalP").val(totald.toFixed(2));
    }


$('#modalNuevoDuenoCargaSaveBtn').click(function (e) {
		e.preventDefault();
		if ($("#modalNuevoDuenoCargaSaveBtn").html() != "Confirmar datos") {

			$(this).html('Realizando la consulta..');

			$.ajax({
			  data: $('#modalNuevoDuenoCargaForm').serialize(),
			  url: "/empresa/buscar_ajax",
			  type: "POST",
			  dataType: 'json',
			  success: function (data) {

				//   $('#modalNuevoDuenoCargaForm').trigger("reset");
				//   $('#duenoCargaModal').modal('hide');

				 //alert(data.msg);

				if (typeof data.ruc != "undefined") {
					$("#numero_ruc_dni").val(data.ruc);
				} else {
					$("#numero_ruc_dni").val(data.numero_documento);
				}

				$("#empresa_nuevo_dueno_carga").val(data.razon_social);
				$("#persona_nuevo_dueno_carga").val(data.nombre_completo);
				//$("#empresa_direccion").val(data.direccion);
				//$("#email").val(data.email);
                $("#direccion").val(data.direccion);
				$("#correo").val(data.email);
				$("#persona_id").val(data.persona_id);
				$("#id_ubicacion").val(data.ubicacion_id);

				if (typeof data.ruc !== "undefined") {
					$("#modalNuevoDuenoCargaSaveBtn").removeClass('btn-primary').addClass('btn-success');
					$("#modalNuevoDuenoCargaSaveBtn").html("Confirmar datos");
				} else if (typeof data.numero_documento !== "undefined") {
					$("#modalNuevoDuenoCargaSaveBtn").removeClass('btn-primary').addClass('btn-success');
					$("#modalNuevoDuenoCargaSaveBtn").html("Confirmar datos");
				} else {
					alert(data.msg);
					if (data.nueva != "") {
						$("#modalNuevoEmpresaPersonaBtn").html("Nueva "+data.nueva);
						$("#modalNuevoEmpresaPersonaBtn").show();
						// $('#empresa_numero_ruc').val(data.numero_ruc_dni);
						// $('#numero_documento_nueva_persona').val(data.numero_ruc_dni);
					}

					$("#modalNuevoDuenoCargaSaveBtn").removeClass('btn-success').addClass('btn-primary');
					$("#modalNuevoDuenoCargaSaveBtn").html("Buscar");
				}

			  },
			  error: function(data) {
				mensaje = "Revisar el formulario:\n\n";
				$.each( data["responseJSON"].errors, function( key, value ) {
				mensaje += value +"\n";
				});
				$("#modalNuevoDuenoCargaSaveBtn").html("Buscar");
				alert(mensaje);
		  }
		  });
		} else {
			if ($("#persona_nuevo_dueno_carga").val() == '') {
				$("#badge_particular").removeClass("badge-success");
				$("#badge_empresa").addClass("badge-success");
				$("#btn_boleta").attr("style", "display:none");
				$("#btn_factura").attr("style", "display:");
			} else {
				$("#badge_empresa").removeClass("badge-success");
				$("#badge_particular").addClass("badge-success");
				$("#btn_boleta").attr("style", "display:");
				$("#btn_factura").attr("style", "display:none");
			}

			// Carga los datos en el formulario padre
			$("#numero_documento").val($("#numero_ruc_dni").val());
			//$("#nombres_razon_social").val($("#empresa_nuevo_dueno_carga").val()+$("#persona_nuevo_dueno_carga").val());
            $("#razon_social").val($("#empresa_nuevo_dueno_carga").val()+$("#persona_nuevo_dueno_carga").val());
			// Reinicia el formulario modal
			$("#empresa_nuevo_dueno_carga").attr("style", "display:block");
			$("#persona_nuevo_dueno_carga").attr("style", "display:none");
			$("#modalNuevoDuenoCargaSaveBtn").html("Buscar");
			$("#modalNuevoDuenoCargaSaveBtn").removeClass('btn-success').addClass('btn-primary');
			$('#modalNuevoDuenoCargaForm').trigger("reset");
			$('#duenoCargaModal').modal('hide');

            buscar_factura_credito();

		}
	});

    function buscar_factura_credito(){

        var numero_documento = $("#numero_documento").val();;

        $.ajax({
            url: "/comprobante/obtener_fatura_credito/"+numero_documento,
            type: "GET",
            dataType: 'json',
            success: function(result){
                //let option = "<option value=''></option>";
                //let option = "<option></option>";
                let option = "";
                $('#idFacturaCredito').html("");
                $(result).each(function (ii, oo) {
                    option += "<option value='"+oo.id+"' data-destinatario='"+oo.destinatario+"' data-ruc='"+oo.cod_tributario+"' data-total='"+oo.total+"'>"+oo.serie+"-"+oo.numero+"</option>";
                });
                $('#idFacturaCredito').html(option);
                $('#idFacturaCredito').val(null).trigger('change');
                //$('#idFacturaCredito').val('').trigger('change');
                if ($('#idFacturaCredito').hasClass("select2-hidden-accessible")) {
                    $('#idFacturaCredito').select2('destroy');
                }

                $("#idFacturaCredito").select2({
                    placeholder: "Seleccionar una Factura",
                    allowClear: true,
                    matcher: function (params, data) {

                        // Si no hay término de búsqueda
                        if ($.trim(params.term) === '') {
                            return data;
                        }

                        // Si no hay elemento
                        if (typeof data.text === 'undefined') {
                            return null;
                        }

                        let term = params.term.toLowerCase();
                        let element = $(data.element);

                        let ruc = (element.data('ruc') || '').toString().toLowerCase();
                        let destinatario = (element.data('destinatario') || '').toString().toLowerCase();
                        let texto = data.text.toLowerCase();

                        // Buscar por texto principal, ruc o destinatario
                        if (
                            texto.indexOf(term) > -1 ||
                            ruc.indexOf(term) > -1 ||
                            destinatario.indexOf(term) > -1
                        ) {
                            return data;
                        }

                        return null;
                    },

                    templateResult: function (data) {
                        if (!data.id) return data.text;

                        let opt = $(data.element);

                        return $(`
                            <div>
                                <strong>${data.text}</strong><br>
                                <small>
                                ${opt.data('destinatario')} |
                                RUC: ${opt.data('ruc')} |
                                Total: S/ ${parseFloat(opt.data('total')).toFixed(2)}
                                </small>
                            </div>
                        `);
                    },

                    templateSelection: function (data) {
                        return data.text;
                    }
                });

            }
            
        });
        
    }

    $('#idFacturaCredito').on('change', function () {

        let selectedOptions = $(this).find('option:selected');

        // Limpiar el segundo select si quieres que siempre refleje lo actual
        //$("#id_comprobante_ncdc").html('<option></option>');
        $("#id_comprobante_ncdc").html('');

        selectedOptions.each(function () {

            let id = $(this).val();
            let text = $(this).text();
            let destinatario = $(this).data('destinatario');
            let ruc = $(this).data('ruc');
            let total = $(this).data('total');

            // Evitar duplicados
            if ($("#id_comprobante_ncdc option[value='" + id + "']").length === 0) {

                let nuevaOpcion = `
                    <option value="${id}" 
                        data-destinatario="${destinatario}" 
                        data-ruc="${ruc}" 
                        data-total="${total}">
                        ${text}
                    </option>
                `;

                $("#id_comprobante_ncdc").append(nuevaOpcion);
            }
        });

        // Si también es select2
        $("#id_comprobante_ncdc").trigger('change');
    });
    
</script>



@endpush