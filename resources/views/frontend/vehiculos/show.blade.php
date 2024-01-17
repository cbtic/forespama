@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $vehiculo->title }}</div>
                    <div class="card-body">
                            <div class="form-group row">
                                <label for="title" class="col-sm-4 col-form-label text-md-right">ID</label>

                                <div class="col-md-6">
                                    <p>{{ $vehiculo->id }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="title" class="col-sm-4 col-form-label text-md-right">Licencia</label>

                                <div class="col-md-6">
                                    <p>{{ $vehiculo->placa }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="title" class="col-sm-4 col-form-label text-md-right">Fecha Emision</label>

                                <div class="col-md-6">
                                    <p>{{ $vehiculo->ejes }}</p>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <a href="{{ route('frontend.vehiculos.edit', $vehiculo->id) }}">Edit</a>
                                    <a href="#" onclick="event.preventDefault();document.getElementById('delete-form').submit();">
                                       Delete
                                    </a>

                                    <form id="delete-form" action="{{ route('frontend.vehiculos.destroy', $vehiculo->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
