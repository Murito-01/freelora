<x-app-layout>
    <div class="max-w-5xl mx-auto py-8">

        <h2 class="text-2xl font-bold mb-6">
            Dashboard
        </h2>

        <!-- STATS GRID -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">

            <div class="bg-white shadow p-4 rounded text-center">
                <p class="text-sm text-gray-500">Clients</p>
                <p class="text-xl font-bold">{{ $clients }}</p>
            </div>

            <div class="bg-white shadow p-4 rounded text-center">
                <p class="text-sm text-gray-500">Projects</p>
                <p class="text-xl font-bold">{{ $projects }}</p>
            </div>

            <div class="bg-white shadow p-4 rounded text-center">
                <p class="text-sm text-gray-500">Tasks</p>
                <p class="text-xl font-bold">{{ $totalTasks }}</p>
            </div>

            <div class="bg-white shadow p-4 rounded text-center">
                <p class="text-sm text-gray-500">Completed</p>
                <p class="text-xl font-bold text-green-600">
                    {{ $completedTasks }}
                </p>
            </div>

            <div class="bg-white shadow p-4 rounded text-center">
                <p class="text-sm text-gray-500">Overdue</p>
                <p class="text-xl font-bold text-red-600">
                    {{ $overdueTasks }}
                </p>
            </div>

        </div>

        <!-- PROGRESS BAR -->
        @php
            $progress = $totalTasks > 0
                ? round(($completedTasks / $totalTasks) * 100)
                : 0;
        @endphp

        <div class="bg-white shadow p-4 rounded">
            <p class="text-sm text-gray-500 mb-2">Task Progress</p>

            <div class="w-full bg-gray-200 rounded h-3">
                <div class="bg-blue-500 h-3 rounded"
                    style="width: {{ $progress }}%"></div>
            </div>

            <p class="text-sm mt-2">
                {{ $progress }}% completed
            </p>
        </div>

        <div class="bg-white shadow p-6 rounded mt-8">
            <h3 class="text-lg font-semibold mb-4">Task Distribution</h3>

            <canvas id="taskChart" height="100"></canvas>
        </div>

        <div class="grid grid-cols-3 gap-4 mt-6">

            <div class="bg-gray-100 p-4 rounded text-center">
                <p class="text-sm text-gray-500">Todo</p>
                <p class="text-xl font-bold">{{ $todoCount }}</p>
            </div>

            <div class="bg-yellow-100 p-4 rounded text-center">
                <p class="text-sm text-gray-500">In Progress</p>
                <p class="text-xl font-bold">{{ $inProgressCount }}</p>
            </div>

            <div class="bg-green-100 p-4 rounded text-center">
                <p class="text-sm text-gray-500">Done</p>
                <p class="text-xl font-bold">{{ $doneCount }}</p>
            </div>

        </div>

        <div class="mt-8">
            <h3 class="text-lg font-semibold mb-3">Recent Tasks</h3>

            <div class="space-y-2">
                @forelse($recentTasks as $task)
                    <div class="flex justify-between items-center border p-3 rounded">

                        <div>
                            <p class="font-medium">{{ $task->title }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $task->project->name }}
                        </p>
                    </div>

                    <span class="text-xs px-2 py-1 rounded
                        @if($task->status == 'done') bg-green-200
                        @elseif($task->status == 'in_progress') bg-yellow-200
                        @else bg-gray-200
                        @endif
                    ">
                        {{ $task->status }}
                    </span>

                </div>
            @empty
                <p class="text-gray-500 text-sm">No tasks yet</p>
            @endforelse
        </div>

        <div class="mt-8">
            <h3 class="text-lg font-semibold mb-3 text-red-500">
                ⚠️ Overdue Tasks
            </h3>

            <div class="space-y-2">
                @forelse($overdueList as $task)
                    <div class="border p-3 rounded bg-red-50">

                        <p class="font-medium">{{ $task->title }}</p>

                        <p class="text-xs text-gray-500">
                            {{ $task->project->name }}
                        </p>

                        <p class="text-xs text-red-500">
                            Due: {{ $task->deadline->format('d M Y') }}
                        </p>

                    </div>
                @empty
                    <p class="text-gray-500 text-sm">No overdue tasks 🎉</p>
                @endforelse
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('taskChart');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Todo', 'In Progress', 'Done'],
                datasets: [{
                    data: [
                        {{ $todoCount }},
                        {{ $inProgressCount }},
                        {{ $doneCount }}
                    ],
                    backgroundColor: [
                        '#9CA3AF',   // gray
                        '#FACC15',   // yellow
                        '#22C55E'    // green
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

    <div class="mt-10">
        <h3 class="text-lg font-semibold mb-4">Activity</h3>

        <div class="space-y-3">
            @forelse($activities as $task)
                <div class="flex items-start gap-3 border-l-4 pl-3
                    @if($task->status === 'done') border-green-500
                    @elseif($task->status === 'in_progress') border-yellow-500
                    @else border-gray-400
                    @endif
                ">

                    <div>
                        <p class="text-sm">
                            <span class="font-medium">{{ $task->title }}</span>

                            @if($task->status === 'done')
                                was completed
                            @elseif($task->status === 'in_progress')
                                is in progress
                            @else
                                was created
                            @endif
                        </p>

                        <p class="text-xs text-gray-500">
                            {{ $task->project->name }} •
                            {{ $task->updated_at->diffForHumans() }}
                        </p>
                    </div>

                </div>
            @empty
                <p class="text-gray-500 text-sm">No activity yet</p>
            @endforelse
        </div>
    </div>
</x-app-layout>