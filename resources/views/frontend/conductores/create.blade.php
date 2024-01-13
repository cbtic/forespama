@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Crear Conductores</div>

                    <div class="card-body">
                        <x-forms.conductores :data='$conductor'></x-forms.conductores>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
<script type="text/javascript" src="{{ asset('js/autocompletePersona.js') }}"></script>
@endpush
