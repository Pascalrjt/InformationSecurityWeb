@extends('master')
@section('content')
    <h1>Edit Center {{$centers->id}}</h1>
    <form action="/center/{{$centers->id}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{$centers->name}}" placeholder="Enter Name">
                            @error('name')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" class="form-control" name="location" value="{{$centers->location}}" placeholder="Enter NRP">
                            @error('location')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="./" class="btn btn-light"><< Back</a>
                            <button type="submit" class="btn btn-primary" style="border-radius: 3px">
                                <i class="nav-icon fas fa-save"></i>
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection