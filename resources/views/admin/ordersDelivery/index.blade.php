@extends('layouts.master')
@section('css')
@section('title')
    <?php echo $title = 'ارسال الطلبية'; ?>
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
                                <th> صورة الشخصية </th>
                                <th> أسم المستخدم</th>
                                <th>البريد الإلكتروني </th>
                                <th>رقم الهاتف</th>
                                <th>تاريخ استلام الطلبية</th>
                                <th>تعديلات</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img class="img-fluid sameImg avatar-small"
                                            src="{{ asset('assets/images/users/' . $order->userRel->avatar) }}"
                                            alt="">
                                    </td>
                                    <td>{{ $order->userRel->name }}</td>
                                    <td><a class="text-primary"
                                            href="mailto:{{ $order->userRel->email }}">{{ $order->userRel->email }}</a>
                                    </td>
                                    <td>{{ $order->userRel->phone }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>

                                    <td>
                                        <button type="button" data-toggle="modal"
                                            data-target="#edit{{ $order->id }}" title="ارسال"
                                            class="btn btn-info btn-sm"><i class="fa fa-send"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{ $order->id }}" title="حذف"><i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>


                                <!-- edit_modal_Section -->
                                <div class="modal fade" id="edit{{ $order->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    ارسال الطلبية
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <form
                                                    action="{{ route('orderDelivery.update', Crypt::encrypt($order->id)) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    {{ method_field('put') }}
                                                    @csrf

                                                    <label for="Name" class="mr-sm-2"> المندوب
                                                        :</label>
                                                    <select name="delivery" class="form-control p-1" required>
                                                        @foreach ($men as $man)
                                                            <option value="{{ $man->id }}">
                                                                {{ $man->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    <br><br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">رجوع</button>
                                                <button type="submit" class="btn btn-success">حفظ</button>
                                            </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                                <!-- delete_modal_Section -->
                                <div class="modal fade" id="delete{{ $order->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    حذف الطلبية
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form
                                                    action="{{ route('orderDelivery.destroy', Crypt::encrypt($order->id)) }}"
                                                    method="post">
                                                    {{ method_field('Delete') }}
                                                    @csrf
                                                    <h3 class="text-center">هل انت متأكد من عملية الحذف ؟</h3>
                                                    <p class="text-center"> اذا تم الحذف سوف يتم حذف كل ماهو متعلق بهذا
                                                        الطلبية</p>
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


<!-- row closed -->

@endsection
@section('js')

@endsection
