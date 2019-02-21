<div class="card" style="height: 200px;">
    <h3 class="font-normal text-xl py-4 border-l-4 border-blue-light -ml-5 mb-4 pl-4">
        <a href="{{ $project->path() }}" class="text-black no-underline">{{ $project->title }}</a>
    </h3>
    <div class="text-grey mb-4">{{ str_limit($project->description, 100) }}</div>
    <footer>
        <form action="{{ $project->path() }}" method="POST" class="text-right">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-xs">Delete</button>
        </form>
    </footer>
</div>