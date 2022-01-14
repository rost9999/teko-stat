@extends('layouts')
@section('content')
<?php
$months = [
//    '1'=>'Січень',
    '2'=>'Лютий',
    '3'=>'Березень',
    '4'=>'Квітень',
    '5'=>'Травень',
    '6'=>'Червень',
    '7'=>'Липень',
    '8'=>'Серпень',
    '9'=>'Вересень',
    '10'=>'Жовтень',
    '11'=>'Листопад',
    '12'=>'Грудень'
]
    ?>
<div class="container">
    <div class="row">
        <h1>Теко-Трейд 2021 рік</h1>
    </div>
    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Місяць</th>
            </tr>
            </thead>
            <tbody>
            @foreach($months as $key => $months)
                <tr>
                    <th scope="row">{{$key}}</th>
                    <td><a href={{$key}}/>{{$months}}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

