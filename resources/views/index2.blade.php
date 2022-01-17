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
                @foreach($data[0] as $key)
                    <th scope="col">{{$key}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($data as $key->$value)
                <tr>
                    <td>{{$key , $value}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

