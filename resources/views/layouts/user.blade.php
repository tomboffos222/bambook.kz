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
<nav class="navbar" style="background-color:#3498db;">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="">Личный кабинет</a>
        </div>
    </div>
</nav>
<!-- #Top Bar -->
<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar" style="background-color:#3498db;">
        <!-- User Info -->
        <div class="user-info">
            <div class="image" style="display:flex;">
                <img src="{{asset('admin-vendor/images/user.png')}}" width="48" height="48" alt="User" style="align-items:top; margin-right: 20px;" />
                <div class="col-white">
                    <b>
                    Id: {{$user->login}} <br>
                    Имя: {{$user->name}} <br>


                    <a href="{{route('Edit')}}" class=" btn red " style="margin-top:10px; color:#fff;" >
                        <img src="{{asset('admin-vendor/images/wheel.svg')}}" alt="" style="width:20px;margin-right: 10px;">
                        Редактровать
                    </a>
                </div>

            </div>
            <div class="info-container">


            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list">

                <li>
                    <a href="{{route('Main')}}">
                        <i class="material-icons">home</i>
                        <span>Главная</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('Home')}}">
                        <i class="material-icons">web</i>
                        <span>На сайт</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('WithdrawShow')}}">
                        <i class="material-icons">attach_money</i>
                        <span>Выводы</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('Refers')}}">
                        <i class="material-icons">accessibility_new</i>
                        <span>Приглашенные пользователи</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('Bonuses')}}">
                        <i class="material-icons">redeem</i>
                        <span>Бонусы</span>

                    </a>
                </li>
                <li>
                    <a href="{{route('Orders')}}">
                        <i class="material-icons">move_to_inbox</i>
                        <span>Заказы</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('Bots')}}">
                        <i class="material-icons">how_to_reg</i>
                        <span>Боты</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('Tree',$user->id)}}">
                        <i class="material-icons">view_comfy</i>
                        <span>Матрица</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('MessagePage')}}">
                        <i class="material-icons">mail</i>
                        <span>Письмо тех поддержке</span>
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
<section class="content">
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
