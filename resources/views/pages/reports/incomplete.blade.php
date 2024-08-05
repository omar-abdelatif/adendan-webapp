@extends('layouts.master')
@section('title', 'تقارير النواقص')
@section('breadcrumb-title')
    <h3>تقارير النواقص</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">التقارير</li>
    <li class="breadcrumb-item active">تقارير النواقص</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-img text-center">
                            <img width="100" height="100" src="https://img.icons8.com/fluency/100/identity-theft.png" alt="identity-theft"/>
                        </div>
                        <div class="card-content text-center">
                            <h3 class="text-center text-decoration-underline mb-4">الرقم لقومي</h3>
                            <p class="mb-3 fw-bold">{{$incompleteSSNCount}}</p>
                            <button class="btn btn-primary fw-bold w-100 fs-5" type="button" data-bs-toggle="modal" data-bs-target="#ssn">المزيد</button>
                            <div class="fade modal" id="ssn" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-centered-dialog modal-fullscreen">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title fs-5 text-white" id="exampleModalLabel">بيانات الرقم القومي</h3>
                                        </div>
                                        <div class="modal-body">
                                            <div class="table-responsive">
                                                <table class="table display align-middle text-center table-hover" id="table35" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">رقم العضوية</th>
                                                            <th class="text-center">إسم العضو</th>
                                                            <th class="text-center">رقم القومي</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($incompleteSSN as $ssn)
                                                            <tr>
                                                                <td>{{$ssn->member_id}}</td>
                                                                <td>{{$ssn->name}}</td>
                                                                <td>{{$ssn->ssn}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">إغلاق</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-img text-center">
                            <img width="100" height="100" src="https://img.icons8.com/fluency/100/google-pixel6.png" alt="google-pixel6"/>
                        </div>
                        <div class="card-content text-center">
                            <h3 class="text-center text-decoration-underline mb-4">رقم المحمول</h3>
                            <p class="mb-3 fw-bold">{{$incompleteMobileCount}}</p>
                            <button class="btn btn-primary fw-bold w-100 fs-5" type="button" data-bs-toggle="modal" data-bs-target="#mobile">المزيد</button>
                            <div class="fade modal" id="mobile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-centered-dialog modal-fullscreen">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title fs-5 text-white" id="exampleModalLabel">بيانات رقم المحمول</h3>
                                        </div>
                                        <div class="modal-body">
                                            <div class="table-responsive">
                                                <table class="table display align-middle text-center table-hover" id="table36" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">رقم العضوية</th>
                                                            <th class="text-center">إسم العضو</th>
                                                            <th class="text-center">رقم المحمول</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($incompleteMobile as $mobile)
                                                            <tr>
                                                                <td>{{$mobile->member_id}}</td>
                                                                <td>{{$mobile->name}}</td>
                                                                <td>{{$mobile->mobile_no}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">إغلاق</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-img text-center">
                            <img width="100" height="100" src="https://img.icons8.com/fluency/100/address-book-2.png" alt="address-book-2"/>
                        </div>
                        <div class="card-content text-center">
                            <h3 class="text-center text-decoration-underline mb-4">العنوان</h3>
                            <p class="mb-3 fw-bold">{{$incompleteAddressCount}}</p>
                            <button class="btn btn-primary fw-bold w-100 fs-5" type="button" data-bs-toggle="modal" data-bs-target="#address">المزيد</button>
                            <div class="fade modal" id="address" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-centered-dialog modal-fullscreen">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title fs-5 text-white" id="exampleModalLabel">بيانات العنوان</h3>
                                        </div>
                                        <div class="modal-body">
                                            <div class="table-responsive">
                                                <table class="table display align-middle text-center table-hover" id="table37" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">رقم العضوية</th>
                                                            <th class="text-center">إسم العضو</th>
                                                            <th class="text-center">العنوان</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($incompleteAddress as $address)
                                                            <tr>
                                                                <td>{{$address->member_id}}</td>
                                                                <td>{{$address->name}}</td>
                                                                <td>{{$address->address}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">إغلاق</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
