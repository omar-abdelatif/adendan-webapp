@extends('frontend.layouts.master')
@section('breadcrumb-items')
    <li class="breadcrumb-item">
        <a href={{route('site.index')}}>الرئيسية</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">من نحن</li>
@endsection
@section('site')
    <section class="about-us">
        <div class="container">
            <div class="row align-items-center justify-content-center"></div>
        </div>
    </section>
@endsection
