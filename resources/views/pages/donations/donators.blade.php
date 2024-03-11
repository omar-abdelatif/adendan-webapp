@extends('layouts.master')
@section('title', 'كل التبرعات')
@section('breadcrumb-title')
    <h3>كل المتبرعين</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">كل المتبرعين</li>
@endsection
@section('modals')

@endsection
@section('script')

@endsection
@section('css')

@endsection
@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger mx-auto w-50 text-center" id="error">
                <p class="mb-0">{{$error}}</p>
            </div>
        @endforeach
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="table display align-middle text-center" data-order='[[1,"asc"]]' data-page-length=10>
                                <thead>
                                    <tr>
                                        <th class="text-center text-white"></th>
                                        <th class="text-center text-white">#</th>
                                        <th class="text-center text-white">إسم المتبرع</th>
                                        <th class="text-center text-white">رقم المحمول</th>
                                        <th class="text-center text-white">تاريخ التسجيل</th>
                                        <th class="text-center text-white">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1 ?>
                                    @foreach ($allDonators as $donator)
                                        <tr>
                                            <td class="text-center text-white"></td>
                                            <td class="text-center text-white"></td>
                                            <td class="text-center text-white"></td>
                                            <td class="text-center text-white"></td>
                                            <td class="text-center text-white"></td>
                                            <td class="text-center text-white"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
