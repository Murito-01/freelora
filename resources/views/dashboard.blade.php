<x-app-layout>
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white tracking-tight">Dashboard</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Welcome back, {{ auth()->user()->name }} 👋</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">

        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 hover:shadow-md dark:hover:shadow-gray-900 transition">
            <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Clients</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $clients }}</p>
        </div>

        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 hover:shadow-md dark:hover:shadow-gray-900 transition">
            <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Projects</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $projects }}</p>
        </div>

        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 hover:shadow-md dark:hover:shadow-gray-900 transition">
            <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Tasks</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalTasks }}</p>
        </div>

        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 hover:shadow-md dark:hover:shadow-gray-900 transition">
            <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Completed</p>
            <p class="text-2xl font-bold text-emerald-500">{{ $completedTasks }}</p>
        </div>

        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 hover:shadow-md dark:hover:shadow-gray-900 transition">
            <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Overdue</p>
            <p class="text-2xl font-bold text-rose-500">{{ $overdueTasks }}</p>
        </div>

    </div>

    <!-- Invoice Stats + Progress Bar Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-8">

        <!-- Task Progress -->
        <div class="lg:col-span-1 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5">
            <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">Task Progress</p>
            <div class="flex items-end gap-2 mb-3">
                <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ $progress }}%</span>
                <span class="text-sm text-gray-400 dark:text-gray-500 mb-0.5">completed</span>
            </div>
            <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-2">
                <div class="h-2 rounded-full bg-indigo-500 transition-all duration-700"
                     style="width: {{ $progress }}%"></div>
            </div>
        </div>

        <!-- Paid Invoices -->
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5">
            <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Paid Invoices</p>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-emerald-500">{{ $paidInvoices }}</p>
            </div>
        </div>

        <!-- Unpaid Invoices -->
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5">
            <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Unpaid Invoices</p>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-amber-500">{{ $unpaidInvoices }}</p>
            </div>
        </div>

    </div>

    <!-- Task Distribution + Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-8">

        <!-- Chart -->
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5">
            <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-4">Task Distribution</p>
            <canvas id="taskChart" height="180"></canvas>
        </div>

        <!-- Breakdown -->
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5 flex flex-col justify-center gap-4">
            <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-800">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                    <span class="text-sm text-gray-600 dark:text-gray-300">Todo</span>
                </div>
                <span class="font-semibold text-gray-900 dark:text-white">{{ $todoCount }}</span>
            </div>
            <div class="flex items-center justify-between p-3 rounded-lg bg-amber-50 dark:bg-amber-900/20">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                    <span class="text-sm text-gray-600 dark:text-gray-300">In Progress</span>
                </div>
                <span class="font-semibold text-gray-900 dark:text-white">{{ $inProgressCount }}</span>
            </div>
            <div class="flex items-center justify-between p-3 rounded-lg bg-emerald-50 dark:bg-emerald-900/20">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span class="text-sm text-gray-600 dark:text-gray-300">Done</span>
                </div>
                <span class="font-semibold text-gray-900 dark:text-white">{{ $doneCount }}</span>
            </div>
        </div>

        <!-- Recent Tasks -->
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5">
            <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-4">Recent Tasks</p>
            <div class="space-y-3">
                @forelse($recentTasks as $task)
                    <div class="flex items-center justify-between">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate">{{ $task->title }}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 truncate">{{ $task->project->name }}</p>
                        </div>
                        <span class="ml-2 shrink-0 text-xs px-2 py-0.5 rounded-full font-medium
                            @if($task->status == 'done') bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400
                            @elseif($task->status == 'in_progress') bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400
                            @else bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400
                            @endif">
                            {{ $task->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 dark:text-gray-500">No tasks yet</p>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Overdue + Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        <!-- Overdue Tasks -->
        <div class="bg-white dark:bg-gray-900 border border-rose-200 dark:border-rose-900/50 rounded-xl p-5">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-xs font-medium text-rose-500 uppercase tracking-wider">Overdue Tasks</p>
            </div>
            <div class="space-y-3">
                @forelse($overdueList as $task)
                    <div class="p-3 rounded-lg bg-rose-50 dark:bg-rose-900/20 border border-rose-100 dark:border-rose-900/40">
                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $task->title }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            <p class="text-xs text-gray-400 dark:text-gray-500">{{ $task->project->name }}</p>
                            <span class="text-xs text-rose-500">· Due {{ $task->deadline->format('d M Y') }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 dark:text-gray-500">No overdue tasks 🎉</p>
                @endforelse
            </div>
        </div>

        <!-- Activity Feed -->
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5">
            <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-4">Activity</p>
            <div class="space-y-3">
                @forelse($activities as $task)
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 w-1.5 h-1.5 rounded-full shrink-0
                            @if($task->status === 'done') bg-emerald-400
                            @elseif($task->status === 'in_progress') bg-amber-400
                            @else bg-gray-300 dark:bg-gray-600
                            @endif"></div>
                        <div class="min-w-0">
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                <span class="font-medium">{{ $task->title }}</span>
                                @if($task->status === 'done') <span class="text-gray-400"> was completed</span>
                                @elseif($task->status === 'in_progress') <span class="text-gray-400"> is in progress</span>
                                @else <span class="text-gray-400"> was created</span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $task->project->name }} · {{ $task->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 dark:text-gray-500">No activity yet</p>
                @endforelse
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const isDark = document.documentElement.classList.contains('dark');
    const ctx = document.getElementById('taskChart');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Todo', 'In Progress', 'Done'],
            datasets: [{
                data: [{{ $todoCount }}, {{ $inProgressCount }}, {{ $doneCount }}],
                backgroundColor: ['#9CA3AF', '#F59E0B', '#10B981'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            cutout: '72%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 16,
                        font: { size: 11, family: 'Inter' },
                        color: isDark ? '#9CA3AF' : '#6B7280',
                        usePointStyle: true,
                        pointStyleWidth: 8
                    }
                }
            }
        }
    });
</script>
</x-app-layout>