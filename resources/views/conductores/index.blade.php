@extends('backend.layouts.app')

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Coductores')
        </x-slot>

        <x-slot name="headerActions">
        </x-slot>

        <x-slot name="body">
            <livewire:backend.conductores-table />
        </x-slot>
    </x-backend.card>
@endsection
