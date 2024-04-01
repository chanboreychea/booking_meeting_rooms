<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <select name="" id="">
        <option value="">ប្រធានអង្គភាព</option>
        <option value="">អនុប្រធានអង្គភាព</option>
        @foreach ($departments as $key => $offices)
            <option value="">ប្រធាននាយកដ្ឋាន {{ $key }}</option>
            @foreach ($offices as $item)
                <option value="">ប្រធានការិយាល័យ {{ $item }}</option><br>
            @endforeach
        @endforeach
    </select>
</body>

</html>
