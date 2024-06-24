@extends('layouts.master')
@section('css')
@section('title')
<?php echo $title = 'الإستشارات'; ?>@stop
@endsection
@section('page-header')
<div class="page-title">
  <div class="row">
    <div class="col-sm-6">
      <h4>{{ $title }}</h4>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
        <li class="breadcrumb-item"><a href="#" class="default-color">الرئيسية</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
      </ol>
    </div>
  </div>
</div>
@endsection
@section('content')

<br><br>

<div class="row">
  <div class="col-xl-12 mb-30">
    <div class="card card-statistics h-100">
      <div class="card-body">
  

        <div class="form-group">
        <label for="consultationText">نص الإستشارة:</label>
        <textarea class="form-control" id="consultationText" rows="10" readonly >  {{ $consultation->content }}</textarea>
    </div>
    @if ($consultation->file)
    <div class="form-group">
       
        <a href="{{ route('download_file', $consultation->file) }}" class="btn btn-primary btn-sm" target="_blank">
            <i class="fa fa-download"></i> تنزيل الملف المرفق
        </a>
    </div>
@endif
        <div class="form-group">
          <label for="userText">إضافة تعليق:</label>
          <textarea class="form-control" id="userText" rows="5" placeholder="اكتب تعليقك هنا ..."></textarea>
        </div>

        <button type="submit" class="btn btn-success">إرسال</button> </div>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  </div>

@endsection
@section('js')
@endsection
