@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Editar Almacen #{{ $almacenes->id }}</div>

                <div class="card-body">
                    <x-forms.almacene :almacenes="$almacenes"></x-forms.almacene>
                </div>
            </div>
        </div>

        <x-backend.card>
            <x-slot name="header">
                @lang("Detalle de Secciones")
            </x-slot>
            <x-slot name="headerActions" :id_almacenes="$almacenes->id">
                <x-forms.Seccione :id_almacenes="$almacenes->id" />
            </x-slot>
            <x-slot name="body">
                <livewire:backend.secciones-table :id_almacenes="$almacenes->id">
            </x-slot>
        </x-backend.card>
    </div>
</div>
@endsection

@push('after-scripts')
<script type="text/javascript" src="{{ asset('js/almacenes.js') }}"></script>
<script>

$('.btn.btn-default').on('click', function() {
            setTimeout(function(){
                // alert(500);
                $('.form-select').select2();
            }, 500)
        });

</script>
@endpush
