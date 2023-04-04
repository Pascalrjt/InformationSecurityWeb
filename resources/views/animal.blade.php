@extends('master')
@section('content')
    <h1>Tambah Camin</h1>
    <form action="/animals" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Name">
                            @error('name')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Breed</label>
                            <input type="text" class="form-control" name="breed" placeholder="Enter Breed">
                            @error('breed')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Age</label>
                            <input type="text" class="form-control" name="age" placeholder="Enter Age">
                            @error('age')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
        
                        <div class="form-group">
                            <label>Center</label>
                            <select class="form-select form-control" name="center_id">
                                <option selected value="">-</option>
                                @foreach ($centers as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="./" class="btn btn-light"><< Back</a>
                            <button type="submit" class="btn btn-primary" style="border-radius: 3px">
                                <i class="nav-icon fas fa-plus-circle"></i>
                                Add Animals
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection