@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Crear una Entrada</div>

                    <div class="card-body">
                        <x-forms.EntradaProducto />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
