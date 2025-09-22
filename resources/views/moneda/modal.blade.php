<title>Sistema</title>
<style>
</style>
<script type="text/javascript">
$(document).ready(function () {
});
function fn_save(){
    save_modal({
        sAjaxSource: "/moneda/send",
        extraData: {
			'id': $('#id').val(),
			'denominacion': $('#denominacion').val(),
			'abreviatura': $('#abreviatura').val(),
			'simbolo': $('#simbolo').val(),
			'estado': $('#estado').val()
		}
    });
}
</script>

<body class="hold-transition skin-blue sidebar-mini">

    <div class="panel-heading close-heading">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>

    <div>
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header" style="padding:5px!important;padding-left:20px!important; font-weight: bold">
                    Registro Moneda
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" id="id" value="{{ $id }}">
                            
                            <div class="row" style="padding:0px,10px,0px,10px">
                                    <div class="col-lg-6">
        <div class="form-group">
            <label class="control-label">denominacion</label>
            <input class="form-control form-control-sm" id="denominacion" name="denominacion" value="{{ $moneda->denominacion }}" placeholder="denominacion">
        </div>
    </div>    <div class="col-lg-6">
        <div class="form-group">
            <label class="control-label">abreviatura</label>
            <input class="form-control form-control-sm" id="abreviatura" name="abreviatura" value="{{ $moneda->abreviatura }}" placeholder="abreviatura">
        </div>
    </div>    <div class="col-lg-6">
        <div class="form-group">
            <label class="control-label">simbolo</label>
            <input class="form-control form-control-sm" id="simbolo" name="simbolo" value="{{ $moneda->simbolo }}" placeholder="simbolo">
        </div>
    </div>    <div class="col-lg-6">
        <div class="form-group">
            <label class="control-label">estado</label>
            <input class="form-control form-control-sm" id="estado" name="estado" value="{{ $moneda->estado }}" placeholder="estado">
        </div>
    </div> <!-- Campos dinámicos -->
                            </div>
                            
                            <div style="margin-top:15px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                        <a href="javascript:void(0)" onClick="fn_save()" class="btn btn-sm btn-success">Guardar</a>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>