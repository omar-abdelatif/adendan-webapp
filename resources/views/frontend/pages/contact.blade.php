@extends('frontend.layouts.master')
@section('title')
    تواصل معنا
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">
        <a href={{route('site.index')}}>الرئيسية</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">تواصل معنا</li>
@endsection
@section('site')
    <section class="contact pt-5 mb-4 bg-smoke-white">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="contact-details bg-primary p-3 rounded w-100">
                        <div class="contact-title bg-smoke-white rounded text-center text-primary mx-auto w-25 px-4 py-3 my-5">
                            <h3>تواصل معنا</h3>
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <div class="col-lg-4">
                                <div class="contact-item rounded bg-smoke-white p-2 text-center mb-2">
                                    <div class="icon bg-primary p-3 rounded-circle text-white mt-3 mb-3 w-25 mx-auto">
                                        <i class="fa-solid fa-at fs-1"></i>
                                    </div>
                                    <div class="contact-texts mt-3 text-center">
                                        <p class="mb-0 text-primary fs-6">
                                            <b>adandanassociation568@gmail.com</b>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="contact-item rounded bg-smoke-white p-2 text-center mb-2">
                                    <div class="icon bg-primary p-3 rounded-circle text-white mt-3 mb-3 w-25 mx-auto">
                                        <i class="fa-solid fa-location-dot fs-1"></i>
                                    </div>
                                    <div class="contact-texts mt-3 text-center">
                                        <p class="mb-0 text-primary fs-5">
                                            <b>١٥ شارع المنوفى، عابدين، القاهرة، مصر</b>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="contact-item rounded bg-smoke-white p-2 text-center">
                                    <div class="icon bg-primary p-3 rounded-circle text-white mt-3 mb-3 w-25 mx-auto">
                                        <i class="fa-solid fa-tty fs-1"></i>
                                    </div>
                                    <div class="contact-texts mt-3 text-center">
                                        <p class="mb-0 text-primary fs-5" dir="ltr">
                                            <b>02 23902313</b>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="map overflow-hidden rounded">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d215.86814938664767!2d31.246650203376216!3d30.04000230844055!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x145840b0bd0e4da7%3A0x43d5514857e5b2d0!2z2KzZhdi52YrYqSDYo9iv2YbYr9in2YYg2KfZhNiu2YrYsdmK2Kk!5e0!3m2!1sen!2seg!4v1704356713991!5m2!1sen!2seg" class="border border-2 border-primary mt-5 rounded" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
