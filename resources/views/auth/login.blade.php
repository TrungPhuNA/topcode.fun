@extends('layout.app_payment')
@section('title_page','Đăng nhập')
@section('content')
    <div class="breadcrumb-wrapper mt-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcumb">
                        <a href="#" style="color: #007bff">Tài khoản</a>
                        <span class="breadcumb-icon mx-1"><i class="fa-solid fa-angles-right"></i></span>
                        <span>Đăng nhập</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <form method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="text" name="email" placeholder="Email" class="form-control" value="{{ old('email', $user->email ?? "") }}">
                        @error('email')
                        <small id="emailHelp" class="form-text text-danger">{{ $errors->first('email') }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input type="password" name="password" placeholder="******" class="form-control" value="">
                        @error('password')
                        <small id="emailHelp" class="form-text text-danger">{{ $errors->first('password') }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div style="display: flex; justify-content: space-between">
                            <p>Bạn chưa có tài khoản?  đăng ký <a href="{{ route('get.register') }}"> tại đây</a></p>
                            <p>Quên mật khẩu?  Cấp lại <a href="{{ route('get.restart_password') }}"> tại đây</a></p>
                        </div>
                        <button type="submit" class="btn btn-primary">Đăng nhập</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
