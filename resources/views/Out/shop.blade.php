@extends('layouts')
@section('content')
    <div class="container">
        <div class="row">
            <h1>Теко-Трейд 2021 рік</h1>
        </div>
        <div class="row">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Контрагент</th>
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
                            <td nowrap>{{$value["fields"]["contractor"]}}</td>
                            <td nowrap>{{$value["fields"]["tm"]}}</td>
                            <td nowrap>{{$value["fields"]["name"]}}</td>
                            <td nowrap>{{$value["days"]}} днів</td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

