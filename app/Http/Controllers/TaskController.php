<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller {
    public function updateStatus(Request $request, Task $task) {
        $task->update([
            'status' => $request->status
        ]);

        return back();
    }
}