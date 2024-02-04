@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Almacen #{{ $almacenes->id }}</div>

                <div class="card-body">
                    <x-forms.almacenes :almacenes="$almacenes"></x-forms.almacenes>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
