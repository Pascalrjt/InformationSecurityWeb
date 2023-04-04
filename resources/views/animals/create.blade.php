@extends('master')
@section('content')
    <h1>Add Animal</h1>
    <form action="/animals" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card bg-dark text-white">
                    <div class="card-body bg-dark text-white">
                        <div class="form-group form-dark bg-dark color-dark text-white">
                            <label>Name</label>
                            <input type="text" class="form-control form-dark bg-dark color-dark text-white" name="name" placeholder="Enter Name">
                            @error('name')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Breed</label>
                            <input type="text" class="form-control form-dark bg-dark color-dark text-white" name="breed" placeholder="Enter breed">
                            @error('breed')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Age</label>
                            <input type="text" class="form-control form-dark bg-dark color-dark text-white" name="age" placeholder="Enter age">
                            @error('age')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control form-dark bg-dark color-dark text-white" name="desc" placeholder="Enter necessary description">
                            @error('desc')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
        
                        <div class="form-group">
                            <label>Center</label>
                            <select class="form-select form-control form-dark bg-dark color-dark text-white" name="center_id">
                                <option selected value="">-</option>
                                @foreach ($centers as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label form-dark bg-dark color-dark text-white">Upload Image</label>
                            <input class="btn-dark form-control form-dark bg-dark color-dark text-white" type="file" id="image" name="image">
                            @error('image')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="./" class="btn btn-dark bg-dark text-white"><< Back</a>
                            <button type="submit" class="btn btn-dark bg-dark" style="border-radius: 3px">
                                <i class="nav-icon fas fa-plus-circle"></i>
                                Add Animal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection