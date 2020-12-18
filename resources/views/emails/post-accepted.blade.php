<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1> Post accepted </h1><br>
<h3>Dear {{$authorName}} {{$authorSurname}},</h3>
<br>
<p>Your post: post id: {{$postId}}, post header: {{$header}} has been published. </p>

<h5>Sincerly yours,</h5>

<h5>{{$adminName}}, {{$adminSurname}}</h5>
</body>
</html>
