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
        sAjaxSource: "/area/modal/"+id,
    });
}

function fn_eliminar(id,estado){
    if(estado==1)estado_=0;
    if(estado==0)estado_=1;
    eliminar({
        estado : estado,
        sAjaxSource: "/area/eliminar/"+id+"/"+estado_,
    });
}

function fn_ListarBusqueda() {
    datatablenew({
        tabla: "tblArea",
        sAjaxSource: "/area/all_ajax",
        extraData: {
            id: $('#id_bus').val(),
			producto: $('#producto_bus').val(),
			montoinicio: $('#montoinicio_bus').val(),
			total: $('#total_bus').val(),
			estado: $('#estado_bus').val()
        },
        columns: [
            'id',
			'producto',
			'montoinicio',
			'total',
			'estado'
        ]
    });
};