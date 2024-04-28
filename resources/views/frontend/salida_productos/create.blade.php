@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Crear una Salida</div>

                    <div class="card-body">
                        <x-forms.salidaproducto></x-forms.salidaproducto>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
