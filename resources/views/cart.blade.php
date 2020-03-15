@extends('layouts.base')


@section('content')

    <?php $user = session()->get('user');

    ?>
<div class="container main">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Фото</th>
				<th>Название книги</th>
				<th>Количество</th>
				<th>Цена</th>
                <th>Сумма</th>
				<th>Действие</th>

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
                    {{$product->price * $product['quantity']}}KZT
                </td>
				<td>
                    @php
                        $user = session()->get('user');

                        @endphp
                    <form action="{{route('DeleteProduct')}}" method="get">


                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <button type="submit"  class="btn btn-danger">Удалить</button>
                    </form>

				</td>

			</tr>
			@endforeach

		</tbody>

	</table>
	<div class="flex">

		 {{$total}} KZT
        <form action="{{route('OrderForm')}}" method="get">
            <input type="hidden" name="total" value={{$total}}>

            <input type="hidden" name="quantity" value={{$quantity}}>

            <button type="submit" class="btn btn-primary m-l-25 p-t-10 p-b-10 red">Оплатить</button>

        </form>
		<a href="{{Route('DeleteAll')}}" class="btn btn-primary p-t-10">
			Очистить корзину
		</a>
	</div>
</div>
<style>

	 .container.main{
		padding:100px 0px;
	}
	.flex{
		display: flex;
		justify-content: flex-end;
		padding:25px 0px;
		font-size: 20px;
	}
	.flex a{
		margin-left: 20px;
	}
	td{
		width: 25%;
	}
	td img{
		width: 100%;
		height: 300px;
	}
</style>
@endsection
