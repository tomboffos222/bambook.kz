@extends('layouts.base')




@section('content')

	<div class="pluser container">
		<div class="row">
			<div class="col-lg-12">
				<h1>
					Повышение статуса
				</h1>
				<p>
					Для того чтобы повысить аккаунт на статус партнера нужно оплатить 20000 KZT
				</p>
				<h4>

				</h4>
				<a href="{{route('AccountUp')}}" class="btn btn-primary">Повысить статус</a>

			</div>
		</div>
	</div>
	<style>
		body{
			color:#000;
		}
		.pluser{
			padding-top:75px;
			padding-bottom: 75px;
		}
		.btn{
			margin-right: 30px;
			margin-top: 20px;
		}
	</style>

@endsection
