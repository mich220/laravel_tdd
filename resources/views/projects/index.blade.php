<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <h1>tddApp</h1>
    <ul>
        @foreach($projects as $project)
            {{$project->title}}
        @endforeach
    </ul>
</body>
</html>
