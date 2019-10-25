<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use function Sodium\compare;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects()->get();

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => '',
        ]);

        $project = auth()->user()->projects()->create($attributes);

        return redirect($project->path());
    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);

        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'min:3',
        ]);

        $project->update($attributes);

        return redirect($project->path());
    }
}
