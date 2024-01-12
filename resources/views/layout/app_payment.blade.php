<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>TOPCODE - {{ date('Y') }}</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/dashboard/">
    <!-- Bootstrap core CSS -->
    <link href="{{asset('theme_admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{asset('theme_admin/css/dashboard.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .nav-tab-profile .nav-item.active {
            border-bottom:  1px solid #dedede;
        }
        .select2-container--default .select2-selection--single {
            height: 48px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 48px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 48px !important;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="">TOPCODE</a>
    <a class="navbar-brand mr-0" style="padding-left: 5px;padding-right: 5px" href="/" target="_blank">Về trang web</a>
    <input class="form-control form-control-dark w-80" type="text" placeholder="Search" aria-label="Search">
    <div class="dropdown" style="margin-right: 10px;">
        <button class="btn dropdown-toggle" style="background: none;color: white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="" onerror="this.src='https://123code.net/images/preloader.png';" style="width: 40px;height: 40px;border-radius: 50%" alt="">
        </button>
{{--        <div class="dropdown-menu" style="left: unset;right: 10px" aria-labelledby="dropdownMenu2">--}}
{{--            <a href="{{ route('get_admin.profile.index') }}" class="dropdown-item" title="Cập nhật thông tin">Cập nhật thông tin</a>--}}
{{--            <a href="{{ route('get_admin.logout') }}" title="Đăng xuất" class="dropdown-item">Đăng xuất</a>--}}
{{--        </div>--}}
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
{{--                        <a class="nav-link" href="{{ route($item['route']) }}" title="{{ $item['name'] }}">--}}
{{--                            <span data-feather="{{ $item['icon'] }}"></span>--}}
{{--                            {{ $item['name'] }}--}}
{{--                        </a>--}}
                    </li>
                </ul>
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>-----------</span>
                </h6>
            </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            @yield('content')
        </main>
    </div>
</div>
<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
{{--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>--}}
<script src="https://code.jquery.com/jquery-3.1.1.min.js">
    <script src="{{ asset('theme_admin/js/popper.min.js') }}"></script>
<script src="{{ asset('theme_admin/js/bootstrap.min.js') }}"></script>
<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace();
</script>
@yield('script')
</body>
</html>
