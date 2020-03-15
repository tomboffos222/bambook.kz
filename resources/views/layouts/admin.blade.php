<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>{{$title ?? 'RCORE'}}</title>
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" type="image/x-icon">
    <link rel="icon" href="{{asset('images/favicon.png')}}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{asset('admin-vendor/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{asset('admin-vendor/plugins/node-waves/waves.css')}}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{asset('admin-vendor/plugins/animate-css/animate.css')}}" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="{{asset('admin-vendor/plugins/morrisjs/morris.css')}}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{asset('admin-vendor/css/style.css')}}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{asset('admin-vendor/css/themes/all-themes.css')}}" rel="stylesheet" />
    @stack('css')
</head>

<body class="theme-red" style="background-color: #ececec;">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Please wait...</p>
    </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->
<!-- Search Bar -->

<!-- #END# Search Bar -->
<!-- Top Bar -->
<nav class="navbar " style="background-color:#3498db;">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="">Админ-панель</a>
        </div>
    </div>
</nav>
<!-- #Top Bar -->
<section >
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar" style="background-color: #3498db;">
        <!-- User Info -->
        <div class="user-info">
            <div class="image">
                <img src="{{asset('admin-vendor/images/user.png')}}" width="48" height="48" alt="User" />
            </div>
            <div class="info-container">
                <?php $admin = session()->get('admin')?>
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$admin->name}}</div>
                <div class="email">{{$admin->username}}</div>
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="{{route('admin.Out')}}"><i class="material-icons">input</i>Выйти</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">НАВИГАЦИЯ</li>
                <li class="">
                    <a href="{{route('admin.Users')}}">
                        <i class="material-icons">home</i>
                        <span>пользователи</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.Discounts')}}">
                        <i class="material-icons">loyalty</i>
                        <span>Скидки BS</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.Orders')}}">
                        <i class="material-icons">shopping_cart</i>
                        <span>Заказы</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.WithdrawShow')}}">
                        <i class="material-icons">attach_money</i>
                        <span>Выводы</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.ProductView')}}">
                         <i class="material-icons">work_outline</i>
                        <span>продукты</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.ShopView')}}">
                        <i class="material-icons">shopping_cart</i>
                        <span>управление магазином</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.BlackList')}}">
                        <i class="material-icons">close</i>
                        <span>Черный список</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.MessagePage')}}">
                        <i class="material-icons">mail</i>
                        <span>Писма для тех поддержки</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.Tree')}}">
                        <i class="material-icons">home</i>
                        <span>Матрица</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('Home')}}">
                        <i class="material-icons">web</i>
                        <span>Домой</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('Out')}}">
                        <i class="material-icons">undo</i>
                        <span>Выход</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
    </aside>
</section>

<section class="content" >
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    @yield('content')
</section>

<script
    src="https://code.jquery.com/jquery-2.2.4.min.js"
    integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
    crossorigin="anonymous"></script>

<!-- Bootstrap Core Js -->
<script src="{{asset('admin-vendor/plugins/bootstrap/js/bootstrap.js')}}"></script>

<!-- Select Plugin Js -->
<script src="{{asset('admin-vendor/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

<!-- Slimscroll Plugin Js -->
<script src="{{asset('admin-vendor/plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{asset('admin-vendor/plugins/node-waves/waves.js')}}"></script>

<!-- Jquery CountTo Plugin Js -->
<script src="{{asset('admin-vendor/plugins/jquery-countto/jquery.countTo.js')}}"></script>

<!-- Custom Js -->
<script src="{{asset('admin-vendor/js/admin.js')}}"></script>

<!-- Demo Js -->
<script src="{{asset('admin-vendor/js/demo.js')}}"></script>
@stack('js')
</body>

</html>
