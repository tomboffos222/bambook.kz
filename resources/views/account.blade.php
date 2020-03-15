@extends('layouts.base')


@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="flex ">
					<button class="btn btn-primary green" type="button" data-target="#exampleModalCenter" data-toggle="modal">Изменить аккаунт</button>
					<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-centered" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLongTitle">Изменить аккаунт</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <form action="{{route('EditUser')}}" method="get">
					        	<div class="">
					        		<input type="hidden" name="id" value="{{$user->id}}">
					        		<input type="text"  class="form-control" name="name" value="{{$user->name}}">
					        	</div>
					        	<div class="">
					        		<input type="text" class="form-control" name="email" value="{{$user->email}}">

					        	</div>
					        	<div class="">
					        		<input type="number" class="form-control" name="zhsn" value="{{$user->zhsn}}">
					        	</div>
					        	<div class="">
					        		<input type="number" class="form-control" name="phone" value="{{$user->phone}}">
					        	</div>
					        	<div class="">
					        		<input type="text" name="password"	placeholder="Ваш пароль" class="form-control">
					        	</div>
					        	<input type="submit" class="btn red btn-primary">
					        </form>
					      </div>
					      <div class="modal-footer">


					      </div>
					    </div>
					  </div>
					</div>
					@if($user->status == 'registered')
					<a href="{{route('Up')}}" class="btn btn-primary red">Повысить статус</a>
					@endif
                    @if($exception == 1)
                    <button class="btn btn-primary  m-l-15" type="button" data-target="#discount" data-toggle="modal">Получение скидки Bs аккаунт</button>
                    <div class="modal fade" id="discount" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Получить скидку Bs аккаунт</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('GetDiscount')}}" method="get">
                                        <div class="">
                                            <input type="hidden" name="user_id" value="{{$user->id}}">
                                            <input type="number" name="bs_id" class="form-control" placeholder="Введите bs_id">
                                        </div>
                                        <div class="">
                                            <input type="number" class="form-control" name="zhsn" value="{{$user->zhsn}}">

                                        </div>
                                        <div class="">
                                            <input type="text" class="form-control" name="login" value="" placeholder="Ваш логин в business sauat">
                                        </div>

                                        <input type="submit" class="btn red btn-primary">
                                    </form>
                                </div>
                                <div class="modal-footer">


                                </div>
                            </div>
                        </div>
                    </div>
                        @elseif($exception != 1)
                        <button disabled class="btn btn-primary m-l-15">Вы уже подали заявку</button>
                    @endif



				</div>
			</div>
		</div>
	</div>
	<div class="section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<table class="table table-striped">
						<tbody>
							<tr>
								<td>Ваш логин</td>
								<td>{{$user->login}}</td>

							</tr>
							<tr>
								<td>Ваше имя</td>
								<td>{{$user->name}} </td>

							</tr>
							<tr>
								<td>Ваш статус</td>
								<td>
									@if($user->status == 'registered')

										Зарегистрированный
									@elseif($user->status == 'partner')

										Партнер
									@endif

								</td>
							</tr>
							<tr>
								<td>Ваш email</td>
								<td>{{$user->email}}</td>
							</tr>
							<tr>
								<td>Ваш ИИН</td>
								<td>{{$user->zhsn}}</td>
							</tr>
							<tr>
								<td>Ваш телефон</td>
								<td>{{$user->phone}}</td>
							</tr>
							<tr>
								<td>Ваш счет</td>
								<td>{{$user->bill}} KZT</td>
							</tr>
							<tr>
								<td>Ваш пароль</td>
								<td>{{$user->password}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<style>
		form div{
			margin-bottom: 15px;
		}
		.flex a{
			margin-left: 20px;
		}
		.flex{
			display: flex;
			align-items: center;
			justify-content: flex-end;
			padding:20px 0px;
		}
	</style>
@endsection
