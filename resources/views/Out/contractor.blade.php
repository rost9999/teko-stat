@extends('layouts')
@section('content')
    <div class="container">
        <div class="row">
            <h1>{{$day}}</h1>
        </div>
        <div class="row">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Контрагент</th>
                    <th scope="col">Артикул</th>
                    <th scope="col">Торгова Марка</th>
                    <th scope="col">Назва</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $key => $values)
                    <tr>
                        <td nowrap><strong>{{$key}}</strong></td>
                    </tr>
                    @foreach($values as $value)
                        <tr>
                            <td nowrap>{{$value["shop"]}}</td>
                            <td nowrap>{{$value["article"]}}</td>
                            <td nowrap>{{$value["tm"]}}</td>
                            <td nowrap>{{$value["name"]}}</td>
                            <td nowrap>{{$value["days"]}} днів</td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

