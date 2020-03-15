<!doctype html>
<html lang="en">

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

    <!--Owlcarousel-->
    <link href="{{asset('admin-vendor/plugins/owlcarousel/owl.carousel.min.css')}}" rel="stylesheet" />
    <link href="{{asset('admin-vendor/plugins/owlcarousel/owl.theme.default.min.css')}}" rel="stylesheet" />
    <!--fonts-->
    <link href="https://fonts.googleapis.com/css?family=Merriweather:300,400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,700&display=swap" rel="stylesheet">

    <!-- Morris Chart Css-->
    <link href="{{asset('admin-vendor/plugins/morrisjs/morris.css')}}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{asset('admin-vendor/css/style.css')}}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{asset('admin-vendor/css/themes/all-themes.css')}}" rel="stylesheet" />
    @stack('css')
</head>
<header>
    <?php $user = session()->get('user')?>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 logotype">
                <img src="{{asset('admin-vendor/images/bambook.png')}}" alt="" >
            </div>
            <div class="col-lg-6">
                <nav>
                    <ul>
                        <li><a href="{{route('Home')}}">Главная</a></li>
                        <li>
                            <a href="#" class="dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Магазин</a>
                            <ul  class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li><a href="{{route('shop')}}">Магазин книг</a></li>
                                <li><a href="{{route('ShopNew')}}">Остальные изделия</a></li>
                            </ul>
                        </li>


                        <li><a href="{{route('Authors')}}">Авторы</a></li>
                        <li><a href="">Контакты</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <nav class="icons">
                    <ul>
                        <li><a href="{{route('shop')}}"><i class="material-icons">search</i></a></li>
                        <li><a href="{{route('CartPage')}}">
                            <i class="material-icons">shopping_cart</i>




                        </a></li>
                        @if($user)
                        <li>
                            <a href="" class="account">{{$user->name}}</a>
                            <ul class="dropdown">
                                <li><a href="{{route('Account')}}">Мой аккаунт</a></li>
                                @if($user['status'] == 'partner')
                                    <li><a href="{{route('Main')}}">Личный кабинет</a></li>

                                @endif
                                <li><a href="{{route('Out')}}">Выйти</a></li>
                            </ul>
                        </li>

                        @else
                        <li><a href="" class="account"><i class="material-icons">perm_identity</i></a></li>
                             <ul class="dropdown">
                                <li><a href="{{route('LoginPage')}}">Войти</a></li>
                                <li><a href="{{route('RegisterPage')}}">Регистрация</a></li>

                            </ul>

                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
<body>

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


<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <h3>Напишите нам</h3>
                <p>1998 Wall Street 707, <br> Washington DC, USA</p>
                <p>
                    bookmart@domain.com <br>
                    support@gmail.com
                </p>
                <p>
                    ( 84) 0123 456 789<br>
                    ( 84) 00123 456 789
                </p>
            </div>
            <div class="col-lg-3">
                <h3>Информация</h3>
                <li><a href="">Напишите нам</a></li>
                <li><a href="">Карта сайта</a></li>
                <li><a href="">Политика конфиденциальности</a></li>
                <li><a href="">О нас</a></li>
                <li><a href="">Потребительские услуги</a></li>
            </div>
            <div class="col-lg-3">
                <h3>Мой аккаунт</h3>
                @if($user['status'] == 'registered')
                <li><a href="{{route('Account')}}">Мой аккаунт</a></li>

                <li><a href="{{route('Out')}}">Выйти</a></li>

                @elseif($user['status'] == 'partner')
                <li><a href="{{route('Account')}}">Мой аккаунт</a></li>
                <li><a href="{{route('Main')}}">Личный кабинет</a></li>
                <li><a href="{{route('Out')}}">Выйти</a></li>


                @endif
            </div>
            <div class="col-lg-3">
                <h3>Инстаграмм</h3>
                <a href=""><img src="" alt=""></a>
                <a href=""><img src="" alt=""></a>
                <a href=""><img src="" alt=""></a>
                <p>7 дней в неделю с 8.00 до 5 вечера</p>
            </div>
        </div>
    </div>
</footer>
<!-- Jquery Core Js -->
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
<!-- Owl-->
<script src="{{asset('admin-vendor/plugins/owlcarousel/owl.carousel.min.js')}}"></script>
<!-- Custom Js -->
<script src="{{asset('admin-vendor/js/admin.js')}}"></script>

<!-- Demo Js -->
<script src="{{asset('admin-vendor/js/demo.js')}}"></script>
@stack('js')
</body>

</html>
