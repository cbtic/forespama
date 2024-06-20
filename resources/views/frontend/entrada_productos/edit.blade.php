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
<script>
    function rowclick(td){
        let rowId = td.parentElement.rowIndex;
        document.getElementsByClassName("btn btn-success")[rowId-1].click();
        setTimeout(function(){
            redimensionaSelect2();
        }, 500);
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

    $(document).ready(function() {
        $('.form-select').select2();
        $('.form-select').select2({dropdownAutoWidth : true});
        if($('#Id_moneda').val()==1) {
            $('#Tipo_cambio_dolar').hide();
            $('#Tipo_cambio_dolar').val(0);
        }
    });

    $(".btn.btn-success").click(setTimeout(function(){
        redimensionaSelect2();
    }, 500));

    $(".btn.btn-default").click(setTimeout(function(){
        redimensionaSelect2();
    }, 500));

    function redimensionaSelect2(){
        $('.form-select').select2({dropdownAutoWidth : true});
    }

</script>
@endpush
