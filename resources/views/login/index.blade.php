@extends('master')
@section('content')

<main class="form-signin w-100 m-auto">
  @if (session()->has('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
      </div>
  @endif  
  @if (session()->has('fail'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('fail') }}
      </div>
  @endif    
  <center><img class="mb-4" src="/img/pethub-logo-dark.png" alt="" width="100" height="100"></center>
  <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
    <form action="/login" method="post">
      @csrf
  
      <div class="form-floating">
        <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" autofocus required>
        <label for="email">Email address</label>
      </div>
      <div class="form-floating">
        <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
        <label for="password">Password</label>
      </div>
  
      <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
    </form>
    <small> <a href="/register">Register Now!</a> </small>
  </main>

@endsection