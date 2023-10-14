@extends('master')
@section('content')

<style>
    .profile {
        padding-right: 40px
    }
</style>

    <div class="container">
        <h1>{{ $username }}</h1>
        <p>{{ Auth::user()->email }}</p>
        <p>{{ Auth::user()->bio }}</p>
        <div>
            <h2>ID Image</h2>
            <div>
                <img src="data:image/png;base64,{{ Auth::user()->image }}" alt="User Image"  style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
        <div class="profile">
            <ul>
                @foreach ($adoptionPlans as $adoptionPlan)
                    <h5>Animal Name: {{ $adoptionPlan->animal->name }}</h5>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
