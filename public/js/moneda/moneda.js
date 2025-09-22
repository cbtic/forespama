$(document).ready(function () {
    $('#btnBuscar').click(function () {
        fn_ListarBusqueda();
    });
    $('#btnNuevo').click(function () {
        fn_modal(0);
    });
    fn_ListarBusqueda();
});

function fn_modal(id){
    modal({
        sAjaxSource: "/moneda/modal/"+id,
    });
}

function fn_eliminar(id,estado){
    if(estado==1)estado_=0;
    if(estado==0)estado_=1;
    eliminar({
        estado : estado,
        sAjaxSource: "/moneda/eliminar/"+id+"/"+estado_,
    });
}

function fn_ListarBusqueda() {
    datatablenew({
        tabla: "tblMoneda",
        sAjaxSource: "/moneda/all_ajax",
        extraData: {
            id: $('#id_bus').val(),
			denominacion: $('#denominacion_bus').val(),
			abreviatura: $('#abreviatura_bus').val(),
			simbolo: $('#simbolo_bus').val(),
			estado: $('#estado_bus').val()
        },
        columns: [
            'id',
			'denominacion',
			'abreviatura',
			'simbolo',
			'estado'
        ]
    });
};