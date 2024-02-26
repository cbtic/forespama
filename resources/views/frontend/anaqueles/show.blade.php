@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $anaqueles->id }}</div>
                    <div class="card-body">
                            <div class="form-group row">
                                <label for="title" class="col-sm-4 col-form-label text-md-right">ID</label>

                                <div class="col-md-6">
                                    <p>{{ $anaqueles->id }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="title" class="col-sm-4 col-form-label text-md-right">Denominacion</label>

                                <div class="col-md-6">
                                    <p>{{ $anaqueles->codigo }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="title" class="col-sm-4 col-form-label text-md-right">Estado</label>

                                <div class="col-md-6">
                                    <p>{{ $anaqueles->estado }}</p>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <a href="{{ route('frontend.anaqueles.edit', $anaqueles->id) }}">Edit</a>
                                    <a href="#" onclick="event.preventDefault();document.getElementById('delete-form').submit();">
                                       Delete
                                    </a>

                                    <form id="delete-form" action="{{ route('frontend.anaqueles.destroy', $anaqueles->id) }}" method="POST" style="display: none;">
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
