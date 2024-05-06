@extends('layouts.master')
@section('css')
@section('title')
    <?php echo $title = $product->name; ?>
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
<div class="row">
    <div class="col-xl-12 mb-30">

        @if ($errors->any())
            <?php Alert::error($errors->all(), 'هناك خطأ في الحقول')->showConfirmButton('تم', '#c0392b'); ?>
        @endif
        <div class="row">
            <div class="col-md-8">
                <div class="card card-statistics h-100">
                    <div class="card-body">
                        <form action="{{ route('products.update', Crypt::encrypt($product->id)) }}" method="post"
                            enctype="multipart/form-data">
                            {{ method_field('put') }}
                            @csrf
                            <label for="Name" class="mr-sm-2"> الاسم
                                :</label>
                            <input class="form-control live" data-class=".live-name" type="text" name="name"
                                value="{{ $product->name }}" required />
                            <label for="Name" class="mr-sm-2"> القسم
                                :</label>
                            <select name="section" class="form-control p-1">
                                <option selected disabled> الأقسام...</option>
                                @foreach ($sections as $section)
                                    <option
                                        value="{{ $section->id }} "{{ $product->section == $section->id ? 'selected' : '' }}>
                                        {{ $section->name }}</option>
                                @endforeach
                            </select>
                            <label for="Name" class="mr-sm-2"> السعر الاول
                                :</label>
                            <input class="form-control live" data-class=".live-price" type="decimal" min="0.0"
                                name="price" value="{{ $product->price }}"required />
                            <label for="Name" class="mr-sm-2"> السعر الثاني
                                :</label>
                            <input class="form-control live" data-class=".live-price2" type="decimal " min="0.0"
                                name="price2" value="{{ $product->price2 }}" />
                            <label for="Name" class="mr-sm-2"> عدد المنتج
                                :</label>
                            <input class="form-control" type="number" name="count" value="{{ $product->count }}"
                                required />

                            <label for="Name" class="mr-sm-2"> صورة المنتج
                                :</label>
                            <input class="form-control" type="file" class="pict" multiple accept="image/*"
                                name="pic[]" />
                            <input type="checkbox" class="mx-2" name="deleteImgs" id="deleteImgs" />
                            <label for="deleteImgs" class="mr-sm-2"> حذف كل الصور السابقة
                            </label>

                            <br>
                            <label for="Name" class="mr-sm-2"> فيديو المنتج
                                :</label>
                            <input class="form-control" type="file" accept="video/mp4,video/x-m4v,video/*"
                                name="video" />
                            <label for="Name" class="mr-sm-2"> فئة المنتج
                                :</label>
                            <input class="form-control" type="text" name="category" value="{{ $product->category }}"
                                required />

                            <br>
                            <label for="Name" class="mr-sm-2"> تفاصيل المنتج
                                :</label>
                            <textarea name="desc" class="form-control live" data-class=".live-text" required>{{ $product->desc }}</textarea>
                            <label for="Name" class="mr-sm-2"> النوع
                                :</label>
                            <select name="type" class="form-control p-1">
                                <option value="0" {{ $product->type == 0 ? 'selected' : '' }}>حجز
                                </option>
                                <option value="1" {{ $product->type == 1 ? 'selected' : '' }}>حجز مسبق
                                </option>
                            </select>
                            <label for="Name" class="mr-sm-2"> الجنس
                                :</label>
                            <select name="sex" class="form-control p-1">
                                <option value="0" {{ $product->sex == 0 ? 'selected' : '' }}>ذكر
                                </option>
                                <option value="1" {{ $product->sex == 0 ? 'selected' : '' }}>أنثى</option>
                            </select>
                            <br>
                            <label for="Name" class="mr-sm-2"> العلامة التجارية
                                :</label>
                            <input class="form-control" type="text" name="mark" value="{{ $product->mark }}"
                                required />
                            <br><br>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">حفظ</button>
                            </div>
                        </form>
                        <a href="{{ route('changeColor', Crypt::encrypt($product->id)) }}"
                            class="btn btn-primary">تعديل اللون</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-statistics h-100">
                    <div class="card-body">
                        <h5 class="card-title live-name">{{ $product->name }}</h5>
                        <!-- action group -->
                        <div class="blog-box blog-2">
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <?php $i = 0; ?>
                                    @forelse ($imgs as $img)
                                        <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                                            <img class="d-block w-100"
                                                src="{{ asset('assets/images/products/' . $img->img) }}"
                                                height="350" alt="First slide">
                                        </div>
                                        <?php $i++; ?>
                                    @empty
                                        <h6 class="text-center">لايوجد صور</h6>
                                    @endforelse


                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                                    data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                                    data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>

                            <div class="blog-info  pt-10">
                                <span class="post-category"><a href="#">القسم :
                                        {{ $product->sectionRel->name }}
                                    </a></span>
                                <p> السعر الأول : <span class="live-price"> {{ $product->price }}</span> دينار </p>
                                <p class="mb-10">السعر الثاني :
                                    <span
                                        class="live-price2">{{ $product->price2 == 0 ? 'لا يوجد ' : $product->price2 . 'دينار' }}</span>
                                </p>
                                <p class="mb-2"> الالوان :</p>
                                <div style=" display:flex;     flex-wrap: wrap;">
                                    @forelse ($product->colorsRel as $color)
                                        <div class="m-1"
                                            style="height: 20px; width:40px; background-color:{{ $color->color }}; margin:0 10px; ">
                                        </div>
                                    @empty
                                        لايوجد
                                    @endforelse
                                </div>
                                <br>
                                <p>التفاصيل : <br>
                                    <span class="live-text">{{ $product->desc }}</span>
                                </p>

                                <a href="{{ route('products.edit', $product->id) }}" target="_blank"
                                    class="text-primary">عرض
                                    الفيديو</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>
</div>




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
