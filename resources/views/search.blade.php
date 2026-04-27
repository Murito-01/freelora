<x-app-layout>
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-8">

    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white tracking-tight mb-2">
        Search Results
    </h1>
    <p class="text-sm text-gray-400 dark:text-gray-500 mb-8">
        Showing results for <span class="text-gray-700 dark:text-gray-300 font-medium">"{{ $q }}"</span>
    </p>

    <div class="space-y-6">

        <!-- Clients -->
        <div>
            <h2 class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">Clients</h2>
            @forelse($clients as $client)
                <div class="p-3 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg mb-2 text-sm text-gray-700 dark:text-gray-300">
                    {{ $client->name }}
                    @if($client->company) <span class="text-gray-400 dark:text-gray-500">· {{ $client->company }}</span> @endif
                </div>
            @empty
                <p class="text-sm text-gray-400 dark:text-gray-500">No clients found</p>
            @endforelse
        </div>

        <!-- Projects -->
        <div>
            <h2 class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">Projects</h2>
            @forelse($projects as $project)
                <a href="{{ route('projects.show', $project->id) }}"
                   class="block p-3 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg mb-2 text-sm text-indigo-600 dark:text-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    {{ $project->name }}
                </a>
            @empty
                <p class="text-sm text-gray-400 dark:text-gray-500">No projects found</p>
            @endforelse
        </div>

        <!-- Tasks -->
        <div>
            <h2 class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">Tasks</h2>
            @forelse($tasks as $task)
                <a href="{{ route('projects.show', $task->project_id) }}"
                   class="block p-3 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg mb-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <p class="text-sm text-gray-800 dark:text-gray-200">{{ $task->title }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $task->project->name }}</p>
                </a>
            @empty
                <p class="text-sm text-gray-400 dark:text-gray-500">No tasks found</p>
            @endforelse
        </div>

    </div>
</div>
</x-app-layout>