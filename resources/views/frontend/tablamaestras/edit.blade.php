@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Tabla #{{ $tablamaestras->id }}</div>

                <div class="card-body">
                    <x-forms.tablamaestra :tablamaestras="$tablamaestras"></x-forms.tablamaestra>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
