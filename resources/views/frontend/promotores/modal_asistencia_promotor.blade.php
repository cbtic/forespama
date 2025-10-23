<style>

.modal-dialog {
  max-width: 40%; /* Ajusta el ancho del modal */
  margin: 1.75rem auto; /* Centrado */
}

.modal-content {
  border-radius: 10px;
  overflow: hidden;
}

.modal-body {
  max-height: 70vh; /* scroll interno */
  overflow-y: auto;
}

.datepicker,
.table-condensed {
  width: 250px;
  height:250px;
}

.custom-select2-dropdown {
    width: 700px !important; 
}

#tablemodal{
    border-spacing: 0;
    max-height: 80vh; /*El alto que necesitemos**/
    overflow-y: auto; /**El scroll verticalmente cuando sea necesario*/
    overflow-x: hidden;/*Sin scroll horizontal*/
    table-layout: fixed;/**Forzamos a que las filas tenga el mismo ancho**/
    border:1px solid #c4c0c9;
}

#tablemodal thead{
    background-color: #e2e3e5;
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

</style>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/locales/bootstrap-datepicker.es.min.js" charset="UTF-8"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker3.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>

<script type="text/javascript">

$(document).ready(function() {

    $('#id_tienda').select2({ width : '100%' });

});

</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
	 
});

function fn_save_asistencia_promotor(){
	
    var msg = "";

    var id_tienda = $('#id_tienda').val();

    if(id_tienda==""){msg+="Debe seleccionar una tienda antes de marcar asistencia. <br>";}
    
    if(msg!=""){
        bootbox.alert(msg);
        return false;
    }else{
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {

                const latitud = position.coords.latitude;
                const longitud = position.coords.longitude;

                var msgLoader = "Marcando asistencia, espere un momento...";
                var heightBrowser = $(window).width() / 2;
                $('.loader').css("opacity", "0.8").css("height", heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>" + msgLoader + "</div></div>");
                $('.loader').show();

                $.ajax({
                    url: "/promotores/marcar_asistencia",
                    type: "POST",
                    dataType: "json",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id_tienda: id_tienda,
                        latitud: latitud,
                        longitud: longitud
                    },
                    success: function (response) {
                        $('.loader').hide();
                        bootbox.alert(response.message);
                        $('#btnAsistencia').attr('disabled', false);
                        $('#openOverlayOpc').modal('hide');
                        datatablenew();
                    },
                    error: function (xhr, status, error) {
                        $('.loader').hide();
                        bootbox.alert("Ocurrió un error al marcar la asistencia: " + error);
                        $('#btnAsistencia').attr('disabled', false);
                    }
                });

            }, function (error) {

                if (error.code === error.PERMISSION_DENIED) {
                    bootbox.alert("Debes permitir el acceso a la ubicación para marcar asistencia.");
                } else if (error.code === error.POSITION_UNAVAILABLE) {
                    bootbox.alert("No se pudo determinar la ubicación.");
                } else if (error.code === error.TIMEOUT) {
                    bootbox.alert("Tiempo de espera agotado al obtener la ubicación.");
                } else {
                    bootbox.alert("Error desconocido al obtener la ubicación.");
                }
                $('#btnAsistencia').attr('disabled', false);
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );

        } else {
            bootbox.alert("Tu navegador no soporta geolocalización.");
            $('#btnAsistencia').attr('disabled', false);
        }
    }
}

</script>


<div class="card">
    <div style="text-align: center; font-size:16px; margin-top: 20px">
        <b>Registrar Asistencia</b>
    </div>
    
    <div class="card-body">
    <form method="post" action="#" id="frmAsistenciaPromotor" name="frmAsistenciaPromotor">

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
        
        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
        
        <div class="row" style="padding-left:10px">

            <div class="col-lg-2">
                Tienda
            </div>
            <div class="col-lg-10">
                <select name="id_tienda" id="id_tienda" class="form-control form-control-sm" onchange="">
                    <option value="">--Seleccionar--</option>
                    <?php
                    foreach ($tiendas as $row){?>
                        <option value="<?php echo $row->id ?>"><?php echo $row->denominacion ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="card-body" style="margin-top:15px">
            <div style="margin-top:15px" class="form-group">
                <div class="col-sm-12 controls">
                    <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                        
                        <a href="javascript:void(0)" onClick="fn_save_asistencia_promotor()" class="btn btn-sm btn-success" style="margin-right:10px">Guardar</a>
                        
                        <a href="javascript:void(0)" onClick="$('#openOverlayOpc').modal('hide');" class="btn btn-sm btn-info" style="">Cerrar</a>
                    </div>
                                        
                </div>
            </div> 

        </div>
                
        </div>
    </form>
    </div>
                
