@extends('master')
@section('content')
    <h1>{{$centers->name}} Details</h1>
    <div class="d-flex justify-content-center my-5">
        <div class="card col-sm-6 mx-3 w-50 p-5 bg-dark text-white">
            <div class="card-body d-flex justify-content-center">
                {{-- <i class='fas fa-id-badge' style='font-size:180px' class="mx-5"></i> --}}
                <i class="bi bi-house-door" style='font-size:180px' class="mx-5"></i>
                <div class="data m-4 align-items-center">
                    <h5>Name: {{$centers->name}}</h5>
                    <h5>Location: {{$centers->location}}</h5>
                    <h5>Telephone Numbers: {{$centers->telephone}}</h5>
                    <h5>Email: {{$centers->email}}</h5>
                </div>
            </div>
            
            <form action="/center/{{$centers->id}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('delete')
                <div class="d-flex justify-content-between">
                    <a href="/center" class="btn btn-dark mt-4 mx-2"><< Back</a>
                    @if (auth()->check() && auth()->user()->is_admin)
                        <div class="d-flex justify-content-end">
                            <a href="/center/{{$centers->id}}/edit" class="btn btn-orange btn-info mt-4 mx-2">Edit</a>
                            <input type="submit" class="btn btn-danger mt-4 mx-2" value="Delete">
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection