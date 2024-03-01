@extends('layouts.master')
@section('title', 'مجلس الإدارة')
@section('breadcrumb-title')
    <h3>كل أعضاء مجلس الإدارة</h3>
@endsection
@section('modals')
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_cat">إضافة عضو جديد</button>
    <div class="modal fade" id="add_cat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">إضافة عضو جديد</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action={{route('board.store')}} method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title" class="text-white">الإسم</label>
                            <input type="text" class="form-control text-white" name="name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="title" class="text-white">المركز</label>
                            <input type="text" class="form-control text-white" name="position" placeholder="Position">
                        </div>
                        <div class="form-group">
                            <label for="title" class="text-white">رقم المحمول</label>
                            <input type="number" class="form-control text-white" name="phone_number" placeholder="رقم المحمول">
                        </div>
                        <div class="form-group">
                            <label for="title" class="text-white">الصورة</label>
                            <input type="file" class="form-control text-white" name="img" accept="image/*">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إلغاء</button>
                            <button type="submit" role="button" class="btn btn-primary">تأكيد</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">مجلس الإدارة</li>
@endsection
@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger text-center w-50 mx-auto rounded" id="error">
                <p class="mb-0">{{$error}}</p>
            </div>
        @endforeach
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-resposive">
                            <?php $i = 1 ?>
                            <table class="table display align-middle text-center table-hover" id="table" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th class="text-white text-center">#</th>
                                        <th class="text-white text-center">الإسم</th>
                                        <th class="text-white text-center">رقم المحمول</th>
                                        <th class="text-white text-center">المركز</th>
                                        <th class="text-white text-center">الصورة</th>
                                        <th class="text-white text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($members as $member)
                                        <tr>
                                            <td class="text-white">{{$i++}}</td>
                                            <td class="text-white">{{$member->name}}</td>
                                            <td class="text-white">{{$member->phone_number}}</td>
                                            <td class="text-white">{{$member->position}}</td>
                                            <td class="text-white">
                                                <img src={{asset('assets/images/border-photos/'.$member->img)}} width="50" class="rounded" alt="">
                                            </td>
                                            <td>
                                                {{-- ! Update ! --}}
                                                <button type="button" class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#editingborder_{{$member->id}}">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <div class="modal fade" id="editingborder_{{$member->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Updating Member {{$member->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('board.update')}} method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value={{$member->id}}>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="title" class="text-white">إسم العضو</label>
                                                                                <input type="text" class="form-control text-white" name="name" value="{{$member->name}}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="title" class="text-white">رقم المحمول</label>
                                                                                <input type="text" class="form-control text-white" name="phone_number" value="{{$member->phone_number}}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="title" class="text-white">وظيفة</label>
                                                                                <input type="text" class="form-control text-white" name="position" value="{{$member->position}}" readonly>
                                                                            </div>
                                                                            <div class="img-show">
                                                                                <img src={{asset('assets/images/border-photos/'.$member->img)}} width="80" data-member-id="{{ $member->id }}" id="showImage_{{ $member->id }}" class="rounded" alt="">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="title" class="text-white">الصورة</label>
                                                                                <input type="file" class="form-control text-white" id="image" data-member-id="{{ $member->id }}" name="img" accept="image/*" value="{{ $member->img }}">
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
                                                {{-- ! Delete ! --}}
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleting_{{$member->id}}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <div class="modal fade" id="deleting_{{$member->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">حذف العضو {{$member->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('board.delete', $member->id)}} method="get">
                                                                    @csrf
                                                                    <div class="form-title text-center">
                                                                        <h1 class="text-white">هل أنت متأكد من الحذف</h1>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إلغاء</button>
                                                                        <button type="submit" role="button" class="btn btn-primary">تأكيد</button>
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
                </div>
            </div>
        </div>
    </div>
@endsection
