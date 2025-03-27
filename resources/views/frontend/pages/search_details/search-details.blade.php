@extends('frontend.layouts.master')
@section('title')
    {{$member->name}}
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">
        <a href={{route('site.index')}}>الرئيسية</a>
    </li>
    <li class="breadcrumb-item">الإستعلامات</li>
    <li class="breadcrumb-item active" aria-current="page">{{$member->name}}</li>
@endsection
@section('site_styles')
    <style>
        .form-label {
            padding: 10px 20px;
            border: 2px solid #004080;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            min-width: 80px;
            display: inline-block;
            transition: all 0.3s;
        }

        .form-label:hover{
            background-color: #004080;
            color: white;
            transition: all 0.3s;
        }
        input[type="radio"]:checked + .form-label {
            background-color: #004080;
            color: white;
        }

        input[type="radio"]:checked:disabled + .form-label, input[type="radio"]:disabled + .form-label {
            background-color: #004080;
            color: white;
            opacity: 0.5;
            cursor: not-allowed;
        }
        input[type="number"]:disabled {
            cursor: not-allowed;
            opacity: 0.5;
        }
    </style>
@endsection
@section('site')
    <section class="search-details-wrappers">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-primary border-2 w-75 mx-auto">
                        <div class="card-header bg-primary text-white">
                            <h1 class="card-title text-center my-3 text-decoration-underline fs-3">دفع الإشتراك او المتأخرات للعضو {{$member->name}}</h1>
                        </div>
                        <div class="card-body py-3 px-2">
                            <div class="caution-title">
                                <h1 class="text-center text-danger text-decoration-underline my-2">المدفوعات في طور التجربة</h1>
                            </div>
                            <form action="{{route('payment.checkout')}}" method="post" id="payment-form">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection