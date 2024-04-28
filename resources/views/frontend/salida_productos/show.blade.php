@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Ver Entrada #{{ $entrada_productos->id }}</div>

                <div class="card-body">
                    <x-forms.entradaproducto :entradaproductos="$entrada_productos"></x-forms.entradaproducto>
                </div>
            </div>
        </div>

        <x-backend.card>
            <x-slot name="body">
                <livewire:backend.entrada-producto-detalles-table :entrada_producto="$entrada_productos->id"/>
            </x-slot>
        </x-backend.card>
    </div>
</div>
@endsection

@push('after-scripts')
<script>
    var form = document.forms[1];

    [].slice.call( form.elements ).forEach(function(item){
      item.disabled = !item.disabled;
    });

    $(".btn.btn-secondary").hide();
    $(".btn.btn-primary").hide();

    $(".form-select").chosen();
</script>
@endpush
