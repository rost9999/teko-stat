@extends('layouts')
@section('content')
<div class="container">
    <div class="row">
        <h1>Теко-Трейд 2021 рік</h1>
    </div>
    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Дата</th>
                <th scope="col">Артикул</th>
                <th scope="col">ТМ</th>
                <th scope="col">Назва</th>
                <th scope="col">Ціна зливу</th>
                <th scope="col">Контрагент</th>
                <th scope="col">Ціна Контрагента</th>
            </tr>
            </thead>
            <tbody>
            @foreach($ndata as $d)
                <tr>
                    <td>{{$d->date}}</td>
                    <td>{{$d->article}}</td>
                    <td>{{$d->tm}}</td>
                    <td>{{$d->name}}</td>
                    <td>{{$d->price}}</td>
                    <td>{{$d->contractor}}</td>
                    <td>{{$d->price2}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

