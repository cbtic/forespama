@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Lote #{{ $lotes->id }}</div>

                <div class="card-body">
                    <x-forms.almacene :lotes="$lotes"></x-forms.almacene>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

