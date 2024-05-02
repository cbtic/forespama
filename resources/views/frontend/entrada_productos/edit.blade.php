@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Editar Entrada #{{ $entrada_productos->id }}</div>

                <div class="card-body">
                    <x-forms.entradaproducto :entradaproductos="$entrada_productos"></x-forms.entradaproducto>
                </div>
            </div>
        </div>


        <x-backend.card>
            <x-slot name="header">
                @lang("Detalle de Entrada")
            </x-slot>
            <x-slot name="headerActions" :entrada_producto="$entrada_productos->id">
                <x-forms.entradaproductodetalle :entradaproducto="$entrada_productos->id"></x-forms.entradaproductodetalle>
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
    }
</script>
@endpush
