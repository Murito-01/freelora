<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;

class DashboardController extends Controller {

    public function index() {
        $user = auth()->user();

        $clients = Client::where('user_id', $user->id)->count();

        $projects = Project::whereHas('client', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();

        $taskQuery = Task::whereHas('project.client', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        });

        $totalTasks = (clone $taskQuery)->count();

        $completedTasks = (clone $taskQuery)
            ->where('status', 'done')
            ->count();
        
        $overdueTasks = (clone $taskQuery)
            ->whereNotNull('deadline')
            ->where('deadline', '<', now())
            ->where('status', '!=', 'done')
            ->count();

        $progress = $totalTasks > 0
            ? round(($completedTasks / $totalTasks) * 100)
            : 0;

        return view('dashboard', compact(
            'clients',
            'projects',
            'totalTasks',
            'completedTasks',
            'overdueTasks',
            'progress'
        ));
    }
}
