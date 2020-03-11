@extends('layouts.user')


@section('content')

	<div class="">
		<div class="col-lg-4">

			<h4>Ваш баланс : {{$user->bill}} KZT  </h4>
            <h4>Ваш депозитный счет : {{$user->deposit_bill}} KZT</h4>
			<h3>
			История вывода

			</h3>
		</div>
		<div class="col-lg-8 flex">
			<button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
				Сделать вывод
			</button>
		</div>
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Заполните форму для вывода</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <form action="{{route('WithdrawCreate')}}" method="get">
		        	<input type="hidden" name="user_id" value="{{$user->id}}">
                    <select name="withdraw_type" id="">
                        <option value="deposit">Депозитный счет</option>
                        <option value="bill">Баланс</option>
                    </select>
		        	<input class="form-control" style="margin-bottom: 20px;" name="amount" placeholder="Сумма вывода" type="number"><input type="submit" class="btn btn-primary">
		        </form>
		      </div>
		      <div class="modal-footer">


		      </div>
		    </div>
		  </div>
		</div>

		<table class="table table-striped">
			<thead>
				<tr>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($withdraws as $withdraw)
				<tr>
					<td>{{$withdraw->id}}</td>
					<td>{{$withdraw->amount}} KZT</td>
					<td>
						@if($withdraw->withdraw_status == 'sent')

							В ожиданий
						@elseif($withdraw->withdraw_status == 'allowed')
							Одобрено
						@else
							Отказано
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		{{$withdraws->links()}}
	</div>
	<style>
		.flex{
			display: flex;
			justify-content: flex-end;
			align-items: center;
		}
		.flex button{
			margin-top: 20px;
		}
	</style>
@endsection
