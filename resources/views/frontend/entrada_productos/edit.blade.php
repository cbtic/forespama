@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Editar Entrada #{{ $entrada_productos->id }}</div>

                <div class="card-body">
                    <x-forms.EntradaProducto :entradaproductos="$entrada_productos" />
                </div>
            </div>
        </div>


        <x-backend.card>
            <x-slot name="header">
                @lang("Detalle de Entrada")
            </x-slot>
            <x-slot name="headerActions" :entrada_producto="$entrada_productos->id">
                <x-forms.EntradaProductoDetalle :entradaproducto="$entrada_productos->id" />
            </x-slot>
            <x-slot name="body">
                <livewire:backend.entrada-producto-detalles-table :entrada_producto="$entrada_productos->id">
            </x-slot>
        </x-backend.card>
    </div>
</div>
@endsection

@push('after-scripts')
<!-- Modal -->
<div class="modal fade" id="ModalProducto" role="dialog">
     <div class="modal-dialog">
     <!-- Modal contenido-->
     <div class="modal-content">
     <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">&times;</button>
     </div>
     <div class="modal-body-producto">
</div>
</div>
</div>
<script>
    /* Llamando al formulario Modal para nuevo producto */
    $('.btnNuevoProducto').on('click',function(){
        $('.modal-body-producto').load('/productos/modal_create',function(){
            $('#ModalProducto').modal({show:true});
        });
    });

    function rowclick(td){
        let rowId = td.parentElement.rowIndex;
        document.getElementsByClassName("btn btn-success btn-entrada")[rowId-1].click();
        setTimeout(function(){
            redimensionaSelect2();
        }, 500);
    }

    $(document).ready(function() {
        $('.form-select').select2();
        $('.form-select').select2({dropdownAutoWidth : true});
        if($('#Id_moneda').val()==1) {
            $('#Tipo_cambio_dolar').hide();
            $('#Tipo_cambio_dolar').val(0);
        }

        $('#Id_moneda').select2().on('change', function(e) {
            var x = this.value;
            if (x==1) {
                    $("#Tipo_cambio_dolar").hide();
                    $("#Tipo_cambio_dolar").val(0);
                } else {
                    $("#Tipo_cambio_dolar").show();
                    $("#Tipo_cambio_dolar").val(3.85);
                }
        });

        $('#Igv_compra').select2().on('change', function(e) {
            var x = this.value;
            if (x==0) {
                $("#Total_compra").val($("#Sub_total_compra").val());
            } else {
                $("#Total_compra").val($("#Sub_total_compra").val()*1.18);
            }
        });

        $('.btn.btn-success').on('click', function() {
            setTimeout(function(){
                // alert(500);
                $('.form-select').select2();
            }, 500)
        });

        $('.btn.btn-default').on('click', function() {
            setTimeout(function(){
                // alert(500);
                $('.form-select').select2();
            }, 500)
        });
    });

    function redimensionaSelect2(){
        $('.form-select').select2({dropdownAutoWidth : true});
    }

    window.ajax = (_event) => {
    _event.preventDefault();

    let _form = _event.target.form;
    let _method = _form.method.toLowerCase();
    let _data = new FormData(_form);

    window.axios[_method](_form.action, _data, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
    })
    .then((response) => {
        window.notify.success(response.data.message);
    })
    .catch((error) => {
        window.notify.warning(error.response.data.message);

        for (var key in error.response.data.errors) {
            document.querySelector('input[name="'+key+'"]').classList.add('border-danger');
            window.notify.error(error.response.data.errors[key][0]);
        }
    });
}
</script>
@endpush
