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
@section('content')
    <div class="container-fluid">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger text-center w-50 mt-4 mx-auto rounded" id="error">
                    <p class="mb-0">{{$error}}</p>
                </div>
            @endforeach
        @endif
        <div class="card">
            <div class="card-body">
                <table id="table" class="table display align-middle text-center table-hover" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                    <thead>
                        <tr>
                            <th class="text-center text-white">#</th>
                            <th class="text-center text-white">العنوان</th>
                            <th class="text-center text-white">التصنيف</th>
                            <th class="text-center text-white">صورة الخبر</th>
                            <th class="text-center text-white">تاريخ النشر</th>
                            <th class="text-center text-white">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i =1 ?>
                        @foreach ($news as $new)
                            <tr>
                                <td class="text-center text-white">{{$i++}}</td>
                                <td class="text-center text-white">{{$new->title}}</td>
                                <td class="text-center text-white">
                                    @if ($new->category === 'عزاء')
                                        <span class="badge rounded-pill py-2 px-3 bg-dark">
                                            <b>{{$new->category}}</b>
                                        </span>
                                    @elseif($new->category === 'أفراح')
                                        <span class="badge rounded-pill py-2 px-3 bg-success">
                                            <b>{{$new->category}}</b>
                                        </span>
                                    @elseif($new->category === 'أخبار ثقافية')
                                        <span class="badge rounded-pill py-2 px-3 bg-info">
                                            <b>{{$new->category}}</b>
                                        </span>
                                    @elseif($new->category === 'أخبار رياضية')
                                        <span class="badge rounded-pill py-2 px-3 bg-primary">
                                            <b>{{$new->category}}</b>
                                        </span>
                                    @else
                                        <span class="badge rounded-pill py-2 px-3 bg-secondary">
                                            <b>{{$new->category}}</b>
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center text-white">
                                    @if ($new->category === 'عزاء')
                                        <img src={{ asset('assets/frontend/images/bg/news/death/0205f1b1728e6eacf3e5935c553516b8.jpg')}} class="img-fluid rounded" width="50" alt={{$new->img}}>
                                    @else
                                        <img src={{ $new->img ? asset('assets/images/news-imgs/'.$new->img) : asset('assets/frontend/images/icons/default/download.jpeg')}} class="img-fluid rounded" width="50" alt={{$new->img}}>
                                    @endif
                                </td>
                                <td class="text-center text-white">{{ $new->created_at->format('Y-m-d') }}</td>
                                <td class="text-center text-white">
                                    <div class="btn-group" role="group">
                                        {{-- ! Button Menu ! --}}
                                        <button class="btn btn-success rounded" id="btnGroupVerticalDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu py-2 px-3 w-100" aria-labelledby="btnGroupVerticalDrop1">
                                            {{-- ! Delete News Button ! --}}
                                            <button type="button" class="btn btn-danger px-2 py-1" data-bs-toggle="modal" data-bs-target="#deleting_{{$new->id}}">
                                                <i class="icofont icofont-trash"></i>
                                            </button>
                                            {{-- ! Updating News Button ! --}}
                                            <button type="button" class="btn btn-warning px-2 py-1" data-bs-toggle="modal" data-bs-target="#editing_{{$new->id}}">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>
                                            {{-- ! Show Thumbnail ! --}}
                                            <a class="text-white btn btn-success px-2 py-1" href={{route('show.thumbs',$new->id)}}>
                                                <i class="fa-solid fa-image"></i>
                                            </a>
                                        </div>
                                    </div>
                                    {{-- ! Deleteing Modal ! --}}
                                    <div class="modal fade" id="deleting_{{$new->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">جار حذف خبر بعنوان {{$new->title}}</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action={{route('news.destroy', $new->id)}} method="get">
                                                        @csrf
                                                        <div class="form-title text-center">
                                                            <h3 class="text-white my-2">هل أنت متأكد من الحذف</h3>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إالغاء</button>
                                                            <button type="submit" role="button" class="btn btn-primary">تأكيد</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- ! Updating Midal ! --}}
                                    <div class="modal fade" id="editing_{{$new->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">تعديل خبر بعنوان {{$new->title}}</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action={{route('news.update')}} method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id" value={{$new->id}}>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label for="title" class="text-white">العنوان</label>
                                                                    <input type="text" class="form-control text-white" name="title" value="{{$new->title}}" placeholder="عنوان الخبر">
                                                                </div>
                                                                <div class="form-group mt-3">
                                                                    <label for="title" class="text-white">تفاصيل الخبر</label>
                                                                    <textarea name="description" class="form-control text-light text-center pt-2" placeholder="تفاصيل الخبر">{{$new->description}}</textarea>
                                                                </div>
                                                                <div class="form-group mt-3">
                                                                    <label for="" class="text-white">إختر التصنيف</label>
                                                                    <select class="form-select" name="category">
                                                                        <option selected="">التصنيف</option>
                                                                        <option value="أخبار عامة" {{$new->category == 'أخبار عامة' ? 'selected' : ''}}>أخبار عامة</option>
                                                                        <option value="أخبار ثقافية" {{$new->category == 'أخبار ثقافية' ? 'selected' : ''}}>أخبار ثقافية</option>
                                                                        <option value="أفراح" {{$new->category == 'أفراح' ? 'selected' : ''}}>أفراح</option>
                                                                        <option value="عزاء" {{$new->category == 'عزاء' ? 'selected' : ''}}>عزاء</option>
                                                                        <option value="أخبار رياضية" {{$new->category == 'أخبار رياضية' ? 'selected' : ''}}>أخبار رياضية</option>
                                                                    </select>
                                                                </div>
                                                                <div class="view-img text-center mt-3">
                                                                    <img src={{asset('assets/images/news-imgs/'.$new->img)}} width="60" data-member-id="{{ $new->id }}" class="rounded img-fluid" id="showImage_{{ $new->id }}" alt="{{$new->img}}">
                                                                </div>
                                                                <div class="form-group mt-3">
                                                                    <label for="" class="text-white">صورة الخبر</label>
                                                                    <input type="file" name="img" id="image" data-member-id="{{ $new->id }}" class="form-control" value={{$new->img}} alt="{{$new->img}}" accept="image/*">
                                                                </div>
                                                                <div class="form-group mt-3">
                                                                    <label class="text-white">صور مصغرة</label>
                                                                    <input type="file" name="thumbnail[]" class="form-control" multiple accept="image/*">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إلغاء</button>
                                                                    <button type="submit" role="button" class="btn btn-primary">تأكيد</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-lg-12">
            </div>
        </div> --}}
    </div>
@endsection
