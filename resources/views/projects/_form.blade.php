 @csrf

<div class="field mb-6">

    <label class="label text-sm mb-2 block" for="title">Title</label>

    <div class="control">

        <input
                type="text"
                class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                id="title"
                name="title"
                placeholder="Title"
                value="{{ $project->title }}">

    </div>

</div>

<div class="field mb-6">

    <label class="label text-sm mb-2 block" for="description">Description</label>

    <div class="control">

        <input
                type="text"
                class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                id="description"
                name="description"
                placeholder="description"
                value="{{ $project->description }}">

    </div>

</div>
<div class="field">

    <div class="control flex">

        <button type="submit" class="button is-link mr-auto" id="create" name="create">{{ $buttonText }}</button>
        <a href="{{ $project->path() }}">Cancel</a>

    </div>

</div>