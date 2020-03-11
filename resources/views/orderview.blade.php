@extends('layouts.user')


@section('content')


    <div class="row">
        <div class="col-lg-12">
            <a href="{{route('Orders')}}" class=" m-b-25 btn btn-primary">Назад</a>
        </div>
        <div class="col-lg-6">
            <div class="card text-left p-l-20 p-t-20 p-b-20">
                <h4>Номер заказа: {{$order->id}}</h4>
                <h4>Сумма заказа: {{$order->total}}</h4>
                <h4>Количество товаров: {{$order->quantity}}</h4>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card text-left p-l-20 p-t-20 p-b-20">
                <h4>Адрес доставки: {{$order->address}}</h4><h4>Почтовый индекс: {{$order->index}}</h4><h4>Город доставки: {{$order->city}}</h4>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Фото</th>
                        <th>Название книги</th>
                        <th>Количество</th>
                        <th>Цена</th>
                        <th>Сумма</th>


                    </tr>
                    </thead>
                    <tbody>


                    @foreach($products as $product)
                        <tr>
                            <td><img src="{{$product->image1}}" alt=""></td>
                            <td>{{$product->title}}</td>
                            <td>
                                {{$product->quantity}}
                            </td>

                            <td>{{$product->price}}KZT</td>
                            <td>
                                {{$product->quantity*$product->price}}KZT
                            </td>

                        </tr>
                    @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <style>

        td{
            width: 20%;
            height: 200px;
        }
        td img{
            width: 100%;
        }
    </style>
@endsection
