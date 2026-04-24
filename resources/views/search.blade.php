<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">

        <h2 class="text-2xl font-bold mb-6">
            Search Results for "{{ $q }}"
        </h2>

        <!-- CLIENTS -->
        <div class="mb-6">
            <h3 class="font-semibold mb-2">Clients</h3>

            @forelse($clients as $client)
                <p class="text-sm">{{ $client->name }}</p>
            @empty
                <p class="text-gray-400 text-sm">No clients found</p>
            @endforelse
        </div>

        <!-- PROJECTS -->
        <div class="mb-6">
            <h3 class="font-semibold mb-2">Projects</h3>

            @forelse($projects as $project)
                <p class="text-sm">{{ $project->name }}</p>
            @empty
                <p class="text-gray-400 text-sm">No projects found</p>
            @endforelse
        </div>

        <!-- TASKS -->
        <div>
            <h3 class="font-semibold mb-2">Tasks</h3>

            @forelse($tasks as $task)
                <p class="text-sm">
                    {{ $task->title }}
                    <span class="text-gray-400 text-xs">
                        ({{ $task->project->name }})
                    </span>
                </p>
            @empty
                <p class="text-gray-400 text-sm">No tasks found</p>
            @endforelse
        </div>

    </div>
</x-app-layout>