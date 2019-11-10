@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-default text-sm font-normal">
                <a href="/projects" class="text-muted text-sm font-normal no-underline">My projects</a>
                <span class="text-muted">/ {{ $project->title }}</span>
            </p>

            <div class="flex items-center">
                @foreach($project->members as $member)
                    <img
                        src="{{ gravatar_url($member->email) }}}?s=60"
                        alt="{{ $member->name }}'s avatar"
                        class="rounded-full w-8 mr-2"
                    />
                @endforeach
                <img
                    src="{{ gravatar_url($project->owner->email) }}?s=60"
                    alt="{{ $project->owner->name }}'s avatar"
                    class="rounded-full w-8 mr-2"
                />

                <a href="{{ $project->path() . '/edit' }}" class="button ml-6">Edit project</a>
            </div>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-muted font-normal text-lg mb-3">Tasks</h2>
                    @foreach($project->tasks as $task)
                        <div class="card mb-3">
                            <form method="POST" action="{{ $task->path() }}">
                                @method('PATCH')
                                @csrf
                                <div class="flex">
                                    <input name="body" value="{{ $task->body }}" class="bg-card text-default w-full {{ $task->completed ? 'text-muted line-through' : '' }}" />
                                    <input name="completed" type="checkbox" onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }} />
                                </div>
                            </form>

                        </div>
                    @endforeach
                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="POST">
                            @csrf
                            <input placeholder="Add new task..." class="bg-card text-default w-full" name="body" />
                        </form>
                    </div>
                </div>
                <div>
                    <h2 class="text-muted font-normal text-lg mb-3">General notes</h2>
                    <form method="POST" action="{{ $project->path() }}">
                        @method('PATCH')
                        @csrf
                        <textarea
                            class="card w-full mb-4 text-md text-muted"
                            name="notes"
                            style="min-height: 200px"
                            placeholder="Write anything..."
                        >{{ $project->notes }}</textarea>

                        <button type="submit" class="button bg-button">Update</button>
                    </form>
                    <dropdown>
                        <template v-slot:trigger>
                            <a href="#">click me</a>
                        </template>

                        <a href="#" class="block text-default no-underline hover:underline text-sm leading-loose px-4">item 1</a>
                        <a href="#" class="block text-default no-underline hover:underline text-sm leading-loose px-4">item 1</a>
                        <a href="#" class="block text-default no-underline hover:underline text-sm leading-loose px-4">item 1</a>
                    </dropdown>
                    @include('errors')

                </div>
            </div>

            <div class="lg:w-1/4 px-3 lg:py-8">
                @include('projects.card')
                @include('projects.activity.card')
                @can('manage', $project)
                    @include('projects.invite')
                @endcan

            </div>
        </div>
    </main>

@endsection
