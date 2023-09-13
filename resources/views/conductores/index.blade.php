@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4">All Conductore</h1>
            </div>
        </div>

        <div class="list-group">
            @foreach($conductores as $conductore)
                <a href="{{ route('conductores.show', $conductore->id) }}"
                   class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $conductore->title }}</h5>
                        <small>{{ $conductore->created_at->diffForHumans() }}</small>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-2">
            <nav aria-label="Page navigation example">
                {{ $conductores->links() }}
            </nav>
        </div>
    </div>
@endsection
