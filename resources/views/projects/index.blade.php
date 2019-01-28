<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    @foreach($projects as $project)
        <div>{{ $project->title }}</div>
        <div>{{ $project->description }}</div>
    @endforeach
</body>
</html>