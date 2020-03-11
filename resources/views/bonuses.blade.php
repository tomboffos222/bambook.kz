@extends('layouts.user')


@section('content')
    <div class="row">

        <div class="col-lg-12">


                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Описание</th>
                        <th>Сумма</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bonuses as $bonus)

                        <tr>
                            <td>{{$bonus->desc}}</td>
                            <td>{{$bonus->sum}}</td>


                        </tr>
                    @endforeach
                    </tbody>
                </table>

        </div>
        <div class="col-lg-12">
            {{$bonuses->links()}}
        </div>
    </div>






@endsection
