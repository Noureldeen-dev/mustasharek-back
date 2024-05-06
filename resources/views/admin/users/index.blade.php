@extends('layouts.master')
@section('css')
@section('title')
    <?php echo $title = 'المستخدمين'; ?>
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
                                <th> أسم المستخدم</th>
                                <th>البريد الإلكتروني </th>
                                <th> رقم الهاتف </th>
                                <th>العنوان  </th>
                                <th>تاريخ التسجيل</th>
                                <th>تعديلات</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img class="img-fluid sameImg avatar-small"
                                            src="{{ asset('assets/images/users/' . $user->avatar) }}" alt="">
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td><a class="text-primary"
                                            href="mailto:{{ $user->email }}">{{ $user->email }}</a> </td>
                                            <td>{{ $user->phone }}</td>
                                            <td>{{ $user->address }}</td>
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>

                                    <td>
                                        <button type="button" data-toggle="modal"
                                            data-target="#edit{{ $user->id }}" title="تعديل"
                                            class="btn btn-info btn-sm" title="تعديل"><i
                                                class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{ $user->id }}" title="حذف"><i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                </div>

                <!-- edit_modal_Section -->
                <div class="modal fade" id="edit{{ $user->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    تعديل بيانات المستخدم
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('users.update', Crypt::encrypt($user->id)) }}" method="post"
                                    enctype="multipart/form-data">
                                    {{ method_field('put') }}
                                    @csrf

                                    <label for="Name" class="mr-sm-2"> الإسم
                                        :</label>
                                    <input class="form-control" type="text" name="name"
                                        value="{{ $user->name }}" required />
                                    <label for="Name" class="mr-sm-2"> البريد الإلكتروني
                                        :</label>
                                    <input class="form-control" type="email" name="email"
                                        value="{{ $user->email }}" required />
                                    <label for="Name" class="mr-sm-2"> الرمز السري
                                        :</label>
                                    <input class="form-control" type="password" name="password" />
                                    <label for="Name" class="mr-sm-2"> الصورة الشخصية
                                        :</label>
                                    <input class="form-control" type="file" name="avatar" />
                                    <label for="Name" class="mr-sm-2"> رقم الهاتف
                                        :</label>
                                    <input class="form-control" type="number" name="phone"
                                        value="{{ $user->phone }}" required />
                                    <label for="Name" class="mr-sm-2">العنوان
                                        :</label>
                                    <input class="form-control" type="text" name="address" "
                                        value="{{ $user->address }}" required>
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
                <div class="modal fade" id="delete{{ $user->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    حذف المستخدم
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('users.destroy', Crypt::encrypt($user->id)) }}"
                                    method="post">
                                    {{ method_field('Delete') }}
                                    @csrf
                                    <h3 class="text-center">هل انت متأكد من عملية الحذف ؟</h3>
                                    <p class="text-center"> اذا تم الحذف سوف يتم حذف كل ماهو متعلق بهذا المستخدم</p>
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
                                إضافة مستخدم جديد
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
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
                                <input class="form-control" type="text" name="address" class="form-control"
                                    required>
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