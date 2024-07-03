@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Entrada Detalle #{{ $entrada_producto_detalles->id }}</div>

                <div class="card-body">
                    <x-forms.entradaproductodetalle :entradaproductodetalles="$entrada_producto_detalles"></x-forms.entradaproductodetalle>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
