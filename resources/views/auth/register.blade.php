@extends('layouts.guest')
@section('title', 'تسجيل')
@section('content')
    <div>
        <div>
            <a class="logo" href="/">
                <img class="img-fluid mx-auto for-dark" src={{asset("assets/images/logo/logo_dark.png")}} alt="looginpage">
            </a>
        </div>
        <div class="login-main">
            <form method="POST" class="theme-form" action="{{ route('register') }}">
                @csrf
                <h4>Create your account</h4>
                <p>Enter your personal details to create account</p>
                <div class="form-group">
                    <label class="col-form-label pt-0">Your Name</label>
                    <input class="form-control @error('name') is-invalid @enderror" name="name" type="text" placeholder="Full Name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label pt-0">Your UserName</label>
                    <input class="form-control @error('username') is-invalid @enderror" name="username" type="text" placeholder="Your UserName">
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label">Email Address</label>
                    <input class="form-control @error('email') is-invalid @enderror" name="email" type="email" placeholder="Your Email Here">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label">Password</label>
                    <input class="form-control @error('password') is-invalid @enderror" name="password" type="password" placeholder="*********">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation" required placeholder="Write The Password Again">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block w-100" type="submit">Create Account</button>
                </div>
                <h6 class="text-muted text-center text-decoration-underline mt-4 or">Or Sign up with</h6>
                <div class="social mt-4 text-center">
                    <div class="btn-showcase">
                        <a class="btn btn-light" href="https://twitter.com/login?lang=en" target="_blank">
                            <i class="txt-twitter" data-feather="twitter"></i>
                            Google
                        </a>
                        <a class="btn btn-light" href="https://www.facebook.com/" target="_blank">
                            <i class="txt-fb" data-feather="facebook"></i>
                            facebook
                        </a>
                    </div>
                </div>
                <p class="mt-4 mb-0 text-center">
                    Already have account?
                    <a class="ms-2" href={{route('login')}}>Sign in</a>
                </p>
            </form>
        </div>
    </div>
@endsection
