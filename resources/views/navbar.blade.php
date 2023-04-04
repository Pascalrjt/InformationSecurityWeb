<div class="bg-orange text-white py-2">
    <div class="d-flex justify-content-between mx-5">
        <h3>
            <img src="img/pethub-logo-orange.png" alt="" class="mr-2" style="width: 32px; height: 32px;">
            Pethub Adoption
        </h3>
        <div class="d-flex justify-content-start align-items-center">
            <h5 class="mx-2">
                <a href="/">Home</a>
            </h5>
            <h5 class="mx-2">
                <a href="/animals">Animals</a>
            </h5>
            <h5 class="mx-2">
                <a href="/center">Centers</a>
            </h5>
            @auth
            <h5><a href="{{ route('profile') }}">Profile</a></h5>
            <h4 class="mx-2"> <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
          </h4>
          <form action="/logout" method="post">
            @csrf
            <button typle="submit" class="btn btn-link">Logout</button>
        </form>
            @else
                <h5 class="mx-2">
                    <a href="/login"><i class="bi bi-box-arrow-in-right"></i> Log in</a>
                </h5>
            @endauth
        </div>
    </div>
</div>
{{-- 
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Dropdown
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav> --}}