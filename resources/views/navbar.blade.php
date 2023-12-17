@php
    use Illuminate\Support\Facades\Auth;
@endphp

<style>
  .bg-black {
    background-color: #1a1a1a;
  }

  .bg-hollow {
    background-color: #141516;
  }
</style>

<div class="bg-hollow text-white py-2">
    <div class="d-flex justify-content-between mx-5">
        <h3 class="navbarText">
          <a href="/">Home</a>
        </h3>
        <div class="d-flex justify-content-start align-items-center navbarText">
            <h5 class="mx-2">
                <a href="/">Home</a>
            </h5>
            <h5 class="mx-2">
                <a href="/animals">Animals</a>
            </h5>
            <h5 class="mx-2">
                <a href="/center">Centers</a>
            </h5>
            <h5 class="mx-2">
                <a href="/users">Users</a>
            </h5>
            <h5 class="mx-2">
                <a href="/files">Files</a>
            </h5>
            <h5 class="mx-2">
                <a href="/inbox">Inbox</a>
            </h5>
            @auth
            <h5 class="mx-2">
                <a href="/digitalsignature">Signature</a>
            </h5>
            <h5><a href="{{ route('profile') }}">Profile</a></h5>
            <h4 class="mx-2"> <i class="bi bi-person-circle"></i> {{ $username }} </h4>
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

