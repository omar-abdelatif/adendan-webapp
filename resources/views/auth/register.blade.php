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
                <div class="form-group">
                    <label class="col-form-label pt-0">الإسم بالكامل</label>
                    <input class="form-control @error('name') is-invalid @enderror" name="name" type="text" placeholder="الإسم بالكامل" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label">البريد الإلكتروني</label>
                    <input class="form-control @error('email') is-invalid @enderror" name="email" type="email" placeholder="البريد الإلكتروني">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label">كلمة السر</label>
                    <input class="form-control @error('password') is-invalid @enderror" name="password" type="password" placeholder="كلمة السر">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label">تأكيد كلمة السر</label>
                    <input type="password" class="form-control" name="password_confirmation" required placeholder="تأكيد كلمة السر">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block w-100" type="submit">إنشاء حساب</button>
                </div>
                <p class="mt-4 mb-0 text-center">
                    لديك حساب بالفعل
                    <a class="ms-2" href={{route('login')}}>تسجيل دخول</a>
                </p>
            </form>
        </div>
    </div>
@endsection
