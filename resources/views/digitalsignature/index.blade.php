@extends('master')

@section('content')
    @auth
        <h1>Add Digital Signature to your PDF</h1>

        <div class="row mx-5 justify-content-center">
        </div>

        @if (auth()->user()->is_admin)
            <div class="d-flex mx-5 my-5 justify-content-center">
                <a href="/digitalsignature/create" class="btn btn-primary btn-info mx-5" style="max-width: 18rem;">+Add PDF</a>
            </div>
        @endif
    @else
        <p>You need to be logged in to view this page. Please <a href="/login">login</a>.</p>
    @endauth
@endsection
