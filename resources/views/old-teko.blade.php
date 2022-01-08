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
<div class="container">
    <div class="row">
        <h1><a href="/">Теко-Трейд 2021 рік</a></h1>
        <h2><a href="{{back()->getTargetUrl()}}">Назад</a></h2>
    </div>
    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <?php $colons = array_keys(get_object_vars($data[0])) ?>
                <th scope="col">#</th>
                @foreach($colons as $colon)
                    <th scope="col">{{$colon}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            <?php  $id = 1; ?>
            @foreach($data as $row)
                <tr>
                    <?php $row = json_decode(json_encode($row), true); ?>
                    <th scope="row">{{$id}}</th>
                    <?php $link = str_replace(' ', '+', $row[$colons[0]]);
                    if (isset($colons[2])) {
                        $link = $row[$colons[2]];
                    }
                    ?>
                    <td><a href={{$GLOBALS["_SERVER"]["REQUEST_URI"].'/'.$link}}>{{$row[$colons[0]]}}</a></td>
                    <td>{{$row[$colons[1]]}}</td>
                    <?php  $id += 1; ?>

<!--                --><?php //xdebug_break(); ?>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
