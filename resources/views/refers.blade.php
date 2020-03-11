@extends('layouts.user')


@section('content')
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2>Чтобы пригласить пользователей надо им написать свой ID</h2>

            <h3>ваш ID : {{$user->id}}</h3>
        </div>
        <div class="col-lg-12">

            @if($refers)
                <h3>Реферальных пользователей нет </h3>
            @else

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Логин</th>

                        <th>Имя</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($refers as $bot)

                        <tr>
                            <td>{{$bot->login}}</td>

                            <td>{{$bot->name}}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="col-lg-12">
            {{$refers->links()}}
        </div>
    </div>






@endsection
