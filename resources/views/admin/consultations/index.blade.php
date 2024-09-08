@extends('layouts.master')
@section('css')
@section('title')
<?php echo $title = 'الإستشارات'; ?>
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{ $title }}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">الرئيسية</a></li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->

<br><br>
<div class="row">
    <div class="col-xl-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                @if ($errors->any())
                <?php Alert::error($errors->all(), 'هناك خطأ في الحقول')->showConfirmButton('تم', '#c0392b'); ?>
                @endif
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered p-0 table-hover">
                        <thead>
                            <tr>
                                <th>الرقم</th>
                                <th>اسم المستخدم</th>
                                <th>تصنيف الإستشارة</th>
                                <th>حالة الإستشارة </th>
                                <th>تعديلات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Con as $Cons)
                            <tr>
                                <td>{{ $Cons->id }}</td>

                                <td>{{ $Cons->user->name }}</td>
                                <td>{{ $Cons->consultationcat->name }}</td>
                             
                                <td class="{{ $Cons->status === 'open' ? 'bg-success' : ($Cons->status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
   
    <form action="{{ route('consultations.update.status', $Cons->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('PATCH')
        <select name="status" onchange="this.form.submit()" style="padding: 5px; border-radius: 4px; border: 1px solid #ccc; font-size: 14px; cursor: pointer;">
            <option value="open" {{ $Cons->status == 'open' ? 'selected' : '' }}>مفتوح</option>
            <option value="closed" {{ $Cons->status == 'closed' ? 'selected' : '' }}>مغلق</option>
            <option value="pending" {{ $Cons->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
        </select>
    </form>
</td>






                                <td>

                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{ $Cons->id }}" title="حذف"><i class="fa fa-trash"></i></button>
                                    <a href="{{ route('consultations.show', $Cons->id) }}" class="btn btn-success btn-sm" title="عرض">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                </div>
                <!-- edit_modal_Section -->
                <div class="modal fade" id="edit{{ $Cons->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    تعديل بيانات القسم
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('bookcategories.update', Crypt::encrypt($Cons->id)) }}" enctype="multipart/form-data" method="post">
                                    {{ method_field('put') }}
                                    @csrf
                                    <label for="Name" class="mr-sm-2"> الاسم
                                        :</label>
                                    <input class="form-control" type="text" value="{{ $Cons->name }}" name="name" required />


                                    <br><br>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">رجوع</button>
                                <button type="submit" class="btn btn-success">حفظ</button>
                            </div>
                            </form>

                        </div>
                    </div>
                </div>
                <!-- delete_modal_Section -->
                <div class="modal fade" id="delete{{ $Cons->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    حذف القسم
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('bookcategories.destroy', Crypt::encrypt($Cons->id)) }}" method="post">
                                    {{ method_field('Delete') }}
                                    @csrf
                                    <h3 class="text-center">هل انت متأكد من عملية الحذف ؟</h3>
                                    <p class="text-center"> اذا تم الحذف سوف يتم حذف كل ماهو متعلق بهذا الإستشارة</p>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">رجوع</button>
                                        <button type="submit" class="btn btn-danger">حفظ</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<!-- add_modal_Section -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    اضافة قسم كتاب جديد
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('bookcategories.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <label for="Name" class="mr-sm-2"> الاسم:</label>
                    <input class="form-control" type="text" name="name" required />


                    <br><br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الرجوع</button>
                        <button type="submit" class="btn btn-success">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- row closed -->

@endsection
@section('js')

@endsection