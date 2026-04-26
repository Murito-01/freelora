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
    
        $status = request('status');
    
        $tasks = $project->tasks()
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->get();
    
        return view('projects.show', compact('project', 'tasks'));
    }

    public function updateStatus(Project $project) {
        $this->authorize('update', $project);

        $project->update([
            'status' => $project->status === 'active' ? 'completed' : 'active'
        ]);

        return back();
    }

    public function store(Request $request, $clientId) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        \App\Models\Project::create([
            'name' => $request->name,
            'client_id' => $clientId,
        ]);

        return back();
    }

    public function storeTask(Request $request, Project $project) {
        $request->validate([
            'title' => 'required|string|max:255',
            'deadline' => 'nullable|date'
        ]);
    
        $project->tasks()->create([
            'title' => $request->title,
            'deadline' => $request->deadline,
            'status' => 'todo',
        ]);
    
        return back();
    }

    public function toggle(Task $task) {
        $task->update([
            'status' => $task->status === 'done' ? 'todo' : 'done'
        ]);
    
        return back();
    }

    public function updateTask(Request $request, Task $task) {
        $task->update([
            'status' => $request->status
        ]);

        return back();
    }
}
