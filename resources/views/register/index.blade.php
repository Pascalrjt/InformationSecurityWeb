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

<main class="form-registration centered-content">
    <div class="card bg-hollow">
        <div class="card-body bg-hollow ">
            <form action="/register" method="post" enctype="multipart/form-data">
            @csrf
              <h1 class="fw-normal">Registration Form</h1>
                
              <div class="form-floating mb-3">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" @error('name') is-invalid @enderror id="name" placeholder="le name?" required>
                @error('name')
                    <div>
                        {{ $message }}
                    </div>
                @enderror
              </div>

              <div class="form-floating mb-3">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" @error('userusername') is-invalid @enderror id="username" placeholder="Username" required>
                @error('username')
                <div>
                    {{ $message }}
                </div>
            @enderror
              </div>

              <div class="form-floating mb-3">
                <label for="email">Email address</label>
                <input type="email" name="email" class="form-control" @error('email') is-invalid @enderror id="email" placeholder="name@example.com" required>
                @error('email')
                <div>
                    {{ $message }}
                </div>
            @enderror
              </div>

              <div class="form-floating mb-3">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" @error('password') is-invalid @enderror id="password" placeholder="Password" required>
                @error('password')
                <div>
                    {{ $message }}
                </div>
            @enderror
              </div>
              <div class="mb-3">
                  <label for="idcard" class="form-label form-dark bg-dark color-dark text-white">Upload Image of ID Card</label>
                  <input class="btn-dark form-control form-dark bg-dark color-dark text-white" type="file" id="image" name="image">
                  @error('image')
                  <div class="alert alert-danger">
                      {{ $message }}
                  </div>
              @enderror
              </div>
          
              <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
            </form>
            <small> Already have an account? <a href="/login">Login</a> </small>
        </div>
    </div>
</main>

@endsection