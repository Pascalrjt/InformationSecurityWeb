@extends('master')
@section('content')
    <h1>{{$animals->name}}'s Profile</h1>
    <div class="d-flex justify-content-center my-5">
        <div class="card col-sm-6 mx-3 w-50 p-5 bg-dark text-white">
            <div class="card-body d-flex justify-content-center">
                @if ($animals->image)
                    <style>
                        .resize{
                            width:40%;
                            height:360px;
                        }
                        img {
                            width:100%;
                            height:100%;
                            object-fit:cover;
                        }
                    </style>
                    <div class = "resize">
                        <img src="{{ asset('storage/' . $animals->image) }}" alt="animal photo">
                    </div>
                @else
                    <i class='fas fa-id-badge' style='font-size:180px' class="mx-5"></i>
                @endif
                {{-- <i class='fas fa-id-badge' style='font-size:180px' class="mx-5"></i> --}}
                <div class="data m-4 align-items-center">
                    <h5>Name: {{$animals->name}}</h5>
                    <h5>Breed: {{$animals->breed}}</h5>
                    <h5>Age: {{$animals->age}}</h5>
                    @if ($animals->center)
                    <h5>Center: {{$animals->center->name}}</h5>
                    @endif
                    <h5>Description: <br>
                        <h6>{{ $animals->desc}}</h6>
                    </h5>
                    @if($animals->center)
                    <h5>
                        <a href="/center/{{ $animals->center->id }}">
                            Visit {{ $animals->name }}'s Center!
                        </a>
                    </h5>
                    @endif
                </div>
            </div>

            <form action="/animals/{{$animals->id}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('delete')
                <div class="d-flex justify-content-between">
                    <a href="/animals" class="btn btn-dark mt-4 mx-2"><< Back</a>
                    @if (auth()->check() && auth()->user()->is_admin)
                        <div class="d-flex justify-content-end">
                            <a href="/animals/{{$animals->id}}/edit" class="btn btn-orange btn-info mt-4 mx-2">Edit</a>
                            <input type="submit" class="btn btn-danger mt-4 mx-2" value="Delete">
                        </div>
                    @endif
                </div>
            </form>

            <form action="{{ route('adoptionplan.store', $animals) }}" method="POST">
                @csrf
                <div class="d-flex justify-content-end">
                    <input type="submit" class="btn btn-danger mt-4 mx-2" value="Adopt Me">
                </div>
            </form>
        </div>
    </div>
@endsection