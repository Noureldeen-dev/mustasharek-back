@extends('layouts.master')
@section('css')
@section('title')
    <?php echo $title = ' الكتب'; ?>
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
                                <th>اسم الكتاب</th>
                                <th>سعر الكتاب</th>
                                <th>اسم الكتاب</th>
                                <th>صورة الكتاب</th>
                                <th>تعديلات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($book as $bookcat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $bookcat->name }}</td>
                                    <td>{{ $bookcat->price }}</td>
                                    <td>{{ $bookcat->bookCategory->name }}</td>
                                    <td>
                                    <a href="#" class="btn btn-primary book-image-btn" data-image="{{ asset('books/' . $bookcat->image) }}">
    عرض الصورة
</a>
            </td>
                                  

                               
                                    <td>
                                        <button type="button" data-toggle="modal"
                                            data-target="#edit{{ $bookcat->id }}" title="تعديل"
                                            class="btn btn-info btn-sm" title="تعديل"><i
                                                class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{ $bookcat->id }}" title="حذف"><i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                </div>
                <!-- Modal -->
<div class="modal fade" id="bookImageModal" tabindex="-1" aria-labelledby="bookImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookImageModalLabel">صورة الكتاب</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="" alt="Book Image" class="img-fluid" id="bookImage">
            </div>
        </div>
    </div>
</div>


                <!-- edit_modal_Section -->
<div class="modal fade" id="edit{{ $bookcat->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل بيانات الكتاب</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('book.update', Crypt::encrypt($bookcat->id)) }}" enctype="multipart/form-data" method="post">
                    {{ method_field('put') }}
                    @csrf
                    <div class="form-group">
                        <label for="Name" class="mr-sm-2">الاسم:</label>
                        <input class="form-control" type="text" value="{{ $bookcat->name }}" name="name" required />
                    </div>
                    <div class="form-group">
                        <label for="book_category_id" class="mr-sm-2">تصنيف الكتاب:</label>
                        <select class="form-control" name="book_category_id" required>
                            <option value="{{ $bookcat->book_category_id }}">{{ $bookcat->bookCategory->name }}</option>
                            @foreach ($bookCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price" class="mr-sm-2">السعر:</label>
                        <input class="form-control" type="number" value="{{ $bookcat->price }}" name="price" required />
                    </div>
                    <div class="form-group">
                        <label for="image" class="mr-sm-2">الصورة:</label>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('books/' . $bookcat->image) }}" alt="{{ $bookcat->name }} Image" class="img-thumbnail mr-3" style="max-width: 100px;">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image">اختر صورة</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">رجوع</button>
                        <button type="submit" class="btn btn-success">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
                <!-- delete_modal_Section -->
                <div class="modal fade" id="delete{{ $bookcat->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    حذف الكتاب
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('book.destroy', Crypt::encrypt($bookcat->id)) }}"
                                    method="post">
                                    {{ method_field('Delete') }}
                                    @csrf
                                    <h3 class="text-center">هل انت متأكد من عملية الحذف ؟</h3>
                                    <p class="text-center"> اذا تم الحذف سوف يتم حذف كل ماهو متعلق بهذا الكتاب</p>
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
                    اضافة  كتاب جديد
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
    <form action="{{ route('book.store') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="form-group">
            <label for="Name" class="mr-sm-2">الاسم:</label>
            <input class="form-control" type="text" name="name" required />
        </div>
        <div class="form-group">
    <label for="book_category_id" class="mr-sm-2">تصنيف الكتاب:</label>
    <select class="form-control" name="book_category_id" required>
        <option value="">اختر تصنيف الكتاب</option>
        @foreach ($bookCategories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>
        <div class="form-group">
            <label for="price" class="mr-sm-2">السعر:</label>
            <input class="form-control" type="number" name="price" required />
        </div>
        <div class="form-group">
            <label for="image" class="mr-sm-2">صورة الكتاب:</label>
            <input class="form-control-file" type="file" name="image" required />
        </div>
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
    $(document).ready(function() {
        $('.book-image-btn').click(function() {
            var imageUrl = $(this).data('image');
            $('#bookImage').attr('src', imageUrl);
            $('#bookImageModal').modal('show');
        });
    });
</script>

@endsection
