@extends('backend.layouts.modal')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Crear un Producto</div>

                    <div class="card-body">
                        <x-forms.producto :modal="$modal"></x-forms.producto>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
