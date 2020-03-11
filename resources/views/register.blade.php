@extends('layouts.base')

@section('content')
    <div class="container">
       <div class="row">

           <form class="col-md-4 col-md-offset-4" action="{{route("Register")}}" method="post">
               <h2>Регистрация</h2>
               {{csrf_field()}}


                <div class="form-group">
                   <label for="password">Введите ваш Пароль</label>
                   <input class="form-control" placeholder="" type="password" required id="password" name="password">
               </div>
               <div class="form-group">
                   <label for="name">Введите ваше ФИО</label>
                   <input class="form-control" placeholder="Например Кайрат Нуртас" type="text" required id="name" name="name">
               </div>
               <div class="for-group">
                   <label for="" class="">ID консультанта</label>
                   <input type="number"  name="referBy" class="form-control">
               </div>
               <div class="form-group">
                 <label for="zhsn">Введите ИИН</label>
                 <input type="number" class="form-control" id="zhsn" name="zhsn" required>
               </div>
               <div class="form-group">
                   <label for="email">Введите ваш Email</label>
                   <input class="form-control" type="email" required id="email" name="email">
               </div>
               <div class="form-group">
                   <label for="phone">Введите ваш Телефон номер</label>
                   <input class="form-control" type="number" required id="phone" name="phone">
               </div>

               <div>
                    <button class="btn btn-primary">Отправить</button>
               </div>
           </form>
       </div>
    </div>
    <style>
      form{
        box-shadow: 0 0 10px rgba(0,0,0,0.5);
        padding:20px 10px;
        margin-bottom: 40px;
      }
      input{
        box-shadow: 0 0 2px rgba(0,0,0,0.5) !important;
        border:1px solid #000;
        padding:10px 10px !important;
      }
    </style>
@endsection

@push('cs')
    <style>
      form{
        border:1px solid #000;
      }
        input{

        }
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
@endpush
