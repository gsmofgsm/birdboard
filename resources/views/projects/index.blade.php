<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<ul>
    @forelse($projects as $project)
        <li>
            <a href="{{ $project->path() }}">{{ $project->title }}</a>
        </li>
    @empty
        <li>No project yet.</li>
    @endforelse
</ul>
</body>
</html>