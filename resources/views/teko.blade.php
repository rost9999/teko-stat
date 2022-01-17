@extends('layouts')
@section('content')
<?php
$months = [
    'previousCount' => 'Попередній місяць',
    'currentCount'  => 'Вибраний місяць',
    'name'          => 'Назва',
    'diff'          => 'Різниця',
    'article'       => 'Артикул',
    '1'             => 'Січень',
    '2'             => 'Лютий',
    '3'             => 'Березень',
    '4'             => 'Квітень',
    '5'             => 'Травень',
    '6'             => 'Червень',
    '7'             => 'Липень',
    '8'             => 'Серпень',
    '9'             => 'Вересень',
    '10'            => 'Жовтень',
    '11'            => 'Листопад',
    //    '12'=>'Грудень'
]
?>
<div class="container">
    <div class="row">
        <h1><a href="/">Теко-Трейд 2021 рік</a></h1>
{{--                <h3 style="display: inline;">{{$months[$month]}} {{$shop}} {{$torg3}} {{$tm}} {{$article}}</h3>--}}
    </div>
    <div class="row">
        <table class="table">
            <thead>
            <tr>
                @foreach($data[0] as $key => $value)
                    <th scope="col">{{$months[$key]}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($data as $key => $value)
                <tr>
                    <?php $link = str_replace(' ', '+', current($value));
                    if (isset($value['article'])) {
                        $link = $value['article'];
                    }?>
                    <td><a href="{{$GLOBALS["_SERVER"]["REQUEST_URI"].'/'.$link}}">{{$value['name']}}</a></td>
                    <td>{{$value['previousCount']}}</td>
                    <td>{{$value['currentCount']}}</td>
                    <td>{{$value['diff']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
