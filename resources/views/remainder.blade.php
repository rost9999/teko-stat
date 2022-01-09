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

</body>
</html>
