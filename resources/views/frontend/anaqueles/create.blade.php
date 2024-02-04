@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Crear Anaquel</div>

                    <div class="card-body">
                        <x-forms.anaquel></x-forms.anaquel>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
