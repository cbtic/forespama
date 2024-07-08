@extends('backend.layouts.app')

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Productos')
        </x-slot>

        <x-slot name="headerActions">
            <x-forms.Producto />
        </x-slot>

        <x-slot name="body">
            <livewire:backend.productos-table />
        </x-slot>
    </x-backend.card>
@endsection
