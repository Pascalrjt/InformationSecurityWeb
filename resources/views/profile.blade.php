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
