@extends('layouts.user')


@section('content')
    <div class="level bg-primary-gradient col-md-3">
        <p>Ваш уровень : </p> <b> {{$tree->level}}</b>

    </div>

    <div class="level green col-md-3">
        <p>Ваш счет : </p><b>{{$user->bill}} kzt</b>
    </div>
    <div class="level red col-md-3">
        <p>Люди приглашены :</p><b> {{$referBy}} </b>
    </div>
    <div class="level purple col-md-3">
        <p>Ваши боты : </p><b> {{$botCount}} </b>
    </div>
    <div class="level bg-purple m-t-30 col-md-3">
        <p>Депозитный счет : </p><b>{{$user->deposit_bill}} </b>
    </div>



    <style>

    </style>
@endsection
