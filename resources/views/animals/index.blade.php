@extends('master')
@section('content')

<style>
.centered-alert {
    position: absolute;
    top: 10%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 20px; /* Adjust this value to your liking */
    z-index: 9999;
}
</style>

    <h1>Data</h1>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show small-font centered-alert" role="alert">
                 {{ session('success') }} <br>  
                Animal name encrypted in: {{ session('animal_des_time_taken') }} ms (DES) <br>
            </div>
        @endif
    <div class="row mx-5 justify-content-center">
        @foreach ($animals as $item)
            <div class="card mx-2 bg-dark text-white animal-card" style="width: 300px;">
                <a href="/animals/{{$item->id}}">
                    @if ($item->image)
                        <div style="width: 100%; height: 300px; margin: 10px 0; position: relative;">
                            <!-- <img src="{{ asset('storage/' . $item->image) }}" alt="animal photo" style="width: 100%; height: 100%; object-fit: cover;"> -->
                            <img src="data:image/png;base64,{{ $item->image }}" alt="animal photo" style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="text-center" style="position: absolute; bottom: 0; width: 100%; padding: 10px; background-color: rgba(0, 0, 0, 0.6);">
                                <h5 class="mb-0 animal-name">{{$item->name}}</h5>
                            </div>
                        </div>
                    @else
                        <i class='fas fa-id-badge' style='font-size:180px'></i>
                    @endif
                </a>
            </div>
        @endforeach
    </div>
    @if (auth()->check() && auth()->user()->is_admin)
    <div class="d-flex mx-5 my-5 justify-content-center">
        <a href="/animals/create" class="btn btn-orange btn-info mx-5" style="width: 300px;">+Add Animals</a>
    </div>
    @endif
@endsection
