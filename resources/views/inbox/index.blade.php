
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
            <div class="card mx-2 bg-dark text-white message-card" style="width: 90%; height: 50px">
                <div class="message-text">
                    @if($file_request->has_access)
                        @if($file_request->requester_id === Auth::id())
                            <p>{{ \App\Models\User::find($file_request->requested_id)->username }} has accepted your request</p>
                        @elseif($file_request->requested_id === Auth::id())
                            <p>You have accepted {{ \App\Models\User::find($file_request->requester_id)->username }}'s request</p>
                        @else
                            <p>You dont have access to this request</p>
                        @endif
                    @else
                    @if($file_request->requester_id === Auth::id() || $file_request->requested_id === Auth::id())
                        <p>{{ \App\Models\User::find($file_request->requester_id)->username }} has requested access to your files</p>
                        @if($file_request->requested_id === Auth::id())
                            <div class="accept-button-container">
                                <form method="POST" action="{{ route('filerequests.update', $file_request->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-primary accept-button">Accept request</button>
                                </form>
                            </div>
                    @endif
                    @else
                            <p>You dont have access to this request</p>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@else
    <p>You need to be logged in to view this page. Please <a href="/login">login</a>.</p>
@endif

@endsection