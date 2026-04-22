<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Task;
use App\Models\Project;

class ProjectController extends Controller {
    use AuthorizesRequests;

    public function show(Project $project) {
        $this->authorize('view', $project);

        return view('projects.show', compact('project'));
    }

    public function updateStatus(Project $project) {
        $this->authorize('update', $project);

        $project->update([
            'status' => $project->status === 'active' ? 'completed' : 'active'
        ]);

        return back();
    }

    public function storeTask(Request $request, Project $project) {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $project->tasks()->create([
            'title' => $request->title,
        ]);

        return back();
    }

    public function toggleTask(Task $task) {
        $task->update([
            'is_completed' => !$task->is_completed
        ]);

        return back();
    }
}
