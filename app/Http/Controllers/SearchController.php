<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;

class SearchController extends Controller {
    public function index(Request $request) {
        $q = $request->input('q');
        $user = auth()->user();

        $clients = Client::where('user_id', $user->id)
            ->where('name', 'like', "%$q%")
            ->get();

        $projects = Project::whereHas('client', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('name', 'like', "%$q%")
            ->get();

        $tasks = Task::whereHas('project.client', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('title', 'like', "%$q%")
            ->get();

        return view('search', compact('q', 'clients', 'projects', 'tasks'));
    }

    public function live(Request $request) {
        $q = $request->input('q');
        $user = auth()->user();

        if (!$q) {
            return response()->json([]);
        }

        $tasks = \App\Models\Task::whereHas('project.client', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('title', 'like', "%$q%")
            ->take(5)
            ->get();

        return response()->json($tasks);
    }  
}