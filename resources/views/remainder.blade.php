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
    '1' => 'Січень',
    '2' => 'Лютий',
    '3' => 'Березень',
    '4' => 'Квітень',
    '5' => 'Травень',
    '6' => 'Червень',
    '7' => 'Липень',
    '8' => 'Серпень',
    '9' => 'Вересень',
    '10' => 'Жовтень',
    '11' => 'Листопад',
//    '12'=>'Грудень'
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
                <th scope="col">День</th>
                @foreach($data as $key => $d)
                    <th scope="col">{{$key}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Залишок</td>
                @foreach($data as $key => $d)
                    <td>{{$d}}</td>
                @endforeach
            </tr>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
