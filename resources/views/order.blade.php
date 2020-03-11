@extends('layouts.base')



@section('content')

    <div class="container">
       <div class="row">
           <div class="col-lg-3">
               <div class="card text-center p-t-10 p-b-10">

                   Общая сумма - 5% скидки
                   <h2>{{$total}}</h2>
               </div>
               <div class="card text-center p-t-10 p-b-10 m-t-10">
                   Количество книг
                   <h2>
                       {{$quantity}}
                   </h2>
               </div>
           </div>
           <div class="col-lg-6 text-center">
               <form action="{{route('OrderCreate')}}" method="get" class="text-center ml-auto mr-auto">
                <?php
                   $user = session()->get('user');
                   ?>
                   <input type="hidden" name="total" value="{{$total}}">

                    <div class="">
                        <input type="number" placeholder="Почтовый индекс"  class="form-control" name="index">
                    </div>

                   <div class=""><input type="tel" class="form-control" placeholder="Телефон" required name="phone_number"></div>
                   <div class=""><input type="text" class="form-control" placeholder="Адрес" required name="address"></div>
                   <div class=""><input type="text" class="form-control" placeholder="Регион" required name="region"></div>
                   <div class=""><input type="text" class="form-control" placeholder="Город" required name="city"></div>
                   <input type="hidden" name="quantity" value="{{$quantity}}">
                   <input type="hidden" name="user_id" value="{{$user->id}}">
                   <div class="">
                       <select name="type_of_order" id="">
                           <option value="pick_up">Самовывоз</option>
                           <option value="kaz_mail">Каз почта</option>
                       </select>
                   </div>
                    <div class="">
                        <select name="purchase" id="">
                            <option value="deposit_balance">Депозитный счет</option>
                            <option value="balance">Через баланс</option>
                            <option value="smartpay">Smartpay</option>
                        </select>
                    </div>
                   <div class="">
                       <input type="submit" class="btn-primary btn">
                   </div>
               </form>
           </div>
       </div>
    </div>
    <style>
    form div{
        margin-bottom: 20px;
    }
    </style>
@endsection
