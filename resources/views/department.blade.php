<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @foreach ($departments as $key => $offices)
        <h4>{{ $key }}</h4>
        @foreach ($offices as $item)
            <div>{{ $item }}</div><br>
        @endforeach
    @endforeach
</body>

</html>
