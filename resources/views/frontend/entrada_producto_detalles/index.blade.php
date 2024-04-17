@extends('backend.layouts.app')

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang("Detalle de Entrada de Productos #$entrada_producto")
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link
                icon="c-icon cil-plus"
                class="card-header-action"
                :href="route('frontend.entrada_producto_detalles.create')"
                :text="__('Nuevo')"
            />
        </x-slot>

        <x-slot name="body">
            <livewire:backend.entrada-producto-detalles-table :entrada_producto="$entrada_producto"/>
        </x-slot>
    </x-backend.card>
@endsection
