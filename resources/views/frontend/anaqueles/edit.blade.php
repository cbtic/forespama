@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Anaquel #{{ $anaquel->id }}</div>

                <div class="card-body">
                    <x-forms.vehiculo :anaqueles="$anaqueles"></x-forms.vehiculo>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
