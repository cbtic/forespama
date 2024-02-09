@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Crear Almacenes</div>

                    <div class="card-body">
                        <x-forms.almacene></x-forms.almacene>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
<script type="text/javascript" src="{{ asset('js/almacenes.js') }}"></script>
@endpush
