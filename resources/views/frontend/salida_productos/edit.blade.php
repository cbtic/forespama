@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Editar Salida #{{ $salida_productos->id }}</div>

                <div class="card-body">
                    <x-forms.salidaproducto :salidaproducto="$salida_productos"></x-forms.salidaproducto>
                </div>
            </div>
        </div>


        <x-backend.card>
            <x-slot name="header">
                @lang("Detalle de Salida")
            </x-slot>
            <x-slot name="headerActions" :salida_producto="$salida_productos->id">
                <x-forms.salidaproductodetalle :salidaproducto="$salida_productos->id"></x-forms.salidaproductodetalle>
            </x-slot>
            <x-slot name="body">
                <livewire:backend.salida-producto-detalles-table :salida_producto="$salida_productos->id">
            </x-slot>
        </x-backend.card>
    </div>
</div>
@endsection
