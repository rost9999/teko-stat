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
{{--                    @foreach($data[0] as $key=>$value)--}}
{{--                        <th scope="col">{{$key}}</th>--}}
{{--                    @endforeach--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                @foreach($data as $values)--}}
{{--                    <tr>--}}
{{--                        @foreach($values as $key=>$value)--}}
{{--                            @php($link = str_replace(' ', '+', $value))--}}
{{--                            <td><a href=outStock/{{$link}}/>{{$value}}</a></td>--}}
{{--                        @endforeach--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
                </tbody>
            </table>
        </div>
    </div>
@endsection

