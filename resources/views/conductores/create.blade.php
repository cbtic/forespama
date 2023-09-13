@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Conductore</div>

                    <div class="card-body">
                        <x-form>
                                <x-form-input name="licencia" label="Licencia" />
                                <x-form-input name="name" label="Persona" />
                                <x-form-select name="estado" :options="$options" label="Estado" />

                                <x-form-submit>
                                    <span class="text-green-500">Grabar</span>
                                </x-form-submit>
                        </x-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
