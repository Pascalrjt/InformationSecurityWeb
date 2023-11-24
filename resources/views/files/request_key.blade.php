@extends('master')

<style>
    .form-dark {
        background-color: #1a1a1a;
        color: #f2f2f2;
        border-color: darkslategrey;
    }
</style>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-dark">
                <div class="card-header">Enter Private Key</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('files.decryptWithKey', ['file' => $file->id]) }}" class="form-dark">
                        @csrf
                        <div class="form-group row">
                            <label for="private_key" class="col-md-4 col-form-label text-md-right">Private Key</label>

                            <div class="col-md-6">
                                <input id="private_key" type="text" class="form-control @error('private_key') is-invalid @enderror" name="private_key" required autofocus>

                                @error('private_key')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4 mx-auto">
                                <button type="submit" class="btn btn-primary">
                                    Download File
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
