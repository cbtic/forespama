<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
@extends('frontend.layouts.app')

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
    <li class="breadcrumb-item text-primary">Inicio</li>
    <li class="breadcrumb-item active">Consulta de Area</li>
</ol>
@endsection

@section('content')

<div class="loader"></div>

<div class="justify-content-center">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0 text-primary">
                        Consulta de Area
                    </h4>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col col-sm-12 align-self-center">
                    <div class="card">
                        <div class="card-header">
                            <strong>
                                Lista de Area
                            </strong>
                        </div>

                        <form class="form-horizontal" method="post" action="" id="frmArea" autocomplete="off">
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                            <div style="padding:20px 20px 0px 20px;">
                                <div class="row">
                                                <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                <input class="form-control form-control-sm" id="producto_bus" name="producto_bus" placeholder="producto">
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                <input class="form-control form-control-sm" id="montoinicio_bus" name="montoinicio_bus" placeholder="montoinicio">
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                <input class="form-control form-control-sm" id="total_bus" name="total_bus" placeholder="total">
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                <input class="form-control form-control-sm" id="estado_bus" name="estado_bus" placeholder="estado">
            </div>

                                    <div class="col-lg-2 col-md-1 col-sm-12 col-xs-12" style="padding-right:0px">
                                        <input class="btn btn-warning" value="Buscar" type="button" id="btnBuscar" />
                                        <input class="btn btn-success" value="Nuevo" type="button" id="btnNuevo" style="margin-left:15px"/>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="card-body">    
                            <div class="table-responsive">
                                <table id="tblArea" class="table table-hover table-sm">
                                    <thead>
                                        <tr style="font-size:13px">
                                            <th>Id</th>
                                            <th>Producto</th>
<th>Montoinicio</th>
<th>Total</th>
<th>Estado</th>

                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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

@endsection

<div id="openOverlayOpc" class="modal fade" role="dialog">
<div class="modal-dialog">
    <div id="id_content_OverlayoneOpc" class="modal-content" style="padding: 0px;margin: 0px">
    <div class="modal-body" style="padding: 0px;margin: 0px">
        <div id="diveditpregOpc"></div>
    </div>
    </div>
</div>
</div>

@push('after-scripts')
<script src="{{ asset('js/area/area.js') }}"></script>
@endpush