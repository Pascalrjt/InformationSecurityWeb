@extends('master')

@section('content')
    <h1>Uploaded Files</h1>

    @if (auth()->check() && auth()->user()->is_admin)
        <div class="d-flex mx-5 my-5 justify-content-center">
            <a href="/files/create" class="btn btn-orange btn-info mx-5" style="max-width: 18rem;">+Add Files</a>
            <a href="/files/download" class="btn btn-orange btn-info mx-5" style="max-width: 18rem;">Download Files</a>
        </div>
    @endif
@endsection
