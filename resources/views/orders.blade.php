@extends('layouts.user')

@section('content')

    <div class="row">

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Номер заказа</th>
                <th>Количество</th>
                <th>Сумма</th>

                <th>Вид доставки</th>
                <th>Адрес</th>
                <th>Город</th>

                <th>Регион</th>
                <th>Почтовый индекс</th>
                <th>Статус</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
            <tr>

                <td><a href="{{route('OrderView',$order->id)}}">{{$order->id}}</a></td>
                <td>{{$order->quantity}}</td>
                <td>{{$order->total}}</td>

                <td>
                    @if($order->type_of_order == 'pick_up')
                        Самовывоз
                        @else
                        Каз почта

                        @endif
                </td>
                <td>
                    {{$order->address}}
                </td>
                <td>
                    {{$order->city}}
                </td>
                <td>
                    {{$order->region}}
                </td>
                <td>
                    {{$order->index}}
                </td>
                <td>
                    @if($order->status == 'success')
                        Успешно оплачено
                        @elseif($order->status == 'waiting')
                        Ожидается оплаты
                    @else
                        Не удалось
                    @endif
                </td>

            </tr>
                @endforeach
            </tbody>

        </table>
        {{$orders->links()}}
    </div>


@endsection
