@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Editar Salida #{{ $salida_productos->id }}</div>

                <div class="card-body">
                    <x-forms.SalidaProducto :salidaproducto="$salida_productos" />
                </div>
            </div>
        </div>


        <x-backend.card>
            <x-slot name="header">
                @lang("Detalle de Salida")
            </x-slot>
            <x-slot name="headerActions" :salida_producto="$salida_productos->id">
                <x-forms.SalidaProductoDetalle :salidaproducto="$salida_productos->id" />
            </x-slot>
            <x-slot name="body">
                <livewire:backend.salida-producto-detalles-table :salida_producto="$salida_productos->id">
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
    }

    function ready(callback){
        // in case the document is already rendered
        if (document.readyState!='loading') callback();
        // modern browsers
        else if (document.addEventListener) document.addEventListener('DOMContentLoaded', callback);
        // IE <= 8
        else document.attachEvent('onreadystatechange', function(){
            if (document.readyState=='complete') callback();
        });
    }

    ready(function(){
        $('.form-select').select2();
    });
</script>
