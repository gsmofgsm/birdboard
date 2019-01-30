<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.css">
</head>
<body>
<h1>Create a project</h1>
<form method="POST" action="/projects">
    @csrf
    <div class="field">

        <label class="label" for="title">Title</label>

        <div class="control">

            <input type="text" class="input" id="title" name="title" placeholder="Title" value="">

        </div>

    </div>

    <div class="field">

        <label class="label" for="description">Description</label>

        <div class="control">

            <input type="text" class="input" id="description" name="description" placeholder="description" value="">

        </div>

    </div>
    <div class="field">

        <div class="control">

            <button type="submit" class="button is-link" id="create" name="create">Create</button>

        </div>

    </div>
</form>

</body>
</html>