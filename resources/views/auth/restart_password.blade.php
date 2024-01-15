@extends('frontend.layouts.master')
@section('title_page','Xác nhận - Cập nhật tài khoản')
@section('content')
    <div class="breadcrumb-wrapper mt-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcumb">
                        <a href="#" style="color: #007bff">Tài khoản</a>
                        <span class="breadcumb-icon mx-1"><i class="fa-solid fa-angles-right"></i></span>
                        <span>Quên mật khẩu</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <form method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" name="email" placeholder="doan@..." class="form-control" value="">
                        @error('email')
                        <small id="emailHelp" class="form-text text-danger">{{ $errors->first('email') }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Xác nhận thông tin</button>
                </form>
            </div>
        </div>
    </div>
@stop
