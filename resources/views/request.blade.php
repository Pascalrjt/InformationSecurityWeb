@extends('master')
@section('content')
    <div>
        @if(isset($requestedUser))
            <p>User {{ auth()->user()->id }} has requested your file!</p>
            <p>User Details:</p>
            <ul>
                <li>Name: {{ $requestedUser->name }}</li>
                <li>Email: {{ $requestedUser->email }}</li>
                <!-- Display any other relevant user information -->
            </ul>
            <!-- You can include a button or link here to handle further actions -->
        @else
            <p>No request information available.</p>
        @endif
    </div>
@endsection
