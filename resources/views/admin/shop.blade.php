@extends('layouts.admin')



@section('content')

	<div class="flex">

		<button class="categoryButton">Категории</button><button class="authors">Авторы</button>
	</div>

	<div class="categories tablet">
		<div class="">
			<button class="btn purple" data-toggle="modal" data-target="#category">Добавить категорию</button>
		</div>
		<table class="table table-striped ">
			<thead>
				<tr>
					<th>ID</th>
					<th>Категории</th>
					<th>Действия</th>
				</tr>
			</thead>
			<tbody>
				@foreach($categories as $category)
				<tr>
					<td>{{$category->id}}</td>
					<td>{{$category->chars}}</td>
					<td></td>
				</tr>
				@endforeach
			</tbody>

		</table>

		{{$categories->links()}}
	</div>
	<div class="author tablet">
		<div class="">
			<button class="btn purple" data-toggle="modal" data-target="#author">Добавить автора</button>
		</div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Фото</th>
					<th>Имя</th>

					<th>Год рождения</th>
					<th>Пол</th>
					<th>Книг выпущенно</th>
					<th>Адрес</th>
					<th>Действие</th>

				</tr>

			</thead>
			<tbody>

				@foreach($authors as $author)
				<tr>

					<td><img src="{!! $author->image1 !!}" alt=""></td>
					<td>{{$author->Name}}</td>
					<td>{{$author->Birth}}</td>
					<td>{{$author->gender}}</td>
					<td>{{$author->Books}}</td>
					<td>{{$author->Address}}</td>
					<td></td>
				</tr>
				@endforeach
			</tbody>
		</table>

		{{$authors->links()}}
	</div>
	<div class="modal fade" id="category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Добавить категорию</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form action="{{route('admin.CategoryAdd')}}" method="get">
	        	<div class="">
	        		<input type="text" name="category"class="form-control" placeholder="Ваша категория">


	        	</div>
	        	<div class="modal-footer">
	        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
	        		<button type="submit" class="btn btn-primary red">Добавить</button>

	      		</div>

	        </form>
	      </div>

	    </div>
	  </div>
	</div>
	<div class="modal fade" id="author" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Добавить  автора</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form action="{{route('admin.AuthorAdd')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
	        	<div class="">
	        		<label for="">Фото автора</label> <br>
	        		<input type="file" name="image" accept="image/jpeg,image/png,image/gif">
	        	</div>
	        	<div class="">
	        		<label for="">Имя автора</label>
	        		<input type="text" name="name" class="form-control" placeholder="Имя автора">



	        	</div>
	        	<div class="">
	        		<label for="">Дата рождения</label>
	        		<input type="date" name="birth" class="form-control" placeholder="Дата рождения">
	        	</div>
	        	<div class="">
	        		<label for="">Число книг</label>
	        		<input type="number" name="books" class="form-control" placeholder="Число книг">
	        	</div>
	        	<div class="">
	        		<label for="">Адрес автора</label>
	        		<input type="Address" name="address" class="form-control" placeholder="Адрес автора">
	        	</div>
	        	<div class="">
	        		<label for="">Описание</label>
	        		<textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
	        	</div>
	        	<div class="">
	        		<label for="">Пол автора</label> <br>
	        		<select name="gender" id="">
	        			<option value="male">Мужчина</option>
	        			<option value="female">Женщина</option>
	        		</select>
	        	</div>
	        	<div class="modal-footer">
	        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
	        		<button type="submit" class="btn btn-primary red">Добавить</button>

	      		</div>

	        </form>
	      </div>

	    </div>
	  </div>
	</div>

	<style>
		form div{
			margin-bottom: 10px;
		}
		td img{
			width: 100%;
			height: 100px;
		}
		.author td{
			width: 15%;

		}
		.flex{
			display: flex;
			justify-content: space-around;
			margin-bottom: 20px;

		}
		.flex button{
			display: block;
			width: 150px;
			height: 50px;
			background-color: #F44336;
			border:none;
			color:#fff;
			font-weight: 700;
			cursor: pointer;
			transition: .5s ease;

		}
		.btn.dropdown-toggle.btn-default{
			display: none;
		}

		.flex button:hover{
			background-color: blue;
		}

	</style>
@endsection
