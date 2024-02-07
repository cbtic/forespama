@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Crear Una Seccion dentro del Almacen</div>

                    <div class="card-body">
                        <x-forms.seccione></x-forms.seccione>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
