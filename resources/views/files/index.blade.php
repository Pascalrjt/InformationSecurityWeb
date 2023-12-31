@extends('master')

@section('content')
    @auth
        <h1>Uploaded Files</h1>

        <div class="row mx-5 justify-content-center">
            @foreach ($files->where('fileOwner', auth()->id()) as $file)
                <div class="card mx-2 bg-dark text-white user-card" style="width: 400px; height: 100px;">
                    <div class="text-center" style="width: 100%; height: 300px; margin: 10px 0; position: relative;">
                        {{-- <img src="{{ $file->url }}" alt="File Image" style="width: 100%; height: 100%; object-fit: cover;"> --}}
                        <h5 class="mb-0 file-name">{{ $file->filename }}</h5>
                        <a href="{{ route('files.download', ['id' => $file->id]) }}" class="btn btn-primary mt-2">Download</a>
                    </div>
                </div>
            @endforeach
        </div>

        @if (auth()->user()->is_admin)
            <div class="d-flex mx-5 my-5 justify-content-center">
                <a href="/files/create" class="btn btn-primary btn-info mx-5" style="max-width: 18rem;">+Add File</a>
            </div>
        @endif
    @else
        <p>You need to be logged in to view this page. Please <a href="/login">login</a>.</p>
    @endauth
@endsection
