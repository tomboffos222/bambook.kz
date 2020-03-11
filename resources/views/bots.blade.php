@extends('layouts.user')


@section('content')
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2>Чтобы добавить бота вам надо войти на второй этап</h2>
        </div>
        <div class="col-lg-12">

            @if($bots)
                <h3>Ботов нет </h3>
                @else

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Логин</th>
                    <th>Пароль</th>
                    <th>Имя</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bots as $bot)

                <tr>
                    <td>{{$bot->login}}</td>
                    <td>{{$bot->password}}</td>
                    <td>{{$bot->name}}</td>

                </tr>
                    @endforeach
                </tbody>
            </table>
                @endif
        </div>
        <div class="col-lg-12">
            {{$bots->links()}}
        </div>
    </div>





    @endsection
