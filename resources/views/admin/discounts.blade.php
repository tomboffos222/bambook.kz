@extends('layouts.admin')

@section('content')
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>

            <th>Логин</th>
            <th>Телефон номер</th>
            <th>email</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($discounts as $user)
            <tr>
                <td>{{$user->bs_id}}</td>

                <td>{{$user->login}}</td>
                <td>{{$user->phone}}</td>
                <td>{{$user->email}}</td>
                <td>
                    @if($user['discount'] == 'wait')
                        <a href="{{route('admin.Discount',$user->id)}}" class="btn btn-primary">Одобрить</a>

                        @else
                        Уже одобрено
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$discounts->links()}}
@endsection
