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
                                    <td>{{ $product->price . 'دينار' }}</td>
                                    <td>{{ $product->price2 == 0 ? 'لا يوجد ' : $product->price2 . 'دينار' }}</td>
                                    <td>{{ $product->count }}</td>

                                    <td>
                                        <a type="button"
                                            href="{{ route('products.show', Crypt::encrypt($product->id)) }}"
                                            class="btn btn-info btn-sm" title="تعديل"><i class="fa fa-edit"></i></a>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{ $product->id }}" title="حذف"><i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
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
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
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
                    <input class="form-control" type="decimal" min="0.0" name="price" required />
                    <label for="Name" class="mr-sm-2"> السعر الثاني
                        :</label>
                    <input class="form-control" type="decimal " min="0.0" name="price2" />
                    <label for="Name" class="mr-sm-2"> عدد المنتج
                        :</label>
                    <input class="form-control" type="number" name="count" required />
                    <label for="Name" class="mr-sm-2"> صورة المنتج
                        :</label>
                    <input class="form-control" type="file" name="pic[]" class="pict" accept="image/*"
                        multiple required />
                    <label for="Name" class="mr-sm-2"> فيديو المنتج
                        :</label>
                    <input class="form-control" type="file" class="video" accept="video/mp4,video/x-m4v,video/*"
                        name="video" />
                    <label for="Name" class="mr-sm-2"> فئة المنتج
                        :</label>

                    <select name="category_id" class="form-control p-1" required >
                        @foreach ($categories as $category)

                        <option value="{{$category->id}}">{{$category->name}}
                        </option>
                            @endforeach
                    </select>



                    <br>
                    <label for="Name" class="mr-sm-2"> تفاصيل المنتج
                        :</label>
                    <textarea name="desc" class="form-control"></textarea>
                    <label for="Name" class="mr-sm-2"> النوع
                        :</label>
                    <select name="type" class="form-control p-1">
                        <option value="0">حجز</option>
                        <option value="1">حجز مسبق</option>
                        <option value="2">عرض حصري</option>
                    </select>
                    <label for="Name" class="mr-sm-2"> الجنس
                        :</label>
                    <select name="sex" class="form-control p-1">
                        <option value="0">ذكر
                        </option>
                        <option value="1">أنثى</option>
                    </select>
                    <br>
                    <label for="Name" class="mr-sm-2"> العلامة التجارية
                        :</label>
                        <select name="brand_id" class="form-control p-1" required >
                            @foreach ($brands as $brand)

                            <option value="{{$brand->id}}">{{$brand->name}}
                            </option>
                                @endforeach
                        </select>
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
                    <br>
                    <label for="Name" class="mr-sm-2"> مقاس المنتج
                        :</label>
                    <br>
                    <div class="repeater">
                        <div data-repeater-list="List_Sizes">
                            <div data-repeater-item>
                                <div class="row">
                                    <div class="col">
                                        <label for="Name" class="mr-sm-2">المقاس:</label>
                                        <select class="form-control" name="size" required>
                                            <option value="Xl">Xl</option>
                                            <option value="s">s</option>
                                            <option value="m">m</option>
                                            <option value="XXL">XXL</option>
                                            <option value="Xxxxl">Xxxxl</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="Name_en" class="mr-sm-2">حذف صف:</label>
                                        <input class="btn btn-danger btn-block" data-repeater-delete type="button" value="حذف الصف" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-20">
                            <div class="col-12">
                                <input class="button" data-repeater-create type="button" value="أضافة مقاس" />
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
<script>
    const input = document.querySelectorAll('input[type="file"]');

    input.forEach(element => {

        const pond = FilePond.create(element, {
            acceptedFileTypes: ['image/png'],
            labelIdle: `قم بسحب ملفك أو <span class="filepond--label-action"> أضغط</span>`,
            onaddfilestart: (file) => {
                isLoadingCheck();
            },
            onprocessfile: (files) => {
                isLoadingCheck();
            },



        });

        function isLoadingCheck() {
            var isLoading = pond.getFiles().filter(x => x.status !== 5).length !== 0;
            if (isLoading) {
                $('button[type="submit"]').attr("disabled", "disabled");
            } else {
                $('button[type="submit"]').removeAttr("disabled");
            }
        }
    });

    $('.filepond--credits').remove();



    FilePond.setOptions({
        server: {
            url: "{{ route('upload') }}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            }
        },
    });
</script>
@endsection
