@extends('frontend.layouts.master')
@section('title')
    لجان الجمعية
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">
        <a href={{route('site.index')}}>الرئيسية</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">لجان الجميعة</li>
@endsection
@section('site')
    <section class="association-committes bg-smoke-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="association-title bg-primary rounded-pill px-4 py-3 w-50 mx-auto mb-5">
                        <h2 class="text-center text-white">لجان الجمعية</h2>
                    </div>
                </div>
                @foreach ($associations as $association)
                    <div class="col-lg-4">
                        @if ($association->name === 'لجنة تكريم الانسان')
                            <div class="ag-courses_item overflow-hidden rounded-5 text-center mb-5">
                                <a href="{{route('site.assossiation_details', $association->id)}}" class="ag-courses-item_link d-block position-relative overflow-hidden bg-white py-3 px-4">
                                    <div class="ag-courses-item_bg position-absolute rounded-circle"></div>
                                    <div class="icon mb-3">
                                        <img width="75" height="75" src="https://img.icons8.com/external-flatart-icons-lineal-color-flatarticons/75/external-muslim-islam-and-ramadan-flatart-icons-lineal-color-flatarticons.png" alt="external-muslim-islam-and-ramadan-flatart-icons-lineal-color-flatarticons"/>
                                    </div>
                                    <div class="ag-courses-item_title overflow-hidden fw-bold fs-2 mb-4 text-decoration-underline position-relative">
                                        {{$association->name}}
                                    </div>
                                </a>
                            </div>
                        @elseif ($association->name === 'اللجنة الثقافية')
                            <div class="ag-courses_item overflow-hidden rounded-5 text-center mb-5">
                                <a href="{{route('site.assossiation_details', $association->id)}}" class="ag-courses-item_link d-block position-relative overflow-hidden bg-white py-3 px-4">
                                    <div class="ag-courses-item_bg position-absolute rounded-circle"></div>
                                    <div class="icon mb-3">
                                        <img width="75" height="75" src="https://img.icons8.com/color/75/art-book.png" alt="art-book"/>
                                    </div>
                                    <div class="ag-courses-item_title overflow-hidden fw-bold fs-2 mb-4 text-decoration-underline position-relative">
                                        {{$association->name}}
                                    </div>
                                </a>
                            </div>
                        @elseif ($association->name === 'اللجنة الرياضية')
                            <div class="ag-courses_item overflow-hidden rounded-5 text-center mb-5">
                                <a href="{{route('site.assossiation_details', $association->id)}}" class="ag-courses-item_link d-block position-relative overflow-hidden bg-white py-3 px-4">
                                    <div class="ag-courses-item_bg position-absolute rounded-circle"></div>
                                    <div class="icon mb-3">
                                        <img width="66" height="66" src="https://img.icons8.com/external-justicon-lineal-color-justicon/66/external-football-sport-justicon-lineal-color-justicon.png" alt="external-football-sport-justicon-lineal-color-justicon"/>
                                    </div>
                                    <div class="ag-courses-item_title overflow-hidden fw-bold fs-2 mb-4 text-decoration-underline position-relative">
                                        {{$association->name}}
                                    </div>
                                </a>
                            </div>
                        @elseif ($association->name === 'لجنة تنمية الموارد')
                            <div class="ag-courses_item overflow-hidden rounded-5 text-center mb-5">
                                <a href="{{route('site.assossiation_details', $association->id)}}" class="ag-courses-item_link d-block position-relative overflow-hidden bg-white py-3 px-4">
                                    <div class="ag-courses-item_bg position-absolute rounded-circle"></div>
                                    <div class="icon mb-3">
                                        <img width="65" height="65" src="https://img.icons8.com/external-obivous-color-kerismaker/65/external-boxes-logistics-and-delivery-color-obivous-color-kerismaker-3.png" alt="external-boxes-logistics-and-delivery-color-obivous-color-kerismaker-3"/>                                    </div>
                                    <div class="ag-courses-item_title overflow-hidden fw-bold fs-2 mb-4 text-decoration-underline position-relative">
                                        {{$association->name}}
                                    </div>
                                </a>
                            </div>
                        @elseif ($association->name === 'لجنة الكفالة')
                            <div class="ag-courses_item overflow-hidden rounded-5 text-center mb-5">
                                <a href="{{route('site.assossiation_details', $association->id)}}" class="ag-courses-item_link d-block position-relative overflow-hidden bg-white py-3 px-4">
                                    <div class="ag-courses-item_bg position-absolute rounded-circle"></div>
                                    <div class="icon mb-3">
                                        <img width="70" height="70" src="https://img.icons8.com/external-justicon-lineal-color-justicon/70/external-donation-economy-and-currency-justicon-lineal-color-justicon.png" alt="external-donation-economy-and-currency-justicon-lineal-color-justicon"/>
                                    </div>
                                    <div class="ag-courses-item_title overflow-hidden fw-bold fs-2 mb-4 text-decoration-underline position-relative">
                                        {{$association->name}}
                                    </div>
                                </a>
                            </div>
                        @elseif ($association->name === 'لجنة الرحلات')
                            <div class="ag-courses_item overflow-hidden rounded-5 text-center mb-5">
                                <a href="{{route('site.assossiation_details', $association->id)}}" class="ag-courses-item_link d-block position-relative overflow-hidden bg-white py-3 px-4">
                                    <div class="ag-courses-item_bg position-absolute rounded-circle"></div>
                                    <div class="icon mb-3">
                                        <img width="75" height="75" src="https://img.icons8.com/cotton/75/luggage--v1.png" alt="luggage--v1"/>
                                    </div>
                                    <div class="ag-courses-item_title overflow-hidden fw-bold fs-2 mb-4 text-decoration-underline position-relative">
                                        {{$association->name}}
                                    </div>
                                </a>
                            </div>
                        @elseif ($association->name === 'اللجنة الفنية')
                            <div class="ag-courses_item overflow-hidden rounded-5 text-center mb-5">
                                <a href="{{route('site.assossiation_details', $association->id)}}" class="ag-courses-item_link d-block position-relative overflow-hidden bg-white py-3 px-4">
                                    <div class="ag-courses-item_bg position-absolute rounded-circle"></div>
                                    <div class="icon mb-3">
                                        <img width="75" height="75" src="https://img.icons8.com/matisse/75/camcorder-pro.png" alt="camcorder-pro"/>
                                    </div>
                                    <div class="ag-courses-item_title overflow-hidden fw-bold fs-2 mb-4 text-decoration-underline position-relative">
                                        {{$association->name}}
                                    </div>
                                </a>
                            </div>
                        @elseif ($association->name === 'لجنة العلاقات العامة')
                            <div class="ag-courses_item overflow-hidden rounded-5 text-center mb-5">
                                <a href="{{route('site.assossiation_details', $association->id)}}" class="ag-courses-item_link d-block position-relative overflow-hidden bg-white py-3 px-4">
                                    <div class="ag-courses-item_bg position-absolute rounded-circle"></div>
                                    <div class="icon mb-3">
                                        <img width="75" height="75" src="https://img.icons8.com/matisse/75/public-speaking.png" alt="public-speaking"/>
                                    </div>
                                    <div class="ag-courses-item_title overflow-hidden fw-bold fs-2 mb-4 text-decoration-underline position-relative">
                                        {{$association->name}}
                                    </div>
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
