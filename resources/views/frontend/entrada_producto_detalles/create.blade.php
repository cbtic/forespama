@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Crear un Detalle de Entrada #<?= $entrada_producto ?></div>

                    <div class="card-body">
                        <x-forms.entradaproductodetalle :entrada_producto="$entrada_producto"></x-forms.entradaproductodetalle>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
