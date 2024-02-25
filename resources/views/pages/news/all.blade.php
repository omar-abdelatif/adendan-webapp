@extends('layouts.master')
@section('title', 'الأخبار')
@section('breadcrumb-title')
    <h3>كل الأخبار</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">الأخبار</li>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
@endsection
@section('modals')
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_news">إضافة خبر جديد</button>
    <div class="modal fade" id="add_news" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">إضافة خبر</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action={{route('news.store')}} method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="title" class="text-white">العنوان</label>
                                    <input type="text" class="form-control text-white" name="title" placeholder="عنوان الخبر">
                                </div>
                                <div class="form-group mt-3">
                                    <label for="title" class="text-white">تفاصيل الخبر</label>
                                    <textarea name="description" class="form-control text-light text-center pt-2" placeholder="تفاصيل الخبر"></textarea>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="" class="text-white">إختر التصنيف</label>
                                    <select class="form-select form-select-sm" name="category" id="categorySelect">
                                        <option selected="">التصنيف</option>
                                        <option value="أخبار عامة">أخبار عامة</option>
                                        <option value="أخبار ثقافية">أخبار ثقافية</option>
                                        <option value="أفراح">أفراح</option>
                                        <option value="عزاء">عزاء</option>
                                        <option value="أخبار رياضية">أخبار رياضية</option>
                                    </select>
                                </div>
                                <div class="form-group mt-3" id="img">
                                    <label for="" class="text-white">صورة الخبر</label>
                                    <input type="file" name="img" class="form-control" accept="image/*">
                                </div>
                                <div class="form-group mt-3" id="thumbs">
                                    <label for="" class="text-white">صورة المصغرة</label>
                                    <input type="file" name="thumbnail[]" class="form-control" multiple accept="image/*">
                                </div>
                                <div class="form-group mt-3" id="inputs">
                                    <label for="" class="text-white mb-3">رابط الفيديو (إذا وجد ) </label>
                                    <a href="javascript:void(0)" class="btn btn-success px-2 py-1 addRow ms-2">+</a>
                                    <input type="text" name="url[]" class="form-control text-center text-white mb-4" placeholder="رابط الفيديو">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إالغاء</button>
                                    <button type="submit" role="button" class="btn btn-primary">تأكيد</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
