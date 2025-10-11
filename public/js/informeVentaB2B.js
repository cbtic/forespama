$(document).ready(function () {
	
	$(".upload").on('click', function() {

		var msgLoader = "";
        msgLoader = "Procesando, espere un momento por favor";
        var heightBrowser = $(window).width()/2;
        $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
        $('.loader').show();
		
        var formData = new FormData();
        var files = $('#image')[0].files[0];
        formData.append('file',files);
        $.ajax({
			headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/orden_compra/upload_informe_b2b_compra",
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
			dataType: 'json', 
            success: function(response) {
				
				console.log(response); 

				if(response.cantidad>0){
					$('.loader').hide();
					bootbox.alert("El informe de venta del B2B ya existe. Por favor ingrese otro.");
					return false;
				}else{
					datatablenew();
					$('.loader').hide();
				}
            }
        });
		return false;
    });

	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#producto_bus').select2({ width : '100%' })

	
	$('#tienda_bus').select2({ width : '100%' })
	
	datatablenew();

});

function datatablenew(){
                      
    var oTable1 = $('#tblInformeB2B').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/orden_compra/listar_informe_b2b_ajax",
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
        "lengthMenu": [[/*10,*/ 50, 100, 200, 60000], [/*10,*/ 50, 100, 200, "Todos"]],
        "aoColumns": [
                        {},
        ],
		"dom": '<"top">rt<"bottom"flpi><"clear">',
        "fnDrawCallback": function(json) {
            $('[data-toggle="tooltip"]').tooltip();
        },

        "fnServerData": function (sSource, aoData, fnCallback, oSettings) {

            var sEcho           = aoData[0].value;
            var iNroPagina 	= parseFloat(fn_util_obtieneNroPagina(aoData[3].value, aoData[4].value)).toFixed();
            var iCantMostrar 	= aoData[4].value;
			
			var semana = $('#semana_bus').val();
			var producto = $('#producto_bus').val();
			var tienda = $('#tienda_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						semana:semana,producto:producto,tienda:tienda,
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
					var upc = "";
					if(row.upc!= null)upc = row.upc;
					return upc;
				},
				"bSortable": true,
				"aTargets": [1]
				},
				
                {
                "mRender": function (data, type, row) {
                	var sku = "";
					if(row.sku!= null)sku = row.sku;
					return sku;
                },
                "bSortable": true,
                "aTargets": [2]
                },

				{
				"mRender": function (data, type, row) {
					var descripcion_empresa = "";
					if(row.descripcion_empresa!= null)descripcion_empresa = row.descripcion_empresa;
					return descripcion_empresa;
				},
				"bSortable": true,
				"aTargets": [3]
				},
				
				{
                "mRender": function (data, type, row) {
                	var subclase_conjunto = "";
					if(row.subclase_conjunto!= null)subclase_conjunto = row.subclase_conjunto;
					return subclase_conjunto;
                },
                "bSortable": true,
                "aTargets": [4]
                },

				{
				"mRender": function (data, type, row) {
					var desc_subclase_conjunto = "";
					if(row.desc_subclase_conjunto!= null)desc_subclase_conjunto = row.desc_subclase_conjunto;
					return desc_subclase_conjunto;
				},
				"bSortable": true,
				"aTargets": [5]
				},
				{
				"mRender": function (data, type, row) {
					var numero_tienda = "";
					if(row.numero_tienda!= null)numero_tienda = row.numero_tienda;
					return numero_tienda;
				},
				"bSortable": true,
				"aTargets": [6]
				},
				{
				"mRender": function (data, type, row) {
					var tienda = "";
					if(row.tienda!= null)tienda = row.tienda;
					return tienda;
				},
				"bSortable": true,
				"aTargets": [7]
				},
				{
				"mRender": function (data, type, row) {
					var semana = "";
					if(row.semana!= null)semana = row.semana;
					return semana;
				},
				"bSortable": true,
				"aTargets": [8]
				},
				{
				"mRender": function (data, type, row) {
					var lunes = "";
					if(row.lunes!= null)lunes = row.lunes;
					return lunes;
				},
				"bSortable": true,
				"aTargets": [9]
				},
				{
				"mRender": function (data, type, row) {
					var martes = "";
					if(row.martes!= null)martes = row.martes;
					return martes;
				},
				"bSortable": true,
				"aTargets": [10]
				},
				{
				"mRender": function (data, type, row) {
					var miercoles = "";
					if(row.miercoles!= null)miercoles = row.miercoles;
					return miercoles;
				},
				"bSortable": true,
				"aTargets": [11]
				},
				{
				"mRender": function (data, type, row) {
					var jueves = "";
					if(row.jueves!= null)jueves = row.jueves;
					return jueves;
				},
				"bSortable": true,
				"aTargets": [12]
				},
				{
				"mRender": function (data, type, row) {
					var viernes = "";
					if(row.viernes!= null)viernes = row.viernes;
					return viernes;
				},
				"bSortable": true,
				"aTargets": [13]
				},
				{
				"mRender": function (data, type, row) {
					var sabado = "";
					if(row.sabado!= null)sabado = row.sabado;
					return sabado;
				},
				"bSortable": true,
				"aTargets": [14]
				},
				{
				"mRender": function (data, type, row) {
					var domingo = "";
					if(row.domingo!= null)domingo = row.domingo;
					return domingo;
				},
				"bSortable": true,
				"aTargets": [15]
				},
				{
				"mRender": function (data, type, row) {
					var venta_unidades = "";
					if(row.venta_unidades!= null)venta_unidades = row.venta_unidades;
					return venta_unidades;
				},
				"bSortable": true,
				"aTargets": [16]
				},
				{
				"mRender": function (data, type, row) {
					var venta_soles = "";
					if(row.venta_soles!= null)venta_soles = row.venta_soles;
					return venta_soles;
				},
				"bSortable": true,
				"aTargets": [17]
				},
				{
				"mRender": function (data, type, row) {
					var stock_contable = "";
					if(row.stock_contable!= null)stock_contable = row.stock_contable;
					return stock_contable;
				},
				"bSortable": true,
				"aTargets": [18]
				},
            ]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};
