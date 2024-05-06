@extends('layouts.master')
@section('css')
@section('title')
    <?php echo $title = 'مندوبين التوصيل'; ?>
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
<button type="button" class="button x-small" data-toggle="modal" data-target="#exampleModal">
    إضافة
</button>
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
                                <th> صورة الشخصية </th>
                                <th> أسم المندوب</th>
                                <th>البريد الإلكتروني </th>
                                <th> رقم الهاتف </th>
                                <th>العنوان </th>
                                <th>تاريخ التسجيل</th>
                                <th>تعديلات</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mans as $man)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img class="img-fluid sameImg avatar-small"
                                            src="{{ asset('assets/images/mans/' . $man->avatar) }}" alt="">
                                    </td>
                                    <td>{{ $man->name }}</td>
                                    <td><a class="text-primary"
                                            href="mailto:{{ $man->email }}">{{ $man->email }}</a> </td>
                                    <td>{{ $man->phone }}</td>
                                    <td>{{ $man->address }}</td>
                                    <td>{{ $man->created_at->format('Y-m-d') }}</td>

                                    <td>
                                        <button type="button" data-toggle="modal"
                                            data-target="#edit{{ $man->id }}" title="تعديل"
                                            class="btn btn-info btn-sm" title="تعديل"><i
                                                class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{ $man->id }}" title="حذف"><i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                </div>

                <!-- edit_modal_Section -->
                <div class="modal fade" id="edit{{ $man->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    تعديل بيانات المندوب
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('mans.update', Crypt::encrypt($man->id)) }}" method="post"
                                    enctype="multipart/form-data">
                                    {{ method_field('put') }}
                                    @csrf

                                    <label for="Name" class="mr-sm-2"> الإسم
                                        :</label>
                                    <input class="form-control" type="text" name="name"
                                        value="{{ $man->name }}" required />
                                    <label for="Name" class="mr-sm-2"> البريد الإلكتروني
                                        :</label>
                                    <input class="form-control" type="email" name="email"
                                        value="{{ $man->email }}" required />
                                    <label for="Name" class="mr-sm-2"> الرمز السري
                                        :</label>
                                    <input class="form-control" type="password" name="password" />
                                    <label for="Name" class="mr-sm-2"> الصورة الشخصية
                                        :</label>
                                    <input class="form-control" type="file" name="avatar" />
                                    <label for="Name" class="mr-sm-2"> رقم الهاتف
                                        :</label>
                                    <input class="form-control" type="number" name="phone"
                                        value="{{ $man->phone }}" required />
                                    <label for="Name" class="mr-sm-2">العنوان
                                        :</label>
                                    <input class="form-control" type="text" name="address" "
                                    value="{{ $man->address }}" required>
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
                <div class="modal fade" id="delete{{ $man->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    حذف المندوب
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('mans.destroy', Crypt::encrypt($man->id)) }}" method="post">
                                    {{ method_field('Delete') }}
                                    @csrf
                                    <h3 class="text-center">هل انت متأكد من عملية الحذف ؟</h3>
                                    <p class="text-center"> اذا تم الحذف سوف يتم حذف كل ماهو متعلق بهذا المندوب</p>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">رجوع</button>
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

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                إضافة مندوب جديد
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('mans.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label for="Name" class="mr-sm-2"> الإسم
                                    :</label>
                                <input class="form-control" type="text" name="name" required />
                                <label for="Name" class="mr-sm-2"> البريد الإلكتروني
                                    :</label>
                                <input class="form-control" type="email" name="email" required />
                                <label for="Name" class="mr-sm-2"> الرمز السري
                                    :</label>
                                <input class="form-control" type="password" name="password" required />
                                <label for="Name" class="mr-sm-2"> الصورة الشخصية
                                    :</label>
                                <input class="form-control" type="file" name="avatar" required />
                                <label for="Name" class="mr-sm-2"> رقم الهاتف
                                    :</label>
                                <input class="form-control" type="number" name="phone" required />
                                <label for="Name" class="mr-sm-2">العنوان
                                    :</label>
                                <input class="form-control" type="text" name="address" required>
                                <br><br>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">الرجوع</button>
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
