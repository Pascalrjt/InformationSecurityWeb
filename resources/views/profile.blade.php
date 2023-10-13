@extends('master')

@section('content')
    <div class="container">
        <h1>{{ $username }}</h1>
        <p>{{ Auth::user()->email }}</p>
        <p>{{ Auth::user()->bio }}</p>
        <div>
            <h2>ID Image</h2>
            <ul>
                @foreach ($adoptionPlans as $adoptionPlan)
                    <h5>Animal Name: {{ $adoptionPlan->animal->name }}</h5>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
