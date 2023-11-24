
@extends('master')
@section('content')

<style>
    .message-text {
        text-align: left;
        padding: 10px 20px;
        /* display: flex; */
        align-items: center;
        justify-content: space-between;
    }

    .accept-button-container {
        text-align: right;
    }

    .message-card {
        margin-bottom: 15px;
        display: flex;
        width: 95%;

    }
</style>

@if(Auth::check())
    <h1>Inbox</h1>
    <div class="row mx-5 justify-content-center">
        @foreach ($file_requests as $file_request)
            <div class="card mx-2 bg-dark text-white message-card">
                <div class="message-text">
                    @if($file_request->has_access)
                        @if($file_request->requester_id === Auth::id())
                            <div>
                                <p>{{ \App\Models\User::find($file_request->requested_id)->username }} has accepted your request. </p>
                            </div>
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
            <div class="card mx-2 bg-dark text-white message-card">
                <div class="message-text">
                    <p>Private Keys:</p>
                    @foreach ($files->where('fileOwner', auth()->id())->where('isDuplicate', true) as $file)
                        @php
                            $cipher = "AES-256-CBC";
                            $options = 0;
                            $iv = $file->iv;
                            $decryptedSecret = openssl_decrypt($file->secret, $cipher, env('AES_KEY_KEY'), $options, $file->iv);
                        @endphp
                        <p>- Here is the private key for {{$file->filename}}:   {{ $decryptedSecret }}</p>
                    @endforeach
                </div>
            </div>
    </div>
@else
    <p>You need to be logged in to view this page. Please <a href="/login">login</a>.</p>
@endif

@endsection
