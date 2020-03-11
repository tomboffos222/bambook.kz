@extends('layouts.user')


@section('content')
    @if(!empty($secondTree))
        <a href="{{route('Tree',$user->id)}}" class="btn-primary btn">Вернуться на первый этап</a>
        <button data-toggle="modal" data-target="#modalBot" href="" class="btn btn-danger">Добавить бота</button>
        <div id="modalBot" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Добавить бота</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{Route('AddBot')}}" method="get">
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <input type="password" name="password" placeholder="Введите пароль" class="form-control" >
                            <input type="submit" value="Добавить"  class="btn btn-danger m-t-10">
                        </form>

                    </div>
                </div>

            </div>
        </div>
        @endif

    <div style="overflow: auto;padding-bottom: 50px">
        <div class="children">
        @if(empty($secondTree))
            @component('treeUser',['user'=>$user,'maxColumnCount'=>5,'i'=>0,'secondTree' => null,])

            @endcomponent


            @else
                @component('treeUser',['user'=>$user,'maxColumnCount'=>5,'i'=>0,'secondTree' => $secondTree,])

                @endcomponent
            @endif


        </div>
    </div>
    <div class="col-lg-12 text-center">
        @if(empty($secondTree))
            <h4>Первый этап</h4>
        @else
            <h4>Второй этап</h4>

        @endif
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 text-center">
            @if(!empty($exception))
                @if($exception == 1)
                    <a href="{{route('SecondTree',$user->id)}}" class="btn btn-danger">
                        Перейти на второй этап
                    </a>
                @else
                    <button disabled class="btn btn-danger">
                        Второй этап будет доступен после закрытия пятого ряда
                    </button>
                @endif
                @endif
        </div>
    </div>
    <style>
        .tree{
            border-bottom: 1px solid rgba(67, 67, 67, 0.77);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            margin: 0 10px;
            min-width: 150px;
            height: 80px;
        }
        .tree span{
            display: flex;
            justify-content: center;
            align-items: center;
            width: 15px;
            height: 15px;
            background: #11ff0f;
            border-radius: 50%;
            color: #000;
            font-size: 10px;
            position: relative;
            right: -15px;
            top: 10px;
        }


        .children{
            display: flex;
        }
        .line{
            margin: 0   auto;
        }


    </style>


@endsection
