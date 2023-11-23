
@extends('master')
@section('content')

<style>
    .message-text {
        text-align: left;
        padding: 10px;
        display: flex;
        align-items: center;
    }

    .accept-button-container {
        text-align: right;
        margin-top: 10px;
    }

    .message-card {
        margin-bottom: 5%;
    }
</style>

@if(Auth::check())
    <h1>Inbox</h1>
    <div class="row mx-5 justify-content-center">
        @foreach ($file_requests as $file_request)
            @if(Auth::id() == $file_request->requested_id)
                <div class="card mx-2 bg-dark text-white message-card" style="width: 90%; height: 50px">
                    <div class="message-text">
                        <p>{{ \App\Models\User::find($file_request->requester_id)->username }} has requested access to your files</p>
                    </div>
                    <div class="accept-button-container">
                        <button class="btn btn-primary accept-button">Accept request</button>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@else
    <p>You need to be logged in to view this page. Please <a href="/login">login</a>.</p>
@endif
@endsection
