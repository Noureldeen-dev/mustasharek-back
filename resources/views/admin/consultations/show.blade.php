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
                <h5>تفاصيل الإستشارة</h5>
                <div class="form-group">
                    <label for="id">رقم الإستشارة :</label>
                    <input class="form-control" id="consultation_id" name="consultation_id" value="{{ $consultation->id }}" readonly>
                </div>
                <div class="form-group">
                    <label for="consultationText">نص الإستشارة:</label>
                    <textarea class="form-control" id="consultationText" rows="10" readonly>{{ $consultation->content }}</textarea>
                </div>
                
                @if ($consultation->file)
                <div class="form-group">
                    <a href="{{ route('download_file', $consultation->file) }}" class="btn btn-primary btn-sm" target="_blank">
                        <i class="fa fa-download"></i> تنزيل الملف المرفق
                    </a>
                </div>
                @endif

                <h5>إضافة تعليق:</h5>
                <form action="{{ route('consultations.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <textarea class="form-control" id="reply" name="reply" rows="5" placeholder="اكتب تعليقك هنا ..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="file" class="mr-sm-2">رفع مرفق :</label>
                        <input class="form-control-file" type="file" name="file" />
                    </div>
                    <button type="submit" class="btn btn-success">إرسال</button>
                </form>

                <!-- عرض الردود السابقة -->
                <div class="mt-4">
                    <h4>الردود السابقة:</h4>
                    @if ($consultation->replies->isEmpty())
                        <p>لا توجد ردود حتى الآن.</p>
                    @else
                        <div class="chat-container">
                            @foreach ($consultation->replies as $reply)
                                <div class="chat-message">
                                    <p><strong>{{ $reply->user->name }}</strong> <small>{{ $reply->created_at->format('Y-m-d H:i') }}</small></p>
                                    <p>{{ $reply->reply }}</p>
                                    @if ($reply->file)
                                        <a href="{{ route('download_file', $reply->file) }}" class="btn btn-link" target="_blank">
                                            <i class="fa fa-download"></i> تنزيل المرفق
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<style>
    .chat-container {
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 5px;
        max-height: 400px;
        overflow-y: auto;
    }
    .chat-message {
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 4px;
        background-color: #f8f9fa;
    }
    .chat-message strong {
        display: block;
    }
</style>
@endsection