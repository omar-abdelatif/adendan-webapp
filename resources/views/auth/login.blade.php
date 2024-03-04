@extends('layouts.guest')
@section('title', 'تسجيل دخول')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="text-white">تسجيل دخول</h3>
                    </div>
                    <div class="card-body login-main w-100">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="email" class="col-form-label text-white">البريد الإلكتروني:</label>
                                    <input id="email" type="email" placeholder="البريد الإلكتروني" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label for="password" class="col-form-label text-white">كلمة السر:</label>
                                    <input id="password" type="password" placeholder="كلمة السر" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 text-center">
                                    <div class="form-group my-2">
                                        <div class="checkbox p-0">
                                            <input id="checkbox1" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="text-muted" for="checkbox1">تذكرني</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-50 py-2 rounded-pill">
                                        تسجيل دخول
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
