//alert("ok");
//jQuery.noConflict(true);

$(document).ready(function () {

	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

    $('#tipo_documento_cobro_bus').select2({ width: '100%' })
    
	datatablenew();

});

function datatablenew(){

    var oTable1 = $('#tblFacturacionSodimacDetalle').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/comprobante/listar_factura_sodimac_detalle_ajax",
        "bProcessing": true,
        "sPaginationType": "full_numbers",
        //"paging":false,
        "bFilter": false,
        "bSort": false,
        "info": true,
		//"responsive": true,
        "language": {"url": "/js/Spanish.json"},
        "autoWidth": false,
        "bLengthChange": true,
        "destroy": true,
        "lengthMenu": [[10, 50, 100, 200, 60000], [10, 50, 100, 200, "Todos"]],
        "aoColumns": [
                        {},
        ],
		"dom": '<"top">rt<"bottom"flpi><"clear">',
        "fnDrawCallback": function(settings) {

            let totalImporteInicial = 0;
            let totalImporteRetencion = 0;
            let totalImporteTotal = 0;

			settings.aoData.forEach(function(row) {
				let importe_inicial = row._aData.importe_inicial;
				let importe_retencion = row._aData.importe_retencion;
				let importe_total = row._aData.importe_total;
                
				if (importe_inicial) {
					totalImporteInicial += parseFloat(Math.abs(importe_inicial));
				}
                if (importe_retencion) {
					totalImporteRetencion += parseFloat(importe_retencion);
				}
                if (importe_total) {
					totalImporteTotal += parseFloat(Math.abs(importe_total));
				}
			});

			$('#tblFacturacionSodimacDetalle tfoot tr').html(`
                <td colspan="5"><b>Total</b></td>
                <td class="text-right"><b>${totalImporteInicial.toFixed(2)}</b></td>
                <td class="text-right"><b>${totalImporteRetencion.toFixed(2)}</b></td>
                <td class="text-right"><b>${totalImporteTotal.toFixed(2)}</b></td>
            `);

            $('[data-toggle="tooltip"]').tooltip();
        },
        
        "fnServerData": function (sSource, aoData, fnCallback, oSettings) {

            var sEcho           = aoData[0].value;
            var iNroPagina 	= parseFloat(fn_util_obtieneNroPagina(aoData[3].value, aoData[4].value)).toFixed();
            var iCantMostrar 	= aoData[4].value;

			var numero_documento = $('#numero_documento_bus').val();
            var tipo_documento_cobro = $('#tipo_documento_cobro_bus').val();
            
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						numero_documento:numero_documento,tipo_documento_cobro:tipo_documento_cobro,
                        _token:_token
                       },
                "success": function (result) {
                    fnCallback(result);
                },
                "error": function (msg, textStatus, errorThrown) {
                    //location.href="login";
                }
            });
        },

        "aoColumnDefs":
        [
            {
            "mRender": function (data, type, row) {
                var id = "";
                if(row.id!= null)id = row.id;
                return id;
            },
            "bSortable": false,
            "aTargets": [0],
            "className": "dt-center",
            },
            {
            "mRender": function (data, type, row) {
                var id_sodimac_factura = "";
                if(row.id_sodimac_factura!= null)id_sodimac_factura = row.id_sodimac_factura;
                return id_sodimac_factura;
            },
            "bSortable": false,
            "aTargets": [1]
            },
            {
            "mRender": function (data, type, row) {
                var tipo_documento_cobro = "";
                if(row.tipo_documento_cobro!= null)tipo_documento_cobro = row.tipo_documento_cobro;
                return tipo_documento_cobro;
            },
            "bSortable": false,
            "aTargets": [2],
            },
            {
            "mRender": function (data, type, row) {
                var numero_documento = "";
                if(row.numero_documento!= null)numero_documento = row.numero_documento;
                return numero_documento;
            },
            "bSortable": false,
            "aTargets": [3],
            },
            {
            "mRender": function (data, type, row) {
                var moneda = "";
                if(row.moneda!= null)moneda = row.moneda;
                return moneda;
            },
            "bSortable": false,
            "aTargets": [4],
            "className": 'control'
            },
            {
            "mRender": function (data, type, row) {
                var importe_inicial = "";
                if(row.importe_inicial!= null)importe_inicial = Math.abs(parseFloat(row.importe_inicial)).toFixed(2);
                return importe_inicial;
            },
            "bSortable": false,
            "aTargets": [5],
            "className": "text-right"
            },
            {
            "mRender": function (data, type, row) {
                var importe_retencion = "";
                if(row.importe_retencion!= null)importe_retencion = parseFloat(row.importe_retencion).toFixed(2);
                return importe_retencion;
            },
            "bSortable": false,
            "aTargets": [6],
            "className": "text-right"
            },
            {
            "mRender": function (data, type, row) {
                var importe_total = "";
                if(row.importe_total!= null)importe_total = Math.abs(parseFloat(row.importe_total)).toFixed(2);
                return importe_total;
            },
            "bSortable": false,
            "aTargets": [7],
            "className": "text-right"
            },
        ]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};

function reporteFacturaSodimac(){

    var fecha_ini = $('#fecha_ini').val();
    var fecha_fin = $('#fecha_fin').val();
    var tipo_documento = $('#tipo_documento').val();
    var serie = $('#serie').val();
    var numero = $('#numero').val();

	if (fecha_ini == "")fecha_ini = "0";
    if (fecha_fin == "")fecha_fin = "0";
    if (tipo_documento == "") tipo_documento= 0;
    if (serie == "")serie = 0;
    if (numero == "")numero = 0;

	location.href = '/comprobante/exportar_factura_sodimac/'  + fecha_ini + '/' + fecha_fin + '/' + tipo_documento + '/'+ serie + '/'+ numero;

}
