@extends('layouts.app')
@section('title')
    تسجيل الدخول
@endsection
<style>

</style>
@section('content')
    <div class="background-img">
        <div class="container" style="height:100vh">
            <div class="  d-flex justify-content-center align-items-center " style="height:100%;">
                <div class="card card-statistics " style="min-width:30%">
                    <div class="card-body ">


                        <img src={{ asset('assets/images/mustasharek.png') }} style="width: 100%; height: 300px;" alt="Responsive image">

                        <form method="POST" action="{{ route('login') }}" class="p-3">
                            @csrf
                            <h2 class="mb-3">تسجيل الدخول</h2>
                            <label for="email" class=" col-form-label">البريد الالكتروني</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder='البريد الالكتروني' name="email" value="{{ old('email') }}" required
                                autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label for="password" class=" col-form-label ">كلمة السر</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder='كلمة السر'
                                name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="my-3 form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label mx-1" for="remember">
                                    تذكرني
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary my-2">
                                تسجيل الدخول
                            </button>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
