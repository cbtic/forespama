@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Entrada #{{ $entrada_productos->id }}</div>

                <div class="card-body">
                    <x-forms.entradaproducto :entradaproductos="$entrada_productos"></x-forms.entradaproducto>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
