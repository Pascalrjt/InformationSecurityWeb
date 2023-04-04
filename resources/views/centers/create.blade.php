@extends('master')
@section('content')
    <h1>Add Center</h1>
    <form action="/center" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card bg-dark text-white">
                    <div class="card-body bg-dark text-white">
                        <div class="form-group">
                            <label>Center Name</label>
                            <input type="text" class="form-control form-dark bg-dark color-dark text-white" name="name" placeholder="Enter Name">
                            @error('name')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group bg-dark text-white">
                            <label>Location</label>
                            <input type="text" class="form-control form-dark bg-dark color-dark text-white" name="location" placeholder="Enter the center location">
                            @error('location')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group bg-dark text-white">
                            <label>Telephone Numbers</label>
                            <input type="text" class="form-control form-dark bg-dark color-dark text-white" name="telephone" placeholder="Enter the center telephone numbers">
                            @error('telephone')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group bg-dark text-white">
                            <label>Email</label>
                            <input type="text" class="form-control form-dark bg-dark color-dark text-white" name="email" placeholder="Enter the center email">
                            @error('email')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="./" class="btn btn-dark bg-dark text-white"><< Back</a>
                            <button type="submit" class="btn btn-dark bg-dark" style="border-radius: 3px">
                                <i class="nav-icon fas fa-plus-circle"></i>
                                Add Center
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection