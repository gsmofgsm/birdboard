@extends('layouts.app')
@section('content')
    <h1>Create a project</h1>
    <form
        method="POST"
        action="/projects"
        class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 rounded shadow"
    >
        @csrf

        <h1 class="text-2xl font-normal mb-10 text-center">
            Let's start something new
        </h1>

        <div class="field mb-6">

            <label class="label text-sm mb-2 block" for="title">Title</label>

            <div class="control">

                <input
                    type="text"
                    class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                    id="title"
                    name="title"
                    placeholder="Title"
                    value="">

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
                    value="">

            </div>

        </div>
        <div class="field">

            <div class="control flex">

                <button type="submit" class="button is-link mr-auto" id="create" name="create">Create</button>
                <a href="/projects">Cancel</a>

            </div>

        </div>
    </form>
@endsection