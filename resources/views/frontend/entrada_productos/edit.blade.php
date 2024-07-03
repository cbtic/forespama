@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Editar Entrada #{{ $entrada_productos->id }}</div>

                <div class="card-body">
                    <x-forms.entradaproducto :entradaproductos="$entrada_productos"></x-forms.entradaproducto>
                </div>
            </div>
        </div>


        <x-backend.card>
            <x-slot name="header">
                @lang("Detalle de Entrada")
            </x-slot>
            <x-slot name="headerActions">
                <x-utils.link
                    icon="c-icon cil-plus"
                    class="card-header-action"
                    :href="route('frontend.entrada_producto_detalles.create', $entrada_productos->id)"
                    :text="__('Nuevo #'.$entrada_productos->id)"
                />
            </x-slot>
            <x-slot name="body">
                <livewire:backend.entrada-producto-detalles-table :entrada_producto="$entrada_productos->id"/>
            </x-slot>
        </x-backend.card>
    </div>
</div>
@endsection
