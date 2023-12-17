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
        height: 100vh;
    }
</style>

<main class="form-registration centered-content">
    <div class="card bg-hollow">
        <div class="card-body bg-hollow ">
            <form method="POST" action="{{ url('/digitalsignature/download') }}" enctype="multipart/form-data">
            @csrf
                <div class="mb-3">
                    <label for="formFile" class="form-label">Upload PDF</label>
                    <input class="form-control" name="file" type="file" id="formFile" accept=".pdf">
                </div>
                <input type="submit" class="btn btn-primary">
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </div>
</main>

@endsection
