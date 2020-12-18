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
<h1> Provide post changes </h1><br>
<h3>Dear {{$authorName}} {{$authorSurname}},</h3>
<br>
<p>Please provide following changes to post: post id: {{$postId}}, post header: {{$header}}
<ol>
    <?php foreach($changes as $single_change): ?>
    <li><?php echo $single_change; ?></li>
    <?php endforeach; ?>
</ol>
</p>

<p>Thanks in advance.</p><br>

<h5>Sincerly yours,</h5>
<h5>{{$adminName}}, {{$adminSurname}}</h5>
</body>
</html>
