@extends('layouts.auth.main')

@section('title', 'Masuk')

@section('content')
<!-- Hero Start -->
<section class="bg-home bg-primary d-flex align-items-center">
    <div class="bg-overlay bg-overlay-white"></div>
    <div class="container mt-4 mb-4">
        <div class="row">
            <div class="col-12">
                <div class="card form-signin p-4 rounded shadow">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <a href="{{ url('/') }}"><img src="{{ asset('default/logo-transparent.png') }}" class="mb-4 d-block mx-auto" height="80" alt="logo"></a>
                        <h5 class="mb-3 text-center">Silahkan masuk</h5>

                        <div class="form-floating mb-2">
                            <input type="email" class="form-control @error('email') is-invalid @enderror"  name="email" id="floatingInput" placeholder="nama@gmail.com" value="{{ old('email') }}" autocomplete="email">
                            <label for="floatingInput">Email</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="floatingPassword" placeholder="Kata Sandi">
                            <label for="floatingPassword">Kata Sandi</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="flexCheckDefault" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexCheckDefault">Ingat saya</label>
                                </div>
                            </div>
                            <p class="forgot-pass mb-0"><a href="{{ route('password.request') }}" class="text-dark small fw-bold">Lupa kata sandi ?</a></p>
                        </div>

                        <button class="btn btn-primary w-100" type="submit">Masuk</button>

                        <p class="mb-0 text-muted mt-3 text-center">© <script>document.write(new Date().getFullYear())</script> Aplikasi Diet.</p>
                    </form>
                </div>
            </div>
        </div>
    </div> <!--end container-->
</section><!--end section-->
<!-- Hero End -->
@endsection
