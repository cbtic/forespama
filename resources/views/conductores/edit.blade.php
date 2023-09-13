@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Conductore</div>

                    <div class="card-body">
                        <x-form>
                            @bind($conductore)
                                <x-form-input name="licencia" label="Licencia" />
                                @bind($persona)
                                    <x-form-input name="name" label="Persona" />
                                @endbind
                                <x-form-select name="estado" :options="$options" label="Estado" />

                                <x-form-submit />
                            @endbind
                        </x-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
