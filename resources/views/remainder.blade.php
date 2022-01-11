@extends('layouts')
@section('content')
<?php
$links = [
    'date'  => 'День',
    'name'  => 'Назва',
    'count' => 'Залишок'
]
?>
<div class="container">
    <div class="row">
        <h1><a href="/">Теко-Трейд 2021 рік</a></h1>
        <h2><a href="{{back()->getTargetUrl()}}">Назад</a></h2>
    </div>
    <div class="row">
        <table class="table table-bordered">
            <thead>
            <tr>
                @foreach($data[0] as $key => $value)
                    <th scope="col">{{$links[$key]}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($data as $key => $d)
                <tr>
                    <td>{{$d['date']}}</td>
                    <td>{{$d['count']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
