@extends('layouts.admin')


@section('content')
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
 		 Добавить товар
	</button>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>
					фото
				</th>
				<th>
					Имя
				</th>
				<th>
					Цена
				</th>
				<th>
					Характеристики
				</th>

				<th>
					Статус
				</th>
				<th>
					Автор
				</th>
				<th>
					Действия
				</th>
			</tr>
		</thead>
		<tbody>
			@foreach($products as $product)
				<tr>
					<td>
						<img src="{!! $product->image1 !!}" alt="">
					</td>
					<td>
						{{$product->title}}
					</td>
					<td>
						{{$product->price}}

					</td>
					<td>
						{{$product->chars}}
					</td>
					<td>
						@if($product->status  == 1)
							В наличии
						@else
							Нет в наличии
						@endif

					</td>
					<td>
						{{$product->author}}
					</td>



				</tr>

			@endforeach

		</tbody>


	</table>
	{{$products->links()}}
	<style>
		td img{

			height: 150px;
			width: 100%;
		}
		td{
			width: 12%;
		}

	</style>


<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Добавить товар</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <form action="{{route('admin.CreateProduct')}}" method="post"  enctype="multipart/form-data">
                    {{csrf_field()}}
		        	<label for="">Фото</label>
		        	<input type="file" placeholder="Фото" name="img" class="form-control">
		        	<br>
		        	<input type="text" name="title" class="form-control" placeholder="Название книги">
		        	<br>
		        	<input type="number" name="price" placeholder="Цена" class="form-control">
		        	<br>
		        	<select name="category" class="custom-select" id="">
		        		@foreach($categories as $category)
		        		<option value="{{$category->chars}}">{{$category->chars}}</option>
		        		@endforeach
		        	</select>
		        	<br>
		        	<select name="author" class="custom-select" id="">
		        		@foreach($authors as $author)
		        		<option value="{{$author->Name}}">{{$author->Name}}</option>
		        		@endforeach
		        	</select>
		        	<br>
		        	<textarea placeholder="Описание" name="description" class="form-control"></textarea>
		        	<br>
		        	<input type="checkbox" placeholder="" id="stock" name="stock"><label for="stock">Товар в наличии</label>
		        	<br>
		        	<input type="submit" class="btn btn-primary form-control">
		        </form>
		      </div>
		      <div class="modal-footer">


		      </div>
		    </div>
		  </div>
		</div>
		<style>
			button.dropdown-toggle{
				display: none;

			}
			select{
				margin-bottom: 20px;
			}
		</style>
@endsection


