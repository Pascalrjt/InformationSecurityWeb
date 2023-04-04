@extends('master')
@section('content')

<main class="form-registration w-100 m-auto">
    <form action="/register" method="post">
    @csrf
      <center><img class="mb-4" src="/img/pethub-logo-dark.png" alt="" width="100" height="100"></center>
      <h1 class="h3 mb-3 fw-normal">Registration Form</h1>
        
      <div class="form-floating">
        <input type="text" name="name" class="form-control" @error('name') is-invalid @enderror id="name" placeholder="Saha Manh?" required>
        <label for="name">Name</label>
        @error('name')
            <div>
                {{ $message }}
            </div>
        @enderror
      </div>

      <div class="form-floating">
        <input type="text" name="username" class="form-control" @error('userusername') is-invalid @enderror id="username" placeholder="Username" required>
        <label for="username">Username</label>
        @error('username')
        <div>
            {{ $message }}
        </div>
    @enderror
      </div>

      <div class="form-floating">
        <input type="email" name="email" class="form-control" @error('email') is-invalid @enderror id="email" placeholder="name@example.com" required>
        <label for="email">Email address</label>
        @error('email')
        <div>
            {{ $message }}
        </div>
    @enderror
      </div>

      <div class="form-floating">
        <input type="password" name="password" class="form-control" @error('password') is-invalid @enderror id="password" placeholder="Password" required>
        <label for="password">Password</label>
        @error('password')
        <div>
            {{ $message }}
        </div>
    @enderror
      </div>
  
      <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
    </form>
    <small> <a href="/register">Register Now!</a> </small>
  </main>

@endsection