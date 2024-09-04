<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h4>Your pending books list</h4>
@foreach ($borrow as $bor)
<p>{{$bor->books->title}}</p>
<p>{{$bor->id}}</p>
<p>{{$bor->due_date}}</p>
@endforeach
</body>
</html>
