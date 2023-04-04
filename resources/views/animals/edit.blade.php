@extends('master')
@section('content')
    <h1>Edit Animal {{$animals->id}}</h1>
    <form action="/animals/{{$animals->id}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-12">
                <div class="card bg-dark text-white">
                    <div class="card-body bg-dark text-white">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control form-dark bg-dark color-dark text-white" name="name" value="{{$animals->name}}" placeholder="Enter Name">
                            @error('name')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Breed</label>
                            <input type="text" class="form-control form-dark bg-dark color-dark text-white" name="breed" value="{{$animals->breed}}" placeholder="Enter Breed">
                            @error('breed')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Age</label>
                            <input type="text" class="form-control form-dark bg-dark color-dark text-white" name="age" value="{{$animals->age}}" placeholder="Enter Age">
                            @error('age')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
        
                        <div class="form-group">
                            <label>Center</label>
                            <select class="form-select form-control form-dark bg-dark color-dark text-white" name="center_id">
                                <option value="">-</option>
                                @foreach ($centers as $temp)
                                <option value="{{$temp-> id}}"
                                    @if($temp->id == $animals->center->id)
                                    selected
                                    @endif
                                >{{$temp->name}}</option>    
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="formFile" class="form-label form-dark bg-dark color-dark text-white">Upload Image</label>
                            <input class="form-control form-dark bg-dark color-dark text-white" type="file" id="formFile">
                          </div>

                        <div class="d-flex justify-content-between">
                            <a href="./" class="btn btn-dark"><< Back</a>
                            <button type="submit" class="btn btn-orange" style="border-radius: 3px">
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