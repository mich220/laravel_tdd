@extends('layouts.app')

@section('content')
    <div style="display: flex; align-items: center">
        <h1 class="mr-auto">tddApp</h1>
        <a href="/projects">Back</a>
    </div>
    <ul>
        {{$project->title}}
        {{$project->description}}
    </ul>

@endsection
