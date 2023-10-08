@extends('master')
@section('content')

<style>
  .bg-black {
    background-color: #1a1a1a;
  }

  .bg-hollow {
    background-color: #141516;
  }

  .centered-content {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* This makes sure it takes the full height of the viewport */
  }
</style>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
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

      <div class="card bg-hollow">
        <div class="card-header text-center bg-black text-white bg-hollow">
          <h1 class="h3 mt-3">Please sign in</h1>
        </div>
        <div class="card-body bg-hollow">
          <form action="/login" method="post">
            @csrf

            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" autofocus required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
            </div>

            <button class="btn btn-primary w-100" type="submit">Sign in</button>
          </form>
        </div>
        <div class="card-footer text-center">
          <small class="text-muted">Don't have an account? <a href="/register">Register Now!</a></small>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
