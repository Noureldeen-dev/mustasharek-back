@extends('layouts.master')
@section('css')
@section('title')
    <?php echo $title = ' الوان المنتج ' . $product->name; ?>
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
<a href="{{ route('products.index') }}">
    <i class="fa fa-arrow-right" style="font-size: 24px"></i>
</a>
<br><br>
<button type="button" class="button x-small" data-toggle="modal" data-target="#exampleModal">
    أضافة
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
                                <th> اللون</th>
                                <th>تاريخ الانشاء</th>
                                <th>تعديلات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product->colorsRel as $color)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div style="height: 20px; width:30px; background-color:{{ $color->color }}">
                                        </div>
                                    </td>
                                    <td>{{ $color->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <button type="button" data-toggle="modal"
                                            data-target="#edit{{ $color->id }}" title="تعديل"
                                            class="btn btn-info btn-sm" title="تعديل"><i
                                                class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{ $color->id }}" title="حذف"><i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                </div>
                <!-- edit_modal_Section -->
                <div class="modal fade" id="edit{{ $color->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    تعديل بيانات اللون
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('colors.update', Crypt::encrypt($color->id)) }}" method="post">
                                    {{ method_field('put') }}
                                    @csrf
                                    <div class="col">
                                        <label for="Name" class="mr-sm-2">اللون
                                            :</label>
                                        <input class="form-control" type="color" name="color"
                                            value="{{ $color->color }}" required />
                                    </div>
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
                <div class="modal fade" id="delete{{ $color->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    حذف اللون
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('colors.destroy', Crypt::encrypt($color->id)) }}"
                                    method="post">
                                    {{ method_field('Delete') }}
                                    @csrf
                                    <h3 class="text-center">هل انت متأكد من عملية الحذف ؟</h3>
                                    <p class="text-center"> اذا تم الحذف سوف يتم حذف كل ماهو متعلق بهذا اللون</p>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    اضافة لون جديد
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('colorStore', $product->id) }}" method="POST">
                    @csrf
                    <br>
                    <label for="Name" class="mr-sm-2"> لون المنتج
                        :</label>
                    <br>
                    <div class="repeater">
                        <div data-repeater-list="List_Colors">
                            <div data-repeater-item>
                                <div class="row">

                                    <div class="col">
                                        <label for="Name" class="mr-sm-2">اللون
                                            :</label>
                                        <input class="form-control" type="color" name="color" required />
                                    </div>


                                    <div class="col">
                                        <label for="Name_en" class="mr-sm-2">حذف صف
                                            :</label>
                                        <input class="btn btn-danger btn-block" data-repeater-delete type="button"
                                            value="حذف الصف" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-20">
                            <div class="col-12">
                                <input class="button" data-repeater-create type="button" value="أضافة لون" />
                            </div>
                        </div>

                    </div>
                    <br><br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الرجوع</button>
                        <button type="submit" class="btn btn-success">حفظ</button>
                    </div>
                </form>
                <div class="modal-body">
                    <form action="{{ route('colorStore', $product->id) }}" method="POST">
                        @csrf
                        <br>
                        <label for="Name" class="mr-sm-2"> لون المنتج
                            :</label>
                        <br>
                        <div class="repeater">
                            <div data-repeater-list="List_Colors">
                                <div data-repeater-item>
                                    <div class="row">

                                        <div class="col">
                                            <label for="Name" class="mr-sm-2">المقاس
                                                :</label>
                                            <input class="form-control" type="color" name="color" required />
                                        </div>


                                        <div class="col">
                                            <label for="Name_en" class="mr-sm-2">حذف صف
                                                :</label>
                                            <input class="btn btn-danger btn-block" data-repeater-delete type="button"
                                                value="حذف الصف" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-20">
                                <div class="col-12">
                                    <input class="button" data-repeater-create type="button" value="أضافة لون" />
                                </div>
                            </div>

                        </div>
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
