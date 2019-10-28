@extends('layouts.app')
@section('content')
    <div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
        <h1 class="text-2xl font-normal md-10 text-center">
            Create project
        </h1>
        <form
            method="post"
            action="/projects"
        >
            @include('projects.form', [
            'project' => new App\Project,
            'buttonText' => 'Create Project',
            ])
        </form>
    </div>
@endsection
