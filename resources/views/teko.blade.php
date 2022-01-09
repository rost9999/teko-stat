<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teko</title>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
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
                <h3 style="display: inline;">{{$month}} {{$month}}</h3>
        <h2><a href="{{back()->getTargetUrl()}}">Назад</a></h2>
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
</body>
</html>
