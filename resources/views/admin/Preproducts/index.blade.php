@extends('layouts.master')
@section('css')
@section('title')
    <?php echo $title = 'المنتجات'; ?>
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
                                <th> اسم المنتج</th>
                                <th>القسم </th>
                                <th>سعر المنتج</th>
                                <th> سعر أخر</th>
                                <th> عدد المنتج </th>
                                <th>تعديلات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->sectionRel->name }}</td>
                                    <td>{{ $product->price.'دينار' }}</td>
                                    <td>{{ $product->price2 == 0 ? 'لا يوجد ' : $product->price2 . 'دينار' }}</td>
                                    <td>{{ $product->count }}</td>
                                    <td>
                                        <button type="button" data-toggle="modal"
                                            data-target="#edit{{ $product->id }}" title="تعديل"
                                            class="btn btn-info btn-sm" title="تعديل"><i
                                                class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{ $product->id }}" title="حذف"><i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                </div>

                <!-- edit_modal_Section -->
                <div class="modal fade" id="edit{{ $product->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    تعديل بيانات المنتج
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('products.update', Crypt::encrypt($product->id)) }}"
                                    method="post">
                                    {{ method_field('put') }}
                                    @csrf
                                    <label for="Name" class="mr-sm-2"> الاسم
                                        :</label>
                                    <input class="form-control" type="text" name="name" value="{{$product->name}}" required />
                                    <label for="Name" class="mr-sm-2" > القسم
                                        :</label>
                                    <select name="section" class="form-control p-1" >
                                        <option selected disabled> الأقسام...</option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }} "{{$product->section == $section->id ? 'selected' : ''}} >{{ $section->name }}</option>
                                        @endforeach

                                    </select>
                                    <label for="Name" class="mr-sm-2"> السعر الاول
                                        :</label>
                                    <input class="form-control" type="number" min="0.0" name="price"  value="{{$product->price}}"required />
                                    <label for="Name" class="mr-sm-2"> السعر الثاني
                                        :</label>
                                    <input class="form-control" type="number" min="0.0" name="price2"  value="{{$product->price2}}"required />
                                    <label for="Name" class="mr-sm-2"> عدد المنتج
                                        :</label>
                                    <input class="form-control" type="number" name="count" value="{{$product->count}}" required />
                                  
                                    <label for="Name" class="mr-sm-2"> صورة المنتج 
                                        :</label>
                                    <input class="form-control" type="file" name="pic" value="{{$product->pic}}" />
                                    <label for="Name" class="mr-sm-2"> فئة المنتج
                                        :</label>
                                    <input class="form-control" type="text" name="category" value="{{$product->category}}" required />
                                    <label for="Name" class="mr-sm-2"> لون المنج
                                        :</label>
                                    <input class="form-control" type="color" name="color" value="{{$product->color}}"required />
                                    <label for="Name" class="mr-sm-2"> تفاصيل المنتج
                                        :</label>
                                    <textarea name="desc" class="form-control" required>{{$product->desc}}</textarea>
                                    <br><br>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">رجوع</button>
                                        <button type="submit" class="btn btn-success">حفظ</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                    <!-- delete_modal_Section -->
                    <div class="modal fade" id="delete{{ $product->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        حذف المنتج
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('products.destroy', Crypt::encrypt($product->id)) }}"
                                        method="post">
                                        {{ method_field('Delete') }}
                                        @csrf
                                        <h3 class="text-center">هل انت متأكد من عملية الحذف ؟</h3>
                                        <p class="text-center"> اذا تم الحذف سوف يتم حذف كل ماهو متعلق بهذا المنتج</p>
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
                    اضافة منتج جديد
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <label for="Name" class="mr-sm-2"> الاسم
                        :</label>
                    <input class="form-control" type="text" name="name" required />
                    <label for="Name" class="mr-sm-2"> القسم
                        :</label>
                    <select name="section" class="form-control p-1">
                        <option selected disabled> الأقسام...</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @endforeach

                    </select>
                    <label for="Name" class="mr-sm-2"> السعر الاول
                        :</label>
                    <input class="form-control" type="number" min="0.0" name="price" required />
                    <label for="Name" class="mr-sm-2"> السعر الثاني
                        :</label>
                    <input class="form-control" type="number" min="0.0" name="price2" required />
                    <label for="Name" class="mr-sm-2"> عدد المنتج
                        :</label>
                    <input class="form-control" type="number" name="count" required />
                    <label for="Name" class="mr-sm-2"> صورة المنتج 
                        :</label>
                    <input class="form-control" type="file" name="pic" required />
                    <label for="Name" class="mr-sm-2"> فئة المنتج
                        :</label>
                    <input class="form-control" type="text" name="category" required />
                    <label for="Name" class="mr-sm-2"> لون المنج
                        :</label>
                    <input class="form-control" type="color" name="color" required />
                    <label for="Name" class="mr-sm-2"> تفاصيل المنتج
                        :</label>
                    <textarea name="desc" class="form-control"></textarea>
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
